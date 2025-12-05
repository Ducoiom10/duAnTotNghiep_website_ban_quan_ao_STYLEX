<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{StockOutInvoice, WarehouseStock, InventoryLog};
use Illuminate\Support\Facades\{DB, Auth};

class StockOutInvoiceController extends Controller
{
    public function index()
    {
        $invoices = StockOutInvoice::with(['warehouse', 'items.variant.product', 'createdByUser'])
            ->latest()
            ->paginate(20);

        return view('admin.inventory.stock-out-invoice.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = StockOutInvoice::with(['warehouse', 'items.variant.product', 'items.defectAssessment', 'createdByUser', 'completedByUser'])
            ->findOrFail($id);

        return view('admin.inventory.stock-out-invoice.show', compact('invoice'));
    }

    public function complete($id)
    {
        $invoice = StockOutInvoice::findOrFail($id);

        if ($invoice->status === 'COMPLETED') {
            return redirect()->route('admin.inventory.stock-out-invoice.show', $invoice->id)
                ->with('error', 'Hóa đơn đã được hoàn thành rồi');
        }

        try {
            DB::transaction(function () use ($invoice) {
                foreach ($invoice->items as $item) {
                    $stock = WarehouseStock::where('warehouse_id', $invoice->warehouse_id)
                        ->where('variant_id', $item->variant_id)
                        ->first();

                    if ($stock) {
                        $onHandBefore = $stock->on_hand;
                        $stock->decrement('on_hand', $item->quantity);
                        $stock->decrement('available', $item->quantity);

                        InventoryLog::create([
                            'warehouse_id' => $invoice->warehouse_id,
                            'variant_id' => $item->variant_id,
                            'action' => 'OUT',
                            'quantity_before' => $onHandBefore,
                            'quantity_change' => -$item->quantity,
                            'quantity_after' => $stock->on_hand,
                            'reference_type' => 'stock_out_invoice',
                            'reference_id' => $invoice->id,
                            'user_id' => Auth::id(),
                            'notes' => "Hoa don thanh ly: {$invoice->invoice_number}",
                        ]);
                    }
                }

                $invoice->update([
                    'status' => 'COMPLETED',
                    'completed_at' => now(),
                    'completed_by' => Auth::id(),
                ]);
            });

            return redirect()->route('admin.inventory.stock-out-invoice.show', $invoice->id)
                ->with('success', 'Hóa đơn đã được hoàn thành');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
