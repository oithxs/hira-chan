# 本プロジェクトの環境構築まで

## 以下の OS では環境構築が出来ることを確認しています

-   Docker と Docker Compose を導入した OS

## 目次

1. [Docker のインストール](#1-docker-rootless-モードのインストール)
2. [Docker Compose のインストール](#2-docker-compose-のインストール)
3. [コンテナの構築](#3-コンテナを構築-作成-起動-アタッチする)
4. [コンテナの停止](#4-コンテナの自動停止・手動停止)
5. [コンテナの起動](#5-コンテナの自動起動・手動起動)

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

## 3 コンテナを構築 作成 起動 アタッチする

1. ホームディレクトリ直下に `git clone` でプロジェクトを配置する
2. プロジェクトディレクトリ内で以下のコマンドを実行する

```sh
chmod +x ./bin/*
```

```sh
./bin/setup-docker.sh
Account name (no @ or below required): <gmailの@より前の部分>
Application Password: <アプリパスワード>
```

※ メール送信は可能ですがメールによるユーザ認証は 403 エラーがでて出来ないので，admin からユーザ登録をして下さい．

メール機能が不要であれば上記の入力は不要です．ただし，メールサーバ用コンテナは作成されます．
手動でメール機能を有効にする場合や，メールアドレスを変更したい場合は，`.env` ファイルの

-   `MAIL_USERNAME`
-   `MAIL_PASSWORD`
-   `MAIL_FROM_ADDRESS`

部分を編集して下さい．

### アクセス

-   掲示板: `http://localhost:8080`
-   掲示板管理者ページ: `http://localhost:8080/admin`
-   phpmyadmin:`http://localhost:8080/phpmyadmin`

## 4 コンテナの自動停止・手動停止

コンテナの停止に関しては，作業ディレクトリが異なるだけでたいした違いはありません．

### 4.1 自動停止（シェルスクリプト）

`docker-Laravel_Forum-B/Laravel_Forum-B` ディレクトリ内で以下のコマンドを実行する

```sh
./bin/stop-docker.sh
```

### 4.2 手動停止（コマンドライン）

`docker-Laravel_Forum-B/docker` ディレクトリ内で以下のコマンドを実行する

```sh
docker-compose stop
```

## 5 コンテナの自動起動・手動起動

### 5.1 自動起動（シェルスクリプト）

`docker-Laravel_Forum-B/Laravel_Forum-B` ディレクトリ内で以下のコマンドを実行する

```sh
./bin/start-docker.sh
```

ローカルリポジトリの更新もここで行っているので，`git pull` などでリモート（フォーク元）の変更をローカルに取り込んでから起動する事をオススメします．

### 5.2 手動起動（コマンドライン）

`docker-Laravel_Forum-B/docker` ディレクトリ内で以下のコマンドを実行する

```sh
docker-compose start
```

コンテナの起動自体はこれで完了です．しかし，ローカルリポジトリの更新には以下のコマンドが必要です．
`git pull` などでリモート（フォーク元）の変更をローカルに取り込んでからコマンドを実行する事をオススメします．

```sh
docker-compose exec composer composer install
docker-compose exec composer npm install
docker-compose exec app php artisan migrate
docker-compose exec app db:seed
```

## 参考にした記事

-   [Docker で Laravel の環境構築をする手順をまとめてみた](https://www.engilaboo.com/how-to-use-docker-for-laravel/)
-   [docker-compose で Laravel の開発環境を整える方法とその解説](https://www.membersedge.co.jp/blog/laravel-development-environment-with-docker-compose/)
-   [【超入門】20 分で Laravel 開発環境を爆速構築する Docker ハンズオン](https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4)
-   [DEBIAN_FRONTEND=noninteractive](https://zenn.dev/flyingbarbarian/scraps/1275681132babd)
