<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Lambo_Merch
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 *
 * @return void
 */
function lambo_merch_woocommerce_setup() {
    // Add theme support for WooCommerce
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'lambo_merch_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function lambo_merch_woocommerce_scripts() {
    wp_enqueue_style( 'lambo-merch-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.css', array(), LAMBO_MERCH_VERSION );

    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';

    wp_add_inline_style( 'lambo-merch-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'lambo_merch_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function lambo_merch_woocommerce_active_body_class( $classes ) {
    $classes[] = 'woocommerce-active';

    return $classes;
}
add_filter( 'body_class', 'lambo_merch_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function lambo_merch_woocommerce_related_products_args( $args ) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args( $defaults, $args );

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'lambo_merch_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'lambo_merch_woocommerce_wrapper_before' ) ) {
    /**
     * Before Content.
     *
     * Wraps all WooCommerce content in wrappers which match the theme markup.
     *
     * @return void
     */
    function lambo_merch_woocommerce_wrapper_before() {
        ?>
        <main id="primary" class="site-main">
        <?php
    }
}
add_action( 'woocommerce_before_main_content', 'lambo_merch_woocommerce_wrapper_before' );

if ( ! function_exists( 'lambo_merch_woocommerce_wrapper_after' ) ) {
    /**
     * After Content.
     *
     * Closes the wrapping divs.
     *
     * @return void
     */
    function lambo_merch_woocommerce_wrapper_after() {
        ?>
        </main><!-- #main -->
        <?php
    }
}
add_action( 'woocommerce_after_main_content', 'lambo_merch_woocommerce_wrapper_after' );

/**
 * Change number of products displayed per page.
 */
function lambo_merch_woocommerce_products_per_page() {
    return 12;
}
add_filter( 'loop_shop_per_page', 'lambo_merch_woocommerce_products_per_page' );

/**
 * Add custom classes to products.
 */
function lambo_merch_woocommerce_product_class( $classes, $class, $product_id = null ) {
    $classes[] = 'product-card';
    return $classes;
}
add_filter( 'woocommerce_post_class', 'lambo_merch_woocommerce_product_class', 10, 3 );

/**
 * Custom product thumbnail size.
 */
function lambo_merch_woocommerce_image_dimensions() {
    global $pagenow;
    
    if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
        return;
    }
    
    // Set default product image dimensions
    update_option( 'woocommerce_single_image_width', 600 );
    update_option( 'woocommerce_thumbnail_image_width', 400 );
    update_option( 'woocommerce_thumbnail_cropping', 'custom' );
    update_option( 'woocommerce_thumbnail_cropping_custom_width', 4 );
    update_option( 'woocommerce_thumbnail_cropping_custom_height', 4 );
}
add_action( 'after_switch_theme', 'lambo_merch_woocommerce_image_dimensions', 1 );

/**
 * Customize WooCommerce checkout fields.
 */
function lambo_merch_woocommerce_checkout_fields( $fields ) {
    // Make all fields look better with Bootstrap classes
    foreach ( $fields as &$fieldset ) {
        foreach ( $fieldset as &$field ) {
            // Add form-control class to all fields
            $field['input_class'][] = 'form-control';
            
            // Add form-group class to field container
            $field['class'][] = 'form-group';
            
            // Add custom styling for Lambo Merch theme
            $field['input_class'][] = 'lambo-merch-input';
            
            // Increase font size and padding for better readability
            $field['input_class'][] = 'lambo-checkout-field';
            
            // Optional: Change placeholder text
            if (isset($field['placeholder'])) {
                $field['placeholder'] = 'Enter ' . strtolower($field['label']);
            }
        }
    }
    
    return $fields;
}

/**
 * Remove Express Checkout options
 */
function lambo_merch_remove_checkout_elements() {
    // Remove Express Checkout
    remove_action('woocommerce_checkout_before_customer_details', 'wc_checkout_express_payment');
    
    // Remove Coupon form from the standard position
    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
    
    // Also remove via filter for versions that use block checkout
    add_filter('wc_get_template', function($template, $template_name, $args, $template_path, $default_path) {
        // Remove express payment template
        if ($template_name == 'checkout/express-payment.php' || 
            $template_name == 'checkout/payment-method.php' && isset($args['gateway_id']) && strpos($args['gateway_id'], 'express') !== false) {
            return '';
        }
        return $template;
    }, 10, 5);
    
    // Remove coupon block
    add_filter('woocommerce_checkout_coupon_message', function() {
        return '';
    });
}
add_action('init', 'lambo_merch_remove_checkout_elements');

/**
 * Disable Express Payment Methods
 */
function lambo_merch_disable_express_payment() {
    return false;
}
add_filter('woocommerce_should_load_express_payment', 'lambo_merch_disable_express_payment');
add_filter('woocommerce_available_payment_gateways', function($gateways) {
    // Remove any payment methods except Stripe
    foreach ($gateways as $key => $gateway) {
        // Keep only the Stripe gateway, remove all others
        if ($key !== 'stripe') {
            unset($gateways[$key]);
        }
    }
    return $gateways;
}, 100);

/**
 * Configure Stripe as the only payment method
 */
function lambo_merch_stripe_only() {
    // Only run if WooCommerce Stripe Gateway is active
    if (class_exists('WC_Stripe_Payment_Gateway')) {
        // Set Stripe as default
        update_option('woocommerce_default_gateway', 'stripe');
    }
}
add_action('init', 'lambo_merch_stripe_only');
add_filter( 'woocommerce_checkout_fields', 'lambo_merch_woocommerce_checkout_fields' );

/**
 * Make sure shipping address is properly handled during checkout
 */
function lambo_merch_handle_shipping_address( $order_id ) {
    // Get the order
    $order = wc_get_order( $order_id );
    
    // Check if "ship to different address" was checked
    if ( isset( $_POST['ship_to_different_address'] ) && $_POST['ship_to_different_address'] == 1 ) {
        // Make sure the shipping address fields are correctly saved
        // This is necessary because sometimes WooCommerce doesn't properly save shipping fields
        if (isset($_POST['shipping_first_name'])) $order->set_shipping_first_name(sanitize_text_field($_POST['shipping_first_name']));
        if (isset($_POST['shipping_last_name'])) $order->set_shipping_last_name(sanitize_text_field($_POST['shipping_last_name']));
        if (isset($_POST['shipping_company'])) $order->set_shipping_company(sanitize_text_field($_POST['shipping_company']));
        if (isset($_POST['shipping_address_1'])) $order->set_shipping_address_1(sanitize_text_field($_POST['shipping_address_1']));
        if (isset($_POST['shipping_address_2'])) $order->set_shipping_address_2(sanitize_text_field($_POST['shipping_address_2']));
        if (isset($_POST['shipping_city'])) $order->set_shipping_city(sanitize_text_field($_POST['shipping_city']));
        if (isset($_POST['shipping_state'])) $order->set_shipping_state(sanitize_text_field($_POST['shipping_state']));
        if (isset($_POST['shipping_postcode'])) $order->set_shipping_postcode(sanitize_text_field($_POST['shipping_postcode']));
        if (isset($_POST['shipping_country'])) $order->set_shipping_country(sanitize_text_field($_POST['shipping_country']));
        
        // Save the updated order
        $order->save();
        return;
    }
    
    // If ship to different address is not checked, copy billing to shipping
    
    // Get billing address
    $billing_address = array(
        'first_name' => $order->get_billing_first_name(),
        'last_name'  => $order->get_billing_last_name(),
        'company'    => $order->get_billing_company(),
        'address_1'  => $order->get_billing_address_1(),
        'address_2'  => $order->get_billing_address_2(),
        'city'       => $order->get_billing_city(),
        'state'      => $order->get_billing_state(),
        'postcode'   => $order->get_billing_postcode(),
        'country'    => $order->get_billing_country()
    );
    
    // Set shipping address same as billing (regardless of what's in shipping fields)
    $order->set_shipping_first_name( $billing_address['first_name'] );
    $order->set_shipping_last_name( $billing_address['last_name'] );
    $order->set_shipping_company( $billing_address['company'] );
    $order->set_shipping_address_1( $billing_address['address_1'] );
    $order->set_shipping_address_2( $billing_address['address_2'] );
    $order->set_shipping_city( $billing_address['city'] );
    $order->set_shipping_state( $billing_address['state'] );
    $order->set_shipping_postcode( $billing_address['postcode'] );
    $order->set_shipping_country( $billing_address['country'] );
    
    // Save the order
    $order->save();
}

/**
 * Process checkout fields before order creation to copy billing to shipping
 * when "Ship to different address" is not checked
 */
function lambo_merch_process_checkout_fields( $data ) {
    // Check if "ship to different address" checkbox is not checked or not set
    if ( ! isset( $data['ship_to_different_address'] ) || $data['ship_to_different_address'] == 0 ) {
        // Copy billing fields to shipping fields
        $data['shipping_first_name'] = $data['billing_first_name'];
        $data['shipping_last_name'] = $data['billing_last_name'];
        $data['shipping_company'] = isset($data['billing_company']) ? $data['billing_company'] : '';
        $data['shipping_address_1'] = $data['billing_address_1'];
        $data['shipping_address_2'] = isset($data['billing_address_2']) ? $data['billing_address_2'] : '';
        $data['shipping_city'] = $data['billing_city'];
        $data['shipping_state'] = $data['billing_state'];
        $data['shipping_postcode'] = $data['billing_postcode'];
        $data['shipping_country'] = $data['billing_country'];
    }
    
    return $data;
}

/**
 * Ensure proper redirect to thank you page
 */
function lambo_merch_checkout_redirect( $order_id ) {
    // Make sure order exists
    if ( $order_id ) {
        $order = wc_get_order( $order_id );
        
        if ( $order ) {
            // Get the thank you page URL from WooCommerce
            $redirect_url = $order->get_checkout_order_received_url();
            
            // Set cookie to indicate we're coming from checkout
            setcookie( 'lambo_checkout_completed', '1', time() + 3600, '/' );
            
            // Force redirect to thank you page
            if ( ! is_ajax() ) {
                wp_safe_redirect( $redirect_url );
                exit;
            } else {
                // For AJAX requests, return the URL for client-side redirect
                return array(
                    'result'   => 'success',
                    'redirect' => $redirect_url,
                );
            }
        }
    }
}
add_action( 'woocommerce_thankyou', 'lambo_merch_checkout_redirect', 5, 1 );
add_action( 'woocommerce_checkout_update_order_meta', 'lambo_merch_handle_shipping_address', 10, 1 );
add_filter( 'woocommerce_checkout_posted_data', 'lambo_merch_process_checkout_fields', 10, 1 );

/**
 * Customize WooCommerce checkout button.
 */
function lambo_merch_woocommerce_checkout_button() {
    ?>
    <style>
        #place_order {
            background-color: #ff0000;
            color: #fff;
            font-weight: 700;
            text-transform: uppercase;
            padding: 15px 30px;
            transition: background-color 0.3s ease;
        }
        
        #place_order:hover {
            background-color: #cc0000;
        }
    </style>
    <?php
}
add_action( 'woocommerce_review_order_before_submit', 'lambo_merch_woocommerce_checkout_button' );

