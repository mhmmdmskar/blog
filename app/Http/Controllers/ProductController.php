<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan produk untuk user biasa dengan pagination dan pencarian
    public function userIndex(Request $request)
    {
        $query = Product::query();

        // Pencarian produk berdasarkan nama atau deskripsi
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        }

        // Pagination 10 produk per halaman
        $products = $query->paginate(10)->appends(request()->query()); // Menjaga parameter pencarian saat berpindah halaman

        return view('user.products.index', compact('products'));
    }
}