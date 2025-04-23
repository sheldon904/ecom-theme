<?php
/**
 * The template for displaying variable product content in the variable-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/content-variable-product.php.
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
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('variable-product-wrapper', $product); ?>>
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
                                            <div class="label"><label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"><?php echo wc_attribute_label($attribute_name); ?> <span class="required">*</span></label></div>
                                            <div class="value">
                                                <?php
                                                wc_dropdown_variation_attribute_options(
                                                    array(
                                                        'options'   => $options,
                                                        'attribute' => $attribute_name,
                                                        'product'   => $product,
                                                        'required'  => true
                                                    )
                                                );
                                                ?>
                                                <img src="<?php echo get_template_directory_uri(); ?>/images/icons/size down arrow.png" class="size-selector-icon" alt="Size Selector">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Variation Price Display -->
                                <div class="variation-price-display"></div>
                                
                                <div class="single_variation_wrap">
                                    <?php
                                    /**
                                     * Hook: woocommerce_before_single_variation.
                                     */
                                    do_action('woocommerce_before_single_variation');
                                    
                                    /**
                                     * Hook: woocommerce_single_variation.
                                     * This outputs the variation price, variation availability status and add to cart button.
                                     */
                                    do_action('woocommerce_single_variation');
                                    
                                    /**
                                     * Hook: woocommerce_after_single_variation.
                                     */
                                    do_action('woocommerce_after_single_variation');
                                    ?>
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

<?php do_action('woocommerce_after_single_product'); ?>

<style>
/* Variable Product Styling */
.variable-product-wrapper {
    margin-bottom: 40px;
}

.product-variations {
    margin-bottom: 25px;
}

/* Error styling */
.error-field {
    border: 2px solid red !important;
}

/* Size selector styling */
.variations select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: white;
}

.variations .value {
    position: relative;
}

.size-selector-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: auto;
    pointer-events: none;
}

/* Make variation rows display better */
.variations {
    width: 100%;
    margin-bottom: 20px;
}

.variation-row {
    margin-bottom: 15px;
}

.variations .label label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

/* Selected variation display */
.variation-price-display {
    margin: 10px 0;
    font-weight: bold;
}

.selected-variation {
    padding: 8px;
    background-color: #f8f8f8;
    border-radius: 4px;
    margin-bottom: 15px;
}

/* Add to cart button styling */
.single_add_to_cart_button {
    background-color: #000;
    color: #fff;
    padding: 12px 25px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-transform: uppercase;
    font-weight: bold;
    margin-top: 15px;
    width: 100%;
    transition: background-color 0.3s;
}

.single_add_to_cart_button:hover {
    background-color: #333;
}

/* Make quantity input nicer */
.quantity input {
    width: 60px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-right: 10px;
}

/* Responsive styling */
@media (max-width: 768px) {
    .product-detail-main .col-md-6 {
        margin-bottom: 30px;
    }
}
</style>

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
        //empty
    });
    
    // Reset display when variations are reset
    $('.variations_form').on('reset_data', function() {
        $('.variation-price-display').html('');
    });
});
</script>