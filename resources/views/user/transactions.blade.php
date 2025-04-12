@extends('layouts.user') {{-- Ganti kalau pakai layout lain --}}

@section('content')
    <div class="container">
        <h1>Daftar Transaksi</h1>

        @if(session('success'))
            <div style="color: green;">{{ session('success') }}</div>
        @endif

        @if($transactions->isEmpty())
            <p>Belum ada transaksi.</p>
        @else
            <ul>
                @foreach ($transactions as $transaction)
                    <li>
                        {{ $transaction->product_name }} - Rp{{ number_format($transaction->total_price) }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
