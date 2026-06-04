#!/usr/bin/env bash

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DEFAULT_PORT=8000
COMPOSE_PROJECT_NAME="laravel-app"
BACKUP_DIR="$PROJECT_DIR/backups/database"
DATABASE_FILE="$PROJECT_DIR/database/database.sqlite"

if [[ -t 1 ]]; then
    RED=$'\033[31m'
    GREEN=$'\033[32m'
    YELLOW=$'\033[33m'
    BLUE=$'\033[34m'
    BOLD=$'\033[1m'
    RESET=$'\033[0m'
else
    RED=""
    GREEN=""
    YELLOW=""
    BLUE=""
    BOLD=""
    RESET=""
fi

log_info() {
    printf '%s[INFO]%s %s\n' "$BLUE" "$RESET" "$*"
}

log_success() {
    printf '%s[SUCCESS]%s %s\n' "$GREEN" "$RESET" "$*"
}

log_warn() {
    printf '%s[WARN]%s %s\n' "$YELLOW" "$RESET" "$*"
}

log_error() {
    printf '%s[ERROR]%s %s\n' "$RED" "$RESET" "$*"
}

ask_port() {
    local port_input
    port_input="${1:-}"

    if [[ -z "$port_input" ]]; then
        read -r -p "Host port [${DEFAULT_PORT}]: " port_input
    fi

    printf '%s' "${port_input:-$DEFAULT_PORT}"
}

validate_port() {
    local port="$1"

    if ! [[ "$port" =~ ^[0-9]+$ ]]; then
        log_error "Invalid port: $port"
        return 1
    fi

    if (( port < 1 || port > 65535 )); then
        log_error "Port must be between 1 and 65535"
        return 1
    fi
}

run_compose() {
    (cd "$PROJECT_DIR" && APP_PORT="$1" docker compose -p "$COMPOSE_PROJECT_NAME" "${@:2}")
}

compose() {
    (cd "$PROJECT_DIR" && docker compose -p "$COMPOSE_PROJECT_NAME" "$@")
}
