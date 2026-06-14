<!DOCTYPE html>
<html>
<head>
    <title>Login Lab Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h1 class="text-2xl font-bold mb-4">Login Lab Nexus</h1>
        <form action="/lab_nexus/auth/login" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded font-bold">Login</button>
        </form>
    </div>
</body>
</html>