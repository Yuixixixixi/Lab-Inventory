<?php
class AdminController extends Controller {
    public function export_excel() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            exit('Akses ditolak');
        }
        $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
        $transModel = new TransactionModel();
        $transactions = $transModel->getFilteredUsageHistory($tanggal);
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="laporan_sirkulasi_' . $tanggal . '.csv"');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
        $delimiter = ';'; // delimiter titik koma agar rapi di Excel Indonesia
        fputcsv($output, ['No', 'User', 'Item (Tipe)', 'Jumlah', 'Tujuan', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status'], $delimiter);
        
        $no = 1;
        foreach ($transactions as $t) {
            fputcsv($output, [
                $no++,
                $t['user_name'],
                $t['item_name'] . ' (' . $t['item_type'] . ')',
                $t['quantity'],
                $t['purpose'],
                date('d-m-Y', strtotime($t['borrow_date'])),
                $t['return_date'] ? date('d-m-Y', strtotime($t['return_date'])) : '-',
                $t['status']
            ], $delimiter);
        }
        fclose($output);
        exit;
    }
}
?>