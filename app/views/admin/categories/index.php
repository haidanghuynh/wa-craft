<?php $pageTitle = 'Quản lý Danh mục'; $activeMenu = 'categories'; ob_start(); ?>
<div class="page-heading">Quản lý Danh Mục Blog <a href="<?= BASE_URL ?>/admin/categories/create" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Thêm</a></div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Slug</th><th>Tên (VN)</th><th>Tên (JP)</th><th>Thứ tự</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php foreach ($categories as $c): ?>
<tr><td><?= $c['id'] ?></td><td><code><?= $c['slug'] ?></code></td>
<td><?= htmlspecialchars($c['name_vi']) ?></td><td><?= htmlspecialchars($c['name_ja']) ?></td>
<td><?= $c['sort_order'] ?></td>
<td><span class="badge <?= $c['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $c['is_active'] ? 'Active' : 'Draft' ?></span></td>
<td><div class="btn-group">
<a href="<?= BASE_URL ?>/admin/categories/edit/<?= $c['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
<a href="<?= BASE_URL ?>/admin/categories/delete/<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a>
</div></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
