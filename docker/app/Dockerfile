FROM ubuntu:22.04

WORKDIR /usr/src/app

ENV WORKDIR=/usr/src/app
ENV LANG=C.UTF-8

RUN \
    # Install Required Linux Packages
    apt-get update; \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
        sudo \
        nginx \
        ca-certificates \
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
        php-fpm \
        php-ctype \
        php-curl \
        php-dom \
        php-fileinfo \
        php-mbstring \
        php-pdo \
        php-tokenizer \
        php-xml \
        php-bcmath \
        php-exif \
        php-gd \
        php-mysqli \
        php-opcache \
        php-zip \
        php-redis \
        postfix \
    ; \
    apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* \
    ; \
    \
    useradd -m -s /bin/bash dev ; \
    usermod -aG sudo dev \
    ; \
    \
    echo "" >> /etc/sudoers ; \
    echo "# Don't require password for sudo command for dev user" >> /etc/sudoers ; \
    echo "dev ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Enabling composer and npm in containers
COPY --from=node:18.16.0-slim /usr/local /usr/local
COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer

COPY ./docker/app/nginx/default /etc/nginx/sites-available/default
COPY ./docker/app/php/www.conf /etc/php/8.1/fpm/pool.d/www.conf
COPY ./docker/app/php/php.ini /etc/php/8.1/fpm/php.ini
COPY ./docker/app/php/php.ini /etc/php/8.1/cli/php.ini
COPY ./docker/app/postfix/main.cf /etc/postfix/main.cf
