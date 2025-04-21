<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined('ABSPATH') || exit;

global $product;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form');
?>

<form class="variations_form cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
    <?php do_action('woocommerce_before_variations_form'); ?>

    <?php if (empty($available_variations) && false !== $available_variations) : ?>
        <p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?></p>
    <?php else : ?>
        <h4 class="variations-title">Select Options</h4>
        
        <div class="variations">
            <?php foreach ($attributes as $attribute_name => $options) : ?>
                <div class="variation-row">
                    <div class="label"><label for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"><?php echo wc_attribute_label($attribute_name); ?> <span class="required">*</span></label></div>
                    <div class="value">
                        <?php
                        wc_dropdown_variation_attribute_options(
                            array(
                                'options'   => $options,
                                'attribute' => $attribute_name,
                                'product'   => $product,
                                'class'     => 'size-selector-dropdown',
                                'show_option_none' => sprintf(__('Choose %s', 'woocommerce'), wc_attribute_label($attribute_name))
                            )
                        );
                        ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/size down arrow.png" class="size-selector-icon" alt="Size Selector">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php do_action('woocommerce_after_variations_select'); ?>

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
             * This outputs variation price, variation availability and add to cart button.
             */
            ?>
            <div class="woocommerce-variation single_variation"></div>
            
            <div class="woocommerce-variation-add-to-cart variations_button">
                <?php 
                /**
                 * Hook: woocommerce_before_add_to_cart_quantity.
                 */
                do_action('woocommerce_before_add_to_cart_quantity');
                
                woocommerce_quantity_input(
                    array(
                        'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                        'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                    )
                );
                
                /**
                 * Hook: woocommerce_after_add_to_cart_quantity.
                 */
                do_action('woocommerce_after_add_to_cart_quantity');
                ?>
                
                <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
                <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
                <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
                <input type="hidden" name="variation_id" class="variation_id" value="0" />
            </div>

            <?php
            /**
             * Hook: woocommerce_after_single_variation.
             */
            do_action('woocommerce_after_single_variation');
            ?>
        </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<script>
jQuery(document).ready(function($) {
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
            alert('Please select size before adding to cart.');
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

<style>
/* Variable Product Styling */
.variations-title {
    font-size: 18px;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Size selectors for variable products */
.variations select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #333;
    border-radius: 4px;
    background-color: #0f0f0f;
    color: #fff;
    font-size: 16px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.variations select:hover {
    background-color: #1a1a1a;
}

.variations select:focus {
    outline: none;
    border-color: #ff0000;
    box-shadow: 0 0 0 1px #ff0000;
}

.variations .value {
    position: relative;
}

.size-selector-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    width: 16px;
    height: auto;
    pointer-events: none;
    z-index: 1;
}

/* Error field styling */
.error-field {
    border: 2px solid #ff0000 !important;
    background-color: rgba(255, 0, 0, 0.1) !important;
}

/* Selected variation display */
.variation-price-display {
    margin: 15px 0;
}

.selected-variation {
    padding: 10px 15px;
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #ff0000;
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
    color: #fff;
}

.variations .label .required {
    color: #ff0000;
    margin-left: 5px;
}

/* Variable product add to cart button */
.single_add_to_cart_button {
    background-color: #000 !important;
    color: #fff !important;
    padding: 15px 30px !important;
    border: none !important;
    border-radius: 4px !important;
    text-transform: uppercase !important;
    font-weight: 600 !important;
    letter-spacing: 1px !important;
    width: 100% !important;
    margin-top: 20px !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
}

.single_add_to_cart_button:hover {
    background-color: #222 !important;
    transform: translateY(-2px) !important;
}

/* Quantity input styling */
.quantity {
    margin-bottom: 15px;
    width: 100%;
}

.quantity input {
    width: 100% !important;
    padding: 12px 15px !important;
    border: 1px solid #333 !important;
    border-radius: 4px !important;
    background-color: #0f0f0f !important;
    color: #fff !important;
    font-size: 16px !important;
}

/* Reset variations link */
.reset_variations {
    display: inline-block;
    margin-top: 10px;
    color: #aaa;
    font-size: 14px;
    text-decoration: none;
}

.reset_variations:hover {
    color: #ff0000;
    text-decoration: underline;
}

/* Responsive styling */
@media (max-width: 768px) {
    .variations select,
    .quantity input,
    .single_add_to_cart_button {
        font-size: 14px !important;
        padding: 10px 12px !important;
    }
}
</style>