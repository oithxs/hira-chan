# 本プロジェクトの環境構築まで

最終更新日：2022/06/26

## 以下の OS では環境構築が出来ることを確認しています

-   Docker と Docker Compose を導入した OS

## 目次

1. [Docker のインストール](#1-docker-rootless-モードのインストール)
2. [Docker Compose のインストール](#2-docker-compose-のインストール)
3. [必要なファイルを配置](#3-必要なファイルを配置)
4. [コンテナを構築する](#4-コンテナを構築-作成-起動-アタッチする)

---

これから Debian 系のディストリビューションの場合の環境構築を説明します

## 1 Docker (Rootless モード)のインストール

これにより、Docker デーモンとコンテナを root 以外のユーザが実行できるようになります。

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

今回はホームディレクトリ直下に`docker-laravel`ディレクトリを作り、そこで作業する。

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

## 4 コンテナを構築 作成 起動 アタッチする

`docker-laravel`ディレクトリで以下のコマンドを実行

```bash
docker-compose up -d
```
