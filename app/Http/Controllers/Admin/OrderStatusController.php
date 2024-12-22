<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderStatusController extends Controller
{
    public function update(Request $request)
    {
        
        $validated = $request->validate([
            'statuses' => 'required|array',
        ]);

        foreach ($validated['statuses'] as $orderId => $status) {
            $order = Order::find($orderId);
            if ($order) {
                $order->status = $status;
                $order->save();
            }
        }

        return redirect()->route('admin.order.index')->with('success', 'Order statuses updated successfully.');
    }
}