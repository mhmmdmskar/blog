@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Kelola Akun</h2>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center bg-[#305c88] text-white px-4 py-2 rounded hover:bg-[#264b6e]">
            <img src="https://www.svgrepo.com/show/524226/add-circle.svg" alt="Tambah" class="w-5 h-5 mr-2">
            Tambah Akun
        </a>
    </div>

    <table class="min-w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="text-center">
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2 capitalize">{{ $user->role }}</td>
                    <td class="border px-4 py-2 relative">
                        <!-- Tombol titik tiga -->
                        <button onclick="toggleMenu({{ $user->id }})" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 hover:text-gray-800" viewBox="0 0 24 24" fill="currentColor">
  <path d="M12 7a2 2 0 100-4 2 2 0 000 4zm0 2a2 2 0 100 4 2 2 0 000-4zm0 6a2 2 0 100 4 2 2 0 000-4z"/>
</svg>
                        </button>

                        <!-- Dropdown -->
                        <div id="menu-{{ $user->id }}" class="hidden absolute right-0 top-8 mt-2 w-28 bg-white border rounded shadow-md z-10">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus akun ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Hapus</button>
                            </form>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-4 text-gray-500">Belum ada akun user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function toggleMenu(userId) {
        const menu = document.getElementById(`menu-${userId}`);
        menu.classList.toggle('hidden');
    }

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function (e) {
        document.querySelectorAll('[id^="menu-"]').forEach(menu => {
            if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    });
</script>
@endsection