/**
 * Add mini cart AJAX update
 */
function lambo_merch_woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['span.cart-count'] = ob_get_clean();
    
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'lambo_merch_woocommerce_header_add_to_cart_fragment' );

/**
 * Custom product tabs
 */
function lambo_merch_woocommerce_product_tabs( $tabs ) {
    // Rename the description tab
    $tabs['description']['title'] = __( 'Product Details', 'lambo-merch' );
    
    // Rename the additional information tab
    $tabs['additional_information']['title'] = __( 'Specifications', 'lambo-merch' );
    
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'lambo_merch_woocommerce_product_tabs' );

/**
 * Add custom message to single product page
 */

/**
 * Set a flag when a variable product page is being displayed
 * DISABLED - using unified template approach instead
 */
// function lambo_merch_is_variable_product() {
//     global $product;
//     
//     if (is_product() && is_object($product) && $product->is_type('variable')) {
//         // Set a flag that we're on a variable product page
//         set_query_var('is_variable_product', true);
//     }
// }
// add_action('wp', 'lambo_merch_is_variable_product');

/**
 * Handle custom template for variable products
 * DISABLED - using unified template approach instead
 */
// function lambo_merch_variable_product_template_include($template) {
//     // Only run on single product pages
//     if (!is_product()) {
//         return $template;
//     }
//     
//     // Check if we have a variable product
//     global $product;
//     if (!is_object($product)) {
//         global $post;
//         $product = wc_get_product($post->ID);
//     }
//     
//     // Redirect to our custom template
//     if (is_object($product) && $product->is_type('variable')) {
//         $variable_template = get_template_directory() . '/woocommerce/variable-product.php';
//         
//         if (file_exists($variable_template)) {
//             return $variable_template;
//         }
//     }
//     
//     return $template;
// }
// add_filter('template_include', 'lambo_merch_variable_product_template_include', 9999);

/**
 * Ensure proper hooks are loaded for variable products
 * DISABLED - using unified template approach instead
 */
// function lambo_merch_ensure_variation_hooks() {
//     // DO NOT add this hook - it creates an infinite recursion!
//     // if (!has_action('woocommerce_before_variations_form')) {
//     //     add_action('woocommerce_before_variations_form', 'woocommerce_template_single_add_to_cart', 10);
//     // }
//     
//     // Make sure these hooks are properly set up
//     if (!has_action('woocommerce_single_variation')) {
//         add_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
//         add_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
//     }
// }
// add_action('template_redirect', 'lambo_merch_ensure_variation_hooks');