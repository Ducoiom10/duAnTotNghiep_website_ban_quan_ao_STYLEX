@extends('admin.layouts.app')

@section('title', 'Chi tiết hóa đơn xuất kho')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $invoice->invoice_number }}</h1>
            <p class="text-muted">Loại: {{ $invoice->type === 'CLEARANCE' ? 'Thanh lý' : 'Thường' }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.inventory.stock-out-invoice.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin hóa đơn</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Số hóa đơn:</strong> {{ $invoice->invoice_number }}</p>
                            <p><strong>Kho:</strong> {{ $invoice->warehouse->name }}</p>
                            <p><strong>Loại:</strong> {{ $invoice->type === 'CLEARANCE' ? 'Thanh lý' : 'Thường' }}</p>
                            <p><strong>Ngày tạo:</strong> {{ $invoice->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge bg-{{ $invoice->status === 'COMPLETED' ? 'success' : 'secondary' }}">
                                    {{ $invoice->status }}
                                </span>
                            </p>
                            <p><strong>Người tạo:</strong> {{ $invoice->createdByUser->name }}</p>
                            @if ($invoice->completed_at)
                                <p><strong>Ngày hoàn thành:</strong> {{ $invoice->completed_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Người hoàn thành:</strong> {{ $invoice->completedByUser->name }}</p>
                            @endif
                        </div>
                    </div>
                    @if ($invoice->notes)
                        <p><strong>Ghi chú:</strong> {{ $invoice->notes }}</p>
                    @endif
                </div>
                @if ($invoice->status !== 'COMPLETED')
                    <div class="card-footer">
                        <form action="{{ route('admin.inventory.stock-out-invoice.complete', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận hoàn thành hóa đơn?');">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Hoàn thành hóa đơn
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Chi tiết sản phẩm</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                                <th>Từ defect</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->variant->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price) }} đ</td>
                                    <td>{{ number_format($item->line_total) }} đ</td>
                                    <td>
                                        @if ($item->defectAssessment)
                                            <a href="{{ route('admin.inventory.defect.assess', $item->defectAssessment->id) }}" class="btn btn-sm btn-link">
                                                {{ $item->defectAssessment->id }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tóm tắt</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Tổng tiền</small>
                        <div class="h5">{{ number_format($invoice->total_amount) }} đ</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Số sản phẩm</small>
                        <div class="h5">{{ $invoice->items->sum('quantity') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Người tạo</small>
                        <div>{{ $invoice->createdByUser->name }}</div>
                    </div>
                    @if ($invoice->completedByUser)
                        <div class="mb-3">
                            <small class="text-muted">Người hoàn thành</small>
                            <div>{{ $invoice->completedByUser->name }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
