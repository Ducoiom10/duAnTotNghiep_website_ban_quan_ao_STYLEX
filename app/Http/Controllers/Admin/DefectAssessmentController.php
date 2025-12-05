<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{DefectAssessment, Warehouse, ProductVariant, WarehouseStock, StockInRequest, StockOutInvoice, StockOutInvoiceItem, InventoryLog};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class DefectAssessmentController extends Controller
{
    public function index()
    {
        $assessments = DefectAssessment::with(['warehouse', 'variant.product', 'createdBy', 'assessedBy', 'approvedBy', 'completedBy', 'rejectedBy'])
            ->latest()
            ->paginate(20);
        return view('admin.inventory.defect.index', compact('assessments'));
    }

    public function create()
    {
        $warehouses = Warehouse::where('operational_status', 'ACTIVE')->get();
        $variants = ProductVariant::with('product')->get();
        return view('admin.inventory.defect.create', compact('warehouses', 'variants'));
    }

    public function store()
    {
        try {
            $data = request()->validate([
                'warehouse_id' => 'required|exists:warehouses,id',
                'variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|integer|min:1',
                'defect_level' => 'required|in:LIGHT,MEDIUM,HEAVY',
                'description' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            $data['created_by'] = auth()->id();
            $data['status'] = 'PENDING';

            DefectAssessment::create($data);

            return redirect()->route('admin.inventory.defect.index')
                ->with('success', 'Tạo báo cáo hàng hỏng thành công!');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function assess($id)
    {
        $defect = DefectAssessment::findOrFail($id);
        return view('admin.inventory.defect.assess', compact('defect'));
    }

    public function confirmAssess($id)
    {
        try {
            $defect = DefectAssessment::findOrFail($id);

            if ($defect->status !== 'PENDING') {
                return redirect()->back()->with('error', 'Chỉ có thể đánh giá báo cáo ở trạng thái chờ đánh giá!');
            }

            $data = request()->validate([
                'defect_type' => 'required|string',
                'defect_description' => 'required|string',
                'classification' => 'required|in:REWORK,B-GRADE,SCRAP',
                'notes' => 'nullable|string',
            ]);

            $defect->update([
                'status' => 'ASSESSED',
                'assessed_by' => auth()->id(),
                'defect_type' => $data['defect_type'],
                'defect_description' => $data['defect_description'],
                'classification' => $data['classification'],
                'notes' => $data['notes'] ?? null,
            ]);

            return redirect()->route('admin.inventory.defect.index')
                ->with('success', 'Đánh giá hàng hỏng thành công!');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            $defect = DefectAssessment::findOrFail($id);

            if ($defect->status !== 'ASSESSED') {
                return redirect()->back()->with('error', 'Chỉ có thể phê duyệt báo cáo đã được đánh giá!');
            }

            $defect->update([
                'status' => 'APPROVED',
                'approved_by' => auth()->id()
            ]);

            return redirect()->route('admin.inventory.defect.index')
                ->with('success', 'Phê duyệt xử lý hàng hỏng thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function complete($id)
    {
        try {
            $defect = DefectAssessment::findOrFail($id);

            if ($defect->status !== 'APPROVED') {
                return redirect()->back()->with('error', 'Chỉ có thể hoàn thành báo cáo đã được phê duyệt!');
            }

            $data = request()->validate([
                'repair_cost' => 'nullable|integer|min:0',
                'material_cost' => 'nullable|integer|min:0',
                'other_cost' => 'nullable|integer|min:0',
                'notes' => 'nullable|string',
            ]);

            DB::beginTransaction();

            $stock = WarehouseStock::where('warehouse_id', $defect->warehouse_id)
                ->where('variant_id', $defect->variant_id)
                ->first();

            if ($stock && $stock->damaged >= $defect->quantity) {
                $damagedBefore = $stock->damaged;
                $stock->decrement('damaged', $defect->quantity);
                
                InventoryLog::create([
                    'warehouse_id' => $defect->warehouse_id,
                    'variant_id' => $defect->variant_id,
                    'action' => 'ADJUSTMENT',
                    'quantity_before' => $damagedBefore,
                    'quantity_change' => -$defect->quantity,
                    'quantity_after' => $stock->damaged,
                    'reference_type' => 'defect_assessment',
                    'reference_id' => $defect->id,
                    'user_id' => Auth::id(),
                    'notes' => "Thanh ly hang hong: {$defect->classification}",
                ]);
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Số lượng hỏng trong kho không đủ!');
            }

            $stockInRequest = null;
            if ($defect->classification === 'SCRAP') {
                $this->createClearanceInvoice($defect, $data);
            } else {
                $totalCost = ($data['repair_cost'] ?? 0) + ($data['material_cost'] ?? 0) + ($data['other_cost'] ?? 0);
                $costPrice = $totalCost > 0 ? round($totalCost / $defect->quantity) : 0;

                $stockInRequest = StockInRequest::create([
                    'warehouse_id' => $defect->warehouse_id,
                    'variant_id' => $defect->variant_id,
                    'quantity' => $defect->quantity,
                    'batch_number' => 'REWORK-' . date('YmdHis'),
                    'cost_price' => $costPrice,
                    'received_date' => now()->toDateString(),
                    'status' => 'PENDING',
                    'created_by' => auth()->id(),
                    'notes' => "Sửa chữa từ lô hỏng - Phân loại: {$defect->classification}",
                ]);
            }

            $defect->update([
                'status' => 'COMPLETED',
                'completed_by' => auth()->id(),
                'repair_cost' => $data['repair_cost'] ?? 0,
                'material_cost' => $data['material_cost'] ?? 0,
                'other_cost' => $data['other_cost'] ?? 0,
                'notes' => $data['notes'] ?? $defect->notes,
                'stock_in_request_id' => $stockInRequest?->id,
            ]);

            DB::commit();

            return redirect()->route('admin.inventory.defect.index')
                ->with('success', 'Hoàn thành xử lý hàng hỏng thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            $defect = DefectAssessment::findOrFail($id);

            if ($defect->status !== 'ASSESSED') {
                return redirect()->back()->with('error', 'Chỉ có thể từ chối báo cáo đã được đánh giá!');
            }

            $data = request()->validate([
                'rejection_reason' => 'required|string',
            ]);

            DB::beginTransaction();

            $defect->update([
                'status' => 'REJECTED',
                'rejected_by' => auth()->id(),
                'rejection_reason' => $data['rejection_reason'],
            ]);

            DB::commit();

            return redirect()->route('admin.inventory.defect.index')
                ->with('success', 'Từ chối xử lý hàng hỏng!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    private function createClearanceInvoice(DefectAssessment $defect, array $data): void
    {
        $costPrice = ($data['repair_cost'] ?? 0) + ($data['material_cost'] ?? 0) + ($data['other_cost'] ?? 0);
        $clearancePrice = round($costPrice * 0.7);
        $totalAmount = $clearancePrice * $defect->quantity;

        $invoice = StockOutInvoice::create([
            'invoice_number' => 'CLR-' . date('YmdHis'),
            'warehouse_id' => $defect->warehouse_id,
            'type' => 'CLEARANCE',
            'total_amount' => $totalAmount,
            'status' => 'COMPLETED',
            'created_by' => auth()->id(),
            'completed_by' => auth()->id(),
            'completed_at' => now(),
            'notes' => "Thanh ly hang hong - Phan loai: {$defect->classification}",
        ]);

        StockOutInvoiceItem::create([
            'stock_out_invoice_id' => $invoice->id,
            'variant_id' => $defect->variant_id,
            'quantity' => $defect->quantity,
            'unit_price' => $clearancePrice,
            'line_total' => $totalAmount,
            'defect_assessment_id' => $defect->id,
        ]);
    }
}
