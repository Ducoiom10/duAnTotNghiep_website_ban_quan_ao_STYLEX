	<style>
		/* Mini-cart polish */
		.header-cart-item { display: flex; align-items: flex-start; gap: 12px; padding: 8px 6px; border-radius: 8px; transition: background-color .2s ease; }
		.header-cart-item:hover { background: #fafafa; }
		.header-cart-item-img img { width: 56px; height: 56px; border-radius: 8px; object-fit: cover; display: block; }
		.header-cart-item-name { font-weight: 600; color: #333; }
		.header-cart-item-info { color: #555; font-weight: 500; }
		.delete-item i { font-size: 18px; color: #999; }
		.delete-item:hover i { color: #333; }
		/* Panel sizing & balance */
		.header-cart { width: 360px; max-width: 92vw; height: 100vh; }
		.header-cart-title { border-bottom: 1px solid #f0f0f0; margin-bottom: 10px; padding-bottom: 6px; }
		#cartContent { padding-top: 6px; }
		#cartFooter .header-cart-total { padding-top: 16px; padding-bottom: 16px; }
	</style>
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-35 p-r-35 p-t-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-15">
				<h4 class="mtext-103 cl2" style="font-size: 20px; font-weight: bold;">
					Giỏ Hàng <span id="cartItemCount" style="font-weight: normal; font-size: 14px; color:#888;">(<?php echo e((int)($headerCartItemCount ?? 0)); ?>)</span>
				</h4>

				<button class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart" style="background: none; border: none; cursor: pointer;">
					<i class="zmdi zmdi-close"></i>
				</button>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll" id="cartContent" style="flex: 1; overflow-y: auto; display: flex; flex-direction: column;">
				<ul class="header-cart-wrapitem w-full" id="cartItems" style="flex: 1; overflow-y: auto;">
					<?php if(empty($headerCartItems) || !count($headerCartItems)): ?>
						<li class="header-cart-empty" style="padding: 60px 20px; text-align: center; color: #999;">
							<p style="margin-top: 20px; font-size: 16px;">Giỏ hàng trống</p>
						</li>
					<?php else: ?>
						<?php $__currentLoopData = $headerCartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="header-cart-item flex-w flex-t m-b-12" data-cart-id="<?php echo e($it['id']); ?>">
							<div class="header-cart-item-img">
								<img src="<?php echo e($it['product']->default_image_url ?? ''); ?>" alt="IMG" />
							</div>
							<div class="header-cart-item-txt p-t-8" style="flex:1;">
								<div class="d-flex justify-content-between align-items-start">
									<a href="<?php echo e(isset($it['product']->id) ? route('client.products.show', $it['product']->id) : '#'); ?>" class="header-cart-item-name m-b-5 hov-cl1 trans-04"><?php echo e($it['product']->name ?? 'Sản phẩm'); ?></a>
								</div>
								<?php
									$v = $it['variant'] ?? null;
									$sizeName = $it['size'] ?? ($v && $v->size ? ($v->size->name ?? null) : null);
									$colorName = $it['color'] ?? ($v && $v->color ? ($v->color->name ?? null) : null);
								?>
								<?php if($sizeName || $colorName): ?>
									<div class="stext-110" style="margin: 2px 0 6px; display:flex; gap:6px; flex-wrap:wrap;">
										<?php if($sizeName): ?>
											<span style="background:#f6f6f6; color:#333; border:1px solid #ebebeb; border-radius:10px; padding:1px 6px; font-size:11px;">Size: <?php echo e($sizeName); ?></span>
										<?php endif; ?>
										<?php if($colorName): ?>
											<span style="background:#f6f6f6; color:#333; border:1px solid #ebebeb; border-radius:10px; padding:1px 6px; font-size:11px;">Màu: <?php echo e($colorName); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<span class="header-cart-item-info"><?php echo e((int)($it['quantity'] ?? 1)); ?> x <?php echo e(number_format((float)($it['price'] ?? 0), 0, ',', '.')); ?> ₫</span>
							</div>
							<button class="delete-item" type="button" data-cart-id="<?php echo e($it['id']); ?>" title="Xóa" style="margin-left:auto; background: none; border: none; cursor: pointer; align-self:center;">
								<i class="zmdi zmdi-close"></i>
							</button>
						</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				</ul>
				<?php if(!empty($headerCartItems) && count($headerCartItems)): ?>
				<div class="w-full" id="cartFooter" style="flex-shrink: 0; border-top: 1px solid #e8e8e8; margin-top: auto;">
					<div class="header-cart-total w-full p-tb-30" id="cartTotal">
						<div class="flex-w flex-sb-m">
							<span class="mtext-107 cl2" style="font-size: 18px; font-weight: 600;">Tổng cộng:</span>
							<span class="mtext-106 cl2" id="totalAmount" style="font-size: 20px; font-weight: 700; color: #666;"><?php echo e(number_format((float)($headerCartTotal ?? 0), 0, ',', '.')); ?> ₫</span>
						</div>
					</div>
					<div class="header-cart-buttons flex-w w-full" style="gap: 10px;">
						<a href="<?php echo e(route('client.cart.index')); ?>" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10" style="flex: 1; text-align: center; text-decoration: none;">Xem Giỏ Hàng</a>
						<!-- <a href="<?php echo e(route('client.checkout.index')); ?>" class="flex-c-m stext-101 cl0 size-107 bg1 bor2 hov-btn3 p-lr-15 trans-04 m-b-10" style="flex: 1; background: #333;">Thanh Toán</a> -->
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	
<?php /**PATH C:\laragon\www\duAnTotNghiep_website_ban_quan_ao_STYLEX-main\resources\views/client/partials/cart.blade.php ENDPATH**/ ?>