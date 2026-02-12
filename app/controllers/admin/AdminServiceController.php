<?php
class AdminServiceController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void { $m = new Service(); $this->view('admin/services/index', ['services' => $m->findAll('sort_order', 'ASC')]); }

    public function create(): void { $this->view('admin/services/create'); }

    public function store(): void
    {
        $m = new Service();
        $m->create([
            'icon' => $this->input('icon', 'fas fa-cog'),
            'title_vi' => $this->input('title_vi'), 'title_ja' => $this->input('title_ja'),
            'description_vi' => $this->input('description_vi'), 'description_ja' => $this->input('description_ja'),
            'detail_vi' => $_POST['detail_vi'] ?? '', 'detail_ja' => $_POST['detail_ja'] ?? '',
            'sort_order' => (int)$this->input('sort_order', '0'), 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        $this->redirect(BASE_URL . '/admin/services');
    }

    public function edit(string $id): void
    {
        $m = new Service(); $s = $m->find((int)$id);
        if (!$s) { $this->redirect(BASE_URL . '/admin/services'); return; }
        $this->view('admin/services/edit', ['service' => $s]);
    }

    public function update(string $id): void
    {
        $m = new Service();
        $m->update((int)$id, [
            'icon' => $this->input('icon', 'fas fa-cog'),
            'title_vi' => $this->input('title_vi'), 'title_ja' => $this->input('title_ja'),
            'description_vi' => $this->input('description_vi'), 'description_ja' => $this->input('description_ja'),
            'detail_vi' => $_POST['detail_vi'] ?? '', 'detail_ja' => $_POST['detail_ja'] ?? '',
            'sort_order' => (int)$this->input('sort_order', '0'), 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ]);
        $this->redirect(BASE_URL . '/admin/services');
    }

    public function delete(string $id): void { $m = new Service(); $m->delete((int)$id); $this->redirect(BASE_URL . '/admin/services'); }
}
