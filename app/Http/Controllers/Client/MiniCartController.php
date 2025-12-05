<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class MiniCartController extends Controller
{
    public function show()
    {
        // Use base controller helper to build mini-cart data
        [$items, $itemCount, $total] = $this->buildHeaderCartData();

        return view('client.partials.cart', [
            'headerCartItems' => $items,
            'headerCartItemCount' => $itemCount,
            'headerCartTotal' => $total,
        ]);
    }
}
