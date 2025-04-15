<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/content-single-product.php.
 *
 * @package Lambo_Merch_Theme
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    <div class="row product-detail-main">
        <!-- Left Column - Product Image -->
        <div class="col-md-6 product-image-column">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <!-- Right Column - Product Details -->
        <div class="col-md-6 product-details-column">
            <div class="product-details-content">
                <h1 class="product-title"><?php the_title(); ?></h1>
                
                <div class="product-price-container">
                    <div class="price"><?php echo $product->get_price_html(); ?></div>
                    
                    <div class="stock-status">
                        <?php if ($product->is_in_stock()): ?>
                            <span class="in-stock">In Stock</span>
                        <?php else: ?>
                            <span class="out-of-stock">Out of Stock</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="product-short-description">
                    <?php echo apply_filters('woocommerce_short_description', $product->get_short_description()); ?>
                </div>
                
                <?php if ($product->is_type('variable')): ?>
                <div class="product-variations">
                    <div class="size-selector">
                        <?php 
                        /**
                         * Hook: woocommerce_before_add_to_cart_form.
                         */
                        do_action('woocommerce_before_add_to_cart_form');
                        ?>

                        <form class="variations_form cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>">
                            <?php do_action('woocommerce_before_variations_form'); ?>

                            <?php if (empty($product->get_available_variations()) && false === $product->get_variation_attributes()) : ?>
                                <p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?></p>
                            <?php else : ?>
                                <div class="variations">
                                    <?php foreach ($product->get_variation_attributes() as $attribute_name => $options) : ?>
                                        <div class="variation-row">
                                            <div class="label"><label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"><?php echo wc_attribute_label($attribute_name); ?></label></div>
                                            <div class="value">
                                                <?php
                                                wc_dropdown_variation_attribute_options(
                                                    array(
                                                        'options'   => $options,
                                                        'attribute' => $attribute_name,
                                                        'product'   => $product,
                                                    )
                                                );
                                                ?>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/size down arrow.png" class="size-selector-icon" alt="Size Selector">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php do_action('woocommerce_after_variations_form'); ?>
                        </form>

                        <?php
                        /**
                         * Hook: woocommerce_after_add_to_cart_form.
                         */
                        do_action('woocommerce_after_add_to_cart_form');
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="cart-actions">
                    <div class="quantity-and-cart">
                        <?php if ($product->is_type('simple')): ?>
                            <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                                <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                                <?php
                                /**
                                 * @hooked woocommerce_quantity_input - 10
                                 */
                                do_action('woocommerce_before_add_to_cart_quantity');
                                
                                woocommerce_quantity_input(
                                    array(
                                        'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                        'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                                    )
                                );

                                do_action('woocommerce_after_add_to_cart_quantity');
                                ?>

                                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

                                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                            </form>
                        <?php endif; ?>
                    </div>
                    
                    <div class="wishlist-button">
                        <?php
                        // Check if YITH WooCommerce Wishlist is active
                        if (function_exists('YITH_WCWL')): ?>
                            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                        <?php else: ?>
                            <button class="add-to-wishlist">Add to Wishlist</button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <hr class="details-divider">
            </div>
        </div>
    </div>
    
    <!-- Product Tabs Section -->
    <div class="row product-tabs-section">
        <div class="col-md-12">
            <div class="product-tabs">
                <ul class="tabs-nav">
                    <li class="active"><a href="#details" class="tab-link" data-tab="details"><img src="<?php echo get_template_directory_uri(); ?>/images/backgrounds/Rectangle 10.png" class="tab-bg" alt=""><span>Details</span></a></li>
                    <li><a href="#reviews" class="tab-link" data-tab="reviews"><img src="<?php echo get_template_directory_uri(); ?>/images/backgrounds/Rectangle 10.png" class="tab-bg" alt=""><span>Reviews</span></a></li>
                </ul>
                
                <div class="tabs-content">
                    <div id="details" class="tab-content active">
                        <div class="product-description">
                            <?php echo wpautop($product->get_description()); ?>
                        </div>
                    </div>
                    
                    <div id="reviews" class="tab-content">
                        <div class="product-reviews">
                            <?php
                            if (comments_open()) {
                                comments_template();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products Section -->
<div class="related-products-full-width">
    <div class="container">
        <h2 class="section-title">Top Related Products</h2>
        <div class="row related-products-row">
            <?php
            $related_products = wc_get_related_products($product->get_id(), 3);
            
            if ($related_products) {
                foreach ($related_products as $related_product_id) {
                    $related_product = wc_get_product($related_product_id);
                    ?>
                    <div class="col-md-4">
                        <div class="related-product">
                            <a href="<?php echo esc_url(get_permalink($related_product_id)); ?>">
                                <?php echo $related_product->get_image('medium'); ?>
                                <div class="product-price"><?php echo $related_product->get_price_html(); ?></div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="no-related">No related products found.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>

<script>
jQuery(document).ready(function($) {
    // Tab functionality
    $('.tab-link').on('click', function(e) {
        e.preventDefault();
        var tab = $(this).data('tab');
        
        // Remove active class from all tabs
        $('.tab-link').parent().removeClass('active');
        $('.tab-content').removeClass('active');
        
        // Add active class to selected tab
        $(this).parent().addClass('active');
        $('#' + tab).addClass('active');
    });
});
</script>