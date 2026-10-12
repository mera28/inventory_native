<?php

require_once __DIR__ . '/../Models/Supplier.php';
require_once __DIR__ . '/../Helpers/Sanitize.php';
require_once __DIR__ . '/../Helpers/Csrf.php';

class SupplierController {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $suppliers = $this->supplierModel->getAll();
        require_once __DIR__ . '/../../views/suppliers/index.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Csrf::verifyToken($_POST['csrf_token'] ?? '')) {
                die("CSRF Token Invalid!");
            }

            $name = Sanitize::clean($_POST['name'] ?? '');
            $phone = Sanitize::clean($_POST['phone'] ?? '');
            $address = Sanitize::clean($_POST['address'] ?? '');

            if (!empty($name)) {
                $this->supplierModel->create($name, $phone, $address);
            }
            header("Location: index.php?action=suppliers");
            exit();
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->supplierModel->delete($id);
        }
        header("Location: index.php?action=suppliers");
        exit();
    }
}