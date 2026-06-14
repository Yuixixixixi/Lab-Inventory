<?php
// Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /lab_nexus/auth/login');
    exit;
}

$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
require_once __DIR__ . '/../../models/TransactionModel.php';
$transModel = new TransactionModel();
$transactions = $transModel->getFilteredUsageHistory($tanggal);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Sirkulasi Lab - <?= date('d-m-Y', strtotime($tanggal)) ?></title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 20px;
            font-size: 12pt;
        }
        h1 {
            text-align: center;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            margin-top: 0;
            color: #555;
            font-size: 10pt;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10pt;
        }
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>LAB NEXUS</h1>
    <div class="subtitle">Laporan Sirkulasi Transaksi Lab<br>Tanggal: <?= date('d-m-Y', strtotime($tanggal)) ?></div>
    
    <?php if (empty($transactions)): ?>
        <p style="text-align: center;">Tidak ada transaksi pada tanggal <?= date('d-m-Y', strtotime($tanggal)) ?></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Item (Tipe)</th>
                    <th>Jumlah</th>
                    <th>Tujuan</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($t['user_name']) ?></td>
                    <td><?= htmlspecialchars($t['item_name']) ?> (<?= $t['item_type'] ?>)</td>
                    <td><?= $t['quantity'] ?></td>
                    <td><?= htmlspecialchars($t['purpose']) ?></td>
                    <td><?= date('d-m-Y', strtotime($t['borrow_date'])) ?></td>
                    <td><?= $t['return_date'] ? date('d-m-Y', strtotime($t['return_date'])) : '-' ?></td>
                    <td><?= $t['status'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <div class="footer">
        Dicetak pada: <?= date('d-m-Y H:i:s') ?>
    </div>
    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print();" style="padding: 8px 16px; background: #1A73E8; color: white; border: none; border-radius: 4px; cursor: pointer;">Cetak / Simpan PDF</button>
        <button onclick="window.close();" style="padding: 8px 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>
</body>
</html>