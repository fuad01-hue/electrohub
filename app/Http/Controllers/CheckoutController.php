<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Checkout Langsung
    public function show(Product $product)
    {
        if ($product->stock < 1) {
            return redirect()->route('shop.index')->with('error', 'Stok produk ini sedang habis.');
        }

        return view('shop.checkout', compact('product'));
    }

    // 2. Proses Pemesanan (Guest Checkout)
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'payment_method' => 'required|in:midtrans,dummy_qris,dummy_va',
        ]);

        $price = $product->price ?? $product->selling_price;
        $totalAmount = $price * $request->quantity;
        $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Simpan Order Sementara (Status: Pending)
        $order = Order::create([
            'order_code' => $orderCode,
            'product_id' => $product->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'payment_channel' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // ALUR OPSI 1: MIDTRANS SNAP (SANDBOX API)
        if ($request->payment_method === 'midtrans') {
            $serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-DUMMYKEY');

            try {
                $response = Http::withBasicAuth($serverKey, '')
                    ->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
                    ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', [
                        'transaction_details' => [
                            'order_id' => $order->order_code,
                            'gross_amount' => (int) $order->total_amount,
                        ],
                        'item_details' => [[
                            'id' => $product->sku ?? $product->id,
                            'price' => (int) $price,
                            'quantity' => (int) $order->quantity,
                            'name' => substr($product->name, 0, 45),
                        ]],
                        'customer_details' => [
                            'first_name' => $order->customer_name,
                            'phone' => $order->customer_phone,
                        ],
                    ]);

                $result = $response->json();
                if (isset($result['token'])) {
                    $order->update(['snap_token' => $result['token']]);
                    return view('shop.payment_midtrans', compact('order', 'product', 'result'));
                }
            } catch (\Exception $e) {
                // Fallback otomatis jika API key belum diisi / offline
            }
        }

        // ALUR OPSI 2: SIMULASI GATEWAY DUMMY (QRIS & VIRTUAL ACCOUNT)
        return redirect()->route('checkout.dummy_payment', $order->order_code);
    }

    // Layar Simulator Gateway Dummy (QRIS / VA)
    public function dummyPayment($orderCode)
    {
        $order = Order::with('product')->where('order_code', $orderCode)->firstOrFail();
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order->order_code);
        }

        return view('shop.payment_dummy', compact('order'));
    }

    // Eksekusi Konfirmasi Pembayaran (Memotong Stok secara ACID aman)
    public function markAsPaid($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order->order_code);
        }

        DB::transaction(function () use ($order) {
            $product = Product::lockForUpdate()->find($order->product_id);

            if ($product->stock < $order->quantity) {
                throw new \Exception('Stok produk tidak mencukupi saat proses finalisasi.');
            }

            // 1. Kurangi stok barang
            $product->decrement('stock', $order->quantity);

            // 2. Ubah status order menjadi Lunas
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);
        });

        return redirect()->route('checkout.success', $order->order_code)->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // Invoice Struk Pembayaran Sukses
    public function success($orderCode)
    {
        $order = Order::with('product')->where('order_code', $orderCode)->firstOrFail();
        return view('shop.success', compact('order'));
    }
}