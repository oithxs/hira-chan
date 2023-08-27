FROM ubuntu:22.04

WORKDIR /usr/src/app

ENV WORKDIR=/usr/src/app
ENV LANG="C.UTF-8"
ENV TZ="Asia/Tokyo"

RUN \
    # Install Required Linux Packages
    apt-get update; \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
        sudo \
        ca-certificates \
        curl \
        default-mysql-client \
        git \
        libfreetype6-dev \
        libjpeg-dev \
        libpng-dev \
        libsasl2-modules \
        libwebp-dev \
        libzip-dev \
        openssh-client \
        screen \
        unzip \
        wget \
        zlib1g-dev \
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
    # キャッシュ削除
    apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* \
    ; \
    \
    # 開発ユーザーの作成
    useradd -m -s /bin/bash dev ; \
    usermod -aG sudo dev \
    ; \
    \
    # 開発ユーザに sudo 権限を付与
    echo "" >> /etc/sudoers ; \
    echo "# Don't require password for sudo command for dev user" >> /etc/sudoers ; \
    echo "dev ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# npm および composer のコピー
COPY --from=node:18.16.0-slim /usr/local /usr/local
COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer

# 設定ファイルをコピー
COPY ./docker/app/php/php.ini /etc/php/8.1/cli/php.ini
COPY ./docker/app/postfix/main.cf /etc/postfix/main.cf

# コンテナ作成時に実行するスクリプトをコピー
COPY ./docker/app/bin/containerCreate.sh /usr/local/bin/containerCreate.sh

# コンテナ起動時に実行するスクリプトをコピー
COPY ./docker/app/bin/containerStart.sh /usr/local/bin/containerStart.sh

# コピーしたスクリプトに実行権限を付与
RUN chmod +x /usr/local/bin/containerCreate.sh ; \
    chmod +x /usr/local/bin/containerStart.sh

# 開発ユーザーに切り替え
USER dev

CMD ["/bin/bash", "-c", "containerStart.sh"]
