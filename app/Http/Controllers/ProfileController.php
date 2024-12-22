<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\AddressSelected;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $selectedAddress = AddressSelected::where('user_id', Auth::id())->first();
        $selectedAddressId = $selectedAddress ? $selectedAddress->address_id : null;

        $addresses = Auth::user()->addresses;

        return view('profile.edit', [
            'user' => $request->user(),
        ], compact('addresses', 'selectedAddressId'));
    }

    public function selectAddress(Request $request)
    {
        $user = Auth::user();

        // Delete any existing selected address for this user
        AddressSelected::where('user_id', $user->id)->delete();

        // Create new selected address
        AddressSelected::create([
            'user_id' => $user->id,
            'address_id' => $request->address_id
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile-photos', 'public');

            if ($user->photo_url) {
                Storage::disk('public')->delete($user->photo_url);
            }

            $user->photo_url = $photoPath;
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
