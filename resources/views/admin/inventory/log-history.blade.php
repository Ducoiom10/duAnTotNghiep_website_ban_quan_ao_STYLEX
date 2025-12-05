@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-history"></i> Lịch Sử Kho</h4>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kho Hàng</label>
                    <select name="warehouse_id" class="form-select">
                        <option value="">-- Tất Cả --</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                {{ $warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hành Động</label>
                    <select name="action" class="form-select">
                        <option value="">-- Tất Cả --</option>
                        <option value="IN" {{ request('action') === 'IN' ? 'selected' : '' }}>Nhập</option>
                        <option value="OUT" {{ request('action') === 'OUT' ? 'selected' : '' }}>Xuất</option>
                        <option value="TRANSFER" {{ request('action') === 'TRANSFER' ? 'selected' : '' }}>Chuyển</option>
                        <option value="ADJUSTMENT" {{ request('action') === 'ADJUSTMENT' ? 'selected' : '' }}>Điều Chỉnh</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Tìm Kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Lịch Sử Giao Dịch ({{ $logs->total() }})</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ngày</th>
                            <th>Sản Phẩm</th>
                            <th>Kho</th>
                            <th>Hành Động</th>
                            <th class="text-end">Trước</th>
                            <th class="text-end">Thay Đổi</th>
                            <th class="text-end">Sau</th>
                            <th>Tham Chiếu</th>
                            <th>Người Thực Hiện</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $log->variant->product->name ?? 'N/A' }}</td>
                                <td>{{ $log->warehouse->name }}</td>
                                <td>
                                    @if ($log->action === 'IN')
                                        <span class="badge bg-success">Nhập</span>
                                    @elseif ($log->action === 'OUT')
                                        <span class="badge bg-danger">Xuất</span>
                                    @elseif ($log->action === 'TRANSFER')
                                        <span class="badge bg-info">Chuyển</span>
                                    @elseif ($log->action === 'ADJUSTMENT')
                                        <span class="badge bg-warning">Điều Chỉnh</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format($log->quantity_before) }}</td>
                                <td class="text-end">
                                    <span class="{{ $log->quantity_change > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $log->quantity_change > 0 ? '+' : '' }}{{ number_format($log->quantity_change) }}
                                    </span>
                                </td>
                                <td class="text-end">{{ number_format($log->quantity_after) }}</td>
                                <td>
                                    <small>{{ $log->reference_type }}: {{ $log->reference_id }}</small>
                                </td>
                                <td>{{ $log->user->name ?? 'N/A' }}</td>
                                <td>{{ $log->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có lịch sử nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $logs->links() }}
    </div>
</div>
@endsection
