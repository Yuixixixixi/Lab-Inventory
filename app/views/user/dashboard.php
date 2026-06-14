<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Pinjaman | Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <aside class="w-64 bg-slate-900 p-6 flex-shrink-0 sticky top-0 h-screen">
        <h1 class="text-white text-xl font-bold mb-10 flex items-center gap-2"><i data-lucide="flask-conical" class="text-blue-500"></i> LABNEXUS</h1>
        <nav class="space-y-2">
            <a href="/lab_nexus/user" class="flex items-center gap-3 bg-blue-600 text-white p-3 rounded-xl font-medium"><i data-lucide="history" size="20"></i> Riwayat Pinjaman</a>
            <a href="/lab_nexus/user/catalog" class="flex items-center gap-3 text-slate-400 hover:text-white p-3 rounded-xl transition"><i data-lucide="package" size="20"></i> Katalog Barang</a>
        </nav>
        <a href="/lab_nexus/auth/logout" class="absolute bottom-6 flex items-center gap-3 text-red-400 hover:text-red-300 p-3"><i data-lucide="log-out" size="20"></i> Logout</a>
    </aside>

    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Riwayat Pinjaman Saya</h2>
        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden p-6">
            <table class="w-full text-left">
                <thead class="text-gray-400 text-xs uppercase">
                    <tr><th class="py-4">Barang</th><th class="py-4">Tanggal</th><th class="py-4">Status</th></tr>
                </thead>
                <tbody class="divide-y">
                    <?php if (!empty($data['history'])): foreach ($data['history'] as $h): ?>
                    <tr><td class="py-4"><?= $h['nama_barang'] ?></td><td class="py-4"><?= $h['tanggal_pinjam'] ?></td>
                        <td class="py-4"><span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700"><?= ucfirst($h['status']) ?></span></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="3" class="py-10 text-center text-gray-400">Belum ada riwayat.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>