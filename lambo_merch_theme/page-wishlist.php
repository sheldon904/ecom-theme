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

// DIRECT DATABASE CHECK - Bypass the functions to directly query favorite products

// Generate a visitor ID from cookie or create a new one if it doesn't exist
if (!isset($_COOKIE['lambo_visitor_id'])) {
    $visitor_id = md5(uniqid('visitor_', true));
    setcookie('lambo_visitor_id', $visitor_id, time() + (30 * DAY_IN_SECONDS), '/');
} else {
    $visitor_id = $_COOKIE['lambo_visitor_id'];
}

// Use that visitor ID for guests, or the WordPress user ID for logged in users
$user_id = is_user_logged_in() ? 'user_' . get_current_user_id() : 'visitor_' . $visitor_id;

// Initialize empty array for favorites
$favorite_product_ids = array();

// Connect to the WordPress database directly
global $wpdb;

// Get all products that have the favorite meta key for this user with a value of 1
$query = $wpdb->prepare("
    SELECT post_id 
    FROM {$wpdb->postmeta} 
    WHERE meta_key = %s 
    AND meta_value = %s
", "favorite_" . $user_id, '1');

// Execute the query
$favorite_product_ids = $wpdb->get_col($query);

// Log for debugging
error_log('Direct DB Query: ' . $query);
error_log('Found favorite products: ' . implode(', ', $favorite_product_ids));
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="wishlist-title"><?php esc_html_e('My Favorites', 'lambo-merch'); ?></h1>
            
            <div class="wishlist-container">
                <?php if (!empty($favorite_product_ids)): ?>
                    <div class="wishlist-products">
                        <?php foreach ($favorite_product_ids as $product_id): 
                            // Get the product
                            $product = wc_get_product($product_id);
                            
                            // Skip if product doesn't exist
                            if (!$product || !is_a($product, 'WC_Product')) {
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
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/trash can icon.png" alt="Remove" class="remove-icon">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-wishlist">
                        <p><?php esc_html_e('Your favorites list is empty.', 'lambo-merch'); ?></p>
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="button continue-shopping">
                            <?php esc_html_e('Continue Shopping', 'lambo-merch'); ?>
                        </a>
                    </div>
                <?php endif; ?>
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

<script>
jQuery(document).ready(function($) {
    // Handle Add to Cart button clicks
    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        
        $.ajax({
            type: 'POST',
            url: typeof ajaxurl !== 'undefined' ? ajaxurl : '/wp-admin/admin-ajax.php',
            data: {
                action: 'lambo_add_to_cart',
                product_id: productId,
                quantity: 1
            },
            beforeSend: function() {
                $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart').text('Adding...').prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    if (typeof LamboFavorites !== 'undefined') {
                        LamboFavorites.showMessage('Product added to cart!', 'success');
                    } else {
                        alert('Product added to cart!');
                    }
                    
                    // Update cart count in header if available
                    if (response.cart_count && $('.cart-count').length) {
                        $('.cart-count').text(response.cart_count);
                    }
                    
                    // Re-enable button
                    $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart')
                        .text('Add to Cart')
                        .prop('disabled', false);
                } else {
                    // Show error message
                    if (typeof LamboFavorites !== 'undefined') {
                        LamboFavorites.showMessage('Error adding product to cart.', 'error');
                    } else {
                        alert('Error adding product to cart.');
                    }
                    
                    // Re-enable button
                    $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart')
                        .text('Add to Cart')
                        .prop('disabled', false);
                }
            },
            error: function() {
                // Show error message
                if (typeof LamboFavorites !== 'undefined') {
                    LamboFavorites.showMessage('Error adding product to cart. Please try again.', 'error');
                } else {
                    alert('Error adding product to cart. Please try again.');
                }
                
                // Re-enable button
                $('.wishlist-product[data-product-id="' + productId + '"] .add-to-cart')
                    .text('Add to Cart')
                    .prop('disabled', false);
            }
        });
    });
});
</script>

<?php get_footer(); ?>