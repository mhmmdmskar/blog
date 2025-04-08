<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class UserController extends Controller
{
    public function dashboard()
    {
        $totalProduk = Product::count();
        $totalTransaksi = Transaction::where('user_id', auth()->id())->count();
        $saldo = 6000; // bisa disesuaikan jika ambil dari model Saldo

        return view('user.dashboard', compact('totalProduk', 'totalTransaksi', 'saldo'));
    }

    public function produk()
    {
        $products = Product::all();
        return view('user.produk.index', compact('products'));
    }
}