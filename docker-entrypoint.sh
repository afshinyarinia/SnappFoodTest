#!/usr/bin/env bash

/usr/bin/php /var/www/zleitner/artisan migrate
/usr/bin/php /var/www/zleitner/artisan db:seed

/usr/bin/php /var/www/zleitner/artisan config:cache --no-ansi -q
/usr/bin/php /var/www/zleitner/artisan route:cache --no-ansi -q
/usr/bin/php /var/www/zleitner/artisan view:cache --no-ansi -q

if [[ $# -gt 0 ]]; then
    exec "$@"
else
    exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
fi
