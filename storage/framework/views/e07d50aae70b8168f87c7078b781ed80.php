<?php $__env->startSection('title', 'Quản lý Hạng thành viên'); ?>

<?php $__env->startPush('page-css'); ?>
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />

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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-vip-crown-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số hạng</h5>
                    <h3 class="card-text fw-bold"><?php echo e($tierStats['total_tiers'] ?? 0); ?></h3>
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
                    <h3 class="card-text fw-bold text-success"><?php echo e($tierStats['total_members'] ?? 0); ?></h3>
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
                    <h3 class="card-text fw-bold text-warning"><?php echo e(number_format($tierStats['min_min_spend'] ?? 0, 0, ',', '.')); ?></h3>
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
                    <h3 class="card-text fw-bold text-danger"><?php echo e(number_format($tierStats['avg_discount'] ?? 0, 2)); ?>%</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title mb-0">Danh sách hạng</h4>
                    <a href="<?php echo e(route('admin.loyalty-tiers.create')); ?>" class="btn btn-success add-btn">
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
                                <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration + ($tiers->currentPage() - 1) * $tiers->perPage()); ?></td>
                                        <td><?php echo e($tier->name); ?></td>
                                        <td><?php echo e(number_format($tier->min_spend_required, 0, ',', '.')); ?></td>
                                        <td><?php echo e(number_format($tier->discount_rate, 2)); ?>%</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?php echo e(route('admin.loyalty-tiers.edit', $tier)); ?>" class="btn btn-sm btn-warning" title="Sửa">
                                                    <span class="ri-edit-box-line"></span>
                                                </a>
                                                <form action="<?php echo e(route('admin.loyalty-tiers.destroy', $tier)); ?>" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa hạng <?php echo e($tier->name); ?>?');">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                        <span class="ri-delete-bin-7-line"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <div class="pagination-wrap hstack gap-2">
            <?php if($tiers->onFirstPage()): ?>
                <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
            <?php else: ?>
                <a class="page-item pagination-prev" href="<?php echo e($tiers->previousPageUrl()); ?>">Previous</a>
            <?php endif; ?>

            <ul class="pagination listjs-pagination mb-0">
                <?php $__currentLoopData = $tiers->getUrlRange(1, $tiers->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="page-item <?php echo e($page == $tiers->currentPage() ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <?php if($tiers->hasMorePages()): ?>
                <a class="page-item pagination-next" href="<?php echo e($tiers->nextPageUrl()); ?>">Next</a>
            <?php else: ?>
                <a class="page-item pagination-next disabled" href="javascript:void(0);">Next</a>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\loyalty-tiers\index.blade.php ENDPATH**/ ?>