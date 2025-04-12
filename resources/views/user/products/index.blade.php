@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Produk</h2>

    <!-- Form Search -->
    <div class="flex justify-end mb-4">
        <form action="{{ route('user.products') }}" method="GET" class="flex items-center bg-white border border-gray-300 rounded-lg px-3 py-1 shadow-sm">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari produk..." 
                class="outline-none px-2 py-1 text-sm text-gray-700 placeholder-gray-400"
            >
            <button type="submit" class="ml-2">
                <img src="https://www.svgrepo.com/show/532555/search.svg" alt="Cari" class="w-5 h-5 text-gray-500">
            </button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-left">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="py-3 px-4">Nama</th>
                    <th class="py-3 px-4">Deskripsi</th>
                    <th class="py-3 px-4">Harga</th>
                    <th class="py-3 px-4">Stok</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $product->description }}</td>
                    <td class="py-3 px-4 text-gray-800">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>
                    <td class="py-3 px-4 text-gray-800">
                        @if ($product->stock > 0)
                            {{ $product->stock }}
                        @else
                            <span class="text-red-600 font-semibold">Habis</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('user.cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button 
                                type="submit"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-white rounded transition
                                    {{ $product->stock < 1 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }}"
                                {{ $product->stock < 1 ? 'disabled' : '' }}
                            >
                                <img src="{{ asset('icons/basket.svg') }}" alt="Beli" class="w-4 h-4">
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Produk tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection