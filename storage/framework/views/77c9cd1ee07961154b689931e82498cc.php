<?php $__env->startSection('title', 'Hóa đơn xuất kho'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Hóa đơn xuất kho</h1>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Số hóa đơn</th>
                        <th>Loại</th>
                        <th>Kho</th>
                        <th>Số sản phẩm</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($invoice->invoice_number); ?></strong></td>
                            <td>
                                <span class="badge bg-<?php echo e($invoice->type === 'CLEARANCE' ? 'warning' : 'info'); ?>">
                                    <?php echo e($invoice->type === 'CLEARANCE' ? 'Thanh lý' : 'Thường'); ?>

                                </span>
                            </td>
                            <td><?php echo e($invoice->warehouse->name); ?></td>
                            <td><?php echo e($invoice->items->sum('quantity')); ?></td>
                            <td><?php echo e(number_format($invoice->total_amount)); ?> đ</td>
                            <td>
                                <span class="badge bg-<?php echo e($invoice->status === 'COMPLETED' ? 'success' : 'secondary'); ?>">
                                    <?php echo e($invoice->status); ?>

                                </span>
                            </td>
                            <td><?php echo e($invoice->created_at->format('d/m/Y H:i')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.inventory.stock-out-invoice.show', $invoice->id)); ?>" class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if($invoice->status !== 'COMPLETED'): ?>
                                    <form action="<?php echo e(route('admin.inventory.stock-out-invoice.complete', $invoice->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận hoàn thành hóa đơn?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-success" title="Hoàn thành">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">Không có hóa đơn xuất kho</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($invoices->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/stock-out-invoice/index.blade.php ENDPATH**/ ?>