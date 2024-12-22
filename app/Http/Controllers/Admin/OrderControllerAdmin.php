<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderControllerAdmin extends Controller
{
    // Menampilkan daftar order
    public function index()
    {
        $orders = Order::with('user')->paginate(10); // Memuat data user untuk setiap order
        return view('admin.order.index', compact('orders'));
    }

    // Menampilkan detail order
    public function show(Order $order)
    {
        $order->load('orderItems'); // Memuat data orderItems untuk detail order
        return view('admin.order.show', compact('order'));
    }
}