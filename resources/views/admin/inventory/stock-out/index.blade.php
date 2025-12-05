@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-upload"></i> Xuất Kho</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.stock-out.create') }}" class="btn btn-success btn-sm">
                <i class="bx bx-plus"></i> Tạo Yêu Cầu Xuất
            </a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-x-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="d-flex gap-2">
            <i class="bx bx-info-circle fs-5 mt-1"></i>
            <div>
                <strong>Quy trình Xuất Kho:</strong>
                <ol class="mb-0 mt-2 ps-3 small">
                    <li>Tạo yêu cầu xuất: Chọn kho, sản phẩm, số lô, số lượng</li>
                    <li>Kiểm chất lượng (QC): Nhập số lượng đạt/không đạt khi lô ở trạng thái "Chờ QC"</li>
                    <li>Xác nhận xuất: Click "Xác Nhận" khi QC pass để cập nhật tồn kho</li>
                </ol>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Yêu Cầu Xuất Kho ({{ $batches->total() }})</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Lô Hàng</th>
                            <th>Sản Phẩm</th>
                            <th class="text-end">Số Lượng</th>
                            <th>Ngày Xuất</th>
                            <th>Hết Hạn</th>
                            <th>Kho</th>
                            <th>Người Tạo</th>
                            <th>QC Bởi</th>
                            <th>Xác Nhận Bởi</th>
                            <th>Ghi Chú</th>
                            <th>Trạng Thái</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($batches as $request)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $request->batch_number }}</span></td>
                                <td>{{ $request->variant->product->name ?? 'N/A' }}</td>
                                <td class="text-end">{{ number_format($request->quantity) }}</td>
                                <td>{{ now()->format('d/m/Y') }}</td>
                                <td>{{ $request->expiry_date?->format('d/m/Y') }}</td>
                                <td>{{ $request->warehouse->name ?? 'N/A' }}</td>
                                <td>{{ $request->createdBy->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($request->qc_by)
                                        <span class="badge bg-success">{{ $request->qcBy->name }}</span>
                                    @else
                                        <span class="badge bg-warning">Chờ</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->confirmed_by)
                                        <span class="badge bg-success">{{ $request->confirmedBy->name }}</span>
                                    @else
                                        <span class="badge bg-warning">Chờ</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->notes)
                                        <span title="{{ $request->notes }}" class="text-truncate d-inline-block" style="max-width: 150px;">{{ $request->notes }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->status === 'PENDING')
                                        <span class="badge bg-warning">Chờ QC</span>
                                    @elseif ($request->status === 'QC_PASSED')
                                        <span class="badge bg-info">QC Pass</span>
                                    @elseif ($request->status === 'QC_FAILED')
                                        <span class="badge bg-danger">QC Fail</span>
                                    @elseif ($request->status === 'CONFIRMED')
                                        <span class="badge bg-success">Đã Xác Nhận</span>
                                    @elseif ($request->status === 'CANCELLED')
                                        <span class="badge bg-danger">Đã Hủy</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($request->status === 'PENDING')
                                        <a href="{{ route('admin.inventory.stock-out.qc', $request->id) }}" class="btn btn-sm btn-info" title="QC Phê Duyệt">
                                            <i class="bx bx-check"></i>
                                        </a>
                                    @elseif ($request->status === 'QC_PASSED')
                                        <form action="{{ route('admin.inventory.stock-out.confirm', $request->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Manager Xác Nhận" onclick="return confirm('Xác nhận xuất kho?')">
                                                <i class="bx bx-check-double"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có yêu cầu nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $batches->links() }}
    </div>
</div>
@endsection
