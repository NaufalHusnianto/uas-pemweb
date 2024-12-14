<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/products', [ProductController::class, 'getProducts'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'detailProducts'])->name('products.detail');

Route::get('/cart', [CartController::class, 'index'])->middleware('auth', 'verified')->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->middleware('auth', 'verified')->name('cart.add');
Route::delete('/cart/{product}', [CartController::class, 'removeFromCart'])->middleware('auth', 'verified')->name('cart.remove');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return view('dashboard-admin');
})->middleware(['auth', 'verified', AdminMiddleware::class])->name('admin');
    
Route::prefix('admin/product')->middleware(['auth', 'verified', AdminMiddleware::class])->name('admin.product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('detail/{product}', [ProductController::class, 'show'])->name('detail');
    Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
    Route::put('update/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('destroy'); // Route destroy
});

require __DIR__.'/auth.php';
