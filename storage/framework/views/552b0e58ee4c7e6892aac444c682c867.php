<?php $__env->startSection('title', 'Đăng nhập'); ?>
<?php $__env->startSection('page-title', 'Đăng nhập'); ?>
<?php $__env->startSection('page-subtitle', 'Chào mừng bạn đến với STYLEX'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(Session::has('success')): ?>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "<?php echo e(Session::get('success')); ?>",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        });
    </script>
    <?php endif; ?>

    <?php if(Session::has('error')): ?>
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "<?php echo e(Session::get('error')); ?>",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        });
    </script>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                name="email" value="<?php echo e(old('email')); ?>" placeholder="Nhập email của bạn" autofocus>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-group">
                <input id="password" type="password"
                    class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" placeholder="Nhập mật khẩu">
                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">
                Ghi nhớ đăng nhập
            </label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                Đăng nhập
            </button>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <p class="mb-0">Chưa có tài khoản? <a href="<?php echo e(route('registerView')); ?>">Đăng ký ngay</a></p>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');
            
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                target.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('auth.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\auth\login.blade.php ENDPATH**/ ?>