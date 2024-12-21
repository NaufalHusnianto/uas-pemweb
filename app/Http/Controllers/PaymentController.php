<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends Controller
{
    public function showPayment(Order $order)
    {
        return view('payment', compact('order'));
    }

    public function processPayment(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'method' => 'required|string',
        ]);

        $payment = Payment::create([
            'order_id' => $data['order_id'],
            'method' => $data['method'],
            'status' => 'completed',
        ]);

        $order = Order::findOrFail($data['order_id']);
        $order->status = 'paid';
        $order->save();

        return redirect()->route('order.showConfirmation', $order->id)
                         ->with('success', 'Payment berhasil diproses!');
    }
}

