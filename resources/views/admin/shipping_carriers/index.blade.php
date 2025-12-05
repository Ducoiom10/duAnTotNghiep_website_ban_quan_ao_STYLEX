@extends('admin.layouts.app')

@section('content')
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
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Quản lý hãng vận chuyển</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Vận chuyển</a></li>
                    <li class="breadcrumb-item">Danh sách hãng</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row cursor-pointer">
    <div class="col-12 col-sm-6 col-md-3 mb-3">
        <div class="card stats-card total-card">
            <div class="card-body text-center">
                <div class="stat-icon text-primary">
                    <i class="ri-truck-line"></i>
                </div>
                <h5 class="card-title text-muted mb-2">Tổng số hãng</h5>
                <h3 class="card-text fw-bold">{{ $carriers->total() ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 mb-3">
        <div class="card stats-card approved-card">
            <div class="card-body text-center">
                <div class="stat-icon text-success">
                    <i class="ri-checkbox-circle-line"></i>
                </div>
                <h5 class="card-title text-muted mb-2">Đang hoạt động</h5>
                <h3 class="card-text fw-bold text-success">{{ $carriers->where('active', true)->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <form class="d-flex gap-2" method="GET" action="{{ route('admin.shipping_carriers.index') }}">
                <input type="text" class="form-control" name="q" value="{{ $q }}"
                    placeholder="Tìm theo tên hãng...">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i> Tìm
                </button>
            </form>
            <a href="{{ route('admin.shipping_carriers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm hãng vận chuyển
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table align-middle table-nowrap">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên hãng</th>
                        <th>Phí ship</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $stt = ($carriers->currentPage() - 1) * $carriers->perPage(); @endphp
                    @forelse($carriers as $item)
                    <tr>
                        <td>{{ ++$stt }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->fee ?? 0, 0, ',', '.') }} ₫</td>
                        <td>
                            @if($item->active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-danger">Không hoạt động</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-warning"
                                href="{{ route('admin.shipping_carriers.edit', $item) }}">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <form class="d-inline" method="POST"
                                action="{{ route('admin.shipping_carriers.destroy', $item) }}"
                                onsubmit="return confirm('Xóa hãng vận chuyển này?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Không có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $carriers->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection