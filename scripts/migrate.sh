#!/usr/bin/env bash
set -euo pipefail

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

SEED=0
FRESH=0

usage() {
    printf 'Usage: %s [--seed] [--fresh]\n' "$(basename "$0")"
    printf '\n'
    printf 'Options:\n'
    printf '  --seed   Jalankan seeder setelah migrate\n'
    printf '  --fresh  Drop semua tabel lalu migrate ulang (hati-hati!)\n'
    exit 1
}

# Parse flags
for arg in "$@"; do
    case "$arg" in
        --seed)  SEED=1 ;;
        --fresh) FRESH=1 ;;
        --help|-h) usage ;;
        *) log_error "Unknown flag: $arg"; usage ;;
    esac
done

# Pastikan container running
if ! compose ps --status running app 2>/dev/null | grep -q "app"; then
    log_error "Container 'app' tidak sedang berjalan."
    log_info  "Jalankan terlebih dahulu: scripts/run.sh atau scripts/build.sh"
    exit 1
fi

if [[ "$FRESH" -eq 1 ]]; then
    log_warn "Menjalankan migrate:fresh — semua data akan dihapus!"
    read -r -p "Yakin? [y/N]: " confirm
    if [[ ! "$confirm" =~ ^[Yy]$ ]]; then
        log_info "Dibatalkan"
        exit 0
    fi
    compose exec app php artisan migrate:fresh --force --ansi
else
    log_info "Menjalankan migration..."
    compose exec app php artisan migrate --force --ansi
fi

log_success "Migration selesai"

if [[ "$SEED" -eq 1 ]]; then
    log_info "Menjalankan seeder..."
    compose exec app php artisan db:seed --force --ansi
    log_success "Seeder selesai"
fi
