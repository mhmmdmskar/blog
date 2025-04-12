@extends('layouts.user')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($products as $product)
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
            <p class="text-gray-600">{{ $product->description }}</p>
            <p class="text-blue-600 font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            <form action="{{ route('user.cart.add', $product->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                    🛒
                </button>
            </form>
        </div>
    @endforeach
</div>
    </div>
@endsection