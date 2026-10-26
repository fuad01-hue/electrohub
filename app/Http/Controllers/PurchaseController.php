<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user'])->latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        // Hanya ambil produk yang valid untuk dibeli
        $products = Product::orderBy('name', 'asc')->get(); 
        
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Syarat UTS)
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchased_at' => ['required', 'date'],
            'products' => ['required', 'array', 'min:1'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ], [
            'products.required' => 'Minimal satu produk harus ditambahkan ke keranjang pembelian.',
        ]);

        // 2. Database Transaction (Syarat Wajib UTS)
        try {
            DB::beginTransaction();

            // A. Simpan Header Transaksi
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(), // Siapa staff/admin yang input
                'purchase_number' => 'PO-' . date('YmdHis'), // Generate nomor struk unik
                'status' => 'completed',
                'purchased_at' => $request->purchased_at,
                'total' => 0 // Set 0 dulu, nanti di-update
            ]);

            $grandTotal = 0;

            // B. Simpan Detail Item dan Update Stok
            foreach ($request->products as $item) {
                $subtotal = $item['quantity'] * $item['unit_cost'];
                $grandTotal += $subtotal;

                // Simpan item pembelian
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal
                ]);

                // Update Stok Produk (Otomatis bertambah)
                $product = Product::find($item['product_id']);
                $product->increment('stock', $item['quantity']);
            }

            // C. Update Grand Total di Header
            $purchase->update(['total' => $grandTotal]);

            // Jika semua lancar, commit (simpan permanen ke DB)
            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi Stock-In berhasil! Stok produk telah otomatis bertambah.');

        } catch (\Exception $e) {
            // Jika ada error sekecil apapun, batalkan SEMUA proses (Rollback)
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal disimpan! Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'purchaseItems.product']);
        return view('purchases.show', compact('purchase'));
    }
}