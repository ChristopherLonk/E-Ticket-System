#!/bin/bash
composer install

get_current_directory() {
    current_file="${PWD}/${0}"
    echo "${current_file%/*}"
}
ENV=$(get_current_directory)/.env

DB_PASSWORD=$(grep -e "DB_PASSWORD" "$ENV" | awk -F= '{print $2}')
DB_DATABASE=$(grep -e "DB_DATABASE" "$ENV" | awk -F= '{print $2}')
DB_USERNAME=$(grep -e "DB_USERNAME" "$ENV" | awk -F= '{print $2}')

echo "
CREATE DATABASE IF NOT EXISTS $DB_DATABASE;
CREATE USER IF NOT EXISTS '$DB_USERNAME'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_DATABASE.* TO '$DB_USERNAME'@'localhost';
FLUSH PRIVILEGES;
" > install.sql

sudo mysql < install.sql
rm install.sql

php artisan migrate:fresh
php artisan db:seed
vendor/bin/phpunit
vendor/bin/phpcs phpcs.xml
