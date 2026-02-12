<?php $pageTitle = 'Quản lý Cài Đặt'; $activeMenu = 'settings'; ob_start(); ?>
<div class="page-heading">Cài Đặt Website</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/settings/update">
<?php foreach ($grouped as $group => $settings): ?>
    <h2 style="text-transform:capitalize;margin-top:16px"><?= ucfirst($group) ?></h2>
    <?php foreach ($settings as $s): ?>
    <input type="hidden" name="keys[]" value="<?= htmlspecialchars($s['setting_key']) ?>">
    <div class="form-group">
        <label><strong><?= htmlspecialchars($s['setting_key']) ?></strong></label>
        <div class="form-row">
            <div><label style="font-size:0.75rem">VN</label><input type="text" name="values_vi[]" class="form-control" value="<?= htmlspecialchars($s['value_vi'] ?? '') ?>"></div>
            <div><label style="font-size:0.75rem">JP</label><input type="text" name="values_ja[]" class="form-control" value="<?= htmlspecialchars($s['value_ja'] ?? '') ?>"></div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endforeach; ?>
    <div class="form-actions"><button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu Cài Đặt</button></div>
</form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
