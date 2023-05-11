#!/bin/bash

# 各種サービス起動
sudo su <<EOF
service postfix start
service nginx start
service php8.1-fpm start
EOF

# 使用できないセッションの削除
screen -wipe

# セッションの作成
screen -dmS queue
screen -dmS build

# queue セッションで Laravel のキューを動作
screen -S queue -X stuff ' \
    cd "$WORKDIR"; \
    php artisan queue:work \
\n'

# build セッションで webpack を用いた自動ビルドを動作
screen -S build -X stuff ' \
    cd "$WORKDIR"; \
    npm run watch \
\n'
