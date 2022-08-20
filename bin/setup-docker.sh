#!/bin/bash

docker -v >/dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "\"docker\" command not found."
    exit 1
fi

docker-compose -v >/dev/null 2>&1
if [ $? -ne 0 ]; then
    echo "\docker-compose\" command not found."
    exit 2
fi

if [ -e "$HOME/docker-Laravel_Forum-B" ]; then
    echo "\"$HOME/docker-Laravel_Forum-B\" already exists."
    exit 3
fi

if [ $(pwd) != "$HOME/Laravel_Forum-B" ]; then
    echo "\"setup-docker.sh\" should be run \"$HOME/Laravel_Forum-B\"."
    exit 4
fi

echo -n "Account name (no @ or below required): "
read account_name
read -sp "Application Password: " Application_pass
echo

cd ~
mkdir docker-Laravel_Forum-B
mv ./Laravel_Forum-B ./docker-Laravel_Forum-B/Laravel_Forum-B
cp -r ./docker-Laravel_Forum-B/Laravel_Forum-B/docker ./docker-Laravel_Forum-B

cd ~/docker-Laravel_Forum-B/Laravel_Forum-B
cp ./docker/.env.docker ./.env
sed -ie "s/<ACCOUNT_NAME>/$account_name/g" .env
sed -ie "s/<APP_PASSWORD>/$Application_pass/g" .env
mkdir storage/app/public/images
mkdir storage/app/public/images/thread_message
chmod -R 777 storage
chmod -R 777 bootstrap/cache
chmod -R 777 public/uploads

cd ~/docker-Laravel_Forum-B/docker
docker-compose up -d
docker-compose exec composer composer install
docker-compose exec node  npm install --update-binary --no-shrinkwrap
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan admin:install
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan admin:import helpers
docker-compose exec app php artisan storage:link

rm ~/docker-Laravel_Forum-B/Laravel_Forum-B/.enve

exit 0
