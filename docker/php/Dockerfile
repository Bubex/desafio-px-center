FROM php:8.2-fpm

# Instalar dependências e extensões PHP
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpq-dev \
    libssl-dev \
    libxml2-dev \
    libzip-dev \
    pkg-config \
    unzip \
    && apt-get clean \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    zip \
    mbstring \
    xml \
    pcntl \
    opcache
    && pecl install redis
    && docker-php-ext-enable redis

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini