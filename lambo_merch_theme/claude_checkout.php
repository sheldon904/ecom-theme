<?php
/**
 * Template Name: Custom Checkout Page
 *
 * A custom checkout template for the Lambo Merch theme.
 *
 * @package Lambo_Merch
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="checkout-title">Checkout</h1>
                
                <!-- Returning Customer Login Notice -->
                <div class="checkout-notice returning-customer">
                    <p>Returning Customer? <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="login-link">Click here to login</a></p>
                </div>
                
                <!-- Coupon Form -->
                <div class="checkout-coupon-form" style="display:none;">
                    <form class="checkout_coupon" method="post">
                        <div class="coupon-input-wrap">
                            <input type="text" name="coupon_code" class="input-text" placeholder="Coupon code" id="coupon_code" value="">
                            <button type="submit" class="button" name="apply_coupon" value="Apply coupon">Apply</button>
                        </div>
                    </form>
                </div>
                
                <div class="woocommerce-checkout-wrapper">
                    <?php
                    // Check if WooCommerce is active
                    if (class_exists('WooCommerce')) {
                        // Output any notices
                        wc_print_notices();
                        
                        // Check cart has contents
                        if (WC()->cart->is_empty() && !is_customize_preview()) {
                            echo '<p class="cart-empty">' . esc_html__('Your cart is currently empty.', 'lambo-merch') . '</p>';
                            do_action('woocommerce_cart_is_empty');
                        } else {
                            // Handle checkout actions
                            do_action('woocommerce_before_checkout_form', WC()->checkout());
                            
                            // Remove the checkout form actions we're replacing
                            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10);
                            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
                            
                            // Display checkout form
                            ?>
                            
                            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                                <div class="checkout-columns">
                                    <div class="billing-addresses-container">
                                        <div class="billing-shipping-column">
                                            <h3 class="billing-details-title">Billing Details</h3>
                                            
                                            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                                <div class="ship-to-different-address-checkbox">
                                                    <input id="ship-to-different-address" type="checkbox" name="ship_to_different_address" value="1" class="input-checkbox">
                                                    <label for="ship-to-different-address">Ship to a different address?</label>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="billing-fields-wrapper">
                                                <?php do_action('woocommerce_checkout_billing'); ?>
                                            </div>
                                            
                                            <div class="create-account-checkbox">
                                                <?php if (get_option('woocommerce_enable_signup_and_login_from_checkout') === 'yes' && !is_user_logged_in()) : ?>
                                                    <input id="createaccount" type="checkbox" name="createaccount" value="1" class="input-checkbox">
                                                    <label for="createaccount">Create an account?</label>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="order-notes">
                                                <label for="order_comments">Notes about your order</label>
                                                <textarea id="order_comments" name="order_comments" rows="4" placeholder="Special notes for delivery or product"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="shipping-address-column">
                                            <h3 class="shipping-details-title">Shipping Details</h3>
                                            <div class="shipping-fields-wrapper">
                                                <?php do_action('woocommerce_checkout_shipping'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="order-review-column">
                                        <h3 class="order-details-title">Your Order</h3>
                                        <div class="order-details-wrapper">
                                            <div class="order-review">
                                                <?php do_action('woocommerce_checkout_before_order_review'); ?>
                                                <?php do_action('woocommerce_checkout_order_review'); ?>
                                                <?php do_action('woocommerce_checkout_after_order_review'); ?>
                                            </div>
                                            
                                            <div class="payment-methods-custom">
                                                <h4>Payment Method</h4>
                                                <div class="payment-method-options">
                                                    <div class="payment-method">
                                                        <input type="radio" id="payment_credit_card" name="payment_method" value="credit_card" checked>
                                                        <label for="payment_credit_card">Credit Card</label>
                                                    </div>
                                                    <div class="payment-method">
                                                        <input type="radio" id="payment_paypal" name="payment_method" value="paypal">
                                                        <label for="payment_paypal">PayPal</label>
                                                    </div>
                                                    <div class="payment-method">
                                                        <input type="radio" id="payment_apple_pay" name="payment_method" value="apple_pay">
                                                        <label for="payment_apple_pay">Apple Pay</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <?php do_action('woocommerce_after_checkout_form', WC()->checkout());
                        }
                    } else {
                        echo '<p>WooCommerce is not active. Please activate WooCommerce to use this template.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    /* Custom Checkout Styles */
    .checkout-title {
        margin-bottom: 20px;
        font-size: 32px;
        font-family: Georgia, serif;
        font-style: italic;
    }
    
    .checkout-notice {
        background-color: #282828;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 3px;
    }
    
    .checkout-notice p {
        margin: 0;
        color: #fff;
    }
    
    .checkout-notice a {
        color: #fff;
        text-decoration: underline;
        font-weight: 600;
    }
    
    .checkout-coupon-form {
        background-color: #282828;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 3px;
    }
    
    .coupon-input-wrap {
        display: flex;
    }
    
    .coupon-input-wrap input {
        flex: 1;
        background-color: #282828;
        border: 1px solid #444;
        padding: 10px 15px;
        color: #fff;
        border-radius: 3px 0 0 3px;
    }
    
    .coupon-input-wrap button {
        background-color: #ff0000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 0 3px 3px 0;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .woocommerce-checkout-wrapper {
        margin-top: 40px;
    }
    
    .checkout-columns {
        display: flex;
        flex-direction: column;
        margin: 0 -15px;
    }
    
    .billing-addresses-container {
        display: flex;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .billing-shipping-column,
    .shipping-address-column {
        flex: 1;
        padding: 0 15px;
    }
    
    .shipping-address-column {
        opacity: 0.5;
        pointer-events: none;
        background-color: #f5f5f5;
        padding: 15px;
        border-radius: 5px;
    }
    
    .order-review-column {
        padding: 0 15px;
        margin-bottom: 30px;
        width: 100%;
    }
    
    .billing-details-title,
    .shipping-details-title,
    .order-details-title {
        margin-bottom: 20px;
        font-size: 24px;
        font-family: Georgia, serif;
        font-style: italic;
    }
    
    .order-details-wrapper {
        background-color: #282828;
        padding: 20px;
        border-radius: 3px;
    }
    
    /* Customize Form Fields */
    .woocommerce-billing-fields__field-wrapper,
    .woocommerce-shipping-fields__field-wrapper {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    
    .form-row {
        padding: 0 10px;
        margin-bottom: 15px;
    }
    
    .form-row-first,
    .form-row-last {
        width: 50%;
    }
    
    .form-row-wide {
        width: 100%;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    
    .woocommerce-input-wrapper input,
    .woocommerce-input-wrapper select,
    .woocommerce-input-wrapper textarea,
    .order-notes textarea {
        width: 100%;
        padding: 10px 15px;
        background-color: #282828;
        border: 1px solid #444;
        border-radius: 3px;
        color: #fff;
    }
    
    .order-notes {
        margin-top: 20px;
    }
    
    .order-notes textarea {
        height: 100px;
    }
    
    /* Custom Order Review Table */
    .woocommerce-checkout-review-order-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-image {
        width: 80px;
    }
    
    .product-image img {
        max-width: 100%;
        height: auto;
    }
    
    .product-name {
        padding-left: 15px;
        font-weight: 500;
        color: #fff;
    }
    
    .product-name .product-quantity,
    .product-name .product-unit-price {
        display: block;
        color: #aaa;
        font-size: 14px;
    }
    
    .product-total {
        text-align: right;
        font-weight: 600;
        color: #fff;
    }
    
    .cart-subtotal,
    .order-total,
    .shipping {
        text-align: right;
        color: #fff;
    }
    
    .cart-subtotal th,
    .order-total th,
    .shipping th {
        text-align: left;
        font-weight: 500;
    }
    
    .cart-subtotal td,
    .order-total td,
    .shipping td {
        font-weight: 600;
    }
    
    .order-total td {
        font-size: 18px;
        color: #ff0000;
    }
    
    /* Payment Methods */
    .payment-methods-custom {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #444;
    }
    
    .payment-methods-custom h4 {
        color: #fff;
        margin-bottom: 15px;
        font-size: 18px;
    }
    
    .payment-method {
        padding: 12px 0;
        border-bottom: 1px solid #444;
    }
    
    .payment-method label {
        color: #fff;
        font-weight: 500;
        margin-left: 10px;
    }
    
    .payment-method input[type="radio"] {
        margin-right: 5px;
    }
    
    #place_order {
        background-color: #ff0000;
        color: #fff;
        border: none;
        padding: 15px 30px;
        width: 100%;
        text-transform: uppercase;
        font-weight: 600;
        font-size: 16px;
        border-radius: 3px;
        cursor: pointer;
        margin-top: 20px;
    }
    
    #place_order:hover {
        background-color: #cc0000;
    }
    
    .ship-to-different-address-checkbox,
    .create-account-checkbox {
        margin: 15px 0;
    }
    
    .input-checkbox {
        margin-right: 8px;
    }
    
    /* Order Review Section */
    .shop_table.woocommerce-checkout-review-order-table .cart_item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #444;
    }
    
    .product-info {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .woocommerce-checkout-review-order-table .cart_item {
        display: grid;
        grid-template-columns: 80px 1fr auto;
        gap: 15px;
        align-items: center;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #444;
    }
    
    /* Hide the save payment information checkbox and privacy policy text */
    .woocommerce-SavedPaymentMethods-saveNew,
    .woocommerce-privacy-policy-text {
        display: none !important;
    }
    
    /* Responsive Styles */
    @media (max-width: 991px) {
        .billing-addresses-container {
            flex-direction: column;
        }
        
        .billing-shipping-column,
        .shipping-address-column {
            width: 100%;
            margin-bottom: 30px;
        }
    }
    
    @media (max-width: 768px) {
        .form-row-first,
        .form-row-last {
            width: 100%;
        }
    }
</style>

<script>
jQuery(document).ready(function($) {
    // Toggle coupon form
    $('.showcoupon').on('click', function(e) {
        e.preventDefault();
        $('.checkout-coupon-form').slideToggle();
    });
    
    // Toggle shipping address
    $('#ship-to-different-address').on('change', function() {
        if ($(this).is(':checked')) {
            $('.shipping-address-column').css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        } else {
            $('.shipping-address-column').css({
                'opacity': '0.5',
                'pointer-events': 'none'
            });
        }
    });
    
    // Custom product display in order review
    function customizeOrderReview() {
        $('.woocommerce-checkout-review-order-table .cart_item').each(function() {
            // Skip if already customized
            if ($(this).hasClass('customized')) return;
            
            var productImg = $(this).find('img');
            var productName = $(this).find('.product-name').text().trim();
            var productTotal = $(this).find('.product-total').html();
            var qty = productName.match(/× (\d+)/);
            var quantity = qty ? qty[1] : 1;
            var cleanProductName = productName.replace(/× \d+/, '').trim();
            
            // Calculate unit price
            var totalPrice = productTotal.replace(/[^0-9.,]/g, '');
            var unitPrice = parseFloat(totalPrice.replace(',', '.')) / quantity;
            
            // Format unit price
            var unitPriceFormatted = '$' + unitPrice.toFixed(2);
            
            // Limit product name length
            if (cleanProductName.length > 25) {
                cleanProductName = cleanProductName.substring(0, 25) + '...';
            }
            
            // Rebuild the cart item with custom layout
            $(this).html('');
            $(this).append('<div class="product-image">' + (productImg.length ? productImg.prop('outerHTML') : '<img src="<?php echo get_template_directory_uri(); ?>/images/products/placeholder.png" alt="Product">') + '</div>');
            $(this).append('<div class="product-name">' + cleanProductName + 
                '<span class="product-quantity">Quantity: ' + quantity + '</span>' +
                '<span class="product-unit-price">Unit Price: ' + unitPriceFormatted + '</span>' +
                '</div>');
            $(this).append('<div class="product-total">' + productTotal + '</div>');
            
            // Mark as customized
            $(this).addClass('customized');
        });
    }
    
    // Run on page load
    customizeOrderReview();
    
    // Run when checkout is updated
    $(document.body).on('updated_checkout', function() {
        customizeOrderReview();
        
        // Hide save payment info checkbox and privacy policy text
        $('.woocommerce-SavedPaymentMethods-saveNew').hide();
        $('.woocommerce-privacy-policy-text').hide();
    });
});
</script>

<?php get_footer(); ?>