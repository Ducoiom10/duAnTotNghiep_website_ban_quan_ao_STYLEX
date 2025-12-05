@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-bar-chart"></i> Báo Cáo Hàng Hỏng</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('admin.inventory.defect.index') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Lọc Báo Cáo</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Từ Ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate->toDateString() }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Đến Ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate->toDateString() }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-search"></i> Lọc
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thống Kê Theo Phân Loại</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Phân Loại</th>
                                    <th class="text-end">Số Lượng</th>
                                    <th class="text-end">Tổng Hỏng</th>
                                    <th class="text-end">Chi Phí</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($summary as $item)
                                    <tr>
                                        <td>
                                            @if ($item->classification === 'REWORK')
                                                <span class="badge bg-primary">Sửa Chữa</span>
                                            @elseif ($item->classification === 'B-GRADE')
                                                <span class="badge bg-secondary">Hàng Loại B</span>
                                            @elseif ($item->classification === 'SCRAP')
                                                <span class="badge bg-dark">Tiêu Hủy</span>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ $item->count }}</td>
                                        <td class="text-end">{{ number_format($item->total_qty) }}</td>
                                        <td class="text-end">{{ number_format($item->total_cost ?? 0) }} VNĐ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thống Kê Theo Trạng Thái</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Trạng Thái</th>
                                    <th class="text-end">Số Lượng</th>
                                    <th class="text-end">Tổng Hỏng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byStatus as $item)
                                    <tr>
                                        <td>
                                            @if ($item->status === 'PENDING')
                                                <span class="badge bg-warning">Chờ Đánh Giá</span>
                                            @elseif ($item->status === 'ASSESSED')
                                                <span class="badge bg-info">Đã Đánh Giá</span>
                                            @elseif ($item->status === 'APPROVED')
                                                <span class="badge bg-primary">Đã Phê Duyệt</span>
                                            @elseif ($item->status === 'COMPLETED')
                                                <span class="badge bg-success">Hoàn Thành</span>
                                            @elseif ($item->status === 'REJECTED')
                                                <span class="badge bg-danger">Từ Chối</span>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ $item->count }}</td>
                                        <td class="text-end">{{ number_format($item->total_qty) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thống Kê Theo Mức Độ</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Mức Độ</th>
                                    <th class="text-end">Số Lượng</th>
                                    <th class="text-end">Tổng Hỏng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byLevel as $item)
                                    <tr>
                                        <td>
                                            @if ($item->defect_level === 'LIGHT')
                                                <span class="badge bg-info">Nhẹ</span>
                                            @elseif ($item->defect_level === 'MEDIUM')
                                                <span class="badge bg-warning">Trung Bình</span>
                                            @elseif ($item->defect_level === 'HEAVY')
                                                <span class="badge bg-danger">Nặng</span>
                                            @endif
                                        </td>
                                        <td class="text-end">{{ $item->count }}</td>
                                        <td class="text-end">{{ number_format($item->total_qty) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thống Kê Theo Kho</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kho Hàng</th>
                                    <th class="text-end">Số Lượng</th>
                                    <th class="text-end">Tổng Hỏng</th>
                                    <th class="text-end">Chi Phí</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($byWarehouse as $item)
                                    <tr>
                                        <td>{{ $item->warehouse->name }}</td>
                                        <td class="text-end">{{ $item->count }}</td>
                                        <td class="text-end">{{ number_format($item->total_qty) }}</td>
                                        <td class="text-end">{{ number_format($item->total_cost ?? 0) }} VNĐ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
