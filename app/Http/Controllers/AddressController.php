<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;

class AddressController extends Controller
{
    use AuthorizesRequests;  // Add this trait

    public function addAddress()
    {
        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        return view('address', compact(['provinces', 'regencies', 'districts', 'villages']));
    }

    public function index()
    {
        $addresses = Auth::user()->addresses;
        return view('address.index', compact('addresses'));
    }

    public function create()
    {
        return view('address.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_id' => 'required|numeric',
            'province_name' => 'required|string',
            'regency_id' => 'required|numeric',
            'regency_name' => 'required|string',
            'district_id' => 'required|numeric',
            'district_name' => 'required|string',
            'village_id' => 'required|numeric',
            'village_name' => 'required|string',
            'detail_address' => 'required|string',
        ]);

        $address = new Address($validated);
        $address->user_id = Auth::id();
        $address->save();

        return redirect()->route('address.index')
            ->with('success', 'Address added successfully');
    }

    public function edit(Address $address)
    {
        $this->authorize('update', $address);

        $provinces = Province::orderBy('name', 'ASC')->get();
        $regencies = Regency::where('province_id', $address->province_id)
            ->orderBy('name', 'ASC')
            ->get();
        $districts = District::where('regency_id', $address->regency_id)
            ->orderBy('name', 'ASC')
            ->get();
        $villages = Village::where('district_id', $address->district_id)
            ->orderBy('name', 'ASC')
            ->get();

        return view('address.edit', compact('address', 'provinces', 'regencies', 'districts', 'villages'));
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'province_id' => 'required|numeric',
            'province_name' => 'required|string',
            'regency_id' => 'required|numeric',
            'regency_name' => 'required|string',
            'district_id' => 'required|numeric',
            'district_name' => 'required|string',
            'village_id' => 'required|numeric',
            'village_name' => 'required|string',
            'detail_address' => 'required|string',
        ]);

        $address->update($validated);

        return redirect()->route('address.index')
            ->with('success', 'Address updated successfully');
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();

        return redirect()->route('address.index')
            ->with('success', 'Address deleted successfully');
    }
}
