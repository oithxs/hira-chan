#!/bin/bash

# containerCreate.shが存在していれば実行（コンテナ作成時に実行）
if [ -e "/usr/local/bin/containerCreate.sh" ]; then
    # 繰り返し
    while true; do
        # hira-chan_mariadb:3306の接続を確認
        curl hira-chan_mariadb:3306
        if [ $? -eq 1 ]; then
            break
        fi

        # 1秒待機
        sleep 1
    done

    # containerCreate.shを実行
    /usr/local/bin/containerCreate.sh

    # containerCreate.shをロック
    sudo mv /usr/local/bin/containerCreate.sh /usr/local/bin/containerCreate.sh.lock
    sudo chmod 644 /usr/local/bin/containerCreate.sh.lock
fi

# 各種サービス起動
sudo su <<EOF
service postfix start
service php8.1-fpm start
EOF

# 使用できないセッションの削除
screen -wipe

# セッションの作成
screen -dmS vite
screen -dmS queue

# vite セッションで vite を用いた自動ビルドを動作
screen -S vite -X stuff ' \
    cd "$WORKDIR"; \
    npm run dev \
\n'

# queue セッションで Laravel のキューを動作
screen -S queue -X stuff ' \
    cd "$WORKDIR"; \
    php artisan queue:work \
\n'

sleep infinity
