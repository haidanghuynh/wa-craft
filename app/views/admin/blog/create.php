<?php $pageTitle = 'Thêm bài viết'; $activeMenu = 'blog'; ob_start(); ?>
<div class="page-heading">Thêm bài viết</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/blog/store" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN) *</label><input type="text" name="title_vi" class="form-control" required></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Slug</label><input type="text" name="slug" class="form-control" placeholder="tu-dong-tao"></div>
        <div class="form-group"><label>Danh mục</label>
        <select name="category_id" class="form-control"><option value="">— Chọn —</option>
        <?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name_vi']) ?></option><?php endforeach; ?>
        </select></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Tóm tắt (VN)</label><textarea name="summary_vi" class="form-control" rows="3"></textarea></div>
        <div class="form-group"><label>Tóm tắt (JP)</label><textarea name="summary_ja" class="form-control" rows="3"></textarea></div>
    </div>
    <div class="form-group"><label>Nội dung (VN)</label><textarea name="content_vi" class="form-control" rows="8"></textarea></div>
    <div class="form-group"><label>Nội dung (JP)</label><textarea name="content_ja" class="form-control" rows="8"></textarea></div>
    <div class="form-row">
        <div class="form-group"><label>Meta Description (VN)</label><input type="text" name="meta_description_vi" class="form-control"></div>
        <div class="form-group"><label>Meta Description (JP)</label><input type="text" name="meta_description_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Meta Keywords (VN)</label><input type="text" name="meta_keywords_vi" class="form-control"></div>
        <div class="form-group"><label>Meta Keywords (JP)</label><input type="text" name="meta_keywords_ja" class="form-control"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Thumbnail</label><input type="file" name="thumbnail" class="form-control" accept="image/*"></div>
        <div class="form-group"><label>OG Image</label><input type="file" name="og_image" class="form-control" accept="image/*"></div>
    </div>
    <div class="form-group"><label>Tags</label>
    <div style="display:flex;flex-wrap:wrap;gap:8px;">
    <?php foreach ($tags as $t): ?>
        <label class="form-check"><input type="checkbox" name="tags[]" value="<?= $t['id'] ?>"> <?= htmlspecialchars($t['name_vi']) ?></label>
    <?php endforeach; ?>
    </div></div>
    <div class="form-row">
        <div class="form-group"><label>Ngày đăng</label><input type="date" name="published_at" class="form-control" value="<?= date('Y-m-d') ?>"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" checked> Active</label></div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
        <a href="<?= BASE_URL ?>/admin/blog" class="btn btn-outline">Hủy</a>
    </div>
</form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
