<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\IsAdmin;

// ==================
// ROUTE AUTH
// ==================
require __DIR__.'/auth.php';

// ==================
// ROOT REDIRECT
// ==================
Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect setelah login berdasarkan peran
Route::middleware(['auth'])->get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->name('dashboard');

// ==================
// ROUTE ADMIN
// ==================
Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manage Users
        Route::resource('users', UserController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        // Manage Products
        Route::resource('products', ProductController::class)->names([
            'index'   => 'products.index',
            'create'  => 'products.create',
            'store'   => 'products.store',
            'edit'    => 'products.edit',
            'update'  => 'products.update',
            'destroy' => 'products.destroy',
        ]);

        // Transactions
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
        Route::put('/transactions/{id}/status', [AdminTransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
    });

// ==================
// ROUTE USER
// ==================
Route::middleware(['auth', IsUser::class])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // User Dashboard
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // Products for User
        Route::get('/products', [ProductController::class, 'userIndex'])->name('products');

        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Halaman keranjang
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); // Menambah produk ke keranjang
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Hapus produk dari keranjang
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // Proses checkout menuju transaksi dan Midtrans

        // Transactions Routes
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions'); // Menampilkan transaksi
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store'); // Menyimpan transaksi baru

        // Route untuk invoice transaksi
        Route::get('/transactions/{transaction}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice'); // Menampilkan invoice transaksi

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

// Route untuk callback dari Midtrans
Route::post('/midtrans/callback', [TransactionController::class, 'midtransCallback'])->name('midtrans.callback'); // Callback dari Midtrans
