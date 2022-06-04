#!/bin/bash

if [ "$EUID" -ne 0 ]; then
	echo "Please run as root."
	exit 1
fi

ls /etc | grep postfix >/dev/null 2>&1
if [ $? -ne 0 ]; then
	echo "Postfix is not installed"
	exit 1
fi

# 入力が必要な物を最初に

echo -n "個人ユーザ名："
read personal_user
echo -n "アプリ名："
read Application_name
echo "データベースを2つ作成します．データベース名を入力してください"
echo "※「_」は使用可能ですが，「-」は使用できません"
echo -n "メインデータベース："
read main_database
echo -n "掲示板用データベース："
read keiziban_database
echo "MySQL/phpMyAdmin関連のパスワードを設定します"
read -sp "Password: " mysql_pass
echo 
echo "メール送信関連の設定をします"
echo -n "アカウント名(@以下不要)："
read account_name
read -sp "Application Password: " Application_pass
echo

cd /home/$personal_user

# 必要なパッケージを一括インストール

apt update -y
apt install -y net-tools expect php libapache2-mod-php php-gd php-xml php-cli php-mbstring php-soap php-xmlrpc php-zip nodejs npm php-mysql

# LAMPPのインストール

wget https://www.apachefriends.org/xampp-files/8.1.5/xampp-linux-x64-8.1.5-0-installer.run
chmod +x xampp-linux-x64-8.1.5-0-installer.run
yes | ./xampp-linux-x64-8.1.5-0-installer.run

# apache2を停止

systemctl disable apache2
systemctl stop apache2.service

# phpMyAdminを使用可能に

sed -ie 's/Require local/Require all granted/' /opt/lampp/etc/extra/httpd-xampp.conf >/dev/null 2>&1

# LAMPP起動時のエラーを解決

sed -ie '/UserPassword daemon <?/,/?>/s|^|#|' /opt/lampp/etc/proftpd.conf >/dev/null 2>&1

# LAMPPを起動

/opt/lampp/lampp stop >/dev/null 2>&1
/opt/lampp/lampp start >/dev/null 2>&1
/opt/lampp/lampp restart >/dev/null 2>&1

# データベースの作成

echo "CREATE DATABASE $main_database" | /opt/lampp/bin/mysql -u root
echo "CREATE DATABASE $keiziban_database" | /opt/lampp/bin/mysql -u root

# LAMPPのセキュリティ

command="/opt/lampp/lampp security"

expect -c "
	spawn $command
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
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
source ~/.bashrc

# node.js関連のインストール

npm install n -g
n lts

# リポジトリの移動

mv Laravel_Forum-B /opt/lampp/htdocs
cd /opt/lampp/htdocs/Laravel_Forum-B

# ドキュメントルート変更

sed -ie 's/DocumentRoot "\/opt\/lampp\/htdocs"/DocumentRoot "\/opt\/lampp\/htdocs\/Laravel_Forum-B\/public"/' /opt/lampp/etc/httpd.conf
sed -ie 's/<Directory "\/opt\/lampp\/htdocs">/<Directory "\/opt\/lampp\/htdocs\/Laravel_Forum-B\/public">/' /opt/lampp/etc/httpd.conf

# リポジトリの公開準備

sudo su - $personal_user <<EOF
cd /opt/lampp/htdocs/Laravel_Forum-B
composer install
npm install
EOF

cp .env.example .env
chmod g+w .env
chown $personal_user:$personal_user .env
php artisan key:generate

sed -ie "s/APP_NAME=Laravel/APP_NAME=$Application_name/" .env
sed -ie "s/DB_DATABASE=laravel/DB_DATABASE=$main_database/" .env
sed -ie "s/DB_DATABASE_KEIZIBAN=/DB_DATABASE_KEIZIBAN=$keiziban_database/" .env
sed -ie "s/DB_PASSWORD=/DB_PASSWORD=$mysql_pass/" .env

chmod 777 -R storage

php artisan migrate

# メールアプリパスワードの適応

cd /etc/postfix
echo "[smtp.gmail.com]:587 $account_name@gmail.com:$Application_pass" > sasl_passwd
chmod 600 sasl_passwd
postmap /etc/postfix/sasl_passwd

# main.cfの編集

cat <<EOF >>main.cf
	smtp_use_tls = yes
	smtp_sasl_auth_enable = yes
	smtp_sasl_password_maps = hash:/etc/postfix/sasl_passwd
	smtp_sasl_tls_security_options = noanonymous
	inet_protcols=ipv4
EOF

# 設定の反映

systemctl restart postfix

# php.iniの編集

sed -ie 's/;sendmail_path =/sendmail_path = \/usr\/sbin\/sendmail -t -i/' /opt/lampp/etc/php.ini

# .envファイルの編集

cd /opt/lampp/htdocs/Laravel_Forum-B
sed -ie 's/MAIL_HOST=mailhog/MAIL_HOST=smtp.gmail.com/' .env
sed -ie 's/MAIL_PORT=1025/MAIL_PORT=587/' .env
sed -ie "s/MAIL_USERNAME=null/MAIL_USERNAME=$account_name@gmail.com/" .env
sed -ie "s/MAIL_PASSWORD=null/MAIL_PASSWORD=$Application_pass/" .env
sed -ie 's/MAIL_ENCRYPTION=null/MAIL_ENCRYPTION=tls/' .env
sed -ie "s/MAIL_FROM_ADDRESS=null/MAIL_FROM_ADDRESS=$account_name@gmail.com/" .env

# LAMPP の起動

rm .enve
/opt/lampp/lampp restart

exit 0