FROM php:8.2-fpm

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y nano \
    && docker-php-ext-install mysqli

ARG PROJECT_NAME=DataForge

WORKDIR /var/www/${PROJECT_NAME}

USER comp
