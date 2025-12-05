<?php echo csrf_field(); ?>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label fw-semibold">Mã voucher <span class="text-danger">*</span></label>
        <input type="text" name="code" value="<?php echo e(old('code', $voucher->code ?? '')); ?>" class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <?php $__errorArgs = ['code'];
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
    <div class="col-md-4">
        <label class="form-label fw-semibold">Loại <span class="text-danger">*</span></label>
        <select name="type" class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <option value="percent" <?php echo e(old('type', $voucher->type ?? 'percent') === 'percent' ? 'selected' : ''); ?>>Phần trăm (%)</option>
            <option value="fixed" <?php echo e(old('type', $voucher->type ?? '') === 'fixed' ? 'selected' : ''); ?>>Cố định (₫)</option>
        </select>
        <?php $__errorArgs = ['type'];
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
    <div class="col-md-4">
        <label class="form-label fw-semibold">Giá trị <span class="text-danger">*</span></label>
        <?php
            $value = old('value', $voucher->value ?? 0);
            $valueFormatted = $value ? (fmod($value, 1) == 0 ? number_format($value, 0, ',', '.') : number_format($value, 2, ',', '.')) : '0';
        ?>
        <input type="text" 
               name="value_display" 
               id="value_display"
               value="<?php echo e($valueFormatted); ?>" 
               class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
               placeholder="Nhập giá trị"
               data-format-number-decimal>
        <input type="hidden" name="value" id="value" value="<?php echo e($value); ?>">
        <?php $__errorArgs = ['value'];
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

    <div class="col-md-4">
        <label class="form-label fw-semibold">Giảm tối đa (áp dụng với %)</label>
        <input type="text" 
               name="max_discount_amount_display" 
               id="max_discount_amount_display"
               value="<?php echo e(old('max_discount_amount', $voucher->max_discount_amount ?? '') ? number_format(old('max_discount_amount', $voucher->max_discount_amount ?? ''), 0, ',', '.') : ''); ?>" 
               class="form-control <?php $__errorArgs = ['max_discount_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
               placeholder="Không giới hạn nếu bỏ trống"
               data-format-number>
        <input type="hidden" name="max_discount_amount" id="max_discount_amount" value="<?php echo e(old('max_discount_amount', $voucher->max_discount_amount ?? '')); ?>">
        <?php $__errorArgs = ['max_discount_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <small class="text-muted">Chỉ áp dụng khi loại là phần trăm</small>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Đơn tối thiểu</label>
        <input type="text" 
               name="min_order_amount_display" 
               id="min_order_amount_display"
               value="<?php echo e(old('min_order_amount', $voucher->min_order_amount ?? '') ? number_format(old('min_order_amount', $voucher->min_order_amount ?? ''), 0, ',', '.') : ''); ?>" 
               class="form-control <?php $__errorArgs = ['min_order_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
               placeholder="Không bắt buộc"
               data-format-number>
        <input type="hidden" name="min_order_amount" id="min_order_amount" value="<?php echo e(old('min_order_amount', $voucher->min_order_amount ?? '')); ?>">
        <?php $__errorArgs = ['min_order_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <small class="text-muted">Đơn hàng tối thiểu để áp dụng voucher</small>
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Giới hạn lượt dùng</label>
        <input type="number" min="1" name="usage_limit" value="<?php echo e(old('usage_limit', $voucher->usage_limit ?? '')); ?>" class="form-control <?php $__errorArgs = ['usage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Không giới hạn nếu bỏ trống">
        <?php $__errorArgs = ['usage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <small class="text-muted">Số lượt sử dụng tối đa</small>
    </div>

    <div class="col-md-12">
        <label class="form-label fw-semibold">Mô tả</label>
        <textarea name="description" rows="3" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nhập mô tả voucher..."><?php echo e(old('description', $voucher->description ?? '')); ?></textarea>
        <?php $__errorArgs = ['description'];
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

    <div class="col-md-6">
        <label class="form-label fw-semibold">Bắt đầu</label>
        <input type="datetime-local" name="starts_at" value="<?php echo e(old('starts_at', isset($voucher->starts_at) ? $voucher->starts_at->format('Y-m-d\TH:i') : '')); ?>" class="form-control <?php $__errorArgs = ['starts_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <?php $__errorArgs = ['starts_at'];
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
    <div class="col-md-6">
        <label class="form-label fw-semibold">Kết thúc</label>
        <input type="datetime-local" name="ends_at" value="<?php echo e(old('ends_at', isset($voucher->ends_at) ? $voucher->ends_at->format('Y-m-d\TH:i') : '')); ?>" class="form-control <?php $__errorArgs = ['ends_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <?php $__errorArgs = ['ends_at'];
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

    <div class="col-md-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" <?php echo e(old('is_active', ($voucher->is_active ?? true)) ? 'checked' : ''); ?>>
            <label class="form-check-label fw-semibold" for="is_active">Kích hoạt voucher</label>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="col-12">
            <div class="alert alert-danger">
                <h6 class="alert-heading mb-2">Vui lòng kiểm tra lại các trường sau:</h6>
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-12">
        <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="<?php echo e(route('admin.vouchers.index')); ?>" class="btn btn-light">
                <i class="ri-close-line me-1"></i> Hủy
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="ri-save-line me-1"></i> Lưu thay đổi
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm format số nguyên với dấu chấm ngăn cách
    function formatNumber(value) {
        if (!value) return '';
        // Loại bỏ tất cả ký tự không phải số
        var num = value.toString().replace(/[^\d]/g, '');
        if (!num) return '';
        // Format với dấu chấm ngăn cách hàng nghìn
        return num.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Hàm format số thập phân với dấu chấm ngăn cách hàng nghìn và dấu phẩy cho phần thập phân
    function formatDecimalNumber(value) {
        if (!value) return '0';
        var str = value.toString();
        
        // Thay tất cả dấu chấm và phẩy thành ký tự tạm để xử lý
        // Giả sử dấu phẩy hoặc dấu chấm cuối cùng là dấu thập phân
        var lastComma = str.lastIndexOf(',');
        var lastDot = str.lastIndexOf('.');
        var decimalSeparatorPos = Math.max(lastComma, lastDot);
        
        if (decimalSeparatorPos > -1) {
            // Có phần thập phân
            var integerPart = str.substring(0, decimalSeparatorPos).replace(/[^\d]/g, '');
            var decimalPart = str.substring(decimalSeparatorPos + 1).replace(/[^\d]/g, '').substring(0, 2);
            
            // Format phần nguyên
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            if (!integerPart) integerPart = '0';
            
            return decimalPart ? integerPart + ',' + decimalPart : integerPart;
        } else {
            // Không có phần thập phân, chỉ format phần nguyên
            var num = str.replace(/[^\d]/g, '');
            if (!num) return '0';
            return num.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    }

    // Hàm lấy số thực (không có dấu chấm ngăn cách, dùng dấu chấm cho phần thập phân)
    function getRawNumber(value) {
        if (!value) return '';
        return value.toString().replace(/[^\d]/g, '');
    }

    // Hàm lấy số thập phân thực (không có dấu chấm ngăn cách, dùng dấu chấm cho phần thập phân)
    function getRawDecimalNumber(value) {
        if (!value) return '0';
        var str = value.toString();
        
        // Tìm vị trí dấu phân cách thập phân (dấu phẩy hoặc chấm cuối cùng)
        var lastComma = str.lastIndexOf(',');
        var lastDot = str.lastIndexOf('.');
        var decimalSeparatorPos = Math.max(lastComma, lastDot);
        
        if (decimalSeparatorPos > -1) {
            // Có phần thập phân
            var integerPart = str.substring(0, decimalSeparatorPos).replace(/[^\d]/g, '');
            var decimalPart = str.substring(decimalSeparatorPos + 1).replace(/[^\d]/g, '').substring(0, 2);
            
            if (!integerPart) integerPart = '0';
            return decimalPart ? integerPart + '.' + decimalPart : integerPart;
        } else {
            // Không có phần thập phân
            var num = str.replace(/[^\d]/g, '');
            return num || '0';
        }
    }

    // Xử lý các trường có data-format-number (số nguyên)
    var formatInputs = document.querySelectorAll('[data-format-number]');
    
    formatInputs.forEach(function(input) {
        // Format khi người dùng nhập
        input.addEventListener('input', function(e) {
            var rawValue = getRawNumber(e.target.value);
            var formatted = formatNumber(rawValue);
            e.target.value = formatted;
            
            // Cập nhật hidden input tương ứng
            var hiddenInput = document.getElementById(input.id.replace('_display', ''));
            if (hiddenInput) {
                hiddenInput.value = rawValue || '';
            }
        });

        // Format khi blur (rời khỏi trường)
        input.addEventListener('blur', function(e) {
            var rawValue = getRawNumber(e.target.value);
            var formatted = formatNumber(rawValue);
            e.target.value = formatted;
            
            var hiddenInput = document.getElementById(input.id.replace('_display', ''));
            if (hiddenInput) {
                hiddenInput.value = rawValue || '';
            }
        });
    });

    // Xử lý các trường có data-format-number-decimal (số thập phân)
    var formatDecimalInputs = document.querySelectorAll('[data-format-number-decimal]');
    
    formatDecimalInputs.forEach(function(input) {
        // Format khi người dùng nhập
        input.addEventListener('input', function(e) {
            var rawValue = getRawDecimalNumber(e.target.value);
            var formatted = formatDecimalNumber(e.target.value);
            e.target.value = formatted;
            
            // Cập nhật hidden input tương ứng
            var hiddenInput = document.getElementById(input.id.replace('_display', ''));
            if (hiddenInput) {
                hiddenInput.value = rawValue || '0';
            }
        });

        // Format khi blur (rời khỏi trường)
        input.addEventListener('blur', function(e) {
            var rawValue = getRawDecimalNumber(e.target.value);
            var formatted = formatDecimalNumber(e.target.value);
            e.target.value = formatted;
            
            var hiddenInput = document.getElementById(input.id.replace('_display', ''));
            if (hiddenInput) {
                hiddenInput.value = rawValue || '0';
            }
        });
    });

    // Cập nhật hidden input trước khi submit form
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Xử lý số nguyên
            formatInputs.forEach(function(input) {
                var rawValue = getRawNumber(input.value);
                var hiddenInput = document.getElementById(input.id.replace('_display', ''));
                if (hiddenInput) {
                    hiddenInput.value = rawValue || '';
                }
            });
            
            // Xử lý số thập phân
            formatDecimalInputs.forEach(function(input) {
                var rawValue = getRawDecimalNumber(input.value);
                var hiddenInput = document.getElementById(input.id.replace('_display', ''));
                if (hiddenInput) {
                    hiddenInput.value = rawValue || '0';
                }
            });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>


<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\vouchers\_form.blade.php ENDPATH**/ ?>