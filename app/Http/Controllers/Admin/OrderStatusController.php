<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderStatusController extends Controller
{
    public function update(Request $request)
    {
        dd($request);
        
        $validated = $request->validate([
            'statuses' => 'required|array',
        ]);

        dd($validated['statuses']);

        foreach ($validated['statuses'] as $orderId => $status) {
            $order = Order::find($orderId);
            if ($order) {
                $order->status = $status;
                $order->save();
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order statuses updated successfully.');
    }
}