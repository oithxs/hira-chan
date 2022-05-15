#!/bin/bash

if [ "$EUID" -ne 0 ]; then
	:
else 
	echo "スーパユーザでは実行しないで下さい"
	exit 1
fi

# 入力が必要な物を最初に

read -sp "[sudo] password for $USER: " sudo_pass
echo "データベースを2つ作成します．データベース名を入力してください"
echo "※「_」は使用可能ですが，「-」は使用できません"
echo -n "メインデータベース："
read main_database
echo -n "掲示板用データベース："
read keiziban_database
echo "MySQL/phpMyAdmin関連のパスワードを設定します"
read -sp "Password: " mysql_pass
echo 

cd

# 必要なパッケージを一括インストール

sudo apt update -y
sudo apt install -y net-tools expect php libapache2-mod-php php-gd php-xml php-cli php-mbstring php-soap php-xmlrpc php-zip nodejs npm php-mysql

# LAMPPのインストール

wget https://www.apachefriends.org/xampp-files/8.1.5/xampp-linux-x64-8.1.5-0-installer.run
chmod +x xampp-linux-x64-8.1.5-0-installer.run
yes | sudo ./xampp-linux-x64-8.1.5-0-installer.run

# apache2を停止

sudo systemctl disable apache2
sudo systemctl stop apache2.service

# phpMyAdminを使用可能に

sudo sed -ie 's/Require local/Require all granted/' /opt/lampp/etc/extra/httpd-xampp.conf >/dev/null 2>&1

# LAMPP起動時のエラーを解決

sudo sed -ie '/UserPassword daemon <?/,/?>/s|^|#|' /opt/lampp/etc/proftpd.conf >/dev/null 2>&1

# LAMPPを起動

sudo /opt/lampp/lampp stop
sudo /opt/lampp/lampp start
sudo /opt/lampp/lampp restart

# データベースの作成

echo "CREATE DATABASE $main_database" | /opt/lampp/bin/mysql -u root
echo "CREATE DATABASE $keiziban_database" | /opt/lampp/bin/mysql -u root

# LAMPPのセキュリティ

command="/opt/lampp/lampp security"

expect -c "
	spawn $command
	expect \"password\"
	send \"$sudo_pass\n\"
	expect \"yes\"
	send \"no\n\"
	expect \"yes\"
	send \"yes\n\"
	expect \"Password\"
	send \"$mysql_pass\n\"
	expect \"Password\"
	send \"$mysql_pass\n\"
	expect \"yes\"
	send \"yes\n\"
	expect \"Password\"
	send \"$mysql_pass\n\"
	expect \"Password\"
	send \"$mysql_pass\n\"
	expect \"yes\"
	send \"yes\n\"
	expect \"Password\"
	send \"$mysql_pass\n\"
	expect \"Password\"
	send \"$mysql_pass\n\"
	exit 0
"

# Composer のインストール

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
source ~/.bashrc

# node.js関連のインストール

sudo npm install n -g
sudo n lts

# リポジトリのクローン

sudo mv Laravel_Forum-B /opt/lampp/htdocs
cd /opt/lampp/htdocs/Laravel_Forum-B

# ドキュメントルート変更

sudo sed -ie 's/DocumentRoot "\/opt\/lampp\/htdocs"/DocumentRoot "\/opt\/lampp\/htdocs\/Laravel_Forum-B\/public"/' /opt/lampp/etc/httpd.conf
sudo sed -ie 's/<Directory "\/opt\/lampp\/htdocs">/<Directory "\/opt\/lampp\/htdocs\/Laravel_Forum-B\/public">/' /opt/lampp/etc/httpd.conf

# リポジトリの公開準備

composer install
npm install

cp .env.example .env
php artisan key:generate

sed -ie "s/DB_DATABASE=laravel/DB_DATABASE=$main_database/" .env
sed -ie "s/DB_DATABASE_KEIZIBAN=/DB_DATABASE_KEIZIBAN=$keiziban_database/" .env
sed -ie "s/DB_PASSWORD=/DB_PASSWORD=$mysql_pass/" .env

chmod 777 -R storage

sudo php artisan migrate

# LAMPP の起動

sudo /opt/lampp/lampp restart

exit 0