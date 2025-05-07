/**
 * Favorites System Check
 * This script verifies that the favorites system is working correctly
 */

// Create a function to debug favorites data
window.debugFavorites = function() {
    console.log('Debugging favorites data...');
    
    jQuery.ajax({
        type: 'POST',
        url: typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php',
        data: {
            action: 'lambo_debug_favorites'
        },
        success: function(response) {
            console.log('Debug favorites response:', response);
            
            if (response.success && response.data) {
                console.log('User ID:', response.data.user_id);
                console.log('Meta key:', response.data.meta_key);
                console.log('Favorite products:', response.data.favorites);
                console.log('All favorite meta keys:', response.data.all_favorite_keys);
                
                // Log information about the browser environment
                console.log('Browser IP address is used for guest ID');
                console.log('Current URL:', window.location.href);
                console.log('ajaxurl defined:', typeof ajaxurl !== 'undefined');
                
                // Check if browser is storing cookies correctly
                console.log('Cookie enabled:', navigator.cookieEnabled);
                console.log('All cookies:', document.cookie);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error debugging favorites:', error);
        }
    });
};

// Create a global test function for use in browser console
window.testFavorites = function(productId) {
    if (!productId) {
        console.error('Please provide a product ID to test');
        return;
    }
    
    console.log('Testing favorites functionality with product ID:', productId);
    
    if (typeof window.LamboFavorites === 'undefined') {
        console.error('LamboFavorites object is not defined!');
        return;
    }
    
    // Send a direct AJAX request to check if product is a favorite
    jQuery.ajax({
        type: 'POST',
        url: typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php',
        data: {
            action: 'lambo_check_favorite',
            product_id: productId
        },
        success: function(response) {
            console.log('Check favorite response:', response);
            
            // Now toggle the favorite status directly
            jQuery.ajax({
                type: 'POST',
                url: typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php',
                data: {
                    action: 'lambo_toggle_favorite',
                    product_id: productId
                },
                success: function(response) {
                    console.log('Toggle favorite response:', response);
                    
                    // If successful, reload the page if we're on the wishlist page
                    if (response.success && window.location.href.indexOf('wishlist') !== -1) {
                        console.log('Reloading wishlist page to see updated products...');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error toggling favorite:', error);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Error checking favorite status:', error);
        }
    });
};

jQuery(document).ready(function($) {
    console.log('Favorites system check running...');
    
    // Check if our main LamboFavorites object exists
    if (typeof window.LamboFavorites === 'undefined') {
        console.error('ERROR: LamboFavorites object is not defined. Favorites functionality will not work.');
        return;
    }
    
    console.log('LamboFavorites object found. Checking methods...');
    
    // Check for required methods
    var requiredMethods = ['toggleFavorite', 'updateFavoriteUI', 'showMessage'];
    var missingMethods = [];
    
    requiredMethods.forEach(function(method) {
        if (typeof window.LamboFavorites[method] !== 'function') {
            missingMethods.push(method);
        }
    });
    
    if (missingMethods.length > 0) {
        console.error('ERROR: LamboFavorites is missing required methods:', missingMethods.join(', '));
    } else {
        console.log('All required methods present in LamboFavorites.');
    }
    
    // Check if we have wishlist buttons on the page
    var $addButtons = $('.add-to-wishlist');
    var $removeButtons = $('.remove-from-wishlist');
    
    console.log('Found ' + $addButtons.length + ' add buttons and ' + $removeButtons.length + ' remove buttons on page.');
    
    // Log the current page
    console.log('Current page:', window.location.href);
    
    // If this is a product page, log the product ID
    if ($('body').hasClass('single-product')) {
        var productId = $('.add-to-wishlist').data('product-id');
        console.log('Product page detected. Product ID:', productId);
        
        // Suggest testing the favorite functionality
        console.log('You can test toggling favorites for this product by running this in the console:');
        console.log('testFavorites(' + productId + ');');
    }
    
    // If this is the wishlist page, log the products
    if (window.location.href.indexOf('wishlist') !== -1) {
        var products = [];
        $('.wishlist-product').each(function() {
            products.push($(this).data('product-id'));
        });
        console.log('Wishlist page detected. Products:', products);
        
        if (products.length === 0) {
            console.log('No products found on wishlist page. This could indicate a problem with the favorites query.');
            console.log('To manually test adding a product, visit a product page and use the testFavorites() function.');
        }
    }
    
    console.log('Favorites system check complete.');
});