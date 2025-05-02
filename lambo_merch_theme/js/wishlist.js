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
            } else {
                // Product already in wishlist
                this.showMessage('Product is already in your favorites!', 'info');
            }
        },
        
        removeFromWishlist: function(productId) {
            // Convert productId to string to ensure consistent comparison
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
                
                // If on wishlist page, remove the product element
                if ($('.wishlist-product[data-product-id="' + productId + '"]').length) {
                    $('.wishlist-product[data-product-id="' + productId + '"]').fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if wishlist is empty
                        if ($('.wishlist-product').length === 0) {
                            $('.wishlist-products').html('<div class="empty-wishlist"><p>Your favorites list is empty.</p><a href="' + wc_add_to_cart_params.shop_url + '" class="button continue-shopping">Continue Shopping</a></div>');
                        }
                    });
                }
                
                // If the user is logged in, also update the server-side wishlist
                if (typeof ajaxurl !== 'undefined') {
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'lambo_update_user_wishlist',
                            wishlist: wishlist
                        },
                        success: function(response) {
                            // Wishlist updated on server
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
                    $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart').text('Adding...').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        LamboWishlist.showMessage('Product added to cart!', 'success');
                        
                        // Update cart fragments
                        if (response.fragments) {
                            $.each(response.fragments, function(key, value) {
                                $(key).replaceWith(value);
                            });
                        }
                        
                        // Update cart item count
                        $('.cart-count').text(response.cart_count);
                        
                        // Trigger event for WooCommerce to update cart fragments
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, null]);
                    } else {
                        LamboWishlist.showMessage('Error adding product to cart.', 'error');
                    }
                    
                    $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart').text('Add to Cart').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.log('Error details:', xhr.responseText);
                    LamboWishlist.showMessage('Error adding product to cart. Please try again.', 'error');
                    $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart').text('Add to Cart').prop('disabled', false);
                }
            });
        },
        
        getWishlist: function() {
            var wishlist = [];
            
            // Check for cookie
            if (document.cookie.indexOf('lambo_wishlist=') !== -1) {
                var cookieValue = document.cookie.split('; ').find(row => row.startsWith('lambo_wishlist='));
                if (cookieValue) {
                    try {
                        wishlist = JSON.parse(decodeURIComponent(cookieValue.split('=')[1]));
                    } catch (e) {
                        wishlist = [];
                    }
                }
            }
            
            return Array.isArray(wishlist) ? wishlist : [];
        },
        
        saveWishlist: function(wishlist) {
            // Set cookie for 30 days
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = 'lambo_wishlist=' + encodeURIComponent(JSON.stringify(wishlist)) + '; expires=' + date.toUTCString() + '; path=/';
        },
        
        updateWishlistCount: function() {
            var count = this.getWishlist().length;
            
            // Update wishlist count in header
            $('.wishlist-count').text(count > 0 ? count : '');
        },
        
        showMessage: function(message, type) {
            // Create message element if it doesn't exist
            if ($('.lambo-wishlist-message').length === 0) {
                $('body').append('<div class="lambo-wishlist-message"></div>');
            }
            
            // Set message content and type
            $('.lambo-wishlist-message')
                .attr('class', 'lambo-wishlist-message ' + type)
                .html(message)
                .fadeIn(300);
            
            // Hide message after 3 seconds
            clearTimeout(this.messageTimeout);
            this.messageTimeout = setTimeout(function() {
                $('.lambo-wishlist-message').fadeOut(300);
            }, 3000);
        }
    };
    
    // Initialize wishlist
    LamboWishlist.init();
});