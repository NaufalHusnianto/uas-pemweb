<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function index()
    {
        // Ambil semua order_id dari tabel shipments
        $orderIDs = Shipment::pluck('order_id')->toArray();

        // Kirim data ke view profile.dashboard-admin
        return view('profile.dashboard-admin', compact('orderIDs'));
    }
}
