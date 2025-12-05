    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>">

    <!-- jsvectormap css -->
    <link href="<?php echo e(asset('assets/libs/jsvectormap/css/jsvectormap.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="<?php echo e(asset('assets/libs/swiper/swiper-bundle.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="<?php echo e(asset('assets/js/layout.js')); ?>"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <!-- custom Css-->
    <link href="<?php echo e(asset('assets/css/custom.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Style X Logo CSS -->
    <link href="<?php echo e(asset('assets/css/style-x-logo.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="<?php echo e(asset('assets/libs/dropzone/dropzone.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Thêm vào phần <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Thêm 3 dòng này để nhúng Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Import Animate.css nếu chưa có */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

        /* Custom Popup Styles */
        /* --- Select2 custom style (Bootstrap 5 theme) --- */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            background-color: #fff;
        }

        .select2-container--bootstrap-5 .select2-selection__choice {
            background-color: #0d6efd !important;
            /* Màu nền xanh Bootstrap */
            color: #fff !important;
            /* Chữ trắng */
            border: none !important;
            border-radius: .3rem;
            padding: 4px 10px !important;
            margin-top: 4px;
            font-weight: 500;
            font-size: 13px;
        }

        /* Nút “×” khi xoá tag */
        .select2-container--bootstrap-5 .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 4px;
            font-weight: bold;
            font-size: 14px;
            opacity: 0.9;
        }

        .select2-container--bootstrap-5 .select2-selection__choice__remove:hover {
            color: #ffe082 !important;
            /* chuyển vàng nhạt khi hover */
        }

        /* Placeholder màu nhẹ hơn */
        .select2-container--bootstrap-5 .select2-selection__placeholder {
            color: #6c757d !important;
        }


        .swal-custom-popup {
            border-radius: 20px !important;
            padding: 0 !important;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
        }

        .swal-custom-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white !important;
            padding: 25px !important;
            margin: 0 !important;
            font-size: 24px !important;
            font-weight: 600 !important;
        }

        .swal-custom-html {
            padding: 30px 20px 20px !important;
        }

        .swal-custom-content {
            text-align: center;
        }

        .swal-icon-wrapper {
            margin-bottom: 20px;
        }

        .swal-icon-wrapper i {
            font-size: 48px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .swal-message {
            font-size: 18px;
            color: #4a5568;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .swal-item-name {
            color: #e53e3e;
            font-weight: 700;
            background: linear-gradient(135deg, #ff6b6b, #ff8787);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .swal-warning {
            background: #fff5f5;
            border-left: 4px solid #fc8181;
            padding: 12px 16px;
            border-radius: 8px;
            color: #c53030;
            font-size: 14px;
            margin-top: 20px;
            text-align: left;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Actions */
        .swal-custom-actions {
            background: #f7fafc;
            padding: 20px !important;
            margin: 0 !important;
            border-top: 1px solid #e2e8f0;
        }

        /* Custom Buttons */
        .swal-custom-confirm,
        .swal-custom-cancel {
            padding: 12px 28px !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            transition: all 0.3s ease !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 8px !important;
        }

        .swal-custom-cancel {
            background: #e2e8f0 !important;
            color: #4a5568 !important;
            border: none !important;
        }

        .swal-custom-cancel:hover {
            background: #cbd5e0 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Gradient Buttons */
        .btn-gradient-warning {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%) !important;
            color: white !important;
            border: none !important;
        }

        .btn-gradient-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border: none !important;
        }

        .btn-gradient-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
            color: white !important;
            border: none !important;
        }

        .btn-gradient-warning:hover,
        .btn-gradient-info:hover,
        .btn-gradient-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            filter: brightness(1.1);
        }

        /* Loading Popup */
        .swal-loading-popup {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .swal-loading {
            padding: 40px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            margin: 0 auto;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            .swal-custom-popup {
                width: 90% !important;
            }

            .swal-custom-title {
                font-size: 20px !important;
                padding: 20px !important;
            }

            .swal-message {
                font-size: 16px;
            }

            .swal-custom-confirm,
            .swal-custom-cancel {
                padding: 10px 20px !important;
                font-size: 14px !important;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .swal-custom-popup {
                background: #1a202c !important;
            }

            .swal-message {
                color: #cbd5e0;
            }

            .swal-custom-actions {
                background: #2d3748;
                border-top-color: #4a5568;
            }

            .swal-warning {
                background: #2d2d2d;
                color: #fc8181;
            }
        }
    </style>
    <!-- Thêm trước </body> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\partials\css.blade.php ENDPATH**/ ?>