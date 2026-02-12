<?php $pageTitle = 'Quản lý Trang'; $activeMenu = 'pages'; ob_start(); ?>
<div class="page-heading">Quản lý Trang</div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Slug</th><th>Tiêu đề (VN)</th><th>Tiêu đề (JP)</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php foreach ($pages as $p): ?>
<tr>
<td><?= $p['id'] ?></td><td><code><?= $p['slug'] ?></code></td>
<td><?= htmlspecialchars($p['title_vi']) ?></td><td><?= htmlspecialchars($p['title_ja']) ?></td>
<td><span class="badge <?= $p['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $p['is_active'] ? 'Active' : 'Draft' ?></span></td>
<td><a href="<?= BASE_URL ?>/admin/pages/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i> Sửa</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
