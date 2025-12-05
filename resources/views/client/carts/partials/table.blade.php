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

	@php /* grand from controller-provided $total; avoid heavy PHP in Blade */ @endphp
	@if(!empty($cartData) && count($cartData))
		@foreach($cartData as $item)
		@php
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
		@endphp
		<tr class="table_row align-middle" 
			data-cart-ids="{{ json_encode($item['ids'] ?? [$item['id']]) }}" 
			data-price="{{ $price }}" 
			data-qty="{{ $qty }}"
			data-item-data="{{ json_encode($item['items'] ?? []) }}">
			<td class="column-0">
				<input type="checkbox" class="item-checkbox" data-cart-ids="{{ json_encode($item['ids'] ?? [$item['id']]) }}">
			</td>
			<td class="column-1">
				<div class="how-itemcart1">
					<img src="{{ $img }}" alt="IMG">
				</div>
			</td>
			<td class="column-2">
				<a href="{{ route('client.products.show', $item['product']->id) }}" class="stext-104 cl4 hov-cl1 trans-04">{{ $item['product']->name }}</a>
			</td>
			<td class="column-3">
				<div style="display: flex; flex-direction: column; gap: 6px;">
					<!-- Size và Màu cùng 1 hàng -->
					<div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
						@if($sizeName)
						<span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #fff; border: 1px solid #ddd; border-radius: 12px; font-size: 12px; color: #333; font-weight: 500;">
							<i class="zmdi zmdi-ruler" style="font-size: 14px; margin-right: 4px; color: #666;"></i>
							{{ $sizeName }}
						</span>
						@endif
						@if($colorName)
						<span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #fff; border: 1px solid #ddd; border-radius: 12px; font-size: 12px; color: #333; font-weight: 500;">
							<i class="zmdi zmdi-palette" style="font-size: 14px; margin-right: 4px; color: #666;"></i>
							{{ $colorName }}
						</span>
						@endif
					</div>
					<!-- Chất liệu ở hàng dưới - hiển thị tất cả -->
					@if(!empty($textures) && is_array($textures) && count($textures) > 0)
					<div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
						@foreach($textures as $texture)
							@if(!empty($texture))
							<span style="display: inline-flex; align-items: center; padding: 4px 10px; background: #fff; border: 1px solid #ddd; border-radius: 12px; font-size: 12px; color: #333; font-weight: 500;">
								<i class="zmdi zmdi-texture" style="font-size: 14px; margin-right: 4px; color: #666;"></i>
								{{ is_string($texture) ? $texture : ($texture->name ?? '') }}
							</span>
							@endif
						@endforeach
					</div>
					@endif
					@if(!$sizeName && !$colorName && empty($textures))
					<span class="stext-110" style="color:#999; font-size:13px;">-</span>
					@endif
				</div>
			</td>
			<td class="column-4">
				@if(is_string($priceDisplay) && strpos($priceDisplay, ' - ') !== false)
					{{ $priceDisplay }} ₫
				@else
					{{ number_format($price, 0, ',', '.') }} ₫
				@endif
			</td>
			<td class="column-5">
				<div class="wrap-num-product flex-w m-l-auto m-r-0">
					<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" data-action="dec" data-cart-ids="{{ json_encode($item['ids'] ?? [$item['id']]) }}">
						<i class="fs-16 zmdi zmdi-minus"></i>
					</div>
					<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product-{{ $item['id'] }}" value="{{ $qty }}" min="1" data-cart-ids="{{ json_encode($item['ids'] ?? [$item['id']]) }}">
					<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" data-action="inc" data-cart-ids="{{ json_encode($item['ids'] ?? [$item['id']]) }}">
						<i class="fs-16 zmdi zmdi-plus"></i>
					</div>
				</div>
			</td>
			<td class="column-6 line-total">{{ number_format($line, 0, ',', '.') }} ₫</td>
			<td class="column-7">
				<button type="button" class="delete-line" data-cart-ids="{{ json_encode($item['ids'] ?? [$item['id']]) }}" title="Xóa" style="background:none;border:none;cursor:pointer;">
					<i class="zmdi zmdi-close"></i>
				</button>
			</td>
		</tr>
		@endforeach
	@else
		<tr>
			<td colspan="8" class="text-center p-tb-40">
				<p class="stext-106 cl6">Giỏ hàng trống</p>
				<a href="{{ route('client.products.index') }}" class="stext-106 cl6 hov1 trans-04">Tiếp tục mua sắm</a>
			</td>
		</tr>
	@endif
</table>

