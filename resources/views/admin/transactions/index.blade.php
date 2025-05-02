@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Transaksi</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-4">
            {{ session('info') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-gray-100 text-gray-600 uppercase">
                <tr>
                    <th class="px-6 py-3">ID</th>
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
                        <td class="px-6 py-4">{{ $trx->id }}</td>
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
                            <form action="{{ route('admin.transactions.updateStatus', $trx->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PUT')
                                <div class="flex items-center">
                                    <select name="status" class="form-select text-sm border rounded p-2" required>
                                        <option value="Menunggu" {{ $trx->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Berhasil" {{ $trx->status == 'Berhasil' ? 'selected' : '' }}>Berhasil</option>
                                        <option value="Gagal" {{ $trx->status == 'Gagal' ? 'selected' : '' }}>Gagal</option>
                                    </select>
                                    <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination controls -->
        <div class="mt-4">
            {{ $transactions->links() }} <!-- Pagination links -->
        </div>
    </div>
@endsection