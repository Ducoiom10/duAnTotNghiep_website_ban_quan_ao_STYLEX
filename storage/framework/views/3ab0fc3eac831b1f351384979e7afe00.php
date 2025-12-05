<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Dashboard Kho Hàng</h1>
            <p class="text-muted small mb-0">Quản lý tồn kho và giao dịch kho hàng</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.inventory.logs')); ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-history me-1"></i> Lịch sử
            </a>
        </div>
    </div>

    <!-- Quick Actions Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo e(route('admin.inventory.stock-in.index')); ?>" class="text-decoration-none">
                <div class="card border-0 h-100 shadow-sm hover-lift" style="transition: all 0.3s ease;">
                    <div class="card-body text-center py-3">
                        <div class="mb-2">
                            <i class="bx bx-download" style="font-size: 2rem; color: #0d6efd;"></i>
                        </div>
                        <h6 class="mb-1 fw-semibold">Nhập Kho</h6>
                        <h4 class="mb-0 text-primary"><?php echo e(\App\Models\StockInRequest::where('status', 'PENDING')->count()); ?></h4>
                        <small class="text-muted">Chờ xác nhận</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo e(route('admin.inventory.stock-out.index')); ?>" class="text-decoration-none">
                <div class="card border-0 h-100 shadow-sm hover-lift" style="transition: all 0.3s ease;">
                    <div class="card-body text-center py-3">
                        <div class="mb-2">
                            <i class="bx bx-upload" style="font-size: 2rem; color: #dc3545;"></i>
                        </div>
                        <h6 class="mb-1 fw-semibold">Xuất Kho</h6>
                        <h4 class="mb-0 text-danger"><?php echo e(\App\Models\StockOutRequest::where('status', 'PENDING')->count()); ?></h4>
                        <small class="text-muted">Chờ xác nhận</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo e(route('admin.inventory.transfer.index')); ?>" class="text-decoration-none">
                <div class="card border-0 h-100 shadow-sm hover-lift" style="transition: all 0.3s ease;">
                    <div class="card-body text-center py-3">
                        <div class="mb-2">
                            <i class="bx bx-transfer" style="font-size: 2rem; color: #ffc107;"></i>
                        </div>
                        <h6 class="mb-1 fw-semibold">Chuyển Kho</h6>
                        <h4 class="mb-0 text-warning"><?php echo e(\App\Models\TransferRequest::where('status', 'PENDING')->count()); ?></h4>
                        <small class="text-muted">Chờ xác nhận</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo e(route('admin.inventory.count.index')); ?>" class="text-decoration-none">
                <div class="card border-0 h-100 shadow-sm hover-lift" style="transition: all 0.3s ease;">
                    <div class="card-body text-center py-3">
                        <div class="mb-2">
                            <i class="bx bx-list-check" style="font-size: 2rem; color: #198754;"></i>
                        </div>
                        <h6 class="mb-1 fw-semibold">Kiểm Kê</h6>
                        <h4 class="mb-0 text-success"><?php echo e(\App\Models\CountRequest::where('status', 'PENDING')->count()); ?></h4>
                        <small class="text-muted">Chờ kiểm kê</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <a href="<?php echo e(route('admin.inventory.current-stock')); ?>" class="text-decoration-none">
                <div class="card border-0 h-100 shadow-sm hover-lift" style="transition: all 0.3s ease;">
                    <div class="card-body text-center py-3">
                        <div class="mb-2">
                            <i class="bx bx-alert-triangle" style="font-size: 2rem; color: #fd7e14;"></i>
                        </div>
                        <h6 class="mb-1 fw-semibold">Cảnh Báo</h6>
                        <h4 class="mb-0 text-warning"><?php echo e($lowStockVariants->count()); ?></h4>
                        <small class="text-muted">Tồn kho thấp</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- KPI Stats -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Tồn Kho Thực Tế</p>
                            <h3 class="mb-0 fw-bold"><?php echo e(number_format($onHandStock ?? 0)); ?></h3>
                        </div>
                        <div class="text-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-package text-white" style="font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Có Sẵn Bán</p>
                            <h3 class="mb-0 fw-bold text-success"><?php echo e(number_format($availableStock ?? 0)); ?></h3>
                        </div>
                        <div class="text-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #198754 0%, #146c43 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-check-circle text-white" style="font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Đã Đặt Hàng</p>
                            <h3 class="mb-0 fw-bold text-warning"><?php echo e(number_format($reservedStock ?? 0)); ?></h3>
                        </div>
                        <div class="text-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #fd7e14 0%, #e56a00 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-cart text-white" style="font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Chờ QC/Đóng Gói</p>
                            <h3 class="mb-0 fw-bold text-info"><?php echo e(number_format($quarantineStock ?? 0)); ?></h3>
                        </div>
                        <div class="text-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bx bx-time text-white" style="font-size: 1.8rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <?php if($unreadNotifications->isNotEmpty()): ?>
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <i class="bx bx-bell me-2"></i>
            <strong>Thông báo:</strong>
            <?php $__currentLoopData = $unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="small"><?php echo e($notif->title); ?> - <?php echo e($notif->message); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="row g-3 mb-4">
        <!-- Warehouse Stock Overview -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-primary text-white py-3" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-building me-2"></i>Tồn Kho Theo Kho</h6>
                </div>
                <div class="card-body p-0">
                    <?php if($stockByWarehouse->isEmpty()): ?>
                        <div class="alert alert-info mb-0 m-3">Không có kho hàng nào.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Kho</th>
                                        <th class="text-end fw-semibold">Tồn</th>
                                        <th class="text-end fw-semibold">Có Sẵn</th>
                                        <th class="text-end fw-semibold">Đặt</th>
                                        <th class="text-end fw-semibold">QC</th>
                                        <th class="text-end fw-semibold">Hỏng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $stockByWarehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo e($warehouse->name); ?></td>
                                            <td class="text-end"><span class="badge bg-info"><?php echo e(number_format($warehouse->on_hand_qty ?? 0)); ?></span></td>
                                            <td class="text-end"><span class="badge bg-success"><?php echo e(number_format($warehouse->available_qty ?? 0)); ?></span></td>
                                            <td class="text-end"><span class="badge bg-warning"><?php echo e(number_format($warehouse->reserved_qty ?? 0)); ?></span></td>
                                            <td class="text-end"><span class="badge bg-secondary"><?php echo e(number_format($warehouse->quarantine_qty ?? 0)); ?></span></td>
                                            <td class="text-end"><span class="badge bg-danger"><?php echo e(number_format($warehouse->damaged_qty ?? 0)); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-success text-white py-3" style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-trending-up me-2"></i>Top 5 Bán Chạy (7 Ngày)</h6>
                </div>
                <div class="card-body p-0">
                    <?php if($topSellingVariants->isEmpty()): ?>
                        <div class="alert alert-info mb-0 m-3">Chưa có dữ liệu bán hàng.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">SKU</th>
                                        <th class="text-end fw-semibold">Bán</th>
                                        <th class="text-end fw-semibold">Tồn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $topSellingVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><span class="badge bg-secondary"><?php echo e($variant->sku); ?></span></td>
                                            <td class="text-end"><span class="badge bg-success"><?php echo e(number_format($variant->total_sold)); ?></span></td>
                                            <td class="text-end"><span class="badge bg-info"><?php echo e(number_format(\App\Services\StockService::getVariantTotalStock($variant->id))); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Operations -->
    <div class="row g-3 mb-4">
        <!-- Pending Stock Out/Transfer -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-info text-white py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-transfer me-2"></i>Chờ Xác Nhận Xuất/Chuyển</h6>
                    <span class="badge bg-white text-info"><?php echo e($pendingOutTransfers->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($pendingOutTransfers->isEmpty()): ?>
                        <div class="alert alert-info mb-0 m-3">Không có hàng chờ xác nhận.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">SKU</th>
                                        <th class="text-end fw-semibold">Số Lượng</th>
                                        <th class="text-end fw-semibold">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pendingOutTransfers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><span class="badge bg-secondary"><?php echo e($transfer->variant->sku ?? 'N/A'); ?></span></td>
                                            <td class="text-end"><span class="badge bg-info"><?php echo e($transfer->reserved); ?></span></td>
                                            <td class="text-end">
                                                <form action="<?php echo e(route('admin.inventory.confirm-stock-out', [$transfer->variant_id, $transfer->warehouse_id])); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" title="Xác nhận">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Pending Count Requests -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-gradient-warning text-white py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-list-check me-2"></i>Chờ Kiểm Kê</h6>
                    <span class="badge bg-white text-warning"><?php echo e($pendingCountRequests->count()); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if($pendingCountRequests->isEmpty()): ?>
                        <div class="alert alert-info mb-0 m-3">Không có yêu cầu kiểm kê nào.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Sản Phẩm</th>
                                        <th class="text-end fw-semibold">Tồn HT</th>
                                        <th class="text-end fw-semibold">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pendingCountRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="small"><?php echo e($count->variant->product->name ?? 'N/A'); ?></td>
                                            <td class="text-end"><span class="badge bg-info"><?php echo e(number_format($count->system_qty)); ?></span></td>
                                            <td class="text-end">
                                                <a href="<?php echo e(route('admin.inventory.count.count', $count->id)); ?>" class="btn btn-sm btn-primary">
                                                    <i class="bx bx-check"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Damaged Stock -->
    <div class="row g-3 mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-danger text-white py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-error-circle me-2"></i>Hàng Hỏng/Lỗi</h6>
                    <span class="badge bg-white text-danger"><?php echo e($damagedStock); ?></span>
                </div>
                <div class="card-body p-0">
                    <?php
                        $damagedItems = \App\Models\WarehouseStock::where('damaged', '>', 0)
                            ->with(['warehouse', 'variant.product'])
                            ->get();
                    ?>
                    <?php if($damagedItems->isEmpty()): ?>
                        <div class="alert alert-success mb-0 m-3">
                            <i class="bx bx-check-circle me-2"></i>Không có hàng hỏng.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">Kho</th>
                                        <th class="fw-semibold">SKU</th>
                                        <th class="fw-semibold">Sản Phẩm</th>
                                        <th class="text-end fw-semibold">Số Lượng Hỏng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $damagedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="small fw-semibold"><?php echo e($item->warehouse->name); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo e($item->variant->sku); ?></span></td>
                                            <td class="small"><?php echo e($item->variant->product->name ?? 'N/A'); ?></td>
                                            <td class="text-end"><span class="badge bg-danger"><?php echo e(number_format($item->damaged)); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics & Alerts -->
    <div class="row g-3">
        <!-- Activity Stats -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-secondary text-white py-3" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-history me-2"></i>Thống Kê Lịch Sử Kho (30 Ngày)</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <p class="text-muted small mb-2">Nhập Kho</p>
                                <h4 class="text-success fw-bold mb-0"><?php echo e(\App\Models\InventoryLog::where('action', 'IN')->whereDate('created_at', '>=', now()->subDays(30))->sum('quantity_change')); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <p class="text-muted small mb-2">Xuất Kho</p>
                                <h4 class="text-danger fw-bold mb-0"><?php echo e(abs(\App\Models\InventoryLog::where('action', 'OUT')->whereDate('created_at', '>=', now()->subDays(30))->sum('quantity_change'))); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <p class="text-muted small mb-2">Chuyển Kho</p>
                                <h4 class="text-info fw-bold mb-0"><?php echo e(\App\Models\InventoryLog::where('action', 'TRANSFER')->whereDate('created_at', '>=', now()->subDays(30))->count()); ?></h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center p-3 bg-light rounded">
                                <p class="text-muted small mb-2">Điều Chỉnh</p>
                                <h4 class="text-warning fw-bold mb-0"><?php echo e(\App\Models\InventoryLog::where('action', 'ADJUSTMENT')->whereDate('created_at', '>=', now()->subDays(30))->count()); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-gradient-danger text-white py-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                    <h6 class="mb-0 fw-semibold"><i class="bx bx-exclamation-triangle me-2"></i>Cảnh Báo Tồn Kho Thấp (≤ <?php echo e($lowStockThreshold); ?>)</h6>
                </div>
                <div class="card-body p-0">
                    <?php if($lowStockVariants->isEmpty()): ?>
                        <div class="alert alert-success mb-0 m-3">
                            <i class="bx bx-check-circle me-2"></i>Tất cả sản phẩm đều có đủ hàng.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold">SKU</th>
                                        <th class="fw-semibold">Sản Phẩm</th>
                                        <th class="text-end fw-semibold">Tồn Kho</th>
                                        <th class="text-end fw-semibold">Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $lowStockVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><span class="badge bg-secondary"><?php echo e($variant->sku); ?></span></td>
                                            <td class="small"><?php echo e($variant->product->name ?? 'N/A'); ?></td>
                                            <td class="text-end"><span class="badge bg-danger"><?php echo e(number_format($variant->total_on_hand_stock)); ?></span></td>
                                            <td class="text-end">
                                                <a href="<?php echo e(route('admin.inventory.stock-in.index')); ?>" class="btn btn-sm btn-primary">
                                                    <i class="bx bx-plus"></i> Nhập
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
    }

    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .badge {
        padding: 0.4rem 0.6rem;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
    }

    h1, h3, h4, h6 {
        color: #1a1a1a;
    }

    .text-muted {
        color: #6c757d !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/dashboard.blade.php ENDPATH**/ ?>