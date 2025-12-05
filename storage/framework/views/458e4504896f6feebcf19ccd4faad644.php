<table class="table-shopping-cart">
	<tr class="table_head">
		<th class="column-0">
			<input type="checkbox" id="select-all-header" title="Chọn tất cả">
		</th>
		<th class="column-1">Sản phẩm</th>
		<th class="column-2">Tên</th>
		<th class="column-3">Loại</th>
		<th class="column-4">Giá</th>
		<th class="column-5">Số lượng</th>
		<th class="column-6">Số tiền</th>
		<th class="column-7">Thao tác</th>
	</tr>

	<?php /* grand from controller-provided $total; avoid heavy PHP in Blade */ ?>
	<?php if(!empty($cartData) && count($cartData)): ?>
		<?php $__currentLoopData = $cartData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$img = $item['image_url'] ?? ($item['product']->default_image_url ?? asset('client/images/product-01.jpg'));
			$qty = (int)($item['quantity'] ?? 1);
			$price = (float)($item['price'] ?? 0);
			$line = (float)($item['line_total'] ?? ($qty * $price));
			
			$sizeName = $item['size'] ?? null;
			$colorName = $item['color'] ?? null; // Single color
			$textures = $item['textures'] ?? []; // Array of textures
			
			// Show price range if different variants have different prices
			$priceDisplay = $price;
			if (isset($item['min_price']) && isset($item['max_price']) && $item['min_price'] != $item['max_price']) {
				$priceDisplay = number_format($item['min_price'], 0, ',', '.') . ' - ' . number_format($item['max_price'], 0, ',', '.');
			}
		?>
		<tr class="table_row align-middle" 
			data-cart-ids="<?php echo e(json_encode($item['ids'] ?? [$item['id']])); ?>" 
			data-price="<?php echo e($price); ?>" 
			data-qty="<?php echo e($qty); ?>"
			data-item-data="<?php echo e(json_encode($item['items'] ?? [])); ?>">
			<td class="column-0">
				<input type="checkbox" class="item-checkbox" data-cart-ids="<?php echo e(json_encode($item['ids'] ?? [$item['id']])); ?>">
			</td>
			<td class="column-1">
				<div class="how-itemcart1">
					<img src="<?php echo e($img); ?>" alt="IMG">
				</div>
			</td>
			<td class="column-2">
				<a href="<?php echo e(route('client.products.show', $item['product']->id)); ?>" class="stext-104 cl4 hov-cl1 trans-04"><?php echo e($item['product']->name); ?></a>
			</td>
			<td class="column-3">
				<div style="display: flex; flex-direction: column; gap: 6px;">
					<!-- Size và Màu cùng 1 hàng -->
					<div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
						<?php if($sizeName): ?>
						<span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #fff; border: 1px solid #ddd; border-radius: 12px; font-size: 12px; color: #333; font-weight: 500;">
							<i class="zmdi zmdi-ruler" style="font-size: 14px; margin-right: 4px; color: #666;"></i>
							<?php echo e($sizeName); ?>

						</span>
						<?php endif; ?>
						<?php if($colorName): ?>
						<span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #fff; border: 1px solid #ddd; border-radius: 12px; font-size: 12px; color: #333; font-weight: 500;">
							<i class="zmdi zmdi-palette" style="font-size: 14px; margin-right: 4px; color: #666;"></i>
							<?php echo e($colorName); ?>

						</span>
						<?php endif; ?>
					</div>
					<!-- Chất liệu ở hàng dưới - hiển thị tất cả -->
					<?php if(!empty($textures) && is_array($textures) && count($textures) > 0): ?>
					<div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
						<?php $__currentLoopData = $textures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $texture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(!empty($texture)): ?>
							<span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #fff; border: 1px solid #ddd; border-radius: 12px; font-size: 12px; color: #333; font-weight: 500;">
								<i class="zmdi zmdi-texture" style="font-size: 14px; margin-right: 4px; color: #666;"></i>
								<?php echo e(is_string($texture) ? $texture : ($texture->name ?? '')); ?>

							</span>
							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
					<?php if(!$sizeName && !$colorName && empty($textures)): ?>
					<span class="stext-110" style="color:#999; font-size:13px;">-</span>
					<?php endif; ?>
				</div>
			</td>
			<td class="column-4">
				<?php if(is_string($priceDisplay) && strpos($priceDisplay, ' - ') !== false): ?>
					<?php echo e($priceDisplay); ?> ₫
				<?php else: ?>
					<?php echo e(number_format($price, 0, ',', '.')); ?> ₫
				<?php endif; ?>
			</td>
			<td class="column-5">
				<div class="wrap-num-product flex-w m-l-auto m-r-0">
					<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" data-action="dec" data-cart-ids="<?php echo e(json_encode($item['ids'] ?? [$item['id']])); ?>">
						<i class="fs-16 zmdi zmdi-minus"></i>
					</div>
					<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product-<?php echo e($item['id']); ?>" value="<?php echo e($qty); ?>" min="1" data-cart-ids="<?php echo e(json_encode($item['ids'] ?? [$item['id']])); ?>">
					<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" data-action="inc" data-cart-ids="<?php echo e(json_encode($item['ids'] ?? [$item['id']])); ?>">
						<i class="fs-16 zmdi zmdi-plus"></i>
					</div>
				</div>
			</td>
			<td class="column-6 line-total"><?php echo e(number_format($line, 0, ',', '.')); ?> ₫</td>
			<td class="column-7">
				<button type="button" class="delete-line" data-cart-ids="<?php echo e(json_encode($item['ids'] ?? [$item['id']])); ?>" title="Xóa" style="background:none;border:none;cursor:pointer;">
					<i class="zmdi zmdi-close"></i>
				</button>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr>
			<td colspan="8" class="text-center p-tb-40">
				<p class="stext-106 cl6">Giỏ hàng trống</p>
				<a href="<?php echo e(route('client.products.index')); ?>" class="stext-106 cl6 hov1 trans-04">Tiếp tục mua sắm</a>
			</td>
		</tr>
	<?php endif; ?>
</table>

<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\carts\partials\table.blade.php ENDPATH**/ ?>