<?php
class DashboardController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /lab_nexus/auth/login');
            exit;
        }

        $tanggal_filter = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
        
        if ($_SESSION['role'] === 'admin') {
            $this->view('admin/dashboard', ['tanggal_filter' => $tanggal_filter]);
        } else {
            $this->view('user/dashboard');
        }
    }
}
?>