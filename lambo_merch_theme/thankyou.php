<?php
/**
 * Thank You Page Template
 * 
 * This template is used for the order-received endpoint and shows detailed order information
 * 
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

// Add specific body class for styling
add_filter('body_class', function($classes) {
    $classes[] = 'lambo-order-received-page';
    return $classes;
});

// Enqueue order received styles
wp_enqueue_style('lambo-order-received', get_template_directory_uri() . '/css/order-received.css');

get_header();

// Get the order details
global $wp;

// Get order ID - simplified approach
$order_id = 0;

// Method 1: Check WooCommerce query vars first (most reliable)
if (isset($wp->query_vars['order-received'])) {
    $order_id = absint($wp->query_vars['order-received']);
}

// Method 2: If not available in query vars, check URL directly
if ($order_id === 0 && isset($_SERVER['REQUEST_URI'])) {
    // Extract from path component
    if (preg_match('#/order-received/(\d+)/?#', $_SERVER['REQUEST_URI'], $matches)) {
        $order_id = absint($matches[1]);
    }
}

// Method 3: Last resort - check GET parameters
if ($order_id === 0 && isset($_GET['order-received'])) {
    $order_id = absint($_GET['order-received']);
}

// Get the order key from the URL
$order_key = isset($_GET['key']) ? wc_clean(wp_unslash($_GET['key'])) : '';

// Get the order object
$order = false;
try {
    if ($order_id > 0) {
        $order = wc_get_order($order_id);
        
        // Verify order key for security (if we have an order key)
        if (!$order) {
            // Order not found, but don't throw an error
        } elseif (!empty($order_key) && $order->get_order_key() !== $order_key) {
            // Keys don't match, but don't throw an error
            $order = false;
        }
    }
} catch (Exception $e) {
    // Handle any exceptions gracefully
    $order = false;
}
}
?>

<main id="primary" class="site-main">
    <div class="woocommerce-order lambo-order-received">
        <?php
        if ($order) :
            do_action('woocommerce_before_thankyou', $order->get_id());
            ?>

            <?php if ($order->has_status('failed')) : ?>
                <div class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed alert alert-danger">
                    <p><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>
                </div>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
                    <?php endif; ?>
                </p>
            
            <?php else : ?>
                <!-- Success Header -->
                <div class="order-confirmation-header">
                    <div class="success-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="11" stroke="#4CAF50" stroke-width="2"/>
                            <path d="M7 12L10 15L17 8" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2 class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                        <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), $order); ?>
                    </h2>
                </div>
                
                <!-- Order Overview - Key information -->
                <div class="order-overview-container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                                <li class="woocommerce-order-overview__order order">
                                    <?php esc_html_e('Order number:', 'woocommerce'); ?>
                                    <strong><?php echo $order->get_order_number(); ?></strong>
                                </li>

                                <li class="woocommerce-order-overview__date date">
                                    <?php esc_html_e('Date:', 'woocommerce'); ?>
                                    <strong><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
                                </li>

                                <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                                    <li class="woocommerce-order-overview__email email">
                                        <?php esc_html_e('Email:', 'woocommerce'); ?>
                                        <strong><?php echo $order->get_billing_email(); ?></strong>
                                    </li>
                                <?php endif; ?>

                                <li class="woocommerce-order-overview__total total">
                                    <?php esc_html_e('Total:', 'woocommerce'); ?>
                                    <strong><?php echo $order->get_formatted_order_total(); ?></strong>
                                </li>

                                <?php if ($order->get_payment_method_title()) : ?>
                                    <li class="woocommerce-order-overview__payment-method method">
                                        <?php esc_html_e('Payment method:', 'woocommerce'); ?>
                                        <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Detailed Order Items Summary -->
                <div class="order-items-summary">
                    <h3><?php esc_html_e('Order Details', 'woocommerce'); ?></h3>
                    
                    <?php if ($order->get_items()) : ?>
                        <div class="items-grid">
                            <?php
                            foreach ($order->get_items() as $item_id => $item) {
                                $product = $item->get_product();
                                
                                // Get product data
                                $product_name = $item->get_name();
                                $quantity = $item->get_quantity();
                                $subtotal = $order->get_formatted_line_subtotal($item);
                                
                                // Get variation data if available
                                $variation_data = [];
                                if ($item->get_variation_id()) {
                                    foreach ($item->get_meta_data() as $meta) {
                                        if (strpos($meta->key, 'pa_') === 0 || strpos($meta->key, 'attribute_') === 0) {
                                            $variation_data[] = wc_attribute_label(str_replace('attribute_', '', $meta->key)) . ': ' . $meta->value;
                                        }
                                    }
                                }
                                
                                // Get product image
                                $thumbnail = $product ? $product->get_image(array(80, 80)) : '';
                                if (!$thumbnail && wc_placeholder_img_src()) {
                                    $thumbnail = wc_placeholder_img(array(80, 80));
                                }
                                ?>
                                <div class="order-item-card">
                                    <?php if ($thumbnail) : ?>
                                        <div class="item-thumbnail">
                                            <?php echo $thumbnail; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="item-details">
                                        <div class="item-name">
                                            <?php 
                                            echo esc_html($product_name);
                                            
                                            // Display variation details if available
                                            if (!empty($variation_data)) {
                                                echo '<div class="item-variation" style="font-size: 0.85em; color: #aaa; margin-top: 3px;">';
                                                echo esc_html(implode(', ', $variation_data));
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>
                                        
                                        <div class="item-meta">
                                            <span class="item-quantity">
                                                <?php echo sprintf(_n('%s item', '%s items', $quantity, 'woocommerce'), $quantity); ?>
                                            </span>
                                            <span class="item-price">
                                                <?php echo $subtotal; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Order Totals -->
                    <div class="order-totals">
                        <?php 
                        // Get all order totals
                        $order_totals = $order->get_order_item_totals();
                        
                        // Display each total
                        foreach ($order_totals as $key => $total) {
                            $is_grand_total = ($key === 'order_total');
                            ?>
                            <div class="totals-row <?php echo $is_grand_total ? 'grand-total' : ''; ?>">
                                <span class="totals-label"><?php echo esc_html($total['label']); ?></span>
                                <span class="totals-value"><?php echo wp_kses_post($total['value']); ?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <?php if ($order->get_customer_note()) : ?>
                    <div class="order-note-container" style="margin-bottom: 20px; background: #1a1a1a; padding: 20px; border-radius: 5px;">
                        <h3><?php esc_html_e('Order Notes', 'woocommerce'); ?></h3>
                        <p><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></p>
                    </div>
                <?php endif; ?>
                
                <!-- Customer Details Section (Billing and Shipping) -->
                <div class="customer-details-section">
                    <h3><?php esc_html_e('Customer Details', 'woocommerce'); ?></h3>
                    
                    <div class="customer-details-box">
                        <div class="customer-details-content">
                            <div class="row">
                                <!-- Billing Address -->
                                <div class="col-sm-12 col-md-6">
                                    <div class="address-section">
                                        <h4><?php esc_html_e('Billing Address', 'woocommerce'); ?></h4>
                                        <address>
                                            <?php 
                                            // Format the billing address
                                            $billing_address = $order->get_formatted_billing_address();
                                            echo wp_kses_post($billing_address ? $billing_address : esc_html__('N/A', 'woocommerce'));
                                            
                                            // Show billing phone
                                            if ($order->get_billing_phone()) : ?>
                                                <p class="woocommerce-customer-details--phone">
                                                    <?php esc_html_e('Phone:', 'woocommerce'); ?> 
                                                    <?php echo esc_html($order->get_billing_phone()); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <!-- Show billing email -->
                                            <?php if ($order->get_billing_email()) : ?>
                                                <p class="woocommerce-customer-details--email">
                                                    <?php esc_html_e('Email:', 'woocommerce'); ?> 
                                                    <?php echo esc_html($order->get_billing_email()); ?>
                                                </p>
                                            <?php endif; ?>
                                        </address>
                                    </div>
                                </div>
                                
                                <!-- Shipping Address -->
                                <div class="col-sm-12 col-md-6">
                                    <div class="address-section">
                                        <h4><?php esc_html_e('Shipping Address', 'woocommerce'); ?></h4>
                                        <address>
                                            <?php 
                                            // Check if shipping is different from billing
                                            if ($order->get_shipping_address_1() && $order->get_shipping_address_1() !== $order->get_billing_address_1()) {
                                                // Format the shipping address
                                                echo wp_kses_post($order->get_formatted_shipping_address());
                                            } else {
                                                echo esc_html__('Same as billing address', 'woocommerce');
                                            }
                                            ?>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Extra payment information (if applicable) -->
                <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
                
                <!-- Continue Shopping Button -->
                <div class="continue-shopping-container">
                    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button continue-shopping">
                        <?php esc_html_e('Continue Shopping', 'woocommerce'); ?>
                    </a>
                </div>
            <?php endif; ?>

        <?php else : ?>
            <!-- Fallback if order not found -->
            <div class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                <?php echo apply_filters('woocommerce_thankyou_order_received_text', esc_html__('Thank you. Your order has been received.', 'woocommerce'), null); ?>
                <p class="error-note"><?php esc_html_e('However, the order details could not be found. If you believe this is an error, please contact us with your order number.', 'woocommerce'); ?></p>
            </div>
            
            <div class="continue-shopping-container">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button continue-shopping">
                    <?php esc_html_e('Continue Shopping', 'woocommerce'); ?>
                </a>
            </div>
            
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>