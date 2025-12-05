<!--===============================================================================================-->	
	<script src="<?php echo e(asset('client/vendor/jquery/jquery-3.2.1.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/animsition/js/animsition.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/bootstrap/js/popper.js')); ?>"></script>
	<script src="<?php echo e(asset('client/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/select2/select2.min.js')); ?>"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/daterangepicker/moment.min.js')); ?>"></script>
	<script src="<?php echo e(asset('client/vendor/daterangepicker/daterangepicker.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/slick/slick.min.js')); ?>"></script>
	<script src="<?php echo e(asset('client/js/slick-custom.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/parallax100/parallax100.js')); ?>"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/MagnificPopup/jquery.magnific-popup.min.js')); ?>"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/isotope/isotope.pkgd.min.js')); ?>"></script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/sweetalert/sweetalert.min.js')); ?>"></script>
	<script>
		$('.js-addwish-b2, .js-addwish-detail').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

	// Global Add-to-cart AJAX (opt-in only). Intercepts form posting to /cart/add when data-ajax="1"
    // Stylish toast (top-right, dark theme)
    function showToast(message, type) {
        // Create container once
        var $container = $('#toast-container-stylex');
        if (!$container.length) {
            $container = $('<div id="toast-container-stylex"></div>').css({
                position:'fixed', top:'20px', right:'20px', zIndex: 99999,
                display:'flex', flexDirection:'column', gap:'10px', pointerEvents:'none'
            });
            $('body').append($container);
        }

        type = type || 'success';

        var baseBg = 'linear-gradient(135deg, #111, #1c1c1c)';
        var borderColor = 'rgba(255,255,255,0.08)';
        var iconChar = '✓';
        var titleText = 'Thành công';
        if (type === 'error') {
            // Đỏ nhạt nhưng đậm hơn một chút cho dễ nhìn
            baseBg = 'linear-gradient(135deg, #fee2e2, #fecaca)';
            borderColor = '#fca5a5';
            iconChar = '!';
            titleText = 'Lỗi';
        }

        var $toast = $('<div class="toast-stylex"></div>').css({
            background: baseBg, color:'#fff',
            border:'1px solid ' + borderColor, borderRadius:'10px',
            boxShadow:'0 10px 25px rgba(0,0,0,0.35), inset 0 1px 0 rgba(255,255,255,0.04)',
            padding:'12px 14px 10px 12px', minWidth:'260px', maxWidth:'360px',
            display:'flex', alignItems:'flex-start', gap:'10px',
            transform:'translateX(20px)', opacity:0, pointerEvents:'auto'
        });

        var $iconWrap = $('<div></div>').css({
            width:'28px', height:'28px', borderRadius:'8px',
            background:'#2a2a2a', display:'flex', alignItems:'center', justifyContent:'center',
            boxShadow:'0 6px 12px rgba(0,0,0,0.35)'
        });
        var $icon = $('<span></span>').text(iconChar).css({ fontWeight:700, color: type === 'error' ? '#b91c1c' : '#fff' });
        $iconWrap.append($icon);

        var $content = $('<div></div>').css({ flex:1 });
        var $title = $('<div></div>').text(titleText).css({ fontSize:'13px', opacity:.9, marginBottom:'2px', color: type === 'error' ? '#b91c1c' : '#fff' });
        var $msg = $('<div></div>').text(message).css({ fontSize:'14px', fontWeight:600, color: type === 'error' ? '#7f1d1d' : '#fff' });
        var $bar = $('<div></div>').css({
            position:'relative', height:'3px', borderRadius:'10px',
            background:'rgba(255,255,255,0.08)', marginTop:'8px', overflow:'hidden'
        });
        var $barFill = $('<div></div>').css({ height:'100%', width:'100%', background:'rgba(255,255,255,0.85)' });
        $bar.append($barFill);
        $content.append($title, $msg, $bar);

        var $close = $('<button aria-label="Đóng">×</button>').css({
            background:'transparent', color:'rgba(255,255,255,0.6)', border:'none', cursor:'pointer',
            fontSize:'18px', lineHeight:1, padding:0, marginLeft:'6px'
        }).on('click', function(){ dismiss(true); });

        $toast.append($iconWrap, $content, $close);
        $container.append($toast);

        // Animate in
        requestAnimationFrame(function(){
            $toast.css({ transition:'transform .25s ease, opacity .25s ease', transform:'translateX(0)', opacity:1 });
        });

        // Progress and auto-hide
        var duration = 2000; // ms
        var start = Date.now();
        var timer = setInterval(function(){
            var elapsed = Date.now() - start;
            var pct = Math.max(0, 1 - elapsed / duration);
            $barFill.css('width', (pct*100)+'%');
            if (pct <= 0) dismiss();
        }, 30);

        function dismiss(immediate){
            clearInterval(timer);
            if (immediate) { $toast.remove(); return; }
            $toast.css({ transform:'translateX(20px)', opacity:0 });
            setTimeout(function(){ $toast.remove(); }, 220);
        }
    }

    $(document).on('submit', 'form[data-ajax="1"][action$="/cart/add"]', function(e){
		e.preventDefault();
		var $form = $(this);
        
        // Đơn giản: chỉ cần lấy variant_id từ form (đã được set sẵn từ detail page)
        // Không cần tìm variant phức tạp nữa vì đã có variant mặc định và cập nhật khi user chọn
		var payload = $form.serialize() + '&ajax=1';
		$.ajax({
			url: $form.attr('action'),
			type: 'POST',
			headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
			data: payload
        }).done(function(res){
            if (!res || !res.success) { 
                // Không hiển thị thông báo lỗi
                return; 
            }
            
			var count = res.cart_count || 0;
			$('.icon-header-noti.js-show-cart').attr('data-notify', count);
			// Reload cart mini to update items and total
			// Always reload cart via AJAX to ensure it's updated
			$.ajax({
				url: '/cart/get',
				method: 'GET',
				success: function(cartData) {
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
									
									// Get variant info (use grouped data if available)
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
								var finalCount = cartData.item_count || count || 0;
								var totalAmount = cartData.total_amount || 0;
								
								// Update cart count badge
								$('#cartItemCount').text('(' + finalCount + ')');
								$('.icon-header-noti.js-show-cart').attr('data-notify', finalCount);
								
								// Create or update footer with total and button
								var $cartContent = $cartItems.closest('.header-cart-content');
								if ($cartFooter.length === 0) {
									// Create footer if it doesn't exist
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
									// Update existing footer
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
					},
					error: function(xhr, status, error) {
						console.error('Error loading cart:', error);
					}
				});
            showToast('Đã thêm vào giỏ hàng');
        }).fail(function(xhr){
            // Không hiển thị thông báo lỗi
		});
		return false;
	});
	
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/vendor/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="<?php echo e(asset('client/js/main.js')); ?>"></script>
	<script src="<?php echo e(asset('client/js/cart.js')); ?>"></script>

	<!-- Mini-cart behaviors: add to DOM, delete handler -->
	<script>

	// Function to append/update an item in the mini-cart
	window.addHeaderCartItemFromResponse = function(cartItem, cartCount){
		var $list = $('#cartItems');
		$list.find('.header-cart-empty').remove();
		var found = false;
		$list.find('li.header-cart-item').each(function(){
			if (String($(this).data('cart-id')) === String(cartItem.id)) {
				$(this).find('.header-cart-item-info').text((cartItem.quantity||1) + ' x ' + new Intl.NumberFormat('vi-VN').format(cartItem.price||0) + ' ₫');
				found = true;
			}
		});
		if (!found) {
            var imageUrl = '';
            if (cartItem.product_image_url) { imageUrl = cartItem.product_image_url; }
            else if (cartItem.product && cartItem.product.default_image_url) { imageUrl = cartItem.product.default_image_url; }
            else if (cartItem.product && cartItem.product.thumbnail) { imageUrl = cartItem.product.thumbnail; }
			var attrs = [];
			if (cartItem.variant && cartItem.variant.size) attrs.push('Size: ' + cartItem.variant.size.name);
			if (cartItem.variant && cartItem.variant.color) attrs.push('Màu: ' + cartItem.variant.color.name);
			$list.append(
				'<li class="header-cart-item flex-w flex-t m-b-12" data-cart-id="'+ cartItem.id +'">' +
					'<div class="header-cart-item-img">\
						<img src="'+ imageUrl +'" alt="IMG" />\
					</div>' +
					'<div class="header-cart-item-txt p-t-8" style="flex:1;">' +
						'<a href="#" class="header-cart-item-name m-b-5 hov-cl1 trans-04">'+ (cartItem.product ? cartItem.product.name : 'Sản phẩm') +'</a>' +
						(attrs.length ? '<div class="stext-110" style="font-size:12px;color:#888">'+ attrs.join(' • ') +'</div>' : '') +
						'<span class="header-cart-item-info">'+ (cartItem.quantity||1) +' x '+ new Intl.NumberFormat('vi-VN').format(cartItem.price||0) + ' ₫</span>' +
					'</div>' +
					'<button class="delete-item" type="button" data-cart-id="'+ cartItem.id +'" title="Xóa" style="margin-left:auto; background: none; border: none; cursor: pointer; align-self:center;">\
						<i class="zmdi zmdi-close"></i>\
					</button>' +
				'</li>'
			);
		}
		// Recompute totals
		var total = 0; $('#cartItems .header-cart-item-info').each(function(){ var t=$(this).text().split(' x '); if(t.length===2){ var q=parseInt(t[0])||0; var p=parseInt((t[1]||'').replace(/[^0-9]/g,''))||0; total += q*p; }});
		$('#totalAmount').text(new Intl.NumberFormat('vi-VN').format(total) + ' ₫');
		// Always show mini-cart footer (tổng cộng + các nút) sau khi thêm sp!
		var $footer = $('#cartFooter');
		if (!$footer.length) {
			// Nếu dom chưa có block footer (vừa thêm sp đầu tiên), render lại từ server bằng AJAX hoặc tự tạo lại DOM block này.
			// Đơn giản nhất là reload lại luôn mini-cart qua location hoặc trigger F5 nhỏ khu vực này.
			// Nhưng tạm thời để phòng ngừa, ta có thể show block này nếu DOM có rồi đang display:none
			$('[id="cartFooter"]').show();
		} else {
			$footer.show();
		}
		$('.icon-header-noti.js-show-cart').attr('data-notify', cartCount||0); $('#cartItemCount').text('(' + (cartCount||0) + ')');
	};

	// Delete item handler (centralized)
	$(document).on('click', '#cartItems .delete-item', function(e){
		e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
		var cartId = $(this).data('cart-id');
		var $btn = $(this);
		$.ajax({ url: '/cart/' + cartId, method: 'DELETE', data: { _token: $('meta[name="csrf-token"]').attr('content') }, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }} )
		.done(function(res){
			if (!res || !res.success) return;
			var $list = $('#cartItems');
			$btn.closest('li.header-cart-item').remove();
			var total = 0, count = 0;
			$('#cartItems .header-cart-item-info').each(function(){ var t=$(this).text().split(' x '); if(t.length===2){ var q=parseInt(t[0])||0; var p=parseInt((t[1]||'').replace(/[^0-9]/g,''))||0; total += q*p; count += q; }});
			if (!$list.find('li.header-cart-item').length) { $list.html('<li class="header-cart-empty" style="padding: 60px 20px; text-align: center; color: #999;">\
				<i class="zmdi zmdi-shopping-cart" style="font-size: 64px; opacity: 0.3;"></i>\
				<p style="margin-top: 20px; font-size: 16px;">Giỏ hàng trống</p>\
			</li>'); $('#cartFooter').hide(); }
			$('#totalAmount').text(new Intl.NumberFormat('vi-VN').format(total) + ' ₫'); $('.icon-header-noti.js-show-cart').attr('data-notify', count); $('#cartItemCount').text('(' + count + ')');
		});
	});
	</script>
	
	<!-- Custom JavaScript for User Dropdown -->
	<script>
		// Dropdown functionality
		document.addEventListener('DOMContentLoaded', function() {
			const dropdownToggle = document.querySelector('.dropdown-toggle');
			const dropdownMenu = document.querySelector('.dropdown-menu');
			
			if (dropdownToggle && dropdownMenu) {
				// Toggle dropdown
				dropdownToggle.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					dropdownMenu.classList.toggle('show');
				});
				
				// Close dropdown when clicking outside
				document.addEventListener('click', function(e) {
					if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
						dropdownMenu.classList.remove('show');
					}
				});
				
				// Prevent dropdown from closing when clicking inside
				dropdownMenu.addEventListener('click', function(e) {
					e.stopPropagation();
				});
				
				// Handle dropdown item clicks
				const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
				dropdownItems.forEach(function(item) {
					item.addEventListener('click', function(e) {
						// If it's a logout button, let the form submit
						if (this.classList.contains('logout-btn') || this.querySelector('button.logout-btn')) {
							return;
						}
						// Only prevent default if href is empty or '#'
						var href = this.getAttribute('href') || '';
						if (href === '' || href === '#') {
							e.preventDefault();
							dropdownMenu.classList.remove('show');
						}
						// If có href thì vẫn cho chuyển trang bình thường
					});
				});
			}
		});
	</script>
