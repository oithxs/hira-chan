FROM php:8.1.4-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    vim \
    bsd-mailx \
    libsasl2-modules \
    default-mysql-client \
    gnupg

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install mysqli pdo_mysql zip opcache gd exif

RUN DEBIAN_FRONTEND=noninteractive apt-get install postfix -y

WORKDIR /var/www/Laravel_Forum-B
