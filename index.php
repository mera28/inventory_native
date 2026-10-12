<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Config & Helpers
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/Helpers/Sanitize.php';
require_once __DIR__ . '/app/Helpers/Csrf.php';

// Load Models
require_once __DIR__ . '/app/Models/Product.php';

// Load Controllers
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/CategoryController.php';
require_once __DIR__ . '/app/Controllers/ProductController.php';
require_once __DIR__ . '/app/Controllers/SupplierController.php';
require_once __DIR__ . '/app/Controllers/StockController.php';

$action = $_GET['action'] ?? 'login';

$authController = new AuthController();
$categoryController = new CategoryController();
$productController = new ProductController();
$supplierController = new SupplierController();
$stockController = new StockController();

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
        $productModel = new Product();
        $summary = $productModel->getSummaryCounts();
        $lowStockProducts = $productModel->getLowStockProducts();
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

    case 'categories_update':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $categoryController->update();
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

    case 'products_update':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $productController->update();
        break;

    case 'products_delete':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $productController->delete();
        break;

    // --- SUPPLIERS ---
    case 'suppliers':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $supplierController->index();
        break;

    case 'suppliers_store':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $supplierController->store();
        break;

    case 'suppliers_update':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $supplierController->update();
        break;

    case 'suppliers_delete':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $supplierController->delete();
        break;

    // --- STOCK MOVEMENTS ---
    case 'stock':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $stockController->index();
        break;

    case 'stock_store':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $stockController->store();
        break;

    // --- REPORTS ---
    case 'reports':
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $stockController->reports();
        break;

    default:
        header("Location: index.php?action=login");
        exit();
}