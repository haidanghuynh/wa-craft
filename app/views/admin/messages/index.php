<?php $pageTitle = 'Tin Nhắn'; $activeMenu = 'messages'; ob_start(); ?>
<div class="page-heading">Tin Nhắn Liên Hệ</div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Tên</th><th>Email</th><th>Tiêu đề</th><th>Ngày</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php foreach ($messages as $m): ?>
<tr <?= !$m['is_read'] ? 'style="font-weight:600"' : '' ?>>
<td><?= $m['id'] ?></td><td><?= htmlspecialchars($m['name']) ?></td>
<td><?= htmlspecialchars($m['email']) ?></td><td><?= htmlspecialchars($m['subject'] ?: '—') ?></td>
<td><?= $m['created_at'] ?></td>
<td><span class="badge <?= $m['is_read'] ? 'badge-active' : 'badge-unread' ?>"><?= $m['is_read'] ? 'Đã đọc' : 'Mới' ?></span></td>
<td><div class="btn-group">
<a href="<?= BASE_URL ?>/admin/messages/view/<?= $m['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
<a href="<?= BASE_URL ?>/admin/messages/delete/<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')"><i class="fas fa-trash"></i></a>
</div></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
