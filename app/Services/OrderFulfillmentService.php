<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPicking;
use Illuminate\Support\Facades\DB;

class OrderFulfillmentService
{
    public function confirmOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update([
                'fulfillment_status' => 'CONFIRMED',
                'status' => 'processing'
            ]);
        });
    }

    public function startPicking(Order $order, int $warehouseId)
    {
        DB::transaction(function () use ($order, $warehouseId) {
            OrderPicking::create([
                'order_id' => $order->id,
                'warehouse_id' => $warehouseId,
                'status' => 'PICKING',
                'started_at' => now(),
            ]);
            
            $order->update(['fulfillment_status' => 'PICKING']);
        });
    }

    public function completePacking(OrderPicking $picking)
    {
        DB::transaction(function () use ($picking) {
            $picking->update([
                'status' => 'PACKED',
                'completed_at' => now(),
            ]);
            
            $picking->order->update(['fulfillment_status' => 'PACKED']);
        });
    }

    public function shipOrder(Order $order)
    {
        DB::transaction(function () use ($order) {
            $order->update([
                'fulfillment_status' => 'SHIPPED',
                'status' => 'completed'
            ]);
        });
    }
}