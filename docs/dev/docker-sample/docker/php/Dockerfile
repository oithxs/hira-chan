FROM php:8.0-fpm

COPY php.ini /usr/local/etc/php/

RUN apt-get update && apt install -y \
    zlib1g-dev \
    libzip-dev \
    vim \
    bsd-mailx \
    libsasl2-modules \
    && docker-php-ext-install zip pdo_mysql opcache

RUN DEBIAN_FRONTEND=noninteractive apt-get install postfix -y

WORKDIR /var/www

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ENV COMPOSER_HOME /composer

ENV PATH $PATH:/composer/vendor/bin

RUN composer global require "laravel/installer"
