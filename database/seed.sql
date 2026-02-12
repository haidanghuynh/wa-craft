-- ============================================================
-- Company SPA - Seed Data (VN + JP)
-- Dữ liệu mẫu song ngữ / バイリンガルサンプルデータ
-- ============================================================


-- ============================================================
-- Admin User (password: admin123)
-- ============================================================
INSERT INTO users (username, email, password) VALUES
('admin', 'admin@company.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ============================================================
-- Pages
-- ============================================================
INSERT INTO pages (slug, title_vi, title_ja, content_vi, content_ja, meta_description_vi, meta_description_ja) VALUES
('about', 'Giới Thiệu Công Ty', '会社概要',
'<h2>Về Chúng Tôi</h2>
<p>Công ty chúng tôi được thành lập từ năm 2015, chuyên cung cấp các giải pháp công nghệ tiên tiến cho doanh nghiệp trong nước và quốc tế. Với đội ngũ kỹ sư giàu kinh nghiệm, chúng tôi cam kết mang đến những sản phẩm chất lượng cao nhất.</p>

<h2>Tầm Nhìn</h2>
<p>Trở thành công ty công nghệ hàng đầu khu vực Đông Nam Á, kết nối Việt Nam và Nhật Bản thông qua công nghệ.</p>

<h2>Sứ Mệnh</h2>
<p>Tạo ra giá trị bền vững cho khách hàng bằng những giải pháp công nghệ sáng tạo và dịch vụ chuyên nghiệp nhất.</p>

<h2>Giá Trị Cốt Lõi</h2>
<ul>
<li><strong>Chất lượng:</strong> Cam kết chất lượng trong từng sản phẩm</li>
<li><strong>Sáng tạo:</strong> Không ngừng đổi mới và sáng tạo</li>
<li><strong>Hợp tác:</strong> Xây dựng quan hệ đối tác bền vững</li>
<li><strong>Con người:</strong> Con người là tài sản quý giá nhất</li>
</ul>',

'<h2>会社について</h2>
<p>当社は2015年に設立され、国内外の企業に先進的なテクノロジーソリューションを提供しています。経験豊富なエンジニアチームにより、最高品質の製品をお届けすることをお約束します。</p>

<h2>ビジョン</h2>
<p>東南アジアをリードするテクノロジー企業となり、テクノロジーを通じてベトナムと日本を繋ぎます。</p>

<h2>ミッション</h2>
<p>革新的なテクノロジーソリューションと最高のプロフェッショナルサービスにより、お客様に持続的な価値を創造します。</p>

<h2>コアバリュー</h2>
<ul>
<li><strong>品質:</strong> すべての製品に品質を約束</li>
<li><strong>イノベーション:</strong> 絶え間ない革新と創造</li>
<li><strong>パートナーシップ:</strong> 持続可能なパートナーシップの構築</li>
<li><strong>人材:</strong> 人材は最も貴重な資産</li>
</ul>',
'Công ty công nghệ hàng đầu, cung cấp giải pháp phần mềm chất lượng cao cho doanh nghiệp Việt Nam và Nhật Bản.',
'ベトナムと日本の企業に高品質なソフトウェアソリューションを提供するリーディングテクノロジー企業。'),

('contact', 'Liên Hệ', 'お問い合わせ',
'<p>Hãy liên hệ với chúng tôi để được tư vấn miễn phí. Chúng tôi luôn sẵn sàng hỗ trợ bạn.</p>',
'<p>無料コンサルティングのために、お気軽にお問い合わせください。私たちはいつでもお手伝いする準備ができています。</p>',
'Liên hệ công ty để được tư vấn miễn phí về các giải pháp công nghệ.',
'テクノロジーソリューションに関する無料コンサルティングについて、お問い合わせください。');

-- ============================================================
-- Services
-- ============================================================
INSERT INTO services (icon, title_vi, title_ja, description_vi, description_ja, detail_vi, detail_ja, sort_order) VALUES
('fas fa-laptop-code', 'Phát Triển Web', 'Web開発',
'Thiết kế và phát triển website chuyên nghiệp, responsive, tối ưu SEO.',
'プロフェッショナルでレスポンシブ、SEO最適化のWebサイトの設計と開発。',
'Chúng tôi cung cấp dịch vụ phát triển web toàn diện bao gồm thiết kế UI/UX, lập trình frontend và backend, tích hợp API, và tối ưu hiệu suất. Sử dụng các công nghệ mới nhất như React, Vue.js, Laravel, Node.js.',
'UI/UXデザイン、フロントエンド・バックエンド開発、API統合、パフォーマンス最適化を含む包括的なWeb開発サービスを提供します。React、Vue.js、Laravel、Node.jsなどの最新テクノロジーを使用。', 1),

('fas fa-mobile-alt', 'Phát Triển Mobile', 'モバイル開発',
'Xây dựng ứng dụng mobile đa nền tảng iOS và Android.',
'iOS・Android対応のクロスプラットフォームモバイルアプリ開発。',
'Phát triển ứng dụng mobile native và cross-platform sử dụng React Native, Flutter. Tích hợp push notification, payment gateway, và các tính năng nâng cao.',
'React Native、Flutterを使用したネイティブ・クロスプラットフォームモバイルアプリ開発。プッシュ通知、決済ゲートウェイ、高度な機能の統合。', 2),

('fas fa-cloud', 'Giải Pháp Cloud', 'クラウドソリューション',
'Triển khai và quản lý hạ tầng cloud AWS, Azure, GCP.',
'AWS、Azure、GCPクラウドインフラの展開と管理。',
'Tư vấn và triển khai giải pháp cloud computing bao gồm migration, auto-scaling, backup, monitoring, và security. Hỗ trợ AWS, Azure, Google Cloud.',
'マイグレーション、オートスケーリング、バックアップ、モニタリング、セキュリティを含むクラウドコンピューティングソリューションのコンサルティングと展開。', 3),

('fas fa-shield-alt', 'Bảo Mật', 'セキュリティ',
'Kiểm tra và tăng cường bảo mật cho hệ thống và ứng dụng.',
'システムとアプリケーションのセキュリティ検査と強化。',
'Dịch vụ bảo mật toàn diện: penetration testing, code review, vulnerability assessment, security audit, và đào tạo nhân viên về an toàn thông tin.',
'ペネトレーションテスト、コードレビュー、脆弱性評価、セキュリティ監査、情報セキュリティ研修を含む包括的なセキュリティサービス。', 4);

-- ============================================================
-- Blog Categories
-- ============================================================
INSERT INTO blog_categories (slug, name_vi, name_ja, description_vi, description_ja, sort_order) VALUES
('company-news', 'Tin Công Ty', '会社ニュース', 'Tin tức và sự kiện của công ty', '会社のニュースとイベント', 1),
('industry', 'Ngành Nghề', '業界情報', 'Tin tức và xu hướng ngành công nghệ', 'テクノロジー業界のニュースとトレンド', 2),
('knowledge', 'Kiến Thức', 'ナレッジ', 'Bài viết chia sẻ kiến thức kỹ thuật', '技術知識を共有する記事', 3),
('case-study', 'Dự Án Tiêu Biểu', '事例紹介', 'Giới thiệu các dự án đã thực hiện', '実施したプロジェクトの紹介', 4),
('recruitment', 'Tuyển Dụng', '採用情報', 'Thông tin tuyển dụng', '採用情報', 5);

-- ============================================================
-- Tags
-- ============================================================
INSERT INTO tags (slug, name_vi, name_ja) VALUES
('php', 'PHP', 'PHP'),
('javascript', 'JavaScript', 'JavaScript'),
('react', 'React', 'React'),
('laravel', 'Laravel', 'Laravel'),
('cloud', 'Cloud', 'クラウド'),
('mobile', 'Mobile', 'モバイル'),
('ai', 'Trí Tuệ Nhân Tạo', 'AI・人工知能'),
('seo', 'SEO', 'SEO'),
('security', 'Bảo Mật', 'セキュリティ'),
('devops', 'DevOps', 'DevOps');

-- ============================================================
-- Posts
-- ============================================================
INSERT INTO posts (slug, category_id, title_vi, title_ja, summary_vi, summary_ja, content_vi, content_ja, published_at, view_count) VALUES
('xu-huong-cong-nghe-2026', 3,
'Xu Hướng Công Nghệ Năm 2026', '2026年のテクノロジートレンド',
'Tổng hợp các xu hướng công nghệ nổi bật nhất năm 2026 mà doanh nghiệp cần biết.',
'企業が知っておくべき2026年の最も注目すべきテクノロジートレンドのまとめ。',
'<h2>1. AI và Machine Learning</h2><p>Trí tuệ nhân tạo tiếp tục là xu hướng hàng đầu trong năm 2026. Các doanh nghiệp ngày càng ứng dụng AI vào quy trình kinh doanh để tăng hiệu suất và giảm chi phí.</p><h2>2. Cloud Computing</h2><p>Điện toán đám mây phát triển mạnh mẽ với sự phổ biến của multi-cloud strategy. Doanh nghiệp cần linh hoạt trong việc chọn nhà cung cấp cloud.</p><h2>3. Cybersecurity</h2><p>An ninh mạng trở thành ưu tiên hàng đầu khi số lượng tấn công mạng gia tăng. Zero Trust Architecture trở thành tiêu chuẩn bảo mật mới.</p>',
'<h2>1. AIと機械学習</h2><p>人工知能は2026年も引き続きトップトレンドです。企業はビジネスプロセスにAIを活用し、効率性の向上とコスト削減を実現しています。</p><h2>2. クラウドコンピューティング</h2><p>マルチクラウド戦略の普及により、クラウドコンピューティングは力強く成長しています。企業はクラウドプロバイダーの選択に柔軟性が必要です。</p><h2>3. サイバーセキュリティ</h2><p>サイバー攻撃の増加により、サイバーセキュリティが最優先事項となっています。ゼロトラストアーキテクチャが新しいセキュリティ標準に。</p>',
'2026-02-10', 156),

('huong-dan-php-mvc', 3,
'Hướng Dẫn Xây Dựng Ứng Dụng PHP MVC', 'PHP MVCアプリケーション構築ガイド',
'Hướng dẫn chi tiết cách xây dựng ứng dụng web với PHP thuần theo mô hình MVC.',
'PHPでMVCパターンに沿ったWebアプリケーションの構築方法の詳細ガイド。',
'<h2>MVC là gì?</h2><p>MVC (Model-View-Controller) là một mô hình kiến trúc phần mềm chia ứng dụng thành 3 phần chính: Model (dữ liệu), View (giao diện), Controller (xử lý logic).</p><h2>Lợi ích của MVC</h2><p>- Tách biệt logic xử lý và giao diện<br>- Dễ bảo trì và mở rộng<br>- Code rõ ràng, dễ hiểu</p>',
'<h2>MVCとは？</h2><p>MVC（Model-View-Controller）はソフトウェアアーキテクチャパターンで、アプリケーションを3つの主要部分に分割します：Model（データ）、View（インターフェース）、Controller（ロジック処理）。</p><h2>MVCのメリット</h2><p>- ロジックとインターフェースの分離<br>- メンテナンスと拡張が容易<br>- コードが明確で理解しやすい</p>',
'2026-02-08', 89),

('du-an-ecommerce-nhat-ban', 4,
'Dự Án E-Commerce Cho Thị Trường Nhật Bản', '日本市場向けEコマースプロジェクト',
'Chia sẻ kinh nghiệm phát triển hệ thống thương mại điện tử cho khách hàng Nhật Bản.',
'日本のお客様向けEコマースシステム開発の経験を共有。',
'<h2>Giới thiệu dự án</h2><p>Năm 2025, chúng tôi đã hoàn thành dự án xây dựng hệ thống e-commerce cho một công ty bán lẻ lớn tại Nhật Bản. Hệ thống xử lý hơn 10,000 đơn hàng mỗi ngày.</p><h2>Thách thức</h2><p>- Đa ngôn ngữ (Nhật, Anh, Việt)<br>- Tích hợp nhiều cổng thanh toán Nhật Bản<br>- Yêu cầu performance cao</p>',
'<h2>プロジェクト紹介</h2><p>2025年、日本の大手小売企業向けEコマースシステムの構築プロジェクトを完了しました。システムは1日10,000件以上の注文を処理します。</p><h2>課題</h2><p>- 多言語対応（日本語、英語、ベトナム語）<br>- 複数の日本の決済ゲートウェイとの統合<br>- 高いパフォーマンス要件</p>',
'2026-02-05', 234);

-- Post-Tags mapping
INSERT INTO post_tags (post_id, tag_id) VALUES
(1, 5), (1, 7), (1, 9),
(2, 1), (2, 4),
(3, 2), (3, 3);

-- ============================================================
-- Team Members
-- ============================================================
INSERT INTO team_members (name_vi, name_ja, position_vi, position_ja, bio_vi, bio_ja, sort_order) VALUES
('Nguyễn Văn A', 'グエン・ヴァン・A', 'Giám Đốc Điều Hành', '代表取締役CEO',
'Hơn 15 năm kinh nghiệm trong lĩnh vực công nghệ. Từng làm việc tại nhiều công ty công nghệ lớn tại Nhật Bản và Việt Nam.',
'テクノロジー分野で15年以上の経験。日本とベトナムの大手テクノロジー企業で勤務経験あり。', 1),

('Trần Thị B', 'チャン・ティー・B', 'Giám Đốc Công Nghệ', '最高技術責任者CTO',
'Chuyên gia về kiến trúc phần mềm và cloud computing. Master từ Đại học Tokyo.',
'ソフトウェアアーキテクチャとクラウドコンピューティングの専門家。東京大学修士。', 2),

('Lê Văn C', 'レー・ヴァン・C', 'Trưởng Phòng Phát Triển', '開発部長',
'10 năm kinh nghiệm fullstack development. Passionate về React và Node.js.',
'フルスタック開発10年の経験。ReactとNode.jsに情熱を持つ。', 3),

('Phạm Thị D', 'ファム・ティー・D', 'Trưởng Phòng Thiết Kế', 'デザイン部長',
'Chuyên gia UI/UX với nhiều giải thưởng thiết kế quốc tế.',
'多くの国際デザイン賞を受賞したUI/UXの専門家。', 4);

-- ============================================================
-- Sliders
-- ============================================================
INSERT INTO sliders (image, title_vi, title_ja, subtitle_vi, subtitle_ja, link, sort_order) VALUES
('', 'Giải Pháp Công Nghệ Tiên Tiến', '先進的テクノロジーソリューション',
'Kết nối Việt Nam và Nhật Bản qua công nghệ', 'テクノロジーでベトナムと日本を繋ぐ', '#services', 1),
('', 'Đội Ngũ Chuyên Nghiệp', 'プロフェッショナルチーム',
'Hơn 50 kỹ sư giàu kinh nghiệm', '50名以上の経験豊富なエンジニア', '#team', 2),
('', 'Đối Tác Tin Cậy', '信頼できるパートナー',
'Đồng hành cùng hơn 100 doanh nghiệp', '100社以上の企業と共に歩む', '#about', 3);

-- ============================================================
-- Settings
-- ============================================================
INSERT INTO settings (setting_key, value_vi, value_ja, group_name) VALUES
('company_name', 'Công Ty Công Nghệ ABC', 'ABCテクノロジー株式会社', 'company'),
('company_address', '123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh', '〒100-0001 東京都千代田区1-2-3', 'company'),
('company_phone', '+84 28 1234 5678', '+81 3-1234-5678', 'company'),
('company_email', 'info@abc-tech.com', 'info@abc-tech.co.jp', 'company'),
('company_fax', '+84 28 1234 5679', '+81 3-1234-5679', 'company'),
('site_title', 'ABC Technology - Giải Pháp Công Nghệ', 'ABCテクノロジー - テクノロジーソリューション', 'seo'),
('site_description', 'Công ty công nghệ hàng đầu cung cấp giải pháp phần mềm, phát triển web và mobile cho doanh nghiệp Việt Nam và Nhật Bản.', 'ベトナムと日本の企業にソフトウェアソリューション、Web・モバイル開発を提供するリーディングテクノロジー企業。', 'seo'),
('facebook', 'https://facebook.com/abc-tech', 'https://facebook.com/abc-tech', 'social'),
('twitter', 'https://twitter.com/abc-tech', 'https://twitter.com/abc-tech', 'social'),
('linkedin', 'https://linkedin.com/company/abc-tech', 'https://linkedin.com/company/abc-tech', 'social'),
('youtube', 'https://youtube.com/abc-tech', 'https://youtube.com/abc-tech', 'social'),
('google_analytics', '', '', 'seo'),
('google_maps', 'https://maps.google.com/?q=10.7769,106.7009', 'https://maps.google.com/?q=35.6762,139.6503', 'company');
