/**
 * Simple Favorites System
 * This is a very simplified favorites implementation that directly sets post meta
 */

jQuery(document).ready(function($) {
    console.log('Simple Favorites system initialized');
    
    // Generate a visitor ID from cookie or create a new one if it doesn't exist
    var visitorId;
    if (document.cookie.indexOf('lambo_visitor_id=') !== -1) {
        var cookieValue = document.cookie.split('; ').find(function(row) { 
            return row.startsWith('lambo_visitor_id='); 
        });
        
        if (cookieValue) {
            visitorId = cookieValue.split('=')[1];
        }
    }
    
    if (!visitorId) {
        // Generate a random ID
        visitorId = Math.random().toString(36).substring(2, 15) + 
                   Math.random().toString(36).substring(2, 15);
        
        // Store it in a cookie for 30 days
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = 'lambo_visitor_id=' + visitorId + 
                         '; expires=' + date.toUTCString() + 
                         '; path=/; SameSite=Lax';
    }
    
    console.log('Visitor ID: ' + visitorId);
    
    // Handle adding/removing favorites
    $(document).on('click', '.add-to-wishlist', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var productId = $button.data('product-id');
        
        console.log('Toggle favorite for product ID: ' + productId);
        
        // Simple AJAX call to update favorite status
        $.ajax({
            type: 'POST',
            url: ajaxurl || '/wp-admin/admin-ajax.php',
            data: {
                action: 'simple_toggle_favorite',
                product_id: productId,
                visitor_id: visitorId
            },
            beforeSend: function() {
                $button.addClass('loading').text('Processing...');
            },
            success: function(response) {
                console.log('Response:', response);
                
                if (response.success) {
                    // Show a success message
                    alert(response.data.message);
                    
                    // Update button text
                    if (response.data.is_favorite) {
                        $button.addClass('added').text('Added to Favorites');
                    } else {
                        $button.removeClass('added').text('Add to Wishlist');
                    }
                    
                    // If we're on the product page and just added it, redirect to the favorites page
                    if (response.data.is_favorite && window.location.href.indexOf('wishlist') === -1) {
                        window.location.href = '/wishlist/';
                    }
                    
                    // If we're on the favorites page, just reload to show the updated list
                    if (window.location.href.indexOf('wishlist') !== -1) {
                        window.location.reload();
                    }
                } else {
                    // Show an error message
                    alert('Error: ' + (response.data ? response.data.message : 'Unknown error'));
                    $button.removeClass('loading').text('Add to Wishlist');
                }
            },
            error: function() {
                // Show an error message
                alert('Error connecting to the server. Please try again.');
                $button.removeClass('loading').text('Add to Wishlist');
            }
        });
    });
    
    // Handle removing favorites from the wishlist page
    $(document).on('click', '.remove-from-wishlist', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var productId = $button.data('product-id');
        
        console.log('Remove from favorites product ID: ' + productId);
        
        // Simple AJAX call to remove favorite
        $.ajax({
            type: 'POST',
            url: ajaxurl || '/wp-admin/admin-ajax.php',
            data: {
                action: 'simple_toggle_favorite',
                product_id: productId,
                visitor_id: visitorId,
                remove: true
            },
            beforeSend: function() {
                // Show loading state
                $button.addClass('loading');
            },
            success: function(response) {
                console.log('Response:', response);
                
                if (response.success) {
                    // If successful, fade out the product
                    var $product = $button.closest('.wishlist-product');
                    $product.fadeOut(300, function() {
                        $product.remove();
                        
                        // If no more products, show empty state
                        if ($('.wishlist-product').length === 0) {
                            $('.wishlist-container').html(
                                '<div class="empty-wishlist">' +
                                '<p>Your favorites list is empty.</p>' +
                                '<a href="/shop/" class="button continue-shopping">Continue Shopping</a>' +
                                '</div>'
                            );
                        }
                    });
                } else {
                    // Show an error message
                    alert('Error: ' + (response.data ? response.data.message : 'Unknown error'));
                    $button.removeClass('loading');
                }
            },
            error: function() {
                // Show an error message
                alert('Error connecting to the server. Please try again.');
                $button.removeClass('loading');
            }
        });
    });
    
    // Debug function that can be called from console
    window.checkFavoriteStatus = function(productId) {
        $.ajax({
            type: 'POST',
            url: ajaxurl || '/wp-admin/admin-ajax.php',
            data: {
                action: 'simple_check_favorite',
                product_id: productId,
                visitor_id: visitorId
            },
            success: function(response) {
                console.log('Favorite status for product ' + productId + ':', response);
            }
        });
    };
});