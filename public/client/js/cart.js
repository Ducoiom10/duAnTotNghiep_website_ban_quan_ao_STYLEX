// Cart Management JavaScript

// Load cart when page loads
function loadCart() {
    console.log('Loading cart...');
    $.ajax({
        url: '/cart/get',
        method: 'GET',
        success: function(response) {
            console.log('Cart data:', response);
            updateCartUI(response);
            updateCartCount(response.item_count || 0);
        },
        error: function(xhr, status, error) {
            console.error('Error loading cart:', xhr, status, error);
        }
    });
}

// Update cart UI
function updateCartUI(data) {
    const cartItems = $('#cartItems');
    const cartFooter = $('#cartFooter');
    
    var items = Array.isArray(data.cart_items) ? data.cart_items : [];
    if (!items.length) {
        // Do not overwrite current DOM with empty state to avoid flicker/race
        return;
    }
    
    cartItems.empty();
    
    items.forEach(function(item) {
        var imagePath = (item.product && item.product.default_image_url) ? item.product.default_image_url : (item.image_url || '/client/images/product/product-01.jpg');
        var name = (item.product && item.product.name) ? item.product.name : (item.name || 'Sản phẩm');
        var productId = (item.product && item.product.id) ? item.product.id : (item.product_id || item.id);
        const html = `
            <li class="header-cart-item flex-w flex-t m-b-12" data-cart-id="${item.id}">
                <div class="header-cart-item-img">
                    <img src="${imagePath}" alt="${name}">
                </div>
                <div class="header-cart-item-txt p-t-8">
                    <a href="/products/${productId}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                        ${name}
                    </a>
                    <span class="header-cart-item-info">
                        ${item.quantity} x ${formatCurrency(item.price)}
                    </span>
                </div>
                <button class="delete-item" data-cart-id="${item.id}" style="margin-left: auto; background: none; border: none; cursor: pointer;">
                    <i class="zmdi zmdi-close"></i>
                </button>
            </li>
        `;
        cartItems.append(html);
    });
    
    // Update total
    $('#totalAmount').text(formatCurrency(data.total_amount || 0));
    cartFooter.show();
    
    // Delete button events are handled globally in document ready
}

// Add to cart
function addToCart(productId, quantity = 1, size = null, color = null) {
    console.log('Adding to cart:', {productId, quantity, size, color});
    
    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            product_id: productId,
            quantity: quantity,
            size: size,
            color: color,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log('Cart add response:', response);
            if (response.success) {
                // Show success notification
                showCartNotification(response.message, 'success');
                
                // Reload cart
                loadCart();
                
                // Update cart count badge
                $('.js-show-cart[data-notify]').attr('data-notify', response.cart_count);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error adding to cart:', xhr, status, error);
            console.error('Response:', xhr.responseJSON);
            showCartNotification(xhr.responseJSON?.message || "Có lỗi xảy ra. Vui lòng thử lại", 'error');
        }
    });
}

// Remove from cart - Direct delete without confirmation
function removeFromCart(cartItemId) {
    $.ajax({
        url: '/cart/' + cartItemId,
        method: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Remove item from DOM and recompute totals locally
                var $list = $('#cartItems');
                $list.find('li.header-cart-item[data-cart-id="' + cartItemId + '"]').remove();
                // If no items left, show empty state
                if (!$list.find('li.header-cart-item').length) {
                    $list.html('<li class="header-cart-empty" style="padding: 60px 20px; text-align: center; color: #999;">\
                        <i class="zmdi zmdi-shopping-cart" style="font-size: 64px; opacity: 0.3;"></i>\
                        <p style="margin-top: 20px; font-size: 16px;">Giỏ hàng trống</p>\
                    </li>');
                    $('#cartFooter').hide();
                    $('.icon-header-noti.js-show-cart').attr('data-notify', 0);
                    $('#cartItemCount').text('(0)');
                    return;
                }
                // Recompute totals and counts
                var total = 0; var count = 0;
                $('#cartItems .header-cart-item-info').each(function(){
                    var parts = $(this).text().split(' x ');
                    if (parts.length === 2) {
                        var q = parseInt(parts[0]) || 0;
                        var p = parseInt((parts[1]||'').replace(/[^0-9]/g,'')) || 0;
                        total += q * p;
                        count += q;
                    }
                });
                $('#totalAmount').text(new Intl.NumberFormat('vi-VN').format(total) + ' ₫');
                $('#cartFooter').show();
                $('.icon-header-noti.js-show-cart').attr('data-notify', count);
                $('#cartItemCount').text('(' + count + ')');
            }
        },
        error: function(error) {
            console.error('Error removing from cart:', error);
        }
    });
}

// Update cart count display
function updateCartCount(count) {
    // Update all cart count displays
    $('.icon-header-noti[data-notify]').each(function() {
        $(this).attr('data-notify', count);
        if (count > 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    
    // Also update mobile menu
    $('.mobile-menu-cart[data-notify]').each(function() {
        $(this).attr('data-notify', count);
        if (count > 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

// Initialize on page load
$(document).ready(function() {
    // Global event delegation for delete buttons - disabled to avoid conflicts
    // $(document).on('click', '.delete-item', function(e) {
    //     e.preventDefault();
    //     e.stopPropagation();
    //     const cartItemId = $(this).data('cart-id') || $(this).data('id');
    //     console.log('Delete button clicked for cart item:', cartItemId);
    //     removeFromCart(cartItemId);
    // });
    
    // Override default add to cart button behavior
    $(document).on('click', '.js-addcart-detail', function(e) {
        e.preventDefault();
        
        // Get product ID from button
        const productId = $(this).data('product-id') || 
                          $(this).closest('[data-product-id]').data('product-id');
        
        // Get quantity from input
        const quantity = $(this).closest('.flex-w').find('.num-product').val() || 
                         $('.num-product').val() || 
                         1;
        
        // Get size and color if available
        const size = $(this).closest('.flex-w').find('.js-select2[name="size"]').val() || 
                     $('.js-select2[name="size"]').val();
        const color = $(this).closest('.flex-w').find('.js-select2[name="color"]').val() || 
                      $('.js-select2[name="color"]').val();
        
        if (productId) {
            addToCart(productId, quantity, size, color);
        } else {
            swal("Có lỗi xảy ra", "Không thể thêm sản phẩm vào giỏ hàng", "error");
        }
    });
    
    // Add to cart from product card (icon button)
    $(document).on('click', '.js-addcart-b2', function(e) {
        e.preventDefault();
        
        const productId = $(this).data('product-id');
        
        if (productId) {
            addToCart(productId, 1);
        } else {
            swal("Có lỗi xảy ra", "Không thể thêm sản phẩm vào giỏ hàng", "error");
        }
    });
    
    // Removed periodic polling to avoid conflicts
});

// Update cart count function
function updateCartCount() {}

// Show cart notification in top right corner
function showCartNotification(message, type) {
    type = type || 'success';
    
    // Remove any existing notification
    $('.cart-notification').remove();
    
    // Create notification with better icons
    const icon = type === 'success' 
        ? '<i class="zmdi zmdi-check-circle"></i>' 
        : '<i class="zmdi zmdi-alert-circle"></i>';
    
    const notification = $(`
        <div class="cart-notification ${type}">
            ${icon}
            <span>${message}</span>
        </div>
    `);
    
    $('body').append(notification);
    
    // Animate in with delay
    setTimeout(function() {
        notification.addClass('show');
    }, 10);
    
    // Remove after 3 seconds with smooth animation
    setTimeout(function() {
        notification.removeClass('show');
        setTimeout(function() {
            notification.remove();
        }, 400);
    }, 3000);
}

