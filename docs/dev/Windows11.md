# 本プロジェクトの環境構築まで

最終更新日：2022/06/11 23:26

このドキュメントは，本プロジェクトのクローンから環境構築までの手順を記載したものです．
この手順ではメール関連の機能は使用出来ません．

## 以下のOSでは環境構築が出来る事を確認しています

- Windows11

## 目次

1. [XAMPPのインストール](#1-xamppのインストール)
2. [Composerのインストール](#2-composerのインストール)
3. [Node.jsのインストール](#3-nodejsのインストール)
4. [Gitのインストール](#4-gitのインストール)
5. [リポジトリのクローンからサイトの表示まで](#5-リポジトリのクローンからサイトの表示まで)

## 1. XAMPPのインストール

XAMPPはwebアプリケーションの実行に必要なフリーソフトウェアをパッケージとしてまとめたものです．

### XAMPPインストーラのインストール

XAMPPのサイト [https://www.apachefriends.org/jp/index.html](https://www.apachefriends.org/jp/index.html) からインストーラをダウンロードします．
XAMPPのバージョンは8.1.5を想定しています．[XAMPP-8.1.5のインストーラリンク](https://downloadsapachefriends.global.ssl.fastly.net/8.1.5/xampp-windows-x64-8.1.5-0-VS16-installer.exe)

### インストーラの実行

ダウンロードしたインストーラを起動します．起動後はよくある「このデバイスに変更を加えることを許可しますか？」と表示されるので，「はい」を選択してください．その後，Warning ウィンドウが表示されるので「OK」をクリックし，インストーラを起動します．

1. Setup - XAMPP : Next
2. Select Components : Next
3. Installation folder : Next
4. Language : Next
5. Bitnami for XAMPP : Next
6. Ready to Install : Next
7. Completing the XAMPP Setup Wizard : Finish

XAMPPは何も変更せず `Next` 連打でインストール出来ます．

### XAMPP の動作確認

- Apach
- MySQL

を `Start` します．すると，「このアプリの機能のいくつかがWindows Defender ファイアウォールでブロックされています」のウィンドウが２回？表示されるので，どちらも「アクセスを許可する」を選択します．

これで起動が出来ない場合は[こちら](https://chigusa-web.com/blog/laravel-setup/)などを参考にして，起動できるようにしておきます．

`C:\xampp\xampp-control.exe` のショートカットを作成しておくと起動が楽です．

## 2. Composerのインストール

phpのパッケージ管理ツールである「Compoer」をインストールします．

### Composerインストーラのダウンロード

こちらのサイト [https://getcomposer.org/download/](https://getcomposer.org/download/) から `Composer-Setup.exe` をダウンロードします．
一応ダウンロードリンクを乗せておきます．[Composerインストーラ](https://getcomposer.org/Composer-Setup.exe)

### Composerインストーラの実行

ダウンロードしたインストーラを起動します．こちらはSelect Setup Install Modeが初めに表示されるので，「Install for all users (recommended)」を選択します．その後，「このデバイス...以下略．インストーラが起動します．

1. Installation Options : Next
2. Settings Check : `Add this PHP to path?` にチェックをいれてNext
3. Proxy Settings : Next
4. Ready to Install : Install
5. Information : Next
6. Completing Composer Setup : Finish

これでComposerのインストール完了です．

### Composerの動作確認

コマンドプロンプトを開き，以下のコマンドを実行します．

```cmd
C:\Users\<user_name>composer -V
Composer version 2.3.7 2022-06-06 16:43:28
```

のように実行できれば，正常にインストール出来ています．

## 3. Node.jsのインストール

### Node.jsインストーラのダウンロード

Node.jsはLaravelのLaravel Mix（jsのコンパイルなど）に必要です．

Node.jsのサイト [https://nodejs.org/ja/download/](https://nodejs.org/ja/download/) からインストーラをダウンロードします．
Node.jsのバージョンは16.15.1を想定しています．[Node.js-16.15.1のインストーラ](https://nodejs.org/dist/v16.15.1/node-v16.15.1-x64.msi)

### Node.jsインストーラの実行

ダウンロードしたインストーラを起動します．こちらは特に何もなくインストーラのウィンドウが表示されます．

1. Welcome to the Node.js Setup Wizard : Next
2. End-User License Agreement : `I accept the terms in the License Agreement` にチェックをいれてNext
3. Destination Folder : Next
4. Custom Setup : Next
5. Tools for Native Modules : Next
6. Ready to install Node.js : Install

Node.jsはここで「このアプリに変更...のくだりが表示されるので，「はい」をクリックします．インストールが始まり，終了すると画面に `Finish` が表示されるのでクリックします．

### Node.jsの動作確認

コマンドプロンプトを開き，以下のコマンドを実行します．

```cmd
C:\Users\<user_name>node -v
v16.15.1
```

初めは少し時間がかかりますが，このように表示されれば正常にインストール出来ています．

## 4. Gitのインストール

インストール済みであれば，[次の項目](#5-リポジトリのクローンからサイトの表示まで)へ移動してください

### Gitインストーラのダウンロード

[公式サイト](https://gitforwindows.org/)で `Download` をクリックし，インストーラをダウンロードします．

### Gitインストーラの実行

ダウンロードしたインストーラを実行します．起動すると，「このデバ...以下略．ここではこちらのサイト [WindowsにGitをインストールする手順(2022年6月更新)](https://www.curict.com/item/60/60bfe0e.html) で各項目の説明を見ることが出来ます．さっさとインストールしたい方はこのまま読み進めてください．

1. Information : Next
2. Select Destination Location : Next
3. Select Components : Next
4. Select Start Menu Folder : Next
5. Choosing the default editor used by Git : Next
6. Adjusting the name of the inital branch in new repositories : Next
7. Adjusting your PATH environment : Next
8. Choosing the SSH executable : Next
9. Choosing HTTPS transport backend : Next
10. Configuring the line ending conversions : `Checkout as-is, commit as-is` にチェックをいれてNext
11. Configuring the terminal emulator to use with Git Bash : Next
12. Choose the default behavior of \`git pull\` : Next
13. Choose a credential helper : Next
14. Configuring extra options : Next
15. Configuring experimental options : Install
16. Completing the Git Setup Wizard : `View Release Notes` のチェックを外しFinish

### Gitの動作確認

コマンドプロンプトを開き，以下のコマンドを実行します．

```cmd
C:\Users\<user_name>git --version
git version 2.36.1.windows.1
```

このように表示されれば正常にインストール出来ています．

## 5. リポジトリのクローンからサイトの表示まで

### リポジトリのクローン

fork等した場合は以下のクローン元は変更して下さい．

```cmd
C:\Users\<user_name>cd C:\xampp\htdocs
C:\xampp\htdocs>git clone https://github.com/hxs-mini2/Laravel_Forum-B.git
```

ssh通信の鍵生成・githubへのキーの追加は[docs/dev/Ubuntu-2204-Server.mp](https://github.com/hxs-mini2/Laravel_Forum-B/blob/develop/docs/dev/Ubuntu-2204-Server.md#4-リポジトリのクローンからサイトの表示まで)を参考にしてください

### ドキュメントルートの変更

`C:\xampp\apache\conf\httpd.conf` ファイルをテキストエディタで開き，以下の箇所を変更します．

変更前

```?
DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">
```

変更後

```?
DocumentRoot "C:/xampp/htdocs/Laravel_Forum-B/public"
<Directory "C:/xampp/htdocs/Laravel_Forum-B/public">
```

変更後，（起動していれば）XAMPPのサービスをすべて停止させ，windowを閉じ，再び開きます（再起動的な？）．`Apache`, `MySQL` をstartさせ，`localhost`にアクセスします．XAMPPのダッシュボードが表示されなければドキュメントルートが変更されています．（サイトは正常動作していません）

### vendarディレクトリの作成

コマンドプロンプトで以下のコマンドを実行します．

```cmd
C:\Users\<user_name>cd C:/xampp/htdocs/Laravel_Forum-B
C:\xampp\htdocs\Laravel_Forum-B>composer install
```

`Package swiftmailer/swiftmailer is abandoned, you shuld avoid using it. Use symfony/mailer instead.` の後，しばらく時間が経過してももう一つ下の緑色文字以後何も進まなければ，Enterを押すと先に進めました．

ほとんど時間がかからなかった場合もありました．

### npm run dev コマンドを使用可能に

```cmd
C:\xampp\htdocs\Laravel_Forum-B>npm install
```

### .envファイルの作成

```cmd
C:\xampp\htdocs\Laravel_Forum-B>copy .env.example .env
```

### よく分かりませんがkeyの生成

```cmd
C:\xampp\htdocs\Laravel_Forum-B>php artisan key:generate
Application key set successfully.
```

### データベースの作成

1. phpmyadminにアクセスし，左の新規作成をクリックします
2. Laravelの機能が使用するデータベースを作成します．任意のデータベース名を入力し作成をクリックします
3. 掲示板用のデータベースを作成します．こちらもデータベース名は任意です

### .envファイルの編集

`C:\xampp\htdocs\Laravel_Forum-B\.env` ファイルをテキストエディタで開き，以下の箇所を変更します．

変更前

```cmd
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_DATABASE_KEIZIBAN=
DB_USERNAME=root
DB_PASSWORD=
```

変更後

```cmd
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<メインデータベース名>
DB_DATABASE_KEIZIBAN=<掲示板用データベース名>
DB_USERNAME=root
DB_PASSWORD=
```

### 使用するテーブルの作成

```cmd
C:\xampp\htdocs\Laravel_Forum-B>php artisan migrate
```

ここまで順調にいけば，`localhost` アクセス時にウェルカムページが表示され，他のページも動作する様になっています．しかし，現状ではメール送信が出来ないため，ユーザ登録を別の方法でする必要があります．以下の手順でユーザ登録が出来ます．

### 管理者ページにアクセス

```cmd
C:\xampp\htdocs\Laravel_Forum-B>php artisan admin:install
C:\xampp\htdocs\Laravel_Forum-B>php artisan db:seed
```

これで，`localhost/admin` にアクセスし，

- ID : admin
- password : admin

でログイン出来るようになります．ログインして下さい．

### ユーザ登録

管理者ページ左の（よくわからん顔）の下3つ目`General` の `Users` をクリックして下さい．よく分からなければ `localhost/admin/users` に直接アクセスして下さい．

右上の「＋新規」をクリックします．そこで，

- 氏名
- メールアドレス
- パスワード

を入力して下さい．メールアドレスは制限されていませんので，何でも構いません（例：user@user.user）．そしてEnterキーを押すか，フォーム右下の「送信」をクリックすると，ユーザ登録が完了します．

通常のページ（ログイン画面）に移動し，登録したユーザEmailとパスワードを入力すると，ログインできます（通常のアカウント新規登録ではメール認証が必要なため，メール機能が必須です）．

## 参考サイト

- [【XAMPP】インストールするやり方を解説します](https://www.tairaengineer-note.com/xampp-install/)
- [【PHP】Composerをインストールするやり方を解説します（Windowsの場合](https://www.tairaengineer-note.com/composer-install/)
- [【Node.js】インストールするやり方を解説します（Windowsの場合）](https://www.tairaengineer-note.com/nodejs-install/)
- []