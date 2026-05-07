<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpus App')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-gray-50 text-gray-800">

    <aside id="sidebar" class="bg-white w-64 border-r border-gray-200 absolute inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 z-30 md:relative md:translate-x-0 overflow-y-auto">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-indigo-600 mb-8 flex items-center gap-2">📚 PerpusKu</h1>
            <nav class="space-y-2">
                @if(isset($role) && $role === 'user')
                    <a href="/user/dashboard" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium transition">🏠 Dashboard</a>
                    <a href="/user/peminjaman" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium transition">📖 Peminjaman Buku</a>
                    <a href="/user/pengembalian" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium transition">↩️ Pengembalian Buku</a>
                @elseif(isset($role) && $role === 'admin')
                    <a href="/admin/dashboard" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium transition">📈 Dashboard Admin</a>
                    <a href="/admin/users" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium transition">👥 Keseluruhan User</a>
                    <a href="/admin/buku" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-medium transition">📚 Manajemen Buku</a>
                @endif
            </nav>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden relative">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between z-20">
            <div class="flex items-center gap-4">
                <button id="hamburger" class="text-gray-500 hover:text-indigo-600 focus:outline-none md:hidden">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
            </div>
            <a href="/" class="text-sm font-semibold text-red-500 hover:text-red-700 bg-red-50 px-4 py-2 rounded-lg">Logout</a>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>
            @yield('content')
        </main>
    </div>

    <script>
        const btn = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenu() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        btn.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    </script>
</body>
</html>