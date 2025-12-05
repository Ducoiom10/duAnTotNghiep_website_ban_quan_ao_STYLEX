<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPicking;
use App\Models\Warehouse;
use App\Services\OrderFulfillmentService;
use Illuminate\Http\Request;

class OrderFulfillmentController extends Controller
{
    private $fulfillmentService;

    public function __construct(OrderFulfillmentService $fulfillmentService)
    {
        $this->fulfillmentService = $fulfillmentService;
    }

    public function index()
    {
        $orders = Order::with('items', 'picking')
            ->whereIn('fulfillment_status', ['PENDING', 'CONFIRMED', 'PICKING', 'PACKED', 'CANCELLED'])
            ->latest()
            ->paginate(20);
        
        return view('admin.orders.fulfillment.index', compact('orders'));
    }

    public function confirm(Order $order)
    {
        try {
            $this->fulfillmentService->confirmOrder($order);
            return back()->with('success', 'Xác nhận đơn hàng thành công. Tồn kho đã được tạm giữ.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function startPicking(Order $order)
    {
        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();
        return view('admin.orders.fulfillment.picking', compact('order', 'warehouses'));
    }

    public function storePicking(Request $request, Order $order)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        try {
            $this->fulfillmentService->startPicking($order, $validated['warehouse_id']);
            return redirect()->route('admin.orders.fulfillment.index')
                ->with('success', 'Bắt đầu picking. Nhân viên kho có thể in phiếu và lấy hàng.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function completePacking(OrderPicking $picking)
    {
        try {
            $this->fulfillmentService->completePacking($picking);
            return back()->with('success', 'Hoàn tất packing. Đơn hàng sẵn sàng để vận chuyển.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function ship(Order $order)
    {
        try {
            $this->fulfillmentService->shipOrder($order);
            return back()->with('success', 'Xuất kho thành công. Đơn hàng đã hoàn tất.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
