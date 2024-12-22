<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;

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
        $order->load('orderItems', 'payment', 'shipment'); // Memuat data orderItems untuk detail order
        return view('admin.order.show', compact('order'));
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,confirmed,failed',
        ]);

        // Update payment status
        $order->payment->status = $request->input('payment_status');
        $order->payment->save();

        return redirect()->route('admin.order.show', $order->id)->with('success', 'Payment status updated successfully.');
    }

    public function createShipment(Request $request, Order $order)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered',  // Status shipment
        ]);

        // Membuat data shipment baru
        $shipment = new Shipment();
        $shipment->order_id = $order->id;  // Menghubungkan shipment dengan order
        $shipment->tracking_number = Shipment::generateTrackingNumber();  // Membuat tracking number secara otomatis
        $shipment->status = $request->input('status');  // Menyimpan status shipment

        // Menyimpan shipment ke database
        $shipment->save();

        // Memberikan feedback kepada user setelah berhasil
        return redirect()->route('admin.order.show', $order->id)
                         ->with('success', 'Shipment created successfully.');
    }

    public function updateShipmentStatus(Request $request, Order $order)
    {

        $request->validate([
            'status' => 'required|in:pending,shipped,delivered',
        ]);

        // Pastikan order sudah memiliki shipment
        if ($order->shipment) {
            // Update status shipment
            $order->shipment->update([
                'status' => $request->status,
            ]);
        } else {
            // Handle jika tidak ada shipment
            return redirect()->back()->withErrors(['shipment' => 'Shipment not found for this order.']);
        }

        return redirect()->route('admin.order.index')->with('success', 'Shipment status updated successfully!');
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
