	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
				<?php
					// Lấy danh sách banner đã được truyền từ HomeController (nếu có)
					$bannersList = isset($banners) ? $banners : collect();
				?>

				<?php if($bannersList->count() > 0): ?>
					<?php $__currentLoopData = $bannersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="item-slick1" style="background-image: url('<?php echo e($banner->image); ?>');">
						<div class="container h-full">
							<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
								<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
									<span class="ltext-101 cl2 respon2">
										<?php echo e($banner->title); ?>

									</span>
								</div>
									
								<?php if(!empty($banner->content)): ?>
								<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
									<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
										<?php echo e($banner->content); ?>

									</h2>
								</div>
								<?php endif; ?>
									
								<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
									<a href="<?php echo e($banner->redirect_url ? url($banner->redirect_url) : route('client.products.index')); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
										Truy cập ngay
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
					
				<div class="item-slick1" style="background-image: url(images/slide-01.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Bộ sưu tập Danh Mục 2025
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									BỘ SƯU TẬP MỚI
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="<?php echo e(route('client.products.index')); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Truy cập ngay
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/slide-02.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Men New-Season
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Jackets & Coats
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="<?php echo e(route('client.products.index')); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(images/slide-03.jpg);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Men Collection 2018
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									New arrivals
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="<?php echo e(route('client.products.index')); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Shop Now
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>


	<!-- Banner -->
	<div class="sec-banner bg0 p-t-80 p-b-50">
		<div class="container">
			<div class="row">

				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
						<img src="<?php echo e(asset('client/images/banner-02.jpg')); ?>" alt="IMG-BANNER">

						<a href="<?php echo e(isset($categories) && $categories->count() > 0 ? route('client.products.index', ['category' => $categories[0]->id]) : route('client.products.index')); ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?php if(isset($categories) && $categories->count() > 0): ?>
										<?php echo e($categories[0]->name); ?>

									<?php else: ?>
										Women
									<?php endif; ?>
								</span>

								<span class="block1-info stext-102 trans-04">
									Mùa đông 2025
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Truy cập ngay
								</div>
							</div>
						</a>
					</div>						
				</div>

				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
					<img src="<?php echo e(asset('client/images/banner-01.jpg')); ?>" alt="IMG-BANNER">
						<a href="<?php echo e(isset($categories) && $categories->count() > 1 ? route('client.products.index', ['category' => $categories[1]->id]) : route('client.products.index')); ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?php if(isset($categories) && $categories->count() > 1): ?>
										<?php echo e($categories[1]->name); ?>

									<?php else: ?>
										Men
									<?php endif; ?>
								</span>

								<span class="block1-info stext-102 trans-04">
									Mùa đông 2025
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Truy cập ngay
								</div>
							</div>
						</a>
					</div>						
				</div>

				<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
					<!-- Block1 -->
					<div class="block1 wrap-pic-w">
					<img src="<?php echo e(asset('client/images/banner-03.jpg')); ?>" alt="IMG-BANNER">

						<a href="<?php echo e(isset($categories) && $categories->count() > 2 ? route('client.products.index', ['category' => $categories[2]->id]) : route('client.products.index')); ?>" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
							<div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									<?php if(isset($categories) && $categories->count() > 2): ?>
										<?php echo e($categories[2]->name); ?>

									<?php else: ?>
										Bag
									<?php endif; ?>
								</span>

								<span class="block1-info stext-102 trans-04">
									Mùa đông 2025
								</span>
							</div>

							<div class="block1-txt-child2 p-b-4 trans-05">
								<div class="block1-link stext-101 cl0 trans-09">
									Truy cập ngay
								</div>
							</div>
						</a>
					</div>						
				</div>


			</div>
		</div>
	</div><?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/client/partials/banner.blade.php ENDPATH**/ ?>