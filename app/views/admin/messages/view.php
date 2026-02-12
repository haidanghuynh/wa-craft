<?php $pageTitle = 'Xem Tin Nhắn'; $activeMenu = 'messages'; $m = $message; ob_start(); ?>
<div class="page-heading">Tin Nhắn #<?= $m['id'] ?></div>
<div class="form-card">
    <div style="margin-bottom:20px">
        <p><strong>Tên:</strong> <?= htmlspecialchars($m['name']) ?></p>
        <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($m['email']) ?>"><?= htmlspecialchars($m['email']) ?></a></p>
        <p><strong>Tiêu đề:</strong> <?= htmlspecialchars($m['subject'] ?: '—') ?></p>
        <p><strong>Ngày:</strong> <?= $m['created_at'] ?></p>
    </div>
    <div style="padding:20px;background:var(--admin-surface);border-radius:8px;border:1px solid var(--admin-border);line-height:1.8">
        <?= nl2br(htmlspecialchars($m['message'])) ?>
    </div>
    <div class="form-actions" style="margin-top:20px">
        <a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="btn btn-primary"><i class="fas fa-reply"></i> Trả lời</a>
        <a href="<?= BASE_URL ?>/admin/messages" class="btn btn-outline">Quay lại</a>
    </div>
</div>
<?php $content = ob_get_clean(); include __DIR__ . '/../layout.php'; ?>
