@extends('admin.layouts.app')
@section('title', 'Cài đặt Kho hàng')

@section('content')
<div class="container-fluid">
    <h2 class="h3 mb-3">Cài đặt Kho hàng</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.inventory.settings.update') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="mb-0"><i class="fas fa-warehouse"></i> Cài đặt Kho hàng</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Ngưỡng cảnh báo</label>
                                <input type="number" class="form-control form-control-sm" name="low_stock_threshold"
                                       value="{{ old('low_stock_threshold', $settings['low_stock_threshold'] ?? 10) }}" min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phương pháp tính giá vốn</label>
                                <select class="form-select form-select-sm" name="costing_method">
                                    <option value="fifo" {{ ($settings['costing_method'] ?? 'fifo') == 'fifo' ? 'selected' : '' }}>FIFO</option>
                                    <option value="lifo" {{ ($settings['costing_method'] ?? 'fifo') == 'lifo' ? 'selected' : '' }}>LIFO</option>
                                    <option value="average" {{ ($settings['costing_method'] ?? 'fifo') == 'average' ? 'selected' : '' }}>Trung bình</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="allow_negative_stock" name="allow_negative_stock" value="1"
                                           {{ ($settings['allow_negative_stock'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="allow_negative_stock">Cho phép tồn kho âm</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_reorder" name="auto_reorder" value="1"
                                           {{ ($settings['auto_reorder'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="auto_reorder">Tự động đặt hàng</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="low_stock_notifications" name="low_stock_notifications" value="1"
                                           {{ ($settings['low_stock_notifications'] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="low_stock_notifications">Thông báo tồn kho thấp</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="negative_stock_notifications" name="negative_stock_notifications" value="1"
                                           {{ ($settings['negative_stock_notifications'] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="negative_stock_notifications">Thông báo tồn kho âm</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-info text-white py-2">
                        <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Thống kê</h6>
                    </div>
                    <div class="card-body p-2 small">
                        @php
                            $totalVariants = \App\Models\ProductVariant::count();
                            $lowStockThreshold = (int)($settings['low_stock_threshold'] ?? 10);
                            $lowStockCount = 0;
                            $outOfStockCount = 0;
                            
                            foreach (\App\Models\ProductVariant::get() as $variant) {
                                $stock = \App\Services\StockService::getVariantTotalStock($variant->id);
                                if ($stock == 0) $outOfStockCount++;
                                elseif ($stock <= $lowStockThreshold) $lowStockCount++;
                            }
                        @endphp
                        <p class="mb-1"><strong>Tổng sản phẩm:</strong> {{ $totalVariants }}</p>
                        <p class="mb-1"><strong>Còn hàng:</strong> {{ $totalVariants - $outOfStockCount }}</p>
                        <p class="mb-1"><strong>Hết hàng:</strong> {{ $outOfStockCount }}</p>
                        <p class="mb-0"><strong>Tồn kho thấp:</strong> 
                            <span class="badge bg-warning">{{ $lowStockCount }}</span>
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-save"></i> Lưu
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
