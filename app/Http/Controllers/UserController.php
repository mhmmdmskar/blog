<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function index()
{
    $users = User::where('role', 'user')->get(); // Hanya tampilkan user biasa
    return view('admin.users.index', compact('users'));
}

public function create()
{
    return view('admin.users.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user', // pastiin ini default user biasa
    ]);

    return redirect()->route('admin.users.index')->with('success', 'Akun user berhasil dibuat.');
}
}