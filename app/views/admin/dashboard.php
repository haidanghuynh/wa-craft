<?php $pageTitle = 'Dashboard'; $activeMenu = 'dashboard'; ob_start(); ?>

<div class="dashboard">
    <h1 class="page-heading">Dashboard</h1>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
            <div class="stat-info">
                <div class="stat-number"><?= $stats['posts'] ?? 0 ?></div>
                <div class="stat-label">Bài viết</div>
            </div>
        </div>
        <div class="stat-card stat-accent">
            <div class="stat-icon"><i class="fas fa-cogs"></i></div>
            <div class="stat-info">
                <div class="stat-number"><?= $stats['services'] ?? 0 ?></div>
                <div class="stat-label">Dịch vụ</div>
            </div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-number"><?= $stats['team'] ?? 0 ?></div>
                <div class="stat-label">Thành viên</div>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
                <div class="stat-number"><?= $stats['messages'] ?? 0 ?></div>
                <div class="stat-label">Tin chưa đọc</div>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Latest Posts -->
        <div class="dash-panel">
            <h2 class="panel-title"><i class="fas fa-newspaper"></i> Bài viết mới nhất</h2>
            <div class="panel-body">
                <?php if (!empty($latestPosts)): foreach ($latestPosts as $p): ?>
                    <div class="dash-item">
                        <div class="dash-item-info">
                            <strong><?= htmlspecialchars($p['title_vi']) ?></strong>
                            <small><?= $p['published_at'] ?? '' ?></small>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/blog/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline">Sửa</a>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <!-- Latest Messages -->
        <div class="dash-panel">
            <h2 class="panel-title"><i class="fas fa-envelope"></i> Tin nhắn mới</h2>
            <div class="panel-body">
                <?php if (!empty($latestMessages)): foreach ($latestMessages as $m): ?>
                    <div class="dash-item">
                        <div class="dash-item-info">
                            <strong><?= htmlspecialchars($m['name']) ?></strong>
                            <small><?= htmlspecialchars($m['subject'] ?: $m['email']) ?></small>
                        </div>
                        <a href="<?= BASE_URL ?>/admin/messages/view/<?= $m['id'] ?>" class="btn btn-sm btn-outline">Xem</a>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); include __DIR__ . '/layout.php'; ?>
