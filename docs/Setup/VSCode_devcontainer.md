# 本プロジェクトの環境構築まで

## 以下の 環境 では環境構築が出来ることを確認しています

-   WSL2

## 目次

1. [Docker のインストール](#1-docker-rootless-モードのインストール)
2. [Docker Compose のインストール](#2-docker-compose-のインストール)
3. [コンテナの構築](#3-コンテナを構築-作成-起動-アタッチする)
4. [コンテナの停止](#4-コンテナの停止)
5. [コンテナの起動](#5-コンテナの起動2-回目以降)

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

1. （ホームディレクトリ直下に） `git clone` でプロジェクトを配置する
2. vscode でプロジェクトを開き，`このワークスペースには拡張機能の推奨事項があります` の通知から `全てインストール` する
3. その後，vscode の通知から `Reopen in Container` を実行する
4. メール送信を可能とするために， `.env` ファイルの以下の項目を設定する
    - `MAIL_USERNAME` -> Gmail アドレス
    - `MAIL_PASSWORD` -> 上記の Gmail アドレスのアプリパスワード
    - `MAIL_FROM_ADDRESS` -> Gmail アドレス

コンテナの構築・作成・起動はこれで完了です．

### コンテナ内での開発

`Reopen in Container` で起動・コンテナ内に入ることで開発でよく使用する `php`，`composer`，`npm` のコマンドを使用出来ます．

また，コンテナ内ではフォーマッタも使用出来るので `Ctrl` + `S` などにより整形を行って下さい．

基本的にコンテナ内での開発をお願いします．

### アクセス

-   掲示板: `http://localhost:8080`
-   掲示板管理者ページ: `http://localhost:8080/admin`
-   phpmyadmin:`http://localhost:8080/phpmyadmin`

## 4 コンテナの停止

コンテナ内での開発中にコンテナを停止する場合は，vscode 左下の緑のアイコンから `Reopen Folder in WSL` を選択する事によりコンテナの停止が行われます

## 5 コンテナの起動（2 回目以降）

-   vscode の通知で `Reopen in Container` を実行する
-   左下の緑のアイコンから `Reopen in Container` を実行

コンテナの起動は上記のどちらかにより完了です．しかし，プロジェクトの更新には以下のコマンドが必要です．`git pull` などでリモート（フォーク元）の変更をローカルに取り込んでから，問題の無いタイミングで以下のコマンドを実行して下さい．

```sh
composer install # PHPのパッケージをインストール
npm install # Nodeのパッケージをインストール
npm install --update-binary --no-shrinkwrap # 上記コマンドでNodeのパッケージインストールが失敗した場合
php artisan migrate # プロジェクトのデータベースを最新の状態にする
php artisan migrate:fresh # プロジェクトのデータベースを再構築する
app db:seed # プロジェクトのテーブルに初期データを作成する
```

-   `composer install` を実行する際は状況に応じて `vendor` フォルダを削除する事も検討して下さい
-   `npm install` を実行する際は状況に応じて `node_modules` フォルダを削除する事も検討して下さい

## 参考にした記事

-   [Docker で Laravel の環境構築をする手順をまとめてみた](https://www.engilaboo.com/how-to-use-docker-for-laravel/)
-   [docker-compose で Laravel の開発環境を整える方法とその解説](https://www.membersedge.co.jp/blog/laravel-development-environment-with-docker-compose/)
-   [【超入門】20 分で Laravel 開発環境を爆速構築する Docker ハンズオン](https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4)
-   [DEBIAN_FRONTEND=noninteractive](https://zenn.dev/flyingbarbarian/scraps/1275681132babd)
