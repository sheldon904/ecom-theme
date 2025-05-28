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
                LamboWishlist.removeFromWishlist(productId);
            });
            
            // Add to cart from wishlist
            $(document).on('click', '.wishlist-product-actions .add-to-cart', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                LamboWishlist.addToCart(productId);
            });
        },
        
        updateWishlistCount: function() {
            var count = LamboWishlist.getWishlist().length;
            $('.wishlist-count').text(count > 0 ? count : '');
        }
    };
    
    // Initialize the local wishlist
    // localWishlist.init();
    
    console.log('Original wishlist.js loaded - functionality provided by global-wishlist.js');
});