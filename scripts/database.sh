#!/usr/bin/env bash
set -euo pipefail

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

ensure_backup_dir() {
    mkdir -p "$BACKUP_DIR"
}

backup_database() {
    local backup_name="${1:-}"

    ensure_backup_dir

    if [[ ! -f "$DATABASE_FILE" ]]; then
        log_error "Database file not found: $DATABASE_FILE"
        exit 1
    fi

    if [[ -z "$backup_name" ]]; then
        read -r -p "Backup name [$(date +%Y%m%d-%H%M%S)]: " backup_name
    fi

    backup_name="${backup_name:-$(date +%Y%m%d-%H%M%S)}"

    if [[ "$backup_name" != *.sqlite ]]; then
        backup_name="${backup_name}.sqlite"
    fi

    local destination="$BACKUP_DIR/$backup_name"

    cp "$DATABASE_FILE" "$destination"
    log_success "Backup saved to $destination"
}

restore_database() {
    local backups=()
    local backup_file

    ensure_backup_dir

    while IFS= read -r backup_file; do
        [[ -n "$backup_file" ]] && backups+=("$backup_file")
    done < <(
        find "$BACKUP_DIR" -maxdepth 1 -type f \( -name '*.sqlite' -o -name '*.db' \) | sort -r
    )

    if (( ${#backups[@]} == 0 )); then
        log_error "No backup files found in $BACKUP_DIR"
        exit 1
    fi

    printf '%sRestore Database%s\n' "$BOLD" "$RESET"
    printf 'Available backups:\n'

    local index=1
    for backup_file in "${backups[@]}"; do
        printf '%s) %s\n' "$index" "$(basename "$backup_file")"
        index=$((index + 1))
    done

    local choice=""
    local selected_backup=""

    while [[ -z "$selected_backup" ]]; do
        read -r -p "Select backup [1]: " choice
        choice="${choice:-1}"

        if ! [[ "$choice" =~ ^[0-9]+$ ]]; then
            log_warn "Please enter a valid number"
            continue
        fi

        if (( choice < 1 || choice > ${#backups[@]} )); then
            log_warn "Choice out of range"
            continue
        fi

        selected_backup="${backups[$((choice - 1))]}"
    done

    printf 'Selected: %s\n' "$(basename "$selected_backup")"
    read -r -p "This will overwrite the current database. Continue? [y/N]: " confirm

    if [[ ! "$confirm" =~ ^[Yy]$ ]]; then
        log_warn "Restore cancelled"
        exit 0
    fi

    log_info "Stopping Docker containers before restore..."
    (cd "$PROJECT_DIR" && docker compose stop >/dev/null 2>&1 || true)

    cp "$selected_backup" "$DATABASE_FILE"
    chmod 666 "$DATABASE_FILE" 2>/dev/null || true

    log_success "Restored database from $(basename "$selected_backup")"
    log_info "Run scripts/run.sh to start the app again"
}

show_menu() {
    printf '%sDatabase Backup & Restore%s\n' "$BOLD" "$RESET"
    printf '1) Backup database\n'
    printf '2) Restore database\n'
    printf '3) Exit\n'
}

main() {
    case "${1:-}" in
        backup)
            backup_database "${2:-}"
            ;;
        restore)
            restore_database
            ;;
        exit|"")
            show_menu
            read -r -p "Choose [1-3]: " choice
            case "$choice" in
                1)
                    backup_database
                    ;;
                2)
                    restore_database
                    ;;
                3|"")
                    log_info "Bye"
                    ;;
                *)
                    log_error "Unknown option: $choice"
                    exit 1
                    ;;
            esac
            ;;
        *)
            log_error "Unknown command: ${1:-}"
            printf 'Usage: %s [backup|restore]\n' "$(basename "$0")"
            exit 1
            ;;
    esac
}

main "$@"
