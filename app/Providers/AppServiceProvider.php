<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Ensure header mini-cart data is always available
        View::composer('client.partials.cart', function ($view) {
            $items = [];
            $itemCount = 0;
            $total = 0;

            if (Auth::check()) {
                $rows = Cart::with(['product', 'variant.size', 'variant.color', 'variant.texture'])
                    ->where('user_id', Auth::id())
                    ->get();
                foreach ($rows as $row) {
                    $variant = $row->variant;
                    $price = $variant && $variant->price ? (float) $variant->price : (float) ($row->product->price_sale ?? $row->product->price);
                    $qty = (int) $row->quantity;
                    $itemCount += $qty; $total += $price * $qty;
                    $items[] = [
                        'id' => $row->id,
                        'product' => $row->product,
                        'variant' => $variant,
                        'quantity' => $qty,
                        'price' => $price,
                    ];
                }
            }

            // Merge guest session items for both guest and just-logged-in users
            $sessionItems = session('cart.items', []);
            if (!empty($sessionItems)) {
                foreach ($sessionItems as $it) {
                    $product = Product::find($it['product_id']);
                    if (!$product) { continue; }
                    $variant = isset($it['variant_id']) && $it['variant_id'] ? ProductVariant::find($it['variant_id']) : null;
                    $price = $variant && $variant->price ? (float) $variant->price : (float) ($product->price_sale ?? $product->price);
                    $qty = (int) ($it['quantity'] ?? 1);
                    $itemCount += $qty; $total += $price * $qty;
                    $items[] = [
                        'id' => sha1('p' . $product->id . '-v' . (($it['variant_id'] ?? null) ?: 'null')),
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $qty,
                        'price' => $price,
                    ];
                }
            }

            $view->with([
                'headerCartItems' => $items,
                'headerCartItemCount' => $itemCount,
                'headerCartTotal' => $total,
            ]);
        });
    }
}
