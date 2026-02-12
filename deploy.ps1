# ========================================
# PowerShell Deployment Script for Windows
# ========================================

Write-Host "==================================" -ForegroundColor Cyan
Write-Host "  SPA Deployment Script (Windows)" -ForegroundColor Cyan
Write-Host "==================================" -ForegroundColor Cyan
Write-Host ""

# Check if PHP is installed
Write-Host "[1/5] Checking PHP installation..." -ForegroundColor Yellow
$phpVersion = php -v 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: PHP is not installed!" -ForegroundColor Red
    Write-Host "Please install PHP first:" -ForegroundColor Yellow
    Write-Host "  1. Download from: https://windows.php.net/download" -ForegroundColor White
    Write-Host "  2. Extract to C:\php" -ForegroundColor White
    Write-Host "  3. Add C:\php to PATH environment variable" -ForegroundColor White
    Write-Host "  4. Run this script again" -ForegroundColor White
    exit 1
}
Write-Host "✓ PHP is installed" -ForegroundColor Green
Write-Host ""

# Check PHP version
Write-Host "[2/5] Checking PHP version..." -ForegroundColor Yellow
$versionMatch = php -v | Select-String -Pattern "PHP (\d+\.\d+)"
if ($versionMatch) {
    $version = [version]$versionMatch.Matches[0].Groups[1].Value
    if ($version -lt [version]"7.4") {
        Write-Host "WARNING: PHP version is $version. Recommended: 7.4 or higher" -ForegroundColor Yellow
    } else {
        Write-Host "✓ PHP version $version is compatible" -ForegroundColor Green
    }
}
Write-Host ""

# Check required PHP extensions
Write-Host "[3/5] Checking PHP extensions..." -ForegroundColor Yellow
$requiredExtensions = @("sqlite3", "pdo_sqlite", "mbstring", "json")
$missingExtensions = @()

foreach ($ext in $requiredExtensions) {
    $result = php -r "echo extension_loaded('$ext') ? '1' : '0';"
    if ($result -eq "0") {
        $missingExtensions += $ext
    }
}

if ($missingExtensions.Count -gt 0) {
    Write-Host "WARNING: Missing extensions: $($missingExtensions -join ', ')" -ForegroundColor Yellow
    Write-Host "Please enable them in php.ini by uncommenting:" -ForegroundColor White
    foreach ($ext in $missingExtensions) {
        Write-Host "  extension=$ext" -ForegroundColor White
    }
} else {
    Write-Host "✓ All required PHP extensions are loaded" -ForegroundColor Green
}
Write-Host ""

# Setup database
Write-Host "[4/5] Setting up database..." -ForegroundColor Yellow
if (Test-Path "database/app.db") {
    Write-Host "✓ Database already exists" -ForegroundColor Green
} else {
    Write-Host "Creating database and running migrations..." -ForegroundColor White
    
    # Create database directory if not exists
    if (!(Test-Path "database")) {
        New-Item -ItemType Directory -Path "database" | Out-Null
    }
    
    # Run seed.sql if exists
    if (Test-Path "database/seed.sql") {
        # Create SQLite database and import seed
        $env:PATH += ";$PWD"
        php -r "
        `$db = new PDO('sqlite:database/app.db');
        `$sql = file_get_contents('database/seed.sql');
        `$db->exec(`$sql);
        echo 'Database seeded successfully\n';
        "
        Write-Host "✓ Database created and seeded" -ForegroundColor Green
    } else {
        Write-Host "WARNING: database/seed.sql not found" -ForegroundColor Yellow
    }
}
Write-Host ""

# Start server
Write-Host "[5/5] Starting PHP development server..." -ForegroundColor Yellow
Write-Host ""
Write-Host "======================================" -ForegroundColor Green
Write-Host "  Server is running at:" -ForegroundColor Green
Write-Host "  http://localhost:8000" -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Green
Write-Host ""
Write-Host "Press Ctrl+C to stop the server" -ForegroundColor Yellow
Write-Host ""

# Start PHP server
php -S localhost:8000 router.php
