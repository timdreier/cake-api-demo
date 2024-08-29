FROM php:8.3-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli