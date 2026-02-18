FROM php:8.2-apache

RUN apt-get update && apt-get install -y unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html/

EXPOSE 80
