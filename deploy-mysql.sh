#!/bin/bash

# ========================================
# Bash MySQL Deployment Script for Ubuntu/Linux
# ========================================

echo "========================================"
echo "  SPA MySQL Deployment (Ubuntu)"
echo "========================================"
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Database Configuration
DB_NAME="spa_db"
DB_USER="spa_user"
DB_PASS="spa_password123"
DB_HOST="localhost"

# Check if PHP is installed
echo -e "${YELLOW}[1/6] Checking PHP installation...${NC}"
if ! command -v php &> /dev/null; then
    echo -e "${YELLOW}Installing PHP...${NC}"
    sudo apt update
    sudo apt install -y php php-cli php-mysql php-mbstring php-json php-xml
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ PHP installed successfully${NC}"
    else
        echo -e "${RED}ERROR: Failed to install PHP${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}✓ PHP is installed${NC}"
fi
echo ""

# Check if MySQL is installed
echo -e "${YELLOW}[2/6] Checking MySQL installation...${NC}"
if ! command -v mysql &> /dev/null; then
    echo -e "${YELLOW}Installing MySQL Server...${NC}"
    
    # Install MySQL
    sudo apt update
    sudo apt install -y mysql-server
    
    # Start MySQL service
    sudo systemctl start mysql
    sudo systemctl enable mysql
    
    # Secure installation (auto-configure)
    echo -e "${YELLOW}Configuring MySQL...${NC}"
    sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';"
    
    echo -e "${GREEN}✓ MySQL installed successfully${NC}"
    echo -e "${CYAN}MySQL root password set to: root${NC}"
else
    echo -e "${GREEN}✓ MySQL is installed${NC}"
fi
echo ""

# Check PHP MySQL extension
echo -e "${YELLOW}[3/6] Checking PHP MySQL extension...${NC}"
if ! php -m | grep -qi "mysqli"; then
    echo -e "${YELLOW}Installing PHP MySQL extension...${NC}"
    sudo apt install -y php-mysql
    echo -e "${GREEN}✓ PHP MySQL extension installed${NC}"
else
    echo -e "${GREEN}✓ PHP MySQL extension is loaded${NC}"
fi
echo ""

# Get MySQL root password
echo -e "${YELLOW}[4/6] MySQL Database Setup${NC}"
echo -e "${CYAN}Enter MySQL root password (default: root):${NC}"
read -s ROOT_PASS
if [ -z "$ROOT_PASS" ]; then
    ROOT_PASS="root"
fi

# Create database and user
echo -e "${YELLOW}Creating database and user...${NC}"
mysql -u root -p"$ROOT_PASS" <<EOF
DROP DATABASE IF EXISTS $DB_NAME;
CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
DROP USER IF EXISTS '$DB_USER'@'localhost';
CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Database and user created${NC}"
else
    echo -e "${RED}ERROR: Failed to create database or user!${NC}"
    echo -e "${YELLOW}Please check your MySQL root password and try again.${NC}"
    exit 1
fi
echo ""

# Import seed data
echo -e "${YELLOW}[5/6] Importing seed data...${NC}"
if [ -f "database/seed.sql" ]; then
    # Convert SQLite syntax to MySQL
    sed -e 's/PRAGMA.*;//g' \
        -e 's/BEGIN TRANSACTION;/START TRANSACTION;/g' \
        -e 's/AUTOINCREMENT/AUTO_INCREMENT/g' \
        database/seed.sql > database/seed_mysql.sql
    
    # Import to MySQL
    mysql -u $DB_USER -p"$DB_PASS" $DB_NAME < database/seed_mysql.sql 2>&1
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ Seed data imported successfully${NC}"
        rm -f database/seed_mysql.sql
    else
        echo -e "${YELLOW}WARNING: Some errors occurred during import (this may be normal)${NC}"
    fi
else
    echo -e "${YELLOW}WARNING: database/seed.sql not found${NC}"
fi
echo ""

# Create database config file
echo -e "${YELLOW}[6/6] Creating database configuration...${NC}"
mkdir -p config
cat > config/database.php <<EOF
<?php
// Database Configuration
define('DB_TYPE', 'mysql');
define('DB_HOST', '$DB_HOST');
define('DB_NAME', '$DB_NAME');
define('DB_USER', '$DB_USER');
define('DB_PASS', '$DB_PASS');
define('DB_CHARSET', 'utf8mb4');
EOF

echo -e "${GREEN}✓ Configuration file created at config/database.php${NC}"
echo ""

# Display connection info
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  MySQL Database Information${NC}"
echo -e "${GREEN}========================================${NC}"
echo -e "${CYAN}Database: $DB_NAME${NC}"
echo -e "${CYAN}User: $DB_USER${NC}"
echo -e "${CYAN}Password: $DB_PASS${NC}"
echo -e "${CYAN}Host: $DB_HOST${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""

# Start server
echo -e "${YELLOW}Starting PHP development server...${NC}"
echo ""
echo -e "${GREEN}======================================${NC}"
echo -e "${GREEN}  Server is running at:${NC}"
echo -e "${CYAN}  http://localhost:8000${NC}"
echo -e "${GREEN}======================================${NC}"
echo ""
echo -e "${YELLOW}Press Ctrl+C to stop the server${NC}"
echo ""

php -S localhost:8000 router.php
