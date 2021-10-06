FROM php:8.0-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get -y update
RUN apt-get -y install git

WORKDIR  /srv/src/readdle

EXPOSE 9000