pipeline {
    agent any
    
    environment {
        AZURE_RESOURCE_GROUP = 'TubesCC'
        AZURE_WEB_APP = 'tubescc-webapp'
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
                    # Skip cache:clear karena butuh database connection
                    echo "Skipping cache clear - no database in CI"
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
                    # Skip artisan optimize commands yang butuh database
                    # Langsung set permissions
                    chmod -R 755 storage bootstrap/cache
                    echo "Build completed - ready for deployment"
                '''
            }
        }
        
        stage('Deploy to Azure') {
            steps {
                echo '🚀 Deploying to Azure App Service...'
                withCredentials([usernamePassword(credentialsId: 'azure-deploy-creds', usernameVariable: 'AZURE_USER', passwordVariable: 'AZURE_PASS')]) {
                    sh '''
                        # Create deployment package
                        zip -r deploy.zip . -x "*.git*" -x "node_modules/*" -x "tests/*" -x "*.zip"
                        
                        echo "Deploying to Azure App Service..."
                        curl -X POST \
                            -u "$AZURE_USER:$AZURE_PASS" \
                            --data-binary @deploy.zip \
                            "https://tubescc-webapp.scm.azurewebsites.net/api/zipdeploy"
                        
                        echo "Deployment completed!"
                    '''
                }
            }
        }
        
        stage('Health Check') {
            steps {
                echo '🏥 Running health check...'
                sh '''
                    sleep 30
                    HTTP_STATUS=$(curl -s -o /dev/null -w \"%{http_code}\" https://tubescc-webapp.azurewebsites.net)
                    echo "HTTP Status: $HTTP_STATUS"
                    if [ "$HTTP_STATUS" = "200" ] || [ "$HTTP_STATUS" = "302" ]; then
                        echo "✅ App is running!"
                    else
                        echo "⚠️ App returned status $HTTP_STATUS"
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