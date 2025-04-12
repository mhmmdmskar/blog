<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Wrapper -->
<div class="flex h-screen">

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-white border-r shadow-md flex flex-col hidden md:flex">
        <div class="p-4 border-b">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 mx-auto">
        </div>
        <div class="p-4">
            <input type="text" placeholder="Search..." class="w-full p-2 text-sm border rounded-md focus:outline-none focus:ring">
        </div>
        <nav class="flex-1 px-4 space-y-2 mt-2">
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                <span class="material-icons mr-2">dashboard</span> Dashboard
            </a>
            <a href="{{ route('user.products') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                <span class="material-icons mr-2">shopping_cart</span> Produk
            </a>
            <a href="{{ route('user.transactions') }}" class="flex items-center p-2 rounded hover:bg-gray-100">
                <span class="material-icons mr-2">receipt</span> Transaksi
            </a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="p-4">
            @csrf
            <button type="submit" class="w-full bg-red-100 text-red-700 p-2 rounded hover:bg-red-200 text-sm">
                Logout
            </button>
        </form>
    </div>

    <!-- Content -->
    <div class="flex-1 w-full overflow-y-auto p-4">

        <!-- Hamburger (mobile only) -->
        <div class="md:hidden mb-4">
            <button id="toggleSidebar" class="p-2 bg-white shadow rounded">
                <!-- Hamburger SVG from svgrepo -->
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 12h18v2H3v-2zm0-5h18v2H3V7zm0 10h18v2H3v-2z"/>
                </svg>
            </button>
        </div>

        <!-- Main content -->
        @yield('content')
    </div>
</div>

<!-- Toggle Sidebar Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
            });
        }
    });
</script>

</body>
</html>
