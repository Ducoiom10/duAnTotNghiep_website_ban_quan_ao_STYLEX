

<?php $__env->startSection('title', 'Giỏ Hàng - ' . env('APP_NAME')); ?>

<?php $__env->startSection('content'); ?>
<style>
	/* Cart Dropdown Styles */
	.cart-dropdown-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 8px;
		margin-bottom: 10px;
	}
	
	.cart-dropdown-title {
		margin: 0;
		font-size: 16px;
		font-weight: 600;
		color: #333;
	}
	
	.cart-dropdown-wrapper {
		position: relative;
	}
	
	.cart-dropdown-btn {
		background: #6777ef;
		border: none;
		padding: 4px 8px;
		border-radius: 4px;
		color: white;
		cursor: pointer;
		font-size: 12px;
		transition: all 0.2s;
		display: flex;
		align-items: center;
		gap: 6px;
	}
	
	.cart-dropdown-btn:hover {
		background: #5568d3;
	}
	
	.cart-dropdown-btn:focus {
		outline: none;
		box-shadow: 0 0 0 2px rgba(103, 119, 239, 0.25);
	}
	
	.cart-dropdown-btn i {
		font-size: 10px;
		transition: transform 0.2s;
	}
	
	.cart-dropdown-btn.active i {
		transform: rotate(180deg);
	}
	
	.cart-dropdown-menu {
		display: none;
		position: absolute;
		right: 0;
		top: 100%;
		margin-top: 6px;
		min-width: 320px;
		max-width: 360px;
		max-height: 240px;
		overflow-y: auto;
		background: white;
		border-radius: 8px;
		box-shadow: 0 8px 24px rgba(0,0,0,0.16);
		z-index: 1000;
		padding: 8px;
	}
	
	.cart-dropdown-menu.show {
		display: block;
	}
	
	.cart-dropdown-item {
		padding: 8px 10px;
		border-bottom: 1px solid #f3f3f3;
		display: flex;
		align-items: center;
		gap: 10px;
		cursor: pointer;
		transition: background 0.2s;
		border-radius: 6px;
	}
	
	.cart-dropdown-item:hover {
		background-color: #f8f9fa;
	}
	
	.cart-dropdown-item:last-child {
		border-bottom: none;
	}
	
	.cart-dropdown-img {
		width: 44px;
		height: 44px;
		object-fit: cover;
		border-radius: 6px;
		flex-shrink: 0;
	}
	
	.cart-dropdown-content {
		flex: 1;
		min-width: 0;
	}
	
	.cart-dropdown-name {
		color: #333;
		text-decoration: none;
		font-weight: 600;
		font-size: 13px;
		display: block;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		line-height: 1.35;
	}
	
	.cart-dropdown-name:hover {
		color: #6777ef;
	}
	
	.cart-dropdown-info {
		color: #666;
		display: block;
		margin-top: 2px;
		font-size: 11px;
	}
	
	/* Scrollbar styling */
	.cart-dropdown-menu::-webkit-scrollbar {
		width: 6px;
	}
	
	.cart-dropdown-menu::-webkit-scrollbar-track {
		background: #f1f1f1;
		border-radius: 3px;
	}
	
	.cart-dropdown-menu::-webkit-scrollbar-thumb {
		background: #ccc;
		border-radius: 3px;
	}
	
	.cart-dropdown-menu::-webkit-scrollbar-thumb:hover {
		background: #aaa;
	}
</style>

<!-- breadcrumb -->
<div class="container">
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="<?php echo e(route('home')); ?>" class="stext-109 cl8 hov-cl1 trans-04">
			Trang Chủ
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>

		<span class="stext-109 cl4">
			Giỏ Hàng
		</span>
	</div>
</div>

<!-- Shoping Cart -->
<?php if(session('error')): ?>
<div class="container m-t-20">
	<div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:10px 14px; border-radius:6px; margin-bottom:10px; font-size:14px;">
		<?php echo e(session('error')); ?>

	</div>
</div>
<?php endif; ?>

