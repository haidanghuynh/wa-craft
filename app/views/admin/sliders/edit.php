<?php $pageTitle = 'Sửa Slider'; $activeMenu = 'sliders'; $s = $slider; ob_start(); ?>
<div class="page-heading">Sửa Slider</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/sliders/update/<?= $s['id'] ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN)</label><input type="text" name="title_vi" class="form-control" value="<?= htmlspecialchars($s['title_vi']) ?>"></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control" value="<?= htmlspecialchars($s['title_ja']) ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Phụ đề (VN)</label><input type="text" name="subtitle_vi" class="form-control" value="<?= htmlspecialchars($s['subtitle_vi']) ?>"></div>
        <div class="form-group"><label>Phụ đề (JP)</label><input type="text" name="subtitle_ja" class="form-control" value="<?= htmlspecialchars($s['subtitle_ja']) ?>"></div>
    </div>
    <div class="form-group"><label>Ảnh nền</label>
        <?php if ($s['image']): ?><br><img src="<?= BASE_URL ?>/public/uploads/<?= $s['image'] ?>" class="img-preview"><?php endif; ?>
        <input type="file" name="image" class="form-control" accept="image/*"></div>
    <div class="form-row">
        <div class="form-group"><label>Link</label><input type="text" name="link" class="form-control" value="<?= htmlspecialchars($s['link']) ?>"></div>
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="<?= $s['sort_order'] ?>"></div>
    </div>
    <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" <?= $s['is_active'] ? 'checked' : '' ?>> Active</label></div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button><a href="<?= BASE_URL ?>/admin/sliders" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
