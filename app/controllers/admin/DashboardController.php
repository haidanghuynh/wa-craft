<?php
class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['admin_id'])) {
            $this->redirect(BASE_URL . '/admin/login');
        }
    }

    public function index(): void
    {
        $postModel = new Post();
        $serviceModel = new Service();
        $teamModel = new TeamMember();
        $messageModel = new ContactMessage();

        $stats = [
            'posts' => $postModel->count(),
            'services' => $serviceModel->count(),
            'team' => $teamModel->count(),
            'messages' => $messageModel->count(['is_read' => 0]),
        ];

        $latestPosts = $postModel->getLatest(5);
        $latestMessages = $messageModel->findWhere(['is_read' => 0], 'created_at', 'DESC');
        $latestMessages = array_slice($latestMessages, 0, 5);

        $this->view('admin/dashboard', [
            'stats' => $stats,
            'latestPosts' => $latestPosts,
            'latestMessages' => $latestMessages,
        ]);
    }
}
