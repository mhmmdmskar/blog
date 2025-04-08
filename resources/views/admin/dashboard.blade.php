@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Dashboard Admin</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-4 shadow rounded-xl">
                <p class="text-gray-600">Total Produk</p>
                <h3 class="text-3xl font-semibold">{{ $totalProduk }}</h3>
            </div>
            <div class="bg-white p-4 shadow rounded-xl">
                <p class="text-gray-600">Total Transaksi</p>
                <h3 class="text-3xl font-semibold">{{ $totalTransaksi }}</h3>
            </div>
            <div class="bg-white p-4 shadow rounded-xl">
                <p class="text-gray-600">Saldo</p>
                <h3 class="text-3xl font-semibold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
@endsection