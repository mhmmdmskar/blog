<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        // Ambil semua transaksi dengan relasi user dan product
        $transactions = Transaction::with('user', 'product')->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    // Mengupdate status transaksi
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|string|in:Menunggu,Berhasil,Gagal',
        ]);

        // Mencari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Pastikan status baru berbeda dengan status lama
        if ($transaction->status !== $request->status) {
            // Mengupdate status transaksi
            $transaction->status = $request->status;
            $transaction->save(); // Simpan perubahan ke database
        }

        // Mengarahkan kembali ke halaman transaksi dengan pesan sukses
        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}