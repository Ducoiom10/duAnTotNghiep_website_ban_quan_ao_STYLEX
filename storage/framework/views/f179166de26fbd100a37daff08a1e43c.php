<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $__env->yieldContent('title', env('APP_NAME')); ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
	<?php echo $__env->make('client.partials.css.css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="animsition">
	
	<!-- Header -->
	<header class="header-v4">
		<!-- Header menu desktop -->
        <?php echo $__env->make('client.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- mobile reponsive -->
         <?php echo $__env->make('client.partials.mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		
	</header>

	<!-- Cart -->
    <?php echo $__env->make('client.partials.cart', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<!-- Chat Box -->
    <?php echo $__env->make('client.partials.chat', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<!-- Content -->
	<?php echo $__env->yieldContent('content'); ?>

	<!-- Footer -->
    <?php echo $__env->make('client.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!--===============================================================================================-->	
<?php echo $__env->make('client.partials.js.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<!--===============================================================================================-->
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\layouts\app.blade.php ENDPATH**/ ?>