<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function index()
    {
        // Gunakan strftime untuk mengekstrak jam dari kolom created_at
        $shipments = Shipment::selectRaw("strftime('%H', created_at) as hour, COUNT(*) as count")
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Format data untuk dikirim ke view
        $orderTimes = $shipments->pluck('hour')->map(function ($hour) {
            return $hour . ':00'; // Format: 01:00, 02:00, ...
        });

        $orderCounts = $shipments->pluck('count');

        // Kirim data ke view profile.dashboard-admin
        return view('dashboard-admin', compact('orderTimes', 'orderCounts'));
    }
}
