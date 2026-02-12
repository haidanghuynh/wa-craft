<?php
class AdminBlogController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void
    {
        $model = new Post();
        $page = (int)($_GET['page'] ?? 1);
        $result = $model->paginate($page, 15, [], 'created_at', 'DESC');
        // Get category names
        $catModel = new BlogCategory();
        $categories = $catModel->findAll('sort_order', 'ASC');
        $catMap = [];
        foreach ($categories as $c) { $catMap[$c['id']] = $c; }
        foreach ($result['data'] as &$post) {
            $post['category_name'] = $catMap[$post['category_id']]['name_vi'] ?? '—';
        }
        $this->view('admin/blog/index', ['posts' => $result]);
    }

    public function create(): void
    {
        $catModel = new BlogCategory();
        $tagModel = new Tag();
        $this->view('admin/blog/create', [
            'categories' => $catModel->findAll('sort_order', 'ASC'),
            'tags' => $tagModel->findAll('name_vi', 'ASC'),
        ]);
    }

    public function store(): void
    {
        $model = new Post();
        $data = [
            'slug' => $this->input('slug') ?: $this->slugify($this->input('title_vi')),
            'category_id' => (int)$this->input('category_id') ?: null,
            'title_vi' => $this->input('title_vi'),
            'title_ja' => $this->input('title_ja'),
            'summary_vi' => $this->input('summary_vi'),
            'summary_ja' => $this->input('summary_ja'),
            'content_vi' => $_POST['content_vi'] ?? '',
            'content_ja' => $_POST['content_ja'] ?? '',
            'meta_description_vi' => $this->input('meta_description_vi'),
            'meta_description_ja' => $this->input('meta_description_ja'),
            'meta_keywords_vi' => $this->input('meta_keywords_vi'),
            'meta_keywords_ja' => $this->input('meta_keywords_ja'),
            'published_at' => $this->input('published_at') ?: date('Y-m-d'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        $thumbnail = $this->uploadFile('thumbnail', 'blog');
        if ($thumbnail) $data['thumbnail'] = $thumbnail;
        $ogImage = $this->uploadFile('og_image', 'blog');
        if ($ogImage) $data['og_image'] = $ogImage;

        $id = $model->create($data);

        // Sync tags
        $tagIds = $_POST['tags'] ?? [];
        if (!empty($tagIds)) {
            $model->syncTags($id, array_map('intval', $tagIds));
        }

        $this->redirect(BASE_URL . '/admin/blog');
    }

    public function edit(string $id): void
    {
        $model = new Post();
        $post = $model->find((int)$id);
        if (!$post) { $this->redirect(BASE_URL . '/admin/blog'); return; }

        $catModel = new BlogCategory();
        $tagModel = new Tag();
        $selectedTags = array_column($model->getTags((int)$id), 'id');

        $this->view('admin/blog/edit', [
            'post' => $post,
            'categories' => $catModel->findAll('sort_order', 'ASC'),
            'tags' => $tagModel->findAll('name_vi', 'ASC'),
            'selectedTags' => $selectedTags,
        ]);
    }

    public function update(string $id): void
    {
        $model = new Post();
        $data = [
            'slug' => $this->input('slug'),
            'category_id' => (int)$this->input('category_id') ?: null,
            'title_vi' => $this->input('title_vi'),
            'title_ja' => $this->input('title_ja'),
            'summary_vi' => $this->input('summary_vi'),
            'summary_ja' => $this->input('summary_ja'),
            'content_vi' => $_POST['content_vi'] ?? '',
            'content_ja' => $_POST['content_ja'] ?? '',
            'meta_description_vi' => $this->input('meta_description_vi'),
            'meta_description_ja' => $this->input('meta_description_ja'),
            'meta_keywords_vi' => $this->input('meta_keywords_vi'),
            'meta_keywords_ja' => $this->input('meta_keywords_ja'),
            'published_at' => $this->input('published_at') ?: date('Y-m-d'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        $thumbnail = $this->uploadFile('thumbnail', 'blog');
        if ($thumbnail) $data['thumbnail'] = $thumbnail;
        $ogImage = $this->uploadFile('og_image', 'blog');
        if ($ogImage) $data['og_image'] = $ogImage;

        $model->update((int)$id, $data);

        $tagIds = $_POST['tags'] ?? [];
        $model->syncTags((int)$id, array_map('intval', $tagIds));

        $this->redirect(BASE_URL . '/admin/blog');
    }

    public function delete(string $id): void
    {
        $model = new Post();
        $post = $model->find((int)$id);
        if ($post) {
            $this->deleteFile($post['thumbnail']);
            $model->delete((int)$id);
        }
        $this->redirect(BASE_URL . '/admin/blog');
    }

    private function slugify(string $text): string
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[àáạảãâầấậẩẫăằắặẳẵ]/u', 'a', $text);
        $text = preg_replace('/[èéẹẻẽêềếệểễ]/u', 'e', $text);
        $text = preg_replace('/[ìíịỉĩ]/u', 'i', $text);
        $text = preg_replace('/[òóọỏõôồốộổỗơờớợởỡ]/u', 'o', $text);
        $text = preg_replace('/[ùúụủũưừứựửữ]/u', 'u', $text);
        $text = preg_replace('/[ỳýỵỷỹ]/u', 'y', $text);
        $text = preg_replace('/đ/u', 'd', $text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }
}
