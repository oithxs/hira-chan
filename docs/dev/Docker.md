# 本プロジェクトの環境構築まで

## 以下の OS では環境構築が出来ることを確認しています

-   Docker と Docker Compose を導入した OS

## 目次

1. [Docker のインストール](#1-docker-rootless-モードのインストール)
2. [Docker Compose のインストール](#2-docker-compose-のインストール)
3. [必要なファイルを配置](#3-必要なファイルを配置)
4. [コンテナの構築](#4-コンテナを構築-作成-起動-アタッチする)
5. [コンテナの初期設定](#5-コンテナの初期設定)

---

これから Debian 系のディストリビューションの場合の環境構築を説明します

## 1 Docker (Rootless モード)のインストール

これにより、Docker デーモンとコンテナを root 以外のユーザが実行できるようになります

### 1.1 uidmap のインストール

```bash
sudo apt install -y uidmap
```

### 1.2 ワンライナーでの Docker のインストール

root 以外のユーザーで実行して下さい

```bash
curl -fsSL https://get.docker.com/rootless | sh
```

### 1.3 Docker コマンドを使えるようにする

スクリプトが終了すると下のようなものを`.bashrc`にコピペするよう促されるので`~/.bashrc`ファイルの最後に追加する  
以下は例です

```bash
export PATH=/home/$USER/bin:$PATH
export DOCKER_HOST=unix:///run/user/1000/docker.sock
```

### 1.4 コマンドライン補完のインストール

```bash
sudo curl \
    -L https://raw.githubusercontent.com/docker/cli/master/contrib/completion/bash/docker \
    -o /etc/bash_completion.d/docker
```

### 1.5 ターミナルを再読込する

ターミナルを閉じて新しいものを開くか、現在のターミナルで以下のコマンドを実行して下さい

```bash
source ~/.bashrc
```

### 1.6 インストールを確認

```bash
docker -v
```

```bash
docker ps
```

---

## 2 Docker Compose のインストール

以下のコマンドは例ですので[Compose リポジトリのリリースページ](https://github.com/docker/compose/releases)を確認して、URL を修正して下さい

### 2.1 Docker Compose の最新版をダウンロード (v2.6.1 の場合)

```bash
sudo curl \
    -L https://github.com/docker/compose/releases/download/v2.6.1/docker-compose-`uname -s`-`uname -m` \
    -o /usr/local/bin/docker-compose
```

### 2.2 バイナリに対して実行権限を付与する

```bash
sudo chmod +x /usr/local/bin/docker-compose
```

### 2.3 インストールを確認

```bash
docker-compose -v
```

---

## 3 必要なファイルを配置

今回はホームディレクトリ直下に`docker-laravel`ディレクトリを作り、そこで作業する

1. `docker-laravel`ディレクトリに`Laravel_Forum-B`のリポジトリをクローンする
2. [Laravel_Forum-B/docs/dev/docker-sample/](./docker-sample/)にある、`dockerフォルダ`と`docker-compose.yml`を全て`docker-laravel`直下に移動させる
3. 以下のような構造になっていたら準備は完了

```
docker-laravel
│
├── Laravel_Forum-B
│   └── 省略
├── docker
│   ├── nginx
│   │   └── default.conf
│   └── php
│       ├── Dockerfile
│       └── php.ini
└── docker-compose.yml
```

---

## 4 コンテナを構築 作成 起動 アタッチする

`docker-laravel`ディレクトリで以下のコマンドを実行

```bash
docker-compose up -d
```

---

## 5 コンテナの初期設定

ワーキングディレクトリを`docker-laravel`とする

### 5.1 env ファイルの設定

1. env ファイルをコピー

```bash
cp Laravel_Forum-B/.env.example Laravel_Forum-B/.env
```

2. env ファイルに以下を記述

```text
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=forum
DB_USERNAME=root
DB_PASSWORD=rootpass
```

### 5.2 権限を設定

```bash
sudo chmod -R 777 Laravel_Forum-B/storage/
```

### 5.3 vendar ディレクトリの作成

```bash
docker-compose exec app \
    composer install
```

### 5.4 アプリケーションキーを生成

```bash
docker-compose exec app \
    php artisan key:generate
```

### 5.5 テーブルの作成

```bash
docker-compose exec app \
    php artisan migrate
```

### 5.6 メールの設定

1. `ACCOUNT_NAME`と`APP_PASSWORD`を任意のものに変更して実行する

```bash
docker-compose exec app \
    echo "[smtp.gmail.com]:587 ACCOUNT_NAME@gmail.com:APP_PASSWORD" \
    > ./docker/php/postfix/sasl_passwd
```

2. 権限を変更する

```bash
chmod 600 ./docker/php/postfix/sasl_passwd
```

3. Postfix 検索テーブルの作成

```bash
docker-compose exec app \
    postmap /etc/postfix/sasl/sasl_passwd
```

4. main.cf の編集

```bash
docker-compose exec app \
    sed -ie 's/relayhost = /relayhost = [smtp.gmail.com]:587/' /etc/postfix/main.cf
```

```bash
docker-compose exec app \
    sed -ie 's/inet_protcols = all/inet_protcols = ipv4/' /etc/postfix/main.cf
```

app コンテナ内に入る

```bash
docker-compose exec app bash
```

main.cf に追記

```bash
cat <<EOF >> /etc/postfix/main.cf
smtp_use_tls = yes
smtp_sasl_auth_enable = yes
smtp_sasl_password_maps = hash:/etc/postfix/sasl/sasl_passwd
smtp_sasl_tls_security_options = noanonymous
EOF
```

コンテナから出る

```bash
exit
```

5. Postfix を再起動

```bash
docker-compose exec app \
    /etc/init.d/postfix restart
```

6. env ファイルの編集

```text
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ACCOUNT_NAME@gmail.com
MAIL_PASSWORD=APP_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=ACCOUNT_NAME@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
MAIL_EXAMPLE_ADDRESS=e1n11111
```

## 6 アクセスする

-   掲示板のポート番号は`8080`
-   phpmyadmin のポート番号は`4040`

## 参考にした記事

-   [Docker で Laravel の環境構築をする手順をまとめてみた](https://www.engilaboo.com/how-to-use-docker-for-laravel/)
-   [docker-compose で Laravel の開発環境を整える方法とその解説](https://www.membersedge.co.jp/blog/laravel-development-environment-with-docker-compose/)
-   [【超入門】20 分で Laravel 開発環境を爆速構築する Docker ハンズオン](https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4)
-   [DEBIAN_FRONTEND=noninteractive](https://zenn.dev/flyingbarbarian/scraps/1275681132babd)
