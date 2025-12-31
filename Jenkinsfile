pipeline {
    agent any
    
    environment {
        AZURE_RESOURCE_GROUP = 'TubesCloud'
        AZURE_WEB_APP = 'joglo-lontar-app'
        GITHUB_REPO = 'https://github.com/zahra853/cloud.git'
        PHP_VERSION = '8.2'
    }
    
    stages {
        stage('Checkout') {
            steps {
                echo '📥 Checking out code from GitHub...'
                git branch: 'main', url: "${GITHUB_REPO}"
            }
        }
        
        stage('Install Dependencies') {
            steps {
                echo '📦 Installing PHP dependencies...'
                sh '''
                    composer install --no-dev --optimize-autoloader --no-interaction
                    npm install
                    npm run build
                '''
            }
        }
        
        stage('Run Tests') {
            steps {
                echo '🧪 Running tests...'
                sh '''
                    cp .env.example .env
                    php artisan key:generate
                    php artisan config:clear
                    php artisan cache:clear
                    # php artisan test (uncomment when tests are available)
                '''
            }
        }
        
        stage('Security Scan') {
            steps {
                echo '🔒 Running security scan...'
                sh '''
                    # Check for known vulnerabilities
                    composer audit || true
                    
                    # Check for sensitive data
                    echo "Checking for sensitive data..."
                    if grep -r "password\|secret\|key" .env.example; then
                        echo "⚠️ Warning: Sensitive data found in .env.example"
                    fi
                '''
            }
        }
        
        stage('Build Application') {
            steps {
                echo '🏗️ Building Laravel application...'
                sh '''
                    # Optimize for production
                    php artisan config:cache
                    php artisan route:cache
                    php artisan view:cache
                    
                    # Set proper permissions
                    chmod -R 755 storage bootstrap/cache
                '''
            }
        }
        
        stage('Deploy to Azure') {
            steps {
                echo '🚀 Deploying to Azure App Service...'
                withCredentials([azureServicePrincipal('azure-service-principal')]) {
                    sh '''
                        # Login to Azure
                        az login --service-principal -u $AZURE_CLIENT_ID -p $AZURE_CLIENT_SECRET --tenant $AZURE_TENANT_ID
                        
                        # Deploy to App Service
                        az webapp deployment source sync \
                            --resource-group $AZURE_RESOURCE_GROUP \
                            --name $AZURE_WEB_APP
                        
                        # Run migrations
                        az webapp ssh --resource-group $AZURE_RESOURCE_GROUP --name $AZURE_WEB_APP --command "cd /home/site/wwwroot && php artisan migrate --force"
                    '''
                }
            }
        }
        
        stage('Health Check') {
            steps {
                echo '🏥 Running health check...'
                sh '''
                    # Wait for deployment to complete
                    sleep 30
                    
                    # Check if app is responding
                    APP_URL="https://${AZURE_WEB_APP}.azurewebsites.net"
                    HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" $APP_URL)
                    
                    if [ $HTTP_STATUS -eq 200 ]; then
                        echo "✅ Application is healthy! Status: $HTTP_STATUS"
                    else
                        echo "❌ Application health check failed! Status: $HTTP_STATUS"
                        exit 1
                    fi
                '''
            }
        }
    }
    
    post {
        always {
            echo '🧹 Cleaning up...'
            cleanWs()
        }
        success {
            echo '✅ Pipeline completed successfully!'
            emailext (
                subject: "✅ Deployment Success: Joglo Lontar App",
                body: """
                    <h2>🎉 Deployment Successful!</h2>
                    <p><strong>Application:</strong> Joglo Lontar Cafe</p>
                    <p><strong>Environment:</strong> Production</p>
                    <p><strong>URL:</strong> <a href="https://${AZURE_WEB_APP}.azurewebsites.net">https://${AZURE_WEB_APP}.azurewebsites.net</a></p>
                    <p><strong>Build:</strong> #${BUILD_NUMBER}</p>
                    <p><strong>Commit:</strong> ${GIT_COMMIT}</p>
                """,
                to: "azzahraalfiyya8@gmail.com",
                mimeType: 'text/html'
            )
        }
        failure {
            echo '❌ Pipeline failed!'
            emailext (
                subject: "❌ Deployment Failed: Joglo Lontar App",
                body: """
                    <h2>💥 Deployment Failed!</h2>
                    <p><strong>Application:</strong> Joglo Lontar Cafe</p>
                    <p><strong>Build:</strong> #${BUILD_NUMBER}</p>
                    <p><strong>Error:</strong> Check Jenkins logs for details</p>
                    <p><strong>Jenkins URL:</strong> <a href="${BUILD_URL}">${BUILD_URL}</a></p>
                """,
                to: "azzahraalfiyya8@gmail.com",
                mimeType: 'text/html'
            )
        }
    }
}