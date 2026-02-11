#!/bin/sh
set -e
cd /var/www/html
# Generate APP_KEY if not set (e.g. when using only .env.example)
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    php artisan key:generate --no-interaction --force
fi
# Create SQLite database file if missing and run migrations
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi
php artisan migrate --force --no-interaction 2>/dev/null || true
exec "$@"
