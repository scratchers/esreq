#!/bin/bash

set -e

php artisan down

php artisan clear-compiled
composer install --no-dev
php artisan optimize

php artisan key:generate

php artisan cache:clear
php artisan route:cache
php artisan config:cache

php artisan migrate

php artisan up

php artisan opcache:clear
