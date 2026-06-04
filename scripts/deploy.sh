#!/usr/bin/env bash
set -euo pipefail

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

DEPLOY_USER="${DEPLOY_USER:-hris-vps}"
DEPLOY_HOST="${DEPLOY_HOST:-103.134.154.143}"
DEPLOY_PORT="${DEPLOY_PORT:-22}"
DEPLOY_PATH="${DEPLOY_PATH:-/var/www/vending-landing-page}"
REMOTE_COMPOSE_PROJECT="${REMOTE_COMPOSE_PROJECT:-vending-landing-page}"
REMOTE_APP_SERVICE="${REMOTE_APP_SERVICE:-app}"
APP_PORT="${APP_PORT:-8001}"
PHP_OPCACHE_ENABLE="${PHP_OPCACHE_ENABLE:-1}"
DEPLOY_DOMAIN="${DEPLOY_DOMAIN:-vending.paci.co.id}"
CONFIGURE_NGINX="${CONFIGURE_NGINX:-1}"
RUN_MIGRATIONS="${RUN_MIGRATIONS:-0}"
RUN_SEEDERS="${RUN_SEEDERS:-}"

SSH_TARGET="${DEPLOY_USER}@${DEPLOY_HOST}"
SSH_CONTROL_PATH="${SSH_CONTROL_PATH:-/tmp/vending-deploy-${DEPLOY_USER}@${DEPLOY_HOST}:${DEPLOY_PORT}}"
SSH_OPTS=(
    -p "$DEPLOY_PORT"
    -o ServerAliveInterval=30
    -o ServerAliveCountMax=6
    -o ControlMaster=auto
    -o ControlPath="$SSH_CONTROL_PATH"
    -o ControlPersist=10m
)
RSYNC_SSH="ssh ${SSH_OPTS[*]}"

require_command() {
    if ! command -v "$1" >/dev/null 2>&1; then
        log_error "Required command not found: $1"
        exit 1
    fi
}

remote() {
    ssh "${SSH_OPTS[@]}" "$SSH_TARGET" "$@"
}

ask_yes_no() {
    local prompt="$1"
    local default="${2:-no}"
    local answer
    local suffix

    case "$default" in
        yes) suffix="[Y/n]" ;;
        no) suffix="[y/N]" ;;
        *)
            log_error "Invalid yes/no default: $default"
            exit 1
            ;;
    esac

    while true; do
        read -r -p "$prompt $suffix: " answer
        answer="${answer:-$default}"
        case "$answer" in
            y|Y|yes|YES|Yes) printf '1'; return ;;
            n|N|no|NO|No) printf '0'; return ;;
            *) log_warn "Please answer yes or no." ;;
        esac
    done
}

log_info "Preparing local build..."
require_command ssh
require_command rsync
require_command npm

if [[ -z "$RUN_SEEDERS" ]]; then
    RUN_SEEDERS="$(ask_yes_no "Run database seeder?" "no")"
fi

if [[ "$RUN_SEEDERS" != "0" && "$RUN_SEEDERS" != "1" ]]; then
    log_error "RUN_SEEDERS must be 0 or 1."
    exit 1
fi

log_info "Opening SSH connection to $SSH_TARGET. Enter the SSH password now if prompted."
remote true

log_info "Validating sudo access on VPS. Enter the sudo password now if prompted."
remote "sudo -v"

if [[ ! -d "$PROJECT_DIR/node_modules" ]]; then
    log_info "Installing npm dependencies..."
    (cd "$PROJECT_DIR" && npm install)
fi

(cd "$PROJECT_DIR" && npm run build)

log_info "Ensuring remote directory exists: $DEPLOY_PATH"
remote bash -s -- "$DEPLOY_PATH" <<'REMOTE_PREPARE'
set -euo pipefail

deploy_path="$1"
remote_user="$(id -un)"
remote_group="$(id -gn)"

sudo mkdir -p "$deploy_path"
sudo chown -R "$remote_user:$remote_group" "$deploy_path"
REMOTE_PREPARE

log_info "Uploading project to $SSH_TARGET:$DEPLOY_PATH"
rsync -az --delete \
    -e "$RSYNC_SSH" \
    --exclude='.git/' \
    --exclude='.env' \
    --exclude='node_modules/' \
    --exclude='vendor/' \
    --exclude='storage/app/private/*' \
    --exclude='storage/framework/cache/data/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/testing/*' \
    --exclude='storage/framework/views/*' \
    --exclude='storage/logs/*' \
    "$PROJECT_DIR/" "$SSH_TARGET:$DEPLOY_PATH/"

log_info "Running remote Laravel deployment commands..."
remote bash -s -- "$DEPLOY_PATH" "$REMOTE_COMPOSE_PROJECT" "$REMOTE_APP_SERVICE" "$APP_PORT" "$PHP_OPCACHE_ENABLE" "$RUN_MIGRATIONS" "$RUN_SEEDERS" "$CONFIGURE_NGINX" "$DEPLOY_DOMAIN" <<'REMOTE_SCRIPT'
set -euo pipefail

