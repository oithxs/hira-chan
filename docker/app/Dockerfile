FROM php:8.1.4-fpm

WORKDIR /usr/src/app

ENV LANG=C.UTF-8

RUN sed -i 's@archive.ubuntu.com@ftp.jaist.ac.jp/pub/Linux@g' /etc/apt/sources.list

RUN apt-get update; \
    apt-get install -y --no-install-recommends \
        git \
        openssh-client \
        default-mysql-client \
        libfreetype6-dev \
        libjpeg-dev \
        libpng-dev \
        libzip-dev \
        zlib1g-dev \
    ; \
    \
    DEBIAN_FRONTEND=noninteractive apt-get install postfix -y \
    ; \
	docker-php-ext-configure gd --with-freetype --with-jpeg; \
	docker-php-ext-install \
		bcmath \
		exif \
		gd \
		mysqli \
		opcache \
		pdo_mysql \
		zip \
    ; \
    \
    useradd -m -s /bin/bash dev \
    ; \
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	apt-get clean; \
	rm -rf /var/lib/apt/lists/*;

COPY --from=node:16.18.0-slim /usr/local /usr/local
COPY --from=composer:2.4.3 /usr/bin/composer /usr/bin/composer
COPY ./docker/app/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/app/postfix/main.cf /etc/postfix/main.cf