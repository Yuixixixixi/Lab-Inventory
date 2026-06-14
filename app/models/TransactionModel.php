<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/InventoryModel.php';

class TransactionModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function requestTransaction($userId, $itemId, $quantity, $purpose, $borrowDate) {
        $invModel = new InventoryModel();
        $item = $invModel->getItemById($itemId);
        if (!$item || $item['quantity'] < $quantity) {
            return false;
        }
        $newQty = $item['quantity'] - $quantity;
        $invModel->updateQuantity($itemId, $newQty);
        $stmt = $this->conn->prepare("INSERT INTO transactions (user_id, item_id, quantity, purpose, borrow_date, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        return $stmt->execute([$userId, $itemId, $quantity, $purpose, $borrowDate]);
    }

    public function approveTransaction($id) {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->execute([$id]);
        $trans = $stmt->fetch();
        if (!$trans || $trans['status'] != 'Pending') return false;
        $stmt2 = $this->conn->prepare("UPDATE transactions SET status = 'Approved' WHERE id = ?");
        return $stmt2->execute([$id]);
    }

    public function rejectTransaction($id, $notes) {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->execute([$id]);
        $trans = $stmt->fetch();
        if (!$trans || $trans['status'] != 'Pending') return false;
        $invModel = new InventoryModel();
        $item = $invModel->getItemById($trans['item_id']);
        if ($item) {
            $newQty = $item['quantity'] + $trans['quantity'];
            $invModel->updateQuantity($trans['item_id'], $newQty);
        }
        $stmt2 = $this->conn->prepare("UPDATE transactions SET status = 'Rejected', condition_notes = ? WHERE id = ?");
        return $stmt2->execute([$notes, $id]);
    }

    public function getUsageHistory() {
        $stmt = $this->conn->prepare("
            SELECT t.*, u.name as user_name, i.name as item_name, i.type as item_type 
            FROM transactions t 
            JOIN users u ON t.user_id = u.id 
            JOIN inventory i ON t.item_id = i.id 
            ORDER BY t.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getFilteredUsageHistory($tanggal) {
        $stmt = $this->conn->prepare("
            SELECT t.*, u.name as user_name, i.name as item_name, i.type as item_type 
            FROM transactions t 
            JOIN users u ON t.user_id = u.id 
            JOIN inventory i ON t.item_id = i.id 
            WHERE DATE(t.borrow_date) = ?
            ORDER BY t.id DESC
        ");
        $stmt->execute([$tanggal]);
        return $stmt->fetchAll();
    }

    public function getHistoryByUserId($userId) {
        $stmt = $this->conn->prepare("SELECT t.*, i.name as item_name, i.type as item_type FROM transactions t JOIN inventory i ON t.item_id = i.id WHERE t.user_id = ? ORDER BY t.id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getTransactionById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function updateStatus($id, $status, $notes = null) {
        if ($notes !== null) {
            $stmt = $this->conn->prepare("UPDATE transactions SET status = ?, condition_notes = ? WHERE id = ?");
            return $stmt->execute([$status, $notes, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE transactions SET status = ? WHERE id = ?");
            return $stmt->execute([$status, $id]);
        }
    }

    public function processReturn($transactionId, $condition) {
        $transaction = $this->getTransactionById($transactionId);
        if (!$transaction || $transaction['status'] !== 'Approved') {
            return false;
        }
        $itemId = $transaction['item_id'];
        $quantity = $transaction['quantity'];
        $invModel = new InventoryModel();
        $item = $invModel->getItemById($itemId);
        if (!$item) return false;

        if ($condition === 'aman') {
            $newQuantity = $item['quantity'] + $quantity;
            $invModel->updateQuantity($itemId, $newQuantity);
            $stmt = $this->conn->prepare("UPDATE transactions SET status = 'Returned', return_date = CURDATE() WHERE id = ?");
            $stmt->execute([$transactionId]);
            return true;
        } elseif ($condition === 'rusak') {
            $invModel->updateStatus($itemId, 'Broken');
            $this->updateStatus($transactionId, 'Rejected', 'Alat dikembalikan dalam kondisi rusak.');
            return 'rusak';
        }
        return false;
    }

    public function completeTransaction($id) {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = ? AND status = 'Approved'");
        $stmt->execute([$id]);
        $trans = $stmt->fetch();
        if (!$trans) return false;

        $invModel = new InventoryModel();
        $item = $invModel->getItemById($trans['item_id']);
        if ($item['type'] != 'bahan') return false;

        $stmt2 = $this->conn->prepare("UPDATE transactions SET status = 'Completed', return_date = CURDATE() WHERE id = ?");
        return $stmt2->execute([$id]);
    }
}
?>