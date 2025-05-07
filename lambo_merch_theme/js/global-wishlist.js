/**
 * Global Wishlist Functions
 * This file provides global access to wishlist functionality across the site
 */

// Create the global LamboWishlist object
window.LamboWishlist = {
    // Get wishlist from cookie
    getWishlist: function() {
        var wishlist = [];
        
        // Check for wishlist cookie
        if (document.cookie.indexOf('lambo_wishlist=') !== -1) {
            var cookieValue = document.cookie.split('; ').find(function(row) { 
                return row.startsWith('lambo_wishlist='); 
            });
            
            if (cookieValue) {
                try {
                    // Parse the cookie value
                    var cookieContent = decodeURIComponent(cookieValue.split('=')[1]);
                    console.log('Raw cookie content:', cookieContent);
                    
                    wishlist = JSON.parse(cookieContent);
                    
                    // Ensure we have an array
                    if (!Array.isArray(wishlist)) {
                        console.error('Wishlist is not an array:', wishlist);
                        wishlist = [];
                    } else {
                        // Ensure all product IDs are strings for consistent comparison
                        wishlist = wishlist.map(function(item) {
                            return item.toString();
                        });
                    }
                } catch (e) {
                    console.error('Error parsing wishlist cookie:', e);
                    wishlist = [];
                }
            }
        }
        
        return wishlist;
    },
    
    // Save wishlist to cookie
    saveWishlist: function(wishlist) {
        if (!Array.isArray(wishlist)) {
            console.error('Cannot save invalid wishlist (not an array):', wishlist);
            wishlist = [];
        }
        
        // Ensure all product IDs are strings
        wishlist = wishlist.map(function(item) {
            return item.toString();
        });
        
        // Set cookie expiration for 30 days
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        
        // Serialize wishlist to JSON string and encode for cookie
        var wishlistJson = JSON.stringify(wishlist);
        
        // Set/update cookie with proper path and expiration
        var cookieString = 'lambo_wishlist=' + encodeURIComponent(wishlistJson) + 
                           '; expires=' + date.toUTCString() + 
                           '; path=/; SameSite=Lax';
        
        // Save cookie
        document.cookie = cookieString;
        console.log('Wishlist saved to cookie:', wishlist);
    },
    
    // Add a product to the wishlist
    addToWishlist: function(productId) {
        // Convert productId to string for consistent comparison
        productId = productId ? productId.toString() : '';
        console.log('Adding to wishlist, product ID:', productId);
        
        if (!productId) {
            this.showMessage('Error: Invalid product ID', 'error');
            return;
        }
        
        // Get current wishlist
        var wishlist = this.getWishlist();
        
        // Check if product is already in wishlist
        if (wishlist.indexOf(productId) === -1) {
            // Add product to wishlist (as string)
            wishlist.push(productId);
            
            // Save updated wishlist
            this.saveWishlist(wishlist);
            
            // Show success message
            this.showMessage('Product added to your favorites!', 'success');
            
            // Update wishlist count in header
            this.updateWishlistCount();
            
            // Send AJAX request to update server-side wishlist for logged-in users
            this.updateServerWishlist(wishlist);
        } else {
            // Product already in wishlist
            this.showMessage('Product is already in your favorites!', 'info');
        }
    },
    
    // Remove a product from the wishlist
    removeFromWishlist: function(productId) {
        // Convert productId to string for consistent comparison
        productId = productId ? productId.toString() : '';
        console.log('Removing from wishlist, product ID:', productId);
        
        if (!productId) {
            this.showMessage('Error: Invalid product ID', 'error');
            return;
        }
        
        // Get current wishlist
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
            
            // Update wishlist count in header
            this.updateWishlistCount();
            
            // Send AJAX request to update server-side wishlist for logged-in users
            this.updateServerWishlist(wishlist);
            
            // If on wishlist/favorites page, remove the item from the DOM
            var $cartItem = jQuery('.cart-item[data-product-id="' + productId + '"]');
            if ($cartItem.length) {
                var $mobileActions = $cartItem.next('.mobile-actions');
                
                $cartItem.fadeOut(300, function() {
                    $cartItem.remove();
                    if ($mobileActions.length) {
                        $mobileActions.remove();
                    }
                    
                    // If list becomes empty, show empty state
                    if (jQuery('.cart-item').length === 0) {
                        var emptyHtml = '<div style="text-align:center; padding:50px 0;">' +
                            '<p style="color:#fff; font-size:18px; margin-bottom:20px;">Your favorites list is empty.</p>' +
                            '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? wc_add_to_cart_params.shop_url : '/shop') + 
                            '" class="button" style="background:#ff0000; color:#fff; padding:12px 24px; text-transform:uppercase; font-weight:bold; text-decoration:none; display:inline-block;">' +
                            'Continue Shopping</a></div>';
                        
                        jQuery('.desktop-layout, .mobile-layout').html(emptyHtml);
                    }
                });
            }
        } else {
            // Product not in wishlist
            this.showMessage('Product was not in your favorites list', 'error');
        }
    },
    
    // Update server-side wishlist via AJAX
    updateServerWishlist: function(wishlist) {
        // Prepare the AJAX data
        var ajaxData = {
            action: 'lambo_update_user_wishlist',
            wishlist: wishlist
        };
        
        // Get the AJAX URL
        var ajaxUrl = (typeof lambo_wishlist_params !== 'undefined' && lambo_wishlist_params.ajaxurl) ? 
            lambo_wishlist_params.ajaxurl : (typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php');
        
        // Send the AJAX request
        jQuery.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: ajaxData,
            success: function(response) {
                console.log('Server wishlist update response:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error updating server wishlist:', error);
            }
        });
    },
    
    // Update wishlist count in header
    updateWishlistCount: function() {
        var count = this.getWishlist().length;
        jQuery('.wishlist-count').text(count > 0 ? count : '');
    },
    
    // Show notification message
    showMessage: function(message, type) {
        var $messageElement = jQuery('.lambo-wishlist-message');
        
        // If the message element doesn't exist, create it
        if ($messageElement.length === 0) {
            jQuery('body').append('<div class="lambo-wishlist-message"></div>');
            $messageElement = jQuery('.lambo-wishlist-message');
        }
        
        // Set the message content and style
        $messageElement
            .attr('class', 'lambo-wishlist-message ' + type)
            .html(message)
            .fadeIn(300);
        
        // Auto-hide the message after 3 seconds
        clearTimeout(this.messageTimeout);
        this.messageTimeout = setTimeout(function() {
            $messageElement.fadeOut(300);
        }, 3000);
    }
};

// Initialize wishlist count on page load
jQuery(document).ready(function($) {
    // Update wishlist count in header
    LamboWishlist.updateWishlistCount();
    
    // Add direct click event handlers for add/remove wishlist buttons
    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log('Add to wishlist button clicked, product ID:', productId);
        LamboWishlist.addToWishlist(productId);
    });
    
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log('Remove from wishlist button clicked, product ID:', productId);
        LamboWishlist.removeFromWishlist(productId);
    });
    
    console.log('Global wishlist functionality initialized');
});