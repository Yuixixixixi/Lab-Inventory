<aside class="w-64 bg-slate-900 text-white h-screen p-4">
    <h1 class="text-xl font-bold mb-8">LAB NEXUS</h1>
    <nav class="space-y-2">
        <a href="/lab_nexus/dashboard" class="block p-2 hover:bg-slate-700 rounded">Dashboard</a>
        <a href="/lab_nexus/inventory" class="block p-2 hover:bg-slate-700 rounded">Inventaris</a>
        <?php if($_SESSION['role'] == 'admin'): ?>
            <a href="/lab_nexus/admin/laporan" class="block p-2 hover:bg-slate-700 rounded">Laporan</a>
        <?php endif; ?>
        <a href="/lab_nexus/auth/logout" class="block p-2 text-red-400">Logout</a>
    </nav>
</aside>