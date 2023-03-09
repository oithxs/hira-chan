#!/bin/bash

# gitコマンドの補完
wget https://raw.githubusercontent.com/git/git/master/contrib/completion/git-completion.bash -O ~/.git-completion.bash
cat <<EOF >> ~/.bashrc

# git command completion
source $HOME/.git-completion.bash
EOF

# .envファイルをプロジェクトルートに配置する
cp /usr/src/app/.env.example /usr/src/app/.env

# スレッドにアップロードされた画像を格納するディレクトリの作成
mkdir storage/app/public
mkdir storage/app/public/images
mkdir storage/app/public/images/thread_message

# ディレクトリのパーミッションを変更し、laravelが書き込みできるようにする。
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# 開発で使用するPHPやNodeのパッケージのインストール
composer install
npm install

# hira-chanを動作させるために .env ファイルを修正する
sed -ie "s/DB_HOST=127.0.0.1/DB_HOST=hira-chan_mariadb/g" /usr/src/app/.env
sed -ie "s/DB_DATABASE=/DB_DATABASE=forum/g" /usr/src/app/.env
sed -ie "s/DB_PASSWORD=/DB_PASSWORD=rootpass/g" /usr/src/app/.env
sed -ie "s/MAIL_FROM_ADDRESS=null/MAIL_FROM_ADDRESS=hira-chan@example.com/g" /usr/src/app/.env

# hira-chanを動作させるためのコマンドの実行
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

# 環境ファイルコピー時に作成される不要ファイルの削除
rm /usr/src/app/.enve

exit 0
