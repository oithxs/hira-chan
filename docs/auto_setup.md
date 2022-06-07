# 本プロジェクトの開発環境構築まで

最終更新日：2022/06/06 21:14

このドキュメントは，本プロジェクトをクローンしてシェルスクリプトによる環境構築までの手順を記載したものです．

シェルスクリプトの実行によりセットアップの手順を大幅に省略する事ができますが，現在のものはコマンドを並べただけなので途中でおかしな動作をする場合があります．このセットアップ方法は自己責任でお願いします．

## 以下のOSでは環境構築ができる事を確認しています

- Ubuntu-22.04-Server

## 目次

1. [リポジトリのクローン](#1-リポジトリのクローン)
2. [シェルスクリプトの実行](#2-シェルスクリプトの実行)

## 1. リポジトリのクローン

fork等した場合は以下のクローン元は変更して下さい．

```sh
$ cd ~
~$ git clone https://github.com/hxs-mini2/Laravel_Forum-B.git
```

ssh通信の鍵生成・githubへのキーの追加は[docs/setup.mp](https://github.com/hxs-mini2/Laravel_Forum-B/blob/develop/docs/setup.md#4-リポジトリのクローンからサイトの表示まで)を参考にしてください

## 2. シェルスクリプトの実行

1. 作成したgoogleアカウントでログイン
2. セキュリティに移動
3. アプリ パスワードに移動
4. アプリを選択でその他を選び，アプリパスワードの名前を入力（なんでも）
5. 生成されたパスワードをコピー
6. 完了をクリック

```sh
~$ chmod +x Laravel_Forum-B/auto_setup.sh
~$ sudo ./Laravel_Forum-B/auto_setup.sh
User name: <シェルスクリプトを実行しようとしている個人ユーザ名を入力して下さい>
App name: <メール送信元などに表示されます>
Create two databases. Please enter the database names.
The "_" character can be used. The "_" character cannot be used.
Main database: <「-」を使用すれば動作がおかしくなります．>
Database for BBS: <上に同じ・メインデータベースと同じ名前を入力しないで下さい>
Set MySQL/phpMyAdmin related passwords
Password: <MySQL等に登録するパスワードです>
Configure mail-related settings.
Account name (no @ or below required): <Googleアカウントの@以前のみを入力して下さい>
Application Password: <Googleアカウントのアプリパスワードを入力して下さい>
```

正常に動作すれば以上です．
`docs/setup.md`の手順完了後と同じ状態になります．（なっているはずです）

## その他

### LAMPPの自動起動

```sh
$ sudo crontab -e
no crontab for root - using an empty one

Select an editor.  To change later, run 'select-editor'.
  1. /bin/nano        <---- easiest
  2. /usr/bin/vim.basic
  3. /usr/bin/vim.tiny
  4. /bin/ed

Choose 1-4 [1]: 1    # 1 を入力してEnter
```

下記の内容を追記・私はもともとある文はすべて削除しています

```sh
@reboot /opt/lampp/lmapp start
```

### laravel-admin の初期ユーザ設定

以下のコマンドを実行します．

```sh
$ php artisan admin:install
$ php artisan db:seed
```

### laravel-admin のユーザアバター

そのままだとフォルダの権限が不足しているので

```sh
$ chmod 777 -R public/uploads
```

.envファイルの `APP_URL` を環境構築したコンピュータのIP（ドメイン）に編集

## 参考サイト

- [UbuntuにLAMPP(XAMPPのLinux版)をインストールする](https://lil.la/archives/4324)
- [Ubuntu20.04にComposerをインストールする手順](https://mebee.info/2020/06/02/post-10844/)
- [Ubuntu で Node の最新版/推奨版を使う (n コマンド編)](https://qiita.com/cointoss1973/items/c000c4f84ae4b0c166b5)
- [Gmail 経由でメールを送信するように Postfix を設定する](https://blog.ymyzk.com/2017/06/postfix-smarthost-gmail/)
- [非対話形式でパッケージを自動更新する(debconfを無効化)](https://blog.jicoman.info/2017/01/autoupgrade_apt-get_dpkg/)
