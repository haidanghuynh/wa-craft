<?php
class TeamController extends Controller
{
    public function index(): void
    {
        $model = new TeamMember();
        $members = $this->localizeList($model->findActive('sort_order', 'ASC'));
        $this->jsonResponse(['members' => $members]);
    }

    public function renderPage(string $lang): void
    {
        $this->lang = in_array($lang, SUPPORTED_LANGS) ? $lang : DEFAULT_LANG;
        $_SESSION['lang'] = $this->lang;
        $_GET['lang'] = $this->lang;

        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap($this->lang);
        $pageTitle = ($this->lang === 'vi' ? 'Đội Ngũ' : 'チーム紹介') . ' - ' . ($settings['company_name'] ?? APP_NAME);

        $this->view('public/layout', [
            'currentPage' => 'team',
            'settings' => $settings,
            'pageTitle' => $pageTitle,
            'metaDescription' => $this->lang === 'vi' ? 'Đội ngũ chuyên gia giàu kinh nghiệm' : '経験豊富な専門家チーム',
        ]);
    }
}
