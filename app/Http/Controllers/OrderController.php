<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function confirmOrder(Request $request)
    {
        $selectedItems = json_decode($request->input('selected_items'), true);
        $request->validate([
            'selected_items' => 'required',
            'total_price' => 'required|numeric|min:1',
        ]);
    
        if (!is_array($selectedItems)) {
            $selectedItems = [$selectedItems];
        }
    
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);
    
        foreach ($selectedItems as $cartId) {
            $cart = Auth::user()->carts()->find($cartId);
            if ($cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
    
                $cart->delete();
            }
        }
    
        return redirect()->route('order.show', $order->id)
                         ->with('success', 'Order berhasil! Lanjutkan ke pembayaran.');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('order', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load('payment', 'shipment');

        return view('show-order', compact('order'));
    }

    public function cancelOrder(Order $order)
    {
        $order->status = 'cancelled';
        $order->save();
    
        return redirect()->route('order.show', $order->id)
                         ->with('success', 'Order berhasil dibatalkan!');
    }

    public function storePayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'method' => 'required|in:bank_transfer,paypal,dana,gopay,ovo',
        ]);

        $order->payment()->create([
            'method' => $validated['method'],
            'status' => 'pending',
        ]);

        return redirect()->route('order.show', $order->id)->with('success', 'Payment method has been selected.');
    }

    public function printInvoice($orderId)
    {
        $order = Order::with(['user', 'orderItems.product', 'payment', 'shipment'])->findOrFail($orderId);

        $pdf = Pdf::loadView('invoice', compact('order'));
        // $pdf = PDF::loadView('order.invoice', compact('order'));
        
        return $pdf->download('invoice_' . $order->id . '.pdf');
    }
}
