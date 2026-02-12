#!/bin/sh
set -e
cd /var/www/html
# Create .env from .env.example if missing (e.g. in Docker .env is not in the image)
if [ ! -f .env ]; then
    cp .env.example .env
fi
# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    php artisan key:generate --no-interaction --force
fi
# Create SQLite database file if missing and run migrations
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi
php artisan migrate --force --no-interaction 2>/dev/null || true
exec "$@"
