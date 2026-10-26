<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->paginate(10);
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:suppliers,name',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Supplier::create($request->all());
        return back()->with('success', 'Data Supplier baru berhasil ditambahkan!');
    }

    public function destroy(Supplier $supplier)
    {
        // Proteksi: Jangan hapus jika sudah ada transaksi pembelian dengan supplier ini
        if ($supplier->purchases()->exists()) {
            return back()->with('error', 'Gagal dihapus! Supplier ini sudah memiliki riwayat transaksi barang masuk.');
        }

        $supplier->delete();
        return back()->with('success', 'Supplier berhasil dihapus.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            // Validasi nama harus unik, KECUALI untuk ID supplier ini sendiri
            'name' => 'required|string|max:100|unique:suppliers,name,' . $supplier->id,
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $supplier->update($request->all());
        
        return redirect()->route('suppliers.index')
            ->with('success', 'Data Supplier "' . $supplier->name . '" berhasil diperbarui!');
    }
}