FROM php:8.2-fpm-alpine
RUN docker-php-ext-install mysqli pdo pdo_mysql
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer