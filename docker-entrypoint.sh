#!/usr/bin/env bash

php /var/www/snappfood/artisan migrate
php /var/www/snappfood/artisan db:seed

php /var/www/snappfood/artisan config:cache --no-ansi -q
php /var/www/snappfood/artisan route:cache --no-ansi -q
php /var/www/snappfood/artisan view:cache --no-ansi -q

