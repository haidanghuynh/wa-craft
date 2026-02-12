<?php $pageTitle = 'Sửa Danh Mục'; $activeMenu = 'categories'; $c = $category; ob_start(); ?>
<div class="page-heading">Sửa Danh Mục</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/categories/update/<?= $c['id'] ?>">
    <div class="form-group"><label>Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($c['slug']) ?>" required></div>
    <div class="form-row">
        <div class="form-group"><label>Tên (VN)</label><input type="text" name="name_vi" class="form-control" value="<?= htmlspecialchars($c['name_vi']) ?>" required></div>
        <div class="form-group"><label>Tên (JP)</label><input type="text" name="name_ja" class="form-control" value="<?= htmlspecialchars($c['name_ja']) ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Mô tả (VN)</label><textarea name="description_vi" class="form-control" rows="2"><?= htmlspecialchars($c['description_vi'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Mô tả (JP)</label><textarea name="description_ja" class="form-control" rows="2"><?= htmlspecialchars($c['description_ja'] ?? '') ?></textarea></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="<?= $c['sort_order'] ?>"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" <?= $c['is_active'] ? 'checked' : '' ?>> Active</label></div>
    </div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button><a href="<?= BASE_URL ?>/admin/categories" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
