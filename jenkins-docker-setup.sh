#!/bin/bash

# Install Docker on Azure VM
echo "Installing Docker..."
sudo apt update
sudo apt install -y apt-transport-https ca-certificates curl gnupg lsb-release

# Add Docker GPG key
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Add Docker repository
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io

# Start Docker
sudo systemctl start docker
sudo systemctl enable docker

# Add user to docker group
sudo usermod -aG docker azureuser

# Run Jenkins container
echo "Starting Jenkins container..."
sudo docker run -d \
  --name jenkins \
  --restart=unless-stopped \
  -p 8080:8080 \
  -p 50000:50000 \
  -v jenkins_home:/var/jenkins_home \
  jenkins/jenkins:lts

# Wait for Jenkins to start
sleep 60

# Get initial admin password
echo "Getting Jenkins initial password..."
sudo docker exec jenkins cat /var/jenkins_home/secrets/initialAdminPassword > /tmp/jenkins-password.txt

echo "Jenkins setup completed!"
echo "Access Jenkins at: http://52.163.115.18:8080"