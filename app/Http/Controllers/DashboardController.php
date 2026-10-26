<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Metrik Finansial & Operasional
        $totalRevenue = Sale::sum('total') ?? 0;
        $todayTransactions = Sale::whereDate('created_at', today())->count();
        $totalAssetValue = Product::all()->sum(fn($p) => $p->stock * $p->purchase_price);
        $lowStockCount = Product::whereColumn('stock', '<=', 'minimum_stock')->count();

        // Data Tabel
        $lowStockItems = Product::whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        $recentSales = Sale::latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalRevenue',
            'todayTransactions',
            'totalAssetValue',
            'lowStockCount',
            'lowStockItems',
            'recentSales'
        ));
    }
}