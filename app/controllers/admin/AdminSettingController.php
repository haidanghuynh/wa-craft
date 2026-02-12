<?php
class AdminSettingController extends Controller
{
    public function __construct() { parent::__construct(); if (empty($_SESSION['admin_id'])) { $this->redirect(BASE_URL . '/admin/login'); } }

    public function index(): void
    {
        $m = new Setting();
        $settings = $m->findAll('id', 'ASC');
        $grouped = [];
        foreach ($settings as $s) { $grouped[$s['group_name']][] = $s; }
        $this->view('admin/settings/edit', ['grouped' => $grouped]);
    }

    public function update(): void
    {
        $m = new Setting();
        $keys = $_POST['keys'] ?? [];
        $valuesVi = $_POST['values_vi'] ?? [];
        $valuesJa = $_POST['values_ja'] ?? [];
        foreach ($keys as $i => $key) {
            $existing = $m->get($key);
            if ($existing) {
                $m->update($existing['id'], [
                    'value_vi' => $valuesVi[$i] ?? '',
                    'value_ja' => $valuesJa[$i] ?? '',
                ]);
            }
        }
        $this->redirect(BASE_URL . '/admin/settings');
    }
}
