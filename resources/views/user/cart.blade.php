@extends('layouts.user')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Keranjang Saya</h2>

    @if(count($cartItems) > 0)
        <table class="min-w-full table-auto border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Produk</th>
                    <th class="px-4 py-2 border">Deskripsi</th>
                    <th class="px-4 py-2 border">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border px-4 py-2">{{ $item->product->description }}</td>
                        <td class="border px-4 py-2">Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tombol Checkout --}}
        <form action="{{ route('user.cart.checkout') }}" method="POST" class="mt-4 text-right">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Checkout
            </button>
        </form>
    @else
        <p class="text-gray-500">Keranjang kamu masih kosong.</p>
    @endif
</div>
@endsection