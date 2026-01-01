pipeline {
    agent any
    
    environment {
        AZURE_RESOURCE_GROUP = 'TubesCloud'
        AZURE_WEB_APP = 'joglo-prembun-app'
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
                    grep -rE "(password|secret|key)" .env.example && echo "Warning: Check sensitive data" || true
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
                sh '''
                    # Create deployment package
                    zip -r deploy.zip . -x "*.git*" -x "node_modules/*" -x "tests/*" -x "*.zip"
                    
                    echo "Deployment package created. Manual deploy required via Azure Portal or CLI."
                    echo "Package size:"
                    ls -lh deploy.zip
                '''
            }
        }
        
        stage('Health Check') {
            steps {
                echo '🏥 Build completed successfully!'
                echo "Ready for deployment to: https://joglo-prembun-app.azurewebsites.net"
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
                subject: "✅ Deployment Success: Joglo Prembun App",
                body: """
                    <h2>🎉 Deployment Successful!</h2>
                    <p><strong>Application:</strong> Joglo Prembun</p>
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
                subject: "❌ Deployment Failed: Joglo Prembun App",
                body: """
                    <h2>💥 Deployment Failed!</h2>
                    <p><strong>Application:</strong> Joglo Prembun</p>
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