<?php
class AdminCategoryController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void { $m = new BlogCategory(); $this->view('admin/categories/index', ['categories' => $m->findAll('sort_order', 'ASC')]); }
    public function create(): void { $this->view('admin/categories/create'); }

    public function store(): void
    {
        $m = new BlogCategory();
        $m->create([
            'slug' => $this->input('slug'), 'name_vi' => $this->input('name_vi'), 'name_ja' => $this->input('name_ja'),
            'description_vi' => $this->input('description_vi'), 'description_ja' => $this->input('description_ja'),
            'sort_order' => (int)$this->input('sort_order', '0'), 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        $this->redirect(BASE_URL . '/admin/categories');
    }

    public function edit(string $id): void
    {
        $m = new BlogCategory(); $cat = $m->find((int)$id);
        if (!$cat) { $this->redirect(BASE_URL . '/admin/categories'); return; }
        $this->view('admin/categories/edit', ['category' => $cat]);
    }

    public function update(string $id): void
    {
        $m = new BlogCategory();
        $m->update((int)$id, [
            'slug' => $this->input('slug'), 'name_vi' => $this->input('name_vi'), 'name_ja' => $this->input('name_ja'),
            'description_vi' => $this->input('description_vi'), 'description_ja' => $this->input('description_ja'),
            'sort_order' => (int)$this->input('sort_order', '0'), 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        $this->redirect(BASE_URL . '/admin/categories');
    }

    public function delete(string $id): void { $m = new BlogCategory(); $m->delete((int)$id); $this->redirect(BASE_URL . '/admin/categories'); }
}
