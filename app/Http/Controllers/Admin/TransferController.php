<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\ProductVariant;
use App\Models\TransferRequest;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $movements = TransferRequest::with(['fromWarehouse', 'toWarehouse', 'variant.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.inventory.transfer.index', compact('movements'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();
        $variants = ProductVariant::with('product', 'color', 'size')->get();

        return view('admin.inventory.transfer.create', compact('warehouses', 'variants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $validated['created_by'] = auth()->id();
            $validated['status'] = 'PENDING';
            
            TransferRequest::create($validated);

            return redirect()->route('admin.inventory.transfer.index')
                ->with('success', 'Tạo yêu cầu chuyển kho thành công');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function confirmOut($id)
    {
        try {
            $transfer = TransferRequest::findOrFail($id);
            
            if ($transfer->status !== 'PENDING') {
                return back()->with('error', 'Chỉ có thể xác nhận yêu cầu ở trạng thái PENDING');
            }

            InventoryService::confirmTransferOut($transfer->id);
            $transfer->update(['out_confirmed_by' => auth()->id()]);

            return redirect()->route('admin.inventory.transfer.index')
                ->with('success', 'Xác nhận xuất kho thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmIn($id)
    {
        try {
            $transfer = TransferRequest::findOrFail($id);
            
            if ($transfer->status !== 'OUT_CONFIRMED') {
                return back()->with('error', 'Chỉ có thể xác nhận yêu cầu ở trạng thái OUT_CONFIRMED');
            }

            InventoryService::confirmTransferIn($transfer->id);
            $transfer->update(['in_confirmed_by' => auth()->id()]);

            return redirect()->route('admin.inventory.transfer.index')
                ->with('success', 'Xác nhận nhập kho thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