deploy_path="$1"
compose_project="$2"
app_service="$3"
app_port="$4"
php_opcache_enable="$5"
run_migrations="$6"
run_seeders="$7"
configure_nginx="$8"
deploy_domain="$9"
app_url="https://$deploy_domain"

run_app() {
    (cd "$deploy_path" && APP_PORT="$app_port" PHP_OPCACHE_ENABLE="$php_opcache_enable" docker compose -p "$compose_project" exec -T "$app_service" "$@")
}

run_app_once() {
    (cd "$deploy_path" && APP_PORT="$app_port" PHP_OPCACHE_ENABLE="$php_opcache_enable" docker compose -p "$compose_project" run --rm --no-deps "$app_service" "$@")
}

composer_install() {
    local composer_args=(
        install
        --no-dev
        --prefer-dist
        --optimize-autoloader
        --no-interaction
        --no-progress
    )

    run_app_once sh -lc 'rm -rf vendor/composer/tmp-* storage/tmp/composer-*'
    if run_app_once composer "${composer_args[@]}"; then
        return 0
    fi

    echo "Composer install failed. Clearing Composer cache and retrying once..."
    run_app_once composer clear-cache || true
    run_app_once sh -lc 'rm -rf vendor/composer/tmp-* storage/tmp/composer-*'
    run_app_once composer "${composer_args[@]}" --no-cache
}

mkdir -p \
    "$deploy_path/storage/app/public" \
    "$deploy_path/storage/composer-cache" \
    "$deploy_path/storage/framework/cache/data" \
    "$deploy_path/storage/framework/sessions" \
    "$deploy_path/storage/framework/testing" \
    "$deploy_path/storage/framework/views" \
    "$deploy_path/storage/logs" \
    "$deploy_path/bootstrap/cache"

if [[ ! -f "$deploy_path/.env" && -f "$deploy_path/.env.example" ]]; then
    cp "$deploy_path/.env.example" "$deploy_path/.env"
    echo "Created $deploy_path/.env from .env.example. Review production settings before exposing the app."
fi

set_env_value() {
    local key="$1"
    local value="$2"
    local env_file="$deploy_path/.env"

    if grep -q "^${key}=" "$env_file"; then
        sed -i "s|^${key}=.*|${key}=${value}|" "$env_file"
    else
        printf '%s=%s\n' "$key" "$value" >> "$env_file"
    fi
}

if [[ -f "$deploy_path/.env" ]]; then
    set_env_value APP_URL "$app_url"
    set_env_value ASSET_URL "$app_url"
    set_env_value APP_FORCE_HTTPS true
fi

cd "$deploy_path"
APP_PORT="$app_port" PHP_OPCACHE_ENABLE="$php_opcache_enable" docker compose -p "$compose_project" build "$app_service"

composer_install

run_app_once php artisan storage:link || true
run_app_once php artisan config:cache
run_app_once php artisan route:cache
run_app_once php artisan view:cache

if [[ "$run_migrations" == "1" ]]; then
    run_app_once php artisan migrate --force
fi

if [[ "$run_seeders" == "1" ]]; then
    run_app_once php artisan db:seed --force
fi

APP_PORT="$app_port" PHP_OPCACHE_ENABLE="$php_opcache_enable" docker compose -p "$compose_project" up -d --remove-orphans
run_app php artisan queue:restart || true

chmod -R ug+rwX "$deploy_path/storage" "$deploy_path/bootstrap/cache"

if [[ "$configure_nginx" == "1" ]]; then
    if ! command -v nginx >/dev/null 2>&1; then
        echo "Nginx is not installed on the VPS. Skipping sites-available setup."
        exit 0
    fi

    site_path="/etc/nginx/sites-available/$deploy_domain"
    sudo tee "$site_path" >/dev/null <<NGINX_SITE
server {
    listen 80;
    listen [::]:80;
    server_name $deploy_domain;

    client_max_body_size 64M;

    location / {
        proxy_pass http://127.0.0.1:$app_port;
        proxy_http_version 1.1;
        proxy_set_header Host \$host;
        proxy_set_header Real-IP \$remote_addr;
        proxy_set_header X-Real-IP \$remote_addr;
        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto \$scheme;
        proxy_set_header Upgrade \$http_upgrade;
        proxy_set_header Connection "upgrade";
    }
}
NGINX_SITE

    sudo ln -sf "$site_path" "/etc/nginx/sites-enabled/$deploy_domain"
    sudo nginx -t
    sudo systemctl reload nginx
fi
REMOTE_SCRIPT

log_success "Deploy finished: http://${DEPLOY_DOMAIN}"
