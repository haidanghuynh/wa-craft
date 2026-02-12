<?php $pageTitle = 'Sửa bài viết'; $activeMenu = 'blog'; $p = $post; ob_start(); ?>
<div class="page-heading">Sửa bài viết</div>
<div class="form-card">
<form method="POST" action="<?= BASE_URL ?>/admin/blog/update/<?= $p['id'] ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group"><label>Tiêu đề (VN) *</label><input type="text" name="title_vi" class="form-control" value="<?= htmlspecialchars($p['title_vi']) ?>" required></div>
        <div class="form-group"><label>Tiêu đề (JP)</label><input type="text" name="title_ja" class="form-control" value="<?= htmlspecialchars($p['title_ja']) ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Slug</label><input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($p['slug']) ?>"></div>
        <div class="form-group"><label>Danh mục</label>
        <select name="category_id" class="form-control"><option value="">— Chọn —</option>
        <?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= ($c['id'] == $p['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($c['name_vi']) ?></option><?php endforeach; ?>
        </select></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Tóm tắt (VN)</label><textarea name="summary_vi" class="form-control" rows="3"><?= htmlspecialchars($p['summary_vi'] ?? '') ?></textarea></div>
        <div class="form-group"><label>Tóm tắt (JP)</label><textarea name="summary_ja" class="form-control" rows="3"><?= htmlspecialchars($p['summary_ja'] ?? '') ?></textarea></div>
    </div>
    <div class="form-group"><label>Nội dung (VN)</label><textarea name="content_vi" class="form-control" rows="8"><?= htmlspecialchars($p['content_vi'] ?? '') ?></textarea></div>
    <div class="form-group"><label>Nội dung (JP)</label><textarea name="content_ja" class="form-control" rows="8"><?= htmlspecialchars($p['content_ja'] ?? '') ?></textarea></div>
    <div class="form-row">
        <div class="form-group"><label>Meta Description (VN)</label><input type="text" name="meta_description_vi" class="form-control" value="<?= htmlspecialchars($p['meta_description_vi'] ?? '') ?>"></div>
        <div class="form-group"><label>Meta Description (JP)</label><input type="text" name="meta_description_ja" class="form-control" value="<?= htmlspecialchars($p['meta_description_ja'] ?? '') ?>"></div>
    </div>
    <div class="form-row">
        <div class="form-group"><label>Thumbnail</label>
            <?php if (!empty($p['thumbnail'])): ?><br><img src="<?= BASE_URL ?>/public/uploads/<?= $p['thumbnail'] ?>" class="img-preview"><?php endif; ?>
            <input type="file" name="thumbnail" class="form-control" accept="image/*"></div>
        <div class="form-group"><label>OG Image</label><input type="file" name="og_image" class="form-control" accept="image/*"></div>
    </div>
    <div class="form-group"><label>Tags</label>
    <div style="display:flex;flex-wrap:wrap;gap:8px;">
    <?php foreach ($tags as $t): ?>
        <label class="form-check"><input type="checkbox" name="tags[]" value="<?= $t['id'] ?>" <?= in_array($t['id'], $selectedTags) ? 'checked' : '' ?>> <?= htmlspecialchars($t['name_vi']) ?></label>
    <?php endforeach; ?>
    </div></div>
    <div class="form-row">
        <div class="form-group"><label>Ngày đăng</label><input type="date" name="published_at" class="form-control" value="<?= $p['published_at'] ?? '' ?>"></div>
        <div class="form-group"><label>&nbsp;</label><label class="form-check"><input type="checkbox" name="is_active" <?= $p['is_active'] ? 'checked' : '' ?>> Active</label></div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
        <a href="<?= BASE_URL ?>/admin/blog" class="btn btn-outline">Hủy</a>
    </div>
</form>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
