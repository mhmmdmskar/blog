@extends('layouts.user')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Transaksi</h1>

    @if($transactions->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded">
            Belum ada transaksi yang tercatat.
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($transactions as $trx)
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="px-6 py-4">{{ $trx->product_name }}</td>
                            <td class="px-6 py-4">{{ $trx->quantity }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded 
                                    @if($trx->status === 'Berhasil') bg-green-100 text-green-700
                                    @elseif($trx->status === 'Menunggu') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    @if($trx->status === 'Berhasil')
                                        ✅
                                    @elseif($trx->status === 'Menunggu')
                                        ⏳
                                    @else
                                        ❌
                                    @endif
                                    <span class="ml-1">{{ ucfirst($trx->status) }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('user.transactions.invoice', $trx->id) }}" class="text-blue-500 hover:text-blue-700">
                                    View Invoice
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection