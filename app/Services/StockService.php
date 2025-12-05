<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class StockService
{
    public static function getVariantStockByWarehouse(int $variantId, int $warehouseId): int
    {
        $stock = DB::table('warehouse_stocks')
            ->where('warehouse_id', $warehouseId)
            ->where('variant_id', $variantId)
            ->first();

        return $stock ? (int)$stock->available : 0;
    }

    public static function getVariantTotalStock(int $variantId): int
    {
        return (int)(DB::table('warehouse_stocks')
            ->where('variant_id', $variantId)
            ->sum('on_hand') ?? 0);
    }

    public static function getVariantAvailableStock(int $variantId): int
    {
        return (int)(DB::table('warehouse_stocks')
            ->where('variant_id', $variantId)
            ->sum('available') ?? 0);
    }

    public static function getVariantStockDetails(int $variantId, int $warehouseId): array
    {
        $stock = DB::table('warehouse_stocks')
            ->where('warehouse_id', $warehouseId)
            ->where('variant_id', $variantId)
            ->first();

        if (!$stock) {
            return [
                'on_hand' => 0,
                'available' => 0,
                'reserved' => 0,
                'quarantine' => 0,
                'damaged' => 0,
            ];
        }

        return [
            'on_hand' => (int)$stock->on_hand,
            'available' => (int)$stock->available,
            'reserved' => (int)$stock->reserved,
            'quarantine' => (int)$stock->quarantine,
            'damaged' => (int)$stock->damaged,
        ];
    }

    public static function getWarehouseTotalStock(int $warehouseId): int
    {
        return (int)(DB::table('warehouse_stocks')
            ->where('warehouse_id', $warehouseId)
            ->sum('on_hand') ?? 0);
    }

    public static function getWarehouseAvailableStock(int $warehouseId): int
    {
        return (int)(DB::table('warehouse_stocks')
            ->where('warehouse_id', $warehouseId)
            ->sum('available') ?? 0);
    }
}
