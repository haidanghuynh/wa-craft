<?php
class PageController extends Controller
{
    public function show(string $slug): void
    {
        $pageModel = new Page();
        $page = $pageModel->findOneWhere(['slug' => $slug, 'is_active' => 1]);
        if (!$page) {
            $this->jsonResponse(['error' => 'Page not found'], 404);
            return;
        }
        $this->jsonResponse($this->localizeItem($page));
    }

    public function renderPage(string $lang): void
    {
        $this->lang = in_array($lang, SUPPORTED_LANGS) ? $lang : DEFAULT_LANG;
        $_SESSION['lang'] = $this->lang;
        $_GET['lang'] = $this->lang;

        $url = $_GET['url'] ?? '';
        $parts = explode('/', trim($url, '/'));
        $currentPage = $parts[1] ?? 'about';

        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap($this->lang);

        $pageModel = new Page();
        $page = $pageModel->findOneWhere(['slug' => $currentPage]);
        $pageTitle = $page ? $this->getLocalized($page, 'title') . ' - ' . ($settings['company_name'] ?? APP_NAME) : APP_NAME;
        $metaDescription = $page ? $this->getLocalized($page, 'meta_description') : ($settings['site_description'] ?? '');

        $this->view('public/layout', [
            'currentPage' => $currentPage,
            'settings' => $settings,
            'pageTitle' => $pageTitle,
            'metaDescription' => $metaDescription,
        ]);
    }
}
