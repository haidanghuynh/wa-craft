<?php
class HomeController extends Controller
{
    public function index(): void
    {
        $sliderModel = new Slider();
        $serviceModel = new Service();
        $postModel = new Post();
        $settingModel = new Setting();
        $teamModel = new TeamMember();

        $sliders = $this->localizeList($sliderModel->findActive('sort_order', 'ASC'));
        $services = $this->localizeList($serviceModel->findActive('sort_order', 'ASC'));
        $latestPosts = $this->localizeList($postModel->getLatest(3));
        $settings = $settingModel->getAllAsMap($this->lang);
        $team = $this->localizeList($teamModel->findActive('sort_order', 'ASC'));

        $this->jsonResponse([
            'sliders' => $sliders,
            'services' => array_slice($services, 0, 3),
            'latest_posts' => $latestPosts,
            'settings' => $settings,
            'team' => $team,
            'highlights' => [
                ['icon' => 'fas fa-calendar-alt', 'number' => '10+', 'label' => $this->lang === 'vi' ? 'Năm Kinh Nghiệm' : '年の経験'],
                ['icon' => 'fas fa-users', 'number' => '50+', 'label' => $this->lang === 'vi' ? 'Kỹ Sư' : 'エンジニア'],
                ['icon' => 'fas fa-project-diagram', 'number' => '200+', 'label' => $this->lang === 'vi' ? 'Dự Án' : 'プロジェクト'],
                ['icon' => 'fas fa-handshake', 'number' => '100+', 'label' => $this->lang === 'vi' ? 'Đối Tác' : 'パートナー'],
            ]
        ]);
    }

    public function page(): void
    {
        // SSR: render full HTML for SEO
        $lang = $_GET['url'] ?? '';
        if ($lang === 'ja') {
            $this->lang = 'ja';
        } else {
            $this->lang = 'vi';
        }
        $_SESSION['lang'] = $this->lang;
        $_GET['lang'] = $this->lang;

        $settingModel = new Setting();
        $settings = $settingModel->getAllAsMap($this->lang);

        $this->view('public/layout', [
            'currentPage' => 'home',
            'settings' => $settings,
            'pageTitle' => $settings['site_title'] ?? APP_NAME,
            'metaDescription' => $settings['site_description'] ?? '',
        ]);
    }
}
