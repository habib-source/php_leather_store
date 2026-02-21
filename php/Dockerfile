FROM php:8.5-apache

RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y libpq-dev libonig-dev\
	&& docker-php-ext-install mbstring pdo pdo_pgsql
