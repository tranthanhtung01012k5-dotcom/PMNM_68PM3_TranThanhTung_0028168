<?php
class auth
{
    protected $users = [
        'admin' => ['password' => 'admin123'],
    ];

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($this->users[$username]) &&
        $this->users[$username]['password'] === $password) {

        $_SESSION['username'] = $username;

        header('Location: /index.php?url=sinhvien/index');
        exit();
    }

    echo "Sai tài khoản hoặc mật khẩu";
    return;
}
    }
}
?>