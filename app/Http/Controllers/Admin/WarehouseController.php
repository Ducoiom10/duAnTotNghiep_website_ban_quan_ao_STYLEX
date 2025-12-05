<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Warehouse\WarehouseRequest ;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::paginate(20);
        return view('admin.warehouse.index', compact('warehouses'));
    }

    public function show(Warehouse $warehouse)
    {
        return view('admin.warehouse.show', compact('warehouse'));
    }

    public function create()
    {
        return view('admin.warehouse.create');
    }

    public function store(WarehouseRequest $request)
    {
        Warehouse::create($request->validated());
        return redirect()->route('admin.inventory.warehouses.index')
                         ->with('success', 'Tạo kho hàng thành công.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouse.edit', compact('warehouse'));
    }

    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        $warehouse->update($request->validated());
        return redirect()->route('admin.inventory.warehouses.index')
                         ->with('success', 'Cập nhật kho hàng thành công.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->loadCount('warehouseStocks');

        if ($warehouse->warehouse_stocks_count > 0) {
            return redirect()->back()->with('error', 'Không thể xóa kho hàng đang có tồn kho. Vui lòng chuyển hàng đi trước.');
        }

        $warehouse->delete();
        return redirect()->route('admin.inventory.warehouses.index')
                         ->with('success', 'Xóa kho hàng thành công.');
    }
}
