#!/usr/bin/env bash
set -euo pipefail

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

PORT="$(ask_port "${1:-}")"
validate_port "$PORT"

log_info "Building Docker image and starting container on port $PORT..."
run_compose "$PORT" up -d --build --remove-orphans
log_success "Build finished and app is running at http://localhost:${PORT}"
