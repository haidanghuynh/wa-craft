<?php
class AdminSliderController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void { $m = new Slider(); $this->view('admin/sliders/index', ['sliders' => $m->findAll('sort_order', 'ASC')]); }
    public function create(): void { $this->view('admin/sliders/create'); }

    public function store(): void
    {
        $m = new Slider();
        $data = [
            'title_vi' => $this->input('title_vi'), 'title_ja' => $this->input('title_ja'),
            'subtitle_vi' => $this->input('subtitle_vi'), 'subtitle_ja' => $this->input('subtitle_ja'),
            'link' => $this->input('link'), 'sort_order' => (int)$this->input('sort_order', '0'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $img = $this->uploadFile('image', 'sliders');
        if ($img) $data['image'] = $img;
        $m->create($data);
        $this->redirect(BASE_URL . '/admin/sliders');
    }

    public function edit(string $id): void
    {
        $m = new Slider(); $s = $m->find((int)$id);
        if (!$s) { $this->redirect(BASE_URL . '/admin/sliders'); return; }
        $this->view('admin/sliders/edit', ['slider' => $s]);
    }

    public function update(string $id): void
    {
        $m = new Slider();
        $data = [
            'title_vi' => $this->input('title_vi'), 'title_ja' => $this->input('title_ja'),
            'subtitle_vi' => $this->input('subtitle_vi'), 'subtitle_ja' => $this->input('subtitle_ja'),
            'link' => $this->input('link'), 'sort_order' => (int)$this->input('sort_order', '0'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $img = $this->uploadFile('image', 'sliders');
        if ($img) $data['image'] = $img;
        $m->update((int)$id, $data);
        $this->redirect(BASE_URL . '/admin/sliders');
    }

    public function delete(string $id): void
    {
        $m = new Slider(); $s = $m->find((int)$id);
        if ($s) { $this->deleteFile($s['image']); $m->delete((int)$id); }
        $this->redirect(BASE_URL . '/admin/sliders');
    }
}
