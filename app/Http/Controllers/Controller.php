<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;

abstract class Controller extends BaseController
{
    public function __construct()
    {
        // Share header mini-cart data from controller layer (MVC)
        [$items, $itemCount, $total] = $this->buildHeaderCartData();
        View::share('headerCartItems', $items);
        View::share('headerCartItemCount', $itemCount);
        View::share('headerCartTotal', $total);
    }

    protected function buildHeaderCartData(): array
    {
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
                $itemCount += (int) $row->quantity;
                $total += $price * (int) $row->quantity;
                $items[] = [
                    'id' => $row->id,
                    'product' => $row->product,
                    'variant' => $variant,
                    'quantity' => (int) $row->quantity,
                    'price' => $price,
                ];
            }
            // Merge guest leftovers in session
            $sessionItems = session('cart.items', []);
            foreach ($sessionItems as $it) {
                $product = Product::find($it['product_id']);
                if (!$product) { continue; }
                $variant = isset($it['variant_id']) && $it['variant_id'] ? ProductVariant::find($it['variant_id']) : null;
                $price = $variant && $variant->price ? (float) $variant->price : (float) ($product->price_sale ?? $product->price);
                $key = sha1('p' . $product->id . '-v' . (($it['variant_id'] ?? null) ?: 'null'));
                $qty = (int) ($it['quantity'] ?? 1);
                $itemCount += $qty;
                $total += $price * $qty;
                $items[] = [
                    'id' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $qty,
                    'price' => $price,
                ];
            }
        } else {
            $sessionItems = session('cart.items', []);
            foreach ($sessionItems as $it) {
                $product = Product::find($it['product_id']);
                if (!$product) { continue; }
                $variant = isset($it['variant_id']) && $it['variant_id'] ? ProductVariant::find($it['variant_id']) : null;
                $price = $variant && $variant->price ? (float) $variant->price : (float) ($product->price_sale ?? $product->price);
                $key = sha1('p' . $product->id . '-v' . (($it['variant_id'] ?? null) ?: 'null'));
                $qty = (int) ($it['quantity'] ?? 1);
                $itemCount += $qty;
                $total += $price * $qty;
                $items[] = [
                    'id' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $qty,
                    'price' => $price,
                ];
            }
        }

        return [$items, $itemCount, $total];
    }
}
