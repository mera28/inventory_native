<?php

require_once __DIR__ . '/../../config/database.php';

class StockMovement {
    private $conn;
    private $table = 'stock_movements';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT sm.*, p.name as product_name, p.sku, u.name as user_name 
                  FROM " . $this->table . " sm 
                  LEFT JOIN products p ON sm.product_id = p.id 
                  LEFT JOIN users u ON sm.user_id = u.id 
                  ORDER BY sm.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Method baru untuk filter laporan tanggal
    public function getByDateRange($startDate, $endDate) {
        $query = "SELECT sm.*, p.name as product_name, p.sku, u.name as user_name 
                  FROM " . $this->table . " sm 
                  LEFT JOIN products p ON sm.product_id = p.id 
                  LEFT JOIN users u ON sm.user_id = u.id 
                  WHERE DATE(sm.created_at) BETWEEN :start_date AND :end_date 
                  ORDER BY sm.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($product_id, $user_id, $type, $quantity, $notes) {
        try {
            $this->conn->beginTransaction();

            $query = "INSERT INTO " . $this->table . " (product_id, user_id, type, quantity, notes) 
                      VALUES (:product_id, :user_id, :type, :quantity, :notes)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':notes', $notes);
            $stmt->execute();

            if ($type === 'in') {
                $updateQuery = "UPDATE products SET stock = stock + :quantity WHERE id = :product_id";
            } else {
                $updateQuery = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
            }

            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $quantity);
            $updateStmt->bindParam(':product_id', $product_id);
            $updateStmt->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}