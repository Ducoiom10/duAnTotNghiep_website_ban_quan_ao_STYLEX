<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\WarehouseController;


Route::get('/products/filter', [ProductController::class, 'index'])->name('api.products.filter');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('api.products.show');

// Review routes
Route::post('/reviews', [ReviewController::class, 'store'])->name('api.reviews.store');
Route::get('/products/{productId}/reviews', [ReviewController::class, 'getProductReviews'])->name('api.reviews.product');



Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/warehouses/{warehouseId}/stocks', [WarehouseController::class, 'getStocks']);
    Route::get('/warehouses/{warehouseId}/variants/{variantId}/stock', [WarehouseController::class, 'getVariantStock']);
});
