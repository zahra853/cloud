#!/bin/bash

# Navigate to the app directory
cd /home/site/wwwroot

# Install composer dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Generate key if not exists
php artisan key:generate --force

# Run migrations
php artisan migrate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Copy custom nginx config
cp /home/site/wwwroot/default /etc/nginx/sites-available/default

# Restart nginx
service nginx reload
