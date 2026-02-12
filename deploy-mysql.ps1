# ========================================
# PowerShell MySQL Deployment Script for Windows
# ========================================

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  SPA MySQL Deployment (Windows)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Database Configuration
$DB_NAME = "spa_db"
$DB_USER = "spa_user"
$DB_PASS = "spa_password123"
$DB_HOST = "localhost"

# Check if PHP is installed
Write-Host "[1/6] Checking PHP installation..." -ForegroundColor Yellow
$phpVersion = php -v 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: PHP is not installed!" -ForegroundColor Red
    Write-Host "Please install PHP first from: https://windows.php.net/download" -ForegroundColor Yellow
    exit 1
}
Write-Host "✓ PHP is installed" -ForegroundColor Green
Write-Host ""

# Check MySQL is installed
Write-Host "[2/6] Checking MySQL installation..." -ForegroundColor Yellow
$mysqlCheck = Get-Command mysql -ErrorAction SilentlyContinue
if (-not $mysqlCheck) {
    Write-Host "ERROR: MySQL is not installed!" -ForegroundColor Red
    Write-Host "Please install MySQL:" -ForegroundColor Yellow
    Write-Host "  1. Download from: https://dev.mysql.com/downloads/installer/" -ForegroundColor White
    Write-Host "  2. Run MySQL Installer" -ForegroundColor White
    Write-Host "  3. Choose 'Developer Default' setup" -ForegroundColor White
    Write-Host "  4. Set root password during installation" -ForegroundColor White
    Write-Host "  5. Run this script again" -ForegroundColor White
    exit 1
}
Write-Host "✓ MySQL is installed" -ForegroundColor Green
Write-Host ""

# Check PHP MySQL extension
Write-Host "[3/6] Checking PHP MySQL extension..." -ForegroundColor Yellow
$mysqlExtCheck = php -r "echo extension_loaded('mysqli') ? '1' : '0';"
if ($mysqlExtCheck -eq "0") {
    Write-Host "ERROR: PHP mysqli extension is not loaded!" -ForegroundColor Red
    Write-Host "Please enable it in php.ini:" -ForegroundColor Yellow
    Write-Host "  extension=mysqli" -ForegroundColor White
    Write-Host "  extension=pdo_mysql" -ForegroundColor White
    exit 1
}
Write-Host "✓ PHP MySQL extensions are loaded" -ForegroundColor Green
Write-Host ""

# Get MySQL root password
Write-Host "[4/6] MySQL Database Setup" -ForegroundColor Yellow
Write-Host "Enter MySQL root password:" -ForegroundColor White
$rootPassSecure = Read-Host -AsSecureString
$rootPass = [Runtime.InteropServices.Marshal]::PtrToStringAuto(
    [Runtime.InteropServices.Marshal]::SecureStringToBSTR($rootPassSecure)
)

# Create database and user
Write-Host "Creating database and user..." -ForegroundColor White
$createDbSql = @"
DROP DATABASE IF EXISTS $DB_NAME;
CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
DROP USER IF EXISTS '$DB_USER'@'localhost';
CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
"@

$createDbSql | mysql -u root -p"$rootPass" 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Failed to create database or user!" -ForegroundColor Red
    Write-Host "Please check your MySQL root password and try again." -ForegroundColor Yellow
    exit 1
}
Write-Host "✓ Database and user created" -ForegroundColor Green
Write-Host ""

# Import seed data
Write-Host "[5/6] Importing seed data..." -ForegroundColor Yellow
if (Test-Path "database/seed.sql") {
    # Convert SQLite syntax to MySQL if needed
    $seedContent = Get-Content "database/seed.sql" -Raw
    
    # Remove SQLite-specific commands
    $seedContent = $seedContent -replace "PRAGMA.*?;", ""
    $seedContent = $seedContent -replace "BEGIN TRANSACTION;", "START TRANSACTION;"
    $seedContent = $seedContent -replace "COMMIT;", "COMMIT;"
    $seedContent = $seedContent -replace "AUTOINCREMENT", "AUTO_INCREMENT"
    
    # Save to temp file
    $tempSqlFile = "database/seed_mysql.sql"
    $seedContent | Out-File -FilePath $tempSqlFile -Encoding UTF8
    
    # Import to MySQL
    Get-Content $tempSqlFile | mysql -u $DB_USER -p"$DB_PASS" $DB_NAME 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Seed data imported successfully" -ForegroundColor Green
        Remove-Item $tempSqlFile -ErrorAction SilentlyContinue
    }
    else {
        Write-Host "WARNING: Some errors occurred during import (this may be normal)" -ForegroundColor Yellow
    }
}
else {
    Write-Host "WARNING: database/seed.sql not found" -ForegroundColor Yellow
}
Write-Host ""

# Create database config file
Write-Host "[6/6] Creating database configuration..." -ForegroundColor Yellow
$configContent = @"
<?php
// Database Configuration
define('DB_TYPE', 'mysql');
define('DB_HOST', '$DB_HOST');
define('DB_NAME', '$DB_NAME');
define('DB_USER', '$DB_USER');
define('DB_PASS', '$DB_PASS');
define('DB_CHARSET', 'utf8mb4');
"@

$configContent | Out-File -FilePath "config/database.php" -Encoding UTF8
Write-Host "✓ Configuration file created at config/database.php" -ForegroundColor Green
Write-Host ""

# Display connection info
Write-Host "========================================" -ForegroundColor Green
Write-Host "  MySQL Database Information" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host "Database: $DB_NAME" -ForegroundColor Cyan
Write-Host "User: $DB_USER" -ForegroundColor Cyan
Write-Host "Password: $DB_PASS" -ForegroundColor Cyan
Write-Host "Host: $DB_HOST" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Start server
Write-Host "Starting PHP development server..." -ForegroundColor Yellow
Write-Host ""
Write-Host "======================================" -ForegroundColor Green
Write-Host "  Server is running at:" -ForegroundColor Green
Write-Host "  http://localhost:8000" -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Green
Write-Host ""
Write-Host "Press Ctrl+C to stop the server" -ForegroundColor Yellow
Write-Host ""

php -S localhost:8000 router.php
