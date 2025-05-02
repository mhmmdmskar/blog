@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

<form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block mb-1 font-semibold">Nama Produk</label>
        <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1 font-semibold">Harga</label>
        <input type="number" name="price" class="w-full border border-gray-300 rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block mb-1 font-semibold">Deskripsi</label>
        <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="3"></textarea>
    </div>

    <div class="mb-4">
        <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
        <input type="number" name="stock" id="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
    </div>

    <div class="flex space-x-4">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Produk
        </button>

        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Batal
        </a>
    </div>
</form>
@endsection