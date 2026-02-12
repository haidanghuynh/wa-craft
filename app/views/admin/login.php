<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/admin.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo"><i class="fas fa-cubes"></i></div>
                <h1>Admin Dashboard</h1>
                <p>Đăng nhập để quản lý website</p>
            </div>
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST" action="<?= BASE_URL ?>/admin/login">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" required autofocus placeholder="admin">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-primary btn-full">
                    <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                </button>
            </form>
        </div>
    </div>
</body>
</html>
