#!/usr/bin/env bash
set -euo pipefail

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

PORT="$(ask_port "${1:-}")"
validate_port "$PORT"

log_info "Starting Docker on port $PORT..."
run_compose "$PORT" up -d --remove-orphans
log_success "Docker is running at http://localhost:${PORT}"
