<!-- Filter -->
<div class="dis-none panel-filter w-full p-t-10">
	<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
		<div class="filter-col1 p-r-15 p-b-27">
			<div class="mtext-102 cl2 p-b-15">
				Sắp Xếp Theo
			</div>

			<ul>
				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 filter-link-active js-sort-filter" data-sort="relevance">
						Mặc Định
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-sort-filter" data-sort="newest">
						Mới Nhất
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-sort-filter" data-sort="price_asc">
						Giá: Thấp Đến Cao
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-sort-filter" data-sort="price_desc">
						Giá: Cao Đến Thấp
					</a>
				</li>
			</ul>
		</div>

		<div class="filter-col2 p-r-15 p-b-27">
			<div class="mtext-102 cl2 p-b-15">
				Giá
			</div>

			<ul>
				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 filter-link-active js-price-filter" data-min="" data-max="">
						Tất Cả
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-price-filter" data-min="0" data-max="500000">
						0đ - 500.000đ
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-price-filter" data-min="500000" data-max="1000000">
						500.000đ - 1.000.000đ
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-price-filter" data-min="1000000" data-max="1500000">
						1.000.000đ - 1.500.000đ
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-price-filter" data-min="1500000" data-max="2000000">
						1.500.000đ - 2.000.000đ
					</a>
				</li>

				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 js-price-filter" data-min="2000000" data-max="">
						2.000.000đ+
					</a>
				</li>
			</ul>
		</div>

		<div class="filter-col3 p-r-15 p-b-27">
			<div class="mtext-102 cl2 p-b-15">
				Chất liệu
			</div>

			<ul>
				<li class="p-b-6">
					<a href="#" class="filter-link stext-106 trans-04 filter-link-active js-texture-filter" data-texture-id="">
						Tất cả
					</a>
				</li>

				<?php if(isset($textures)): ?>
					<?php $__currentLoopData = $textures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $texture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="p-b-6">
							<a href="#"
							   class="filter-link stext-106 trans-04 js-texture-filter"
							   data-texture-id="<?php echo e($texture->id); ?>">
								<?php echo e($texture->name); ?>

							</a>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\partials\filter-product.blade.php ENDPATH**/ ?>