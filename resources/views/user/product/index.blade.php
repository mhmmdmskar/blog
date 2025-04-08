@extends('layouts.admin') {{-- atau layouts.user --}}

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Produk</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mb-1">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500">{{ $product->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
