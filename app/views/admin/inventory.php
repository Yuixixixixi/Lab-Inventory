<!DOCTYPE html>
<html lang="id">
<head>
    <title>Inventaris | Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <aside class="w-64 bg-slate-900 p-6 flex-shrink-0 sticky top-0 h-screen">
        <h1 class="text-white text-xl font-bold mb-10 flex items-center gap-2"><i data-lucide="flask-conical" class="text-blue-500"></i> LABNEXUS</h1>
        <nav class="space-y-2">
            <a href="/lab_nexus/dashboard" class="flex items-center gap-3 text-slate-400 hover:text-white p-3 rounded-xl transition"><i data-lucide="layout-dashboard" size="20"></i> Dashboard</a>
            <a href="/lab_nexus/inventory" class="flex items-center gap-3 bg-blue-600 text-white p-3 rounded-xl font-medium"><i data-lucide="package" size="20"></i> Inventaris</a>
        </nav>
        <a href="/lab_nexus/auth/logout" class="absolute bottom-6 flex items-center gap-3 text-red-400 hover:text-red-300 p-3"><i data-lucide="log-out" size="20"></i> Logout</a>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Inventaris</h2>
            <button onclick="toggleModal('modalAdd')" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700">Tambah Barang</button>
        </div>

        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-400 text-xs uppercase">
                    <tr><th class="py-4 px-6">ID</th><th class="py-4 px-6">Barang</th><th class="py-4 px-6">Stok</th><th class="py-4 px-6">Kategori</th><th class="py-4 px-6">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($data['items'] as $item): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6 text-gray-500">#<?= $item['id'] ?></td>
                        <td class="py-4 px-6 font-medium"><?= htmlspecialchars($item['nama_barang']) ?></td>
                        <td class="py-4 px-6 text-gray-600"><?= $item['stok'] ?></td>
                        <td class="py-4 px-6 text-gray-600"><?= $item['kategori'] ?></td>
                        <td class="py-4 px-6">
                            <a href="#" class="text-blue-500 mr-3"><i data-lucide="edit-2" size="16"></i></a>
                            <a href="/lab_nexus/inventory/delete/<?= $item['id'] ?>" class="text-red-500"><i data-lucide="trash-2" size="16"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>lucide.createIcons();</script>
</body>
</html>