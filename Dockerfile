FROM php:7.4-fpm-alpine

RUN apk update --no-cache \
&& apk add \
icu-dev \
oniguruma-dev \
tzdata

RUN docker-php-ext-install intl

RUN docker-php-ext-install pcntl

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install php-curl

RUN rm -rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN composer install

CMD ["php-fpm"]
