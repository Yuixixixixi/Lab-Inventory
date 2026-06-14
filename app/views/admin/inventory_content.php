<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form Tambah -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-2 mb-5">
            <i class="fas fa-plus-circle text-[#1A73E8] text-xl"></i>
            <h2 class="text-lg font-semibold text-gray-800">Tambah Master Alat / Bahan</h2>
        </div>

        <div id="alert-message"></div>

        <form id="add-item-form" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aset Lab</label>
                <input type="text" name="name" id="name" required placeholder="Contoh: Gelas Ukur 100ml"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#1A73E8] focus:ring-1 focus:ring-[#1A73E8]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Aset</label>
                <select name="type" id="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                    <option value="alat">Alat (Bisa Dipinjam-Kembalikan)</option>
                    <option value="bahan">Bahan Kimia / Habis Pakai</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kuantitas Awal</label>
                <input type="number" name="quantity" id="quantity" min="1" value="10" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Batas Minimum Stok (Threshold Alert)</label>
                <input type="number" name="threshold" id="threshold" min="0" value="2" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Sistem akan memberi peringatan jika stok ≤ batas ini.</p>
            </div>
            <button type="submit" class="w-full bg-[#1A73E8] hover:bg-[#1557B0] text-white font-medium py-2 rounded-lg text-sm transition shadow-sm">
                <i class="fas fa-database mr-1"></i> Simpan ke Database
            </button>
        </form>
    </div>

    <!-- Tabel Inventaris (dengan kolom Status dan fitur pencarian) -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Master Inventaris Lab</h2>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInventory" placeholder="Cari nama barang..." 
                           class="pl-9 pr-3 py-1 border border-gray-300 rounded-lg text-sm w-64 focus:outline-none focus:ring-1 focus:ring-[#1A73E8]">
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="inventory-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Aman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="inventory-tbody">
                    <!-- Data akan dimuat via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit (sama seperti sebelumnya) -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Edit Aset</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form id="edit-item-form">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Aset Lab</label>
                <input type="text" name="name" id="edit_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Aset</label>
                <select name="type" id="edit_type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                    <option value="alat">Alat (Bisa Dipinjam-Kembalikan)</option>
                    <option value="bahan">Bahan Kimia / Habis Pakai</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Kuantitas</label>
                <input type="number" name="quantity" id="edit_quantity" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Batas Minimum Stok</label>
                <input type="number" name="threshold" id="edit_threshold" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="edit_status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                    <option value="Available">Available</option>
                    <option value="Borrowed">Borrowed</option>
                    <option value="Broken">Broken</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#1A73E8] text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
let inventoryData = []; // Menyimpan data asli untuk filter

// Fungsi untuk memuat data inventaris
function loadInventory() {
    fetch('/lab_nexus/inventory/getData')
        .then(response => response.json())
        .then(data => {
            inventoryData = data;
            renderTable(data);
        });
}

// Render tabel berdasarkan array data (dengan status badge)
function renderTable(data) {
    const tbody = document.getElementById('inventory-tbody');
    tbody.innerHTML = '';
    data.forEach(item => {
        let statusBadge = '';
        if (item.status === 'Available') {
            statusBadge = '<span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>';
        } else if (item.status === 'Borrowed') {
            statusBadge = '<span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Borrowed</span>';
        } else if (item.status === 'Broken') {
            statusBadge = '<span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Broken</span>';
        } else {
            statusBadge = '<span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' + item.status + '</span>';
        }

        const row = `
            <tr class="hover:bg-gray-50 transition" data-id="${item.id}">
                <td class="px-6 py-4 text-sm font-medium text-gray-900">${escapeHtml(item.name)}</td>
                <td class="px-6 py-4 text-sm">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <i class="fas ${item.type === 'alat' ? 'fa-tools' : 'fa-flask'} mr-1"></i>
                        ${item.type.toUpperCase()}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">${item.quantity} unit</td>
                <td class="px-6 py-4 text-sm text-gray-500">${item.threshold} unit</td>
                <td class="px-6 py-4 text-sm">${statusBadge}</td>
                <td class="px-6 py-4 text-center text-sm">
                    <div class="flex justify-center gap-2">
                        <button onclick="openEditModal(${item.id})" class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-2 py-1 rounded text-xs">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button onclick="deleteItem(${item.id})" class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

// Fungsi pencarian (filter berdasarkan nama barang)
document.getElementById('searchInventory').addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    const filtered = inventoryData.filter(item => item.name.toLowerCase().includes(keyword));
    renderTable(filtered);
});

// Helper escapeHtml
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Submit form tambah via AJAX
document.getElementById('add-item-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('/lab_nexus/inventory/add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        const alertDiv = document.getElementById('alert-message');
        if (result.success) {
            alertDiv.innerHTML = `<div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm"><i class="fas fa-check-circle mr-1"></i> ${result.message}</div>`;
            document.getElementById('add-item-form').reset();
            loadInventory(); // reload tabel
        } else {
            alertDiv.innerHTML = `<div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> ${result.message}</div>`;
        }
        setTimeout(() => { alertDiv.innerHTML = ''; }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('alert-message').innerHTML = `<div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">Terjadi kesalahan.</div>`;
    });
});

// Delete via AJAX
function deleteItem(id) {
    if (confirm('Yakin hapus data ini?')) {
        fetch('/lab_nexus/inventory/deleteAjax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(result => {
            const alertDiv = document.getElementById('alert-message');
            if (result.success) {
                alertDiv.innerHTML = `<div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm"><i class="fas fa-check-circle mr-1"></i> ${result.message}</div>`;
                loadInventory();
            } else {
                alertDiv.innerHTML = `<div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> ${result.message}</div>`;
            }
            setTimeout(() => { alertDiv.innerHTML = ''; }, 3000);
        });
    }
}

// Edit modal
function openEditModal(id) {
    fetch('/lab_nexus/inventory/getItem/' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_type').value = data.type;
            document.getElementById('edit_quantity').value = data.quantity;
            document.getElementById('edit_threshold').value = data.threshold;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('editModal').classList.remove('hidden');
        });
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Submit edit via AJAX
document.getElementById('edit-item-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('/lab_nexus/inventory/editAjax', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        const alertDiv = document.getElementById('alert-message');
        if (result.success) {
            alertDiv.innerHTML = `<div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm"><i class="fas fa-check-circle mr-1"></i> ${result.message}</div>`;
            closeEditModal();
            loadInventory();
        } else {
            alertDiv.innerHTML = `<div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-1"></i> ${result.message}</div>`;
        }
        setTimeout(() => { alertDiv.innerHTML = ''; }, 3000);
    });
});

// Inisialisasi awal
loadInventory();
</script>