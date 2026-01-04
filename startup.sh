#!/bin/bash

# --- Nginx Setup for Laravel (Robust Mode) ---
# We extract the correct fastcgi_pass upstream from Azure's default config
# to ensure we don't get 502 Bad Gateway, while ensuring Laravel routing works.

echo "Configuring Nginx..."

# Backup original
cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.bak

# Extract upstream line (e.g., fastcgi_pass unix:/tmp/php-cgi.sock;)
UPSTREAM_LINE=$(grep "fastcgi_pass" /etc/nginx/sites-available/default.bak | head -n 1)

if [ -z "$UPSTREAM_LINE" ]; then
    echo "Warning: Could not find fastcgi_pass. using default."
    UPSTREAM_LINE="fastcgi_pass 127.0.0.1:9000;"
fi

# Write new config
cat > /etc/nginx/sites-available/default <<EOF
server {
    listen 8080;
    listen [::]:8080;
    root /home/site/wwwroot/public;
    index index.php index.html index.htm;
    server_name _;
    port_in_redirect off;

    location / {
        # This fixes the 404 on login/routes
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        $UPSTREAM_LINE
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

service nginx reload

# --- Laravel Setup ---
cd /home/site/wwwroot

# Ensure storage directories exist
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
chmod -R 775 storage bootstrap/cache

# Run package discovery
php artisan package:discover --ansi

# Ensure env file
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Database & Cache
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link 2>/dev/null || true
