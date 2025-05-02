@extends('layouts.user')

@section('content')
<div class="container">
    <h1 class="text-2xl font-semibold mb-6 text-center">Daftar Transaksi</h1>

    @if($transactions->isEmpty())
        <div class="text-center text-gray-500">
            <p>Belum ada transaksi.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-lg mx-auto">
            <table class="min-w-full text-sm table-auto text-center">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $trx)
                        @php
                            $detail = $trx->details->first();
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ optional($detail->product)->name ?? 'Produk Tidak Tersedia' }}
                            </td>
                            <td class="px-6 py-4">{{ $detail->quantity }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($detail->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded 
                                    @if($trx->status === 'Berhasil') bg-green-100 text-green-700
                                    @elseif($trx->status === 'Menunggu') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                @if($trx->status === 'Menunggu')
                                    @if($trx->snap_token)
                                        <button class="pay-button bg-blue-500 text-white px-4 py-2 rounded" data-token="{{ $trx->snap_token }}">
                                            Bayar Sekarang
                                        </button>
                                    @else
                                        <span class="text-sm text-red-400 italic">Token tidak tersedia</span>
                                    @endif
                                @elseif($trx->status === 'Berhasil')
                                    <a href="{{ route('user.transactions.invoice', ['transaction' => $trx->id]) }}" class="hover:bg-blue-200 p-2 rounded transition">
                                        <img src="{{ asset('icons/actions-view.svg') }}" alt="View Invoice" class="h-8 w-8 inline-block bg-blue-100 p-2 rounded transition-all duration-300 hover:bg-blue-300" />
                                    </a>
                                @else
                                    Menunggu Pembayaran
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    @endif
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.querySelectorAll('.pay-button').forEach(button => {
        button.addEventListener('click', function() {
            let snapToken = this.getAttribute('data-token');
            snap.pay(snapToken, {
                onSuccess: function(result){ 
                    alert('Pembayaran berhasil!');
                    location.reload();
                },
                onPending: function(result){
                    alert('Pembayaran sedang diproses!');
                    location.reload();
                },
                onError: function(result){
                    alert('Pembayaran gagal!');
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
