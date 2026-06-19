<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: /auth/login');
        exit();
    }
    if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        $_SESSION['username'] = $_COOKIE['username'];
    }
?>

<h1> Dang Nhap Thanh Cong </h1>
<h1> Chao Mung <?php echo $_SESSION['username']; ?> </h1>
<a href="/auth/logout">Logout</a>