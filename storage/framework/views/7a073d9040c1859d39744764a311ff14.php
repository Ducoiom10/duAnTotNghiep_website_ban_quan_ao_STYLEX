<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo e(env('APP_NAME')); ?></title>
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

	<!-- Banner -->
	<?php echo $__env->make('client.partials.banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<!-- Product -->
	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					New Trend
				</h3>
			</div>

			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<a href="<?php echo e(route('client.products.index')); ?>" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 <?php echo e(!request('category') ? 'how-active1' : ''); ?>" data-filter="*">
						Tất Cả Danh Mục
					</a>

					<?php if(isset($categories) && $categories->count() > 0): ?>
						<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 <?php echo e(request('category') == $category->id ? 'how-active1' : ''); ?>" data-filter=".category-<?php echo e($category->id); ?>">
						<?php echo e($category->name); ?>

					</button>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Lọc
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Tìm Kiếm
					</div>
				</div>
				
				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Tìm kiếm sản phẩm...">
					</div>	
				</div>

				<?php echo $__env->make('client.partials.filter-product', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
			</div>

			<div class="row isotope-grid">
				<?php if(isset($products) && $products->count() > 0): ?>
					<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item category-<?php echo e($product->category_id); ?>">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="<?php echo e($product->default_image_url); ?>" alt="<?php echo e($product->name); ?>">

                            <a href="<?php echo e(route('home', ['quick_view' => $product->id])); ?>" 
                               class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Xem nhanh
                            </a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="<?php echo e(route('client.products.show', $product->id)); ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?php echo e($product->name); ?>

									</a>

									<span class="stext-105 cl3">
										<?php if($product->price_sale && $product->price_sale < $product->price): ?>
											<span class="fw-bold"><?php echo e(number_format($product->price_sale, 0, ',', '.')); ?>đ</span>
											<span style="text-decoration: line-through; color: red;"><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</span>
										<?php else: ?>
											<?php echo e(number_format($product->price, 0, ',', '.')); ?>đ
										<?php endif; ?>
									</span>
								</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2" style="margin-right: 15px;">
									<img class="icon-heart1 dis-block trans-04" src="<?php echo e(asset('client/images/icons/icon-heart-01.png')); ?>" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="<?php echo e(asset('client/images/icons/icon-heart-02.png')); ?>" alt="ICON">
								</a>
							</div>
							</div>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
					<div class="col-12 text-center">
						<p class="text-muted">Chưa có sản phẩm nào</p>
					</div>
				<?php endif; ?>
			</div>
			

			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="<?php echo e(route('client.products.index')); ?>" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
					Xem Thêm
				</a>
			</div>
		</div>
	</section>
	
	<!-- Content -->
	<?php echo $__env->make('client.products.mini-product', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<!-- Footer -->
    <?php echo $__env->make('client.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<!--===============================================================================================-->	
<?php echo $__env->make('client.partials.js.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!--===============================================================================================--><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/client/index.blade.php ENDPATH**/ ?>