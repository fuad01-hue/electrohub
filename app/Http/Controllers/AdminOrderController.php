<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        // Mengambil semua data pesanan dari yang paling baru
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function print($id)
    {
        // Pastikan model Order sudah di-import (use App\Models\Order;)
        $order = Order::findOrFail($id);
        return view('orders.print', compact('order'));
    }
}