<?php

require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Helpers/Sanitize.php';
require_once __DIR__ . '/../Helpers/Csrf.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function index() {
        $categories = $this->categoryModel->getAll();
        $editCategory = null;

        // Jika ada parameter edit_id, ambil data kategori untuk diedit
        if (isset($_GET['edit_id'])) {
            $editCategory = $this->categoryModel->getById($_GET['edit_id']);
        }

        require_once __DIR__ . '/../../views/categories/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("CSRF Token Invalid!");
            }

            $name = Sanitize::clean($_POST['name'] ?? '');
            if (!empty($name)) {
                $this->categoryModel->create($name);
            }
            header("Location: index.php?action=categories");
            exit();
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("CSRF Token Invalid!");
            }

            $id = Sanitize::clean($_POST['id'] ?? '');
            $name = Sanitize::clean($_POST['name'] ?? '');

            if (!empty($id) && !empty($name)) {
                $this->categoryModel->update($id, $name);
            }
            header("Location: index.php?action=categories");
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->categoryModel->delete($id);
        }
        header("Location: index.php?action=categories");
        exit();
    }
}