<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses Pengunjung / Customer tanpa Login)
|--------------------------------------------------------------------------
*/
// 1. Landing Page Utama ala Desty
Route::get('/', function () {
    return view('welcome');
});

// 2. Katalog Belanja Customer
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Rute Checkout Pelanggan (Guest Checkout)
Route::get('/checkout/{product}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/payment/dummy/{orderCode}', [CheckoutController::class, 'dummyPayment'])->name('checkout.dummy_payment');
Route::post('/checkout/payment/confirm/{orderCode}', [CheckoutController::class, 'markAsPaid'])->name('checkout.confirm_paid');
Route::get('/checkout/success/{orderCode}', [CheckoutController::class, 'success'])->name('checkout.success');


/*
|--------------------------------------------------------------------------
| Admin / Owner saja (dilindungi di SERVER lewat Gate)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:manage-master-data'])->group(function () {
    Route::resource('categories', CategoryController::class)->except('show');
    
    // CRUD Supplier
    Route::resource('suppliers', SupplierController::class)->except(['create', 'show']);
    
    Route::resource('products', ProductController::class)->except(['index', 'show']);
});


/*
|--------------------------------------------------------------------------
| Admin / Owner (Manajemen Pengguna)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::resource('users', UserController::class)->except(['show', 'destroy']);
});


/*
|--------------------------------------------------------------------------
| Semua user yang sudah login (Admin dan Staff Kasir)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::group(['middleware' => function ($request, $next) {
        if ($request->user()->role === 'customer') {
            return redirect()->route('shop.index')->with('info', 'Anda dialihkan ke etalase belanja.');
        }
        return $next($request);
    }], function () {
            
    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Melihat Katalog & Detail Produk Internal
    Route::resource('products', ProductController::class)->only(['index', 'show']);

    // Transaksi Barang Masuk (Stock-In)
    Route::resource('purchases', PurchaseController::class)->except(['edit', 'update', 'destroy']);

    // Transaksi Barang Keluar / Kasir (Stock-Out)
    Route::resource('sales', SaleController::class)->except(['edit', 'update', 'destroy']);

    // Pengaturan Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/admin/orders', [App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/{id}/print', [App\Http\Controllers\AdminOrderController::class, 'print'])->name('admin.orders.print');

    });
});

require __DIR__.'/auth.php';