FROM php:8.1.4-fpm

WORKDIR /usr/src/app

ENV WORKDIR=/usr/src/app
ENV LANG=C.UTF-8

# Faster apt commands
RUN sed -i 's@archive.ubuntu.com@ftp.jaist.ac.jp/pub/Linux@g' /etc/apt/sources.list

RUN \
    # # Install Required Linux Packages
    apt-get update; \
    apt-get install -y --no-install-recommends \
    default-mysql-client \
    git \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    openssh-client \
    screen \
    unzip \
    wget \
    zlib1g-dev \
    ; \
    DEBIAN_FRONTEND=noninteractive apt-get install postfix -y \
    ; \
    apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* \
    ; \
    # # Install Required PHP extensions
    git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis; \
    docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp; \
    docker-php-ext-install \
    bcmath \
    exif \
    gd \
    mysqli \
    opcache \
    pdo_mysql \
    redis \
    zip \
    ; \
    \
    useradd -m -s /bin/bash dev

# Enabling composer and npm in containers
COPY --from=node:16.18.0-slim /usr/local /usr/local
COPY --from=composer:2.4.3 /usr/bin/composer /usr/bin/composer

# Place configuration files in containers
COPY ./docker/app/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/app/postfix/main.cf /etc/postfix/main.cf
