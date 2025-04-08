<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-black">
        <div class="bg-gray-900 p-10 rounded-2xl shadow-lg w-full max-w-md">
            <h1 class="text-white text-2xl font-semibold mb-6 text-center">Buat Akun Baru</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm text-gray-300">Nama</label>
                    <input id="name" type="text" name="name" required autofocus class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm text-gray-300">Email</label>
                    <input id="email" type="email" name="email" required class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm text-gray-300">Password</label>
                    <input id="password" type="password" name="password" required class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm text-gray-300">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-white">
                </div>

                <button type="submit" class="w-full bg-white text-black font-bold py-2 rounded hover:bg-gray-200 transition">Daftar</button>
            </form>

            <div class="text-sm text-center text-gray-400 mt-4">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-white hover:underline">Login di sini</a>
            </div>
        </div>
    </div>
</x-guest-layout>