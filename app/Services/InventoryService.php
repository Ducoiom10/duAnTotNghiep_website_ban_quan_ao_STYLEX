<?php

namespace App\Services;

use App\Models\WarehouseStock;
use App\Models\InventoryLog;
use App\Models\StockInRequest;
use App\Models\StockOutRequest;
use App\Models\TransferRequest;
use App\Models\CountRequest;
use App\Models\DefectAssessment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryService
{
    public static function confirmStockIn(int $requestId): void
    {
        DB::transaction(function () use ($requestId) {
            $request = StockInRequest::findOrFail($requestId);
            
            if ($request->status !== 'QC_PASSED') {
                throw new \Exception('Chi co the xac nhan nhap kho khi QC da pass');
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

            $request->update(['status' => 'CONFIRMED']);

            InventoryLog::create([
                'warehouse_id' => $request->warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'IN',
                'quantity_before' => $quantityBefore,
                'quantity_change' => $quantity,
                'quantity_after' => $stock->on_hand,
                'reference_type' => 'stock_in',
                'reference_id' => $requestId,
                'user_id' => Auth::id(),
                'notes' => "Nhap lo {$request->batch_number}",
            ]);
        });
    }

    public static function confirmStockOut(int $requestId): void
    {
        DB::transaction(function () use ($requestId) {
            $request = StockOutRequest::findOrFail($requestId);
            
            if ($request->status !== 'QC_PASSED') {
                throw new \Exception('Chi co the xac nhan xuat kho khi QC da pass');
            }

            $quantity = $request->qc_passed_qty;
            $stock = WarehouseStock::where('warehouse_id', $request->warehouse_id)
                ->where('variant_id', $request->variant_id)
                ->first();

            if (!$stock || $stock->available < $quantity) {
                throw new \Exception('Khong du ton kho de xuat');
            }

            $quantityBefore = $stock->on_hand;
            
            $stock->update([
                'on_hand' => $stock->on_hand - $quantity,
                'available' => $stock->available - $quantity,
            ]);

            $request->update(['status' => 'CONFIRMED']);

            InventoryLog::create([
                'warehouse_id' => $request->warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'OUT',
                'quantity_before' => $quantityBefore,
                'quantity_change' => -$quantity,
                'quantity_after' => $stock->on_hand,
                'reference_type' => 'stock_out',
                'reference_id' => $requestId,
                'user_id' => Auth::id(),
                'notes' => "Xuat lo {$request->batch_number}",
            ]);
        });
    }

    public static function confirmTransferOut(int $requestId): void
    {
        DB::transaction(function () use ($requestId) {
            $request = TransferRequest::findOrFail($requestId);
            
            if ($request->status !== 'PENDING') {
                throw new \Exception('Chi co the xac nhan xuat chuyen kho khi o trang thai PENDING');
            }

            $stock = WarehouseStock::where('warehouse_id', $request->from_warehouse_id)
                ->where('variant_id', $request->variant_id)
                ->first();

            if (!$stock || $stock->available < $request->quantity) {
                throw new \Exception('Khong du ton kho de chuyen');
            }

            $quantityBefore = $stock->on_hand;
            $stock->update([
                'on_hand' => $stock->on_hand - $request->quantity,
                'available' => $stock->available - $request->quantity,
            ]);

            $request->update(['status' => 'OUT_CONFIRMED']);

            InventoryLog::create([
                'warehouse_id' => $request->from_warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'TRANSFER',
                'quantity_before' => $quantityBefore,
                'quantity_change' => -$request->quantity,
                'quantity_after' => $stock->on_hand,
                'reference_type' => 'transfer',
                'reference_id' => $requestId,
                'user_id' => Auth::id(),
                'notes' => "Xuat tu kho {$request->from_warehouse_id}",
            ]);
        });
    }

    public static function confirmTransferIn(int $requestId): void
    {
        DB::transaction(function () use ($requestId) {
            $request = TransferRequest::findOrFail($requestId);
            
            if ($request->status !== 'OUT_CONFIRMED') {
                throw new \Exception('Chi co the xac nhan nhap chuyen kho khi da xac nhan xuat');
            }

            $toStock = WarehouseStock::firstOrCreate(
                ['warehouse_id' => $request->to_warehouse_id, 'variant_id' => $request->variant_id],
                [
                    'on_hand' => 0,
                    'available' => 0,
                    'reserved' => 0,
                    'quarantine' => 0,
                    'damaged' => 0
                ]
            );

            $quantityBefore = $toStock->on_hand;
            $toStock->update([
                'on_hand' => $toStock->on_hand + $request->quantity,
                'available' => $toStock->available + $request->quantity,
            ]);

            $request->update(['status' => 'COMPLETED']);

            InventoryLog::create([
                'warehouse_id' => $request->to_warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'TRANSFER',
                'quantity_before' => $quantityBefore,
                'quantity_change' => $request->quantity,
                'quantity_after' => $toStock->on_hand,
                'reference_type' => 'transfer',
                'reference_id' => $requestId,
                'user_id' => Auth::id(),
                'notes' => "Nhap vao kho {$request->to_warehouse_id}",
            ]);
        });
    }

    public static function createCount(int $warehouseId, int $variantId): CountRequest
    {
        $stock = WarehouseStock::firstOrCreate(
            ['warehouse_id' => $warehouseId, 'variant_id' => $variantId],
            [
                'on_hand' => 0,
                'available' => 0,
                'reserved' => 0,
                'quarantine' => 0,
                'damaged' => 0
            ]
        );

        return CountRequest::create([
            'warehouse_id' => $warehouseId,
            'variant_id' => $variantId,
            'system_qty' => $stock->on_hand,
            'status' => 'PENDING',
            'created_by' => Auth::id(),
        ]);
    }

    public static function confirmCount(int $requestId, ?int $availableQty, ?int $reservedQty, ?int $quarantineQty, ?int $damagedQty, ?string $notes = null): void
    {
        DB::transaction(function () use ($requestId, $availableQty, $reservedQty, $quarantineQty, $damagedQty, $notes) {
            $request = CountRequest::findOrFail($requestId);
            
            if ($request->status !== 'PENDING') {
                throw new \Exception('Chi co the dem kho khi o trang thai PENDING');
            }

            $availableQty = $availableQty ?? 0;
            $reservedQty = $reservedQty ?? 0;
            $quarantineQty = $quarantineQty ?? 0;
            $damagedQty = $damagedQty ?? 0;
            $physicalQty = $availableQty + $reservedQty + $quarantineQty + $damagedQty;
            $difference = $physicalQty - $request->system_qty;

            $request->update([
                'available_qty' => $availableQty,
                'reserved_qty' => $reservedQty,
                'quarantine_qty' => $quarantineQty,
                'damaged_qty' => $damagedQty,
                'physical_qty' => $physicalQty,
                'difference' => $difference,
                'status' => 'COUNTED',
                'counted_by' => Auth::id(),
                'notes' => $notes,
            ]);
        });
    }

    public static function confirmCountAdjustment(int $requestId, int $availableQty, int $reservedQty, int $quarantineQty, int $damagedQty, ?string $notes = null): void
    {
        DB::transaction(function () use ($requestId, $availableQty, $reservedQty, $quarantineQty, $damagedQty, $notes) {
            $request = CountRequest::findOrFail($requestId);
            
            if ($request->status !== 'COUNTED') {
                throw new \Exception('Chi co the xac nhan dieu chinh kho khi da dem xong');
            }

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
            $newTotal = $availableQty + $reservedQty + $quarantineQty + $damagedQty;
            
            $stock->update([
                'on_hand' => $newTotal,
                'available' => $availableQty,
                'reserved' => $reservedQty,
                'quarantine' => $quarantineQty,
                'damaged' => $damagedQty,
            ]);

            $request->update([
                'available_qty' => $availableQty,
                'reserved_qty' => $reservedQty,
                'quarantine_qty' => $quarantineQty,
                'damaged_qty' => $damagedQty,
                'physical_qty' => $newTotal,
                'status' => 'CONFIRMED',
                'confirmed_by' => Auth::id(),
                'notes' => $notes,
            ]);

            InventoryLog::create([
                'warehouse_id' => $request->warehouse_id,
                'variant_id' => $request->variant_id,
                'action' => 'ADJUSTMENT',
                'quantity_before' => $quantityBefore,
                'quantity_change' => $newTotal - $quantityBefore,
                'quantity_after' => $newTotal,
                'reference_type' => 'count',
                'reference_id' => $requestId,
                'user_id' => Auth::id(),
                'notes' => "Kiem ke: {$request->system_qty} -> {$newTotal}",
            ]);

            if ($damagedQty > 0) {
                DefectAssessment::create([
                    'warehouse_id' => $request->warehouse_id,
                    'variant_id' => $request->variant_id,
                    'quantity' => $damagedQty,
                    'defect_level' => 'MEDIUM',
                    'description' => "Phát hiện từ kiểm kê - {$notes}",
                    'status' => 'PENDING',
                    'created_by' => Auth::id(),
                ]);
            }
        });
    }
}
