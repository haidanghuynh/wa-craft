/**
 * Company SPA - Main JavaScript Application
 * SPA Router + AJAX Content Loading + Language Switching
 */

(function () {
    'use strict';

    // ============================================================
    // SPA Router
    // ============================================================
    const App = {
        init() {
            this.bindNavigation();
            this.bindMobileMenu();
            this.loadPage(currentPage, postSlug);
            this.bindScrollHeader();
        },

        bindNavigation() {
            document.addEventListener('click', (e) => {
                const link = e.target.closest('[data-spa="true"]');
                if (!link) return;
                e.preventDefault();

                const href = link.getAttribute('href');
                const page = link.dataset.page || this.getPageFromUrl(href);

                // Language switch
                if (link.dataset.lang) {
                    currentLang = link.dataset.lang;
                    localStorage.setItem('lang', currentLang);
                    window.location.href = href;
                    return;
                }

                // Update URL
                history.pushState({ page }, '', href);
                this.loadPage(page);
                this.updateActiveNav(page);
                this.closeMobileMenu();

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Handle browser back/forward
            window.addEventListener('popstate', (e) => {
                const page = e.state?.page || 'home';
                this.loadPage(page);
                this.updateActiveNav(page);
            });
        },

        getPageFromUrl(url) {
            const parts = url.replace(BASE_URL, '').split('/').filter(Boolean);
            if (parts.length <= 1) return 'home';
            return parts[1] || 'home';
        },

        updateActiveNav(page) {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.toggle('active', link.dataset.page === page);
            });
        },

        async loadPage(page, slug = '') {
            const app = document.getElementById('app');
            app.innerHTML = '<div class="page-loader"><div class="loader-spinner"></div></div>';

            try {
                switch (page) {
                    case 'home':
                        await this.renderHome(); break;
                    case 'about':
                        await this.renderAbout(); break;
                    case 'services':
                        await this.renderServices(); break;
                    case 'blog':
                        await this.renderBlog(); break;
                    case 'blog-detail':
                        await this.renderBlogDetail(slug || postSlug); break;
                    case 'team':
                        await this.renderTeam(); break;
                    case 'contact':
                        await this.renderContact(); break;
                    default:
                        app.innerHTML = '<div class="container section"><h1>404</h1></div>';
                }
            } catch (err) {
                console.error('Load page error:', err);
                app.innerHTML = '<div class="container section"><h1>Error loading page</h1></div>';
            }
        },

        async fetchApi(endpoint) {
            const sep = endpoint.includes('?') ? '&' : '?';
            const res = await fetch(`${BASE_URL}/${endpoint}${sep}lang=${currentLang}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            return res.json();
        },

        // ============================================================
        // Page Renderers
        // ============================================================

        async renderHome() {
            const data = await this.fetchApi('api/home');
            const s = data.settings || {};
            const app = document.getElementById('app');

            app.innerHTML = `
                <!-- Hero Section: Centered Layout -->
                <section class="hero-centered">
                    <!-- Background Slideshow -->
                    <div class="hero-bg-slideshow">
                        <div class="hero-bg-slide active" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1920&q=80');"></div>
                        <div class="hero-bg-slide" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?w=1920&q=80');"></div>
                        <div class="hero-bg-slide" style="background-image: url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=1920&q=80');"></div>
                        <div class="hero-bg-slide" style="background-image: url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1920&q=80');"></div>
                    </div>
                    <div class="hero-overlay"></div>
                    <div class="container">
                        <div class="hero-content-center">
                            <div class="hero-badge">${currentLang === 'ja' ? 'ダナン・日本企業サポート' : 'Hỗ Trợ Doanh Nghiệp Nhật'}</div>
                            <h1 class="hero-title">${currentLang === 'ja' ? 'ベトナム進出を成功に導く' : 'Dẫn Dắt Thành Công Khi Vào Việt Nam'}</h1>
                            <p class="hero-desc">${currentLang === 'ja' ? 'ダナンでの人材派遣・BPO・投資コンサルティングサービス。日本企業の海外進出を全面的にサポートします。' : 'Dịch vụ tư vấn nhân lực, BPO và đầu tư tại Đà Nẵng. Hỗ trợ toàn diện doanh nghiệp Nhật Bản mở rộng ra nước ngoài.'}</p>
                            <div class="hero-actions">
                                <a href="${BASE_URL}/${currentLang}/services" class="btn btn-primary" data-spa="true" data-page="services">
                                    <i class="fas fa-briefcase"></i> ${currentLang === 'ja' ? 'サービス一覧' : 'Xem Dịch Vụ'}
                                </a>
                                <a href="${BASE_URL}/${currentLang}/contact" class="btn btn-outline" data-spa="true" data-page="contact">
                                    <i class="fas fa-envelope"></i> ${currentLang === 'ja' ? 'お問い合わせ' : 'Liên Hệ'}
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Trust Stats Bar -->
                <section class="stats-bar">
                    <div class="container">
                        <div class="stats-grid">
                            ${(data.highlights || []).map(h => `
                                <div class="stat-item">
                                    <div class="stat-icon"><i class="${h.icon}"></i></div>
                                    <div class="stat-content">
                                        <div class="stat-number">${h.number}</div>
                                        <div class="stat-label">${h.label}</div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </section>

                <!-- Services Section -->
                <section class="section services-section">
                    <div class="container">
                        <div class="section-header">
                            <h2 class="section-title">${currentLang === 'ja' ? '私たちのサービス' : 'Dịch Vụ Của Chúng Tôi'}</h2>
                            <p class="section-subtitle">${currentLang === 'ja' ? '御社のベトナム進出をトータルサポート' : 'Hỗ trợ toàn diện cho việc mở rộng sang Việt Nam'}</p>
                        </div>
                        <div class="${(data.services || []).length > 5 ? 'services-carousel' : ''}">
                            ${(data.services || []).length > 5 ? '<button class="carousel-nav prev"><i class="fas fa-chevron-left"></i></button>' : ''}
                            <div class="services-grid-jp">
                                ${(data.services || []).map(s => `
                                    <div class="service-card-jp">
                                        <div class="service-icon-jp"><i class="${s.icon || 'fas fa-cog'}"></i></div>
                                        <h3 class="service-title-jp">${this.esc(s.title)}</h3>
                                        <p class="service-desc-jp">${this.esc(s.description)}</p>
                                        <a href="${BASE_URL}/${currentLang}/services" class="service-link" data-spa="true" data-page="services">
                                            ${currentLang === 'ja' ? '詳しく見る' : 'Xem chi tiết'} <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                `).join('')}
                            </div>
                            ${(data.services || []).length > 5 ? '<button class="carousel-nav next"><i class="fas fa-chevron-right"></i></button>' : ''}
                        </div>
                    </div>
                </section>

                <!-- Team Section (日本式) -->
                <section class="section team-section">
                    <div class="container">
                        <div class="section-header">
                            <h2 class="section-title">${currentLang === 'ja' ? '私たちのチーム' : 'Đội Ngũ Của Chúng Tôi'}</h2>
                            <p class="section-subtitle">${currentLang === 'ja' ? '経験豊富なプロフェッショナルチーム' : 'Đội ngũ chuyên nghiệp giàu kinh nghiệm'}</p>
                        </div>
                        <div class="team-grid-jp">
                            ${(data.team || []).map(member => `
                                <div class="team-card-jp">
                                    <div class="team-photo">
                                        ${member.photo ? `<img src="${BASE_URL}/${member.photo}" alt="${this.esc(member.name)}">` : `<div class="team-photo-placeholder"><i class="fas fa-user"></i></div>`}
                                    </div>
                                    <h3 class="team-name">${this.esc(member.name)}</h3>
                                    <p class="team-position">${this.esc(member.position)}</p>
                                    ${member.bio ? `<p class="team-bio">${this.esc(member.bio)}</p>` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </section>

                <!-- Why Da Nang Section -->
                <section class="section why-section">
                    <div class="container">
                        <div class="section-header">
                            <h2 class="section-title">${currentLang === 'ja' ? 'なぜダナンか' : 'Tại Sao Đà Nẵng'}</h2>
                            <p class="section-subtitle">${currentLang === 'ja' ? 'ベトナム中部の経済ハブ' : 'Trung tâm Kinh tế Miền Trung Việt Nam'}</p>
                        </div>
                        <div class="why-grid">
                            <div class="why-card">
                                <div class="why-icon"><i class="fas fa-dollar-sign"></i></div>
                                <h3 class="why-title">${currentLang === 'ja' ? 'コスト効率' : 'Chi Phí Hiệu Quả'}</h3>
                                <p class="why-desc">${currentLang === 'ja' ? 'ハノイ・ホーチミンより最大30%低い運営コスト' : 'Chi phí vận hành thấp hơn 30% so với Hà Nội/HCM'}</p>
                            </div>
                            <div class="why-card">
                                <div class="why-icon"><i class="fas fa-users"></i></div>
                                <h3 class="why-title">${currentLang === 'ja' ? '優秀な人材' : 'Nguồn Nhân Lực Chất Lượng'}</h3>
                                <p class="why-desc">${currentLang === 'ja' ? '若く、教育水準の高い労働力' : 'Lực lượng lao động trẻ, có trình độ cao'}</p>
                            </div>
                            <div class="why-card">
                                <div class="why-icon"><i class="fas fa-globe-asia"></i></div>
                                <h3 class="why-title">${currentLang === 'ja' ? '戦略的立地' : 'Vị Trí Chiến Lược'}</h3>
                                <p class="why-desc">${currentLang === 'ja' ? 'ASEAN経済圏へのゲートウェイ' : 'Cổng vào khu vực kinh tế ASEAN'}</p>
                            </div>
                            <div class="why-card">
                                <div class="why-icon"><i class="fas fa-handshake"></i></div>
                                <h3 class="why-title">${currentLang === 'ja' ? '日本語対応' : 'Hỗ Trợ Tiếng Nhật'}</h3>
                                <p class="why-desc">${currentLang === 'ja' ? '日本語でのフルサポート体制' : 'Hỗ trợ đầy đủ bằng tiếng Nhật'}</p>
                            </div>
                        </div>
                    </div>
                </section>
            `;

            // Initialize hero background slideshow
            this.initHeroSlideshow();

            // Initialize services carousel if applicable
            this.initServicesCarousel();
        },

        initHeroSlideshow() {
            const slides = document.querySelectorAll('.hero-bg-slide');
            if (slides.length === 0) return;

            let currentSlide = 0;

            setInterval(() => {
                // Remove active from current
                slides[currentSlide].classList.remove('active');

                // Move to next slide
                currentSlide = (currentSlide + 1) % slides.length;

                // Add active to new slide
                slides[currentSlide].classList.add('active');
            }, 6000); // Change slide every 6 seconds
        },

        initServicesCarousel() {
            const carousel = document.querySelector('.services-carousel');
            if (!carousel) return;

            const grid = carousel.querySelector('.services-grid-jp');
            const prevBtn = carousel.querySelector('.carousel-nav.prev');
            const nextBtn = carousel.querySelector('.carousel-nav.next');

            if (!grid || !prevBtn || !nextBtn) return;

            prevBtn.addEventListener('click', () => {
                const cardWidth = grid.querySelector('.service-card-jp').offsetWidth;
                grid.scrollBy({ left: -(cardWidth + 28), behavior: 'smooth' });
            });

            nextBtn.addEventListener('click', () => {
                const cardWidth = grid.querySelector('.service-card-jp').offsetWidth;
                grid.scrollBy({ left: cardWidth + 28, behavior: 'smooth' });
            });
        },


        async renderAbout() {
            const data = await this.fetchApi('api/page/about');
            document.getElementById('app').innerHTML = `
                <section class="page-hero">
                    <div class="container">
                        <h1 class="page-hero-title">${this.esc(data.title)}</h1>
                    </div>
                </section>
                <section class="section">
                    <div class="container content-area">
                        ${data.content || ''}
                    </div>
                </section>
            `;
        },

        async renderServices() {
            const data = await this.fetchApi('api/services');
            document.getElementById('app').innerHTML = `
                <section class="page-hero">
                    <div class="container">
                        <h1 class="page-hero-title">${currentLang === 'ja' ? 'サービス' : 'Dịch Vụ'}</h1>
                    </div>
                </section>
                <section class="section">
                    <div class="container">
                        <div class="services-detail-grid">
                            ${(data.services || []).map(s => `
                                <div class="service-detail-card">
                                    <div class="service-detail-icon"><i class="${s.icon || 'fas fa-cog'}"></i></div>
                                    <h2 class="service-detail-title">${this.esc(s.title)}</h2>
                                    <p class="service-detail-desc">${this.esc(s.description)}</p>
                                    <div class="service-detail-content">${s.detail || ''}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </section>
            `;
        },

        async renderBlog(categorySlug = '', tagSlug = '', page = 1) {
            let endpoint = 'api/blog';
            if (categorySlug) endpoint = `api/blog/category/${categorySlug}`;
            if (tagSlug) endpoint = `api/blog/tag/${tagSlug}`;
            endpoint += `?page=${page}`;

            const data = await this.fetchApi(endpoint);
            const posts = data.posts || {};
            const categories = data.categories || [];

            document.getElementById('app').innerHTML = `
                <section class="page-hero">
                    <div class="container">
                        <h1 class="page-hero-title">${data.category ? this.esc(data.category.name) : (data.tag ? '#' + this.esc(data.tag.name) : (currentLang === 'ja' ? 'ブログ' : 'Blog'))}</h1>
                    </div>
                </section>
                <section class="section">
                    <div class="container blog-layout">
                        <div class="blog-main">
                            <div class="posts-grid">
                                ${(posts.data || []).map(p => `
                                    <article class="post-card">
                                        <div class="post-thumb" style="background-image: url('${p.thumbnail ? BASE_URL + '/public/uploads/' + p.thumbnail : ''}')">
                                            <span class="post-category">${this.esc(p.category_name || '')}</span>
                                        </div>
                                        <div class="post-body">
                                            <h3 class="post-title"><a href="${BASE_URL}/${currentLang}/blog/${p.slug}" data-spa="true" data-page="blog-detail">${this.esc(p.title)}</a></h3>
                                            <p class="post-summary">${this.esc(p.summary || '')}</p>
                                            <div class="post-meta">
                                                <span><i class="far fa-calendar"></i> ${p.published_at || ''}</span>
                                                <span><i class="far fa-eye"></i> ${p.view_count || 0}</span>
                                            </div>
                                        </div>
                                    </article>
                                `).join('')}
                            </div>
                            ${this.renderPagination(posts)}
                        </div>
                        <aside class="blog-sidebar">
                            <div class="sidebar-widget">
                                <h3 class="widget-title">${currentLang === 'ja' ? 'カテゴリー' : 'Danh Mục'}</h3>
                                <ul class="category-list">
                                    ${categories.map(c => `
                                        <li><a href="${BASE_URL}/${currentLang}/blog/category/${c.slug}" data-spa="true" data-page="blog">${this.esc(c.name)}</a></li>
                                    `).join('')}
                                </ul>
                            </div>
                        </aside>
                    </div>
                </section>
            `;
        },

        async renderBlogDetail(slug) {
            const data = await this.fetchApi(`api/blog/${slug}`);
            if (data.error) {
                document.getElementById('app').innerHTML = '<div class="container section"><h1>Post not found</h1></div>';
                return;
            }
            const post = data.post;
            const tags = data.tags || [];
            const related = data.related || [];

            document.getElementById('app').innerHTML = `
                <section class="page-hero page-hero-sm">
                    <div class="container">
                        <nav class="breadcrumb">
                            <a href="${BASE_URL}/${currentLang}" data-spa="true" data-page="home">${currentLang === 'ja' ? 'ホーム' : 'Trang Chủ'}</a>
                            <span>/</span>
                            <a href="${BASE_URL}/${currentLang}/blog" data-spa="true" data-page="blog">${currentLang === 'ja' ? 'ブログ' : 'Blog'}</a>
                            <span>/</span>
                            <span>${this.esc(post.title)}</span>
                        </nav>
                    </div>
                </section>
                <section class="section">
                    <div class="container blog-detail-layout">
                        <article class="blog-detail">
                            <header class="blog-detail-header">
                                <h1 class="blog-detail-title">${this.esc(post.title)}</h1>
                                <div class="blog-detail-meta">
                                    <span><i class="far fa-calendar"></i> ${post.published_at || ''}</span>
                                    <span><i class="far fa-eye"></i> ${post.view_count || 0} ${currentLang === 'ja' ? '回閲覧' : 'lượt xem'}</span>
                                    ${post.category_name ? `<span><i class="fas fa-folder"></i> ${this.esc(post.category_name)}</span>` : ''}
                                </div>
                            </header>
                            ${post.thumbnail ? `<img src="${BASE_URL}/public/uploads/${post.thumbnail}" alt="${this.esc(post.title)}" class="blog-detail-thumb" loading="lazy">` : ''}
                            <div class="blog-detail-content content-area">
                                ${post.content || ''}
                            </div>
                            ${tags.length ? `
                                <div class="blog-tags">
                                    <i class="fas fa-tags"></i>
                                    ${tags.map(t => `<a href="${BASE_URL}/${currentLang}/blog/tag/${t.slug}" class="tag" data-spa="true" data-page="blog">${this.esc(t.name)}</a>`).join('')}
                                </div>
                            ` : ''}
                        </article>
                        ${related.length ? `
                            <div class="related-posts">
                                <h2 class="section-title">${currentLang === 'ja' ? '関連記事' : 'Bài Viết Liên Quan'}</h2>
                                <div class="posts-grid posts-grid-sm">
                                    ${related.map(p => `
                                        <article class="post-card">
                                            <div class="post-body">
                                                <h3 class="post-title"><a href="${BASE_URL}/${currentLang}/blog/${p.slug}" data-spa="true" data-page="blog-detail">${this.esc(p.title)}</a></h3>
                                                <div class="post-meta"><span><i class="far fa-calendar"></i> ${p.published_at || ''}</span></div>
                                            </div>
                                        </article>
                                    `).join('')}
                                </div>
                            </div>
                        ` : ''}
                    </div>
                </section>
            `;
        },

        async renderTeam() {
            const data = await this.fetchApi('api/team');
            document.getElementById('app').innerHTML = `
                <section class="page-hero">
                    <div class="container">
                        <h1 class="page-hero-title">${currentLang === 'ja' ? 'チーム紹介' : 'Đội Ngũ'}</h1>
                    </div>
                </section>
                <section class="section">
                    <div class="container">
                        <div class="team-grid">
                            ${(data.members || []).map(m => `
                                <div class="team-card">
                                    <div class="team-photo">
                                        ${m.photo ? `<img src="${BASE_URL}/public/uploads/${m.photo}" alt="${this.esc(m.name)}" loading="lazy">` : `<div class="team-avatar"><i class="fas fa-user"></i></div>`}
                                    </div>
                                    <h3 class="team-name">${this.esc(m.name)}</h3>
                                    <p class="team-position">${this.esc(m.position)}</p>
                                    <p class="team-bio">${this.esc(m.bio || '')}</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </section>
            `;
        },

        async renderContact() {
            const pageData = await this.fetchApi('api/page/contact');
            const settingsData = await this.fetchApi('api/settings');

            document.getElementById('app').innerHTML = `
                <section class="page-hero">
                    <div class="container">
                        <h1 class="page-hero-title">${this.esc(pageData.title || (currentLang === 'ja' ? 'お問い合わせ' : 'Liên Hệ'))}</h1>
                    </div>
                </section>
                <section class="section">
                    <div class="container contact-layout">
                        <div class="contact-info">
                            <div class="content-area">${pageData.content || ''}</div>
                            <div class="contact-details">
                                <div class="contact-item"><i class="fas fa-map-marker-alt"></i><span>${this.esc(settingsData.company_address || '')}</span></div>
                                <div class="contact-item"><i class="fas fa-phone"></i><span>${this.esc(settingsData.company_phone || '')}</span></div>
                                <div class="contact-item"><i class="fas fa-envelope"></i><span>${this.esc(settingsData.company_email || '')}</span></div>
                            </div>
                        </div>
                        <div class="contact-form-wrapper">
                            <h2>${currentLang === 'ja' ? 'メッセージを送る' : 'Gửi Tin Nhắn'}</h2>
                            <form id="contactForm" class="contact-form">
                                <div class="form-group">
                                    <label>${currentLang === 'ja' ? 'お名前' : 'Họ Tên'} *</label>
                                    <input type="text" name="name" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" name="email" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>${currentLang === 'ja' ? '件名' : 'Tiêu Đề'}</label>
                                    <input type="text" name="subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>${currentLang === 'ja' ? 'メッセージ' : 'Nội Dung'} *</label>
                                    <textarea name="message" rows="5" required class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-full">
                                    <i class="fas fa-paper-plane"></i> ${currentLang === 'ja' ? '送信する' : 'Gửi'}
                                </button>
                                <div id="contactResult" class="form-result"></div>
                            </form>
                        </div>
                    </div>
                </section>
            `;

            this.bindContactForm();
        },

        // ============================================================
        // Utilities
        // ============================================================

        esc(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        },

        renderPagination(pagination) {
            if (!pagination || pagination.last_page <= 1) return '';
            let html = '<div class="pagination">';
            for (let i = 1; i <= pagination.last_page; i++) {
                html += `<button class="page-btn ${i === pagination.current_page ? 'active' : ''}" data-page-num="${i}">${i}</button>`;
            }
            html += '</div>';
            return html;
        },

        initSlider() {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');
            if (slides.length === 0) return;

            let current = 0;
            const next = () => {
                slides[current].classList.remove('active');
                dots[current]?.classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
                dots[current]?.classList.add('active');
            };

            setInterval(next, 5000);

            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    slides[current].classList.remove('active');
                    dots[current]?.classList.remove('active');
                    current = i;
                    slides[current].classList.add('active');
                    dots[current]?.classList.add('active');
                });
            });
        },

        bindContactForm() {
            const form = document.getElementById('contactForm');
            if (!form) return;
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const resultDiv = document.getElementById('contactResult');
                const formData = new FormData(form);

                try {
                    const res = await fetch(`${BASE_URL}/api/contact?lang=${currentLang}`, {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        form.reset();
                    } else {
                        resultDiv.innerHTML = `<div class="alert alert-error">${data.error}</div>`;
                    }
                } catch (err) {
                    resultDiv.innerHTML = '<div class="alert alert-error">Error sending message</div>';
                }
            });
        },

        bindMobileMenu() {
            const toggle = document.getElementById('mobileToggle');
            const nav = document.getElementById('mainNav');
            if (toggle && nav) {
                toggle.addEventListener('click', () => {
                    nav.classList.toggle('open');
                    toggle.classList.toggle('open');
                });
            }
        },

        closeMobileMenu() {
            document.getElementById('mainNav')?.classList.remove('open');
            document.getElementById('mobileToggle')?.classList.remove('open');
        },

        bindScrollHeader() {
            let lastScroll = 0;
            window.addEventListener('scroll', () => {
                const header = document.getElementById('siteHeader');
                const scroll = window.scrollY;
                if (scroll > 80) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                lastScroll = scroll;
            });
        }
    };

    // Init on DOM ready
    document.addEventListener('DOMContentLoaded', () => App.init());
})();
