# Stage 1: Composer dependencies
FROM composer:2.8.5 AS composer

WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Application image
FROM php:8.3.21-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath

# Setup working directory
WORKDIR /var/www

# Copy app source code
COPY . .

# Copy composer dependencies from builder stage
COPY --from=composer /app/vendor ./vendor

# Laravel optimization commands
RUN php artisan optimize

# Setup permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 storage bootstrap/cache

# Copy file konfigurasi PHP-FPM dan Nginx
COPY deploy/php-fpm-pool.conf /usr/local/etc/php-fpm.d/zz-render.conf
COPY deploy/nginx.conf /etc/nginx/nginx.conf

# Entrypoint script to launch both PHP-FPM and Nginx
COPY deploy/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

CMD ["/entrypoint.sh"]
