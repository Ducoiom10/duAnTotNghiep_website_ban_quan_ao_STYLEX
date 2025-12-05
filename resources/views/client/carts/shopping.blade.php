@extends('client.layouts.app')

@section('title', 'Giỏ hàng - ' . env('APP_NAME'))

@section('content')

<div class="container">
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
			Trang Chủ
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>
		<span class="stext-109 cl4">Giỏ Hàng</span>
	</div>
</div>

<section class="bg0 p-t-40 p-b-60">
	<div class="container" id="cart-page-container" data-cart-error="{{ session('error') }}">
		<div class="row">
			<div class="col-lg-10 col-xl-12 m-lr-auto m-b-50">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<style>
						/* Harmonize cart table columns */
						.table-shopping-cart { 
							table-layout: fixed; 
							width: 100%;
						}
						.table-shopping-cart .table_head th { 
							padding: 14px 12px; 
							vertical-align: middle; 
							border-bottom: 1px solid #e6e6e6;
						}
						.table-shopping-cart .column-0 { 
							width: 50px; 
							text-align: center; 
							vertical-align: middle; 
						}
						.table-shopping-cart .column-1 { 
							width: 120px; 
							vertical-align: middle; 
							padding: 10px;
						}
						.table-shopping-cart .column-2 { 
							width: 220px; 
							padding: 10px 12px; 
							vertical-align: middle; 
						}
						.table-shopping-cart .column-3 { 
							width: 220px; 
							padding: 10px 12px; 
							vertical-align: middle; 
						}
						.table-shopping-cart .column-4 { 
							width: 120px; 
							text-align: center; 
							vertical-align: middle; 
						}
						.table-shopping-cart .column-5 { 
							width: 150px; 
							text-align: center; 
							vertical-align: middle; 
						}
						.table-shopping-cart .column-6 { 
							width: 130px; 
							text-align: right; 
							vertical-align: middle; 
							padding-right: 15px;
						}
						.table-shopping-cart .column-7 { 
							width: 80px; 
							text-align: center; 
							vertical-align: middle; 
						}

						/* Align body cells same as headers */
						.table-shopping-cart td.column-0 { 
							text-align: center; 
							vertical-align: middle; 
							padding: 10px 5px;
						}
						.table-shopping-cart td.column-1 { 
							vertical-align: middle; 
							padding: 10px;
						}
						.table-shopping-cart td.column-2 { 
							vertical-align: middle; 
							padding: 10px 12px;
						}
						.table-shopping-cart td.column-3 { 
							vertical-align: middle; 
							padding: 10px 12px;
						}
						.table-shopping-cart td.column-4,
						.table-shopping-cart td.column-5,
						.table-shopping-cart td.column-7 { 
							text-align: center; 
							vertical-align: middle; 
							padding: 10px;
						}
						.table-shopping-cart td.column-6 { 
							text-align: right; 
							vertical-align: middle; 
							padding: 10px 15px 10px 10px;
						}
						
						/* Align checkboxes */
						.table-shopping-cart .column-0 input[type="checkbox"] {
							width: 18px;
							height: 18px;
							cursor: pointer;
							margin: 0 auto;
							display: block;
						}
						
						/* Product image alignment */
						.table-shopping-cart .column-1 .how-itemcart1 {
							display: flex;
							align-items: center;
							justify-content: center;
							width: 100%;
							height: 100%;
						}
						
						.table-shopping-cart .column-1 img {
							max-width: 100px;
							max-height: 100px;
							width: auto;
							height: auto;
							display: block;
							object-fit: contain;
						}
						
						/* Product name alignment */
						.table-shopping-cart .column-2 {
							word-wrap: break-word;
							overflow-wrap: break-word;
						}
						
						.table-shopping-cart .column-2 a.stext-104 {
							display: block;
							word-wrap: break-word;
							overflow-wrap: break-word;
							line-height: 1.4;
						}
						
						/* Variant info alignment */
						.table-shopping-cart .column-3 {
							word-wrap: break-word;
							overflow-wrap: break-word;
						}
						
						.table-shopping-cart .column-3 .stext-110 {
							display: block;
							word-wrap: break-word;
							overflow-wrap: break-word;
							line-height: 1.5;
						}
						
						/* Ensure table cells don't overlap */
						.table-shopping-cart td {
							white-space: normal;
							overflow: visible;
						}
						
						/* Table row styling */
						.table-shopping-cart .table_row {
							border-bottom: 1px solid #f0f0f0;
						}
						
						.table-shopping-cart .table_row:hover {
							background-color: #fafafa;
						}

						/* Tidy action button */
						.table-shopping-cart .delete-line { 
							color: #999; 
							display: flex;
							align-items: center;
							justify-content: center;
							margin: 0 auto;
							width: 30px;
							height: 30px;
						}
						.table-shopping-cart .delete-line:hover { 
							color: #333; 
						}
						.table-shopping-cart .delete-line i {
							font-size: 20px;
						}

						/* Product name readability */
						.table-shopping-cart td.column-2 a.stext-104 {
							display: -webkit-box;
							-webkit-line-clamp: 2;
							line-clamp: 2;
							-webkit-box-orient: vertical;
							overflow: hidden;
							max-width: 420px;
							line-height: 1.35;
						}
					</style>
					<div class="wrap-table-shopping-cart" id="cart-table-container">
						@include('client.carts.partials.table', ['cartData' => $cartData])
					</div>

						<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
						<div class="flex-w flex-m m-tb-10" style="gap: 10px;">
							<button type="button" id="delete-selected-items" class="flex-c-m stext-101 cl0 size-119 bg1 bor13 hov-btn1 p-lr-15 trans-04" style="display: none;">
								Xóa đã chọn
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-10 col-xl-12 m-lr-auto m-b-50" style="margin-top: 30px;">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">Tổng cộng</h4>
					
					<!-- Voucher Section -->
					<div class="bor12 p-b-15 m-b-20">
						<div id="voucherInfo" class="w-full m-b-10" style="display: none;">
							<span class="stext-110 cl2" style="color: #28a745; font-weight: 600;">
								Mã voucher: <span id="appliedVoucherCode"></span>
							</span>
							<button type="button" 
									id="removeVoucherBtn" 
									class="stext-110 cl2 ml-2" 
									style="color: #dc3545; background: none; border: none; cursor: pointer; text-decoration: underline;">
								(Xóa)
							</button>
						</div>
						<a href="javascript:void(0);" 
						   id="openVoucherModal" 
						   class="stext-110 cl2 hov-cl1 trans-04" 
						   style="display: inline-block; text-decoration: underline; cursor: pointer;">
							<i class="zmdi zmdi-ticket-star" style="margin-right: 5px;"></i>
							Chọn hoặc nhập mã voucher
						</a>
						<div id="voucherMessage" class="w-full m-t-10" style="font-size: 12px; color: #28a745;"></div>
					</div>
					
					<!-- Voucher Modal -->
					<div id="voucherModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; overflow-y: auto;">
						<div style="position: relative; max-width: 600px; margin: 50px auto; background: white; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
							<div style="padding: 20px; border-bottom: 1px solid #e0e0e0; display: flex; justify-content: space-between; align-items: center;">
								<h4 class="mtext-109 cl2" style="margin: 0;">Chọn hoặc nhập mã voucher</h4>
								<button type="button" 
										id="closeVoucherModal" 
										style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
									<i class="zmdi zmdi-close"></i>
								</button>
							</div>
							<div style="padding: 20px;">
								<div style="margin-bottom: 20px;">
									<label class="stext-110 cl2" style="display: block; margin-bottom: 8px; font-weight: 600;">Nhập mã voucher:</label>
									<input type="text" 
										   id="voucherCodeInput" 
										   class="stext-104 cl2 plh4 size-117 bor13 p-lr-15" 
										   placeholder="Nhập mã voucher"
										   style="width: 100%;">
									<button type="button" 
											id="applyVoucherBtn" 
											class="flex-c-m stext-101 cl0 size-118 bg1 bor13 hov-btn1 p-lr-15 trans-04 pointer m-t-10"
											style="width: 100%;">
										Áp dụng mã
									</button>
								</div>
								<div>
									@if(!empty($availableVouchers) && count($availableVouchers) > 0)
									<label class="stext-110 cl2" style="display: block; margin-bottom: 10px; font-weight: 600;">Danh sách voucher có sẵn:</label>
									<div id="voucherList" style="max-height: 400px; overflow-y: auto;">
											@foreach($availableVouchers as $v)
											<div class="voucher-item" 
												 data-code="{{ $v['code'] }}"
												 style="padding: 12px; border: 1px solid #e0e0e0; border-radius: 4px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s;"
												 onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.borderColor='#333';"
												 onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#e0e0e0';">
												<div style="display: flex; justify-content: space-between; align-items: center;">
													<div style="flex: 1;">
														<div class="stext-110 cl2" style="font-weight: 600; color: #333; margin-bottom: 4px;">
															{{ $v['code'] }}
														</div>
														@if($v['description'])
														<div class="stext-110 cl6" style="font-size: 12px; margin-bottom: 4px;">
															{{ $v['description'] }}
														</div>
														@endif
														<div class="stext-110 cl2" style="font-size: 13px; color: #28a745; font-weight: 600;">
															Giảm {{ $v['discount_display'] }}
															@if($v['type'] === 'percent' && $v['max_discount_amount'])
																(tối đa {{ number_format($v['max_discount_amount'], 0, ',', '.') }} ₫)
															@endif
														</div>
													</div>
													<button type="button" 
															class="select-voucher-btn flex-c-m stext-101 cl0 size-118 bg1 bor13 hov-btn1 p-lr-15 trans-04"
															data-code="{{ $v['code'] }}"
															style="margin-left: 10px; white-space: nowrap;">
														Chọn
													</button>
												</div>
											</div>
											@endforeach
											</div>
										@endif
								</div>
							</div>
						</div>
					</div>
					<!-- End Voucher Section -->
					
					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208"><span class="stext-110 cl2">Tạm tính:</span></div>
						<div class="size-209"><span class="mtext-110 cl2" id="cart-subtotal">{{ number_format($total ?? 0, 0, ',', '.') }} ₫</span></div>
					</div>
					<div class="flex-w flex-t bor12 p-b-13" id="discountRow" style="display: none;">
						<div class="size-208"><span class="stext-110 cl2" style="color: #28a745;">Giảm giá:</span></div>
						<div class="size-209"><span class="mtext-110 cl2" id="discountAmount" style="color: #28a745;">0 ₫</span></div>
					</div>
					<div class="flex-w flex-t bor12 p-t-15 p-b-30">
						<div class="size-208 w-full-ssm"><span class="stext-110 cl2">Vận chuyển:</span></div>
						<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
							@if(!empty($shippingCarriers) && count($shippingCarriers) > 0)
								<div class="shipping-carriers-list" style="display: flex; flex-wrap: wrap; gap: 8px;">
									@foreach($shippingCarriers as $carrier)
									<div class="shipping-carrier-box" 
										 data-carrier-id="{{ $carrier->id }}"
										 data-carrier-fee="{{ isset($carrier->fee) ? $carrier->fee : 0 }}"
										 style="display: inline-block; padding: 6px 12px; border: 1px solid #e0e0e0; border-radius: 4px; cursor: pointer; transition: all 0.2s; background: #fff; margin-right: 8px; margin-bottom: 8px;"
										 onmouseover="this.style.borderColor='#333'; this.style.backgroundColor='#f9f9f9';"
										 onmouseout="if(!this.classList.contains('selected')) { this.style.borderColor='#e0e0e0'; this.style.backgroundColor='#fff'; }">
										<input type="radio" 
											   name="shipping_carrier" 
											   id="carrier_{{ $carrier->id }}" 
											   value="{{ $carrier->id }}"
											   data-fee="{{ isset($carrier->fee) ? $carrier->fee : 0 }}"
											   style="margin-right: 6px; vertical-align: middle;">
										<label for="carrier_{{ $carrier->id }}" style="cursor: pointer; margin: 0; font-weight: 600; color: #333; font-size: 14px; vertical-align: middle;">
											{{ $carrier->name }}
											<span style="margin-left: 8px; color: #666; font-weight: 500;">
												({{ number_format(isset($carrier->fee) ? $carrier->fee : 0, 0, ',', '.') }} ₫)
											</span>
										</label>
									</div>
									@endforeach
								</div>
							@else
								<span class="stext-111 cl6 p-t-2">Tính khi thanh toán</span>
							@endif
						</div>
					</div>
					<div class="flex-w flex-t p-t-27 p-b-33">
						<div class="size-208"><span class="mtext-101 cl2">Tổng:</span></div>
						<div class="size-209 p-t-1"><span class="mtext-110 cl2" id="cart-grandtotal">{{ number_format($total ?? 0, 0, ',', '.') }} ₫</span></div>
					</div>
						<a href="{{ route('client.checkout.index') }}" id="btn-go-checkout" class="flex-c-m stext-101 cl0 size-116 bg1 bor14 hov-btn3 p-lr-15 trans-04 pointer">Thanh toán</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@push('scripts')
