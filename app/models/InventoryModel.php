<?php
require_once __DIR__ . '/../config/Database.php';

class InventoryModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllItems() {
        $stmt = $this->conn->prepare("SELECT * FROM inventory ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getItemById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getItemByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM inventory WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch();
    }

    public function addItem($name, $type, $quantity, $threshold, $status = 'Available') {
        $stmt = $this->conn->prepare("INSERT INTO inventory (name, type, quantity, threshold, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $type, $quantity, $threshold, $status]);
    }

    public function updateItem($id, $name, $type, $quantity, $threshold, $status) {
        $stmt = $this->conn->prepare("UPDATE inventory SET name = ?, type = ?, quantity = ?, threshold = ?, status = ? WHERE id = ?");
        return $stmt->execute([$name, $type, $quantity, $threshold, $status, $id]);
    }

    public function deleteItem($id) {
        $stmt = $this->conn->prepare("DELETE FROM inventory WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateQuantity($id, $newQuantity) {
        $stmt = $this->conn->prepare("UPDATE inventory SET quantity = ? WHERE id = ?");
        return $stmt->execute([$newQuantity, $id]);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE inventory SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
?>