#!/bin/bash

echo "🚀 Deploying Joglo Lontar to Azure..."

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate --force

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Seed database (optional, only for first deployment)
# php artisan db:seed --force

# Clear and cache config
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "✅ Deployment completed!"