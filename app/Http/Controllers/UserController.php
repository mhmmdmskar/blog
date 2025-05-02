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

public function destroy($id)
{
    $user = User::findOrFail($id);

    return redirect()->route('admin.users.index')->with('error', 'User not found');
}

public function edit($id)
{
    $user = User::findOrFail($id);
    return view('admin.edit-user', compact('user'));
}

public function update(Request $request, $id)
{
    // Validasi input awal
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:6|confirmed',
    ]);

    $user = User::findOrFail($id);

    // Cek apakah password baru sama dengan password lama
    if ($request->filled('password')) {
        if (Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.'])
                ->withInput(); // supaya input sebelumnya tetap tampil
        }

        // Jika tidak sama, tambahkan ke data update
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    } else {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
    }

    return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
}

}