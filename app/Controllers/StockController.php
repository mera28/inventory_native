<?php

require_once __DIR__ . '/../Models/StockMovement.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Helpers/Sanitize.php';
require_once __DIR__ . '/../Helpers/Csrf.php';

class StockController {
    private $stockModel;
    private $productModel;

    public function __construct() {
        $this->stockModel = new StockMovement();
        $this->productModel = new Product();
    }

    public function index() {
        $movements = $this->stockModel->getAll();
        $products = $this->productModel->getAll();
        require_once __DIR__ . '/../../views/stock/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("CSRF Token Invalid!");
            }

            $product_id = Sanitize::clean($_POST['product_id'] ?? '');
            $type = Sanitize::clean($_POST['type'] ?? '');
            $quantity = (int) Sanitize::clean($_POST['quantity'] ?? 0);
            $notes = Sanitize::clean($_POST['notes'] ?? '');
            $user_id = $_SESSION['user_id'] ?? 1;

            if (!empty($product_id) && !empty($type) && $quantity > 0) {
                $this->stockModel->create($product_id, $user_id, $type, $quantity, $notes);
            }
            header("Location: index.php?action=stock");
            exit();
        }
    }

    // Method untuk menangani Laporan
    public function reports() {
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-d');

        $movements = $this->stockModel->getByDateRange($startDate, $endDate);
        require_once __DIR__ . '/../../views/reports/index.php';
    }
}