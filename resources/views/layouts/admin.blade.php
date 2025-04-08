<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-6">
            <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline block">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline block">Kelola User</a>
                <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline block">Kelola Produk</a>
                <a href="#" class="text-blue-600 hover:underline block">Transaksi</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline mt-4">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
