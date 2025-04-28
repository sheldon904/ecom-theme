<?php
/**
 * Thankyou page - Extra head content
 *
 * This template adds extra styling to the head for order-received page
 *
 */

defined( 'ABSPATH' ) || exit;
?>
<style>
/* Ensure black background for the order received page */
body.woocommerce-checkout.woocommerce-order-received,
body.woocommerce-checkout.woocommerce-order-received #page,
body.woocommerce-checkout.woocommerce-order-received #content,
body.woocommerce-checkout.woocommerce-order-received .entry-content,
body.woocommerce-checkout.woocommerce-order-received .site-content,
body.woocommerce-checkout.woocommerce-order-received .woocommerce {
    background-color: #000 !important;
    color: #fff !important;
}

/* Override any themes that might set background to white */
.woocommerce-order.lambo-order-received * {
    background-color: transparent;
}

.woocommerce-order.lambo-order-received {
    background-color: #000 !important;
}

.woocommerce-order.lambo-order-received .woocommerce-thankyou-order-received,
.woocommerce-order.lambo-order-received h1,
.woocommerce-order.lambo-order-received h2,
.woocommerce-order.lambo-order-received h3,
.woocommerce-order.lambo-order-received h4 {
    color: #fff !important;
}
</style>
<?php