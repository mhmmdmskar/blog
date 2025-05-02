<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CartController extends Controller
{
    // Tampilkan keranjang user
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('user.cart.index', compact('cartItems'));
    }

    // Tambah produk ke keranjang
    public function add($id)
    {
        $product = Product::find($id);

        if (!$product || $product->stock < 1) {
            return back()->with('error', 'Produk tidak tersedia atau stok habis.');
        }

        $cartItem = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $id],
            ['quantity' => 0, 'total_price' => 0]
        );

        $cartItem->quantity += 1;
        $cartItem->total_price = $cartItem->quantity * $product->price;
        $cartItem->save();

        return redirect()->route('user.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Hapus produk dari keranjang
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->find($id);

        if ($cartItem) {
            $cartItem->delete();
            return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    // Checkout keranjang
    public function checkout()
    {
        // Ambil semua item di keranjang pengguna yang sedang login
        $cartItems = Cart::where('user_id', auth()->id())->get();
    
        // Jika keranjang kosong
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang kamu kosong!');
        }
    
        // Hitung total harga semua item
        $total_price = $cartItems->sum('total_price');
    
        // Buat transaksi baru
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'total_price' => $total_price,
            'status' => 'Menunggu', // Status menunggu hingga pembayaran diproses
        ]);
    
        // Masukkan detail transaksi
        foreach ($cartItems as $item) {
            $transaction->details()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total_price' => $item->total_price,
            ]);
        }
    
        // Kosongkan keranjang setelah checkout
        Cart::where('user_id', auth()->id())->delete();
    
        // Kirim Snap Token untuk proses pembayaran Midtrans
        $snapToken = $this->getSnapToken($transaction);
    
        // Arahkan ke halaman transaksi dengan token Midtrans
        return redirect()->route('user.transactions')->with([
            'snapToken' => $snapToken,
            'transaction_id' => $transaction->id
        ]);
    }
    
    // Fungsi untuk mendapatkan Snap Token
    private function getSnapToken($transaction)
    {
        // Setup Midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    
        // Data transaksi untuk Midtrans
        $midtransParams = [
            'transaction_details' => [
                'order_id' => 'TRX-'.$transaction->id.'-'.time(),
                'gross_amount' => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];
    
        // Dapatkan Snap Token Midtrans
        return \Midtrans\Snap::getSnapToken($midtransParams);
    }    
}
