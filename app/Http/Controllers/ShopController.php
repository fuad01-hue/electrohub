<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori beserta jumlah produknya
        $categories = Category::withCount('products')->get();

        // 2. Siapkan query dasar produk
        $query = Product::with('category');

        // 3. Filter berdasarkan kategori yang dipilih (?category=ID)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 4. Filter pencarian nama barang atau SKU jika form search diisi
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // 5. Eksekusi paginasi data
        $products = $query->latest()->paginate(12)->withQueryString();

        return view('shop.index', compact('products', 'categories'));
    }
}