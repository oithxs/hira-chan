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

if [ ! -e "$HOME/docker-Laravel_Forum-B/Laravel_Forum-B" ]; then
    echo "\"$HOME/docker-Laravel_Forum-B/Laravel_Forum-B\" does not exist."
    exit 3
fi

if [ ! -e "$HOME/docker-Laravel_Forum-B/docker" ]; then
    echo "\"$HOME/docker-Laravel_Forum-B/docker\" does not exist."
    exit 4
fi

if [ $(pwd) != "$HOME/docker-Laravel_Forum-B/Laravel_Forum-B" ]; then
    echo "\"stop-docker.sh\" should be run \"$HOME/docker-Laravel_Forum-B/Laravel_Forum-B\"."
    exit 5
fi

cd ~/docker-Laravel_Forum-B/docker
docker-compose start
docker-compose exec composer composer install
docker-compose exec composer npm install
docker-compose exec app php artisan migrate
docker-compose exec app db:seed

exit 0
