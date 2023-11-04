FROM php:8.2-fpm

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y nano \
    && docker-php-ext-install mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG PROJECT_NAME=data-forge

WORKDIR /var/www/${PROJECT_NAME}

USER www-data
