#!/bin/bash

# Azure App Service Setup for Laravel
# Resource Group: TubesCloud

echo "🚀 Setting up Laravel App Service in Azure"

# Variables
RESOURCE_GROUP="TubesCloud"
LOCATION="Southeast Asia"
APP_SERVICE_PLAN="joglo-lontar-plan"
WEB_APP_NAME="joglo-lontar-app"
MYSQL_SERVER_NAME="joglo-lontar-mysql"
MYSQL_DB_NAME="joglo_lontar_db"
MYSQL_ADMIN_USER="jogloadmin"
MYSQL_ADMIN_PASSWORD="JogloLontar2025!"

# Create App Service Plan
echo "📋 Creating App Service Plan..."
az appservice plan create \
  --name $APP_SERVICE_PLAN \
  --resource-group $RESOURCE_GROUP \
  --location "$LOCATION" \
  --sku B1 \
  --is-linux

# Create Web App
echo "🌐 Creating Web App..."
az webapp create \
  --resource-group $RESOURCE_GROUP \
  --plan $APP_SERVICE_PLAN \
  --name $WEB_APP_NAME \
  --runtime "PHP|8.2" \
  --deployment-source-url https://github.com/zahra853/cloud.git \
  --deployment-source-branch main

# Create MySQL Server
echo "🗄️ Creating MySQL Server..."
az mysql flexible-server create \
  --resource-group $RESOURCE_GROUP \
  --name $MYSQL_SERVER_NAME \
  --location "$LOCATION" \
  --admin-user $MYSQL_ADMIN_USER \
  --admin-password $MYSQL_ADMIN_PASSWORD \
  --sku-name Standard_B1ms \
  --tier Burstable \
  --public-access 0.0.0.0 \
  --storage-size 20 \
  --version 8.0.21

# Create Database
echo "📊 Creating Database..."
az mysql flexible-server db create \
  --resource-group $RESOURCE_GROUP \
  --server-name $MYSQL_SERVER_NAME \
  --database-name $MYSQL_DB_NAME

# Configure App Settings
echo "⚙️ Configuring App Settings..."
az webapp config appsettings set \
  --resource-group $RESOURCE_GROUP \
  --name $WEB_APP_NAME \
  --settings \
    APP_ENV=production \
    APP_DEBUG=false \
    APP_KEY=base64:$(openssl rand -base64 32) \
    DB_CONNECTION=mysql \
    DB_HOST=$MYSQL_SERVER_NAME.mysql.database.azure.com \
    DB_PORT=3306 \
    DB_DATABASE=$MYSQL_DB_NAME \
    DB_USERNAME=$MYSQL_ADMIN_USER \
    DB_PASSWORD=$MYSQL_ADMIN_PASSWORD \
    GOOGLE_CLIENT_ID=your_google_client_id_here \
    GOOGLE_CLIENT_SECRET=your_google_client_secret_here \
    GOOGLE_REDIRECT_URI=https://$WEB_APP_NAME.azurewebsites.net/auth/google/callback

# Configure deployment
echo "🚀 Configuring Deployment..."
az webapp deployment source config \
  --resource-group $RESOURCE_GROUP \
  --name $WEB_APP_NAME \
  --repo-url https://github.com/zahra853/cloud.git \
  --branch main \
  --manual-integration

# Get App URL
APP_URL="https://$WEB_APP_NAME.azurewebsites.net"

echo "✅ Laravel App Service created successfully!"
echo "🌍 App URL: $APP_URL"
echo "🗄️ MySQL Server: $MYSQL_SERVER_NAME.mysql.database.azure.com"
echo "📊 Database: $MYSQL_DB_NAME"