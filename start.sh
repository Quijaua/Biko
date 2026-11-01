#!/bin/sh
echo "Starting services..."
service php8.3-fpm start
service mysql start

if test -f /var/www/html/fresh_install; then
    mysql -u root < /var/www/html/database/scripts/create_user_and_database.sql
    cd /var/www/html
    php artisan migrate --force
    php artisan db:seed --force
    rm /var/www/html/fresh_install
fi

nginx -g "daemon off;" &
echo "Ready!"
echo "http://localhost:8000"
echo "Default username: admin@biko.edu"
echo "Default password: admin@biko.edu"
tail -s 1 -f /var/log/nginx/*.log
