<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseStock;

class WarehouseController extends Controller
{
    public function getStocks($warehouseId)
    {
        $stocks = WarehouseStock::where('warehouse_id', $warehouseId)
            ->with('variant.product')
            ->where('on_hand', '>', 0)
            ->get()
            ->map(function ($stock) {
                return [
                    'id' => $stock->id,
                    'product' => $stock->variant->product->name,
                    'sku' => $stock->variant->sku,
                    'on_hand' => $stock->on_hand,
                    'available' => $stock->available,
                    'reserved' => $stock->reserved,
                    'quarantine' => $stock->quarantine,
                    'damaged' => $stock->damaged,
                ];
            });

        return response()->json($stocks);
    }

    public function getVariantStock($warehouseId, $variantId)
    {
        $stock = WarehouseStock::where('warehouse_id', $warehouseId)
            ->where('variant_id', $variantId)
            ->first();

        return response()->json([
            'on_hand' => $stock?->on_hand ?? 0,
            'available' => $stock?->available ?? 0,
            'reserved' => $stock?->reserved ?? 0,
            'quarantine' => $stock?->quarantine ?? 0,
            'damaged' => $stock?->damaged ?? 0,
        ]);
    }
}
