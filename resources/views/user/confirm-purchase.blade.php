@extends('layouts.user')

@section('content')
<div class="max-w-lg mx-auto mt-20 bg-white border border-gray-200 rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center border-b pb-3">Konfirmasi Pembelian</h2>

    <!-- Info Produk -->
    <div class="text-center text-gray-700 space-y-4 mb-10">
        <div>
            <p class="text-sm font-medium text-gray-500">Nama Produk</p>
            <p class="text-lg font-semibold text-gray-800">{{ $product->name }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Harga</p>
            <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-center gap-x-16 items-center">
        <a href="{{ route('user.products') }}"
           class="px-6 py-2 border border-gray-400 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-200">
            Batal
        </a>
        <form action="{{ route('user.transactions.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit"
        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
        Lanjutkan Pembelian
    </button>
</form>
    </div>
</div>
@endsection