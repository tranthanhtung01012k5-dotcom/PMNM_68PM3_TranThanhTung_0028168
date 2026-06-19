<?php
class middleware
{
    public function checklogin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $url = trim($_GET['url'] ?? '', '/');
        $publicPages = [
            'auth/login',
        ];

        if (!isset($_SESSION['username']) && !in_array($url, $publicPages)) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
            header('Location: ' . $basePath . '/auth/login');
            exit();
        }
    }
}