<?php
/**
 * My Addresses
 *
 * Custom my addresses template for Lambo Merch.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing'  => __( 'Billing address', 'woocommerce' ),
            'shipping' => __( 'Shipping address', 'woocommerce' ),
        ),
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing' => __( 'Billing address', 'woocommerce' ),
        ),
        $customer_id
    );
}

$oldcol = 1;
$col    = 1;
?>

<h2><?php esc_html_e( 'Addresses', 'woocommerce' ); ?></h2>

<p>
    <?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
    <div class="woocommerce-Addresses addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
    <?php
        $address = wc_get_account_formatted_address( $name );
        $col     = $col * -1;
        $oldcol  = $oldcol * -1;
    ?>

    <div class="woocommerce-Address">
        <header class="woocommerce-Address-title title">
            <h3><?php echo esc_html( $address_title ); ?></h3>
            <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php echo esc_html__( 'Edit', 'woocommerce' ); ?></a>
        </header>
        <address>
            <?php
                echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );
            ?>
        </address>
    </div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
    </div>
<?php endif; ?>