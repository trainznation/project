#!/bin/sh

set -e

echo "Deploiment de l'application..."

(php artisan down --message "L'application est actuellement en maintenance !") || true

    git fetch origin deploy
    git reset --hard origin/deploy

    composer install --no-interaction --prefer-dist --optimize-autoloader

    php artisan migrate --force

    php artisan optimize

    echo "" | service php7.4-fpm reload

php artisan up

echo "Application déployer"
