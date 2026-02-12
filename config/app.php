<?php
/**
 * Application Configuration
 * Cấu hình ứng dụng / アプリケーション設定
 */

// Base URL - thay đổi khi deploy
define('BASE_URL', 'http://localhost:8000');

// App Info
define('APP_NAME', 'Company SPA');
define('APP_VERSION', '1.0.0');

// Default Language
define('DEFAULT_LANG', 'vi'); // 'vi' hoặc 'ja'
define('SUPPORTED_LANGS', ['vi', 'ja']);

// Paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('VIEWS_PATH', APP_PATH . '/views');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');
define('UPLOAD_URL', BASE_URL . '/public/uploads');

// Upload settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);

// Pagination
define('POSTS_PER_PAGE', 9);

// Session
define('SESSION_LIFETIME', 3600); // 1 hour
