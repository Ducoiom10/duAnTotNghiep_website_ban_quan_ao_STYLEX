<?php $__env->startSection('title', 'Tạo Role'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <h4 class="mb-3">Tạo Role</h4>
  <div class="card">
    <div class="card-body">
      <form method="POST" action="<?php echo e(route('admin.rbac.roles.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control">
          <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-3">
          <label class="form-label">Mô tả</label>
          <input type="text" name="description" value="<?php echo e(old('description')); ?>" class="form-control">
        </div>
        <div class="d-flex gap-2">
          <a href="<?php echo e(route('admin.rbac.roles.index')); ?>" class="btn btn-light">Hủy</a>
          <button class="btn btn-primary" type="submit">Tạo</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\rbac\roles\create.blade.php ENDPATH**/ ?>