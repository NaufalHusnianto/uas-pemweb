<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();
        return view('cart', compact('carts'));
    }

    public function removeFromCart($cartId)
    {
        $user = Auth::user();
        
        $cartItem = Cart::where('user_id', $user->id)->where('id', $cartId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
        } else {
            return redirect()->route('cart.index')->with('error', 'Item not found in your cart.');
        }
    }

}
