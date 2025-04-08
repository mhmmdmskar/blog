<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return redirect()->route('login');
});

// =======================
// ROUTE UNTUK USER BIASA
// =======================
Route::middleware(['auth', 'isUser'])->group(function () {
    // Dashboard user - daftar produk
    Route::get('/dashboard', [ProductController::class, 'userIndex'])->name('dashboard');

    // Daftar produk (khusus user)
    Route::get('/products', [ProductController::class, 'userIndex'])->name('user.products');

    // Edit profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tambah ke keranjang
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

    // Tampilkan keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});

// =======================
// ROUTE KHUSUS ADMIN
// =======================
Route::middleware(['auth', 'isAdmin']) // ✅ Ganti class langsung ke alias 'isAdmin'
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUserForm'])->name('users.create');
        Route::post('/users', [AdminController::class, 'createUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Kelola Produk (admin)
        Route::resource('products', ProductController::class)->names([
            'index'   => 'products.index',
            'create'  => 'products.create',
            'store'   => 'products.store',
            'edit'    => 'products.edit',
            'update'  => 'products.update',
            'destroy' => 'products.destroy',
        ]);
    });

// =======================
// ROUTE AUTH (Laravel Breeze)
// =======================
require __DIR__.'/auth.php';