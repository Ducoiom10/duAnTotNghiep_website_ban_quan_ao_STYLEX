<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ReturnRequest, ReturnItem, Refund, Order, WarehouseStock, InventoryLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};

class ReturnController extends Controller
{
    public function index()
    {
        $returns = ReturnRequest::with(['order', 'user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.returns.index', compact('returns'));
    }

    public function create()
    {
        $orders = Order::where('status', 'completed')
            ->with('items.variant.product')
            ->get();

        return view('admin.returns.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'type' => 'required|in:RETURN,EXCHANGE',
            'reason' => 'required|in:DEFECTIVE,NOT_AS_DESCRIBED,WRONG_SIZE,WRONG_COLOR,CHANGED_MIND,OTHER',
            'reason_description' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.order_item_id' => 'required|exists:order_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.condition' => 'required|in:UNOPENED,OPENED,DAMAGED,DEFECTIVE',
            'items.*.notes' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $order = Order::findOrFail($validated['order_id']);
                $rmaNumber = 'RMA-' . date('YmdHis') . '-' . rand(1000, 9999);

                $returnRequest = ReturnRequest::create([
                    'order_id' => $validated['order_id'],
                    'user_id' => $order->user_id,
                    'rma_number' => $rmaNumber,
                    'type' => $validated['type'],
                    'reason' => $validated['reason'],
                    'reason_description' => $validated['reason_description'],
                    'status' => 'PENDING',
                    'notes' => $validated['notes'],
                ]);

                foreach ($validated['items'] as $item) {
                    $orderItem = $order->items()->findOrFail($item['order_item_id']);
                    ReturnItem::create([
                        'return_request_id' => $returnRequest->id,
                        'order_item_id' => $item['order_item_id'],
                        'variant_id' => $orderItem->variant_id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $orderItem->price,
                        'condition' => $item['condition'],
                        'item_notes' => $item['notes'],
                    ]);
                }
            });

            return redirect()->route('admin.inventory.returns.index')
                ->with('success', 'Tạo yêu cầu trả/đổi hàng thành công');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $return = ReturnRequest::with(['order', 'user', 'items.variant.product', 'refund'])
            ->findOrFail($id);

        return view('admin.returns.show', compact('return'));
    }

    public function approve(Request $request, $id)
    {
        $return = ReturnRequest::findOrFail($id);

        if ($return->status !== 'PENDING') {
            return back()->with('error', 'Chỉ có thể duyệt yêu cầu ở trạng thái PENDING');
        }

        $return->update([
            'status' => 'APPROVED',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Duyệt yêu cầu thành công');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        $return = ReturnRequest::findOrFail($id);

        if ($return->status !== 'PENDING') {
            return back()->with('error', 'Chỉ có thể từ chối yêu cầu ở trạng thái PENDING');
        }

        $return->update([
            'status' => 'REJECTED',
            'notes' => $validated['notes'],
        ]);

        return back()->with('success', 'Từ chối yêu cầu thành công');
    }

    public function confirmReceived(Request $request, $id)
    {
        $return = ReturnRequest::findOrFail($id);

        if ($return->status !== 'APPROVED') {
            return back()->with('error', 'Chỉ có thể xác nhận nhận hàng khi đã duyệt');
        }

        $return->update([
            'status' => 'RECEIVED',
            'received_by' => auth()->id(),
            'received_at' => now(),
        ]);

        return back()->with('success', 'Xác nhận nhận hàng thành công');
    }

    public function qc(Request $request, $id)
    {
        $validated = $request->validate([
            'qc_notes' => 'nullable|string|max:500',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:return_items,id',
            'items.*.qc_result' => 'required|in:PASS,FAIL',
        ]);

        try {
            DB::transaction(function () use ($validated, $id) {
                $return = ReturnRequest::findOrFail($id);

                if ($return->status !== 'RECEIVED') {
                    throw new \Exception('Chỉ có thể QC khi đã nhận hàng');
                }

                $allPass = true;
                foreach ($validated['items'] as $item) {
                    if ($item['qc_result'] === 'FAIL') {
                        $allPass = false;
                        break;
                    }
                }

                $return->update([
                    'status' => $allPass ? 'QC_PASSED' : 'QC_FAILED',
                    'qc_by' => auth()->id(),
                    'qc_at' => now(),
                    'qc_notes' => $validated['qc_notes'],
                ]);

                if ($allPass && $return->type === 'RETURN') {
                    Refund::create([
                        'return_request_id' => $return->id,
                        'amount' => $return->getTotalRefundAmount(),
                        'status' => 'PENDING',
                        'method' => 'ORIGINAL_PAYMENT',
                    ]);
                }
            });

            return back()->with('success', 'Hoàn thành QC');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function complete($id)
    {
        $return = ReturnRequest::findOrFail($id);

        if ($return->status !== 'QC_PASSED') {
            return back()->with('error', 'Chỉ có thể hoàn thành khi QC đã pass');
        }

        try {
            DB::transaction(function () use ($return) {
                if ($return->type === 'RETURN') {
                    $this->restockReturnedItems($return);
                } elseif ($return->type === 'EXCHANGE') {
                    $this->restockReturnedItems($return);
                }

                $return->update(['status' => 'COMPLETED']);
            });

            return back()->with('success', 'Hoàn thành xử lý trả/đổi hàng');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function restockReturnedItems(ReturnRequest $return): void
    {
        $warehouse = $return->order->items()->first()?->variant?->warehouse;

        if (!$warehouse) {
            throw new \Exception('Không tìm thấy kho để nhập hàng trả về');
        }

        foreach ($return->items as $item) {
            $stock = WarehouseStock::firstOrCreate(
                ['warehouse_id' => $warehouse->id, 'variant_id' => $item->variant_id],
                ['on_hand' => 0, 'available' => 0, 'reserved' => 0, 'quarantine' => 0, 'damaged' => 0]
            );

            $availableBefore = $stock->available;
            $stock->update([
                'on_hand' => $stock->on_hand + $item->quantity,
                'available' => $stock->available + $item->quantity,
            ]);

            InventoryLog::create([
                'warehouse_id' => $warehouse->id,
                'variant_id' => $item->variant_id,
                'action' => 'IN',
                'quantity_before' => $availableBefore,
                'quantity_change' => $item->quantity,
                'quantity_after' => $stock->available,
                'reference_type' => 'return_request',
                'reference_id' => $return->id,
                'user_id' => Auth::id(),
                'notes' => "Tra hang: {$return->rma_number}",
            ]);
        }
    }
}
