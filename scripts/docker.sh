#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

show_menu() {
    printf '%sDocker Menu%s\n' "$BOLD" "$RESET"
    printf '1) Run\n'
    printf '2) Build\n'
    printf '3) Stop\n'
    printf '4) Clean\n'
    printf '5) Database backup / restore\n'
    printf '6) Migrate & Seed\n'
    printf '7) Exit\n'
}

run_action() {
    local choice="${1:-}"
    local port

    case "$choice" in
        1|run)
            port="$(ask_port "${2:-}")"
            validate_port "$port"
            log_info "Starting Docker on port $port..."
            run_compose "$port" up -d --remove-orphans
            log_success "Docker is running at http://localhost:${port}"
            ;;
        2|build)
            port="$(ask_port "${2:-}")"
            validate_port "$port"
            log_info "Building Docker image and starting container on port $port..."
            run_compose "$port" up -d --build --remove-orphans
            log_success "Build finished and app is running at http://localhost:${port}"
            ;;
        3|stop)
            log_info "Stopping Docker containers..."
            compose stop
            log_success "Containers stopped"
            ;;
        4|clean)
            log_warn "Removing containers, network, and volumes..."
            compose down --remove-orphans --volumes --rmi local
            EXTRA_CONTAINERS="$(
                {
                    docker ps -aq --filter label=com.docker.compose.service=app
                } | sort -u || true
            )"
            if [[ -n "$EXTRA_CONTAINERS" ]]; then
                log_warn "Removing leftover app containers..."
                printf '%s\n' "$EXTRA_CONTAINERS" | xargs -r docker rm -f >/dev/null
            fi
            log_success "Clean complete"
            ;;
        5|database)
            log_info "Opening database backup / restore menu..."
            bash "$SCRIPT_DIR/database.sh"
            ;;
        6|migrate)
            log_info "Migrate & Seed menu"
            printf '1) Migrate saja\n'
            printf '2) Migrate + Seed\n'
            printf '3) Migrate fresh + Seed (HAPUS SEMUA DATA)\n'
            printf '4) Kembali\n'
            read -r -p "Choose [1-4]: " migrate_choice
            case "$migrate_choice" in
                1) bash "$SCRIPT_DIR/migrate.sh" ;;
                2) bash "$SCRIPT_DIR/migrate.sh" --seed ;;
                3) bash "$SCRIPT_DIR/migrate.sh" --fresh --seed ;;
                4) log_info "Kembali ke menu utama" ;;
                *) log_error "Pilihan tidak valid" ;;
            esac
            ;;
        7|exit|"")
            log_info "Bye"
            ;;
        *)
            log_error "Unknown option: $choice"
            return 1
            ;;
    esac
}

if [[ $# -gt 0 ]]; then
    run_action "$1" "${2:-}"
    exit 0
fi

show_menu
read -r -p "Choose [1-7]: " choice
run_action "$choice"
