#!/bin/bash

# 1. Configure Nginx Document Root to /public
# NOTE: We use sed to modify the existing default config provided by Azure to preserve the correct fastcgi_pass upstream.
# Do NOT overwrite the file with a custom one unless you know the exact upstream socket.
sed -i 's|root /home/site/wwwroot;|root /home/site/wwwroot/public;|g' /etc/nginx/sites-available/default
service nginx reload

# 2. Navigate to app
cd /home/site/wwwroot

# 3. Create necessary directories to avoid "View path not found"
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
chmod -R 775 storage bootstrap/cache

# 4. Laravel Setup
# Run package discovery
php artisan package:discover --ansi

# Ensure env exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Run migrations (force for production)
php artisan migrate --force

# Optimize and Cache
php artisan config:clear
php artisan view:clear
php artisan route:clear

php artisan config:cache
php artisan view:cache
php artisan route:cache

# Link storage
php artisan storage:link 2>/dev/null || true
