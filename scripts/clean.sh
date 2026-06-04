#!/usr/bin/env bash
set -euo pipefail

source "$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)/lib.sh"

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
