<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-lg hidden md:block">
            <div class="p-4 text-xl font-bold text-[#305c88] border-b">Admin Panel</div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    <span>🏠</span> Dashboard
                </a>
                <hr>
                <p class="text-sm font-semibold text-gray-500">PRODUCTS</p>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    🛒 Produk
                </a>
                <hr>
                <p class="text-sm font-semibold text-gray-500">TRANSACTIONS</p>
                <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100">
                    📄 Riwayat Transaksi
                </a>
                <hr>
                <a href="#" class="text-red-500 p-2 block hover:bg-red-50 rounded">Logout</a>
            </nav>
        </aside>

        {{-- Main content --}}
        <main class="flex-1">
            {{-- Top bar --}}
            <header class="bg-white p-4 shadow flex justify-between items-center">
                <div class="md:hidden">
                    <button id="toggleSidebar" class="text-gray-500">☰</button>
                </div>
                <h1 class="text-lg font-bold text-[#305c88]">Dashboard</h1>
                <div class="flex gap-4 items-center">
                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">💰 Saldo: 6.000</span>
                    <span>👤 Admin</span>
                </div>
            </header>

            <section class="p-6">
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        document.getElementById('toggleSidebar')?.addEventListener('click', () => {
            const aside = document.querySelector('aside');
            aside.classList.toggle('hidden');
        });
    </script>

</body>
</html>
