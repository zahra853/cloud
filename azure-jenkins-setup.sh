#!/bin/bash

# Azure Jenkins Setup Script
# Resource Group: TubesCloud

echo "🚀 Setting up Jenkins in Azure Resource Group: TubesCloud"

# Variables
RESOURCE_GROUP="TubesCloud"
LOCATION="Southeast Asia"
VM_NAME="jenkins-server"
VM_SIZE="Standard_B2s"
ADMIN_USERNAME="azureuser"
NSG_NAME="jenkins-nsg"
VNET_NAME="jenkins-vnet"
SUBNET_NAME="jenkins-subnet"
PUBLIC_IP_NAME="jenkins-public-ip"
NIC_NAME="jenkins-nic"

# Create Resource Group (if not exists)
echo "📦 Creating Resource Group..."
az group create --name $RESOURCE_GROUP --location "$LOCATION"

# Create Virtual Network
echo "🌐 Creating Virtual Network..."
az network vnet create \
  --resource-group $RESOURCE_GROUP \
  --name $VNET_NAME \
  --address-prefix 10.0.0.0/16 \
  --subnet-name $SUBNET_NAME \
  --subnet-prefix 10.0.1.0/24

# Create Network Security Group
echo "🔒 Creating Network Security Group..."
az network nsg create \
  --resource-group $RESOURCE_GROUP \
  --name $NSG_NAME

# Add Jenkins port rule (8080)
az network nsg rule create \
  --resource-group $RESOURCE_GROUP \
  --nsg-name $NSG_NAME \
  --name "Allow-Jenkins" \
  --protocol tcp \
  --priority 1001 \
  --destination-port-range 8080 \
  --access allow

# Add SSH rule
az network nsg rule create \
  --resource-group $RESOURCE_GROUP \
  --nsg-name $NSG_NAME \
  --name "Allow-SSH" \
  --protocol tcp \
  --priority 1002 \
  --destination-port-range 22 \
  --access allow

# Create Public IP
echo "🌍 Creating Public IP..."
az network public-ip create \
  --resource-group $RESOURCE_GROUP \
  --name $PUBLIC_IP_NAME \
  --allocation-method Static \
  --sku Standard

# Create Network Interface
echo "🔌 Creating Network Interface..."
az network nic create \
  --resource-group $RESOURCE_GROUP \
  --name $NIC_NAME \
  --vnet-name $VNET_NAME \
  --subnet $SUBNET_NAME \
  --public-ip-address $PUBLIC_IP_NAME \
  --network-security-group $NSG_NAME

# Create Virtual Machine
echo "💻 Creating Jenkins VM..."
az vm create \
  --resource-group $RESOURCE_GROUP \
  --name $VM_NAME \
  --size $VM_SIZE \
  --image Ubuntu2204 \
  --admin-username $ADMIN_USERNAME \
  --generate-ssh-keys \
  --nics $NIC_NAME \
  --custom-data jenkins-cloud-init.yml

# Get Public IP
PUBLIC_IP=$(az network public-ip show --resource-group $RESOURCE_GROUP --name $PUBLIC_IP_NAME --query ipAddress --output tsv)

echo "✅ Jenkins VM created successfully!"
echo "🌍 Public IP: $PUBLIC_IP"
echo "🔗 Jenkins URL: http://$PUBLIC_IP:8080"
echo "👤 SSH: ssh $ADMIN_USERNAME@$PUBLIC_IP"