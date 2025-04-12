<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request; // <- Tambahan penting

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user', 'product')->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
