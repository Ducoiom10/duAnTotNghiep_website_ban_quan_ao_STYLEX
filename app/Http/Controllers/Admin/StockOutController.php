<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\ProductVariant;
use App\Models\StockOutRequest;
use App\Models\WarehouseStock;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $batches = StockOutRequest::with(['variant.product', 'warehouse', 'createdBy', 'qcBy', 'confirmedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.inventory.stock-out.index', compact('batches'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();
        $variants = ProductVariant::with('product', 'color', 'size')->get();

        return view('admin.inventory.stock-out.create', compact('warehouses', 'variants'));
    }

    public function store(Request $httpRequest)
    {
        $validated = $httpRequest->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'variant_id' => 'required|exists:product_variants,id',
            'batch_number' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $stock = WarehouseStock::where('warehouse_id', $validated['warehouse_id'])
                ->where('variant_id', $validated['variant_id'])
                ->first();

            if (!$stock || $stock->available < $validated['quantity']) {
                return back()->withInput()->with('error', 'Không đủ tồn kho. Có sẵn: ' . ($stock->available ?? 0));
            }

            $validated['created_by'] = auth()->id();
            $validated['status'] = 'PENDING';
            $validated['expiry_date'] = now()->addMonths(12)->toDateString();

            $stockOutRequest = StockOutRequest::create($validated);

            return redirect()->route('admin.inventory.stock-out.index')
                ->with('success', 'Tạo yêu cầu xuất kho thành công');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function qc($id)
    {
        $request = StockOutRequest::find($id);

        if (!$request || $request->status !== 'PENDING') {
            return back()->with('error', 'Chỉ có thể QC yêu cầu ở trạng thái PENDING');
        }

        return view('admin.inventory.stock-out.qc', compact('request'));
    }

    public function confirmQC(Request $httpRequest, $id)
    {
        $validated = $httpRequest->validate([
            'passed_qty' => 'required|integer|min:0',
            'failed_qty' => 'required|integer|min:0',
        ]);

        try {
            $request = StockOutRequest::find($id);
            if (!$request) {
                throw new \Exception('Yêu cầu không tồn tại');
            }

            if ($validated['passed_qty'] + $validated['failed_qty'] !== $request->quantity) {
                return back()->with('error', 'Tổng số lượng QC không khớp với số lượng xuất');
            }

            $request->update([
                'qc_passed_qty' => $validated['passed_qty'],
                'qc_failed_qty' => $validated['failed_qty'],
                'status' => 'QC_PASSED',
                'qc_by' => auth()->id(),
            ]);

            return redirect()->route('admin.inventory.stock-out.index')
                ->with('success', 'Phê duyệt QC thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirm($id)
    {
        try {
            $request = StockOutRequest::findOrFail($id);
            
            if ($request->status !== 'QC_PASSED') {
                return back()->with('error', 'Chỉ có thể xác nhận yêu cầu ở trạng thái QC_PASSED');
            }

            if (!$request->qc_passed_qty || $request->qc_passed_qty <= 0) {
                return back()->with('error', 'Không có số lượng pass để xuất kho');
            }

            InventoryService::confirmStockOut($request->id);

            $request->update(['confirmed_by' => auth()->id()]);

            return redirect()->route('admin.inventory.stock-out.index')
                ->with('success', 'Xác nhận xuất ' . $request->qc_passed_qty . ' sản phẩm thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xác nhận xuất kho: ' . $e->getMessage());
        }
    }
}
