#!/bin/bash

# プロジェクトルートに移動
cd ${WORKDIR}

# .envファイルが存在しない場合
if [ ! -e "${WORKDIR}/.env" ]; then
    # .envファイルをプロジェクトルートに配置する
    cp ${WORKDIR}/.env.example ${WORKDIR}/.env
fi

# ディレクトリのパーミッションを変更し、laravelが書き込みできるようにする。
sudo chmod -R 777 ${WORKDIR}/storage
sudo chmod -R 777 ${WORKDIR}/bootstrap/cache

# 開発で使用するPHPやNodeのパッケージのインストール
composer install
npm install

# hira-chanを動作させるためのコマンドの実行
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

exit 0
