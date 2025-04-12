<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalTransaksi = Transaction::where('user_id', Auth::id())->count();

        return view('user.dashboard', compact('totalProduk', 'totalTransaksi'));
    }
}