<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();
        return view('user.transactions', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        // ✅ Cek stok
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Stok produk habis!');
        }

        // ✅ Simpan transaksi
        $transaction = $user->transactions()->create([
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'price'        => $product->price,
            'quantity'     => 1,
            'total_price'  => $product->price,
        ]);

        // ✅ Kurangi stok
        $product->decrement('stock');

        return redirect()->route('user.transactions')->with('success', 'Transaksi berhasil!');
    }
}