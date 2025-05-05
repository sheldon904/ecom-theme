<?php
/**
 * Order received page - head content
 *
 * This file is included in the <head> section when viewing the order received page
 *
 * @package Lambo_Merch
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// This file can include additional meta tags, tracking scripts, or other head content
// specific to the order received page
?>

<!-- Additional meta tags for order received page -->
<meta name="robots" content="noindex, nofollow">

<!-- Optional: Add any order conversion tracking scripts here -->
<!-- Example:
<script>
    // Order tracking code
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({
        'event': 'purchase',
        'ecommerce': {
            'purchase': {
                'actionField': {
                    'id': '<?php echo isset($order) ? esc_js($order->get_order_number()) : ''; ?>',
                    'revenue': '<?php echo isset($order) ? esc_js($order->get_total()) : ''; ?>'
                }
            }
        }
    });
</script>
-->