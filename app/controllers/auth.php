<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class auth {
    protected $user = [
            "lxh"=>"lxh1",
            "admin"=>"123"
    ];

    public function login() {
        $error = '';

        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if(isset($this->user[$username]) && $this->user[$username] == $password) {
                $_SESSION['username'] = $username;
                $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
                header("Location: " . $basePath . "/sinhvien/index");
                exit();
            } else {
                $error = 'Tai khoan hoac mat khau khong dung.';
            }
        }

        Controller::renderView('sinhvien/login', [
            'title' => 'Dang nhap',
            'error' => $error,
        ]);
    }

    public function logout()
    {
        session_destroy();

        if (isset($_COOKIE['username'])) {
            setcookie('username', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['password'])) {
            setcookie('password', '', time() - 3600, '/');
        }

        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header('Location: ' . $basePath . '/auth/login');
        exit();
    }
}