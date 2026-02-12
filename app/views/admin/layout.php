<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Dashboard' ?> - <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/admin.css">
</head>
<body class="admin-body">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-cubes"></i>
                <span>Admin Panel</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= BASE_URL ?>/admin/dashboard" class="sidebar-link <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/pages" class="sidebar-link <?= ($activeMenu ?? '') === 'pages' ? 'active' : '' ?>">
                <i class="fas fa-file-alt"></i> <span>Trang</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/services" class="sidebar-link <?= ($activeMenu ?? '') === 'services' ? 'active' : '' ?>">
                <i class="fas fa-cogs"></i> <span>Dịch Vụ</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/blog" class="sidebar-link <?= ($activeMenu ?? '') === 'blog' ? 'active' : '' ?>">
                <i class="fas fa-newspaper"></i> <span>Blog</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/categories" class="sidebar-link <?= ($activeMenu ?? '') === 'categories' ? 'active' : '' ?>">
                <i class="fas fa-folder"></i> <span>Danh Mục</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/team" class="sidebar-link <?= ($activeMenu ?? '') === 'team' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> <span>Đội Ngũ</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/sliders" class="sidebar-link <?= ($activeMenu ?? '') === 'sliders' ? 'active' : '' ?>">
                <i class="fas fa-images"></i> <span>Slider</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/messages" class="sidebar-link <?= ($activeMenu ?? '') === 'messages' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i> <span>Tin Nhắn</span>
            </a>
            <a href="<?= BASE_URL ?>/admin/settings" class="sidebar-link <?= ($activeMenu ?? '') === 'settings' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> <span>Cài Đặt</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/vi" target="_blank" class="sidebar-link"><i class="fas fa-external-link-alt"></i> <span>Xem Website</span></a>
            <a href="<?= BASE_URL ?>/admin/logout" class="sidebar-link logout"><i class="fas fa-sign-out-alt"></i> <span>Đăng Xuất</span></a>
        </div>
    </aside>

    <!-- Main -->
    <main class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <div class="admin-header-right">
                <span class="admin-user"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
            </div>
        </header>
        <div class="admin-content">
            <?= $content ?? '' ?>
        </div>
    </main>

    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.getElementById('adminSidebar').classList.toggle('collapsed');
        });
    </script>
</body>
</html>
