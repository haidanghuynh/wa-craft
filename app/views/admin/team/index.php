<?php $pageTitle = 'Quản lý Đội Ngũ'; $activeMenu = 'team'; ob_start(); ?>
<div class="page-heading">Quản lý Đội Ngũ <a href="<?= BASE_URL ?>/admin/team/create" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Thêm</a></div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Ảnh</th><th>Tên (VN)</th><th>Chức vụ (VN)</th><th>Thứ tự</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php foreach ($members as $m): ?>
<tr><td><?= $m['id'] ?></td>
<td><?php if ($m['photo']): ?><img src="<?= BASE_URL ?>/public/uploads/<?= $m['photo'] ?>" class="img-preview" style="max-width:48px;max-height:48px;border-radius:50%"><?php else: ?>—<?php endif; ?></td>
<td><?= htmlspecialchars($m['name_vi']) ?></td><td><?= htmlspecialchars($m['position_vi']) ?></td>
<td><?= $m['sort_order'] ?></td>
<td><span class="badge <?= $m['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $m['is_active'] ? 'Active' : 'Draft' ?></span></td>
<td><div class="btn-group">
<a href="<?= BASE_URL ?>/admin/team/edit/<?= $m['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
<a href="<?= BASE_URL ?>/admin/team/delete/<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a>
</div></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
