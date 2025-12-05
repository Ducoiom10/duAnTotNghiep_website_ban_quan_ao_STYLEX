@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-error-circle"></i> Xử Lý Hàng Hỏng</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.defect.create') }}" class="btn btn-success btn-sm">
                <i class="bx bx-plus"></i> Báo Cáo Hàng Hỏng
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
                <strong>Quy trình Xử Lý Hàng Hỏng:</strong>
                <ol class="mb-0 mt-2 ps-3 small">
                    <li>Báo cáo hàng hỏng: Tạo báo cáo với số lượng và mức độ hỏng</li>
                    <li>Đánh giá: Click "Đánh Giá" khi ở trạng thái "Chờ Đánh Giá" - nhập loại lỗi, mô tả, phân loại</li>
                    <li>Phê duyệt: Click "Phê Duyệt" khi ở trạng thái "Chờ Phê Duyệt" - QC xác nhận</li>
                    <li>Hoàn thành: Click "Hoàn Thành" khi ở trạng thái "Đã Phê Duyệt" - nhập chi phí xử lý</li>
                </ol>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light py-2">
            <h6 class="mb-0">Danh Sách Báo Cáo Hàng Hỏng ({{ $assessments->total() }})</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th class="text-end">Số Lượng</th>
                            <th>Mức Độ</th>
                            <th>Phân Loại</th>
                            <th>Loại Lỗi</th>
                            <th>Trạng Thái</th>
                            <th>Người Báo Cáo</th>
                            <th class="text-end">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assessments as $assessment)
                            <tr>
                                <td>{{ $assessment->variant->product->name ?? 'N/A' }}</td>
                                <td class="text-end"><span class="badge bg-warning">{{ number_format($assessment->quantity) }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $assessment->defect_level === 'LIGHT' ? 'info' : ($assessment->defect_level === 'MEDIUM' ? 'warning' : 'danger') }}">
                                        {{ $assessment->defect_level }}
                                    </span>
                                </td>
                                <td>
                                    @if ($assessment->classification === 'REWORK')
                                        <span class="badge bg-primary">Sửa Chữa</span>
                                    @elseif ($assessment->classification === 'B-GRADE')
                                        <span class="badge bg-secondary">Hàng Loại B</span>
                                    @elseif ($assessment->classification === 'SCRAP')
                                        <span class="badge bg-dark">Tiêu Hủy</span>
                                    @else
                                        <span class="badge bg-light text-dark">-</span>
                                    @endif
                                </td>
                                <td><small>{{ $assessment->defect_type ?? '-' }}</small></td>
                                <td>
                                    @if ($assessment->status === 'PENDING')
                                        <span class="badge bg-secondary">Chờ Đánh Giá</span>
                                    @elseif ($assessment->status === 'ASSESSED')
                                        <span class="badge bg-warning">Chờ Phê Duyệt</span>
                                    @elseif ($assessment->status === 'APPROVED')
                                        <span class="badge bg-info">Đã Phê Duyệt</span>
                                    @elseif ($assessment->status === 'COMPLETED')
                                        <span class="badge bg-success">Hoàn Thành</span>
                                    @elseif ($assessment->status === 'REJECTED')
                                        <span class="badge bg-danger">Từ Chối</span>
                                    @endif
                                </td>
                                <td><small>{{ $assessment->createdBy->name ?? 'N/A' }}</small></td>
                                <td class="text-end">
                                    @if ($assessment->status === 'PENDING')
                                        <a href="{{ route('admin.inventory.defect.assess', $assessment->id) }}" class="btn btn-sm btn-primary" title="Đánh Giá">
                                            <i class="bx bx-check"></i>
                                        </a>
                                    @elseif ($assessment->status === 'ASSESSED')
                                        <a href="{{ route('admin.inventory.defect.assess', $assessment->id) }}" class="btn btn-sm btn-warning" title="Phê Duyệt">
                                            <i class="bx bx-check-double"></i>
                                        </a>
                                    @elseif ($assessment->status === 'APPROVED')
                                        <a href="{{ route('admin.inventory.defect.assess', $assessment->id) }}" class="btn btn-sm btn-success" title="Hoàn Thành">
                                            <i class="bx bx-check-circle"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.inventory.defect.assess', $assessment->id) }}" class="btn btn-sm btn-secondary" title="Xem Chi Tiết">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bx bx-inbox"></i> Không có báo cáo nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $assessments->links() }}
    </div>
</div>
@endsection
