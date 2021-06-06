#!/bin/sh

php artisan down
git checkout -f
git pull
composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist --ignore-platform-reqs --no-dev
php artisan key:generate --no-interaction
chmod -R 777 storage/ bootstrap/
php artisan system:clear --no-interaction
php artisan migrate:fresh --seed --no-interaction

npm install --no-dev --no-interaction
npm run production

php artisan up
