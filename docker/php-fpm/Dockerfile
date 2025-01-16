FROM php:7.4.14-fpm

# Install dependencies
RUN apt-get update && apt-get -y install gnupg2 \
&& apt-key update \
&& apt-get update \
&& apt-get -y install g++ git curl \
    libzip-dev zlib1g-dev libpq-dev\
    openssh-client nano unzip libcurl4-openssl-dev \
    libssl-dev --no-install-recommends default-mysql-client \
    nano
# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_pgsql
# Set working directory
WORKDIR /var/www
#
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
