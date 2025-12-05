<?php $__env->startSection('title', 'Quản lí chất liệu'); ?>
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

        .texture-table th,
        .texture-table td {
            vertical-align: middle;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lí chất liệu</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="javascript: void(0);">Thuộc tính sản phẩm</a></li>
                        <li class="breadcrumb-item">Quản lí chất liệu</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Thống kê chất liệu -->
    <div class="row cursor-pointer">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card total-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-primary">
                        <i class="ri-scissors-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Tổng số chất liệu</h5>
                    <h3 class="card-text fw-bold"><?php echo e($textures->total() ?? 0); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card approved-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-success">
                        <i class="ri-checkbox-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Chất liệu hoạt động</h5>
                    <h3 class="card-text fw-bold text-success"><?php echo e($textures->where('status', 1)->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card pending-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-warning">
                        <i class="ri-pause-circle-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Chất liệu không hoạt động</h5>
                    <h3 class="card-text fw-bold text-warning"><?php echo e($textures->where('status', 0)->count()); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card stats-card parent-card">
                <div class="card-body text-center">
                    <div class="stat-icon text-info">
                        <i class="ri-scissors-line"></i>
                    </div>
                    <h5 class="card-title text-muted mb-2">Có mô tả</h5>
                    <h3 class="card-text fw-bold text-info"><?php echo e($textures->whereNotNull('description')->count()); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Danh sách chất liệu</h4>
                    <a href="<?php echo e(route('admin.textures.create')); ?>" class="btn btn-success add-btn">
                        <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg texture-table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên chất liệu</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt = ($textures->currentPage() - 1) * $textures->perPage(); ?>
                                <?php $__empty_1 = true; $__currentLoopData = $textures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $texture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e(++$stt); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="ri-scissors-line me-2 text-primary"></i>
                                            <span class="fw-medium"><?php echo e($texture->name); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($texture->description): ?>
                                            <span class="text-muted"><?php echo e(Str::limit($texture->description, 50)); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Chưa có mô tả</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($texture->status == 1): ?>
                                            <span class="badge bg-success">Hoạt động</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Không hoạt động</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.textures.edit', $texture)); ?>" class="btn btn-sm btn-warning me-1" title="Sửa">
                                            <i class="ri-edit-box-line"></i>
                                        </a>
                                        <form method="POST" action="<?php echo e(route('admin.textures.destroy', $texture)); ?>" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa chất liệu này?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="ri-delete-bin-7-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Chưa có chất liệu nào</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if($textures->hasPages()): ?>
                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($textures->links()); ?>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\textures\index.blade.php ENDPATH**/ ?>