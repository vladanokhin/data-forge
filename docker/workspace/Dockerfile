FROM php:8.2-fpm

ARG PROJECT_NAME=data-forge

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y nano git zip unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/${PROJECT_NAME}
