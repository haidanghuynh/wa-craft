<?php $pageTitle = 'Sửa Thành Viên'; $activeMenu = 'team'; $m = $member; ob_start(); ?>
<div class="page-heading">Sửa Thành Viên</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/team/update/<?= $m['id'] ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tên (VN)</label><input type="text" name="name_vi" class="form-control" value="<?= htmlspecialchars($m['name_vi']) ?>" required></div>
        <div class="form-group"><label>Tên (JP)</label><input type="text" name="name_ja" class="form-control" value="<?= htmlspecialchars($m['name_ja']) ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Chức vụ (VN)</label><input type="text" name="position_vi" class="form-control" value="<?= htmlspecialchars($m['position_vi']) ?>"></div>
        <div class="form-group"><label>Chức vụ (JP)</label><input type="text" name="position_ja" class="form-control" value="<?= htmlspecialchars($m['position_ja']) ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Tiểu sử (VN)</label><textarea name="bio_vi" class="form-control" rows="3"><?= htmlspecialchars($m['bio_vi'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Tiểu sử (JP)</label><textarea name="bio_ja" class="form-control" rows="3"><?= htmlspecialchars($m['bio_ja'] ?? '') ?></textarea></div>
    </div>
    <div class="form-group"><label>Ảnh</label>
        <?php if ($m['photo']): ?><br><img src="<?= BASE_URL ?>/public/uploads/<?= $m['photo'] ?>" class="img-preview"><?php endif; ?>
        <input type="file" name="photo" class="form-control" accept="image/*"></div>
    <div class="form-row">
        <div class="form-group"><label>Thứ tự</label><input type="number" name="sort_order" class="form-control" value="<?= $m['sort_order'] ?>"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" <?= $m['is_active'] ? 'checked' : '' ?>> Active</label></div>
    </div>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button><a href="<?= BASE_URL ?>/admin/team" class="btn btn-outline">Hủy</a></div>
</form></div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
