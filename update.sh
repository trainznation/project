#!/bin/sh

php artisan down
git checkout -f
git pull
composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist --ignore-platform-reqs --no-dev
php artisan key:generate
php artisan system:clear
php artisan migrate:fresh --seed

npm install
npm run production

php artisan up
