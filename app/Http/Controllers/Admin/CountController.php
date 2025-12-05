<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountRequest;
use App\Models\Warehouse;
use App\Models\ProductVariant;
use App\Models\WarehouseStock;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class CountController extends Controller
{
    public function index()
    {
        $requests = CountRequest::with(['warehouse', 'variant.product', 'createdBy', 'countedBy', 'confirmedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.inventory.count.index', compact('requests'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $variants = ProductVariant::with('product', 'color', 'size')->get();

        return view('admin.inventory.count.create', compact('warehouses', 'variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'variant_id' => 'required|exists:product_variants,id',
        ]);

        try {
            InventoryService::createCount(
                $validated['warehouse_id'],
                $validated['variant_id']
            );

            return redirect()->route('admin.inventory.count.index')
                ->with('success', 'Tao yeu cau kiem ke thanh cong');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function count($id)
    {
        $request = CountRequest::findOrFail($id);

        if ($request->status !== 'PENDING') {
            return back()->with('error', 'Chi co the dem kho khi o trang thai PENDING');
        }

        return view('admin.inventory.count.count', compact('request'));
    }

    public function confirmCount(Request $request, $id)
    {
        $validated = $request->validate([
            'available_qty' => 'required|integer|min:0',
            'reserved_qty' => 'required|integer|min:0',
            'quarantine_qty' => 'required|integer|min:0',
            'damaged_qty' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            InventoryService::confirmCount(
                $id,
                $validated['available_qty'],
                $validated['reserved_qty'],
                $validated['quarantine_qty'],
                $validated['damaged_qty'],
                $validated['notes'] ?? null
            );

            return redirect()->route('admin.inventory.count.index')
                ->with('success', 'Xac nhan dem kho thanh cong');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmAdjustment(Request $request, $id)
    {
        $validated = $request->validate([
            'available_qty' => 'required|integer|min:0',
            'reserved_qty' => 'required|integer|min:0',
            'quarantine_qty' => 'required|integer|min:0',
            'damaged_qty' => 'required|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            InventoryService::confirmCountAdjustment(
                $id,
                $validated['available_qty'],
                $validated['reserved_qty'],
                $validated['quarantine_qty'],
                $validated['damaged_qty'],
                $validated['notes'] ?? null
            );

            return redirect()->route('admin.inventory.count.index')
                ->with('success', 'Xac nhan dieu chinh kho thanh cong');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
