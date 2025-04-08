<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transaction; // kalau ada transaksi
use Illuminate\Support\Facades\Hash;
use App\Models\Product;


class AdminController extends Controller
{
    // Tampilkan dashboard admin (daftar user biasa)
    public function index()
    {
        $users = User::where('role', 'user')->get();
        $products = \App\Models\Product::all(); // tambahkan ini
    
        return view('admin.dashboard', compact('users', 'products'));
    }    

    // Proses tambah user baru
    public function createUser(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'user',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }

    // Tampilkan form edit user
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function dashboard()
    {
        $totalProduk = Product::count();
        $totalTransaksi = 0; // ganti kalau sudah ada model transaksi
        $saldo = 0; // bisa diganti kalau pakai sistem saldo
    
        return view('admin.dashboard', compact('totalProduk', 'totalTransaksi', 'saldo'));
    }    

    // Proses update user
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil diupdate!');
    }

    // Hapus user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User berhasil dihapus!');
    }

    public function userList()
{
    $users = User::where('role', 'user')->get();
    return view('admin.users', compact('users'));
}

public function createUserForm()
{
    return view('admin.create-user');
}
}