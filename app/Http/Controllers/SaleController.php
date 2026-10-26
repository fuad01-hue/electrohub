<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // Hanya tampilkan produk yang stoknya lebih dari 0
        $products = Product::where('stock', '>', 0)->orderBy('name', 'asc')->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'customer_name' => 'nullable|string|max:100',
            'sold_at' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ], [
            'products.required' => 'Minimal satu produk harus dimasukkan ke keranjang.',
        ]);

        // 2. Transaksi Database (Syarat Utama UTS)
        try {
            DB::beginTransaction();

            // A. Buat Header Nota Penjualan
            $nomorInvoice = 'INV-' . date('YmdHis');

            $sale = Sale::create([
                'user_id'        => Auth::id(),
                'sale_number'    => $nomorInvoice,
                'invoice_number' => $nomorInvoice, // Tambahkan baris ini agar MySQL tidak error
                'sold_at'        => $request->sold_at,
                'total'          => 0
            ]);

            $grandTotal = 0;

            // B. Proses setiap item di keranjang
        foreach ($request->products as $item) {
            // 1. Kunci baris produk & ambil data valid langsung dari database
            $product = Product::lockForUpdate()->findOrFail($item['product_id']);
            $qty = (int) $item['quantity'];

            // 2. VALIDASI KRUSIAL: Kuantitas valid (>0) dan stok mencukupi
            if ($qty < 1 || $product->stock < $qty) {
                throw new \Exception("Stok produk {$product->name} tidak mencukupi atau kuantitas tidak valid! Sisa stok saat ini: {$product->stock} unit.");
            }

            // 3. HITUNG HARGA DARI DATABASE (Bukan dari input browser)
            $unitPrice = $product->selling_price; // Ambil harga resmi dari DB
            $subtotal = $qty * $unitPrice;
            $grandTotal += $subtotal;

            // 4. Simpan detail item
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $product->id,
                'quantity'   => $qty,
                'unit_price' => $unitPrice,
                'subtotal'   => $subtotal,
            ]);

            // 5. Kurangi Stok Secara Otomatis
            $product->decrement('stock', $qty);
        }

            // C. Update Grand Total
            $sale->update(['total' => $grandTotal]);

            // Jika semua lolos validasi, simpan permanen!
            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Transaksi Penjualan berhasil! Stok telah otomatis dikurangi.');

        } catch (\Exception $e) {
            // Jika stok tidak cukup atau ada error lain, BATALKAN SEMUA PROSES (Rollback)
            DB::rollBack();
            return back()->with('error', 'Transaksi Dibatalkan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'saleItems.product']);
        return view('sales.show', compact('sale'));
    }
}