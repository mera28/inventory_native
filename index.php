<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Config & Helpers
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Helpers/Sanitize.php';
require_once __DIR__ . '/app/Helpers/Csrf.php';

// Load Controllers
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/CategoryController.php';
require_once __DIR__ . '/app/Controllers/ProductController.php';

$action = $_GET['action'] ?? 'login';

$authController = new AuthController();
$categoryController = new CategoryController();
$productController = new ProductController();

switch ($action) {
    // --- AUTHENTICATION ---
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            if (isset($_SESSION['user_id'])) {
                header("Location: index.php?action=dashboard");
                exit();
            }
            require_once __DIR__ . '/views/auth/login.php';
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    // --- DASHBOARD ---
    case 'dashboard':
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        require_once __DIR__ . '/views/dashboard.php';
        break;

    // --- CATEGORIES ---
    case 'categories':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $categoryController->index();
        break;

    case 'categories_store':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $categoryController->store();
        break;

    case 'categories_delete':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $categoryController->delete();
        break;

    // --- PRODUCTS ---
    case 'products':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $productController->index();
        break;

    case 'products_store':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $productController->store();
        break;

    case 'products_delete':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $productController->delete();
        break;

    default:
        header("Location: index.php?action=login");
        exit();
}