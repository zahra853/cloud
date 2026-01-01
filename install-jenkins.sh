#!/bin/bash

# Update system
apt update
apt upgrade -y

# Install Java
apt install -y openjdk-11-jdk

# Add Jenkins repository
wget -q -O - https://pkg.jenkins.io/debian-stable/jenkins.io.key | apt-key add -
sh -c 'echo deb https://pkg.jenkins.io/debian-stable binary/ > /etc/apt/sources.list.d/jenkins.list'

# Install Jenkins
apt update
apt install -y jenkins

# Start Jenkins
systemctl start jenkins
systemctl enable jenkins

# Install additional tools
apt install -y git curl wget unzip

# Wait for Jenkins to start
sleep 30

# Create a flag file to indicate completion
echo "Jenkins installation completed at $(date)" > /tmp/jenkins-installed.txt

# Get initial admin password
if [ -f /var/lib/jenkins/secrets/initialAdminPassword ]; then
    cat /var/lib/jenkins/secrets/initialAdminPassword > /tmp/jenkins-password.txt
fi