<script>
(function($){
	function format(n){ try { return new Intl.NumberFormat('vi-VN').format(n) + ' ₫'; } catch(e){ return n + ' ₫'; } }
	var currentDiscount = parseFloat('{{ $discount ?? 0 }}') || 0;
	var currentSubtotal = 0;
	var appliedVoucher = <?php echo json_encode($voucher); ?>;

	// Nếu có lỗi từ backend (ví dụ giỏ hàng trống khi bấm thanh toán), hiển thị toast đỏ sau khi DOM sẵn sàng
	$(document).ready(function() {
		var $cartContainer = $('#cart-page-container');
		var cartError = $cartContainer.data('cart-error');
		if (cartError && typeof showToast === 'function') {
			showToast(cartError, 'error');
		}
	});

	// Dùng toast chung của toàn site (đã định nghĩa trong client.partials.js.js)
	function showCartToast(message) {
		if (typeof showToast === 'function') {
			showToast(message);
		} else {
			alert(message);
		}
	}

	// Initialize voucher UI if voucher is applied
	$(document).ready(function(){
		if (appliedVoucher) {
			currentDiscount = parseFloat('{{ $discount ?? 0 }}') || 0;
			$('#voucherInfo').show();
			$('#appliedVoucherCode').text(appliedVoucher.code);
			updateGrandTotal();
		}
	});

	function recalcTotals(){
		var grand = 0;
		$('table.table-shopping-cart tr.table_row').each(function(){
			var $row = $(this);
			var price = parseFloat($row.data('price')||0);
			var qty = parseInt($row.find('input.num-product').val(), 10);
			if (isNaN(qty) || qty < 1) qty = 1;
			var line = price * qty;
			$row.find('.line-total').text(format(line));
			grand += line;
		});
		currentSubtotal = grand;
		$('#cart-subtotal').text(format(grand));
		
		// Recalculate discount if voucher is applied
		if (appliedVoucher) {
			if (appliedVoucher.type === 'percent') {
				currentDiscount = (grand * appliedVoucher.value) / 100;
			} else if (appliedVoucher.type === 'fixed') {
				currentDiscount = appliedVoucher.value;
				if (currentDiscount > grand) {
					currentDiscount = grand;
				}
			}
		}
		
		updateGrandTotal();
	}

	var currentShippingFee = 0;
	
	function updateGrandTotal(){
		var finalTotal = currentSubtotal - currentDiscount + currentShippingFee;
		if (finalTotal < 0) finalTotal = 0;
		$('#cart-grandtotal').text(format(finalTotal));
		if (currentDiscount > 0) {
			$('#discountRow').show();
			$('#discountAmount').text(format(currentDiscount));
		} else {
			$('#discountRow').hide();
		}
	}
	
	// Shipping carrier selection
	$(document).on('change', 'input[name="shipping_carrier"]', function(){
		var $radio = $(this);
		var fee = parseFloat($radio.data('fee') || 0);
		currentShippingFee = fee;
		
		// Update UI
		$('.shipping-carrier-box').removeClass('selected').css({
			'borderColor': '#e0e0e0',
			'backgroundColor': '#fff'
		});
		$radio.closest('.shipping-carrier-box').addClass('selected').css({
			'borderColor': '#333',
			'backgroundColor': '#f9f9f9'
		});
		
		// Update total trên giao diện
		updateGrandTotal();

		// Gửi lựa chọn đơn vị vận chuyển lên server để lưu vào session (dùng cho bước checkout)
		// Dùng trực tiếp URL để tránh lỗi khi route cache chưa cập nhật
		$.ajax({
			url: '/cart/shipping/select',
			method: 'POST',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
			data: {
				shipping_carrier_id: $radio.val(),
				_token: $('meta[name="csrf-token"]').attr('content')
			}
		}).fail(function(xhr){
			console.error('Không thể lưu lựa chọn đơn vị vận chuyển', xhr.responseText || '');
		});
	});
	
	// Initialize first carrier as selected if available
	$(document).ready(function(){
		var $firstCarrier = $('input[name="shipping_carrier"]:first');
		if ($firstCarrier.length > 0) {
			$firstCarrier.prop('checked', true).trigger('change');
		}
	});
	// Function to reload cart table only (not full page)
	function reloadCartTable() {
		$.ajax({
			url: '{{ route("client.cart.table") }}',
			method: 'GET',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
		}).done(function(html){
			$('#cart-table-container').html(html);
			// Update totals from server
			updateTotalsFromServer();
			// Re-initialize checkbox state after reload
			setTimeout(function() {
				updateSelectAllState();
			}, 100);
			// Reload mini cart in menu
			reloadMiniCart();
		}).fail(function(){
			console.error('Failed to reload cart table');
		});
	}
	
	// Function to reload mini cart in menu
	function reloadMiniCart() {
		$.ajax({
			url: '/cart/get',
			method: 'GET',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
		}).done(function(cartData) {
			if (cartData && cartData.cart_items) {
				var $cartItems = $('#cartItems');
				var $cartFooter = $('#cartFooter');
				$cartItems.empty();
				
				if (cartData.cart_items.length > 0) {
					cartData.cart_items.forEach(function(item) {
						var imagePath = (item.product && item.product.default_image_url) ? item.product.default_image_url : '/client/images/product/product-01.jpg';
						var name = (item.product && item.product.name) ? item.product.name : 'Sản phẩm';
						var productId = (item.product && item.product.id) ? item.product.id : (item.product_id || item.id);
						var price = item.price || 0;
						var quantity = item.quantity || 1;
						
						// Get variant info
						var variant = item.variant || {};
						var sizeName = item.size || (variant.size ? (variant.size.name || '') : '');
						var colorName = item.color || (variant.color ? (variant.color.name || '') : '');
						var variantInfo = '';
						if (sizeName || colorName) {
							var parts = [];
							if (sizeName) parts.push('Size: ' + sizeName);
							if (colorName) parts.push('Màu: ' + colorName);
							variantInfo = '<div class="stext-110" style="margin: 2px 0 6px; display:flex; gap:6px; flex-wrap:wrap;">' +
								parts.map(function(p) {
									return '<span style="background:#f6f6f6; color:#333; border:1px solid #ebebeb; border-radius:10px; padding:1px 6px; font-size:11px;">' + p + '</span>';
								}).join('') +
								'</div>';
						}
						
						var html = '<li class="header-cart-item flex-w flex-t m-b-12" data-cart-id="' + item.id + '">' +
							'<div class="header-cart-item-img"><img src="' + imagePath + '" alt="' + name + '"></div>' +
							'<div class="header-cart-item-txt p-t-8" style="flex:1;">' +
							'<a href="/products/' + productId + '" class="header-cart-item-name m-b-5 hov-cl1 trans-04">' + name + '</a>' +
							variantInfo +
							'<span class="header-cart-item-info">' + quantity + ' x ' + new Intl.NumberFormat('vi-VN').format(price) + ' ₫</span>' +
							'</div>' +
							'<button class="delete-item" type="button" data-cart-id="' + item.id + '" title="Xóa" style="margin-left:auto; background: none; border: none; cursor: pointer; align-self:center;"><i class="zmdi zmdi-close"></i></button>' +
							'</li>';
						$cartItems.append(html);
					});
					
					// Update total and count
					var finalCount = cartData.item_count || 0;
					var totalAmount = cartData.total_amount || 0;
					
					// Update cart count badge
					$('#cartItemCount').text('(' + finalCount + ')');
					$('.icon-header-noti.js-show-cart').attr('data-notify', finalCount);
					
					// Create or update footer with total and button
					var $cartContent = $cartItems.closest('.header-cart-content');
					if ($cartFooter.length === 0) {
						var footerHtml = '<div class="w-full" id="cartFooter" style="flex-shrink: 0; border-top: 1px solid #e8e8e8; margin-top: auto;">' +
							'<div class="header-cart-total w-full p-tb-30" id="cartTotal">' +
							'<div class="flex-w flex-sb-m">' +
							'<span class="mtext-107 cl2" style="font-size: 18px; font-weight: 600;">Tổng cộng:</span>' +
							'<span class="mtext-106 cl2" id="totalAmount" style="font-size: 20px; font-weight: 700; color: #666;">' + new Intl.NumberFormat('vi-VN').format(totalAmount) + ' ₫</span>' +
							'</div>' +
							'</div>' +
							'<div class="header-cart-buttons flex-w w-full" style="gap: 10px;">' +
							'<a href="/cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10" style="flex: 1; text-align: center; text-decoration: none;">Xem Giỏ Hàng</a>' +
							'</div>' +
							'</div>';
						$cartContent.append(footerHtml);
					} else {
						$('#totalAmount').text(new Intl.NumberFormat('vi-VN').format(totalAmount) + ' ₫');
						$cartFooter.css('display', 'block').show();
					}
				} else {
					$cartItems.html('<li class="header-cart-empty" style="padding: 60px 20px; text-align: center; color: #999;"><p style="margin-top: 20px; font-size: 16px;">Giỏ hàng trống</p></li>');
					if ($cartFooter.length > 0) {
						$cartFooter.hide();
					}
				}
			}
		}).fail(function(xhr, status, error) {
			console.error('Error loading mini cart:', error);
		});
	}
	
	// Function to get totals from server
	function updateTotalsFromServer() {
		$.ajax({
			url: '{{ route("client.cart.index") }}',
			method: 'GET',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
			data: { ajax: 1, totals_only: 1 }
		}).done(function(data){
			if (data && data.subtotal !== undefined) {
				$('#cart-subtotal').text(format(data.subtotal));
				if (data.discount > 0) {
					$('#discountRow').show();
					$('#discountAmount').text(format(data.discount));
				} else {
					$('#discountRow').hide();
				}
				$('#cart-grandtotal').text(format(data.total || data.subtotal));
			}
		}).fail(function(){
			// Fallback: reload full page if AJAX fails
			location.reload();
		});
	}
	
	// Function to update cart automatically
	function updateCartItem($row) {
		var qty = parseInt($row.find('input.num-product').val(), 10);
		if (isNaN(qty) || qty < 1) {
			qty = 1;
			$row.find('input.num-product').val(1);
		}
		
		// Check if this row has multiple cart IDs (grouped items)
		var cartIds = $row.data('cart-ids');
		if (!cartIds || !Array.isArray(cartIds)) {
			// Fallback to single cart ID
			cartIds = [$row.data('cart-id')];
		}
		
		// Get item data to calculate proportions
		var itemData = $row.data('item-data') || [];
		var totalOldQty = 0;
		if (itemData.length > 0) {
			itemData.forEach(function(item) {
				totalOldQty += parseInt(item.quantity || 1, 10);
			});
		} else {
			totalOldQty = qty; // If no item data, assume equal distribution
		}
		
		var ajaxCount = 0;
		var successCount = 0;
		
		// Update all cart items in this group
		cartIds.forEach(function(cartId) {
			if (!cartId) return;
			
			// Calculate quantity for this item (proportional to old quantity)
			var itemQty = qty;
			if (itemData.length > 0 && totalOldQty > 0) {
				var item = itemData.find(function(i) { return i.id == cartId; });
				if (item) {
					var proportion = parseInt(item.quantity || 1, 10) / totalOldQty;
					itemQty = Math.max(1, Math.round(qty * proportion));
				}
			}
			
			ajaxCount++;
			$.ajax({
				url: '/cart/'+cartId,
				method: 'PUT',
				headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
				data: { quantity: itemQty, _token: $('meta[name="csrf-token"]').attr('content'), ajax: 1 }
			}).done(function(res){
				successCount++;
				// Update totals from response if available
				if (res && res.subtotal !== undefined) {
					$('#cart-subtotal').text(format(res.subtotal));
					if (res.discount > 0) {
						$('#discountRow').show();
						$('#discountAmount').text(format(res.discount));
					} else {
						$('#discountRow').hide();
					}
					$('#cart-grandtotal').text(format(res.total || res.subtotal));
				}
			}).fail(function(){ 
				// Revert quantity on error
				var oldQty = $row.data('qty') || 1;
				$row.find('input.num-product').val(oldQty);
			}).always(function(){
				ajaxCount--;
				if (ajaxCount === 0) {
					if (successCount > 0) {
						// Update row data
						$row.attr('data-qty', qty);
						// Reload only cart table, not full page
						reloadCartTable();
					}
				}
			});
		});
	}
	
	// Auto-update when +/- buttons are clicked
	$(document).on('click', 'table.table-shopping-cart .btn-num-product-up, table.table-shopping-cart .btn-num-product-down', function(e){
		e.preventDefault();
		e.stopPropagation();
		var $btn = $(this);
		var $row = $btn.closest('tr.table_row');
		var $input = $row.find('input.num-product');
		var currentValue = parseInt($input.val(), 10) || 1;
		
		if ($btn.data('action') === 'inc') {
			$input.val(currentValue + 1);
		} else if ($btn.data('action') === 'dec' && currentValue > 1) {
			$input.val(currentValue - 1);
		}
		
		// Trigger update immediately
		updateCartItem($row);
		return false;
	});
	
	// Auto-update when quantity input changes (with debounce)
	var updateTimeout;
	$(document).on('change', 'table.table-shopping-cart input.num-product', function(e){
		var $input = $(this);
		var $row = $input.closest('tr.table_row');
		var val = parseInt($input.val(), 10);
		if (isNaN(val) || val < 1) { 
			val = 1; 
			$input.val(val); 
		}
		
		clearTimeout(updateTimeout);
		updateTimeout = setTimeout(function() {
			updateCartItem($row);
		}, 500); // Debounce 500ms
	});
	// Delete single item handler
	$(document).on('click', '.delete-line', function(e){
		e.preventDefault();
		var $btn = $(this);
		var cartIds = $btn.data('cart-ids');
		if (!cartIds || !Array.isArray(cartIds)) {
			cartIds = [];
		}
		
		if (cartIds.length === 0) {
			alert('Không tìm thấy sản phẩm để xóa.');
			return;
		}
		
		if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
			return;
		}
		
		var deleteCount = 0;
		var failCount = 0;
		
		cartIds.forEach(function(cartId) {
			if (!cartId) return;
			deleteCount++;
			$.ajax({ 
				url: '/cart/' + cartId, 
				method: 'DELETE', 
				data: { _token: $('meta[name="csrf-token"]').attr('content') }, 
				headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
			})
			.done(function(res){
				if (!res || !res.success) { failCount++; return; }
			})
			.fail(function(){ failCount++; })
			.always(function(){
				deleteCount--;
				if (deleteCount === 0) {
					if (failCount === 0) {
						// Reload only cart table, not full page
						reloadCartTable();
					} else {
						alert('Có lỗi khi xóa sản phẩm. Vui lòng thử lại.');
					}
				}
			});
		});
		
		return false;
	});
	
	// Initial totals
	recalcTotals();

	// Open voucher modal
	$(document).on('click', '#openVoucherModal', function(e){
		e.preventDefault();
		$('#voucherModal').fadeIn(200);
		$('#voucherCodeInput').focus();
	});
	
	// Close voucher modal
	$(document).on('click', '#closeVoucherModal, #voucherModal', function(e){
		if (e.target === this) {
			$('#voucherModal').fadeOut(200);
		}
	});
	
	// Prevent modal close when clicking inside modal content
	$(document).on('click', '#voucherModal > div', function(e){
		e.stopPropagation();
	});
	
	// Select voucher from list
	$(document).on('click', '.select-voucher-btn, .voucher-item', function(e){
		e.preventDefault();
		var code = $(this).data('code') || $(this).closest('.voucher-item').data('code');
		if (code) {
			$('#voucherCodeInput').val(code);
			applyVoucherCode(code);
		}
	});
	
	// Apply voucher function
	function applyVoucherCode(code) {
		if (!code || !code.trim()) {
			$('#voucherMessage').text('Vui lòng nhập mã voucher').css('color', '#dc3545');
			if (typeof showToast === 'function') {
				showToast('Vui lòng nhập mã voucher.', 'error');
			}
			return;
		}
		$('#applyVoucherBtn').prop('disabled', true).text('Đang xử lý...');
		$('#voucherMessage').text('');
		$.ajax({
			url: '/cart/voucher/apply',
			method: 'POST',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
			data: { code: code.trim(), _token: $('meta[name="csrf-token"]').attr('content') }
		}).done(function(res){
			if (res.success) {
				currentDiscount = res.discount;
				updateGrandTotal();
				$('#voucherMessage').text(res.message).css('color', '#28a745');
				if (typeof showToast === 'function') {
					showToast(res.message || 'Áp dụng mã voucher thành công.', 'success');
				}
				$('#voucherInfo').show();
				$('#appliedVoucherCode').text(res.voucher.code);
				$('#voucherCodeInput').val(res.voucher.code);
				$('#voucherModal').fadeOut(200);
			} else {
				$('#voucherMessage').text(res.message || 'Có lỗi xảy ra').css('color', '#dc3545');
			}
		}).fail(function(xhr){
			var msg = 'Có lỗi xảy ra';
			if (xhr.responseJSON && xhr.responseJSON.message) {
				msg = xhr.responseJSON.message;
			}
			$('#voucherMessage').text(msg).css('color', '#dc3545');
			if (typeof showToast === 'function') {
				showToast(msg, 'error');
			}
		}).always(function(){
			$('#applyVoucherBtn').prop('disabled', false).text('Áp dụng mã');
		});
	}
	
	// Apply voucher button click
	$(document).on('click', '#applyVoucherBtn', function(e){
		e.preventDefault();
		var code = $('#voucherCodeInput').val().trim();
		applyVoucherCode(code);
	});

	// Remove voucher
	$(document).on('click', '#removeVoucherBtn', function(e){
		e.preventDefault();
		$.ajax({
			url: '/cart/voucher/remove',
			method: 'POST',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
			data: { _token: $('meta[name="csrf-token"]').attr('content') }
		}).done(function(res){
			if (res.success) {
				currentDiscount = 0;
				updateGrandTotal();
				$('#voucherMessage').text(res.message).css('color', '#28a745');
				$('#voucherInfo').hide();
				$('#voucherCodeInput').val('');
				setTimeout(function(){
					$('#voucherMessage').text('');
				}, 3000);
			}
		});
	});

	// Enter key to apply voucher
	$(document).on('keypress', '#voucherCodeInput, #voucherCode', function(e){
		if (e.which === 13) {
			var code = $('#voucherCodeInput').val().trim() || $('#voucherCode').val().trim();
			applyVoucherCode(code);
		}
	});

	// Checkbox functionality
	function updateSelectAllState() {
		var totalCheckboxes = $('.item-checkbox').length;
		var checkedCheckboxes = $('.item-checkbox:checked').length;
		
		// Update select all checkbox state
		if (totalCheckboxes > 0) {
			$('#select-all-header').prop('checked', checkedCheckboxes === totalCheckboxes);
		}
		
		// Show/hide delete button
		if (checkedCheckboxes > 0) {
			$('#delete-selected-items').show();
		} else {
			$('#delete-selected-items').hide();
		}
	}
	
	// Initialize on page load
	$(document).ready(function() {
		updateSelectAllState();
	});
	
	// Select all checkboxes when header checkbox is clicked (use event delegation)
	$(document).on('change', '#select-all-header', function() {
		var isChecked = $(this).prop('checked');
		$('.item-checkbox').prop('checked', isChecked);
		updateSelectAllState();
	});
	
	// Individual checkbox change
	$(document).on('change', '.item-checkbox', function() {
		updateSelectAllState();
	});
	
	// Delete selected items
	$('#delete-selected-items').on('click', function() {
		var selectedIds = [];
		$('.item-checkbox:checked').each(function() {
			var cartIds = $(this).data('cart-ids');
			if (cartIds && Array.isArray(cartIds)) {
				selectedIds = selectedIds.concat(cartIds);
			}
		});
		
		if (selectedIds.length === 0) {
			showCartToast('Vui lòng chọn ít nhất một sản phẩm để xóa.');
			return;
		}
		
		if (!confirm('Bạn có chắc chắn muốn xóa ' + selectedIds.length + ' sản phẩm đã chọn khỏi giỏ hàng?')) {
			return;
		}
		
		var deleteCount = 0;
		var failCount = 0;
		var rowsToRemove = [];
		
		selectedIds.forEach(function(cartId) {
			if (!cartId) return;
			deleteCount++;
			$.ajax({ 
				url: '/cart/' + cartId, 
				method: 'DELETE', 
				data: { _token: $('meta[name="csrf-token"]').attr('content') }, 
				headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
			})
			.done(function(res){
				if (!res || !res.success) { failCount++; return; }
			})
			.fail(function(){ failCount++; })
			.always(function(){
				deleteCount--;
				if (deleteCount === 0) {
					if (failCount === 0) {
						// Thông báo xóa thành công và reload lại bảng giỏ hàng
						showCartToast('Đã xóa ' + selectedIds.length + ' sản phẩm khỏi giỏ hàng.');
						// Reload only cart table, not full page
						reloadCartTable();
					} else {
						showCartToast('Có lỗi khi xóa một số sản phẩm. Vui lòng thử lại.');
					}
				}
			});
		});
		
		return false;
	});

	// Khi bấm "Thanh toán" từ giỏ hàng, gắn đơn vị vận chuyển đã chọn vào URL để PHP đọc được
	$(document).on('click', '#btn-go-checkout', function(e){
		e.preventDefault();
		var url = '{{ route("client.checkout.index") }}';
		var selectedCarrierId = $('input[name="shipping_carrier"]:checked').val();
		if (selectedCarrierId) {
			// Thêm ?shipping_carrier_id=... vào URL
			url += (url.indexOf('?') === -1 ? '?' : '&') + 'shipping_carrier_id=' + encodeURIComponent(selectedCarrierId);
		}
		window.location.href = url;
	});
})(jQuery);
</script>
@endpush

@endsection

