@extends('admin.layouts.app')
@section('title', 'Quản lý đơn hàng')

@push('page-css')
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .stat-card {
            border-radius: 18px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            padding: 18px 22px;
            height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all .25s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px -15px rgba(15, 23, 42, 0.4);
        }
        .stat-card .stat-label {
            font-size: 13px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #94a3b8;
        }
        .stat-card .stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
        }
        .stat-trend {
            font-size: 13px;
        }
        #filterForm {
            position: relative;
            z-index: 10;
            background-color: #fff;
            border-top: 1px solid #e2e8f0;
            margin-top: 5px;
            padding: 18px;
        }
        .order-table thead th {
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #94a3b8;
            border-bottom: none;
        }
        .order-table tbody td {
            vertical-align: middle;
        }
        .badge-dot {
            position: relative;
            padding-left: 14px;
        }
        .badge-dot::before {
            content: '';
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            left: 4px;
            top: 50%;
            transform: translateY(-50%);
        }
        .badge-dot.bg-pending::before { background: #f59e0b; }
        .badge-dot.bg-processing::before { background: #3b82f6; }
        .badge-dot.bg-completed::before { background: #10b981; }
        .badge-dot.bg-cancelled::before { background: #ef4444; }
        .timeline-step {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
        }
        .timeline-step .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #cbd5f5;
        }
        .timeline-step.active .dot {
            background: #2563eb;
            box-shadow: 0 0 0 6px rgba(37, 99, 235, .15);
        }
        .order-detail-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: .08em;
        }
        .order-detail-value {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }
        .product-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
        }
        .status-pill {
            border-radius: 20px;
            font-weight: 600;
            padding: 6px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }
        .status-pill.status-pending { background: #fff7ed; color: #c2410c; }
        .status-pill.status-processing { background: #eff6ff; color: #1d4ed8; }
        .status-pill.status-shipping { background: #e0f2fe; color: #0369a1; }
        .status-pill.status-completed { background: #ecfdf5; color: #059669; }
        .status-pill.status-cancelled { background: #fef2f2; color: #b91c1c; }
        .status-pill.status-returned { background: #fef3c7; color: #92400e; }
        .btn-icon {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
        }
        .status-menu {
            min-width: 280px;
            padding: 4px;
        }
        .status-menu .dropdown-item {
            border-radius: 10px;
            padding: 10px 14px;
            gap: 10px;
        }
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-top: 6px;
        }
        .status-dot.status-pending { background: #fb923c; }
        .status-dot.status-processing { background: #3b82f6; }
        .status-dot.status-shipping { background: #0ea5e9; }
        .status-dot.status-completed { background: #22c55e; }
        .status-dot.status-cancelled { background: #ef4444; }
        .status-dot.status-returned { background: #f97316; }
        .status-action.disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
@endpush

@section('content')
    @php
        $statusStyles = [
            'pending' => [
                'label' => 'Chờ xác nhận',
                'class' => 'text-warning',
                'icon' => 'ri-time-line',
                'pill' => 'status-pending',
                'desc' => 'Đơn mới, chờ nhân viên xác nhận'
            ],
            'processing' => [
                'label' => 'Đang xử lý',
                'class' => 'text-primary',
                'icon' => 'ri-loader-4-line',
                'pill' => 'status-processing',
                'desc' => 'Đang chuẩn bị & đóng gói tại kho'
            ],
            'shipping' => [
                'label' => 'Chờ giao hàng',
                'class' => 'text-info',
                'icon' => 'ri-truck-line',
                'pill' => 'status-shipping',
                'desc' => 'Đã bàn giao cho đơn vị vận chuyển'
            ],
            'completed' => [
                'label' => 'Hoàn thành',
                'class' => 'text-success',
                'icon' => 'ri-check-double-line',
                'pill' => 'status-completed',
                'desc' => 'Đơn đã giao thành công'
            ],
            'cancelled' => [
                'label' => 'Đã hủy',
                'class' => 'text-danger',
                'icon' => 'ri-close-line',
                'pill' => 'status-cancelled',
                'desc' => 'Đơn bị hủy theo yêu cầu'
            ],
            'returned' => [
                'label' => 'Trả hàng/Hoàn tiền',
                'class' => 'text-warning',
                'icon' => 'ri-refund-2-line',
                'pill' => 'status-returned',
                'desc' => 'Đơn đã được trả lại hoặc hoàn tiền'
            ],
        ];
        // Quy tắc chuyển trạng thái hợp lệ
        $statusTransitions = [
            'pending' => ['pending', 'processing', 'cancelled'],
            'processing' => ['processing', 'shipping', 'cancelled'],
            'shipping' => ['shipping', 'completed', 'returned'],
            'completed' => ['completed'],
            'cancelled' => ['cancelled'],
            'returned' => ['returned'],
        ];
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý đơn hàng</h4>
            </div>
        </div>
    </div>

    @php
        $totalOrders = $orderStats->total_orders ?? 0;
        $processingCount = ($orderStats->processing_orders ?? 0) + ($orderStats->shipping_orders ?? 0);
        $processingPercent = $totalOrders > 0
            ? max(5, min(100, ($processingCount / max(1, $totalOrders)) * 100))
            : 0;
        $completionPercent = $totalOrders > 0
            ? round((($orderStats->completed_orders ?? 0) / max(1, $totalOrders)) * 100)
            : 0;
    @endphp

    {{-- 🧮 Thống kê --}}
    <div class="row cursor-pointer">
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-white">
                <span class="stat-label">Tổng đơn</span>
                <span class="stat-value">{{ $orderStats->total_orders ?? 0 }}</span>
                <span class="stat-trend text-muted"><i class="ri-arrow-up-line text-success"></i> so với tuần trước</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-white">
                <span class="stat-label">Đang xử lý / Giao hàng</span>
                <span class="stat-value text-warning">{{ $processingCount }}</span>
                <div class="progress progress-sm mt-2" style="height: 6px;">
                    <div class="progress-bar bg-warning" role="progressbar"
                        style="<?php echo 'width: ' . $processingPercent . '%'; ?>"
                        aria-valuenow="{{ $processingPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-white">
                <span class="stat-label">Hoàn tất</span>
                <span class="stat-value text-success">{{ $orderStats->completed_orders ?? 0 }}</span>
                <span class="stat-trend text-success"><i class="ri-check-line me-1"></i>Tỉ lệ hoàn tất
                    {{ $completionPercent }}%</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card bg-white">
                <span class="stat-label">Bị hủy / Hoàn tiền</span>
                <span class="stat-value text-danger">{{ ($orderStats->cancelled_orders ?? 0) + ($orderStats->returned_orders ?? 0) }}</span>
                <span class="stat-trend text-muted"><i class="ri-alert-line text-danger"></i> Cần xử lý nhanh</span>
            </div>
        </div>
    </div>

    {{-- 🔎 Bộ lọc --}}
    <div class="card">
        <div class="card-header d-flex flex-wrap gap-2 align-items-center justify-content-between">
            <div>
                <h4 class="card-title mb-0">Danh sách đơn hàng</h4>
                <span class="text-muted small">Theo dõi trạng thái và dòng tiền theo thời gian thực</span>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary btn-sm" id="toggleFilterBtn">
                    <i class="ri-filter-3-line"></i> Bộ lọc
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="ri-printer-line"></i> In báo cáo
                </button>
            </div>
        </div>

        {{-- Form lọc --}}
        <div class="card-body" id="filterForm" style="display: none;">
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tìm nhanh</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Tên, email hoặc mã đơn">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Mã đơn</label>
                        <input type="text" name="code" value="{{ request('code') }}" class="form-control"
                            placeholder="VD: STX-0001">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tên khách hàng</label>
                        <input type="text" name="full_name" value="{{ request('full_name') }}" class="form-control"
                            placeholder="VD: Trần Minh">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Trạng thái đơn</label>
                        <select name="status" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Chờ giao hàng</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Trả hàng/Hoàn tiền</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Trạng thái thanh toán</label>
                        <select name="payment_status" class="form-select">
                            <option value="">-- Tất cả --</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán
                            </option>
                            <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán
                            </option>
                            <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Hoàn tiền
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Từ ngày</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Đến ngày</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="d-flex w-100 gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="ri-search-line"></i> Lọc
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-soft-secondary">
                                <i class="ri-refresh-line"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        {{-- 📋 Danh sách --}}
        <div class="card-body">
            @php
                $totalActive   = $activeOrders->total();
                $totalArchived = $archivedOrders->total();
                $totalAll      = $totalActive + $totalArchived;
            @endphp

            {{-- Thanh trạng thái + chọn kích thước trang --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div class="text-muted small">
                    @if ($totalAll > 0)
                        <span class="me-3">Tổng: {{ $totalAll }} đơn</span>
                        <span class="badge bg-warning-subtle text-warning me-2">
                            Đang xử lý / giao hàng: {{ $totalActive }}
                        </span>
                        <span class="badge bg-success-subtle text-success">
                            Hoàn thành / hủy / hoàn tiền: {{ $totalArchived }}
                        </span>
                    @else
                        Không có đơn hàng nào khớp bộ lọc
                    @endif
                </div>
                <form method="GET" class="d-inline-flex align-items-center gap-2">
                    @foreach (request()->except('per_page', 'page') as $key => $value)
                        @if (is_array($value))
                            @foreach ($value as $item)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <label for="per_page" class="text-muted small mb-0">Hiển thị</label>
                    <select name="per_page" id="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach ([10, 20, 50, 100] as $size)
                            <option value="{{ $size }}" {{ (int) request('per_page', 10) === $size ? 'selected' : '' }}>
                                {{ $size }} đơn / trang
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- Tabs: chia 2 nhóm đơn hàng để đỡ rối giao diện --}}
            <ul class="nav nav-pills mb-3" id="orderTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-active-orders"
                            data-bs-toggle="tab" data-bs-target="#pane-active-orders"
                            type="button" role="tab" aria-controls="pane-active-orders" aria-selected="true">
                        Đang xử lý / giao hàng ({{ $totalActive }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-archived-orders"
                            data-bs-toggle="tab" data-bs-target="#pane-archived-orders"
                            type="button" role="tab" aria-controls="pane-archived-orders" aria-selected="false">
                        Hoàn thành / hủy / hoàn tiền ({{ $totalArchived }})
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="orderTabsContent">
                @php
                    $activeStatuses = ['pending', 'processing', 'shipping'];
                    $archivedStatuses = ['completed', 'delivered', 'cancelled', 'returned'];
                @endphp

                {{-- TAB 1: Đơn đang xử lý / giao hàng --}}
                <div class="tab-pane fade show active" id="pane-active-orders" role="tabpanel" aria-labelledby="tab-active-orders">
                    <div class="table-responsive table-card">
                        <table class="table align-middle text-center table-nowrap order-table">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Thanh toán</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ($activeOrders as $order)
                                @php
                                    $paymentStatusClass = match ($order->payment_status) {
                                        'paid' => 'bg-success-subtle text-success',
                                        'unpaid' => 'bg-warning-subtle text-warning',
                                        'refunded' => 'bg-info-subtle text-info',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                    $detailPayload = [
                                        'id' => $order->id,
                                        'code' => $order->code,
                                        'full_name' => $order->full_name,
                                        'email' => $order->email,
                                        'phone' => $order->phone,
                                        'address' => $order->address,
                                        'total' => number_format($order->total, 0, ',', '.'),
                                        'status' => $order->status,
                                        'payment_status' => $order->payment_status,
                                        'payment_method' => strtoupper($order->payment_method ?? 'COD'),
                                        'created_at' => $order->created_at ? $order->created_at->format('d/m/Y H:i') : '',
                                        'updated_at' => $order->updated_at ? $order->updated_at->format('d/m/Y H:i') : '',
                                        'notes' => $order->note ?? 'Không có ghi chú',
                                        'items' => $order->items->map(function ($item) {
                                            return [
                                                'name' => $item->product->name ?? 'Sản phẩm',
                                                'sku' => $item->product->sku ?? 'N/A',
                                                'quantity' => $item->quantity,
                                                'price' => number_format($item->price ?? 0, 0, ',', '.'),
                                                'total' => number_format(($item->price ?? 0) * $item->quantity, 0, ',', '.'),
                                                'image' => $item->product->default_image_url ?? asset('client/images/product-01.jpg'),
                                            ];
                                        })->values()->all(),
                                    ];
                                        $currentStatusKey = $order->status ?? 'pending';
                                        $currentStatus = $statusStyles[$currentStatusKey] ?? $statusStyles['pending'];
                                        $allowedStatuses = $statusTransitions[$currentStatusKey] ?? [$currentStatusKey];
                                @endphp
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->code }}</td>
                                    <td class="text-start">
                                        <div class="fw-bold">{{ $order->full_name }}</div>
                                        <small class="text-muted">{{ $order->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-dark text-body">
                                            {{ $order->items->count() }} sản phẩm
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-primary">{{ number_format($order->total) }}₫</td>
                                    <td>
                                        <span class="badge {{ $paymentStatusClass }}">
                                            {{ ucfirst($order->payment_status ?? 'N/A') }}
                                        </span>
                                        <div class="small text-muted">
                                            {{ strtoupper($order->payment_method ?? 'COD') }}
                                        </div>
                                    </td>
                                    <td>
                                            <div class="status-control d-inline-flex align-items-center gap-2"
                                                 data-order-id="{{ $order->id }}"
                                                 data-current="{{ $currentStatusKey }}">
                                                <span class="status-pill {{ $currentStatus['pill'] }}">
                                                    <i class="{{ $currentStatus['icon'] }} me-1"></i>
                                                    {{ $currentStatus['label'] }}
                                                </span>
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-icon btn-sm status-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-arrow-down-s-line"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end status-menu">
                                                        @foreach ($statusStyles as $key => $option)
                                                            @php
                                                                $isActive = $currentStatusKey === $key;
                                                                $disabled = !in_array($key, $allowedStatuses, true);
                                                            @endphp
                                                            <button type="button"
                                                                    class="dropdown-item status-action d-flex justify-content-between align-items-start {{ $isActive ? 'active' : '' }} {{ $disabled ? 'disabled' : '' }}"
                                                                    data-status="{{ $key }}">
                                                                <span class="d-flex gap-2">
                                                                    <span class="status-dot {{ $option['pill'] }}"></span>
                                                                    <span>
                                                                        <span class="fw-semibold d-block">{{ $option['label'] }}</span>
                                                                        <small class="text-muted">{{ $option['desc'] }}</small>
                                                                    </span>
                                                                </span>
                                                                <i class="ri-check-line status-check {{ $isActive ? '' : 'opacity-0' }}"></i>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-soft-primary view-order-detail"
                                                        data-order='@json($detailPayload)'>
                                                    <i class="ri-file-text-line"></i>
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary"
                                                        onclick="window.print()">
                                                    <i class="ri-printer-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-muted">Không có đơn hàng đang xử lý / giao hàng trên trang này.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Phân trang TAB 1 --}}
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                        <div class="text-muted small">
                            Trang: {{ $activeOrders->currentPage() }} / {{ $activeOrders->lastPage() }}
                        </div>
                        <div>
                            {{ $activeOrders->onEachSide(1)->appends(request()->except('active_page', 'page'))->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

                {{-- TAB 2: Đơn hoàn thành / hủy / hoàn tiền --}}
                <div class="tab-pane fade" id="pane-archived-orders" role="tabpanel" aria-labelledby="tab-archived-orders">
                    <div class="table-responsive table-card">
                        <table class="table align-middle text-center table-nowrap order-table">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Cập nhật</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($archivedOrders as $order)
                                    @php
                                        $paymentStatusClass = match ($order->payment_status) {
                                            'paid' => 'bg-success-subtle text-success',
                                            'unpaid' => 'bg-warning-subtle text-warning',
                                            'refunded' => 'bg-info-subtle text-info',
                                            default => 'bg-secondary-subtle text-secondary'
                                        };
                                        $detailPayload = [
                                            'id' => $order->id,
                                            'code' => $order->code,
                                            'full_name' => $order->full_name,
                                            'email' => $order->email,
                                            'phone' => $order->phone,
                                            'address' => $order->address,
                                            'total' => number_format($order->total, 0, ',', '.'),
                                            'status' => $order->status,
                                            'payment_status' => $order->payment_status,
                                            'payment_method' => strtoupper($order->payment_method ?? 'COD'),
                                            'created_at' => $order->created_at ? $order->created_at->format('d/m/Y H:i') : '',
                                            'updated_at' => $order->updated_at ? $order->updated_at->format('d/m/Y H:i') : '',
                                            'notes' => $order->note ?? 'Không có ghi chú',
                                            'items' => $order->items->map(function ($item) {
                                                return [
                                                    'name' => $item->product->name ?? 'Sản phẩm',
                                                    'sku' => $item->product->sku ?? 'N/A',
                                                    'quantity' => $item->quantity,
                                                    'price' => number_format($item->price ?? 0, 0, ',', '.'),
                                                    'total' => number_format(($item->price ?? 0) * $item->quantity, 0, ',', '.'),
                                                    'image' => $item->product->default_image_url ?? asset('client/images/product-01.jpg'),
                                                ];
                                            })->values()->all(),
                                        ];
                                            $currentStatusKey = $order->status ?? 'pending';
                                            $currentStatus = $statusStyles[$currentStatusKey] ?? $statusStyles['pending'];
                                            $allowedStatuses = $statusTransitions[$currentStatusKey] ?? [$currentStatusKey];
                                        @endphp
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->code }}</td>
                                        <td class="text-start">
                                            <div class="fw-bold">{{ $order->full_name }}</div>
                                            <small class="text-muted">{{ $order->email }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-dark text-body">
                                                {{ $order->items->count() }} sản phẩm
                                            </span>
                                        </td>
                                        <td class="fw-semibold text-primary">{{ number_format($order->total) }}₫</td>
                                        <td>
                                            <span class="badge {{ $paymentStatusClass }}">
                                                {{ ucfirst($order->payment_status ?? 'N/A') }}
                                            </span>
                                            <div class="small text-muted">
                                                {{ strtoupper($order->payment_method ?? 'COD') }}
                                            </div>
                                        </td>
                                        <td>
                                        <div class="status-control d-inline-flex align-items-center gap-2"
                                            data-order-id="{{ $order->id }}"
                                            data-current="{{ $currentStatusKey }}">
                                            <span class="status-pill {{ $currentStatus['pill'] }}">
                                                <i class="{{ $currentStatus['icon'] }} me-1"></i>
                                                {{ $currentStatus['label'] }}
                                            </span>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-icon btn-sm status-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-arrow-down-s-line"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end status-menu">
                                                    @foreach ($statusStyles as $key => $option)
                                                        @php
                                                            $isActive = $currentStatusKey === $key;
                                                            $disabled = !in_array($key, $allowedStatuses, true);
                                                        @endphp
                                                        <button type="button"
                                                            class="dropdown-item status-action d-flex justify-content-between align-items-start {{ $isActive ? 'active' : '' }} {{ $disabled ? 'disabled' : '' }}"
                                                            data-status="{{ $key }}">
                                                            <span class="d-flex gap-2">
                                                                <span class="status-dot {{ $option['pill'] }}"></span>
                                                                <span>
                                                                    <span class="fw-semibold d-block">{{ $option['label'] }}</span>
                                                                    <small class="text-muted">{{ $option['desc'] }}</small>
                                                                </span>
                                                            </span>
                                                            <i class="ri-check-line status-check {{ $isActive ? '' : 'opacity-0' }}"></i>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-soft-primary view-order-detail"
                                                data-order='@json($detailPayload)'>
                                                <i class="ri-file-text-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-soft-secondary"
                                                onclick="window.print()">
                                                <i class="ri-printer-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-muted">Không có đơn hàng hoàn thành / đã hủy trên trang này.</td>
                                    </tr>
                                @endforelse
                        </tbody>
                    </table>
            </div>

                    {{-- Phân trang TAB 2 --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                <div class="text-muted small">
                            Trang: {{ $archivedOrders->currentPage() }} / {{ $archivedOrders->lastPage() }}
                </div>
                <div>
                            {{ $archivedOrders->onEachSide(1)->appends(request()->except('archived_page', 'page'))->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                        <small class="text-muted">Theo dõi trạng thái xử lý theo thời gian thực</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="mb-3">
                                    <div class="order-detail-label">Mã đơn hàng</div>
                                    <div class="order-detail-value" id="detailCode">#</div>
                                </div>
                                <div class="mb-3">
                                    <div class="order-detail-label">Khách hàng</div>
                                    <div class="order-detail-value" id="detailCustomer">-</div>
                                    <div class="text-muted" id="detailEmail">-</div>
                                    <div class="text-muted" id="detailPhone">-</div>
                                </div>
                                <div class="mb-3">
                                    <div class="order-detail-label">Địa chỉ giao hàng</div>
                                    <div class="text-body" id="detailAddress">-</div>
                                </div>
                                <div class="mb-3">
                                    <div class="order-detail-label">Thanh toán</div>
                                    <div class="order-detail-value" id="detailPaymentStatus">-</div>
                                    <div class="text-muted" id="detailPaymentMethod">-</div>
                                </div>
                                <div>
                                    <div class="order-detail-label">Ghi chú</div>
                                    <div class="text-body" id="detailNotes">-</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="border rounded-3 p-3 mb-3">
                                <div class="order-detail-label">Trạng thái xử lý</div>
                                <div class="timeline-step" data-step="pending">
                                    <span class="dot"></span>
                                    <div>
                                        <div class="fw-semibold">Chờ xác nhận</div>
                                        <small class="text-muted">Đang đợi xác nhận từ nhân viên CSKH</small>
                                    </div>
                                </div>
                                <div class="timeline-step" data-step="processing">
                                    <span class="dot"></span>
                                    <div>
                                        <div class="fw-semibold">Đang xử lý</div>
                                        <small class="text-muted">Chuẩn bị hàng & đóng gói</small>
                                    </div>
                                </div>
                                <div class="timeline-step" data-step="completed">
                                    <span class="dot"></span>
                                    <div>
                                        <div class="fw-semibold">Hoàn tất</div>
                                        <small class="text-muted">Đơn đã giao thành công</small>
                                    </div>
                                </div>
                                <div class="timeline-step" data-step="cancelled">
                                    <span class="dot"></span>
                                    <div>
                                        <div class="fw-semibold text-danger">Đã hủy</div>
                                        <small class="text-muted">Đơn hàng bị hủy theo yêu cầu</small>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded-3 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <div class="order-detail-label">Danh sách sản phẩm</div>
                                        <div class="order-detail-value" id="detailTotal">-</div>
                                    </div>
                                    <span class="badge bg-soft-primary" id="detailCreatedAt">-</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>SL</th>
                                                <th>Giá</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailItems">
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Không có dữ liệu</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer print-hidden">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="printOrderDetail()">In phiếu giao hàng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateStatus(orderId, status) {
            const url = "{{ route('admin.orders.updateStatus', ':id') }}".replace(':id', orderId);
            return fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status })
            })
                .then(res => res.json())
                .then(data => {
                    toastr.success(data.message);
                    return data;
                })
                .catch(err => {
                    toastr.error('Lỗi khi cập nhật trạng thái đơn hàng!');
                    console.error(err);
                    throw err;
                });
        }

        function printOrderDetail() {
            const modal = document.getElementById('orderDetailModal');
            if (!modal) return;
            const printable = modal.querySelector('.modal-content');
            if (!printable) return;

            const clone = printable.cloneNode(true);
            clone.querySelectorAll('.print-hidden').forEach(el => el.remove());

            const wrapper = document.createElement('div');
            wrapper.appendChild(clone);

            const styleLinks = Array.from(document.querySelectorAll('link[rel="stylesheet"], style'))
                .map(el => el.outerHTML)
                .join('\n');

            const inlinePrintCss = `
                <style>
                    body { font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif; margin: 32px; color: #0f172a; }
                    .modal-dialog { max-width: 100%; }
                    .modal-content { box-shadow: none; border: none; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { padding: 8px 6px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
                    th { text-transform: uppercase; letter-spacing: .05em; font-size: 12px; color: #94a3b8; }
                    .status-pill { font-size: 13px; }
                </style>
            `;

            const printWindow = window.open('', '', 'width=900,height=650');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Chi tiết đơn hàng</title>
                        ${styleLinks}
                        ${inlinePrintCss}
                    </head>
                    <body>${wrapper.innerHTML}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>
    <script>
        const detailModalEl = document.getElementById('orderDetailModal');
        const detailModal = detailModalEl ? new bootstrap.Modal(detailModalEl) : null;
        function resetTimeline(status) {
            document.querySelectorAll('.timeline-step').forEach(step => {
                step.classList.remove('active');
                if (step.dataset.step === status || (status === 'cancelled' && step.dataset.step === 'cancelled')) {
                    step.classList.add('active');
                } else if (status === 'completed' && (step.dataset.step === 'pending' || step.dataset.step === 'processing' || step.dataset.step === 'completed')) {
                    step.classList.add('active');
                } else if (status === 'processing' && (step.dataset.step === 'pending' || step.dataset.step === 'processing')) {
                    step.classList.add('active');
                }
            });
        }
        const statusMeta = {
            pending:   { label: 'Chờ xác nhận', class: 'text-warning', icon: 'ri-time-line',        pill: 'status-pending',   desc: 'Đơn mới, chờ nhân viên xác nhận' },
            processing:{ label: 'Đang xử lý',   class: 'text-primary', icon: 'ri-loader-4-line',    pill: 'status-processing',desc: 'Đang chuẩn bị & đóng gói tại kho' },
            shipping:  { label: 'Chờ giao hàng',class: 'text-info',    icon: 'ri-truck-line',       pill: 'status-shipping',  desc: 'Đã bàn giao cho đơn vị vận chuyển' },
            completed: { label: 'Hoàn thành',   class: 'text-success', icon: 'ri-check-double-line',pill: 'status-completed', desc: 'Đơn đã giao thành công' },
            cancelled: { label: 'Đã hủy',       class: 'text-danger',  icon: 'ri-close-line',       pill: 'status-cancelled', desc: 'Đơn bị hủy theo yêu cầu' },
            returned:  { label: 'Trả hàng/Hoàn tiền', class: 'text-warning', icon: 'ri-refund-2-line', pill: 'status-returned', desc: 'Đơn đã được trả lại hoặc hoàn tiền' },
        };

        const statusTransitions = {
            pending:   ['pending', 'processing', 'cancelled'],
            processing:['processing', 'shipping', 'cancelled'],
            shipping:  ['shipping', 'completed', 'returned'],
            completed: ['completed'],
            cancelled: ['cancelled'],
            returned:  ['returned'],
        };

        function applyStatusUI(control, status) {
            const meta = statusMeta[status] || statusMeta.pending;
            const allowed = statusTransitions[status] || [status];
            control.dataset.current = status;
            control.dataset.allowed = JSON.stringify(allowed);

            const pill = control.querySelector('.status-pill');
            if (pill) {
                pill.className = `status-pill ${meta.pill}`;
                pill.innerHTML = `<i class="${meta.icon} me-1"></i>${meta.label}`;
            }

            control.querySelectorAll('.status-action').forEach(action => {
                const optionStatus = action.dataset.status;
                const isActive = optionStatus === status;
                const isDisabled = !allowed.includes(optionStatus);
                action.classList.toggle('active', isActive);
                action.classList.toggle('disabled', isDisabled);
                const checkIcon = action.querySelector('.status-check');
                if (checkIcon) {
                    checkIcon.classList.toggle('opacity-0', !isActive);
                }
            });
        }

        document.querySelectorAll('.status-control').forEach(control => {
            const current = control.dataset.current || 'pending';
            applyStatusUI(control, current);

            control.querySelectorAll('.status-action').forEach(action => {
                action.addEventListener('click', () => {
                    const targetStatus = action.dataset.status;
                    const allowed = JSON.parse(control.dataset.allowed || '[]');
                    const currentStatus = control.dataset.current || 'pending';
                    if (!allowed.includes(targetStatus) || targetStatus === currentStatus) {
                        return;
                    }

                    const toggleBtn = control.querySelector('.status-toggle');
                    toggleBtn && (toggleBtn.disabled = true);

                    updateStatus(control.dataset.orderId, targetStatus)
                        .then(() => {
                            applyStatusUI(control, targetStatus);
                            if (toggleBtn) {
                                const dropdownInstance = bootstrap.Dropdown.getInstance(toggleBtn);
                                dropdownInstance && dropdownInstance.hide();
                            }
                        })
                        .finally(() => {
                            toggleBtn && (toggleBtn.disabled = false);
                        });
                });
            });
        });

        document.querySelectorAll('.view-order-detail').forEach(btn => {
            btn.addEventListener('click', () => {
                const data = JSON.parse(btn.dataset.order);
                document.getElementById('detailCode').textContent = data.code;
                document.getElementById('detailCustomer').textContent = data.full_name;
                document.getElementById('detailEmail').textContent = data.email || '—';
                document.getElementById('detailPhone').textContent = data.phone || '—';
                document.getElementById('detailAddress').textContent = data.address || 'Không cung cấp';
                document.getElementById('detailPaymentStatus').textContent = (data.payment_status || 'pending').toUpperCase();
                document.getElementById('detailPaymentMethod').textContent = 'Phương thức: ' + data.payment_method;
                document.getElementById('detailNotes').textContent = data.notes || 'Không có ghi chú';
                document.getElementById('detailCreatedAt').textContent = 'Tạo lúc ' + data.created_at;
                document.getElementById('detailTotal').textContent = 'Tổng: ' + data.total + ' ₫';

                const itemsTbody = document.getElementById('detailItems');
                itemsTbody.innerHTML = '';
                if (!data.items || data.items.length === 0) {
                    itemsTbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Không có sản phẩm</td></tr>';
                } else {
                    data.items.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="text-start">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="${item.image}" class="product-thumb" alt="${item.name}">
                                    <div>
                                        <div class="fw-semibold">${item.name}</div>
                                        <small class="text-muted">SKU: ${item.sku}</small>
                                    </div>
                                </div>
                            </td>
                            <td>x${item.quantity}</td>
                            <td>${item.price} ₫</td>
                            <td class="fw-semibold">${item.total} ₫</td>
                        `;
                        itemsTbody.appendChild(row);
                    });
                }

                resetTimeline(data.status);
                detailModal && detailModal.show();
            });
        });

        const filterBtn = document.getElementById('toggleFilterBtn');
        if (filterBtn) {
            filterBtn.addEventListener('click', () => {
                $('#filterForm').slideToggle(200);
            });
        }
    </script>
@endpush
