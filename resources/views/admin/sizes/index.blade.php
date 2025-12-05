@extends('admin.layouts.app')
@section('title', 'Quản lí kích thước')
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

        .size-table th,
        .size-table td {
            vertical-align: middle;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí kích thước</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Thuộc tính sản phẩm</a></li>
                        <li class="breadcrumb-item">Quản lí kích thước</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Thống kê kích thước -->
    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-ruler-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số kích thước</h5>
                    <h3 class="card-text fw-bold">{{ $sizes->total() ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Kích thước hoạt động</h5>
                    <h3 class="card-text fw-bold text-success">{{ $sizes->where('status', 1)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning">
                        <i class="ri-pause-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Kích thước không hoạt động</h5>
                    <h3 class="card-text fw-bold text-warning">{{ $sizes->where('status', 0)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card parent-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-info">
                        <i class="ri-ruler-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Có mô tả</h5>
                    <h3 class="card-text fw-bold text-info">{{ $sizes->whereNotNull('description')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Danh sách kích thước</h4>
                    <a href="{{ route('admin.sizes.create') }}" class="btn btn-success add-btn">
                        <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg size-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên kích thước</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $stt = ($sizes->currentPage() - 1) * $sizes->perPage(); @endphp
                                @forelse($sizes as $size)
                                <tr>
                                    <td>{{ ++$stt }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="ri-ruler-line me-2 text-primary"></i>
                                            <span class="fw-medium">{{ $size->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($size->description)
                                            <span class="text-muted">{{ Str::limit($size->description, 50) }}</span>
                                        @else
                                            <span class="text-muted">Chưa có mô tả</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($size->status == 1)
                                            <span class="badge bg-success">Hoạt động</span>
                                        @else
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.sizes.edit', $size) }}" class="btn btn-sm btn-warning me-1" title="Sửa">
                                            <i class="ri-edit-box-line"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.sizes.destroy', $size) }}" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa kích thước này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="ri-delete-bin-7-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Chưa có kích thước nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($sizes->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $sizes->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection