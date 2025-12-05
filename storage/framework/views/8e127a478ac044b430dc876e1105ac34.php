<?php $__env->startSection('title', 'Quản lý Permission'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Danh sách Permission</h4>
    <a href="<?php echo e(route('admin.rbac.permissions.create')); ?>" class="btn btn-primary">Tạo Permission</a>
  </div>
  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($permission->id); ?></td>
            <td><?php echo e($permission->name); ?></td>
            <td><?php echo e($permission->description); ?></td>
            <td>
              <a class="btn btn-sm btn-warning" href="<?php echo e(route('admin.rbac.permissions.edit', $permission)); ?>">Sửa</a>
              <form class="d-inline" method="POST" action="<?php echo e(route('admin.rbac.permissions.destroy', $permission)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa permission này?')">Xóa</button>
              </form>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
      <div>
        <?php echo e($permissions->links()); ?>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\rbac\permissions\index.blade.php ENDPATH**/ ?>