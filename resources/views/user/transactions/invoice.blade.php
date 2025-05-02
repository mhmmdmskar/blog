@extends('layouts.user')

@section('content')
    <div class="container">
        <h2>Invoice Transaksi #{{ $transaction->id }}</h2>
        <p>Tanggal: {{ $transaction->created_at->format('d M Y, H:i') }}</p>
        <p>Status: {{ ucfirst($transaction->status) }}</p>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price,0,',','.') }}</td>
                        <td>{{ number_format($detail->total_price,0,',','.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: Rp {{ number_format($transaction->total_price,0,',','.') }}</h3>
    </div>
@endsection
