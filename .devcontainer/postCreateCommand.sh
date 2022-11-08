#!/bin/bash

cp /usr/src/app/.env.example /usr/src/app/.env

mkdir storage/app/public/images
mkdir storage/app/public/images/thread_message
chmod -R 777 storage
chmod -R 777 bootstrap/cache
chmod -R 777 public/uploads

composer install
npm install --update-binary --no-shrinkwrap

sed -ie "s/DB_HOST=127.0.0.1/DB_HOST=hira-chan_mysql/g" /usr/src/app/.env
sed -ie "s/DB_DATABASE=/DB_DATABASE=forum/g" /usr/src/app/.env
sed -ie "s/DB_PASSWORD=/DB_PASSWORD=rootpass/g" /usr/src/app/.env

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

rm /usr/src/app/.enve

exit 0
