#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    composer install
fi

if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
fi

php artisan migrate --force

if [ ! -f node_modules/.bin/vite ]; then
    npm install
fi

if [ "$1" = "dev" ]; then
    # Build sekali agar public/build ada saat request pertama masuk,
    # lalu watch untuk rebuild otomatis saat file berubah.
    npx vite build

    exec npx concurrently -c "#93c5fd,#c4b5fd,#fb7185,#fdba74" \
        "php artisan serve --host=0.0.0.0 --port=8000" \
        "php artisan queue:listen --tries=1" \
        "php artisan pail --timeout=0" \
        "npx vite build --watch" \
        --names=server,queue,logs,vite-build --kill-others
fi

exec "$@"
