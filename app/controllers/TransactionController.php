<?php
class TransactionController extends Controller {
    private $transModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /lab_nexus/auth/login');
            exit;
        }
        $this->transModel = new TransactionModel();
    }

    public function request() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_id'];
            $itemId = $_POST['item_id'];
            $quantity = $_POST['quantity'];
            $purpose = htmlspecialchars($_POST['purpose']);
            $borrowDate = $_POST['borrow_date'];

            $res = $this->transModel->requestTransaction($userId, $itemId, $quantity, $purpose, $borrowDate);
            if ($res) {
                $_SESSION['success'] = "Request sirkulasi berhasil dikirim!";
            } else {
                $_SESSION['error'] = "Gagal! Jumlah request melebihi sisa stok fisik gudang.";
            }
            header('Location: /lab_nexus/dashboard');
            exit;
        }
    }
    
    public function reject($id) {
        if ($_SESSION['role'] !== 'admin') {
            die("Akses Ditolak");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $notes = htmlspecialchars($_POST['rejection_notes']);
            if ($this->transModel->rejectTransaction($id, $notes)) {
                $_SESSION['success'] = "Transaksi sirkulasi berhasil ditolak.";
            } else {
                $_SESSION['error'] = "Gagal menolak transaksi.";
            }
        }
        header('Location: /lab_nexus/dashboard');
        exit;
    }

    public function approve($id) {
        if ($_SESSION['role'] !== 'admin') {
            die("Akses Ditolak");
        }
        if ($this->transModel->approveTransaction($id)) {
            $_SESSION['success'] = "Transaksi sirkulasi berhasil disetujui!";
        } else {
            $_SESSION['error'] = "Gagal menyetujui transaksi. Silakan periksa kembali ketersediaan data barang master.";
        }
        header('Location: /lab_nexus/dashboard');
        exit;
    }

    public function return($id) {
        if ($_SESSION['role'] !== 'admin') {
            die("Akses Ditolak");
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $condition = $_POST['condition'];
            $result = $this->transModel->processReturn($id, $condition);
            if ($result === true) {
                $_SESSION['success'] = "Proses pengembalian logistik berhasil dicatat!";
            } elseif ($result === 'rusak') {
                $_SESSION['error'] = "Alat rusak! Transaksi ditolak dan alat tidak dapat dipinjam lagi.";
            } else {
                $_SESSION['error'] = "Gagal memproses sirkulasi pengembalian.";
            }
        }
        header('Location: /lab_nexus/dashboard');
        exit;
    }

    public function complete($id) {
        if ($_SESSION['role'] !== 'admin') {
            die("Akses Ditolak");
        }
        $result = $this->transModel->completeTransaction($id);
        if ($result) {
            $_SESSION['success'] = "Transaksi bahan berhasil diselesaikan.";
        } else {
            $_SESSION['error'] = "Gagal menyelesaikan transaksi.";
        }
        header('Location: /lab_nexus/dashboard');
        exit;
    }
}
?>