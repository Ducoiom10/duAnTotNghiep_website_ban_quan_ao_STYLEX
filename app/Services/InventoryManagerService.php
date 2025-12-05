<?php

namespace App\Services;

use App\Models\WarehouseStock;
use App\Models\StockInRequest;
use App\Models\StockOutRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryManagerService
{
    public function confirmStockIn(int $requestId): void
    {
        DB::transaction(function () use ($requestId) {
            $request = StockInRequest::findOrFail($requestId);
            
            if ($request->status !== 'QC_PASSED') {
                throw new \Exception('Chỉ có thể xác nhận nhập kho khi QC đã pass');
            }

            $quantity = $request->qc_passed_qty;
            $stock = WarehouseStock::firstOrCreate(
                ['warehouse_id' => $request->warehouse_id, 'variant_id' => $request->variant_id],
                [
                    'on_hand' => 0,
                    'available' => 0,
                    'reserved' => 0,
                    'quarantine' => 0,
                    'damaged' => 0
                ]
            );

            $quantityBefore = $stock->on_hand;
            $stock->update([
                'on_hand' => $stock->on_hand + $quantity,
                'available' => $stock->available + $quantity,
            ]);

            $this->logInventory([
                'warehouse_id' => $request->warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'IN',
                'quantity_before' => $quantityBefore,
                'quantity_change' => $quantity,
                'quantity_after' => $stock->on_hand,
                'reference_type' => 'stock_in',
                'reference_id' => $requestId,
                'notes' => "Nhập lô {$request->batch_number}",
            ]);
        });
    }

    public function confirmStockOut(int $requestId): void
    {
        DB::transaction(function () use ($requestId) {
            $request = StockOutRequest::findOrFail($requestId);
            
            if ($request->status !== 'QC_PASSED') {
                throw new \Exception('Chỉ có thể xác nhận xuất kho khi QC đã pass');
            }

            $quantity = $request->qc_passed_qty;
            $stock = WarehouseStock::where('warehouse_id', $request->warehouse_id)
                ->where('variant_id', $request->variant_id)
                ->first();

            if (!$stock || $stock->available < $quantity) {
                throw new \Exception('Không đủ tồn kho để xuất');
            }

            $quantityBefore = $stock->on_hand;
            $stock->update([
                'on_hand' => $stock->on_hand - $quantity,
                'available' => $stock->available - $quantity,
            ]);

            $this->logInventory([
                'warehouse_id' => $request->warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'OUT',
                'quantity_before' => $quantityBefore,
                'quantity_change' => -$quantity,
                'quantity_after' => $stock->on_hand,
                'reference_type' => 'stock_out',
                'reference_id' => $requestId,
                'notes' => "Xuất lô {$request->batch_number}",
            ]);
        });
    }

    public function stockIn(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $variantId = $data['variant_id'];
            $warehouseId = $data['warehouse_id'];
            $quantity = $data['quantity'];

            if ($quantity <= 0) throw new \Exception('Số lượng phải > 0');
            if (empty($data['batch_number'])) throw new \Exception('Batch number bắt buộc');

            $batch = DB::table('product_batches')->insertGetId([
                'variant_id' => $variantId,
                'batch_number' => $data['batch_number'],
                'status' => 'QUARANTINE',
                'cost_price' => $data['cost_price'] ?? 0,
                'received_date' => now()->toDateString(),
                'expiry_date' => $data['expiry_date'] ?? now()->addMonths(12)->toDateString(),
                'notes' => $data['notes'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('batch_movements')->insert([
                'batch_id' => $batch,
                'warehouse_id' => $warehouseId,
                'type' => 'IN',
                'status' => 'COMPLETED',
                'quantity' => $quantity,
                'user_id' => Auth::id() ?? 1,
                'reference_type' => 'PURCHASE',
                'reference_id' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('warehouse_stocks')->updateOrInsert(
                ['warehouse_id' => $warehouseId, 'variant_id' => $variantId],
                [
                    'on_hand' => DB::raw('COALESCE(on_hand, 0) + ' . $quantity),
                    'quarantine' => DB::raw('COALESCE(quarantine, 0) + ' . $quantity),
                    'updated_at' => now(),
                ]
            );

            $this->logInventory([
                'warehouse_id' => $warehouseId,
                'variant_id' => $variantId,
                'action' => 'IN',
                'quantity_change' => $quantity,
                'notes' => 'Nhập kho',
            ]);

            return ['batch_id' => $batch, 'quantity' => $quantity];
        });
    }

    public function approveQuality(int $batchId): void
    {
        DB::transaction(function () use ($batchId) {
            $batch = DB::table('product_batches')->find($batchId);
            if (!$batch) throw new \Exception('Batch không tồn tại');

            $inMovement = DB::table('batch_movements')
                ->where('batch_id', $batchId)
                ->where('type', 'IN')
                ->first();

            if (!$inMovement) throw new \Exception('Batch phải có IN movement');

            $quantity = $inMovement->quantity;

            DB::table('product_batches')
                ->where('id', $batchId)
                ->update(['status' => 'AVAILABLE', 'updated_at' => now()]);

            DB::table('warehouse_stocks')
                ->where('variant_id', $batch->variant_id)
                ->where('warehouse_id', $inMovement->warehouse_id)
                ->update([
                    'quarantine' => DB::raw('quarantine - ' . $quantity),
                    'available' => DB::raw('available + ' . $quantity),
                    'updated_at' => now(),
                ]);

            $this->logInventory([
                'warehouse_id' => $inMovement->warehouse_id,
                'variant_id' => $batch->variant_id,
                'action' => 'QUALITY_CHECK',
                'quantity_change' => $quantity,
                'notes' => 'Phê duyệt QC',
            ]);
        });
    }

    public function stockOut(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $variantId = $data['variant_id'];
            $warehouseId = $data['warehouse_id'];
            $quantity = $data['quantity'];

            if ($quantity <= 0) throw new \Exception('Số lượng phải > 0');

            $stock = DB::table('warehouse_stocks')
                ->where('warehouse_id', $warehouseId)
                ->where('variant_id', $variantId)
                ->first();

            if (!$stock || $stock->available < $quantity) {
                throw new \Exception('Không đủ tồn kho');
            }

            $batches = DB::table('product_batches')
                ->where('variant_id', $variantId)
                ->where('status', 'AVAILABLE')
                ->where('expiry_date', '>', now()->toDateString())
                ->orderBy('received_date', 'asc')
                ->get();

            $allocation = [];
            $remaining = $quantity;
            foreach ($batches as $batch) {
                $inMovement = DB::table('batch_movements')
                    ->where('batch_id', $batch->id)
                    ->where('warehouse_id', $warehouseId)
                    ->where('type', 'IN')
                    ->first();

                if ($inMovement && $inMovement->quantity > 0) {
                    $allocate = min($inMovement->quantity, $remaining);
                    $allocation[] = ['batch_id' => $batch->id, 'quantity' => $allocate];
                    $remaining -= $allocate;
                    if ($remaining <= 0) break;
                }
            }

            if ($remaining > 0) throw new \Exception('Không thể phân bổ đủ batch');

            foreach ($allocation as $item) {
                DB::table('batch_movements')->insert([
                    'batch_id' => $item['batch_id'],
                    'warehouse_id' => $warehouseId,
                    'type' => 'OUT',
                    'status' => 'PENDING',
                    'quantity' => -$item['quantity'],
                    'user_id' => Auth::id() ?? 1,
                    'reference_type' => 'ORDER',
                    'reference_id' => null,
                    'notes' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('warehouse_stocks')
                ->where('warehouse_id', $warehouseId)
                ->where('variant_id', $variantId)
                ->update([
                    'available' => DB::raw('available - ' . $quantity),
                    'reserved' => DB::raw('reserved + ' . $quantity),
                    'updated_at' => now(),
                ]);

            $this->logInventory([
                'warehouse_id' => $warehouseId,
                'variant_id' => $variantId,
                'action' => 'OUT',
                'quantity_change' => -$quantity,
                'notes' => 'Xuất kho',
            ]);

            return $allocation;
        });
    }

    public function completeDelivery(string $referenceId): void
    {
        DB::transaction(function () use ($referenceId) {
            $movements = DB::table('batch_movements')
                ->where('reference_id', $referenceId)
                ->where('type', 'OUT')
                ->get();

            if ($movements->isEmpty()) throw new \Exception('Không tìm thấy xuất kho');

            $totalQuantity = 0;
            $warehouseId = null;
            foreach ($movements as $movement) {
                DB::table('batch_movements')
                    ->where('id', $movement->id)
                    ->update(['status' => 'COMPLETED', 'updated_at' => now()]);
                $totalQuantity += abs($movement->quantity);
                $warehouseId = $movement->warehouse_id;
            }

            DB::table('warehouse_stocks')
                ->where('warehouse_id', $warehouseId)
                ->update([
                    'reserved' => DB::raw('reserved - ' . $totalQuantity),
                    'updated_at' => now(),
                ]);

            $this->logInventory([
                'warehouse_id' => $warehouseId,
                'action' => 'DELIVERY',
                'quantity_change' => -$totalQuantity,
                'notes' => 'Giao hàng',
            ]);
        });
    }

    public function cancelOrder(string $referenceId): void
    {
        DB::transaction(function () use ($referenceId) {
            $movements = DB::table('batch_movements')
                ->where('reference_id', $referenceId)
                ->where('type', 'OUT')
                ->where('status', 'PENDING')
                ->get();

            if ($movements->isEmpty()) return;

            $first = $movements->first();
            $totalQuantity = 0;

            foreach ($movements as $movement) {
                DB::table('batch_movements')
                    ->where('id', $movement->id)
                    ->update(['status' => 'CANCELLED', 'updated_at' => now()]);
                $totalQuantity += abs($movement->quantity);
            }

            DB::table('warehouse_stocks')
                ->where('warehouse_id', $first->warehouse_id)
                ->update([
                    'available' => DB::raw('available + ' . $totalQuantity),
                    'reserved' => DB::raw('reserved - ' . $totalQuantity),
                    'updated_at' => now(),
                ]);

            $this->logInventory([
                'warehouse_id' => $first->warehouse_id,
                'action' => 'CANCEL',
                'quantity_change' => $totalQuantity,
                'notes' => 'Hủy đơn',
            ]);
        });
    }

    public function returnOrderItem(array $data): void
    {
        DB::transaction(function () use ($data) {
            $variantId = $data['variant_id'];
            $warehouseId = $data['warehouse_id'];
            $quantity = $data['quantity'];
            $referenceId = $data['reference_id'];

            if ($quantity <= 0) throw new \Exception('Số lượng phải > 0');

            $stock = DB::table('warehouse_stocks')
                ->where('warehouse_id', $warehouseId)
                ->where('variant_id', $variantId)
                ->first();

            if (!$stock || $stock->reserved < $quantity) {
                throw new \Exception('Số lượng hoàn trả vượt quá reserved');
            }

            $returnBatch = DB::table('product_batches')->insertGetId([
                'variant_id' => $variantId,
                'batch_number' => 'RETURN-' . $referenceId . '-' . now()->timestamp,
                'status' => 'AVAILABLE',
                'cost_price' => 0,
                'received_date' => now()->toDateString(),
                'expiry_date' => now()->addMonths(12)->toDateString(),
                'notes' => 'Hoàn trả',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('batch_movements')->insert([
                'batch_id' => $returnBatch,
                'warehouse_id' => $warehouseId,
                'type' => 'IN',
                'status' => 'COMPLETED',
                'quantity' => $quantity,
                'user_id' => Auth::id() ?? 1,
                'reference_type' => 'RETURN',
                'reference_id' => $referenceId,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('warehouse_stocks')
                ->where('warehouse_id', $warehouseId)
                ->where('variant_id', $variantId)
                ->update([
                    'on_hand' => DB::raw('on_hand + ' . $quantity),
                    'available' => DB::raw('available + ' . $quantity),
                    'reserved' => DB::raw('reserved - ' . $quantity),
                    'updated_at' => now(),
                ]);

            $this->logInventory([
                'warehouse_id' => $warehouseId,
                'variant_id' => $variantId,
                'action' => 'RETURN',
                'quantity_change' => $quantity,
                'notes' => 'Hoàn trả',
            ]);
        });
    }

    public function transferStock(array $data): void
    {
        DB::transaction(function () use ($data) {
            $variantId = $data['variant_id'];
            $fromWarehouse = $data['from_warehouse_id'];
            $toWarehouse = $data['to_warehouse_id'];
            $quantity = $data['quantity'];

            if ($quantity <= 0) throw new \Exception('Số lượng phải > 0');

            $toWarehouseExists = DB::table('warehouses')
                ->where('id', $toWarehouse)
                ->where('operational_status', 'ACTIVE')
                ->exists();

            if (!$toWarehouseExists) throw new \Exception('Kho đích không tồn tại');

            $stock = DB::table('warehouse_stocks')
                ->where('warehouse_id', $fromWarehouse)
                ->where('variant_id', $variantId)
                ->first();

            if (!$stock || $stock->available < $quantity) {
                throw new \Exception('Không đủ tồn kho');
            }

            $transferBatch = DB::table('product_batches')->insertGetId([
                'variant_id' => $variantId,
                'batch_number' => 'TRANSFER-W' . $fromWarehouse . '-W' . $toWarehouse . '-' . now()->timestamp,
                'status' => 'AVAILABLE',
                'cost_price' => 0,
                'received_date' => now()->toDateString(),
                'expiry_date' => now()->addMonths(12)->toDateString(),
                'notes' => 'Chuyển kho',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('batch_movements')->insert([
                'batch_id' => $transferBatch,
                'warehouse_id' => $fromWarehouse,
                'type' => 'TRANSFER',
                'status' => 'COMPLETED',
                'quantity' => -$quantity,
                'user_id' => Auth::id() ?? 1,
                'reference_type' => 'TRANSFER',
                'reference_id' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('batch_movements')->insert([
                'batch_id' => $transferBatch,
                'warehouse_id' => $toWarehouse,
                'type' => 'TRANSFER',
                'status' => 'COMPLETED',
                'quantity' => $quantity,
                'user_id' => Auth::id() ?? 1,
                'reference_type' => 'TRANSFER',
                'reference_id' => null,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('warehouse_stocks')
                ->where('warehouse_id', $fromWarehouse)
                ->where('variant_id', $variantId)
                ->update([
                    'available' => DB::raw('available - ' . $quantity),
                    'updated_at' => now(),
                ]);

            DB::table('warehouse_stocks')
                ->where('warehouse_id', $toWarehouse)
                ->where('variant_id', $variantId)
                ->updateOrInsert(
                    ['warehouse_id' => $toWarehouse, 'variant_id' => $variantId],
                    [
                        'available' => DB::raw('COALESCE(available, 0) + ' . $quantity),
                        'updated_at' => now(),
                    ]
                );

            $this->logInventory([
                'warehouse_id' => $fromWarehouse,
                'variant_id' => $variantId,
                'action' => 'TRANSFER',
                'quantity_change' => -$quantity,
                'notes' => 'Chuyển kho',
            ]);
        });
    }

    private function logInventory(array $data): void
    {
        DB::table('inventory_logs')->insert([
            'warehouse_id' => $data['warehouse_id'] ?? null,
            'variant_id' => $data['variant_id'] ?? null,
            'action' => $data['action'],
            'quantity_before' => $data['quantity_before'] ?? null,
            'quantity_change' => $data['quantity_change'] ?? 0,
            'quantity_after' => $data['quantity_after'] ?? null,
            'reference_type' => $data['reference_type'] ?? null,
            'reference_id' => $data['reference_id'] ?? null,
            'user_id' => Auth::id() ?? 1,
            'notes' => $data['notes'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
