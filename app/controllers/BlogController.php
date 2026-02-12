<?php
class BlogController extends Controller
{
    public function index(): void
    {
        $postModel = new Post();
        $page = (int)($_GET['page'] ?? 1);
        $result = $postModel->paginateActive($page, POSTS_PER_PAGE);
        $result['data'] = $this->localizeList($result['data']);

        $categoryModel = new BlogCategory();
        $categories = $this->localizeList($categoryModel->findActive('sort_order', 'ASC'));

        $this->jsonResponse([
            'posts' => $result,
            'categories' => $categories,
        ]);
    }

    public function byCategory(string $slug): void
    {
        $categoryModel = new BlogCategory();
        $category = $categoryModel->findOneWhere(['slug' => $slug, 'is_active' => 1]);
        if (!$category) {
            $this->jsonResponse(['error' => 'Category not found'], 404);
            return;
        }

        $postModel = new Post();
        $page = (int)($_GET['page'] ?? 1);
        $result = $postModel->paginateActive($page, POSTS_PER_PAGE, $category['id']);
        $result['data'] = $this->localizeList($result['data']);

        $this->jsonResponse([
            'posts' => $result,
            'category' => $this->localizeItem($category),
        ]);
    }

    public function byTag(string $slug): void
    {
        $tagModel = new Tag();
        $tag = $tagModel->findOneWhere(['slug' => $slug]);
        if (!$tag) {
            $this->jsonResponse(['error' => 'Tag not found'], 404);
            return;
        }

        $postModel = new Post();
        $page = (int)($_GET['page'] ?? 1);
        $result = $postModel->findByTag($slug, $page, POSTS_PER_PAGE);
        $result['data'] = $this->localizeList($result['data']);

        $this->jsonResponse([
            'posts' => $result,
            'tag' => $this->localizeItem($tag),
        ]);
    }

    public function show(string $slug): void
    {
        $postModel = new Post();
        $post = $postModel->findBySlug($slug);
        if (!$post) {
            $this->jsonResponse(['error' => 'Post not found'], 404);
            return;
        }

        $postModel->incrementViews($post['id']);
        $tags = $this->localizeList($postModel->getTags($post['id']));
        $related = $this->localizeList($postModel->getRelated($post['id'], $post['category_id']));

        $this->jsonResponse([
            'post' => $this->localizeItem($post),
            'tags' => $tags,
            'related' => $related,
        ]);
    }

    public function renderPage(string $lang): void
    {
        $this->lang = in_array($lang, SUPPORTED_LANGS) ? $lang : DEFAULT_LANG;
        $_SESSION['lang'] = $this->lang;
        $_GET['lang'] = $this->lang;

        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap($this->lang);
        $pageTitle = ($this->lang === 'vi' ? 'Blog' : 'ブログ') . ' - ' . ($settings['company_name'] ?? APP_NAME);

        $this->view('public/layout', [
            'currentPage' => 'blog',
            'settings' => $settings,
            'pageTitle' => $pageTitle,
            'metaDescription' => $this->lang === 'vi' ? 'Bài viết, kiến thức và tin tức công nghệ' : 'テクノロジーに関する記事、知識、ニュース',
        ]);
    }

    public function renderPost(string $lang, string $slug): void
    {
        $this->lang = in_array($lang, SUPPORTED_LANGS) ? $lang : DEFAULT_LANG;
        $_SESSION['lang'] = $this->lang;
        $_GET['lang'] = $this->lang;

        $postModel = new Post();
        $post = $postModel->findBySlug($slug);

        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap($this->lang);

        $pageTitle = $post ? $this->getLocalized($post, 'title') . ' - ' . ($settings['company_name'] ?? APP_NAME) : 'Blog';
        $metaDescription = $post ? $this->getLocalized($post, 'meta_description') ?: $this->getLocalized($post, 'summary') : '';

        $this->view('public/layout', [
            'currentPage' => 'blog-detail',
            'settings' => $settings,
            'pageTitle' => $pageTitle,
            'metaDescription' => mb_substr(strip_tags($metaDescription), 0, 155),
            'postSlug' => $slug,
        ]);
    }
}
