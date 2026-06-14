<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Barang | Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-10">
    <div class="max-w-lg mx-auto bg-white p-8 rounded-2xl shadow-sm border">
        <h2 class="text-2xl font-bold mb-6">Edit Barang</h2>
        <form action="/lab_nexus/inventory/update" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?= $data['item']['id'] ?>">
            <div>
                <label class="block text-sm font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" value="<?= $data['item']['nama_barang'] ?>" required class="w-full p-2.5 rounded-lg border">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium">Stok</label><input type="number" name="stok" value="<?= $data['item']['stok'] ?>" required class="w-full p-2.5 rounded-lg border"></div>
                <div><label class="block text-sm font-medium">Kategori</label><input type="text" name="kategori" value="<?= $data['item']['kategori'] ?>" required class="w-full p-2.5 rounded-lg border"></div>
            </div>
            <div class="flex gap-3 mt-6">
                <a href="/lab_nexus/inventory" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg flex-1">Update Barang</button>
            </div>
        </form>
    </div>
</body>
</html>