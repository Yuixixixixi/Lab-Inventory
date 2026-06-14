<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Palet Solid (Tanpa RGB/Opacity)
                        primary: '#1e293b', // Slate 800
                        secondary: '#475569', // Slate 600
                        accent: '#2563eb',    // Blue 600
                        bg: '#f8fafc',        // Slate 50
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-bg text-slate-900 h-screen flex">
    <aside class="w-64 bg-primary text-white flex-shrink-0">
    <div class="p-6 border-b border-secondary">
        <h2 class="text-xl font-bold">LAB NEXUS</h2>
    </div>
    <nav class="p-4 space-y-1">
        <a href="/lab_nexus/dashboard" class="block p-3 hover:bg-secondary rounded">Dashboard</a>
        <a href="/lab_nexus/inventory" class="block p-3 hover:bg-secondary rounded">Katalog</a>
        <a href="/lab_nexus/auth/logout" class="block p-3 mt-10 border-t border-secondary text-slate-300 hover:text-white">Keluar</a>
    </nav>
</aside>