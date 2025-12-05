@extends('admin.layouts.app')
@section('title', 'Báo cáo Tồn kho')

@section('content')
<div class="container-fluid">
    <h2 class="h3 mb-3">Báo cáo & Thống kê Kho hàng</h2>

    <form action="{{ route('admin.inventory.reports') }}" method="GET" class="card p-2 mb-3">
        <div class="row g-2">
            <div class="col-md-2">
                <select name="time_range" class="form-select form-select-sm">
                    <option value="7" {{ $timeRange == 7 ? 'selected' : '' }}>7 ngày</option>
                    <option value="30" {{ $timeRange == 30 ? 'selected' : '' }}>30 ngày</option>
                    <option value="90" {{ $timeRange == 90 ? 'selected' : '' }}>90 ngày</option>
                    <option value="365" {{ $timeRange == 365 ? 'selected' : '' }}>1 năm</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="warehouse_id" class="form-select form-select-sm">
                    <option value="">-- Tất cả Kho --</option>
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bx bx-search"></i> Lọc
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.inventory.current-stock') }}" class="btn btn-danger btn-sm w-100">
                    <i class="bx bx-alert"></i> Cảnh báo
                </a>
            </div>
        </div>
    </form>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white py-2">
                    <h6 class="mb-0"><i class="fas fa-rocket"></i> Top 5 Bán chạy</h6>
                </div>
                <div class="card-body p-2">
                    @if ($fastMovingVariants->isEmpty())
                        <div class="alert alert-info mb-0 small">Không có giao dịch.</div>
                    @else
                        <ul class="list-group list-group-flush small">
                            @foreach ($fastMovingVariants as $variant)
                                <li class="list-group-item d-flex justify-content-between py-1">
                                    <span>#{{ $loop->iteration }} {{ $variant->sku }}</span>
                                    <span class="badge bg-success">{{ number_format($variant->total_sold) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white py-2">
                    <h6 class="mb-0"><i class="fas fa-warehouse"></i> Giá trị Tồn kho</h6>
                </div>
                <div class="card-body p-2">
                    @if ($inventoryValueByWarehouse->isEmpty())
                        <div class="alert alert-info mb-0 small">Không có dữ liệu.</div>
                    @else
                        <ul class="list-group list-group-flush small">
                            @foreach ($inventoryValueByWarehouse as $warehouse)
                                <li class="list-group-item d-flex justify-content-between py-1">
                                    <span>{{ $warehouse->name }}</span>
                                    <span class="badge bg-info">{{ number_format($warehouse->total_value) }}₫</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-body { font-size: 0.875rem; }
    .list-group-item { padding: 0.4rem 0.75rem !important; }
</style>
@endsection
