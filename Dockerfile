FROM node:21.7.3-slim

FROM  dunglas/frankenphp:1.9.0-builder-php8.4-bookworm

LABEL authors="Cybrarist"

ENV SERVER_NAME=":80"
ENV FRANKENPHP_CONFIG="worker /app/public/index.php"
ENV FRANKEN_HOST="localhost"

RUN apt update && apt install -y supervisor  \
        libbz2-dev \
        libzip-dev \
        libmcrypt-dev \
        libicu-dev \
        gnupg \
        ca-certificates \
        libx11-xcb1 \
        && apt-get clean


RUN install-php-extensions @composer

RUN docker-php-ext-install   pcntl \
        opcache \
        pdo_mysql \
        pdo \
        bz2 \
        intl \
        bcmath \
        zip



RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
 && apt-get update && apt-get install -y nodejs \
 && npm install -g npm@latest



COPY ./docker/base_supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY . /app

WORKDIR /app

RUN chmod +x /app/docker/*


EXPOSE 80 443 2019 8080


ENTRYPOINT ["docker/entrypoint.sh"]
