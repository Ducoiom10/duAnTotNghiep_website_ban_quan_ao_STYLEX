@extends('admin.layouts.app')

@section('title', 'Chi tiết yêu cầu Trả/Đổi hàng')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>{{ $return->rma_number }}</h1>
            <p class="text-muted">Đơn hàng: {{ $return->order->code }}</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.inventory.returns.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Thông tin chung -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin yêu cầu</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Loại:</strong> {{ $return->type === 'RETURN' ? 'Trả hàng' : 'Đổi hàng' }}</p>
                            <p><strong>Lý do:</strong> {{ $return->reason }}</p>
                            <p><strong>Khách hàng:</strong> {{ $return->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Trạng thái:</strong> 
                                @php
                                    $statusColors = [
                                        'PENDING' => 'secondary',
                                        'APPROVED' => 'info',
                                        'REJECTED' => 'danger',
                                        'RECEIVED' => 'primary',
                                        'QC_PASSED' => 'success',
                                        'QC_FAILED' => 'danger',
                                        'COMPLETED' => 'success',
                                    ];
                                    $statusLabels = [
                                        'PENDING' => 'Chờ duyệt',
                                        'APPROVED' => 'Đã duyệt',
                                        'REJECTED' => 'Từ chối',
                                        'RECEIVED' => 'Đã nhận',
                                        'QC_PASSED' => 'QC Pass',
                                        'QC_FAILED' => 'QC Fail',
                                        'COMPLETED' => 'Hoàn thành',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$return->status] ?? 'secondary' }}">
                                    {{ $statusLabels[$return->status] ?? $return->status }}
                                </span>
                            </p>
                            <p><strong>Ngày tạo:</strong> {{ $return->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if ($return->reason_description)
                        <p><strong>Mô tả:</strong> {{ $return->reason_description }}</p>
                    @endif
                </div>
            </div>

            <!-- Sản phẩm trả/đổi -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Sản phẩm trả/đổi</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tình trạng</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($return->items as $item)
                                <tr>
                                    <td>{{ $item->variant->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price) }} đ</td>
                                    <td>{{ $item->condition }}</td>
                                    <td>{{ $item->item_notes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Workflow Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Xử lý yêu cầu</h5>
                </div>
                <div class="card-body">
                    @if ($return->status === 'PENDING')
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('admin.inventory.returns.approve', $return->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-circle"></i> Duyệt yêu cầu
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="bi bi-x-circle"></i> Từ chối
                                </button>
                            </div>
                        </div>
                    @elseif ($return->status === 'APPROVED')
                        <form action="{{ route('admin.inventory.returns.confirmReceived', $return->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-box-seam"></i> Xác nhận đã nhận hàng
                            </button>
                        </form>
                    @elseif ($return->status === 'RECEIVED')
                        <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#qcModal">
                            <i class="bi bi-clipboard-check"></i> Thực hiện QC
                        </button>
                    @elseif ($return->status === 'QC_PASSED')
                        <form action="{{ route('admin.inventory.returns.complete', $return->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-all"></i> Hoàn thành xử lý
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin hoàn tiền</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tổng tiền hoàn:</strong> {{ number_format($return->getTotalRefundAmount()) }} đ</p>
                    @if ($return->refund)
                        <p><strong>Trạng thái:</strong> 
                            <span class="badge bg-{{ $return->refund->status === 'PROCESSED' ? 'success' : 'warning' }}">
                                {{ $return->refund->status }}
                            </span>
                        </p>
                        <p><strong>Phương thức:</strong> {{ $return->refund->method }}</p>
                        @if ($return->refund->processed_at)
                            <p><strong>Ngày xử lý:</strong> {{ $return->refund->processed_at->format('d/m/Y H:i') }}</p>
                        @endif
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lịch sử xử lý</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @if ($return->approved_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Đã duyệt</strong></p>
                                    <small class="text-muted">{{ $return->approved_at->format('d/m/Y H:i') }}</small>
                                    <small class="text-muted">bởi {{ $return->approvedByUser->name ?? 'N/A' }}</small>
                                </div>
                            </div>
                        @endif
                        @if ($return->received_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>Đã nhận hàng</strong></p>
                                    <small class="text-muted">{{ $return->received_at->format('d/m/Y H:i') }}</small>
                                    <small class="text-muted">bởi {{ $return->receivedByUser->name ?? 'N/A' }}</small>
                                </div>
                            </div>
                        @endif
                        @if ($return->qc_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-{{ $return->status === 'QC_PASSED' ? 'success' : 'danger' }}"></div>
                                <div class="timeline-content">
                                    <p class="mb-0"><strong>QC {{ $return->status === 'QC_PASSED' ? 'Pass' : 'Fail' }}</strong></p>
                                    <small class="text-muted">{{ $return->qc_at->format('d/m/Y H:i') }}</small>
                                    <small class="text-muted">bởi {{ $return->qcByUser->name ?? 'N/A' }}</small>
                                    @if ($return->qc_notes)
                                        <p class="mb-0 mt-2"><small>{{ $return->qc_notes }}</small></p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Từ chối yêu cầu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.inventory.returns.reject', $return->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea name="notes" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- QC Modal -->
<div class="modal fade" id="qcModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thực hiện QC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.inventory.returns.qc', $return->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Kết quả QC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($return->items as $index => $item)
                                    <tr>
                                        <td>{{ $item->variant->product->name }}</td>
                                        <td>
                                            <select name="items[{{ $index }}][qc_result]" class="form-select form-select-sm" required>
                                                <option value="">-- Chọn --</option>
                                                <option value="PASS">Pass</option>
                                                <option value="FAIL">Fail</option>
                                            </select>
                                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú QC</label>
                        <textarea name="qc_notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Hoàn thành QC</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -20px;
    top: 30px;
    width: 2px;
    height: calc(100% + 10px);
    background: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -28px;
    top: 0;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid white;
}

.timeline-content {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
}
</style>
@endsection
