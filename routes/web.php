<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderControllerAdmin;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavouritController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getProducts'])->name('products');
    Route::get('/{product}', [ProductController::class, 'detailProducts'])->name('products.detail');
});

Route::prefix('cart')->middleware(['auth'])->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/{product}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

Route::prefix('favourit')->middleware(['auth'])->group(function () {
    Route::get('/', [FavouritController::class, 'index'])->name('favourit.index');
    Route::post('/addFavItem/{product}', [FavouritController::class, 'addFavouritItem'])->name('favourit.add');
    Route::delete('/delete/{favId}', [FavouritController::class, 'removeFavouriteItem'])->name('favourit.remove');
});

// Order routes
Route::post('/order/confirm', [OrderController::class, 'confirmOrder'])->name('order.confirm');
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/{order}', [OrderController::class, 'showOrder'])->name('order.show');
Route::put('/order/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
Route::put('/order/{order}/payment', [OrderController::class, 'storePayment'])->name('order.payment');
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    Route::put('order/{order}/update-payment-status', [OrderControllerAdmin::class, 'updatePaymentStatus'])->name('order.updatePaymentStatus');
    Route::post('orders/{order}/create-shipment', [OrderControllerAdmin::class, 'createShipment'])->name('order.createShipment');
    Route::put('/order/{order}/shipment/update', [OrderControllerAdmin::class, 'updateShipmentStatus'])->name('order.updateShipmentStatus');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Address routes
    Route::get('/address', [AddressController::class, 'index'])->name('address.index');
    Route::get('/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/{address}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/address/select', [AddressController::class, 'selectAddress'])->name('address.select');
    Route::get('/address/selected', [AddressController::class, 'getSelectedAddress'])->name('address.selected');

    // Dependent dropdown routes
    Route::get('/getRegencies', [AddressController::class, 'getRegencies'])->name('getRegencies');
    Route::get('/getDistricts', [AddressController::class, 'getDistricts'])->name('getDistricts');
    Route::get('/getVillages', [AddressController::class, 'getVillages'])->name('getVillages');
});

Route::get('/admin', [ShipmentController::class, 'index'])->middleware(['auth', 'verified', AdminMiddleware::class])->name('admin');
Route::get('/admin', [ShipmentController::class, 'index'])->middleware(['auth', 'verified', AdminMiddleware::class])->name('admin');

Route::prefix('admin/user')->middleware(['auth', 'verified', AdminMiddleware::class])->name('admin.user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('show/{user}', [UserController::class, 'show'])->name('show');
    Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/order', [OrderControllerAdmin::class, 'index'])->name('order.index');
    Route::get('/order/{order}', [OrderControllerAdmin::class, 'show'])->name('order.show');
});

Route::put('/admin/orders/update-status', [OrderStatusController::class, 'update'])->name('admin.orders.updateStatus');

Route::prefix('admin/product')->middleware(['auth', 'verified', AdminMiddleware::class])->name('admin.product.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('create', [ProductController::class, 'create'])->name('create');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('detail/{product}', [ProductController::class, 'show'])->name('detail');
    Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
    Route::put('update/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('destroy'); // Route destroy
});


require __DIR__ . '/auth.php';
