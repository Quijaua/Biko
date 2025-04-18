    #!/bin/sh
    echo "Starting services..."
    service php8.2-fpm start
    service mysql start
    if test -f /var/www/html/fresh_install; then
        mysql -u root < /var/www/html/database/scripts/create_user_and_database.sql
        cd /var/www/html
        php artisan migrate
        php artisan db:seed
        rm /var/www/html/fresh_install
    fi
    nginx -g "daemon off;" &
    echo "Ready!"
    echo "http://localhost:8000"
    echo "Default username: admin@biko.edu"
    echo "Default password: admin@biko.edu"
    tail -s 1 /var/log/nginx/*.log -f
    exit