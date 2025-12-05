<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title', 'Đăng nhập'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Website Bán Quần Áo STYLEX" name="description" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.ico')); ?>">

    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?php echo e(asset('assets/css/custom.min.css')); ?>" rel="stylesheet" type="text/css" />
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #666;
            margin: 0;
        }
        
        .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 0.75rem;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 4px;
            padding: 0.75rem;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 1rem;
            color: #666;
        }
        
        .login-footer a {
            color: #007bff;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
    
    <?php echo $__env->yieldPushContent('page-css'); ?>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h2><?php echo $__env->yieldContent('page-title', 'Đăng nhập'); ?></h2>
            <p><?php echo $__env->yieldContent('page-subtitle', 'Chào mừng bạn đến với STYLEX'); ?></p>
        </div>
        
        <div class="login-body">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        
        <div class="login-footer">
            <?php echo $__env->yieldContent('footer'); ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo e(asset('assets/libs/jquery/jquery.min.js')); ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo e(asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/auth/layout.blade.php ENDPATH**/ ?>