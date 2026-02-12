#!/bin/bash

# ========================================
# Bash Deployment Script for Ubuntu/Linux
# ========================================

echo "=================================="
echo "  SPA Deployment Script (Ubuntu)"
echo "=================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Check if PHP is installed
echo -e "${YELLOW}[1/5] Checking PHP installation...${NC}"
if ! command -v php &> /dev/null; then
    echo -e "${RED}ERROR: PHP is not installed!${NC}"
    echo -e "${YELLOW}Installing PHP and required extensions...${NC}"
    
    # Auto-install PHP on Ubuntu
    sudo apt update
    sudo apt install -y php php-cli php-sqlite3 php-mbstring php-json php-xml
    
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

# Check PHP version
echo -e "${YELLOW}[2/5] Checking PHP version...${NC}"
PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(echo $PHP_VERSION | cut -d. -f1)
PHP_MINOR=$(echo $PHP_VERSION | cut -d. -f2)

if [ "$PHP_MAJOR" -lt 7 ] || ([ "$PHP_MAJOR" -eq 7 ] && [ "$PHP_MINOR" -lt 4 ]); then
    echo -e "${YELLOW}WARNING: PHP version is $PHP_VERSION. Recommended: 7.4 or higher${NC}"
else
    echo -e "${GREEN}✓ PHP version $PHP_VERSION is compatible${NC}"
fi
echo ""

# Check required PHP extensions
echo -e "${YELLOW}[3/5] Checking PHP extensions...${NC}"
REQUIRED_EXTENSIONS=("sqlite3" "pdo_sqlite" "mbstring" "json")
MISSING_EXTENSIONS=()

for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if ! php -m | grep -qi "^$ext$"; then
        MISSING_EXTENSIONS+=($ext)
    fi
done

if [ ${#MISSING_EXTENSIONS[@]} -gt 0 ]; then
    echo -e "${YELLOW}WARNING: Missing extensions: ${MISSING_EXTENSIONS[*]}${NC}"
    echo -e "${YELLOW}Installing missing extensions...${NC}"
    
    for ext in "${MISSING_EXTENSIONS[@]}"; do
        sudo apt install -y php-${ext//_/-}
    done
    
    echo -e "${GREEN}✓ Extensions installed${NC}"
else
    echo -e "${GREEN}✓ All required PHP extensions are loaded${NC}"
fi
echo ""

# Setup database
echo -e "${YELLOW}[4/5] Setting up database...${NC}"
if [ -f "database/app.db" ]; then
    echo -e "${GREEN}✓ Database already exists${NC}"
else
    echo "Creating database and running migrations..."
    
    # Create database directory if not exists
    mkdir -p database
    
    # Run seed.sql if exists
    if [ -f "database/seed.sql" ]; then
        php -r "
        \$db = new PDO('sqlite:database/app.db');
        \$sql = file_get_contents('database/seed.sql');
        \$db->exec(\$sql);
        echo 'Database seeded successfully\n';
        "
        echo -e "${GREEN}✓ Database created and seeded${NC}"
    else
        echo -e "${YELLOW}WARNING: database/seed.sql not found${NC}"
    fi
fi
echo ""

# Start server
echo -e "${YELLOW}[5/5] Starting PHP development server...${NC}"
echo ""
echo -e "${GREEN}======================================${NC}"
echo -e "${GREEN}  Server is running at:${NC}"
echo -e "${CYAN}  http://localhost:8000${NC}"
echo -e "${GREEN}======================================${NC}"
echo ""
echo -e "${YELLOW}Press Ctrl+C to stop the server${NC}"
echo ""

# Start PHP server
php -S localhost:8000 router.php
