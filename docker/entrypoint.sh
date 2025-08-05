#!/bin/sh

if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing Composer"
    composer install --no-interaction --no-progress
else
    composer dump-autoload
    composer update --no-interaction --no-progress
fi

# if the directory was created by the docker image, then remove it
# the system will copy .env.example later on.
if [ -d ".env" ]; then
    rm .env
fi


if [ ! -f "/logs" ]; then
    mkdir /logs
fi


if [ ! -f ".env" ] ||  ! grep -q . ".env" ; then
    cp .env.example .env
    php artisan key:generate --force
fi

php artisan storage:link

php artisan key:generate

printenv > /etc/environment

npm install

npm run build

php artisan migrate --force --seed

php artisan optimize:clear

php artisan optimize

php artisan octane:install --server=frankenphp

supervisord -c  /etc/supervisor/conf.d/supervisord.conf

