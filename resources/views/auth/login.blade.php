<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Login Perpus</h2>
            <p class="text-gray-500 text-sm">Silakan masuk ke akun Anda</p>
            <p class="text-xs text-indigo-500 mt-2 font-semibold bg-indigo-50 py-1 rounded"></p>
        </div>
        
        <form id="loginForm" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Username / Email</label>
                <input type="text" id="username" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Masukkan username...">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition-all shadow-lg hover:shadow-xl">
                Login Sekarang
            </button>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Tahan biar halaman gak refresh
            let username = document.getElementById('username').value.toLowerCase();
            
            if (username === 'admin') {
                window.location.href = '/admin/dashboard';
            } else {
                window.location.href = '/user/dashboard';
            }
        });
    </script>
</body>
</html>