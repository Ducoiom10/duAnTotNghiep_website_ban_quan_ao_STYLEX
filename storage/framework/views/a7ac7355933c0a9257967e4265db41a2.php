<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Xác thực email - <?php echo e(config('app.name')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap Css -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo e(asset('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo e(asset('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?php echo e(asset('assets/css/custom.min.css')); ?>" rel="stylesheet" type="text/css" />
    
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
        
        .verification-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 3rem;
            text-align: center;
        }
        
        .verification-icon {
            font-size: 80px;
            margin-bottom: 1.5rem;
        }
        
        .verification-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .verification-message {
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="verification-container">
        <?php if(strpos($msg, 'thành công') !== false || strpos($msg, 'success') !== false): ?>
            <div class="verification-icon">
                <i class="ri-checkbox-circle-line text-success"></i>
            </div>
            <h3 class="verification-title text-success"><?php echo e($msg); ?></h3>
            <p class="verification-message">Bạn có thể đăng nhập vào tài khoản của mình ngay bây giờ.</p>
            <a href="<?php echo e(route('loginView')); ?>" class="btn btn-primary btn-lg">
                <i class="ri-login-box-line me-2"></i> Đăng nhập ngay
            </a>
        <?php else: ?>
            <div class="verification-icon">
                <i class="ri-error-warning-line text-warning"></i>
            </div>
            <h3 class="verification-title text-warning"><?php echo e($msg); ?></h3>
            <p class="verification-message">Vui lòng kiểm tra email và thử lại với link mới.</p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="<?php echo e(route('registerView')); ?>" class="btn btn-outline-secondary">
                    <i class="ri-arrow-left-line me-2"></i> Quay lại đăng ký
                </a>
                <a href="<?php echo e(route('loginView')); ?>" class="btn btn-primary">
                    <i class="ri-login-box-line me-2"></i> Đăng nhập
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\auth\verification\verification-message.blade.php ENDPATH**/ ?>