<?php
class AdminTeamController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void { $m = new TeamMember(); $this->view('admin/team/index', ['members' => $m->findAll('sort_order', 'ASC')]); }
    public function create(): void { $this->view('admin/team/create'); }

    public function store(): void
    {
        $m = new TeamMember();
        $data = [
            'name_vi' => $this->input('name_vi'), 'name_ja' => $this->input('name_ja'),
            'position_vi' => $this->input('position_vi'), 'position_ja' => $this->input('position_ja'),
            'bio_vi' => $this->input('bio_vi'), 'bio_ja' => $this->input('bio_ja'),
            'sort_order' => (int)$this->input('sort_order', '0'), 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $photo = $this->uploadFile('photo', 'team');
        if ($photo) $data['photo'] = $photo;
        $m->create($data);
        $this->redirect(BASE_URL . '/admin/team');
    }

    public function edit(string $id): void
    {
        $m = new TeamMember(); $member = $m->find((int)$id);
        if (!$member) { $this->redirect(BASE_URL . '/admin/team'); return; }
        $this->view('admin/team/edit', ['member' => $member]);
    }

    public function update(string $id): void
    {
        $m = new TeamMember();
        $data = [
            'name_vi' => $this->input('name_vi'), 'name_ja' => $this->input('name_ja'),
            'position_vi' => $this->input('position_vi'), 'position_ja' => $this->input('position_ja'),
            'bio_vi' => $this->input('bio_vi'), 'bio_ja' => $this->input('bio_ja'),
            'sort_order' => (int)$this->input('sort_order', '0'), 'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $photo = $this->uploadFile('photo', 'team');
        if ($photo) $data['photo'] = $photo;
        $m->update((int)$id, $data);
        $this->redirect(BASE_URL . '/admin/team');
    }

    public function delete(string $id): void
    {
        $m = new TeamMember(); $member = $m->find((int)$id);
        if ($member) { $this->deleteFile($member['photo']); $m->delete((int)$id); }
        $this->redirect(BASE_URL . '/admin/team');
    }
}
