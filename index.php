<?php
/**
 * Entry Point - Main Application
 * Điểm vào ứng dụng / アプリケーションエントリーポイント
 */

// Start session
session_start();

// Load config
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';

// Load core
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Router.php';

// Autoload models
$modelDir = __DIR__ . '/app/models';
if (is_dir($modelDir)) {
    foreach (glob($modelDir . '/*.php') as $modelFile) {
        require_once $modelFile;
    }
}

// ============================================================
// ROUTES DEFINITION / ルート定義
// ============================================================

$router = new Router();

// --- Public API routes (JSON cho AJAX) ---
$router->get('api/home', 'HomeController', 'index');
$router->get('api/page/{slug}', 'PageController', 'show');
$router->get('api/services', 'ServiceController', 'index');
$router->get('api/services/{id}', 'ServiceController', 'show');
$router->get('api/blog', 'BlogController', 'index');
$router->get('api/blog/category/{slug}', 'BlogController', 'byCategory');
$router->get('api/blog/tag/{slug}', 'BlogController', 'byTag');
$router->get('api/blog/{slug}', 'BlogController', 'show');
$router->get('api/team', 'TeamController', 'index');
$router->post('api/contact', 'ContactController', 'submit');
$router->get('api/settings', 'SettingController', 'index');

// --- Public pages (SSR for SEO / Hybrid Rendering) ---
$router->get('', 'HomeController', 'page');
$router->get('vi', 'HomeController', 'page');
$router->get('ja', 'HomeController', 'page');
$router->get('{lang}/about', 'PageController', 'renderPage');
$router->get('{lang}/services', 'ServiceController', 'renderPage');
$router->get('{lang}/blog', 'BlogController', 'renderPage');
$router->get('{lang}/blog/category/{slug}', 'BlogController', 'renderPage');
$router->get('{lang}/blog/tag/{slug}', 'BlogController', 'renderPage');
$router->get('{lang}/blog/{slug}', 'BlogController', 'renderPost');
$router->get('{lang}/team', 'TeamController', 'renderPage');
$router->get('{lang}/contact', 'PageController', 'renderPage');

// --- SEO ---
$router->get('sitemap.xml', 'SitemapController', 'index');

// --- Admin routes ---
$router->get('admin', 'admin/AuthController', 'loginPage');
$router->get('admin/login', 'admin/AuthController', 'loginPage');
$router->post('admin/login', 'admin/AuthController', 'login');
$router->get('admin/logout', 'admin/AuthController', 'logout');

$router->get('admin/dashboard', 'admin/DashboardController', 'index');

// Admin Pages
$router->get('admin/pages', 'admin/AdminPageController', 'index');
$router->get('admin/pages/edit/{id}', 'admin/AdminPageController', 'edit');
$router->post('admin/pages/update/{id}', 'admin/AdminPageController', 'update');

// Admin Blog
$router->get('admin/blog', 'admin/AdminBlogController', 'index');
$router->get('admin/blog/create', 'admin/AdminBlogController', 'create');
$router->post('admin/blog/store', 'admin/AdminBlogController', 'store');
$router->get('admin/blog/edit/{id}', 'admin/AdminBlogController', 'edit');
$router->post('admin/blog/update/{id}', 'admin/AdminBlogController', 'update');
$router->get('admin/blog/delete/{id}', 'admin/AdminBlogController', 'delete');

// Admin Blog Categories
$router->get('admin/categories', 'admin/AdminCategoryController', 'index');
$router->get('admin/categories/create', 'admin/AdminCategoryController', 'create');
$router->post('admin/categories/store', 'admin/AdminCategoryController', 'store');
$router->get('admin/categories/edit/{id}', 'admin/AdminCategoryController', 'edit');
$router->post('admin/categories/update/{id}', 'admin/AdminCategoryController', 'update');
$router->get('admin/categories/delete/{id}', 'admin/AdminCategoryController', 'delete');

// Admin Services
$router->get('admin/services', 'admin/AdminServiceController', 'index');
$router->get('admin/services/create', 'admin/AdminServiceController', 'create');
$router->post('admin/services/store', 'admin/AdminServiceController', 'store');
$router->get('admin/services/edit/{id}', 'admin/AdminServiceController', 'edit');
$router->post('admin/services/update/{id}', 'admin/AdminServiceController', 'update');
$router->get('admin/services/delete/{id}', 'admin/AdminServiceController', 'delete');

// Admin Team
$router->get('admin/team', 'admin/AdminTeamController', 'index');
$router->get('admin/team/create', 'admin/AdminTeamController', 'create');
$router->post('admin/team/store', 'admin/AdminTeamController', 'store');
$router->get('admin/team/edit/{id}', 'admin/AdminTeamController', 'edit');
$router->post('admin/team/update/{id}', 'admin/AdminTeamController', 'update');
$router->get('admin/team/delete/{id}', 'admin/AdminTeamController', 'delete');

// Admin Sliders
$router->get('admin/sliders', 'admin/AdminSliderController', 'index');
$router->get('admin/sliders/create', 'admin/AdminSliderController', 'create');
$router->post('admin/sliders/store', 'admin/AdminSliderController', 'store');
$router->get('admin/sliders/edit/{id}', 'admin/AdminSliderController', 'edit');
$router->post('admin/sliders/update/{id}', 'admin/AdminSliderController', 'update');
$router->get('admin/sliders/delete/{id}', 'admin/AdminSliderController', 'delete');

// Admin Settings
$router->get('admin/settings', 'admin/AdminSettingController', 'index');
$router->post('admin/settings/update', 'admin/AdminSettingController', 'update');

// Admin Messages
$router->get('admin/messages', 'admin/AdminMessageController', 'index');
$router->get('admin/messages/view/{id}', 'admin/AdminMessageController', 'view');
$router->get('admin/messages/delete/{id}', 'admin/AdminMessageController', 'delete');

// ============================================================
// DISPATCH / ディスパッチ
// ============================================================

$url = $_GET['url'] ?? '';
$router->dispatch($url);
