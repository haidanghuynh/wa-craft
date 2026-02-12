<?php $pageTitle = 'Thêm Dịch Vụ'; $activeMenu = 'services'; ob_start(); ?>
<div class="page-heading">Thêm Dịch Vụ</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/services/store">
    <div class="form-group"><label>Icon (FontAwesome class)</label><input type="text" name="icon" class="form-control" value="fas fa-cog" placeholder="fas fa-cog"></div>
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN) *</label><input type="text" name="title_vi" class="form-control" required></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Mô tả ngắn (VN)</label><textarea name="description_vi" class="form-control" rows="3"></textarea></div>
        <div class="form-group"><label>Mô tả ngắn (JP)</label><textarea name="description_ja" class="form-control" rows="3"></textarea></div>
    </div>
    <div class="form-group"><label>Chi tiết (VN)</label><textarea name="detail_vi" class="form-control" rows="5"></textarea></div>
    <div class="form-group"><label>Chi tiết (JP)</label><textarea name="detail_ja" class="form-control" rows="5"></textarea></div>
    <div class="form-row">
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="0"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" checked> Active</label></div>
    </div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button><a href="<?= BASE_URL ?>/admin/services" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
