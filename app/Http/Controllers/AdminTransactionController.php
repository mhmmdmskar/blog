<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        // Ambil semua transaksi dengan relasi user dan product dengan pagination
        $transactions = Transaction::with('user', 'product')->latest()->paginate(10); // Paginasi 10 transaksi per halaman
        return view('admin.transactions.index', compact('transactions'));
    }

    // Mengupdate status transaksi
    public function updateStatus(Request $request, $id)
    {
        dd($request->status);  // Debugging status yang diterima
        
        // Validasi input status
        $request->validate([
            'status' => 'required|string|in:Menunggu,Berhasil,Gagal',
        ]);

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Debugging: Log status yang diterima untuk memastikan datanya benar
        \Log::info('Status yang diterima untuk transaksi ID ' . $id . ': ' . $request->status);

        // Pastikan status baru berbeda dengan status lama
        if ($transaction->status !== $request->status) {
            // Mengupdate status transaksi
            $transaction->update(['status' => $request->status]);

            // Redirect dengan pesan sukses
            return redirect()->route('admin.transactions.index')
                ->with('success', 'Status transaksi berhasil diperbarui.');
        }

        // Jika status tidak berubah
        return redirect()->route('admin.transactions.index')
            ->with('info', 'Status transaksi tidak berubah.');
    }
}