<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;

class CartController extends Controller
{
    public function add($id)
    {
        $product = Product::findOrFail($id);
        return view('user.confirm-purchase', compact('product'));
    }

    public function checkout()
{
    $user = auth()->user();
    $cartItems = $user->cartItems()->with('product')->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('user.cart.index')->with('error', 'Keranjang kosong!');
    }

    // Buat transaksi baru
    $transaction = $user->transactions()->create([
        'total_price' => $cartItems->sum(function($item) {
            return $item->product->price;
        }),
        'status' => 'pending'
    ]);

    // Simpan detail transaksi
    foreach ($cartItems as $item) {
        $transaction->details()->create([
            'product_id' => $item->product_id,
            'price' => $item->product->price,
        ]);
    }

    // Kosongkan keranjang
    $user->cart()->delete();

    return redirect()->route('user.transactions')->with('success', 'Checkout berhasil! Menunggu konfirmasi.');
}

public function index()
{
    $cartItems = auth()->user()->cartItems()->with('product')->get();
    return view('user.cart.index', compact('cartItems'));
}

}