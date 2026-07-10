# syntax=docker/dockerfile:1

# Composer stage: installs the PHP production dependencies in an isolated layer.
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader \
    --no-scripts

COPY . .

RUN composer dump-autoload \
    --no-dev \
    --optimize

# Node/Vite stage: builds the frontend assets and keeps Node out of the runtime image.
FROM node:22-bookworm-slim AS assets

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./

RUN npm run build

# Runtime stage: serves Laravel through PHP 8.3 with Apache.
FROM php:8.3-apache AS runtime

WORKDIR /var/www/html

# Installs only the system packages needed to compile required PHP extensions.
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libcurl4-openssl-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        curl \
        mbstring \
        pdo_mysql \
        xml \
        zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enables Apache URL rewriting and points the web root to Laravel's public directory.
RUN a2enmod rewrite \
    && sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
        /etc/apache2/sites-available/000-default.conf \
        /etc/apache2/apache2.conf

# Copies the application source without local dependencies or secrets, as filtered by .dockerignore.
COPY . .

# Copies optimized Composer dependencies and the Vite production build from previous stages.
COPY --from=composer /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Discovers Laravel packages after the production dependencies are available.
RUN php artisan package:discover --ansi

# Prepares Laravel writable directories for the Apache user.
RUN mkdir -p \
        storage/app/public \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
