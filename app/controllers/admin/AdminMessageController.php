<?php
class AdminMessageController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void
    {
        $m = new ContactMessage();
        $messages = $m->findAll('created_at', 'DESC');
        $this->view('admin/messages/index', ['messages' => $messages]);
    }

    public function view(string $id): void
    {
        $m = new ContactMessage();
        $msg = $m->find((int)$id);
        if (!$msg) { $this->redirect(BASE_URL . '/admin/messages'); return; }
        if (!$msg['is_read']) { $m->update((int)$id, ['is_read' => 1]); }
        $this->view('admin/messages/view', ['message' => $msg]);
    }

    public function delete(string $id): void
    {
        $m = new ContactMessage(); $m->delete((int)$id);
        $this->redirect(BASE_URL . '/admin/messages');
    }
}
