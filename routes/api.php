<?php

use App\Models\Category;
use App\Models\District;
use App\Models\Product;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', function () {
    return Product::all();
});

Route::get('/categories', function () {
    return Category::all();
});

Route::get('/getProvinces', function () {
    return Province::all();
});

Route::get('/getRegencies/{province_id}', function ($province_id) {
    return Regency::where('province_id', $province_id)->get();
});

Route::get('/getDistricts/{regency_id}', function ($regency_id) {
    return District::where('regency_id', $regency_id)->get();
});

Route::get('/getVillages/{district_id}', function ($district_id) {
    return Village::where('district_id', $district_id)->get();
});