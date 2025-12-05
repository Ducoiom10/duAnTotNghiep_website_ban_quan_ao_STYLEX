<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực Email - Style X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verification-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo h2 {
            color: #6366f1;
            font-weight: 700;
            margin: 0;
        }
        .logo .x-text {
            color: #f59e0b;
        }
    </style>
</head>
<body>
    <div class="verification-card">
        <div class="logo">
            <h2><span class="style-text">Style</span><span class="x-text">X</span></h2>
        </div>
        
        <?php if(strpos($msg, 'thành công') !== false): ?>
            <div class="text-center mb-4">
                <i class="ri-checkbox-circle-fill text-success" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-success text-center mb-3">Xác thực thành công!</h4>
        <?php else: ?>
            <div class="text-center mb-4">
                <i class="ri-error-warning-fill text-danger" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-danger text-center mb-3">Xác thực thất bại!</h4>
        <?php endif; ?>
        
        <p class="text-muted text-center mb-4"><?php echo e($msg); ?></p>
        
        <div class="d-grid gap-2">
            <a href="<?php echo e(route('loginView')); ?>" class="btn btn-primary">
                <i class="ri-login-box-line me-2"></i>Đăng nhập ngay
            </a>
            <a href="<?php echo e(route('registerView')); ?>" class="btn btn-outline-secondary">
                <i class="ri-user-add-line me-2"></i>Đăng ký tài khoản mới
            </a>
        </div>
    </div>
</body>
</html>
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\auth\verification\verification-message.blade.php ENDPATH**/ ?>