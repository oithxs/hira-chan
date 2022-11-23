#!/bin/bash

# git command completion
wget https://raw.githubusercontent.com/git/git/master/contrib/completion/git-completion.bash -O ~/.git-completion.bash
cat <<EOF >> ~/.bashrc

# git command completion
source $HOME/.git-completion.bash
EOF

# Place env file in project root
cp /usr/src/app/.env.example /usr/src/app/.env

# Creation of a directory to store images uploaded to the thread
mkdir storage/app/public
mkdir storage/app/public/images
mkdir storage/app/public/images/thread_message

# Change directory permissions to allow laravel to write
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Install PHP and Node packages used for development
composer install
npm install

# Modify env file to make database available
sed -ie "s/DB_HOST=127.0.0.1/DB_HOST=hira-chan_mariadb/g" /usr/src/app/.env
sed -ie "s/DB_DATABASE=/DB_DATABASE=forum/g" /usr/src/app/.env
sed -ie "s/DB_PASSWORD=/DB_PASSWORD=rootpass/g" /usr/src/app/.env

# Executing commands to run hira-chan
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

# Delete unnecessary files created when copying env files
rm /usr/src/app/.enve

exit 0
