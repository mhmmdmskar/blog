@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Daftar Transaksi User</h2>

    <table class="min-w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">User</th>
                <th class="px-4 py-2 border">Produk</th>
                <th class="px-4 py-2 border">Jumlah</th>
                <th class="px-4 py-2 border">Total</th>
                <th class="px-4 py-2 border">Waktu</th>
                <th class="px-4 py-2 border">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $tx)
                <tr class="text-center hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $tx->user->name }}</td>
                    <td class="border px-4 py-2">{{ $tx->product_name }}</td>
                    <td class="border px-4 py-2">{{ $tx->quantity }}</td>
                    <td class="border px-4 py-2">Rp{{ number_format($tx->total_price, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ $tx->created_at->format('d M Y H:i') }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('admin.transactions.updateStatus', $tx->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="border px-2 py-1 rounded text-sm">
                                @foreach([
                                    'pending' => 'Menunggu',
                                    'diproses' => 'Diproses',
                                    'dikirim' => 'Dikirim',
                                    'selesai' => 'Selesai'
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ $tx->status === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
