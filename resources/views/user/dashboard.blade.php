@extends('layouts.user')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Welcome, {{ Auth::user()->name }}</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Total Produk</p>
            <h2 class="text-2xl font-bold">{{ $totalProduk }}</h2>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Total Transaksi</p>
            <h2 class="text-2xl font-bold">{{ $totalTransaksi }}</h2>
        </div>
    </div>
@endsection
