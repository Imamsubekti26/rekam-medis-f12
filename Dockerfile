# =================================================================
# Tahap 1: Install Dependensi PHP (Composer)
# Output dari stage ini adalah folder /app/vendor yang sudah jadi.
# =================================================================
FROM composer:2.7.2 AS vendor_base
WORKDIR /app
COPY database/ database/
COPY app/Helpers app/Helpers
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --optimize-autoloader


# =================================================================
# Tahap 2: Build Aset Frontend (Bun)
# Stage ini menggunakan Bun, dan akan "mengimpor" vendor dari tahap 1.
# =================================================================
FROM node:20-alpine AS assets_base
WORKDIR /app

# Copy file-file untuk instalasi dependensi frontend
COPY package.json package-lock.json vite.config.js ./
RUN npm install

# Salin folder vendor dari tahap sebelumnya agar bisa diakses oleh proses build.
COPY --from=vendor_base /app/vendor /app/vendor

# Copy sisa folder 'resources' untuk proses build
COPY resources/ resources/

# Jalankan build. Sekarang bun/vite bisa menemukan file css di dalam vendor/.
RUN npm run build


# =================================================================
# Tahap 3: Image Final (PHP-FPM + Nginx)
# Stage ini adalah image produksi yang bersih dan ramping.
# =================================================================
FROM php:8.3-fpm-alpine

# Install HANYA dependensi yang dibutuhkan untuk menjalankan aplikasi.
# Termasuk postgresql-dev untuk kompilasi ekstensi.
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev

# Install ekstensi PHP yang dibutuhkan.
# Perintah ini sekarang akan berhasil karena postgresql-dev sudah diinstal.
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd

# Copy file-file konfigurasi
COPY deploy/php-fpm-pool.conf /usr/local/etc/php-fpm.d/zz-render.conf
COPY deploy/nginx.conf /etc/nginx/nginx.conf

# Set working directory final
WORKDIR /var/www

# Salin seluruh basis kode aplikasi dari direktori build lokal
COPY . /var/www

# "TARIK 1-1 FILE-FILE TADI"
# Timpa dengan artefak yang sudah jadi dari stage-stage sebelumnya.
COPY --from=vendor_base /app/vendor /var/www/vendor
COPY --from=assets_base /app/public/build /var/www/public/build

# Setup permissions untuk user www-data
RUN chown -R www-data:www-data /var/www

# Siapkan entrypoint script
COPY deploy/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port
EXPOSE 80

# Jalankan aplikasi
CMD ["/entrypoint.sh"]
