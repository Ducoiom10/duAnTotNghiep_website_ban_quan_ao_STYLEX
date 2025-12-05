<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleX</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">

    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; padding:20px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <h2 style="color:#333; text-align:center;">Xin chào <?php echo e($name); ?> </h2>

        <p style="font-size:15px; color:#444; line-height:1.6;">
            Cảm ơn bạn đã đăng ký tài khoản tại <strong><?php echo e(config('app.name')); ?></strong>.
            Vui lòng nhấn vào nút bên dưới để <b>xác thực email</b> của bạn:
        </p>

        <div style="text-align:center; margin: 30px 0;">
            <a href="<?php echo e($url); ?>" 
               style="display:inline-block; background:#28a745; color:#fff; text-decoration:none; 
                      padding:12px 20px; border-radius:6px; font-size:16px; font-weight:600;">
                Xác thực tài khoản
            </a>
        </div>

        <p style="font-size:14px; color:#666; line-height:1.6;">
            Nếu bạn không thực hiện hành động này, vui lòng bỏ qua email này.
        </p>

        <hr style="margin:20px 0; border:none; border-top:1px solid #ddd;">

        <p style="font-size:13px; color:#999; text-align:center;">
            Thư này được gửi tự động từ hệ thống, vui lòng không trả lời.<br>
            &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?> Team
        </p>
    </div>

</body>
</html><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\admin\mails\verification.blade.php ENDPATH**/ ?>