<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class OrderControllerAdmin extends Controller
{
    /**
     * Menampilkan daftar order.
     */
    public function index()
    {
        $orders = Order::with('user')->paginate(10); // Memuat data user untuk setiap order
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Menampilkan detail order.
     */
    public function show(Order $order)
    {
        $order->load('orderItems'); // Memuat data orderItems untuk detail order
        return view('admin.order.show', compact('order'));
    }

    /**
     * Menampilkan grafik Sales Overview.
     */
    public function salesOverview()
    {
        // Ambil data dari tabel shipments
        $shipments = DB::table('shipments')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(revenue) as total_revenue'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mengambil bulan dan total pendapatan
        $months = $shipments->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1)); // Mengubah angka bulan menjadi nama bulan
        });
        $revenues = $shipments->pluck('total_revenue');

        // Mengirim data ke view
        return view('admin.sales-overview', compact('months', 'revenues'));
    }
}
