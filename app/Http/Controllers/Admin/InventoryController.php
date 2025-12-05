<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ProductVariant, Warehouse, Product, Setting, Notification, User, InventoryLog, WarehouseStock, CountRequest, DefectAssessment};
use App\Services\InventoryService;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

class InventoryController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.inventory.dashboard');
    }

    public function dashboard()
    {
        $lowStockThreshold = (int) Setting::where('key', 'wms_low_stock_threshold')->value('value') ?? 10;

        $onHandStock = 0;
        $availableStock = 0;
        $reservedStock = 0;
        $quarantineStock = 0;
        $damagedStock = 0;

        if (DB::getSchemaBuilder()->hasTable('warehouse_stocks')) {
            $onHandStock = DB::table('warehouse_stocks')->sum('on_hand') ?? 0;
            $availableStock = DB::table('warehouse_stocks')->sum('available') ?? 0;
            $reservedStock = DB::table('warehouse_stocks')->sum('reserved') ?? 0;
            $quarantineStock = DB::table('warehouse_stocks')->sum('quarantine') ?? 0;
            $damagedStock = DB::table('warehouse_stocks')->sum('damaged') ?? 0;
        }

        $lowStockVariants = collect();
        $topSellingVariants = collect();
        $stockByWarehouse = collect();
        $pendingOutTransfers = collect();
        $pendingCountRequests = collect();
        $pendingDefectAssessments = collect();

        if (DB::getSchemaBuilder()->hasTable('warehouse_stocks')) {
            $lowStockVariants = ProductVariant::select('product_variants.id', 'sku')
                ->with('product:id,name')
                ->get()
                ->filter(function ($variant) use ($lowStockThreshold) {
                    $stock = StockService::getVariantTotalStock($variant->id);
                    return $stock > 0 && $stock <= $lowStockThreshold;
                })
                ->sortBy(function ($variant) {
                    return StockService::getVariantTotalStock($variant->id);
                })
                ->map(function ($variant) {
                    $variant->total_on_hand_stock = StockService::getVariantTotalStock($variant->id);
                    return $variant;
                });

            $topSellingVariants = ProductVariant::join('order_items', 'product_variants.id', '=', 'order_items.variant_id')
                ->with('product:id,name')
                ->select('product_variants.id', 'product_variants.sku', 'product_variants.product_id')
                ->selectRaw('SUM(order_items.quantity) as total_sold')
                ->whereDate('order_items.created_at', '>=', now()->subDays(7))
                ->groupBy('product_variants.id', 'product_variants.sku', 'product_variants.product_id')
                ->orderBy('total_sold', 'desc')
                ->limit(5)
                ->get();

            $stockByWarehouse = Warehouse::where('operational_status', 'ACTIVE')
                ->get()
                ->map(function ($warehouse) {
                    $warehouse->on_hand_qty = DB::table('warehouse_stocks')
                        ->where('warehouse_id', $warehouse->id)
                        ->sum('on_hand') ?? 0;
                    $warehouse->available_qty = DB::table('warehouse_stocks')
                        ->where('warehouse_id', $warehouse->id)
                        ->sum('available') ?? 0;
                    $warehouse->reserved_qty = DB::table('warehouse_stocks')
                        ->where('warehouse_id', $warehouse->id)
                        ->sum('reserved') ?? 0;
                    $warehouse->quarantine_qty = DB::table('warehouse_stocks')
                        ->where('warehouse_id', $warehouse->id)
                        ->sum('quarantine') ?? 0;
                    $warehouse->damaged_qty = DB::table('warehouse_stocks')
                        ->where('warehouse_id', $warehouse->id)
                        ->sum('damaged') ?? 0;
                    return $warehouse;
                });

            $pendingOutTransfers = collect();
            if (Schema::hasColumn('warehouse_stocks', 'status')) {
                $pendingOutTransfers = WarehouseStock::where('status', 'PENDING')
                    ->where('reserved', '>', 0)
                    ->with(['warehouse', 'variant'])
                    ->get();
            }

            $pendingCountRequests = CountRequest::where('status', 'PENDING')
                ->with(['warehouse', 'variant.product', 'createdBy'])
                ->latest()
                ->limit(5)
                ->get();

            $pendingDefectAssessments = DefectAssessment::where('status', 'PENDING')
                ->with(['warehouse', 'variant.product', 'createdBy'])
                ->latest()
                ->limit(5)
                ->get();
        }

        $unreadNotifications = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.inventory.dashboard', compact(
            'onHandStock', 'availableStock', 'reservedStock', 'quarantineStock', 'damagedStock',
            'lowStockVariants', 'lowStockThreshold',
            'topSellingVariants', 'stockByWarehouse', 'pendingOutTransfers',
            'pendingCountRequests', 'pendingDefectAssessments', 'unreadNotifications'
        ));
    }

    public function currentStock()
    {
        $search = request('search');
        $warehouseId = request('warehouse_id');
        // Lọc chỉ hiển thị sản phẩm tồn kho thấp nếu được yêu cầu
        $showLowStockOnly = request('low_stock_only', false);
        // Ngưỡng tồn kho thấp từ cài đặt
        $lowStockThreshold = (int) Setting::where('key', 'wms_low_stock_threshold')->value('value') ?? 10;

        $query = ProductVariant::with('product:id,name,thumbnail');

        if ($search) {
            $searchTerm = '%' . $search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('sku', 'like', $searchTerm)
                    ->orWhereHas('product', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', $searchTerm);
                    });
            });
        }

        $variantsWithStock = $query->paginate(20)->withQueryString();

        $variantsWithStock->getCollection()->transform(function ($variant) use ($warehouseId, $lowStockThreshold) {
            if ($warehouseId) {
                // Lấy chi tiết tồn kho cho biến thể trong kho cụ thể
                $details = StockService::getVariantStockDetails($variant->id, $warehouseId);
                $variant->stock_details = $details;
                // Thiết lập các thuộc tính tồn kho tổng hợp
                $variant->total_on_hand_stock = $details['on_hand'];
                $variant->available_stock = $details['available'];
                $variant->reserved_stock = $details['reserved'];
                $variant->quarantine_stock = $details['quarantine'];
                $variant->damaged_stock = $details['damaged'];
            } else {
                $variant->total_on_hand_stock = StockService::getVariantTotalStock($variant->id);
                $variant->available_stock = StockService::getVariantAvailableStock($variant->id);
                $variant->reserved_stock = 0;
                $variant->quarantine_stock = 0;
                $variant->damaged_stock = 0;
            }
            $variant->is_low_stock = $variant->total_on_hand_stock <= $lowStockThreshold;
            return $variant;
        });

        // Lọc chỉ hiển thị sản phẩm tồn kho thấp nếu được yêu cầu
        if ($showLowStockOnly) {
            $filteredItems = $variantsWithStock->getCollection()->filter(fn($v) => $v->is_low_stock);
            $variantsWithStock->setCollection($filteredItems);
        }

        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();
        $lowStockCount = $variantsWithStock->getCollection()->filter(fn($v) => $v->is_low_stock)->count();
        $totalStockValue = $variantsWithStock->getCollection()->sum(function ($variant) {
            return $variant->total_on_hand_stock * $variant->price;
        });

        return view('admin.inventory.current-stock', compact(
            'variantsWithStock', 'warehouses', 'lowStockCount', 'lowStockThreshold',
            'totalStockValue', 'showLowStockOnly'
        ));
    }

    public function showLogs()
    {
        $warehouseId = request('warehouse_id');
        $action = request('action');

        $query = InventoryLog::with(['warehouse', 'variant.product', 'user'])
            ->latest('created_at');

        if ($warehouseId) {
            $query->where('warehouse_id', $warehouseId);
        }

        if ($action) {
            $query->where('action', $action);
        }

        $logs = $query->paginate(20)->withQueryString();
        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();

        return view('admin.inventory.log-history', compact('logs', 'warehouses'));
    }

    public function reports()
    {
        $timeRange = request('time_range', '30');

        $inventoryValueByWarehouse = Warehouse::where('operational_status', 'ACTIVE')
            ->get()
            ->map(function ($warehouse) {
                $warehouse->total_quantity = DB::table('warehouse_stocks')
                    ->where('warehouse_id', $warehouse->id)
                    ->sum('on_hand') ?? 0;
                $warehouse->total_value = DB::table('warehouse_stocks')
                    ->where('warehouse_stocks.warehouse_id', $warehouse->id)
                    ->sum('on_hand');
                return $warehouse;
            });

        $fastMovingVariants = ProductVariant::join('order_items', 'product_variants.id', '=', 'order_items.variant_id')
            ->with('product:id,name')
            ->select('product_variants.id', 'product_variants.sku', 'product_variants.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->whereDate('order_items.created_at', '>=', now()->subDays($timeRange))
            ->groupBy('product_variants.id', 'product_variants.sku', 'product_variants.product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();

        return view('admin.inventory.reports', compact(
            'inventoryValueByWarehouse', 'fastMovingVariants', 'warehouses', 'timeRange'
        ));
    }

    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.inventory.settings', compact('settings'));
    }

    public function updateSettings()
    {
        try {
            $data = request()->all();
            foreach ($data as $key => $value) {
                if ($key !== '_token') {
                    Setting::updateOrCreate(['key' => $key], ['value' => $value]);
                }
            }

            return redirect()->route('admin.inventory.settings')
                ->with('success', 'Cập nhật cài đặt thành công!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Lỗi khi lưu cài đặt: ' . $e->getMessage());
        }
    }
}
