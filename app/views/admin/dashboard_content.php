<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-800 border-l-4 border-[#1A73E8] pl-3">Dashboard</h1>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
    <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<!-- Low stock alerts -->
<?php
$invModel = new InventoryModel();
foreach($invModel->getAllItems() as $item):
    if($item['type'] == 'bahan' && $item['quantity'] <= $item['threshold']):
?>
<div class="mb-3 p-3 rounded bg-amber-50 border-l-4 border-amber-400 text-amber-800 text-sm flex justify-between">
    <span>⚠️ Stok bahan <strong><?= $item['name'] ?></strong> menipis (Sisa: <?= $item['quantity'] ?>).</span>
    <span class="bg-amber-100 px-2 py-0.5 rounded text-xs">Batas Minimum</span>
</div>
<?php endif; endforeach; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b flex flex-wrap justify-between items-center gap-3">
        <div>
            <h2 class="text-lg font-semibold">Sirkulasi & Persetujuan Transaksi Lab</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola permintaan peminjaman alat dan bahan laboratorium.</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" action="" class="flex items-center gap-2">
                <label class="text-sm font-medium text-gray-700">Filter Tanggal:</label>
                <input type="date" name="tanggal" value="<?= htmlspecialchars($tanggal_filter) ?>" 
                       class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-[#1A73E8]"
                       onchange="this.form.submit()">
            </form>
            <a href="/lab_nexus/admin/export_excel?tanggal=<?= urlencode($tanggal_filter) ?>" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-sm transition flex items-center gap-1">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Item</th>
                    <th class="px-6 py-3">Qty</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Tanggal Pinjam</th>
                    <th class="px-6 py-3">Tanggal Kembali</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php
                $transModel = new TransactionModel();
                $transactions = $transModel->getFilteredUsageHistory($tanggal_filter);
                if (empty($transactions)):
                ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-400 text-sm">
                            <i class="fas fa-calendar-day mr-1"></i> Tidak ada transaksi pada tanggal <?= date('d-m-Y', strtotime($tanggal_filter)) ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($transactions as $t): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium"><?= $t['user_name'] ?></td>
                        <td class="px-6 py-3"><?= $t['item_name'] ?> <span class="text-gray-400 text-xs">(<?= $t['item_type'] ?>)</span></td>
                        <td class="px-6 py-3"><?= $t['quantity'] ?></td>
                        <td class="px-6 py-3 text-gray-500"><?= $t['purpose'] ?></td>
                        <td class="px-6 py-3"><?= date('d-m-Y', strtotime($t['borrow_date'])) ?></td>
                        <td class="px-6 py-3"><?= $t['return_date'] ? date('d-m-Y', strtotime($t['return_date'])) : '-' ?></td>
                        <td class="px-6 py-3">
                            <?php
                            $statusClass = match($t['status']) {
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Approved' => 'bg-blue-100 text-blue-800',
                                'Returned' => 'bg-green-100 text-green-800',
                                'Rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                            ?>
                            <span class="px-2 py-1 rounded-full text-xs <?= $statusClass ?>"><?= $t['status'] ?></span>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <?php if($t['status'] == 'Pending'): ?>
                                <div class="flex justify-center gap-1 flex-wrap">
                                    <a href="/lab_nexus/transaction/approve/<?= $t['id'] ?>" class="bg-[#1A73E8] text-white px-2 py-1 rounded text-xs">Approve</a>
                                    <form action="/lab_nexus/transaction/reject/<?= $t['id'] ?>" method="POST" class="inline">
                                        <input type="text" name="rejection_notes" placeholder="Alasan" class="border text-xs p-1 w-24 rounded">
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-xs">Reject</button>
                                    </form>
                                </div>
                            <?php elseif($t['status'] == 'Approved' && $t['item_type'] == 'alat'): ?>
                                <form action="/lab_nexus/transaction/return/<?= $t['id'] ?>" method="POST" class="flex items-center gap-1">
                                    <select name="condition" class="border text-xs p-1 rounded">
                                        <option value="aman">Aman</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-2 py-1 rounded text-xs">Return</button>
                                </form>
                            <?php elseif($t['status'] == 'Approved' && $t['item_type'] == 'bahan'): ?>
                                <a href="/lab_nexus/transaction/complete/<?= $t['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs" onclick="return confirm('Tandai bahan ini sebagai sudah terpakai?')">Selesai</a>
                            <?php else: ?>
                                <span class="text-gray-300 text-xs">- No Action -</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>