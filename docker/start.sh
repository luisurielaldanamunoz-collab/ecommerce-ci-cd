#!/usr/bin/env sh
set -e

mkdir -p database storage/logs bootstrap/cache

if [ "${DB_CONNECTION}" = "sqlite" ]; then
  touch "${DB_DATABASE:-database/database.sqlite}"
fi

php artisan migrate --force
php artisan db:seed --force || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
