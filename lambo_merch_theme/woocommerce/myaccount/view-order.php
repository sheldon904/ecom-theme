<?php
/**
 * View Order
 *
 * Custom view order template for Lambo Merch.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>

<h2><?php
    /* translators: 1: order number 2: order date 3: order status */
    printf(
        esc_html__( 'Order #%1$s', 'woocommerce' ),
        $order->get_order_number()
    );
?></h2>

<div class="order-info">
    <p>
        <?php
        printf(
            /* translators: 1: order date 2: order status */
            esc_html__( 'Placed on %1$s, Status: %2$s', 'woocommerce' ),
            '<strong>' . wc_format_datetime( $order->get_date_created() ) . '</strong>',
            '<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
        );
        ?>
    </p>
</div>

<?php if ( $notes ) : ?>
    <h3><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h3>
    <ol class="woocommerce-OrderUpdates">
        <?php foreach ( $notes as $note ) : ?>
            <li class="woocommerce-OrderUpdate">
                <div class="woocommerce-OrderUpdate-inner">
                    <div class="woocommerce-OrderUpdate-description">
                        <?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                    <p class="woocommerce-OrderUpdate-meta">
                        <?php echo esc_html( date_i18n( 'F j, Y', strtotime( $note->comment_date ) ) ); ?>
                    </p>
                </div>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>