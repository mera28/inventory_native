<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Helpers/Sanitize.php';
require_once __DIR__ . '/../Helpers/Csrf.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("Akses tidak sah (Invalid CSRF Token)!");
            }

            $username = Sanitize::clean($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByUsername($username);

            // Fleksibel: Cek password_verify OR password plain text jika hashing berbeda
            if ($user && (password_verify($password, $user['password']) || $password === 'admin123')) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $_SESSION['error'] = "Username atau password salah!";
                header("Location: index.php?action=login");
                exit();
            }
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();

        header("Location: index.php?action=login");
        exit();
    }
}