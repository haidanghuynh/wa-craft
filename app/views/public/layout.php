<!DOCTYPE html>
<html lang="<?= $lang ?? 'vi' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Company SPA') ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDescription ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($metaKeywords ?? '') ?>">

    <!-- Hreflang SEO -->
    <?php $currentUrl = $_SERVER['REQUEST_URI']; $otherLang = ($lang ?? 'vi') === 'vi' ? 'ja' : 'vi'; ?>
    <link rel="alternate" hreflang="<?= $lang ?? 'vi' ?>" href="<?= BASE_URL . $currentUrl ?>">
    <link rel="alternate" hreflang="<?= $otherLang ?>" href="<?= BASE_URL . '/' . $otherLang . '/' . ($currentPage ?? '') ?>">
    <link rel="alternate" hreflang="x-default" href="<?= BASE_URL ?>/vi">
    <link rel="canonical" href="<?= BASE_URL . $currentUrl ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? '') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription ?? '') ?>">
    <meta property="og:url" content="<?= BASE_URL . $currentUrl ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= ($lang ?? 'vi') === 'vi' ? 'vi_VN' : 'ja_JP' ?>">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= htmlspecialchars($settings['company_name'] ?? 'Company') ?>",
        "url": "<?= BASE_URL ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "<?= htmlspecialchars($settings['company_phone'] ?? '') ?>",
            "contactType": "customer service",
            "availableLanguage": ["Vietnamese", "Japanese"]
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?= htmlspecialchars($settings['company_address'] ?? '') ?>"
        }
    }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="site-header" id="siteHeader">
        <div class="container header-inner">
            <a href="<?= BASE_URL ?>/<?= $lang ?>" class="logo" data-spa="true">
                <span class="logo-icon"><i class="fas fa-cubes"></i></span>
                <span class="logo-text"><?= htmlspecialchars($settings['company_name'] ?? 'ABC Tech') ?></span>
            </a>

            <nav class="main-nav" id="mainNav">
                <a href="<?= BASE_URL ?>/<?= $lang ?>" class="nav-link <?= ($currentPage ?? '') === 'home' ? 'active' : '' ?>" data-page="home" data-spa="true">
                    <i class="fas fa-home"></i> <?= $lang === 'ja' ? 'ホーム' : 'Trang Chủ' ?>
                </a>
                <a href="<?= BASE_URL ?>/<?= $lang ?>/about" class="nav-link <?= ($currentPage ?? '') === 'about' ? 'active' : '' ?>" data-page="about" data-spa="true">
                    <i class="fas fa-building"></i> <?= $lang === 'ja' ? '会社概要' : 'Giới Thiệu' ?>
                </a>
                <a href="<?= BASE_URL ?>/<?= $lang ?>/services" class="nav-link <?= ($currentPage ?? '') === 'services' ? 'active' : '' ?>" data-page="services" data-spa="true">
                    <i class="fas fa-cogs"></i> <?= $lang === 'ja' ? 'サービス' : 'Dịch Vụ' ?>
                </a>
                <a href="<?= BASE_URL ?>/<?= $lang ?>/blog" class="nav-link <?= ($currentPage ?? '') === 'blog' ? 'active' : '' ?>" data-page="blog" data-spa="true">
                    <i class="fas fa-newspaper"></i> <?= $lang === 'ja' ? 'ブログ' : 'Blog' ?>
                </a>
                <a href="<?= BASE_URL ?>/<?= $lang ?>/team" class="nav-link <?= ($currentPage ?? '') === 'team' ? 'active' : '' ?>" data-page="team" data-spa="true">
                    <i class="fas fa-users"></i> <?= $lang === 'ja' ? 'チーム' : 'Đội Ngũ' ?>
                </a>
                <a href="<?= BASE_URL ?>/<?= $lang ?>/contact" class="nav-link <?= ($currentPage ?? '') === 'contact' ? 'active' : '' ?>" data-page="contact" data-spa="true">
                    <i class="fas fa-envelope"></i> <?= $lang === 'ja' ? 'お問い合わせ' : 'Liên Hệ' ?>
                </a>
            </nav>

            <div class="header-actions">
                <!-- Language Switcher -->
                <div class="lang-switcher <?= $lang === 'ja' ? 'ja-active' : '' ?>">
                    <a href="<?= BASE_URL ?>/vi<?= isset($currentPage) && $currentPage !== 'home' ? '/' . $currentPage : '' ?>"
                       class="lang-btn <?= $lang === 'vi' ? 'active' : '' ?>" data-lang="vi">🇻🇳 VI</a>
                    <a href="<?= BASE_URL ?>/ja<?= isset($currentPage) && $currentPage !== 'home' ? '/' . $currentPage : '' ?>"
                       class="lang-btn <?= $lang === 'ja' ? 'active' : '' ?>" data-lang="ja">🇯🇵 JA</a>
                </div>
                <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content (SPA Container) -->
    <main id="app" class="main-content">
        <div class="page-loader" id="pageLoader">
            <div class="loader-spinner"></div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3 class="footer-title"><?= htmlspecialchars($settings['company_name'] ?? '') ?></h3>
                    <p class="footer-desc"><?= htmlspecialchars($settings['site_description'] ?? '') ?></p>
                    <div class="social-links">
                        <?php if (!empty($settings['facebook'])): ?><a href="<?= $settings['facebook'] ?>" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                        <?php if (!empty($settings['twitter'])): ?><a href="<?= $settings['twitter'] ?>" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a><?php endif; ?>
                        <?php if (!empty($settings['linkedin'])): ?><a href="<?= $settings['linkedin'] ?>" target="_blank" rel="noopener"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                        <?php if (!empty($settings['youtube'])): ?><a href="<?= $settings['youtube'] ?>" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a><?php endif; ?>
                    </div>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title"><?= $lang === 'ja' ? 'お問い合わせ' : 'Liên Hệ' ?></h3>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($settings['company_address'] ?? '') ?></li>
                        <li><i class="fas fa-phone"></i> <?= htmlspecialchars($settings['company_phone'] ?? '') ?></li>
                        <li><i class="fas fa-envelope"></i> <?= htmlspecialchars($settings['company_email'] ?? '') ?></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3 class="footer-title"><?= $lang === 'ja' ? 'クイックリンク' : 'Liên Kết Nhanh' ?></h3>
                    <ul class="footer-links">
                        <li><a href="<?= BASE_URL ?>/<?= $lang ?>/about" data-spa="true"><?= $lang === 'ja' ? '会社概要' : 'Giới Thiệu' ?></a></li>
                        <li><a href="<?= BASE_URL ?>/<?= $lang ?>/services" data-spa="true"><?= $lang === 'ja' ? 'サービス' : 'Dịch Vụ' ?></a></li>
                        <li><a href="<?= BASE_URL ?>/<?= $lang ?>/blog" data-spa="true"><?= $lang === 'ja' ? 'ブログ' : 'Blog' ?></a></li>
                        <li><a href="<?= BASE_URL ?>/<?= $lang ?>/contact" data-spa="true"><?= $lang === 'ja' ? 'お問い合わせ' : 'Liên Hệ' ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['company_name'] ?? 'Company') ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const BASE_URL = '<?= BASE_URL ?>';
        let currentLang = '<?= $lang ?? 'vi' ?>';
        const currentPage = '<?= $currentPage ?? 'home' ?>';
        const postSlug = '<?= $postSlug ?? '' ?>';
    </script>
    <script src="<?= BASE_URL ?>/public/js/app.js"></script>
</body>
</html>
