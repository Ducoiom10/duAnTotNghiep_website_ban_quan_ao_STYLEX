<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Quản Lý Kho Hàng</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?php echo e(route('admin.inventory.warehouses.create')); ?>" class="btn btn-success">+ Thêm Kho</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tên Kho</th>
                        <th>Mã Kho</th>
                        <th>Loại</th>
                        <th>Trạng Thái</th>
                        <th>Địa Chỉ</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($warehouse->name); ?></strong></td>
                            <td><?php echo e($warehouse->code); ?></td>
                            <td><?php echo e($warehouse->type); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($warehouse->operational_status === 'ACTIVE' ? 'success' : 'danger'); ?>">
                                    <?php echo e($warehouse->operational_status); ?>

                                </span>
                            </td>
                            <td><?php echo e($warehouse->address ?? '-'); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.inventory.warehouses.edit', $warehouse)); ?>" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="<?php echo e(route('admin.inventory.warehouses.destroy', $warehouse)); ?>" method="POST" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Không có kho hàng nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($warehouses->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/warehouse/index.blade.php ENDPATH**/ ?>