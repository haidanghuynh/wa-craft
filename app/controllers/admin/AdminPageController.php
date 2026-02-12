<?php
class AdminPageController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void
    {
        $model = new Page();
        $pages = $model->findAll('id', 'ASC');
        $this->view('admin/pages/index', ['pages' => $pages]);
    }

    public function edit(string $id): void
    {
        $model = new Page();
        $page = $model->find((int)$id);
        if (!$page) { $this->redirect(BASE_URL . '/admin/pages'); return; }
        $this->view('admin/pages/edit', ['page' => $page]);
    }

    public function update(string $id): void
    {
        $model = new Page();
        $data = [
            'title_vi' => $this->input('title_vi'),
            'title_ja' => $this->input('title_ja'),
            'content_vi' => $_POST['content_vi'] ?? '',
            'content_ja' => $_POST['content_ja'] ?? '',
            'meta_description_vi' => $this->input('meta_description_vi'),
            'meta_description_ja' => $this->input('meta_description_ja'),
            'meta_keywords_vi' => $this->input('meta_keywords_vi'),
            'meta_keywords_ja' => $this->input('meta_keywords_ja'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $og = $this->uploadFile('og_image', 'pages');
        if ($og) $data['og_image'] = $og;

        $model->update((int)$id, $data);
        $this->redirect(BASE_URL . '/admin/pages');
    }
}
