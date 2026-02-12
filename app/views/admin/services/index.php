<?php $pageTitle = 'Quản lý Dịch Vụ'; $activeMenu = 'services'; ob_start(); ?>
<div class="page-heading">Quản lý Dịch Vụ <a href="<?= BASE_URL ?>/admin/services/create" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Thêm</a></div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Icon</th><th>Tiêu đề (VN)</th><th>Tiêu đề (JP)</th><th>Thứ tự</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php foreach ($services as $s): ?>
<tr><td><?= $s['id'] ?></td><td><i class="<?= $s['icon'] ?>"></i></td>
<td><?= htmlspecialchars($s['title_vi']) ?></td><td><?= htmlspecialchars($s['title_ja']) ?></td>
<td><?= $s['sort_order'] ?></td>
<td><span class="badge <?= $s['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $s['is_active'] ? 'Active' : 'Draft' ?></span></td>
<td><div class="btn-group">
<a href="<?= BASE_URL ?>/admin/services/edit/<?= $s['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
<a href="<?= BASE_URL ?>/admin/services/delete/<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a>
</div></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
