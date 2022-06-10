# 本プロジェクトの環境構築まで

最終更新日：2022/06/10 22:41

このドキュメントは，本プロジェクトのクローンから環境構築までの手順を記載したものです．

各コマンドの，$マーク前にある `~` や， `/opt/lampp/htdocs/Laravel_Forum-B` などは，現在いるディレクトリを表しています．

Ubuntu-22.04-Server ではパッケージ更新の際に `Which services should be restarted?` （など）で止まる事があるようです．そのため，それ以外のOSを利用する場合は以下の手順のなかでところどころ素通りするピンク色の対話画面があります．

## 以下のOSでは環境構築ができる事を確認しています

- Ubuntu-22.04-Server

## 目次

1. [XAMPP for Linux のインストール](#1-xampp-for-linux-のインストール)
2. [Composer のインストール](#2-composer-のインストール)
3. [Node.js・npm のインストール](#3-nodejs・npm-のインストール)
4. [リポジトリのクローンから環境構築まで](#4-リポジトリのクローンからサイトの表示まで)
5. [アカウント新規登録時のメール検証機能まで](#5-アカウント新規登録時のメール検証機能まで)

## 1. XAMPP for Linux のインストール

XAMPPはwebアプリケーションの実行に必要なフリーソフトウェアをパッケージとしてまとめたものです．

### LAMPP インストーラのダウンロード

```sh
$ cd ~
~$ wget wget https://downloadsapachefriends.global.ssl.fastly.net/8.1.5/xampp-linux-x64-8.1.5-0-installer.run
```

実行後，`xampp-linux-x64-8.1.5-0-installer.run` がダウンロードされています．

### インストーラに実行権限をつける

```sh
~$ chmod +x xampp-linux-x64-8.1.5-0-installer.run
```

何も出力されなければ成功です．

### インストーラの実行

```sh
~$ sudo ./xampp-linux-x64-8.1.5-0-installer.run
----------------------------------------------------------------------------
Welcome to the XAMPP Setup Wizard.

----------------------------------------------------------------------------
Select the components you want to install; clear the components you do not want
to install. Click Next when you are ready to continue.

XAMPP Core Files : Y (Cannot be edited)

XAMPP Developer Files [Y/n] :y     # y を入力してEnter

Is the selection above correct? [Y/n]: y     # y を入力してEnter

----------------------------------------------------------------------------
Installation Directory

XAMPP will be installed to /opt/lampp
Press [Enter] to continue:     # 何も入力せずにEnter

----------------------------------------------------------------------------
Setup is now ready to begin installing XAMPP on your computer.

Do you want to continue? [Y/n]: y     # y を入力してEnter
```

`Setup has finished installing xampp on your computer`と表示されると成功です

### 不要サービスの停止

```sh
~$ sudo systemctl disable apache2
~$ sudo systemctl stop apache2
```

`apache2`を停止しておかないと，LAMPPのapacheが起動しないなどの動作不良が起こりました．

### LAMPP を起動

ここでは起動していませんが，`ProFTPD` はエラー無く普通に起動する場合もあります．

`line 22: netstat: command not found` はおそらく出るかと思います．

```sh
~$ sudo /opt/lampp/lampp start
XAMPP: Starting Apache.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
/opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
ok.
XAMPP: Starting MySQL.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
ok.
XAMPP: Starting ProFTPD.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
fail.
Contents of "/opt/lampp/var/proftpd/start.err":
2022-05-04 16:41:09,468 ubu-serv proftpd[991]: fatal: unknown configuration directive 'function' on line 44 of '/opt/lampp/etc/proftpd.conf'
```


### 最低限のセキュリティ設定を行う

```sh
~$ sudo /opt/lampp/lampp security
XAMPP:  Quick security check...
XAMPP:  MySQL is accessable via network.
XAMPP: Normaly that's not recommended. Do you want me to turn it off? [yes] no     # no を入力後Enter
XAMPP:  The MySQL/phpMyAdmin user pma has no password set!!!
XAMPP: Do you want to set a password? [yes] yes     # yes を入力後Enter
XAMPP: Password:     # 任意のパスワードを入力後Enter
XAMPP: Password (again):     # パスワードの確認
XAMPP:  Setting new MySQL pma password.
XAMPP:  Setting phpMyAdmin's pma password to the new one.
XAMPP:  MySQL has no root passwort set!!!
XAMPP: Do you want to set a password? [yes] yes     # yes を入力後Enter
XAMPP:  Write the password somewhere down to make sure you won't forget it!!!
XAMPP: Password:     # 任意のパスワードを入力後Enter
XAMPP: Password (again):     # パスワードの確認
XAMPP:  Setting new MySQL root password.
XAMPP:  Change phpMyAdmin's authentication method.
XAMPP:  The FTP password for user 'daemon' is still set to 'xampp'.
XAMPP: Do you want to change the password? [yes] yes     # yes を入力後Enter
XAMPP: Password:     # 任意のパスワードを入力後Enter
XAMPP: Password (again):     # パスワードの確認
XAMPP: Reload ProFTPD...ok.
XAMPP:  Done.
```

各質問の意味は[こちら](https://lil.la/archives/4324)を参考にして下さい．

### 外部ホストからphpMyAdminへ接続できる様に

```sh
~$ sudo nano /opt/lampp/etc/extra/httpd-xampp.conf
```

```sh
<Directory "/opt/lampp/phpmyadmin">
    AllowOverride AuthConfig Limit
    # Require local ここをコメントアウト
    Require all granted     # ここを追記
    ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
</Directory>
```

### LAMPPの再起動

```sh
~$ sudo /opt/lampp/lampp restart
```

再起動後ipアドレスを確認し，http://<ここにIPアドレス>/phpmyadmin へアクセスすると，phpmyadminのログイン画面が表示されます．

ipアドレスは以下のコマンドで確認できます

```sh
~$ ip a
# いろいろ出力されますが，inetの項目にipアドレス（ipv4）が出力されます
```

### 補足

### LAMPP起動時にApache・MySQL・ProFTPDで`line 22: netstat: command not found`と出力される

```sh
~$ sudo /opt/lampp/lampp restart 
Restarting XAMPP for Linux 8.1.5-0...
XAMPP: Stopping Apache...ok.
XAMPP: Stopping MySQL...ok.
XAMPP: Stopping ProFTPD...not running.
XAMPP: Starting Apache.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
/opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
ok.
XAMPP: Starting MySQL.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
ok.
XAMPP: Starting ProFTPD.../opt/lampp/share/xampp/xampplib: line 22: netstat: command not found
fail.
Contents of "/opt/lampp/var/proftpd/start.err":
2022-05-04 16:37:29,358 ubu-serv proftpd[56989]: fatal: unknown configuration directive 'function' on line 44 of '/opt/lampp/etc/proftpd.conf'
```

これは無視しても問題無いかと思います．気になる場合は以下のコマンドを実行して下さい

```sh
~$ sudo apt update -y
~$ sudo apt install net-tools
~$ sudo /opt/lampp/lampp restart
Restarting XAMPP for Linux 8.1.5-0...
XAMPP: Stopping Apache...ok.
XAMPP: Stopping MySQL...ok.
XAMPP: Stopping ProFTPD...not running.
XAMPP: Starting Apache...ok.
XAMPP: Starting MySQL...ok.
XAMPP: Starting ProFTPD...fail.
Contents of "/opt/lampp/var/proftpd/start.err":
2022-05-04 16:45:01,700 ubu-serv proftpd[2149]: fatal: unknown configuration directive 'function' on line 44 of '/opt/lampp/etc/proftpd.conf'
```

### ProFTPDが起動しない

```sh
~$ sudo /opt/lampp/lampp status
Version: XAMPP for Linux 8.1.5-0
Apache is running.
MySQL is running.
ProFTPD is not running.
```

これも無視しても問題無いかと思います．気になる場合は以下のようにファイルを編集して下さい

```sh
~$ sudo nano /opt/lampp/etc/proftpd.conf
```

```sh
# 以下の部分を全てコメントアウトして下さい（これはコメントアウトした状態です）
#UserPassword daemon <?
#       function make_seed() {
#           list($usec, $sec) = explode(' ', microtime());
#           return (float) $sec + ((float) $usec * 100000);
#       }
#       srand(make_seed());
#       $random=rand();
#       $chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.>
#       $salt=substr($chars,$random % 64,1).substr($chars,($random/64)%64,1);
#       $pass=$argv[1];
#       $crypted = crypt($pass,$salt);
#       echo $crypted."
#";
#?>
```

LAMPPの再起動

```sh
~$ sudo /opt/lampp/lampp restart
Restarting XAMPP for Linux 8.1.5-0...
XAMPP: Stopping Apache...ok.
XAMPP: Stopping MySQL...ok.
XAMPP: Stopping ProFTPD...not running.
XAMPP: Starting Apache...ok.
XAMPP: Starting MySQL...ok.
XAMPP: Starting ProFTPD...ok.
```

## 2. Composer のインストール

phpのパッケージ管理ツールである「Compoer」をインストールする手順です

### パッケージの更新

```sh
$ cd ~
~$ sudo apt update -y  
```

### phpのインストール

```
~$ sudo apt install -y php libapache2-mod-php php-gd php-xml php-cli php-mbstring php-soap php-xmlrpc php-zip
```

### Composerをダウンロードしてphpで実行

```sh
~$ curl -sS https://getcomposer.org/installer | php
```

コマンド実行後，`composer.phar` がダウンロードされます

### Composerを利用できる様に設定

```sh
~$ sudo mv composer.phar /usr/local/bin/composer
~$ sudo chmod +x /usr/local/bin/composer
~$ source ~/.bashrc
```

### 確認

```sh
~$ composer -V
Composer version 2.3.6 2022-06-01 21:57:13
```

このように表示されれば成功です．

## 3. Node.js・npm のインストール

node.js・npmコマンドは，Laravelで使用するた導入します．

### nコマンドの導入

```sh
$ sudo apt install -y nodejs npm
```

コマンド実行後，ピンク色の対話画面が出てきますがそのまま `Tab` でカーソルを移動させ， `OK` を選択して下さい．

```sh
$ sudo npm install n -g
```

### 推奨版（lts）のインストール

```sh
$ sudo n lts
```

### 確認

```sh
$ npm -v
8.11.0
$ node -v
v16.15.1
$ n -V
v8.2.0
```

このように表示されればインストール完了です

## 4. リポジトリのクローンからサイトの表示まで

### リポジトリのクローン

fork等した場合は以下のクローン元は変更して下さい

#### httpsの場合

```sh
$ cd ~
~$ git clone https://github.com/hxs-mini2/Laravel_Forum-B.git
```

#### sshの場合

鍵の作成からの手順です．鍵の作成・githubへのキーの追加が完了している場合は適宜手順を飛ばして下さい

1. 鍵の生成

```sh
$ ~cd
~$ ssh-keygen -b 4096
Generating public/private rsa key pair.
Enter file in which to save the key (/home/pr0gr/.ssh/id_rsa):     # 何も入力せずにEnter
Enter passphrase (empty for no passphrase):     # 何も入力せずにEnter
Enter same passphrase again: # 何も入力せずにEnter
Your identification has been saved in /home/pr0gr/.ssh/id_rsa
Your public key has been saved in /home/pr0gr/.ssh/id_rsa.pub
The key fingerprint is:
```

2. ssh-rsaも含めて全てコピー

```sh
~$ cat .ssh/id_rsa.pub
ssh-rsa <省略>
```

3. githubへアクセスし，アカウントのSettingsからSSH and GPG keysへ移動
4. New SSH keyをクリック
5. Titleは分かりやすいもの・Keyはコピーしたものを貼り付け
6. Add SSH key

これでsshでのcloneが使用可能になりました．
初回のみ質問がされます．

```sh
~$ git clone git@github.com:hxs-mini2/Laravel_Forum-B.git
<省略>
Are you sure you want to continue connecting (yes/no/[fingerprint])? yes     # yes を入力してEnter
```

clone完了後，`Laravel_Forum-B`フォルダ（プロジェクト）が作成されています

### プロジェクトの移動

プロジェクトをドキュメントルートへ移動して，ブラウザからアクセスできるようにします（現状では動きません）

```sh
~$ sudo mv Laravel_Forum-B /opt/lampp/htdocs
~$ cd /opt/lampp/htdocs/Laravel_Forum-B
```

### ドキュメントルートの変更

ドキュメントルートを変更しなければ動かないものがあるので，変更します．

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ sudo nano /opt/lampp/etc/httpd.conf
```

```sh
# DocumentRoot "/opt/lampp/htdocs"    # コメントアウト
# <Directory "/opt/lampp/htdocs">    # コメントアウト
DocumentRoot "/opt/lampp/htdocs/Laravel_Forum-B/public"    # 追記
<Directory "/opt/lampp/htdocs/Laravel_Forum-B/public">    # 追記
```

ここではコメントアウト・追記を行いましたが，`Laravel_Forum-B/public`を付け足すのでも問題ありません

### 変更の適応

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ sudo /opt/lampp/lampp restart
```

この状態で http://<IPアドレス>/ へアクセスして，「このページは動作していません」と表示されていれば成功です．

### vendarディレクトリの作成

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ composer install
```

`Package manifest generated successfully.`と表示されていれば完了です．

### npm run dev コマンドを使用可能に

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ npm install
```

### .envファイルの作成

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ cp .env.example .env
```

`.env`ファイルが作成されたと思います．

### よく分かりませんがkeyの作成

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ php artisan key:generate
Application key set successfully.
```

### データベースの作成

1. phpmyadminにアクセスし，左の新規作成をクリックします
2. Laravelの機能が使用するデータベースを作成します．任意のデータベース名を入力し作成をクリックします
3. 掲示板用のデータベースを作成します．こちらもデータベース名は任意です

### .envファイルの編集

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ nano .env
```

以下の箇所を書き換えます．

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<メインデータベース名>
DB_DATABASE_KEIZIBAN=<掲示板用データベース名>
DB_USERNAME=root
DB_PASSWORD=<phpmyadminのパスワード>
```

### 使用するテーブルの作成

使用するテーブルを自動生成します．以下のコマンドを実行して下さい

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ sudo apt install -y php-mysql
```

コマンド実行後，ピンク色の対話画面が出てきますがそのまま `Tab` でカーソルを移動させ， `OK` を選択して下さい．

その後，以下のコマンドを実行するとテーブルが自動生成されます．

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ sudo php artisan migrate
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (42.95ms)
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table (49.99ms)
Migrating: 2014_10_12_200000_add_two_factor_columns_to_users_table
Migrated:  2014_10_12_200000_add_two_factor_columns_to_users_table (14.07ms)
Migrating: 2016_01_04_173148_create_admin_tables
Migrated:  2016_01_04_173148_create_admin_tables (473.45ms)
Migrating: 2019_08_19_000000_create_failed_jobs_table
Migrated:  2019_08_19_000000_create_failed_jobs_table (58.19ms)
Migrating: 2019_12_14_000001_create_personal_access_tokens_table
Migrated:  2019_12_14_000001_create_personal_access_tokens_table (77.10ms)
Migrating: 2022_04_30_125059_create_sessions_table
Migrated:  2022_04_30_125059_create_sessions_table (145.04ms)
Migrating: 2022_05_05_112244_create_hub_table
Migrated:  2022_05_05_112244_create_hub_table (26.38ms)
Migrating: 2022_05_09_134146_create_likes_table
Migrated:  2022_05_09_134146_create_likes_table (27.73ms)
Migrating: 2022_05_25_073001_create_access_logs_table
Migrated:  2022_05_25_073001_create_access_logs_table (29.03ms)
```

### ログファイルを開けるように

現段階で http://<IPアドレス>/ へアクセスすると，`The stream or file "/opt/lampp/htdocs/Laravel_Forum-B/storage/logs/laravel.log" could not be opened in append mode <省略>` とエラーが出力されていると思います．以下のコマンドを実行して下さい

```sh
/opt/lampp/htdocs/Laravel_Forum-B$ chmod 777 -R storage
```

これで，HxSコンピュータ部のホームページが表示される様になります．

## 5. アカウント新規登録時のメール検証機能まで

メール検証の送り送り元アカウント・メール送信（Postfix）機能を構築します

### アプリパスワードの生成

1. googleアカウントの作成をしてください（既存のものを利用する場合は不要です）
2. 作成した・既存のアカウントを利用してGoogle Chromeなどでログインして下さい
3. そのアカウントの2段階認証を有効にしてください
4. セキュリティに移動
5. アプリ パスワードに移動
6. アプリを選択でその他を選び，アプリパスワードの名前を入力（なんでも）
7. 生成されたパスワードをコピー
8. 完了をクリック

アプリパスワードは複数回使用するため，環境構築が終了するまではどこかにメモをしておいてください

### Postfixをインストールする

```sh
$ sudo apt install -y postfix bsd-mailx libsasl2-modules
```

コマンド実行後，いくつかの設定を行います．その手順は以下の通りです．

1. いろいろ書かれていますが，ボタンがそれしかないので `OK`
2. `Internet with smarthost` を選択
3. System mail nameはそのままEnter
4. SMTP relay hostは`[smtp.gmail.com]:587`を入力

ここで一旦画面が閉じます．

その後， `Which services should be restarted?` と聞かれますが，何も選択せず `OK` （各項目の意味は分からないので必要に応じて選択して下さい．多分問題ありません．多分...）

### アプリパスワードの適応１

```sh
$ cd /etc/postfix
/etc/postfix$ sudo nano sasl_passwd
```

以下の内容を追記

```sh
[smtp.gmail.com]:587 <アカウント名>@gmail.com:<アプリパスワード>
```

### アプリパスワードの適応２

```sh
/etc/postfix$ sudo chmod 600 sasl_passwd
/etc/postfix$ sudo postmap /etc/postfix/sasl_passwd
```

何も出力されずに，`sasl_passwd.db`が生成されていれば成功です．

### main.cfの編集

```sh
/etc/postfix$ sudo nano main.cf
```

一番下に，以下の内容を追記

```sh
smtp_use_tls = yes
smtp_sasl_auth_enable = yes
smtp_sasl_password_maps = hash:/etc/postfix/sasl_passwd
smtp_sasl_tls_security_options = noanonymous
inet_protcols=ipv4
```

### 設定の反映とテスト

```sh
/etc/postfix$ sudo systemctl restart postfix
/etc/postfix$ echo "Test message" | mail <送信先アドレス>
```

送信が確認出来た場合は次へ進んでください

### php.iniの編集

```sh
$ cd /opt/lampp/etc
/opt/lampp/etc$ sudo nano php.ini
```

php.iniの`[mail function]`内に，以下の内容を追記してください

```sh
[mail function]
sendmail_path = /usr/sbin/sendmail -t -i
```

### .envファイルの編集

```sh
$ cd /opt/lampp/htdocs/Laravel_Forum-B/
/opt/lampp/htdocs/Laravel_Forum-B$ nano .env
```

以下の箇所を変更して下さい

ただし `MAIL_FROM_NAME=` の欄は，`.env` ファイル一番上の `APP_NAME=` の欄を書き換える事をオススメします．この場合は `MAIL_FROM_NAME=` の欄は書き換え無しです． 

`APP_NAME=` の欄書き換えにより，ブラウザのタイトル欄もそれに変わる用です．日本語使用出来ました．

```sh
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=<アカウント名>@gmail.com
MAIL_PASSWORD=<アプリパスワード>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=<アカウント名>@gmail.com
MAIL_FROM_NAME=<ここでメール受信時の名前を決められます>
```

### メール検証テスト

1. http://<IPアドレス>へアクセス
2. 掲示板へ移動し，新規登録はコチラをクリックします．
3. 学生番号は自分のもの．それ以外は適当に入力します．
4. アカウント作成をクリック
5. 大学アカウントのメールボックス（の迷惑メール）を確認
6. メールの「検証する」をクリック（迷惑メールの場合：一番上のURLをコピー・ブラウザに張り付けてEnter）
7. ダッシュボードへ移動できれば環境構築完了

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