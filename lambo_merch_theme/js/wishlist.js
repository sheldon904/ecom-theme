// Original wishlist.js file - now works alongside global-wishlist.js
// We avoid initializing our own LamboWishlist object to prevent conflicts

jQuery(document).ready(function($) {
    // This object is no longer necessary since global-wishlist.js already provides these functions
    // We create a local object just for backward compatibility
    var localWishlist = {
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
                console.log('Trash icon clicked for product ID:', productId);
                console.log('Data attributes on this element:', $(this).data());
                
                // Get current wishlist before removal attempt
                var currentWishlist = LamboWishlist.getWishlist();
                console.log('Current wishlist before removal:', currentWishlist);
                console.log('Is product in wishlist?', currentWishlist.indexOf(productId.toString()) !== -1);
                
                // Attempt removal
                LamboWishlist.removeFromWishlist(productId);
                
                // Debug after removal
                setTimeout(function() {
                    console.log('Wishlist after removal (delayed check):', LamboWishlist.getWishlist());
                    console.log('Cookie after removal:', document.cookie);
                }, 100);
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
                // Add product to wishlist (as string)
                wishlist.push(productId.toString());
                
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
            // Ensure productId is a string for consistent comparison
            productId = productId ? productId.toString() : '';
            console.log('Removing product from wishlist, ID:', productId, 'Type:', typeof productId);
            
            if (!productId) {
                console.error('Invalid product ID for removal');
                this.showMessage('Error: Invalid product ID', 'error');
                return;
            }
            
            try {
                // Get existing wishlist items
                var wishlist = this.getWishlist();
                console.log('Current wishlist before removal:', wishlist);
                
                // Convert all wishlist items to strings for consistent comparison
                wishlist = wishlist.map(function(id) { return id.toString(); });
                
                // Find product in wishlist
                var index = wishlist.indexOf(productId);
                console.log('Product index in wishlist:', index);
                
                if (index !== -1) {
                    // Remove product from wishlist
                    wishlist.splice(index, 1);
                    console.log('Wishlist after removal:', wishlist);
                    
                    // Force a hard refresh of cookie first
                    try {
                        // Clear the cookie first to avoid any stale data
                        document.cookie = 'lambo_wishlist=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                        console.log('Cleared wishlist cookie');
                    } catch (e) {
                        console.error('Error clearing wishlist cookie:', e);
                    }
                    
                    // Save updated wishlist to cookie
                    this.saveWishlist(wishlist);
                    
                    // Show success message
                    this.showMessage('Product removed from your favorites!', 'success');
                    
                    // Update wishlist count
                    this.updateWishlistCount();
                    
                    // Find and remove the cart item from DOM
                    var $cartItem = $('.cart-item[data-product-id="' + productId + '"]');
                    if ($cartItem.length) {
                        console.log('Found cart item to remove from DOM:', $cartItem);
                        var $mobileActions = $cartItem.next('.mobile-actions');
                        
                        // Add debug info to cart item before removing
                        $cartItem.attr('data-removal-attempted', 'true');
                        
                        // Remove the item from the DOM
                        $cartItem.fadeOut(300, function() {
                            console.log('Removing cart item from DOM now');
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
                    } else {
                        console.log('Warning: Cart item not found in DOM with ID: ' + productId);
                        console.log('All cart items on page:', $('.cart-item').length);
                        // List all cart items with their IDs for debugging
                        $('.cart-item').each(function() {
                            console.log('Cart item with ID:', $(this).data('product-id'), 'Type:', typeof $(this).data('product-id'));
                        });
                    }
                    
                    // Prepare the AJAX data - make sure wishlist is passed as array of strings
                    var ajaxData = {
                        action: 'lambo_update_user_wishlist',
                        wishlist: wishlist.map(function(id) { return id.toString(); })
                    };
                    
                    // Add security nonce if available
                    if (typeof lambo_ajax !== 'undefined' && lambo_ajax.nonce) {
                        ajaxData.security = lambo_ajax.nonce;
                    }
                    
                    console.log('Sending AJAX update with data:', ajaxData);
                    
                    // Send the AJAX request to update the server-side wishlist
                    $.ajax({
                        type: 'POST',
                        url: (typeof lambo_wishlist_params !== 'undefined' && lambo_wishlist_params.ajaxurl) ? 
                             lambo_wishlist_params.ajaxurl : 
                             (typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php'),
                        data: ajaxData,
                        success: function(response) {
                            console.log('Wishlist updated on server after removal:', response);
                            if (response.success) {
                                console.log('Server confirmed wishlist update:', response.data);
                                
                                // Force reload if we're on the wishlist page to ensure correct display
                                if (window.location.href.indexOf('wishlist') !== -1 || 
                                    window.location.href.indexOf('favorites') !== -1) {
                                    console.log('On wishlist page, will reload in 1 second to refresh content');
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1000);
                                }
                            } else {
                                console.error('Server reported error updating wishlist:', response.data);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error updating wishlist:', error);
                            console.error('Response:', xhr.responseText);
                        }
                    });
                } else {
                    console.error('Product ID not found in wishlist:', productId);
                    console.log('Current wishlist contents:', wishlist);
                    this.showMessage('Product was not in your favorites list.', 'error');
                    
                    // Since the product is not in the wishlist, but might still be showing on screen,
                    // try to force remove it from the DOM
                    var $staleItem = $('.cart-item[data-product-id="' + productId + '"]');
                    if ($staleItem.length) {
                        console.log('Found stale cart item to remove from DOM:', $staleItem);
                        $staleItem.fadeOut(300, function() {
                            $staleItem.remove();
                            var $mobileActions = $staleItem.next('.mobile-actions');
                            if ($mobileActions.length) {
                                $mobileActions.remove();
                            }
                        });
                    }
                }
            } catch (e) {
                console.error('Error in removeFromWishlist function:', e);
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
                        // Parse the cookie value
                        var cookieContent = decodeURIComponent(cookieValue.split('=')[1]);
                        console.log('Raw cookie content:', cookieContent);
                        
                        wishlist = JSON.parse(cookieContent);
                        console.log('Parsed wishlist from cookie:', wishlist);
                        
                        // Ensure we have an array
                        if (!Array.isArray(wishlist)) {
                            console.error('Wishlist is not an array:', wishlist);
                            wishlist = [];
                        } else {
                            // Ensure all product IDs are strings for consistent comparison
                            wishlist = wishlist.map(function(item) {
                                return item.toString();
                            });
                            console.log('Normalized wishlist (all strings):', wishlist);
                        }
                    } catch (e) {
                        console.error('Error parsing wishlist cookie:', e);
                        console.error('Cookie content:', cookieValue);
                        wishlist = [];
                    }
                }
            } else {
                console.log('No wishlist cookie found');
            }
            
            return wishlist;
        },
        
        saveWishlist: function(wishlist) {
            // Validate the wishlist input
            if (!Array.isArray(wishlist)) {
                console.error('Invalid wishlist (not an array):', wishlist);
                wishlist = [];
            }
            
            // Ensure all product IDs are strings for consistent storage
            wishlist = wishlist.map(function(item) {
                return item.toString();
            });
            
            // Set cookie expiration for 30 days
            var date = new Date();
            date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
            
            // Serialize wishlist to JSON string and encode for cookie
            var wishlistJson = JSON.stringify(wishlist);
            console.log('Wishlist JSON to save:', wishlistJson);
            
            // Set/update cookie with proper path and expiration
            var cookieString = 'lambo_wishlist=' + encodeURIComponent(wishlistJson) + 
                               '; expires=' + date.toUTCString() + 
                               '; path=/; SameSite=Lax';
            
            // Save cookie
            document.cookie = cookieString;
            
            console.log('Wishlist saved to cookie:', wishlist);
            console.log('Cookie string:', cookieString);
            
            // Double-check the saved cookie
            setTimeout(function() {
                if (document.cookie.indexOf('lambo_wishlist=') !== -1) {
                    console.log('Verified: Wishlist cookie was saved successfully');
                } else {
                    console.error('Error: Wishlist cookie was not saved');
                }
            }, 100);
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
    
    // This script is now deprecated in favor of global-wishlist.js
    // We leave this for backward compatibility but it now does very little
    console.log('Original wishlist.js loaded - functionality provided by global-wishlist.js');
});