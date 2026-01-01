# Manual Jenkins Setup via SSH

## 1. SSH ke VM
```bash
ssh azureuser@52.163.115.18
```

## 2. Install Java
```bash
sudo apt update
sudo apt install -y openjdk-11-jdk
java -version
```

## 3. Add Jenkins Repository
```bash
wget -q -O - https://pkg.jenkins.io/debian-stable/jenkins.io.key | sudo apt-key add -
sudo sh -c 'echo deb https://pkg.jenkins.io/debian-stable binary/ > /etc/apt/sources.list.d/jenkins.list'
```

## 4. Install Jenkins
```bash
sudo apt update
sudo apt install -y jenkins
```

## 5. Start Jenkins
```bash
sudo systemctl start jenkins
sudo systemctl enable jenkins
sudo systemctl status jenkins
```

## 6. Check Port
```bash
sudo netstat -tlnp | grep 8080
```

## 7. Get Initial Password
```bash
sudo cat /var/lib/jenkins/secrets/initialAdminPassword
```

## 8. Access Jenkins
Open browser: http://52.163.115.18:8080