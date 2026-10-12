<?php

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Helpers/Sanitize.php';
require_once __DIR__ . '/../Helpers/Csrf.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function index() {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        $editProduct = null;

        if (isset($_GET['edit_id'])) {
            $editProduct = $this->productModel->getById($_GET['edit_id']);
        }

        require_once __DIR__ . '/../../views/products/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("CSRF Token Invalid!");
            }

            $sku = Sanitize::clean($_POST['sku'] ?? '');
            $name = Sanitize::clean($_POST['name'] ?? '');
            $category_id = Sanitize::clean($_POST['category_id'] ?? '');
            $price = Sanitize::clean($_POST['price'] ?? 0);
            $stock = Sanitize::clean($_POST['stock'] ?? 0);

            if (!empty($sku) && !empty($name) && !empty($category_id)) {
                $this->productModel->create($sku, $name, $category_id, $price, $stock);
            }
            header("Location: index.php?action=products");
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("CSRF Token Invalid!");
            }

            $id = Sanitize::clean($_POST['id'] ?? '');
            $sku = Sanitize::clean($_POST['sku'] ?? '');
            $name = Sanitize::clean($_POST['name'] ?? '');
            $category_id = Sanitize::clean($_POST['category_id'] ?? '');
            $price = Sanitize::clean($_POST['price'] ?? 0);
            $stock = Sanitize::clean($_POST['stock'] ?? 0);

            if (!empty($id) && !empty($sku) && !empty($name) && !empty($category_id)) {
                $this->productModel->update($id, $sku, $name, $category_id, $price, $stock);
            }
            header("Location: index.php?action=products");
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->productModel->delete($id);
        }
        header("Location: index.php?action=products");
        exit();
    }
}