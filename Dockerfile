FROM php:8-fpm-alpine3.15 as base

RUN apk --update add \
    alpine-sdk \
    linux-headers \
    openssl-dev \
    php8-pear \
    php8-dev

RUN docker-php-ext-install pdo_mysql

RUN rm -rf /var/cache/apk/*

EXPOSE 9000

FROM base as development

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG USER=developer
ARG GROUP=developer

ENV TZ ${TZ}

RUN pecl channel-update pecl.php.net

RUN apk add --update --upgrade tzdata autoconf g++ make \
    && ln -s /usr/share/zoneinfo/$TZ /etc/localtime \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN addgroup -g ${GROUP_ID} ${GROUP} \
    && adduser -G ${GROUP} -u ${USER_ID} ${USER} -D
