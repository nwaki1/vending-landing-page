#!/bin/sh

set -eu

APP_DIR="/var/www/html"

mkdir -p "$APP_DIR/storage/tmp"
mkdir -p "$APP_DIR/storage/framework/views"
mkdir -p "$APP_DIR/storage/framework/cache"
mkdir -p "$APP_DIR/storage/framework/sessions"
mkdir -p "$APP_DIR/bootstrap/cache"
mkdir -p "$APP_DIR/database"

chmod -R 777 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
chmod -R 777 "$APP_DIR/database"

if [ ! -f "$APP_DIR/database/database.sqlite" ]; then
    touch "$APP_DIR/database/database.sqlite"
fi

cd "$APP_DIR"

if [ ! -f ".env" ] && [ -f ".env.example" ]; then
    cp ".env.example" ".env"
fi

if [ ! -f "vendor/autoload.php" ]; then
    if command -v composer >/dev/null 2>&1; then
        composer install --no-interaction --prefer-dist --optimize-autoloader
    else
        echo "composer is not available, skipping dependency install" >&2
    fi
fi

if [ -f ".env" ] && ! grep -q '^APP_KEY=base64:' ".env"; then
    php artisan key:generate --force --ansi
fi

if [ -f "artisan" ] && [ -f "composer.json" ]; then
    if [ ! -f "database/database.sqlite" ] && grep -q '^DB_CONNECTION=sqlite$' ".env" 2>/dev/null; then
        touch "database/database.sqlite"
    fi

    php artisan migrate --force --no-interaction --ansi
fi
