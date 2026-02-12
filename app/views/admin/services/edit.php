<?php $pageTitle = 'Sửa Dịch Vụ'; $activeMenu = 'services'; $s = $service; ob_start(); ?>
<div class="page-heading">Sửa Dịch Vụ</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/services/update/<?= $s['id'] ?>">
    <div class="form-group"><label>Icon</label><input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($s['icon']) ?>"></div>
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN)</label><input type="text" name="title_vi" class="form-control" value="<?= htmlspecialchars($s['title_vi']) ?>" required></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control" value="<?= htmlspecialchars($s['title_ja']) ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Mô tả (VN)</label><textarea name="description_vi" class="form-control" rows="3"><?= htmlspecialchars($s['description_vi'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Mô tả (JP)</label><textarea name="description_ja" class="form-control" rows="3"><?= htmlspecialchars($s['description_ja'] ?? '') ?></textarea></div>
    </div>
    <div class="form-group"><label>Chi tiết (VN)</label><textarea name="detail_vi" class="form-control" rows="5"><?= htmlspecialchars($s['detail_vi'] ?? '') ?></textarea></div>
    <div class="form-group"><label>Chi tiết (JP)</label><textarea name="detail_ja" class="form-control" rows="5"><?= htmlspecialchars($s['detail_ja'] ?? '') ?></textarea></div>
    <div class="form-row">
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="<?= $s['sort_order'] ?>"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" <?= $s['is_active'] ? 'checked' : '' ?>> Active</label></div>
    </div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button><a href="<?= BASE_URL ?>/admin/services" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
