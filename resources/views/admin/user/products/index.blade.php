@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold text-[#305c88] mb-6">Daftar Produk</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border p-4 rounded shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-[#305c88]">{{ $product->name }}</h3>
                <p class="text-sm text-gray-700">Harga: Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $product->description }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