<!--===============================================================================================-->
	<!-- Chat Box JavaScript -->
	<script>
		$(document).ready(function() {
			// Display current date
			function updateChatDate() {
				const now = new Date();
				const days = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'];
				const dayName = days[now.getDay()];
				const day = String(now.getDate()).padStart(2, '0');
				const month = String(now.getMonth() + 1).padStart(2, '0');
				const year = now.getFullYear();
				const dateStr = dayName + ', ' + day + '/' + month + '/' + year;
				$('#chatCurrentDate').html('<i class="zmdi zmdi-calendar" style="font-size: 9px; margin-right: 4px; opacity: 0.7;"></i>' + dateStr);
			}
			updateChatDate();
			
			// Ensure chat icon is visible
			$('#chatIconWrapper').attr('style', 'bottom: 100px; right: 30px; z-index: 10001 !important; display: block !important; visibility: visible !important; position: fixed !important;');
			
			$('#chatIconButton').show().css({
				'display': 'flex',
				'visibility': 'visible'
			});

			const chatIconButton = $('#chatIconButton');
			const chatBoxContainer = $('#chatBoxContainer');
			const chatCloseBtn = $('#chatCloseBtn');
			const chatInput = $('#chatInput');
			const chatSendBtn = $('#chatSendBtn');
			const chatMessages = $('#chatMessages');

			// Debug: Check if elements exist
			if (chatIconButton.length === 0) {
				console.error('Chat icon button not found!');
			}
			if (chatBoxContainer.length === 0) {
				console.error('Chat box container not found!');
			}

			// Toggle chat box
			chatIconButton.on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				if (chatBoxContainer.hasClass('show')) {
					// Close chat box
					chatBoxContainer.removeClass('show');
					chatBoxContainer.hide();
				} else {
					// Simple positioning: box above icon, same right
					const iconBottom = 100; // Icon bottom position
					const iconRight = 30; // Icon right position
					const iconHeight = 60; // Icon height
					const gap = 10; // Gap between icon and box
					
					// Position box above icon
					const boxBottom = iconBottom + iconHeight + gap;
					
					// Open chat box
					chatBoxContainer.addClass('show');
					chatBoxContainer.css({
						'display': 'flex',
						'visibility': 'visible',
						'opacity': '1',
						'bottom': boxBottom + 'px',
						'right': iconRight + 'px',
						'position': 'fixed'
					}).show();
					chatInput.focus();
					scrollToBottom();
				}
			});

			// Close chat box
			chatCloseBtn.on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				chatBoxContainer.removeClass('show');
				chatBoxContainer.hide();
			});

			// Hide chat icon when minicart is opened
			function toggleChatIconVisibility() {
				const panelCart = $('.js-panel-cart');
				const chatIconWrapper = $('#chatIconWrapper');
				
				if (panelCart.hasClass('show-header-cart')) {
					// Hide chat icon when minicart is open
					chatIconWrapper.attr('style', 'bottom: 100px; right: 30px; z-index: 10001 !important; display: none !important; visibility: hidden !important; opacity: 0 !important; position: fixed !important;');
				} else {
					// Show chat icon when minicart is closed
					chatIconWrapper.attr('style', 'bottom: 100px; right: 30px; z-index: 10001 !important; display: block !important; visibility: visible !important; opacity: 1 !important; position: fixed !important;');
				}
			}

			// Watch for minicart open/close
			$(document).on('click', '.js-show-cart', function() {
				setTimeout(toggleChatIconVisibility, 10);
			});

			$(document).on('click', '.js-hide-cart', function() {
				setTimeout(toggleChatIconVisibility, 10);
			});

			// Also watch for class changes on panel-cart (in case it's toggled elsewhere)
			const panelCartObserver = new MutationObserver(function(mutations) {
				toggleChatIconVisibility();
			});

			const panelCartElement = document.querySelector('.js-panel-cart');
			if (panelCartElement) {
				panelCartObserver.observe(panelCartElement, {
					attributes: true,
					attributeFilter: ['class']
				});
			}

			// Initial check
			toggleChatIconVisibility();

			// Send message function
			function sendMessage() {
				const message = chatInput.val().trim();
				if (message === '') return;

				// Remove welcome message if exists
				chatMessages.find('.chat-welcome').remove();

				// Add user message
				addMessage(message, 'user');
				chatInput.val('');
				scrollToBottom();

				// Simulate admin response (chỉ là giao diện, không có backend)
				setTimeout(function() {
					showTypingIndicator();
					setTimeout(function() {
						removeTypingIndicator();
						addMessage('Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất có thể.', 'admin');
						scrollToBottom();
					}, 1500);
				}, 500);
			}

			// Send button click
			chatSendBtn.on('click', function() {
				sendMessage();
			});

			// Enter key to send
			chatInput.on('keypress', function(e) {
				if (e.which === 13) {
					e.preventDefault();
					sendMessage();
				}
			});

			// Add message to chat
			function addMessage(text, type) {
				const now = new Date();
				const time = now.getHours().toString().padStart(2, '0') + ':' + 
							now.getMinutes().toString().padStart(2, '0');
				
				const messageClass = type === 'user' ? 'user' : 'admin';
				const avatarIcon = type === 'user' ? 'zmdi-account' : 'zmdi-account-circle';
				
				const messageHtml = `
					<div class="chat-message ${messageClass}">
						<div class="chat-message-avatar">
							<i class="zmdi ${avatarIcon}"></i>
						</div>
						<div class="chat-message-content">
							<div class="chat-message-bubble">${text}</div>
							<div class="chat-message-time">${time}</div>
						</div>
					</div>
				`;
				
				chatMessages.append(messageHtml);
			}

			// Show typing indicator
			function showTypingIndicator() {
				const typingHtml = `
					<div class="chat-message admin" id="typingIndicator">
						<div class="chat-message-avatar">
							<i class="zmdi zmdi-account-circle"></i>
						</div>
						<div class="chat-message-content">
							<div class="chat-typing-indicator">
								<div class="chat-typing-dot"></div>
								<div class="chat-typing-dot"></div>
								<div class="chat-typing-dot"></div>
							</div>
						</div>
					</div>
				`;
				chatMessages.append(typingHtml);
				scrollToBottom();
			}

			// Remove typing indicator
			function removeTypingIndicator() {
				$('#typingIndicator').remove();
			}

			// Scroll to bottom
			function scrollToBottom() {
				chatMessages.scrollTop(chatMessages[0].scrollHeight);
			}


			// Close chat when clicking outside (optional)
			$(document).on('click', function(e) {
				if (!$(e.target).closest('#chatBoxContainer, #chatIconWrapper').length) {
					if (chatBoxContainer.hasClass('show')) {
						// Uncomment below if you want to close when clicking outside
						// chatBoxContainer.removeClass('show');
					}
				}
			});
		});
	</script>
<!--===============================================================================================-->
<?php /**PATH E:\LARAGON\laragon\www\DATN\duAnTotNghiep_website_ban_quan_ao_STYLEX\resources\views\client\partials\js\js.blade.php ENDPATH**/ ?>