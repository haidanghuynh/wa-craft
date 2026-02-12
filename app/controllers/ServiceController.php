<?php
class ServiceController extends Controller
{
    public function index(): void
    {
        $model = new Service();
        $services = $this->localizeList($model->findActive('sort_order', 'ASC'));
        $this->jsonResponse(['services' => $services]);
    }

    public function show(string $id): void
    {
        $model = new Service();
        $service = $model->find((int)$id);
        if (!$service || !$service['is_active']) {
            $this->jsonResponse(['error' => 'Service not found'], 404);
            return;
        }
        $this->jsonResponse($this->localizeItem($service));
    }

    public function renderPage(string $lang): void
    {
        $this->lang = in_array($lang, SUPPORTED_LANGS) ? $lang : DEFAULT_LANG;
        $_SESSION['lang'] = $this->lang;
        $_GET['lang'] = $this->lang;

        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap($this->lang);
        $pageTitle = ($this->lang === 'vi' ? 'Dịch Vụ' : 'サービス') . ' - ' . ($settings['company_name'] ?? APP_NAME);

        $this->view('public/layout', [
            'currentPage' => 'services',
            'settings' => $settings,
            'pageTitle' => $pageTitle,
            'metaDescription' => $this->lang === 'vi' ? 'Các dịch vụ công nghệ chất lượng cao' : '高品質なテクノロジーサービス',
        ]);
    }
}
