@extends('admin.layouts.app')

@section('title', 'Quản lý Hạng thành viên')

@push('page-css')
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 150px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý hạng thành viên</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Hạng thành viên</a></li>
                        <li class="breadcrumb-item">Danh sách hạng</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-vip-crown-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số hạng</h5>
                    <h3 class="card-text fw-bold">{{ $tierStats['total_tiers'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-user-star-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng thành viên có hạng</h5>
                    <h3 class="card-text fw-bold text-success">{{ $tierStats['total_members'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning">
                        <i class="ri-coin-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Ngưỡng tối thiểu thấp nhất</h5>
                    <h3 class="card-text fw-bold text-warning">{{ number_format($tierStats['min_min_spend'] ?? 0, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card rejected-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-danger">
                        <i class="ri-discount-percent-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Giảm giá TB (%)</h5>
                    <h3 class="card-text fw-bold text-danger">{{ number_format($tierStats['avg_discount'] ?? 0, 2) }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Danh sách hạng</h4>
                    <a href="{{ route('admin.loyalty-tiers.create') }}" class="btn btn-success add-btn">
                        <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Hạng</th>
                                    <th>Ngưỡng Chi tiêu (VNĐ)</th>
                                    <th>Giảm giá (%)</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiers as $tier)
                                    <tr>
                                        <td>{{ $loop->iteration + ($tiers->currentPage() - 1) * $tiers->perPage() }}</td>
                                        <td>{{ $tier->name }}</td>
                                        <td>{{ number_format($tier->min_spend_required, 0, ',', '.') }}</td>
                                        <td>{{ number_format($tier->discount_rate, 2) }}%</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.loyalty-tiers.edit', $tier) }}" class="btn btn-sm btn-warning" title="Sửa">
                                                    <span class="ri-edit-box-line"></span>
                                                </a>
                                                <form action="{{ route('admin.loyalty-tiers.destroy', $tier) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa hạng {{ $tier->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                        <span class="ri-delete-bin-7-line"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <div class="pagination-wrap hstack gap-2">
            @if ($tiers->onFirstPage())
                <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
            @else
                <a class="page-item pagination-prev" href="{{ $tiers->previousPageUrl() }}">Previous</a>
            @endif

            <ul class="pagination listjs-pagination mb-0">
                @foreach ($tiers->getUrlRange(1, $tiers->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $tiers->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
            </ul>

            @if ($tiers->hasMorePages())
                <a class="page-item pagination-next" href="{{ $tiers->nextPageUrl() }}">Next</a>
            @else
                <a class="page-item pagination-next disabled" href="javascript:void(0);">Next</a>
            @endif
        </div>
    </div>
@endsection
