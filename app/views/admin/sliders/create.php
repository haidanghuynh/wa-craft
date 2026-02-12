<?php $pageTitle = 'Thêm Slider'; $activeMenu = 'sliders'; ob_start(); ?>
<div class="page-heading">Thêm Slider</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/sliders/store" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN)</label><input type="text" name="title_vi" class="form-control"></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Phụ đề (VN)</label><input type="text" name="subtitle_vi" class="form-control"></div>
        <div class="form-group"><label>Phụ đề (JP)</label><input type="text" name="subtitle_ja" class="form-control"></div>
    </div>
    <div class="form-group"><label>Ảnh nền</label><input type="file" name="image" class="form-control" accept="image/*"></div>
    <div class="form-row">
        <div class="form-group"><label>Link</label><input type="text" name="link" class="form-control"></div>
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="0"></div>
    </div>
    <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" checked> Active</label></div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button><a href="<?= BASE_URL ?>/admin/sliders" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
