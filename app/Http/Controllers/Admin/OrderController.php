<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Base query dùng chung cho hai bảng (đơn đang giao & đơn đã hoàn thành/hủy)
        $baseQuery = Order::with(['items.product']);

        // 🔍 Tìm kiếm theo tên, email hoặc mã đơn
        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // 📦 Lọc theo trạng thái đơn hàng (áp dụng cho cả 2 bảng)
        if ($request->filled('status')) {
            $baseQuery->where('status', $request->status);
        }
        // Lọc theo tên khách hàng
        if ($request->filled('full_name')) {
            $baseQuery->where('full_name', 'like', '%' . $request->full_name . '%');
        }

        // Lọc theo mã đơn
        if ($request->filled('code')) {
            $baseQuery->where('code', 'like', '%' . $request->code . '%');
        }

        // 💳 Lọc theo trạng thái thanh toán
        if ($request->filled('payment_status')) {
            $baseQuery->where('payment_status', $request->payment_status);
        }

        // 📅 Lọc theo ngày tạo
        if ($request->filled('date_from')) {
            $baseQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $baseQuery->whereDate('created_at', '<=', $request->date_to);
        }

        // 📊 Thống kê theo trạng thái
        $orderStats = Order::selectRaw("
            COUNT(id) as total_orders,
            SUM(status = 'pending')     as pending_orders,
            SUM(status = 'processing')  as processing_orders,
            SUM(status = 'shipping')    as shipping_orders,
            SUM(status = 'completed')   as completed_orders,
            SUM(status = 'cancelled')   as cancelled_orders,
            SUM(status = 'returned')    as returned_orders
        ")->first();

        // Phân trang linh hoạt
        $perPage = (int) $request->input('per_page', 10);
        $allowedPerPage = [10, 20, 50, 100];
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        // Hai nhóm trạng thái
        $activeStatuses   = ['pending', 'processing', 'shipping'];
        $archivedStatuses = ['completed', 'delivered', 'cancelled', 'returned'];

        // Mỗi bảng có paginator riêng và page parameter riêng
        $activeOrders = (clone $baseQuery)
            ->whereIn('status', $activeStatuses)
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'active_page')
            ->appends($request->except('active_page'));

        $archivedOrders = (clone $baseQuery)
            ->whereIn('status', $archivedStatuses)
            ->orderByDesc('created_at')
            ->paginate($perPage, ['*'], 'archived_page')
            ->appends($request->except('archived_page'));

        return view('admin.orders.index', compact('activeOrders', 'archivedOrders', 'orderStats'));
    }

    // ✅ API đổi trạng thái AJAX
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return response()->json(['message' => 'Cập nhật trạng thái đơn hàng thành công!']);
    }
}
