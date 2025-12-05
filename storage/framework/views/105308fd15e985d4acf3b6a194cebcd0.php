	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Danh Mục
					</h4>

					<?php
						// Lấy danh mục hiển thị ở footer: ưu tiên $categories nếu controller đã truyền
						$footerCategories = null;
						if (isset($categories) && $categories instanceof \Illuminate\Support\Collection && $categories->count() > 0) {
							$footerCategories = $categories->take(4);
						} else {
							$footerCategories = \App\Models\Category::query()
								->where('status', 1)
								->orderBy('id')
								->take(4)
								->get();
						}
					?>
					<ul>
						<?php $__empty_1 = true; $__currentLoopData = $footerCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
							<li class="p-b-10">
								<a href="<?php echo e(route('client.products.index', ['category' => $category->id])); ?>" class="stext-107 cl7 hov-cl1 trans-04">
									<?php echo e($category->name); ?>

								</a>
							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
							<li class="p-b-10">
								<a href="<?php echo e(route('client.products.index')); ?>" class="stext-107 cl7 hov-cl1 trans-04">
									Nữ
								</a>
							</li>
							<li class="p-b-10">
								<a href="<?php echo e(route('client.products.index')); ?>" class="stext-107 cl7 hov-cl1 trans-04">
									Nam
								</a>
							</li>
							<li class="p-b-10">
								<a href="<?php echo e(route('client.products.index')); ?>" class="stext-107 cl7 hov-cl1 trans-04">
									Giày dép
								</a>
							</li>
							<li class="p-b-10">
								<a href="<?php echo e(route('client.products.index')); ?>" class="stext-107 cl7 hov-cl1 trans-04">
									Phụ kiện
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns 
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="<?php echo e(asset('client/images/icons/icon-pay-01.png')); ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?php echo e(asset('client/images/icons/icon-pay-02.png')); ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?php echo e(asset('client/images/icons/icon-pay-03.png')); ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?php echo e(asset('client/images/icons/icon-pay-04.png')); ?>" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="<?php echo e(asset('client/images/icons/icon-pay-05.png')); ?>" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					Copyright &copy;2025
			</div>
		</div>
	</footer>
	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\partials\footer.blade.php ENDPATH**/ ?>