<?php
class AuthController extends Controller
{
    public function loginPage(): void
    {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirect(BASE_URL . '/admin/dashboard');
        }
        $this->view('admin/login', ['error' => '']);
    }

    public function login(): void
    {
        $username = $this->input('username');
        $password = $this->input('password');

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if ($user && $userModel->verifyPassword($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $this->redirect(BASE_URL . '/admin/dashboard');
        } else {
            $this->view('admin/login', ['error' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
        }
    }

    public function logout(): void
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_username']);
        $this->redirect(BASE_URL . '/admin/login');
    }
}
