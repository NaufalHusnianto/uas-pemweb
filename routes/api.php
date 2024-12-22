<?php

use App\Models\Category;
use App\Models\Product;
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
