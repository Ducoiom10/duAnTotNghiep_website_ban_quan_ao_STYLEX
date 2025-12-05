<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\ProductVariant;
use App\Models\StockInRequest;
use App\Models\StockReturnRequest;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class StockInController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $batches = StockInRequest::with(['variant.product', 'warehouse', 'createdBy', 'qcBy', 'confirmedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.inventory.stock-in.index', compact('batches'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();
        $variants = ProductVariant::with('product', 'color', 'size')->get();

        return view('admin.inventory.stock-in.create', compact('warehouses', 'variants'));
    }

    public function store(Request $httpRequest)
    {
        $validated = $httpRequest->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'variant_id' => 'required|exists:product_variants,id',
            'batch_number' => 'required|string|unique:stock_in_requests,batch_number',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $validated['created_by'] = auth()->id();
            $validated['status'] = 'PENDING';
            $validated['received_date'] = now()->toDateString();

            $stockInRequest = StockInRequest::create($validated);

            return redirect()->route('admin.inventory.stock-in.index')
                ->with('success', 'Tạo yêu cầu nhập kho thành công');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function qc($id)
    {
        $request = StockInRequest::find($id);

        if (!$request || $request->status !== 'PENDING') {
            return back()->with('error', 'Chỉ có thể QC yêu cầu ở trạng thái PENDING');
        }

        return view('admin.inventory.stock-in.qc', compact('request'));
    }

    public function confirmQC(Request $httpRequest, $id)
    {
        $validated = $httpRequest->validate([
            'passed_qty' => 'required|integer|min:0',
            'failed_qty' => 'required|integer|min:0',
        ]);

        try {
            $request = StockInRequest::find($id);
            if (!$request) {
                throw new \Exception('Yêu cầu không tồn tại');
            }

            if ($validated['passed_qty'] + $validated['failed_qty'] !== $request->quantity) {
                return back()->with('error', 'Tổng số lượng QC không khớp với số lượng nhập');
            }

            $request->update([
                'qc_passed_qty' => $validated['passed_qty'],
                'qc_failed_qty' => $validated['failed_qty'],
                'status' => 'QC_PASSED',
                'qc_by' => auth()->id(),
            ]);

            if ($validated['failed_qty'] > 0) {
                StockReturnRequest::create([
                    'stock_in_request_id' => $request->id,
                    'quantity' => $validated['failed_qty'],
                    'reason' => 'QC_FAIL',
                    'status' => 'PENDING',
                    'created_by' => auth()->id(),
                ]);
            }

            return redirect()->route('admin.inventory.stock-in.index')
                ->with('success', 'Phê duyệt QC thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirm($id)
    {
        try {
            $request = StockInRequest::findOrFail($id);
            
            if ($request->status !== 'QC_PASSED') {
                return back()->with('error', 'Chỉ có thể xác nhận yêu cầu ở trạng thái QC_PASSED');
            }

            if (!$request->qc_passed_qty || $request->qc_passed_qty <= 0) {
                return back()->with('error', 'Không có số lượng pass để nhập kho');
            }

            InventoryService::confirmStockIn($request->id);

            $request->update(['confirmed_by' => auth()->id()]);

            $message = 'Xác nhận nhập ' . $request->qc_passed_qty . ' sản phẩm thành công';
            if ($request->qc_failed_qty > 0) {
                $message .= '. Đã tạo phiếu trả ' . $request->qc_failed_qty . ' sản phẩm fail';
            }

            return redirect()->route('admin.inventory.stock-in.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi xác nhận nhập kho: ' . $e->getMessage());
        }
    }
}