<form class="bg0 p-t-75 p-b-85">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<?php if(count($cartData) > 0): ?>
					<div class="cart-dropdown-header">
						<h4 class="cart-dropdown-title">Giỏ hàng của bạn (<?php echo e(count($cartData)); ?> sản phẩm)</h4>
						<div class="cart-dropdown-wrapper">
							<button class="cart-dropdown-btn" type="button" id="cartDropdown">
								Xem tất cả <i class="fa fa-chevron-down"></i>
							</button>
							<div class="cart-dropdown-menu" id="cartDropdownMenu">
								<?php $__currentLoopData = $cartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cart-dropdown-item">
									<?php
										if (isset($item['image_url'])) {
											$imageUrl = $item['image_url'];
										} else {
											$firstImage = $item['product']->productImages->first();
											if ($firstImage) {
												$imagePath = public_path($firstImage->image_path);
												$imageUrl = file_exists($imagePath) ? asset($firstImage->image_path) : asset('client/images/product-01.jpg');
											} else {
												$imageUrl = asset('client/images/product-01.jpg');
											}
										}
									?>
									<img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($item['product']->name); ?>" class="cart-dropdown-img">
									<div class="cart-dropdown-content">
										<a href="<?php echo e(route('client.products.show', $item['product']->id)); ?>" class="cart-dropdown-name">
											<?php echo e($item['product']->name); ?>

										</a>
										<small class="cart-dropdown-info">
											x<?php echo e($item['quantity']); ?> - <?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?> ₫
										</small>
									</div>
								</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>
					
					<div class="wrap-table-shopping-cart">
						<table class="table-shopping-cart">
							<tr class="table-head">
								<th class="column-1">Sản Phẩm</th>
								<th class="column-2"></th>
								<th class="column-3">Giá</th>
								<th class="column-4">Số Lượng</th>
								<th class="column-5">Tổng</th>
								<th class="column-6"></th>
							</tr>

							<tbody id="cartItems">
								<?php if(count($cartData) > 0): ?>
									<?php $__currentLoopData = $cartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr class="table-row" data-cart-id="<?php echo e($item['id']); ?>">
										<td class="column-1">
											<div class="how-itemcart1">
												<?php
													// Lấy image_url từ controller nếu có, nếu không thì fallback về cách cũ
													if (isset($item['image_url'])) {
														$imageUrl = $item['image_url'];
													} else {
														$firstImage = $item['product']->productImages->first();
														if ($firstImage) {
															// Check if image exists in uploads folder
															$imagePath = public_path($firstImage->image_path);
															$imageUrl = file_exists($imagePath) ? asset($firstImage->image_path) : asset('client/images/product-01.jpg');
														} else {
															$imageUrl = asset('client/images/product-01.jpg');
														}
													}
												?>
												<img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($item['product']->name); ?>">
											</div>
										</td>
										<td class="column-2">
											<a href="<?php echo e(route('client.products.show', $item['product']->id)); ?>"><?php echo e($item['product']->name); ?></a>
											<?php if($item['size'] || $item['color']): ?>
												<br>
												<small class="text-muted">
													<?php if($item['size']): ?> Size: <?php echo e($item['size']); ?> <?php endif; ?>
													<?php if($item['size'] && $item['color']): ?> | <?php endif; ?>
													<?php if($item['color']): ?> Màu: <?php echo e($item['color']); ?> <?php endif; ?>
												</small>
											<?php endif; ?>
										</td>
										<td class="column-3"><?php echo e(number_format($item['price'], 0, ',', '.')); ?> VNĐ</td>
										<td class="column-4">
											<div class="wrap-num-product flex-w m-l-auto m-r-0">
												<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
													<i class="fs-16 zmdi zmdi-minus"></i>
												</div>

												<input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" data-cart-id="<?php echo e($item['id']); ?>">

												<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
													<i class="fs-16 zmdi zmdi-plus"></i>
												</div>
											</div>
										</td>
										<td class="column-5">
											<?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?> VNĐ
										</td>
										<td class="column-6">
											<button class="btn-remove-cart" data-cart-id="<?php echo e($item['id']); ?>">
												<i class="zmdi zmdi-close"></i>
											</button>
										</td>
									</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
									<tr>
										<td colspan="6" class="text-center" style="padding: 50px;">
											<p style="font-size: 18px; color: #888;">Giỏ hàng trống</p>
											<a href="<?php echo e(route('client.products.index')); ?>" class="stext-106 cl6 hov1 trans-04">
												Tiếp tục mua sắm
											</a>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>

					<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
						<div>
							<a href="<?php echo e(route('client.products.index')); ?>" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-10">
								Tiếp tục mua sắm
							</a>
						</div>
					</div>
				</div>
			</div>

			<?php if(count($cartData) > 0): ?>
			<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-lr-0-xl">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-r-0-lg ml-auto">
					<h4 class="mtext-109 cl2 p-b-30">
						Cart Totals
					</h4>

					<!-- Voucher Section -->
					<div class="flex-w flex-t bor12 p-b-13 p-t-13">
						<div class="size-208 w-full">
							<span class="stext-110 cl2 d-block mb-2">
								Mã giảm giá:
							</span>
							<div class="flex-w" style="gap: 8px;">
								<input type="text" 
									   id="voucherCode" 
									   class="stext-111 cl2 plh3 size-111 bor11 p-lr-20" 
									   placeholder="Nhập mã voucher"
									   style="flex: 1; border: 1px solid #e0e0e0; padding: 10px 15px; border-radius: 4px;">
								<button type="button" 
										id="applyVoucherBtn" 
										class="flex-c-m stext-101 cl0 size-112 bg1 bor11 hov-btn3 p-lr-15 trans-04"
										style="white-space: nowrap; border-radius: 4px;">
									Áp dụng
								</button>
							</div>
							<div id="voucherMessage" class="mt-2" style="font-size: 12px;"></div>
							<div id="voucherInfo" class="mt-2" style="display: none;">
								<span class="stext-110 cl2" style="color: #28a745; font-weight: 600;">
									Mã: <span id="appliedVoucherCode"></span>
								</span>
								<button type="button" 
										id="removeVoucherBtn" 
										class="stext-110 cl2 ml-2" 
										style="color: #dc3545; background: none; border: none; cursor: pointer; text-decoration: underline;">
									(Xóa)
								</button>
							</div>
						</div>
					</div>

					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2">
								Tổng:
							</span>
						</div>

						<div class="size-209">
							<span class="mtext-110 cl2" id="subtotalAmount">
								<?php echo e(number_format($total, 0, ',', '.')); ?> VNĐ
							</span>
						</div>
					</div>

					<div class="flex-w flex-t bor12 p-b-13" id="discountRow" style="display: none;">
						<div class="size-208">
							<span class="stext-110 cl2" style="color: #28a745;">
								Giảm giá:
							</span>
						</div>

						<div class="size-209">
							<span class="mtext-110 cl2" id="discountAmount" style="color: #28a745;">
								0 VNĐ
							</span>
						</div>
					</div>

					<div class="flex-w flex-t bor12 p-t-13 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2" style="font-weight: 600; font-size: 16px;">
								Thành tiền:
							</span>
						</div>

						<div class="size-209">
							<span class="mtext-110 cl2" id="totalAmount" style="font-weight: 700; font-size: 18px; color: #333;">
								<?php echo e(number_format($total, 0, ',', '.')); ?> VNĐ
							</span>
						</div>
					</div>

					<button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-tb-10" style="width: 100%;">
						Thanh Toán
					</button>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</form>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
	$(document).ready(function() {
		// Dropdown toggle functionality
		$(document).on('click', '#cartDropdown', function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).toggleClass('active');
			$('#cartDropdownMenu').toggleClass('show');
		});
		
		// Close dropdown when clicking outside
		$(document).on('click', function(e) {
			if (!$(e.target).closest('.cart-dropdown-wrapper').length) {
				$('#cartDropdown').removeClass('active');
				$('#cartDropdownMenu').removeClass('show');
			}
		});
		
		// Update quantity
		$('.num-product').on('change', function() {
			const cartId = $(this).data('cart-id');
			const quantity = $(this).val();
			
			$.ajax({
				url: '/cart/' + cartId,
				method: 'PUT',
				data: {
					quantity: quantity,
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					location.reload();
				}
			});
		});
		
		// Remove item - Direct delete without confirmation
		$('.btn-remove-cart').on('click', function() {
			const cartId = $(this).data('cart-id');
			
			$.ajax({
				url: '/cart/' + cartId,
				method: 'DELETE',
				data: {
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response) {
					location.reload();
				},
				error: function() {
					location.reload();
				}
			});
		});
	});
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\carts\index.blade.php ENDPATH**/ ?>