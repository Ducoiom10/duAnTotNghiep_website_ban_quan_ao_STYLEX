<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, OrderItem, User, Product, InventoryLog, Warehouse, WarehouseStock, EmployeeSalary};
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        $startDate = request('start_date') ? \Carbon\Carbon::parse(request('start_date')) : now()->subDays(30);
        $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : now();

        $salesData = $this->getSalesReport($startDate, $endDate);
        $inventoryData = $this->getInventoryReport();
        $userStats = $this->getUserStats();
        $orderStats = $this->getOrderStats($startDate, $endDate);
        $profitData = $this->getProfitReport($startDate, $endDate);
        $salaryData = $this->getSalaryReport($startDate, $endDate);

        return view('admin.reports.admin-report', compact('salesData', 'inventoryData', 'userStats', 'orderStats', 'profitData', 'salaryData', 'startDate', 'endDate'));
    }

    private function getSalesReport($startDate, $endDate)
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        
        return [
            'total_revenue' => $orders->sum('total'),
            'total_orders' => $orders->count(),
            'avg_order_value' => $orders->count() > 0 ? $orders->sum('total') / $orders->count() : 0,
            'top_products' => OrderItem::whereBetween('order_items.created_at', [$startDate, $endDate])
                ->with('variant.product')
                ->select('variant_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as revenue'))
                ->groupBy('variant_id')
                ->orderBy('revenue', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    private function getInventoryReport()
    {
        return [
            'total_stock_value' => WarehouseStock::sum(DB::raw('on_hand_stock * cost_price')),
            'total_quantity' => WarehouseStock::sum('on_hand_stock'),
            'warehouse_distribution' => Warehouse::where('operational_status', 'ACTIVE')
                ->withSum('warehouseStocks as total_qty', 'on_hand_stock')
                ->withSum('warehouseStocks as total_value', DB::raw('on_hand_stock * cost_price'))
                ->get(),
            'low_stock_count' => WarehouseStock::where('on_hand_stock', '<=', 10)->count(),
        ];
    }

    private function getUserStats()
    {
        return [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'active_users' => User::where('email_verified_at', '!=', null)->count(),
        ];
    }

    private function getOrderStats($startDate, $endDate)
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        
        return [
            'pending' => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];
    }

    private function getProfitReport($startDate, $endDate)
    {
        // 1. DOANH THU
        $totalRevenue = Order::whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('total');
        
        $shippingRevenue = Order::whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->sum('shipping_fee');
            
        // 2. CHI PHÍ HÀNG HÓA (COGS - Cost of Goods Sold)
        $productCost = OrderItem::whereBetween('order_items.created_at', [$startDate, $endDate])
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('product_variants', 'order_items.variant_id', '=', 'product_variants.id')
            ->join('warehouse_stocks', 'product_variants.id', '=', 'warehouse_stocks.variant_id')
            ->where('orders.status', '!=', 'cancelled')
            ->sum(DB::raw('order_items.quantity * warehouse_stocks.cost_price'));
        
        // 3. CHI PHÍ NHÂN VIÊN
        $salaryData = EmployeeSalary::whereBetween('employee_salaries.created_at', [$startDate, $endDate])
            ->selectRaw('SUM(base_salary) as total_base_salary, SUM(bonus) as total_bonus, SUM(deduction) as total_deduction')
            ->first();
            
        $totalSalary = ($salaryData->total_base_salary ?? 0) + ($salaryData->total_bonus ?? 0) - ($salaryData->total_deduction ?? 0);
        
        // 4. CHI PHÍ VẬN HÀNH (Giả định 5% doanh thu)
        $operatingCost = $totalRevenue * 0.05;
        
        // 5. TÍNH TOÁN LỢI NHUẬN
        $grossProfit = $totalRevenue - $productCost; // Lợi nhuận gộp
        $totalExpenses = $totalSalary + $operatingCost; // Tổng chi phí
        $netProfit = $grossProfit - $totalExpenses; // Lợi nhuận ròng

        return [
            // Doanh thu
            'total_revenue' => $totalRevenue,
            'shipping_revenue' => $shippingRevenue,
            'product_revenue' => $totalRevenue - $shippingRevenue,
            
            // Chi phí
            'product_cost' => $productCost,
            'total_salary' => $totalSalary,
            'base_salary' => $salaryData->total_base_salary ?? 0,
            'bonus' => $salaryData->total_bonus ?? 0,
            'deduction' => $salaryData->total_deduction ?? 0,
            'operating_cost' => $operatingCost,
            'total_expenses' => $totalExpenses,
            
            // Lợi nhuận
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'gross_margin' => $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0,
            'net_margin' => $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0,
        ];
    }

    private function getSalaryReport($startDate, $endDate)
    {
        return [
            'total_salary' => EmployeeSalary::whereBetween('employee_salaries.created_at', [$startDate, $endDate])
                ->sum(DB::raw('base_salary + bonus - deduction')),
            'total_bonus' => EmployeeSalary::whereBetween('employee_salaries.created_at', [$startDate, $endDate])->sum('bonus'),
            'total_deduction' => EmployeeSalary::whereBetween('employee_salaries.created_at', [$startDate, $endDate])->sum('deduction'),
            'employee_salaries' => EmployeeSalary::whereBetween('employee_salaries.created_at', [$startDate, $endDate])
                ->with('user:id,name')
                ->select('user_id', DB::raw('SUM(base_salary) as base'), DB::raw('SUM(bonus) as bonus'), DB::raw('SUM(deduction) as deduction'))
                ->groupBy('user_id')
                ->get(),
        ];
    }

    public function exportPdf()
    {
        $startDate = request('start_date') ? \Carbon\Carbon::parse(request('start_date')) : now()->subDays(30);
        $endDate = request('end_date') ? \Carbon\Carbon::parse(request('end_date')) : now();

        $salesData = $this->getSalesReport($startDate, $endDate);
        $inventoryData = $this->getInventoryReport();
        $userStats = $this->getUserStats();
        $orderStats = $this->getOrderStats($startDate, $endDate);
        $profitData = $this->getProfitReport($startDate, $endDate);
        $salaryData = $this->getSalaryReport($startDate, $endDate);

        $pdf = \PDF::loadView('admin.reports.admin-report-pdf', compact('salesData', 'inventoryData', 'userStats', 'orderStats', 'profitData', 'salaryData', 'startDate', 'endDate'));
        return $pdf->download('admin-report-' . now()->format('Y-m-d') . '.pdf');
    }
}
