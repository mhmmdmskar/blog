<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\IsAdmin;

// =======================
// REDIRECT ROOT KE LOGIN
// =======================
Route::get('/', function () {
    return redirect()->route('login');
});

// =======================
// REDIRECT SETELAH LOGIN
// =======================
Route::middleware(['auth'])->get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->name('dashboard');

// =======================
// ROUTE UNTUK ADMIN
// =======================
Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Produk
        Route::resource('products', ProductController::class)->names([
            'index'   => 'products.index',
            'create'  => 'products.create',
            'store'   => 'products.store',
            'edit'    => 'products.edit',
            'update'  => 'products.update',
            'destroy' => 'products.destroy',
        ]);

        // Transaksi Admin
        Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transactions/{id}/status', [AdminTransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
    });

// =======================
// ROUTE UNTUK USER
// =======================
Route::middleware(['auth', IsUser::class])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard User
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // Produk
        Route::get('/products', [ProductController::class, 'userIndex'])->name('products');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

        // Transaksi User
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

// =======================
// ROUTE AUTH
// =======================
require __DIR__.'/auth.php';