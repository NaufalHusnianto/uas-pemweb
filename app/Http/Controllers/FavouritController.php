<?php

namespace App\Http\Controllers;

use App\Models\Favourit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritController extends Controller
{
    public function addFavouritItem(Request $request, $productId)
    {
        $user = Auth::user();

        $exists = Favourit::where('user_id', $user->id)->where('product_id', $productId)->exists();

        if ($exists) {
            return redirect()->route('products')->with('error', 'Item already in your favourites.');
        }

        Favourit::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return redirect()->route('favourit.index')->with('success', 'Item added to your favourites.');
    }


    public function index()
    {
        $user = Auth::user();
        $favourites = Favourit::where('user_id', $user->id)->get();
        return view('favourite', compact('favourites'));
    }

    public function removeFavouriteItem($favId)
    {
        $user = Auth::user();

        $favItem = Favourit::where('user_id', $user->id)->where('id', $favId)->first();

        if ($favItem) {
            $favItem->delete();
            return redirect()->route('favourit.index')->with('success', 'Item removed from Favourite Page!');
        } else {
            return redirect()->route('favourit.index')->with('error', 'Item not found in your favourite page.');
        }
    }
}
