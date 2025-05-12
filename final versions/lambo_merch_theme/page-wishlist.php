<?php
/**
 * Template Name: Wishlist Page
 * Template Post Type: page
 *
 * A custom template for the wishlist/favs page
 *
 * @package Lambo_Merch
 */

get_header(); 
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="wishlist-title"><?php esc_html_e('My Favorites', 'lambo-merch'); ?></h1>
            
            <div class="wishlist-container">
                <?php
                // Get wishlist items from cookies or user meta if logged in
                $wishlist_items = array();
                
                if (is_user_logged_in()) {
                    // Get wishlist from user meta
                    $current_user_id = get_current_user_id();
                    $wishlist_items = get_user_meta($current_user_id, 'lambo_wishlist', true);
                    if (!is_array($wishlist_items)) {
                        $wishlist_items = array();
                    }
                } else {
                    // Get wishlist from cookies
                    if (isset($_COOKIE['lambo_wishlist'])) {
                        $wishlist_items = json_decode(stripslashes($_COOKIE['lambo_wishlist']), true);
                        if (!is_array($wishlist_items)) {
                            $wishlist_items = array();
                        }
                    }
                }
                
                if (!empty($wishlist_items)) {
                    echo '<div class="wishlist-products">';
                    foreach ($wishlist_items as $product_id) {
                        $product = wc_get_product($product_id);
                        
                        // Skip if product doesn't exist
                        if (!$product) {
                            continue;
                        }
                        
                        ?>
                        <div class="wishlist-product" data-product-id="<?php echo esc_attr($product_id); ?>">
                            <div class="wishlist-product-image">
                                <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                    <?php echo $product->get_image('medium'); ?>
                                </a>
                            </div>
                            
                            <div class="wishlist-product-details">
                                <h2 class="wishlist-product-title">
                                    <a href="<?php echo esc_url(get_permalink($product_id)); ?>">
                                        <?php echo $product->get_name(); ?>
                                    </a>
                                </h2>
                                
                                <div class="wishlist-product-price">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                                
                                <div class="wishlist-product-actions">
                                    <button class="button add-to-cart" data-product-id="<?php echo esc_attr($product_id); ?>">
                                        <?php esc_html_e('Add to Cart', 'lambo-merch'); ?>
                                    </button>
                                    
                                    <button class="remove-from-wishlist" data-product-id="<?php echo esc_attr($product_id); ?>">
                                        <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/trash-can-icon.png" alt="Remove" class="remove-icon">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                } else {
                    echo '<div class="empty-wishlist">';
                    echo '<p>' . esc_html__('Your favorites list is empty.', 'lambo-merch') . '</p>';
                    echo '<a href="' . esc_url(get_permalink(wc_get_page_id('shop'))) . '" class="button continue-shopping">' . esc_html__('Continue Shopping', 'lambo-merch') . '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    .wishlist-title {
        margin-bottom: 30px;
        text-align: center;
        color: #fff;
        text-transform: uppercase;
        font-size: 32px;
    }
    
    .wishlist-products {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .wishlist-product {
        display: flex;
        background-color: #222;
        padding: 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .wishlist-product:hover {
        background-color: #333;
    }
    
    .wishlist-product-image {
        flex: 0 0 200px;
        margin-right: 20px;
    }
    
    .wishlist-product-image img {
        max-width: 100%;
        height: auto;
    }
    
    .wishlist-product-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .wishlist-product-title {
        font-size: 24px;
        margin-bottom: 10px;
        font-weight: bold;
    }
    
    .wishlist-product-title a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .wishlist-product-title a:hover {
        color: #C8B100; /* Gold color */
    }
    
    .wishlist-product-price {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #C8B100; /* Gold color */
    }
    
    .wishlist-product-actions {
        display: flex;
        align-items: center;
    }
    
    .wishlist-product-actions .add-to-cart {
        margin-right: 15px;
        background-color: #C8B100; /* Gold color */
        color: #000;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    
    .wishlist-product-actions .add-to-cart:hover {
        background-color: #a99600; /* Darker gold */
    }
    
    .remove-from-wishlist {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        transition: transform 0.2s ease;
    }
    
    .remove-from-wishlist:hover {
        transform: scale(1.1);
    }
    
    .remove-icon {
        width: 25px;
        height: auto;
    }
    
    .empty-wishlist {
        text-align: center;
        padding: 50px 0;
    }
    
    .empty-wishlist p {
        font-size: 18px;
        margin-bottom: 20px;
        color: #fff;
    }
    
    .continue-shopping {
        background-color: #C8B100; /* Gold color */
        color: #000;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s ease;
    }
    
    .continue-shopping:hover {
        background-color: #a99600; /* Darker gold */
    }
    
    @media (max-width: 767px) {
        .wishlist-product {
            flex-direction: column;
        }
        
        .wishlist-product-image {
            flex: 0 0 auto;
            margin-right: 0;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .wishlist-product-details {
            text-align: center;
        }
        
        .wishlist-product-actions {
            justify-content: center;
        }
    }
</style>

<!-- Wishlist item validation and visibility control -->
<script>
// Initialize wishlist items visibility on page load
jQuery(document).ready(function($) {
    // Define a function to handle wishlist item visibility
    function updateWishlistItemVisibility() {
        console.log("Updating wishlist item visibility");
        
        // First try to get wishlist items from localStorage
        var currentWishlist = [];
        try {
            var localStorageWishlist = localStorage.getItem('wishlist');
            if (localStorageWishlist) {
                currentWishlist = JSON.parse(localStorageWishlist);
                console.log('Loaded wishlist from localStorage:', currentWishlist);
            }
        } catch (e) {
            console.error('Error accessing localStorage:', e);
        }
        
        // If no localStorage data, try the global LamboWishlist object
        if (currentWishlist.length === 0 && typeof LamboWishlist !== 'undefined') {
            currentWishlist = LamboWishlist.getWishlist();
            console.log('Loaded wishlist from LamboWishlist object:', currentWishlist);
        }
        
        if (currentWishlist.length === 0) {
            console.log('No wishlist items found, showing empty state');
            // No wishlist items found, show empty state
            var emptyHtml = '<div class="empty-wishlist">' +
                '<p>' + <?php echo wp_json_encode(__('Your favorites list is empty.', 'lambo-merch')); ?> + '</p>' +
                '<a href="' + <?php echo wp_json_encode(esc_url(get_permalink(wc_get_page_id('shop')))); ?> + '" class="button continue-shopping">' + 
                <?php echo wp_json_encode(__('Continue Shopping', 'lambo-merch')); ?> + '</a></div>';
            
            $('.wishlist-container').html(emptyHtml);
            return;
        }
        
        // Ensure all product IDs are strings for consistent comparison
        currentWishlist = currentWishlist.map(function(item) {
            return item.toString();
        });
        
        console.log('Filtered wishlist (all strings):', currentWishlist);
        
        // Get all wishlist items on the page
        var $wishlistItems = $('.wishlist-product');
        console.log('Found', $wishlistItems.length, 'wishlist items in DOM');
        
        if ($wishlistItems.length > 0) {
            var anyItemsVisible = false;
            
            // Loop through each item and check if it's in the wishlist
            $wishlistItems.each(function() {
                var $item = $(this);
                var itemId = $item.data('product-id');
                
                // Make sure itemId is a string and log it
                itemId = itemId ? itemId.toString() : '';
                
                console.log('Checking item ID:', itemId, ' (type: ' + typeof itemId + ')');
                console.log('Wishlist:', currentWishlist);
                
                // Check if the item ID is in the wishlist using some() for more flexible comparison
                var inWishlist = currentWishlist.some(function(wishlistId) {
                    return wishlistId.toString() === itemId;
                });
                
                console.log('Item in wishlist:', inWishlist);
                
                if (inWishlist) {
                    // Item is in wishlist, show it
                    $item.addClass('wishlist-active');
                    $item.css('display', 'flex'); // Force display in case CSS isn't loaded yet
                    anyItemsVisible = true;
                    console.log('Showing item:', itemId);
                } else {
                    // Item not in wishlist, ensure it stays hidden
                    $item.removeClass('wishlist-active');
                    $item.css('display', 'none'); // Force hide
                    console.log('Hiding item:', itemId);
                }
            });
            
            // If no items are visible after filtering, show empty state
            if (!anyItemsVisible) {
                console.log('No matching items in wishlist, showing empty state');
                var emptyHtml = '<div class="empty-wishlist">' +
                    '<p>' + <?php echo wp_json_encode(__('Your favorites list is empty.', 'lambo-merch')); ?> + '</p>' +
                    '<a href="' + <?php echo wp_json_encode(esc_url(get_permalink(wc_get_page_id('shop')))); ?> + '" class="button continue-shopping">' + 
                    <?php echo wp_json_encode(__('Continue Shopping', 'lambo-merch')); ?> + '</a></div>';
                
                $('.wishlist-container').html(emptyHtml);
            }
        }
    }
    
    // Run immediately and after a short delay to ensure everything is loaded
    updateWishlistItemVisibility();
    
    // Also watch for changes to localStorage
    window.addEventListener('storage', function(e) {
        if (e.key === 'wishlist') {
            console.log('localStorage wishlist changed, updating display');
            updateWishlistItemVisibility();
        }
    });
});
</script>

<?php get_footer(); ?>