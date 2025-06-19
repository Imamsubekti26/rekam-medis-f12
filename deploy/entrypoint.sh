#!/bin/sh

# Bagian ini berjalan SETELAH Render menyuntikkan variabel lingkungan.
# Ini adalah tempat yang tepat untuk membuat cache.
echo "Clearing and caching configuration..."
php artisan config:clear
php artisan optimize

# Start PHP-FPM in background
php-fpm &

# Start Nginx in foreground
echo "Starting Nginx..."
nginx -g "daemon off;"
