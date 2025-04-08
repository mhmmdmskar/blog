@extends('layouts.app') <!-- Ganti sesuai layout user kamu -->

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Keranjang Saya</h2>

    @if(count($cart) > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Deskripsi</th>
                        <th class="px-4 py-2 text-left">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item['name'] }}</td>
                            <td class="px-4 py-2">{{ $item['description'] }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">Keranjang masih kosong.</p>
    @endif
</div>
@endsection