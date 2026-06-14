<!DOCTYPE html>
<html lang="id">
<head>
    <title>Katalog | Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <aside class="w-64 bg-slate-900 p-6 flex-shrink-0 sticky top-0 h-screen">
        <h1 class="text-white text-xl font-bold mb-10 flex items-center gap-2"><i data-lucide="flask-conical" class="text-blue-500"></i> LABNEXUS</h1>
        <nav class="space-y-2">
            <a href="/lab_nexus/user" class="flex items-center gap-3 text-slate-400 hover:text-white p-3 rounded-xl transition"><i data-lucide="history" size="20"></i> Riwayat Pinjaman</a>
            <a href="/lab_nexus/user/catalog" class="flex items-center gap-3 bg-blue-600 text-white p-3 rounded-xl font-medium"><i data-lucide="package" size="20"></i> Katalog Barang</a>
        </nav>
        <a href="/lab_nexus/auth/logout" class="absolute bottom-6 flex items-center gap-3 text-red-400 hover:text-red-300 p-3"><i data-lucide="log-out" size="20"></i> Logout</a>
    </aside>

    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Katalog Alat Lab</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($data['items'] as $item): ?>
            <div class="bg-white p-6 rounded-2xl border shadow-sm">
                <h3 class="font-bold text-lg"><?= htmlspecialchars($item['nama_barang']) ?></h3>
                <p class="text-sm text-gray-500 mb-4">Stok: <?= $item['stok'] ?></p>
                <form action="/lab_nexus/transaction/request" method="POST">
                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                    <input type="number" name="qty" placeholder="Qty" class="w-full p-2 border rounded-lg mb-2" required>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Pinjam</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>