FROM php:8.2-fpm-alpine3.17

RUN apk add --no-cache openssl bash nodejs npm postgresql-dev --update linux-headers

RUN docker-php-ext-install pdo pdo_pgsql bcmath

RUN docker-php-ext-enable pdo_pgsql

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

WORKDIR /var/www
RUN rm -rf /var/www/html
RUN ln -s public html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.5.5

EXPOSE 9000
ENTRYPOINT [ "php-fpm" ]