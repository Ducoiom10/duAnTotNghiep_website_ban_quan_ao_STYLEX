<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h4 class="mb-0"><i class="bx bx-check"></i> Đếm Kho - <?php echo e($request->variant->product->name); ?></h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.inventory.count.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Quay Lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Thông Tin Sản Phẩm & Kho</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Sản Phẩm:</strong> <?php echo e($request->variant->product->name); ?></p>
                    <p><strong>SKU:</strong> <?php echo e($request->variant->sku); ?></p>
                    <p><strong>Kho:</strong> <?php echo e($request->warehouse->name); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngày Tạo:</strong> <?php echo e($request->created_at->format('d/m/Y H:i')); ?></p>
                    <p><strong>Người Tạo:</strong> <?php echo e($request->createdBy->name ?? 'N/A'); ?></p>
                    <p><strong>Trạng Thái:</strong> <span class="badge bg-warning"><?php echo e($request->status); ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Tồn Kho Hiện Tại (Hệ Thống)</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Tồn Kho Tổng</p>
                    <h4 class="text-primary"><?php echo e(number_format($request->system_qty)); ?></h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Sẵn Sàng</p>
                    <h4 class="text-success" id="system_available">0</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Đã Đặt</p>
                    <h4 class="text-info" id="system_reserved">0</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Chờ QC</p>
                    <h4 class="text-warning" id="system_quarantine">0</h4>
                </div>
                <div class="col-md-2 text-center">
                    <p class="text-muted mb-1">Hỏng</p>
                    <h4 class="text-danger" id="system_damaged">0</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chi Tiết Loại Hàng</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Loại Hàng</th>
                            <th class="text-end">Số Lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge bg-success">Sẵn Sàng</span></td>
                            <td class="text-end"><strong id="detail_available">0</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">Đã Đặt</span></td>
                            <td class="text-end"><strong id="detail_reserved">0</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-warning">Chờ QC</span></td>
                            <td class="text-end"><strong id="detail_quarantine">0</strong></td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-danger">Hỏng</span></td>
                            <td class="text-end"><strong id="detail_damaged">0</strong></td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>Tổng Cộng</strong></td>
                            <td class="text-end"><strong id="detail_total">0</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Nhập Kết Quả Đếm</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.inventory.count.confirm-count', $request->id)); ?>" method="POST" id="countForm">
                <?php echo csrf_field(); ?>

                <div class="alert alert-info">
                    <strong>Hướng dẫn:</strong> Nhập số lượng thực tế đếm được theo từng loại
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Sẵn Sàng <span class="text-danger">*</span></label>
                        <input type="number" name="available_qty" id="available_qty" class="form-control <?php $__errorArgs = ['available_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('available_qty', 0)); ?>" min="0">
                        <?php $__errorArgs = ['available_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Đã Đặt <span class="text-danger">*</span></label>
                        <input type="number" name="reserved_qty" id="reserved_qty" class="form-control <?php $__errorArgs = ['reserved_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('reserved_qty', 0)); ?>" min="0">
                        <?php $__errorArgs = ['reserved_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Chờ QC <span class="text-danger">*</span></label>
                        <input type="number" name="quarantine_qty" id="quarantine_qty" class="form-control <?php $__errorArgs = ['quarantine_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('quarantine_qty', 0)); ?>" min="0">
                        <?php $__errorArgs = ['quarantine_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số Lượng Hỏng <span class="text-danger">*</span></label>
                        <input type="number" name="damaged_qty" id="damaged_qty" class="form-control <?php $__errorArgs = ['damaged_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('damaged_qty', 0)); ?>" min="0">
                        <?php $__errorArgs = ['damaged_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div id="defectSection" style="display: none;">
                    <div class="alert alert-warning">
                        <strong>Thông Tin Hàng Hỏng:</strong> Vui lòng nhập chi tiết về hàng hỏng
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mức Độ Hỏng <span class="text-danger">*</span></label>
                            <select name="defect_level" id="defect_level" class="form-select <?php $__errorArgs = ['defect_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Chọn mức độ --</option>
                                <option value="LIGHT" <?php echo e(old('defect_level') === 'LIGHT' ? 'selected' : ''); ?>>Nhẹ (Sửa chữa được)</option>
                                <option value="MEDIUM" <?php echo e(old('defect_level') === 'MEDIUM' ? 'selected' : ''); ?>>Trung Bình (Hạ cấp)</option>
                                <option value="HEAVY" <?php echo e(old('defect_level') === 'HEAVY' ? 'selected' : ''); ?>>Nặng (Phế liệu)</option>
                            </select>
                            <?php $__errorArgs = ['defect_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loại Lỗi</label>
                            <select name="defect_type" id="defect_type" class="form-select <?php $__errorArgs = ['defect_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Chọn loại lỗi --</option>
                                <option value="SEWING" <?php echo e(old('defect_type') === 'SEWING' ? 'selected' : ''); ?>>Lỗi May</option>
                                <option value="CUTTING" <?php echo e(old('defect_type') === 'CUTTING' ? 'selected' : ''); ?>>Lỗi Cắt</option>
                                <option value="DYEING" <?php echo e(old('defect_type') === 'DYEING' ? 'selected' : ''); ?>>Lỗi Nhuộm</option>
                                <option value="FABRIC" <?php echo e(old('defect_type') === 'FABRIC' ? 'selected' : ''); ?>>Lỗi Vải</option>
                                <option value="SIZE" <?php echo e(old('defect_type') === 'SIZE' ? 'selected' : ''); ?>>Lỗi Kích Thước</option>
                                <option value="OTHER" <?php echo e(old('defect_type') === 'OTHER' ? 'selected' : ''); ?>>Khác</option>
                            </select>
                            <?php $__errorArgs = ['defect_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô Tả Lỗi</label>
                        <textarea name="defect_description" id="defect_description" class="form-control <?php $__errorArgs = ['defect_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="2" placeholder="Mô tả chi tiết về lỗi..."><?php echo e(old('defect_description')); ?></textarea>
                        <?php $__errorArgs = ['defect_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Tổng Số Lượng Đếm Được:</strong> <span id="total-display" class="badge bg-primary">0</span>
                    <br><strong>Chênh Lệch:</strong> <span id="difference-display" class="badge bg-warning">0</span>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Người Đếm</label>
                        <input type="text" class="form-control" value="<?php echo e(auth()->user()->name); ?>" disabled>
                        <input type="hidden" name="counted_by" value="<?php echo e(auth()->id()); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi Chú / Lý Do Kiểm Kê</label>
                    <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="3" placeholder="Ví dụ: Kiểm kê định kỳ, phát hiện mất hàng, ..."><?php echo e(old('notes')); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-check"></i> Xác Nhận Đếm
                    </button>
                    <a href="<?php echo e(route('admin.inventory.count.index')); ?>" class="btn btn-secondary">
                        <i class="bx bx-x"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateTotal() {
    const available = parseInt(document.getElementById('available_qty').value) || 0;
    const reserved = parseInt(document.getElementById('reserved_qty').value) || 0;
    const quarantine = parseInt(document.getElementById('quarantine_qty').value) || 0;
    const damaged = parseInt(document.getElementById('damaged_qty').value) || 0;
    const total = available + reserved + quarantine + damaged;
    const systemQty = <?php echo e($request->system_qty ?? 0); ?>;
    const difference = total - systemQty;
    
    document.getElementById('total-display').textContent = total;
    document.getElementById('difference-display').textContent = (difference >= 0 ? '+' : '') + difference;
    document.getElementById('difference-display').className = difference === 0 ? 'badge bg-success' : (difference > 0 ? 'badge bg-info' : 'badge bg-danger');
    
    const defectSection = document.getElementById('defectSection');
    if (damaged > 0) {
        defectSection.style.display = 'block';
        document.getElementById('defect_level').setAttribute('required', 'required');
    } else {
        defectSection.style.display = 'none';
        document.getElementById('defect_level').removeAttribute('required');
    }
}

document.getElementById('available_qty').addEventListener('input', updateTotal);
document.getElementById('reserved_qty').addEventListener('input', updateTotal);
document.getElementById('quarantine_qty').addEventListener('input', updateTotal);
document.getElementById('damaged_qty').addEventListener('input', updateTotal);

fetch(`/api/v1/warehouses/<?php echo e($request->warehouse_id); ?>/variants/<?php echo e($request->variant_id); ?>/stock`)
    .then(r => r.json())
    .then(data => {
        document.getElementById('system_available').textContent = data.available || 0;
        document.getElementById('system_reserved').textContent = data.reserved || 0;
        document.getElementById('system_quarantine').textContent = data.quarantine || 0;
        document.getElementById('system_damaged').textContent = data.damaged || 0;
        
        document.getElementById('detail_available').textContent = data.available || 0;
        document.getElementById('detail_reserved').textContent = data.reserved || 0;
        document.getElementById('detail_quarantine').textContent = data.quarantine || 0;
        document.getElementById('detail_damaged').textContent = data.damaged || 0;
        document.getElementById('detail_total').textContent = (data.available || 0) + (data.reserved || 0) + (data.quarantine || 0) + (data.damaged || 0);
        
        updateTotal();
    })
    .catch(err => console.error('Lỗi tải dữ liệu:', err));
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/inventory/count/count.blade.php ENDPATH**/ ?>