<?php
class UserController extends Controller {
    // Tampilan Riwayat Pinjaman
    public function index() {
        if (!isset($_SESSION['user_id'])) { header('Location: /lab_nexus/auth'); exit; }
        
        $db = (new Database())->connect();
        require_once __DIR__ . '/../models/TransactionModel.php';
        
        $model = new TransactionModel($db);
        $history = $model->getHistoryByUserId($_SESSION['user_id']); // Ambil data
        
        $this->view('user/dashboard', ['history' => $history]);
    }

    // Tampilan Katalog Barang (untuk User)
    public function catalog() {
        if (!isset($_SESSION['user_id'])) { header('Location: /lab_nexus/auth'); exit; }
        
        $db = (new Database())->connect();
        require_once __DIR__ . '/../models/InventoryModel.php';
        
        $model = new InventoryModel($db);
        $items = $model->getAllInventory(); // Ambil data barang
        
        $this->view('user/inventory', ['items' => $items]);
    }
}