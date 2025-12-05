<!-- Content -->
<div class="wrap-modal1 js-modal1 p-t-60 p-b-20 <?php echo e(isset($quickProduct) && $quickProduct ? 'show-modal1' : ''); ?>">
	<div class="overlay-modal1 js-hide-modal1"></div>

	<div class="container">
		<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
			<button class="how-pos3 hov3 trans-04 js-hide-modal1">
				<img src="<?php echo e(asset('client/images/icons/icon-close.png')); ?>" alt="CLOSE">
			</button>

			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                <?php if(isset($quickProduct) && $quickProduct): ?>
                                    <?php if($quickProduct->productImages && $quickProduct->productImages->count() > 0): ?>
                                        <?php $__currentLoopData = $quickProduct->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item-slick3" data-thumb="<?php echo e(Storage::url($image->image_path)); ?>">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="<?php echo e(Storage::url($image->image_path)); ?>" alt="<?php echo e($quickProduct->name); ?>" class="product-image">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?php echo e(Storage::url($image->image_path)); ?>">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="item-slick3" data-thumb="<?php echo e($quickProduct->default_image_url); ?>">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="<?php echo e($quickProduct->default_image_url); ?>" alt="<?php echo e($quickProduct->name); ?>" class="product-image">
                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?php echo e($quickProduct->default_image_url); ?>">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
						</div>
					</div>
				</div>
				
				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            <?php echo e($quickProduct->name ?? ''); ?>

                        </h4>

                        <span class="mtext-106 cl2 js-price-detail">
                            <?php if(isset($quickProduct) && $quickProduct): ?>
                                <?php if($quickProduct->price_sale && $quickProduct->price_sale < $quickProduct->price): ?>
                                    <span class="fw-bold"><?php echo e(number_format($quickProduct->price_sale, 0, ',', '.')); ?>đ</span>
                                    <span style="text-decoration: line-through; color: red;"><?php echo e(number_format($quickProduct->price, 0, ',', '.')); ?>đ</span>
                                <?php else: ?>
                                    <?php echo e(number_format($quickProduct->price, 0, ',', '.')); ?>đ
                                <?php endif; ?>
                            <?php endif; ?>
                        </span>

                        <p class="stext-102 cl3 p-t-23 js-description-detail">
                            <?php echo e($quickProduct->description ?? ''); ?>

                        </p>
						
						<!-- Product Options -->
                        <div class="p-t-33 js-product-options">
                            <?php
                                $sizes = isset($quickProduct) && $quickProduct && $quickProduct->productVariants ? $quickProduct->productVariants->pluck('size.name')->unique()->filter() : collect();
                                $colors = isset($quickProduct) && $quickProduct && $quickProduct->productVariants ? $quickProduct->productVariants->pluck('color.name')->unique()->filter() : collect();
                            ?>
                            <?php if($sizes->count() > 0): ?>
                            <div class="flex-w flex-r-m p-b-10 js-size-option">
								<div class="size-203 flex-c-m respon6">
									Kích Thước
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="size" id="size-select">
                                            <option value="">Chọn kích thước</option>
                                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($size); ?>"><?php echo e($size); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>
                            <?php endif; ?>
                            <?php if($colors->count() > 0): ?>
                            <div class="flex-w flex-r-m p-b-10 js-color-option">
								<div class="size-203 flex-c-m respon6">
									Màu Sắc
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
                                        <select class="js-select2" name="color" id="color-select">
                                            <option value="">Chọn màu sắc</option>
                                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color); ?>"><?php echo e($color); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
										<div class="dropDownSelect2"></div>
									</div>
								</div>
							</div>
                            <?php endif; ?>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <?php if(isset($quickProduct) && $quickProduct): ?>
                                    <?php
                                        $variantsForJson = $quickProduct->productVariants->map(function($v) {
                                            return [
                                                'id' => $v->id,
                                                'size' => $v->size ? ['name' => $v->size->name] : null,
                                                'color' => $v->color ? ['name' => $v->color->name] : null,
                                                'texture' => $v->texture ? ['name' => $v->texture->name] : null,
                                            ];
                                        })->values();
                                    ?>
                                    <div data-variants='<?php echo json_encode($variantsForJson, 15, 512) ?>'>
                                    <form method="POST" action="<?php echo e(route('client.cart.add')); ?>" class="flex-w flex-m w-full" data-ajax="1">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($quickProduct->id); ?>">
                                        <input type="hidden" name="variant_id" value="">
                                        <input type="hidden" name="size_name" value="">
                                        <input type="hidden" name="color_name" value="">
                                        <input type="hidden" name="texture_name" value="">

                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value="1" min="1">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>

                                        <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                            Thêm vào giỏ
                                        </button>
                                        <a class="flex-c-m stext-101 cl2 size-101 bg0 bor1 hov-btn2 p-lr-15 trans-04 m-l-10 js-view-detail" href="<?php echo e(route('client.products.show', $quickProduct->id)); ?>" target="_self">
                                            Xem chi tiết
                                        </a>
                                    </form>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div> 
						</div>

						<!-- Social Share -->
						<div class="flex-w flex-m p-l-100 p-t-40 respon7">
							<div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Thêm vào yêu thích">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
								<i class="fa fa-facebook"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
								<i class="fa fa-twitter"></i>
							</a>

							<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
								<i class="fa fa-google-plus"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    $hasQuickProduct = !empty($quickProduct);
?>
<script>
$(document).ready(function() {
    var hasQuickProduct = <?php echo json_encode($hasQuickProduct); ?>;
    var lastQuickAddForm = null;

    if (hasQuickProduct) {
        var $gallery = $('.slick3');
        if ($gallery.length && !$gallery.hasClass('slick-initialized')) {
            $gallery.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                infinite: true,
                autoplay: false,
                autoplaySpeed: 6000,
                arrows: true,
                dots: true,
                prevArrow: '<button class="arrow-slick3 prev-slick3"><i class="zmdi zmdi-caret-left"></i></button>',
                nextArrow: '<button class="arrow-slick3 next-slick3"><i class="zmdi zmdi-caret-right"></i></button>',
            });
        }
        $('.js-modal1').addClass('show-modal1');
    }

    $('#size-select, #color-select').on('change', function() {
        var size = $('#size-select').val();
        var color = $('#color-select').val();
        $('input[name="size_name"]').val(size || '');
        $('input[name="color_name"]').val(color || '');
    });
    
    $(document).on('submit', 'form[data-ajax="1"][action$="/cart/add"]', function() {
        lastQuickAddForm = this;
    });

    $(document).ajaxSuccess(function(event, xhr) {
        if (!lastQuickAddForm) {
            return;
        }
        var $triggerForm = $(lastQuickAddForm);
        lastQuickAddForm = null;
        if ($triggerForm.closest('.js-modal1').length && xhr.responseJSON && xhr.responseJSON.success) {
            setTimeout(function() {
                $('.js-modal1').removeClass('show-modal1');
                if (window.history && window.history.replaceState) {
                    var url = new URL(window.location);
                    url.searchParams.delete('quick_view');
                    window.history.replaceState({}, '', url);
                }
            }, 1500);
        }
    });
});
</script>

<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\products\mini-product.blade.php ENDPATH**/ ?>