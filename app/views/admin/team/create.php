<?php $pageTitle = 'Thêm Thành Viên'; $activeMenu = 'team'; ob_start(); ?>
<div class="page-heading">Thêm Thành Viên</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/team/store" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tên (VN) *</label><input type="text" name="name_vi" class="form-control" required></div>
        <div class="form-group"><label>Tên (JP)</label><input type="text" name="name_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Chức vụ (VN)</label><input type="text" name="position_vi" class="form-control"></div>
        <div class="form-group"><label>Chức vụ (JP)</label><input type="text" name="position_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Tiểu sử (VN)</label><textarea name="bio_vi" class="form-control" rows="3"></textarea></div>
        <div class="form-group"><label>Tiểu sử (JP)</label><textarea name="bio_ja" class="form-control" rows="3"></textarea></div>
    </div>
    <div class="form-group"><label>Ảnh</label><input type="file" name="photo" class="form-control" accept="image/*"></div>
    <div class="form-row">
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="0"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" checked> Active</label></div>
    </div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button><a href="<?= BASE_URL ?>/admin/team" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
