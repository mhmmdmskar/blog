@extends('layouts.user')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Daftar Transaksi</h1>

    @if($transactions->isEmpty())
        <p class="text-gray-600">Belum ada transaksi.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 text-left">Produk</th>
                        <th class="px-4 py-2 text-left">Jumlah</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $trx->product_name }}</td>
                            <td class="px-4 py-2">{{ $trx->quantity }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-2 py-1 text-xs rounded 
                                    @if($trx->status === 'Berhasil') bg-green-100 text-green-700
                                    @elseif($trx->status === 'Menunggu') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection