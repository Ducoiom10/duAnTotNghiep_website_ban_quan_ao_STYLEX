    <!-- JAVASCRIPT -->
    <script src="<?php echo e(asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/node-waves/waves.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/feather-icons/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins.js')); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- apexcharts -->
    <script src="<?php echo e(asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>

    <!-- Vector map-->
    <script src="<?php echo e(asset('assets/libs/jsvectormap/js/jsvectormap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/jsvectormap/maps/world-merc.js')); ?>"></script>

    <!--Swiper slider js-->
    <script src="<?php echo e(asset('assets/libs/swiper/swiper-bundle.min.js')); ?>"></script>

    <!-- Dashboard init -->
    <script src="<?php echo e(asset('assets/js/pages/dashboard-ecommerce.init.js')); ?>"></script>

    <!-- ckeditor -->
    <script src="<?php echo e(asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')); ?>"></script>

    <!-- dropzone js -->
    <script src="<?php echo e(asset('assets/libs/dropzone/dropzone-min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/pages/ecommerce-product-create.init.js')); ?>"></script>
    <!-- App js -->
    <script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
        <script>
        // Hiển thị lỗi validation //
        <?php if($errors->any()): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr.error("<?php echo e($error); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        // Hiển thị flash messages //
        <?php if(session('success')): ?>
            toastr.success("<?php echo e(session('success')); ?>");
        <?php endif; ?>

        <?php if(session('error')): ?>
            toastr.error("<?php echo e(session('error')); ?>");
        <?php endif; ?>

        <?php if(session('warning')): ?>
            toastr.warning("<?php echo e(session('warning')); ?>");
        <?php endif; ?>

        <?php if(session('info')): ?>
            toastr.info("<?php echo e(session('info')); ?>");
        <?php endif; ?>
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function handleAction(btnSelector, config) {
                document.querySelectorAll(btnSelector).forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const name = btn.getAttribute('data-name') || 'mục này';
                        const form = btn.closest('form');

                        Swal.fire({
                            title: config.title,
                            html: `
                        <div class="swal-custom-content">
                            <div class="swal-icon-wrapper">
                                <i class="${config.iconClass}"></i>
                            </div>
                            <p class="swal-message">
                                ${config.message} 
                                <span class="swal-item-name">"${name}"</span>?
                            </p>
                            ${config.warning ? `<p class="swal-warning">${config.warning}</p>` : ''}
                        </div>
                    `,
                            showCancelButton: true,
                            confirmButtonText: config.confirmText,
                            cancelButtonText: '<i class="fa fa-times"></i> Hủy bỏ',
                            reverseButtons: true,
                            buttonsStyling: false,
                            allowOutsideClick: false,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            customClass: {
                                popup: 'swal-custom-popup',
                                title: 'swal-custom-title',
                                htmlContainer: 'swal-custom-html',
                                confirmButton: config.confirmClass + ' swal-custom-confirm',
                                cancelButton: 'swal-custom-cancel',
                                actions: 'swal-custom-actions'
                            },
                            didOpen: () => {
                                // Thêm hiệu ứng cho icon
                                const icon = Swal.getPopup().querySelector(
                                    '.swal-icon-wrapper i');
                                if (icon) {
                                    icon.classList.add('animate__animated',
                                        'animate__heartBeat');
                                }
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Hiển thị loading
                                Swal.fire({
                                    title: 'Đang xử lý...',
                                    html: '<div class="swal-loading"><div class="spinner"></div></div>',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal-loading-popup'
                                    }
                                });

                                // Submit form
                                setTimeout(() => {
                                    form.submit();
                                }, 500);
                            }
                        });
                    });
                });
            }

            // Cấu hình cho từng loại action
            const actionConfigs = {
                softDelete: {
                    title: '⚠️ Xác nhận xóa',
                    message: 'Bạn có chắc chắn muốn xóa',
                    warning: 'Dữ liệu sẽ được chuyển vào thùng rác và có thể khôi phục lại.',
                    iconClass: 'fas fa-trash-alt text-warning',
                    confirmText: '<i class="fas fa-trash"></i> Xóa ngay',
                    confirmClass: 'btn-gradient-warning'
                },
                restore: {
                    title: '♻️ Khôi phục dữ liệu',
                    message: 'Bạn muốn khôi phục lại',
                    iconClass: 'fas fa-undo-alt text-info',
                    confirmText: '<i class="fas fa-undo"></i> Khôi phục',
                    confirmClass: 'btn-gradient-info'
                },
                forceDelete: {
                    title: '🚨 Cảnh báo nghiêm trọng',
                    message: 'Bạn thực sự muốn xóa vĩnh viễn',
                    warning: '⚠️ Hành động này KHÔNG THỂ hoàn tác! Dữ liệu sẽ bị xóa hoàn toàn khỏi hệ thống.',
                    iconClass: 'fas fa-exclamation-triangle text-danger',
                    confirmText: '<i class="fas fa-trash-alt"></i> Xóa vĩnh viễn',
                    confirmClass: 'btn-gradient-danger'
                }
            };

            // Áp dụng cho các button
            handleAction('.btn-delete', actionConfigs.softDelete);
            handleAction('.btn-remove', actionConfigs.restore);
            handleAction('.btn-forcedelete', actionConfigs.forceDelete);
        });
    </script>
<?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/admin/partials/js.blade.php ENDPATH**/ ?>