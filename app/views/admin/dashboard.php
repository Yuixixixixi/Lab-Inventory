<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard | Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <aside class="w-64 bg-slate-900 p-6 flex-shrink-0 sticky top-0 h-screen">
        <h1 class="text-white text-xl font-bold mb-10 flex items-center gap-2"><i data-lucide="flask-conical" class="text-blue-500"></i> LABNEXUS</h1>
        <nav class="space-y-2">
            <a href="/lab_nexus/dashboard" class="flex items-center gap-3 bg-blue-600 text-white p-3 rounded-xl font-medium"><i data-lucide="layout-dashboard" size="20"></i> Dashboard</a>
            <a href="/lab_nexus/inventory" class="flex items-center gap-3 text-slate-400 hover:text-white p-3 rounded-xl transition"><i data-lucide="package" size="20"></i> Inventaris</a>
        </nav>
        <a href="/lab_nexus/auth/logout" class="absolute bottom-6 flex items-center gap-3 text-red-400 hover:text-red-300 p-3"><i data-lucide="log-out" size="20"></i> Logout</a>
    </aside>

    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Overview Admin</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border shadow-sm"><p class="text-gray-400 text-sm">Total Barang</p><h3 class="text-3xl font-bold mt-1"><?= count($data['items'] ?? []); ?></h3></div>
        </div>
        
        <div class="bg-white rounded-2xl border shadow-sm p-6">
            <h3 class="font-bold text-lg mb-6">Request Peminjaman (Approval)</h3>
            <table class="w-full text-left">
                <thead class="text-gray-400 text-xs uppercase"><tr><th>User</th><th>Barang</th><th>Qty</th><th>Aksi</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (!empty($data['transactions'])): foreach ($data['transactions'] as $t): ?>
                    <tr><td class="py-4"><?= $t['username'] ?></td><td class="py-4"><?= $t['nama_barang'] ?></td><td class="py-4"><?= $t['qty'] ?></td>
                        <td class="py-4"><a href="/lab_nexus/transaction/approve/<?= $t['id'] ?>/<?= $t['item_id'] ?>/<?= $t['qty'] ?>" class="text-green-600 bg-green-50 px-3 py-1 rounded-lg">Approve</a></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="py-4 text-center text-gray-400">Tidak ada request baru.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>