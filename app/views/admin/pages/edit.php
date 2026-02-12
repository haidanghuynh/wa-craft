<?php $pageTitle = 'Sửa Trang'; $activeMenu = 'pages'; $p = $page; ob_start(); ?>
<div class="page-heading">Sửa trang: <?= htmlspecialchars($p['slug']) ?></div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/pages/update/<?= $p['id'] ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN)</label><input type="text" name="title_vi" class="form-control" value="<?= htmlspecialchars($p['title_vi']) ?>"></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control" value="<?= htmlspecialchars($p['title_ja']) ?>"></div>
    </div>
    <div class="form-group"><label>Nội dung (VN)</label><textarea name="content_vi" class="form-control" rows="10"><?= htmlspecialchars($p['content_vi'] ?? '') ?></textarea></div>
    <div class="form-group"><label>Nội dung (JP)</label><textarea name="content_ja" class="form-control" rows="10"><?= htmlspecialchars($p['content_ja'] ?? '') ?></textarea></div>
    <div class="form-row">
        <div class="form-group"><label>Meta Description (VN)</label><input type="text" name="meta_description_vi" class="form-control" value="<?= htmlspecialchars($p['meta_description_vi'] ?? '') ?>"></div>
        <div class="form-group"><label>Meta Description (JP)</label><input type="text" name="meta_description_ja" class="form-control" value="<?= htmlspecialchars($p['meta_description_ja'] ?? '') ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Meta Keywords (VN)</label><input type="text" name="meta_keywords_vi" class="form-control" value="<?= htmlspecialchars($p['meta_keywords_vi'] ?? '') ?>"></div>
        <div class="form-group"><label>Meta Keywords (JP)</label><input type="text" name="meta_keywords_ja" class="form-control" value="<?= htmlspecialchars($p['meta_keywords_ja'] ?? '') ?>"></div>
    </div>
    <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" <?= $p['is_active'] ? 'checked' : '' ?>> Active</label></div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
        <a href="<?= BASE_URL ?>/admin/pages" class="btn btn-outline">Hủy</a>
    </div>
</form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
