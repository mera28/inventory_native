<?php

require_once __DIR__ . '/../../config/database.php';

class Product {
    private $conn;
    private $table = 'products';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($sku, $name, $category_id, $price, $stock) {
        $query = "INSERT INTO " . $this->table . " (sku, name, category_id, price, stock) 
                  VALUES (:sku, :name, :category_id, :price, :stock)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}