#!/usr/bin/env bash
php /var/www/snappfood/artisan key:generate

php /var/www/snappfood/artisan migrate:fresh --seed

php /var/www/snappfood/artisan config:cache --no-ansi -q
php /var/www/snappfood/artisan route:cache --no-ansi -q
php /var/www/snappfood/artisan view:cache --no-ansi -q


php /var/www/snappfood/artisan serve --host "0.0.0.0" --port 9000

