<?php

namespace App\Services;

use App\Models\ProductBatch;

class PickingService
{
    const FIFO = 'FIFO';
    const LIFO = 'LIFO';

    public function pickBatches(int $variantId, int $quantity, int $warehouseId, string $method = self::FIFO): array
    {
        return match($method) {
            self::FIFO => $this->fifo($variantId, $quantity, $warehouseId),
            self::LIFO => $this->lifo($variantId, $quantity, $warehouseId),
            default => [],
        };
    }

    private function fifo(int $variantId, int $quantity, int $warehouseId): array
    {
        $batches = ProductBatch::where('variant_id', $variantId)
            ->with('movements')
            ->orderBy('created_at', 'asc')
            ->get();

        return $this->allocateBatches($batches, $quantity, $warehouseId);
    }

    private function lifo(int $variantId, int $quantity, int $warehouseId): array
    {
        $batches = ProductBatch::where('variant_id', $variantId)
            ->with('movements')
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->allocateBatches($batches, $quantity, $warehouseId);
    }

    private function allocateBatches($batches, int $quantity, int $warehouseId): array
    {
        $allocation = [];
        $remainingQty = $quantity;

        foreach ($batches as $batch) {
            if ($remainingQty <= 0) break;

            $warehouseStock = $batch->getWarehouseStock($warehouseId);
            
            // Debug log
            error_log("Batch {$batch->id}: warehouse stock = {$warehouseStock}");
            
            if ($warehouseStock <= 0) continue;

            $qtyToAllocate = min($remainingQty, $warehouseStock);
            $allocation[] = [
                'batch_id' => $batch->id,
                'batch_number' => $batch->batch_number,
                'quantity' => $qtyToAllocate,
            ];

            $remainingQty -= $qtyToAllocate;
        }

        return $allocation;
    }
}
