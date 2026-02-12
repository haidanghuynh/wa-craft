<?php $pageTitle = 'Quản lý Blog'; $activeMenu = 'blog'; ob_start(); ?>
<div class="page-heading">Quản lý Blog <a href="<?= BASE_URL ?>/admin/blog/create" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Thêm bài viết</a></div>
<div class="admin-table-wrapper">
<table class="admin-table">
<thead><tr><th>ID</th><th>Tiêu đề (VN)</th><th>Danh mục</th><th>Ngày đăng</th><th>Trạng thái</th><th>Thao tác</th></tr></thead>
<tbody>
<?php if (!empty($posts['data'])): foreach ($posts['data'] as $p): ?>
<tr>
<td><?= $p['id'] ?></td>
<td><strong><?= htmlspecialchars($p['title_vi']) ?></strong><br><small class="text-muted"><?= htmlspecialchars($p['title_ja']) ?></small></td>
<td><?= htmlspecialchars($p['category_name'] ?? '—') ?></td>
<td><?= $p['published_at'] ?? '—' ?></td>
<td><span class="badge <?= $p['is_active'] ? 'badge-active' : 'badge-inactive' ?>"><?= $p['is_active'] ? 'Active' : 'Draft' ?></span></td>
<td>
<div class="btn-group">
<a href="<?= BASE_URL ?>/admin/blog/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline"><i class="fas fa-edit"></i></a>
<a href="<?= BASE_URL ?>/admin/blog/delete/<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa bài viết này?')"><i class="fas fa-trash"></i></a>
</div></td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
