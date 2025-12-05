<?php $__env->startSection('title', 'Sửa Role'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <h4 class="mb-3">Sửa Role: <?php echo e($role->name); ?></h4>
  <div class="card">
    <div class="card-body">
      <form method="POST" action="<?php echo e(route('admin.rbac.roles.update', $role)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
          <label class="form-label">Tên</label>
          <input type="text" name="name" value="<?php echo e(old('name', $role->name)); ?>" class="form-control">
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
          <input type="text" name="description" value="<?php echo e(old('description', $role->description)); ?>" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label">Gán Permission cho Role</label>
          <div class="row">
            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-md-3 mb-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="permission_ids[]" value="<?php echo e($perm->id); ?>" id="perm_<?php echo e($perm->id); ?>" <?php echo e(in_array($perm->id, $assigned) ? 'checked' : ''); ?>>
                  <label class="form-check-label" for="perm_<?php echo e($perm->id); ?>"><?php echo e($perm->name); ?></label>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>

        <div class="d-flex gap-2">
          <a href="<?php echo e(route('admin.rbac.roles.index')); ?>" class="btn btn-light">Hủy</a>
          <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\rbac\roles\edit.blade.php ENDPATH**/ ?>