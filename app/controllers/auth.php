<?php
class auth
{
    protected $users = [
        'admin' => ['password' => 'admin123'],
    ];

    public function login()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = $_POST['username'];
            $password = $_POST['password'];

            if (
                isset($this->users[$username]) &&
                $this->users[$username]['password'] === $password
            ) {

                session_start();
                $_SESSION['username'] = $username;

                header('Location:/home/index');
                exit();

            } else {

                echo "Tên đăng nhập hoặc mật khẩu không đúng";
            }

        } else {

            require_once '../app/views/home/login.php';
        }
    }
}
?>