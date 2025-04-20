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
        }
    }
    
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'lambo_merch_woocommerce_checkout_fields' );

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
function lambo_merch_woocommerce_product_message() {
    echo '<div class="exclusive-product-notice">';
    echo '<p>' . esc_html__( 'Limited edition - Don\'t miss out!', 'lambo-merch' ) . '</p>';
    echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'lambo_merch_woocommerce_product_message', 25 );

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