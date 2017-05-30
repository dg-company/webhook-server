FROM php:7.1-apache

RUN a2enmod rewrite

COPY src /var/www/html