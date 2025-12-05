<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Client Product routes
Route::prefix('products')->as('client.products.')->group(function () {
    Route::get('/', [ClientProductController::class, 'index'])->name('index');
    Route::get('/{id}', [ClientProductController::class, 'show'])->name('show');
});

// Client Blog routes
Route::prefix('blog')->as('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('detail');
});

// Client Cart routes
Route::prefix('cart')->as('client.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::get('/get', [CartController::class, 'getCart'])->name('get');
    Route::put('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::get('/table', [CartController::class, 'getCartTable'])->name('table');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::post('/voucher/apply', [CartController::class, 'applyVoucher'])->name('voucher.apply');
    Route::post('/voucher/remove', [CartController::class, 'removeVoucher'])->name('voucher.remove');
    Route::post('/shipping/select', [CartController::class, 'selectShipping'])->name('shipping.select');
});

// Checkout
Route::prefix('checkout')->as('client.checkout.')->group(function(){
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/place', [CheckoutController::class, 'place'])->name('place');
});

Route::get('/checkout/thankyou/{id}', [CheckoutController::class, 'thankyou'])->name('client.checkout.thankyou');
Route::get('/order/track', [CheckoutController::class, 'track'])->name('client.order.track');
Route::get('/order/history', [CheckoutController::class, 'orderList'])->name('client.order.list');
Route::post('/order/{order}/cancel', [CheckoutController::class, 'cancel'])->name('client.order.cancel');
Route::post('/order/review', [CheckoutController::class, 'storeReview'])->name('client.order.review');

// Email verification - public route (no auth required)
Route::get('/verify/{token}', [VerificationController::class, 'verify'])->name('verify');

// Auth & verification
Route::group(['middleware' => ['isAuthenticated']], function(){
    Route::get('/register', [AuthController::class,'registerView'])->name('registerView');
    Route::post('/register', [AuthController::class,'register'])->name('register');

    Route::get('/login', [AuthController::class,'loginView'])->name('loginView');
    Route::post('/login', [AuthController::class,'login'])->name('login');
});

// Logout route - cần middleware auth để đảm bảo user đã đăng nhập
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth')->name('logout');

// User dashboard (khách đăng nhập)
Route::group(['middleware' => ['onlyAuthenticated']], function(){
    Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
});


