FROM php:8.1.4-fpm

WORKDIR /usr/src/app

ENV LANG=C.UTF-8

RUN sed -i 's@archive.ubuntu.com@ftp.jaist.ac.jp/pub/Linux@g' /etc/apt/sources.list

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    openssh-client \
    zlib1g-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    default-mysql-client \
    gnupg \
    bsd-mailx \
    libsasl2-modules \
    && DEBIAN_FRONTEND=noninteractive apt-get install postfix -y \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo_mysql zip opcache gd exif \
    && useradd -m -s /bin/bash dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=node:16.18.0-slim /usr/local /usr/local
COPY --from=composer:2.4.3 /usr/bin/composer /usr/bin/composer
COPY ./docker/app/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/app/postfix/main.cf /etc/postfix/main.cf
