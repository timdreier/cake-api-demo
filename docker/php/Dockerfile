FROM php:8.3-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y git libzip-dev

RUN docker-php-ext-install mysqli pdo pdo_mysql zip
RUN docker-php-ext-enable mysqli