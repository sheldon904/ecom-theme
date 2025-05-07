/**
 * Global Favorites/Wishlist System
 * This file provides global access to product favorites functionality across the site
 */

// Create the global LamboFavorites object
window.LamboFavorites = {
    // Toggle favorite status for a product
    toggleFavorite: function(productId) {
        // Convert productId to string for consistent comparison
        productId = productId ? productId.toString() : '';
        console.log('Toggling favorite status for product ID:', productId);
        
        if (!productId) {
            this.showMessage('Error: Invalid product ID', 'error');
            return;
        }
        
        // Send AJAX request to toggle favorite status
        jQuery.ajax({
            type: 'POST',
            url: typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php',
            data: {
                action: 'lambo_toggle_favorite',
                product_id: productId
            },
            beforeSend: function() {
                console.log('Sending request to toggle favorite status for product ID:', productId);
            },
            success: function(response) {
                console.log('Server response:', response);
                
                if (response.success) {
                    // Update UI based on new status
                    LamboFavorites.updateFavoriteUI(productId, response.data.status);
                    
                    // Show success message
                    LamboFavorites.showMessage(
                        response.data.status ? 
                        'Product added to your favorites!' : 
                        'Product removed from your favorites!', 
                        'success'
                    );
                    
                    // If we just added a product and we're not on the wishlist page, redirect to it
                    if (response.data.status && window.location.href.indexOf('wishlist') === -1) {
                        console.log('Product added to favorites, redirecting to wishlist page in 1 second...');
                        setTimeout(function() {
                            window.location.href = '/wishlist/';
                        }, 1000);
                        return;
                    }
                    
                    // If on favorites page, refresh the page to show changes
                    if (window.location.href.indexOf('wishlist') !== -1) {
                        console.log('On wishlist page, reloading to show updated favorites...');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                        return;
                    }
                    
                    // If on favorites page and removing an item, handle the UI update
                    if (!response.data.status && window.location.href.indexOf('wishlist') !== -1) {
                        var $product = jQuery('.wishlist-product[data-product-id="' + productId + '"]');
                        if ($product.length) {
                            $product.fadeOut(300, function() {
                                $product.remove();
                                
                                // If no more products, show empty state
                                if (jQuery('.wishlist-product').length === 0) {
                                    var emptyHtml = '<div class="empty-wishlist">' +
                                        '<p>Your favorites list is empty.</p>' +
                                        '<a href="' + (typeof wc_add_to_cart_params !== 'undefined' ? 
                                           wc_add_to_cart_params.shop_url : '/shop') + 
                                        '" class="button continue-shopping">Continue Shopping</a></div>';
                                    
                                    jQuery('.wishlist-container').html(emptyHtml);
                                }
                            });
                        }
                    }
                } else {
                    // Show error message
                    LamboFavorites.showMessage(
                        response.data && response.data.message ? 
                        response.data.message : 
                        'Error updating favorite status', 
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error('Error toggling favorite status:', error);
                LamboFavorites.showMessage('Error updating favorite status. Please try again.', 'error');
            }
        });
    },
    
    // Update the UI to reflect favorite status
    updateFavoriteUI: function(productId, isFavorite) {
        // Update the add/remove buttons
        var $addButtons = jQuery('.add-to-wishlist[data-product-id="' + productId + '"]');
        var $removeButtons = jQuery('.remove-from-wishlist[data-product-id="' + productId + '"]');
        
        if (isFavorite) {
            // Product is a favorite
            $addButtons.addClass('added').text('Added to Favorites');
        } else {
            // Product is not a favorite
            $addButtons.removeClass('added').text('Add to Wishlist');
        }
        
        // Update the favicon icon if it exists
        var $icon = jQuery('.wishlist-icon[data-product-id="' + productId + '"]');
        if ($icon.length) {
            if (isFavorite) {
                $icon.addClass('active');
            } else {
                $icon.removeClass('active');
            }
        }
        
        console.log('Updated UI for product ID:', productId, 'Favorite status:', isFavorite);
    },
    
    // Check favorite status for a product
    checkFavoriteStatus: function(productId) {
        jQuery.ajax({
            type: 'POST',
            url: typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php',
            data: {
                action: 'lambo_check_favorite',
                product_id: productId
            },
            success: function(response) {
                if (response.success) {
                    LamboFavorites.updateFavoriteUI(productId, response.data.status);
                }
            }
        });
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

// Initialize favorites system on page load
jQuery(document).ready(function($) {
    // Set up click event handlers for favorite buttons
    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log('Add to wishlist button clicked, product ID:', productId);
        LamboFavorites.toggleFavorite(productId);
    });
    
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        console.log('Remove from wishlist button clicked, product ID:', productId);
        LamboFavorites.toggleFavorite(productId);
    });
    
    // Check for backward compatibility - map LamboWishlist to LamboFavorites
    if (typeof window.LamboWishlist === 'undefined') {
        window.LamboWishlist = {
            addToWishlist: function(productId) {
                LamboFavorites.toggleFavorite(productId);
            },
            removeFromWishlist: function(productId) {
                LamboFavorites.toggleFavorite(productId);
            },
            showMessage: LamboFavorites.showMessage
        };
    }
    
    console.log('Favorites system initialized');
});