<?php
/**
 * Router file for PHP Built-in Development Server
 * PHP built-in server không hỗ trợ .htaccess, nên cần file này để rewrite URL
 * 
 * Usage: php -S localhost:8000 router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Nếu file thật tồn tại (CSS, JS, images...) → serve trực tiếp
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // Let PHP built-in server handle static files
}

// Mọi request khác → route qua index.php
$_GET['url'] = ltrim($uri, '/');
require __DIR__ . '/index.php';
