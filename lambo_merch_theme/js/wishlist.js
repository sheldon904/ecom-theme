jQuery(document).ready(function($) {
    // Initialize the wishlist functionality
    var LamboWishlist = {
        init: function() {
            this.setupEventListeners();
            this.updateWishlistCount();
        },
        
        setupEventListeners: function() {
            // Add to wishlist button click event
            $(document).on('click', '.add-to-wishlist', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                LamboWishlist.addToWishlist(productId);
            });
            
            // Remove from wishlist button click event
            $(document).on('click', '.remove-from-wishlist', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                LamboWishlist.removeFromWishlist(productId);
            });
            
            // Add to cart from wishlist
            $(document).on('click', '.wishlist-product-actions .add-to-cart', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                LamboWishlist.addToCart(productId);
            });
        },
        
        addToWishlist: function(productId) {
            // Convert productId to string for consistent comparison
            productId = productId.toString();
            
            // Get existing wishlist items
            var wishlist = this.getWishlist();
            
            // Check if product is already in wishlist
            if (wishlist.indexOf(productId) === -1) {
                // Add product to wishlist
                wishlist.push(productId);
                
                // Save updated wishlist
                this.saveWishlist(wishlist);
                
                // Show success message
                this.showMessage('Product added to your favorites!', 'success');
                
                // Update wishlist count
                this.updateWishlistCount();
                
                // If the user is logged in, update server-side wishlist
                if (typeof lambo_wishlist_params !== 'undefined' && lambo_wishlist_params.ajaxurl) {
                    $.ajax({
                        type: 'POST',
                        url: lambo_wishlist_params.ajaxurl,
                        data: {
                            action: 'lambo_update_user_wishlist',
                            wishlist: wishlist
                        },
                        success: function(response) {
                            // Wishlist updated on server
                            console.log('Wishlist updated on server', response);
                        }
                    });
                } else if (typeof ajaxurl !== 'undefined') {
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'lambo_update_user_wishlist',
                            wishlist: wishlist
                        },
                        success: function(response) {
                            // Wishlist updated on server
                            console.log('Wishlist updated on server', response);
                        }
                    });
                }
            } else {
                // Product already in wishlist
                this.showMessage('Product is already in your favorites!', 'info');
            }
        },
        
        removeFromWishlist: function(productId) {
            // Convert productId to string for consistent comparison
            productId = productId.toString();
            
            // Get existing wishlist items
            var wishlist = this.getWishlist();
            
            // Find product in wishlist
            var index = wishlist.indexOf(productId);
            
            if (index !== -1) {
                // Remove product from wishlist
                wishlist.splice(index, 1);
                
                // Save updated wishlist
                this.saveWishlist(wishlist);
                
                // Show success message
                this.showMessage('Product removed from your favorites!', 'success');
                
                // Update wishlist count
                this.updateWishlistCount();
                
                // If on wishlist page, remove the product element in the DOM
                if ($('.cart-item[data-product-id="' + productId + '"]').length) {
                    var $cartItem = $('.cart-item[data-product-id="' + productId + '"]');
                    var $mobileActions = $cartItem.next('.mobile-actions');
                    
                    $cartItem.fadeOut(300, function() {
                        // Remove both the cart item and its mobile actions row if it exists
                        $cartItem.remove();
                        if ($mobileActions.length) {
                            $mobileActions.remove();
                        }
                        
                        // If list becomes empty, show empty state
                        if ($('.cart-item').length === 0) {
                            var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                                '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                                '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                                '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                                'Continue Shopping</a></div>';
                            
                            $('.desktop-layout, .mobile-layout').html(emptyHtml);
                        }
                    });
                }
                
                // If the user is logged in, also update the server-side wishlist
                if (typeof lambo_wishlist_params !== 'undefined' && lambo_wishlist_params.ajaxurl) {
                    $.ajax({
                        type: 'POST',
                        url: lambo_wishlist_params.ajaxurl,
                        data: {
                            action: 'lambo_update_user_wishlist',
                            wishlist: wishlist
                        },
                        success: function(response) {
                            // Wishlist updated on server
                            console.log('Wishlist updated on server after removal', response);
                        }
                    });
                } else if (typeof ajaxurl !== 'undefined') {
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'lambo_update_user_wishlist',
                            wishlist: wishlist,
                            security: typeof lambo_ajax !== 'undefined' ? lambo_ajax.nonce : ''
                        },
                        success: function(response) {
                            // Wishlist updated on server
                            console.log('Wishlist updated on server after removal', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error updating wishlist:', error);
                        }
                    });
                }
            }
        },
        
        addToCart: function(productId) {
            $.ajax({
                type: 'POST',
                url: typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.ajax_url : ajaxurl,
                data: {
                    action: 'lambo_add_to_cart',
                    product_id: productId,
                    quantity: 1,
                    // Use our nonce if available, otherwise fallback to WooCommerce nonce
                    security: typeof lambo_ajax !== 'undefined' ? lambo_ajax.nonce : 
                             (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.nonce : '')
                },
                beforeSend: function() {
                    $('.cart-item[data-product-id="' + productId + '"] .add-to-cart').text('Adding...').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        LamboWishlist.showMessage('Product added to cart!', 'success');
                        // Replace fragments (mini-cart, etc.) if returned
                        if (response.fragments) {
                            $.each(response.fragments, function(key, value) {
                                $(key).replaceWith(value);
                            });
                        }
                        // Update cart item count in header
                        $('.cart-count').text(response.cart_count);
                        // Trigger WooCommerce event for added to cart
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, null]);
                    } else {
                        LamboWishlist.showMessage('Error adding product to cart.', 'error');
                    }
                    $('.cart-item[data-product-id="' + productId + '"] .add-to-cart').text('Add to Cart').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.log('Error details:', xhr.responseText);
                    LamboWishlist.showMessage('Error adding product to cart. Please try again.', 'error');
                    $('.cart-item[data-product-id="' + productId + '"] .add-to-cart').text('Add to Cart').prop('disabled', false);
                }
            });
        },
        
        getWishlist: function() {
            var wishlist = [];
            // Check for wishlist cookie
            if (document.cookie.indexOf('lambo_wishlist=') !== -1) {
                var cookieValue = document.cookie.split('; ').find(row => row.startsWith('lambo_wishlist='));
                if (cookieValue) {
                    try {
                        wishlist = JSON.parse(decodeURIComponent(cookieValue.split('=')[1]));
                        
                        // Ensure all product IDs are strings for consistent comparison
                        wishlist = wishlist.map(item => item.toString());
                    } catch (e) {
                        console.error('Error parsing wishlist cookie:', e);
                        wishlist = [];
                    }
                }
            }
            return Array.isArray(wishlist) ? wishlist : [];
        },
        
        saveWishlist: function(wishlist) {
            // Ensure all product IDs are strings for consistent storage
            wishlist = wishlist.map(item => item.toString());
            
            // Set/update cookie for 30 days
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = 'lambo_wishlist=' + encodeURIComponent(JSON.stringify(wishlist)) + '; expires=' + date.toUTCString() + '; path=/';
            
            console.log('Wishlist saved to cookie:', wishlist);
        },
        
        updateWishlistCount: function() {
            var count = this.getWishlist().length;
            // Update wishlist count in header icon
            $('.wishlist-count').text(count > 0 ? count : '');
            
            console.log('Wishlist count updated:', count);
        },
        
        showMessage: function(message, type) {
            // Create a floating message element if not already present
            if ($('.lambo-wishlist-message').length === 0) {
                $('body').append('<div class="lambo-wishlist-message"></div>');
            }
            // Set message text and style
            $('.lambo-wishlist-message')
                .attr('class', 'lambo-wishlist-message ' + type)
                .html(message)
                .fadeIn(300);
            // Auto-hide message after 3 seconds
            clearTimeout(this.messageTimeout);
            this.messageTimeout = setTimeout(function() {
                $('.lambo-wishlist-message').fadeOut(300);
            }, 3000);
        }
    };
    
    // Initialize wishlist functionality
    LamboWishlist.init();
});