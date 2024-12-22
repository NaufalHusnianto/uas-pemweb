<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\AddressSelected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AddressController extends Controller
{

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
        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        $addresses = Auth::user()->addresses;
        return view('address.create', compact('addresses', 'provinces', 'regencies', 'districts', 'villages'));
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

        // $address = new Address($validated);
        // $address->user_id = Auth::id();
        // $address->save();


        DB::beginTransaction();
        try {
            $address = new Address($validated);
            $address->user_id = Auth::id();
            $address->save();

            // If this is the only address, automatically select it
            $addressCount = Address::where('user_id', Auth::id())->count();
            if ($addressCount === 1) {
                AddressSelected::updateOrCreate(
                    ['user_id' => Auth::id()],
                    ['address_id' => $address->id]
                );
            }

            DB::commit();
            return redirect()->route('profile.edit')
                ->with('success', 'Address added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error adding address: ' . $e->getMessage());
        }
    }

    public function edit(Address $address)
    {


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

        return redirect()->route('profile.edit')
            ->with('success', 'Address updated successfully');
    }

    public function destroy(Address $address)
    {

        $address->delete();

        return redirect()->route('profile.edit')
            ->with('success', 'Address deleted successfully');
    }


    public function selectAddress(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'address_id' => 'required|exists:addresses,id'
            ]);

            AddressSelected::updateOrCreate(
                ['user_id' => Auth::id()],
                ['address_id' => $request->address_id]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Address selected successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error updating address selection: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getSelectedAddress()
    {
        $selectedAddress = AddressSelected::where('user_id', Auth::id())->first();
        return response()->json([
            'selected_address_id' => $selectedAddress ? $selectedAddress->address_id : null
        ]);
    }

    public function getRegencies(Request $request)
    {
        $regencies = Regency::where('province_id', $request->province_id)
            ->orderBy('name', 'ASC')
            ->get();
        return response()->json($regencies);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where('regency_id', $request->regency_id)
            ->orderBy('name', 'ASC')
            ->get();
        return response()->json($districts);
    }

    public function getVillages(Request $request)
    {
        $villages = Village::where('district_id', $request->district_id)
            ->orderBy('name', 'ASC')
            ->get();
        return response()->json($villages);
    }
}
