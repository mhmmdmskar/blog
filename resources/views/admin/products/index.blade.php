@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Daftar Produk</h2>
        <a href="{{ route('admin.products.create') }}" class="flex items-center bg-[#305c88] text-white px-4 py-2 rounded hover:bg-[#264b6e]">
            <img src="https://www.svgrepo.com/show/524226/add-circle.svg" alt="Tambah Produk" class="w-5 h-5 mr-2">
            Tambah Produk
        </a>
    </div>

    <table class="min-w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Deskripsi</th>
                <th class="px-4 py-2 border">Harga</th>
                <th class="px-4 py-2 border">Stok</th> {{-- 🆕 Kolom Stok --}}
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="text-center relative">
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">{{ $product->description }}</td>
                    <td class="border px-4 py-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $product->stock }}</td> {{-- 🆕 Isi Stok --}}
                    <td class="border px-4 py-2 relative">
                        <!-- Trigger -->
                        <button onclick="toggleDropdown({{ $product->id }})" class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto text-gray-700" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 7a2 2 0 110-4 2 2 0 010 4zm0 3a2 2 0 110 4 2 2 0 010-4zm0 7a2 2 0 110 4 2 2 0 010-4z"/>
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div id="dropdown-{{ $product->id }}" class="absolute right-4 mt-2 bg-white border rounded shadow-lg w-28 z-50 hidden">
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Hapus
                                </button>
                            </form>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4 text-gray-500">Tidak ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function toggleDropdown(id) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
        const dropdown = document.getElementById('dropdown-' + id);
        dropdown.classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dropdown => {
            if (!dropdown.contains(e.target) && !dropdown.previousElementSibling.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>
@endsection
