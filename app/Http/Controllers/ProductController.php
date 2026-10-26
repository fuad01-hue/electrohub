<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->orderBy('name', 'asc')->get();

        $query = Product::with('category');

        // Filter berdasarkan Pencarian (Nama, SKU, atau Brand)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Menu Tab Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Stok Rendah (Low Stock)
        if ($request->get('filter') === 'low_stock') {
            $query->whereColumn('stock', '<=', 'minimum_stock');
        }

        $products = $query->latest()->paginate(10);

        // Statistik ringkas di bagian atas halaman produk
        $stats = [
            'total_products' => Product::count(),
            'total_stock'    => Product::sum('stock'),
            'low_stock'      => Product::whereColumn('stock', '<=', 'minimum_stock')->count(),
        ];

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'sku'            => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name'           => ['required', 'string', 'max:150'],
            'brand'          => ['nullable', 'string', 'max:50'],
            'specifications' => ['nullable', 'string'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price'  => ['required', 'numeric', 'min:0'],
            'minimum_stock'  => ['required', 'integer', 'min:0'],
        ], [
            'sku.unique'     => 'Kode SKU ini sudah dipakai produk lain.',
            'image.image'    => 'File harus berupa gambar (JPG, PNG, WEBP).',
            'image.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Sesuai aturan bisnis UTS: stok awal produk baru adalah 0 (bertambah lewat Purchase)
        $validated['stock'] = 0;

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk elektronik berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'sku'            => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'name'           => ['required', 'string', 'max:150'],
            'brand'          => ['nullable', 'string', 'max:50'],
            'specifications' => ['nullable', 'string'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price'  => ['required', 'numeric', 'min:0'],
            'minimum_stock'  => ['required', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Data produk "' . $product->name . '" berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Cek apakah produk sudah pernah masuk transaksi pembelian atau penjualan
        $hasPurchases = $product->purchaseItems()->exists();
        $hasSales = $product->saleItems()->exists();

        if ($hasPurchases || $hasSales) {
            return redirect()->route('products.index')->with('error', 
                "Gagal menghapus! Produk '{$product->name}' memiliki riwayat transaksi aktif dan tidak boleh dihapus demi integritas pembukuan."
            );
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}