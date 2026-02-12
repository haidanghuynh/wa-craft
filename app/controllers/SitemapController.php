<?php
class SitemapController extends Controller
{
    public function index(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $baseUrl = BASE_URL;

        $postModel = new Post();
        $posts = $postModel->findActive('published_at', 'DESC');

        $pageModel = new Page();
        $pages = $pageModel->findActive();

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        // Home pages
        foreach (['vi', 'ja'] as $lang) {
            $otherLang = $lang === 'vi' ? 'ja' : 'vi';
            echo "<url>\n";
            echo "  <loc>{$baseUrl}/{$lang}</loc>\n";
            echo "  <xhtml:link rel=\"alternate\" hreflang=\"{$otherLang}\" href=\"{$baseUrl}/{$otherLang}\"/>\n";
            echo "  <priority>1.0</priority>\n";
            echo "</url>\n";
        }

        // Static pages
        $staticPages = ['about', 'services', 'blog', 'team', 'contact'];
        foreach ($staticPages as $slug) {
            foreach (['vi', 'ja'] as $lang) {
                $otherLang = $lang === 'vi' ? 'ja' : 'vi';
                echo "<url>\n";
                echo "  <loc>{$baseUrl}/{$lang}/{$slug}</loc>\n";
                echo "  <xhtml:link rel=\"alternate\" hreflang=\"{$otherLang}\" href=\"{$baseUrl}/{$otherLang}/{$slug}\"/>\n";
                echo "  <priority>0.8</priority>\n";
                echo "</url>\n";
            }
        }

        // Blog posts
        foreach ($posts as $post) {
            foreach (['vi', 'ja'] as $lang) {
                $otherLang = $lang === 'vi' ? 'ja' : 'vi';
                echo "<url>\n";
                echo "  <loc>{$baseUrl}/{$lang}/blog/{$post['slug']}</loc>\n";
                echo "  <xhtml:link rel=\"alternate\" hreflang=\"{$otherLang}\" href=\"{$baseUrl}/{$otherLang}/blog/{$post['slug']}\"/>\n";
                echo "  <lastmod>{$post['published_at']}</lastmod>\n";
                echo "  <priority>0.6</priority>\n";
                echo "</url>\n";
            }
        }

        echo '</urlset>';
        exit;
    }
}
