<?php $pageTitle = 'Quản lý Slider'; $activeMenu = 'sliders'; ob_start(); ?>
<div class="page-heading">Quản lý Slider <a href="<?= BASE_URL ?>/admin/sliders/create" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Thêm</a></div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Ảnh</th><th>Tiêu đề (VN)</th><th>Thứ tự</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php foreach ($sliders as $s): ?>
<tr><td><?= $s['id'] ?></td>
<td><?php if ($s['image']): ?><img src="<?= BASE_URL ?>/public/uploads/<?= $s['image'] ?>" class="img-preview" style="max-width:80px"><?php else: ?>—<?php endif; ?></td>
<td><?= htmlspecialchars($s['title_vi']) ?></td><td><?= $s['sort_order'] ?></td>
<td><span class="badge <?= $s['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $s['is_active'] ? 'Active' : 'Draft' ?></span></td>
<td><div class="btn-group">
<a href="<?= BASE_URL ?>/admin/sliders/edit/<?= $s['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
<a href="<?= BASE_URL ?>/admin/sliders/delete/<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a>
</div></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
