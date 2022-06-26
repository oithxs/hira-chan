# 本プロジェクトの環境構築まで

最終更新日：2022/06/26

## 1 以下の OS では環境構築が出来る事を確認しています

-   Docker と Docker Compose を導入した OS

---

これから Linux の場合の環境構築を説明します

## 2 Docker (Rootless モード)のインストール

これにより、Docker デーモンとコンテナを root 以外のユーザが実行できるようになります。

### 2.1 uidmap のインストール

```bash
sudo apt install -y uidmap
```

### 2.2 ワンライナーでの Docker のインストール

root 以外のユーザーで実行して下さい

```bash
curl -fsSL https://get.docker.com/rootless | sh
```

### 2.3 Docker コマンドを使えるようにする

以下の 2 つのコマンドを実行して下さい

```bash
export PATH=/home/$USER/bin:$PATH
```

```bash
export DOCKER_HOST=unix:///run/user/1000/docker.sock
```

### 2.4 インストールを確認

```bash
docker -v
```

```bash
docker ps
```

## 3 Docker Compose のインストール

以下のコマンドは例ですので[Compose リポジトリのリリースページ](https://github.com/docker/compose/releases)を確認して、URL を修正して下さい

### 3.1 Docker Compose の最新版をダウンロード (v2.6.1 の場合)

```bash
sudo curl -L https://github.com/docker/compose/releases/download/v2.6.1/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
```

### 3.2 バイナリに対して実行権限を付与する

```bash
sudo chmod +x /usr/local/bin/docker-compose
```

### 3.3 インストールを確認

```bash
docker-compose -v
```

---

## 4 必要なファイルを配置

今回はホームディレクトリ直下に`docker-laravel`ディレクトリを作り、そこで作業する。

1. `docker-laravel`ディレクトリに`Laravel_Forum-B`をクローンする
2. `Laravel_Forum-B/docs/dev/docker-sample/`にある、`dockerフォルダ`と`docker-compose.yml`を全て`docker-laravel`直下に移動させる
3. 以下のような構造になっていたら準備は完了

```bash
docker-laravel
|
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

## 5 コンテナを起動
`docker-laravel`ディレクトリで以下のコマンドを実行
```bash
docker-compose up -d
```
