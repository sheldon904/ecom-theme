<?php
/**
 * The Template for displaying variable products
 *
 * @package Lambo_Merch
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// This template is only for variable products
// Make sure we have a valid product
global $product;
if (!is_object($product) || !$product->is_type('variable')) {
    global $post;
    if (isset($post->ID)) {
        $product = wc_get_product($post->ID);
    }
}

// If still no valid variable product, redirect to the normal product page
if (!is_object($product) || !$product->is_type('variable')) {
    wp_redirect(get_permalink());
    exit;
}

// Normal template structure
get_header('shop');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            /**
             * Hook: woocommerce_before_main_content.
             */
            do_action('woocommerce_before_main_content');
            ?>

            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('variable-product-wrapper', $product); ?>>
                <div class="row product-detail-main">
                    <!-- Left Column - Product Image -->
                    <div class="col-md-6 product-image-column">
                        <?php
                        /**
                         * Hook: woocommerce_before_single_product_summary.
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
                            
                            <div class="exclusive-product-notice">
                                <p><?php echo esc_html__('Limited edition - Don\'t miss out!', 'lambo-merch'); ?></p>
                            </div>
                            
                            <div class="product-variations">
                                <div class="size-selector">
                                    <?php
                                    /**
                                     * Display variable product add to cart form
                                     */
                                    $available_variations = $product->get_available_variations();
                                    $attributes = $product->get_variation_attributes();
                                    $selected_attributes = $product->get_default_attributes();

                                    // Include the custom variable product template
                                    wc_get_template(
                                        'single-product/add-to-cart/variable.php',
                                        array(
                                            'available_variations' => $available_variations,
                                            'attributes'           => $attributes,
                                            'selected_attributes'  => $selected_attributes,
                                        )
                                    );
                                    ?>
                                </div>
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

            <?php
            do_action('woocommerce_after_main_content');
            ?>
        </div><!-- .col-md-12 -->
    </div><!-- .row -->
</div><!-- .container -->

<?php get_footer('shop'); ?>

<script>
jQuery(document).ready(function($) {
    // Tab functionality
    $('.tab-link').on('click', function(e) {
        e.preventDefault();
        var tab = $(this).data('tab');
        
        // Remove active class from all tabs
        $('.tab-link').parent().removeClass('active');
        $('.tab-content').removeClass('active');
        
        // Add active class to the selected tab
        $(this).parent().addClass('active');
        $('#' + tab).addClass('active');
    });
    
    // Make sure variation selects are required
    $('.variations select').attr('required', 'required');
    
    // Enhanced validation for variable products
    $('.variations_form').on('submit', function(e) {
        var $form = $(this);
        var $variationId = $form.find('input[name="variation_id"]');
        var $selects = $form.find('.variations select');
        var allSelected = true;
        
        // Check all variation dropdowns
        $selects.each(function() {
            if (!$(this).val()) {
                allSelected = false;
                $(this).addClass('error-field');
            }
        });
        
        // Check variation ID
        if (!allSelected || !$variationId.val() || $variationId.val() === '0') {
            e.preventDefault();
            alert('Please select all options before adding to cart.');
            return false;
        }
    });
    
    // Remove error class when selection is made
    $('.variations select').on('change', function() {
        $(this).removeClass('error-field');
    });
    
    // Update display when variation is selected
    $('.variations_form').on('show_variation', function(event, variation) {
        // Show selected variation details
        if (variation) {
            $('.variation-price-display').html('<div class="selected-variation">Selected option: ' + variation.price_html + '</div>');
        }
    });
    
    // Reset display when variations are reset
    $('.variations_form').on('reset_data', function() {
        $('.variation-price-display').html('');
    });
});
</script>