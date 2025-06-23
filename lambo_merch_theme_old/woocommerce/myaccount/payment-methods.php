<?php
/**
 * Payment Methods
 *
 * Custom payment methods template for Lambo Merch.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types();

do_action( 'woocommerce_before_account_payment_methods', $has_methods ); ?>

<?php if ( $has_methods ) : ?>

    <h2><?php esc_html_e( 'Payment Methods', 'woocommerce' ); ?></h2>

    <div class="payment-methods-list">
        <?php foreach ( $saved_methods as $type => $methods ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
            <?php foreach ( $methods as $method ) : ?>
                <div class="woocommerce-PaymentMethod payment-method-<?php echo esc_attr( $method['method']['id'] ); ?>">
                    <div class="payment-method-info">
                        <?php if ( ! empty( $method['method']['last4'] ) ) : ?>
                            <span class="payment-method-brand">
                                <?php echo esc_html( $method['method']['brand'] ); ?> 
                                <?php esc_html_e( 'ending in', 'woocommerce' ); ?> 
                                <?php echo esc_html( $method['method']['last4'] ); ?>
                            </span>
                            <?php if ( ! empty( $method['expires'] ) ) : ?>
                                <span class="payment-method-expiry">
                                    <?php esc_html_e( 'Expires', 'woocommerce' ); ?> 
                                    <?php echo esc_html( $method['expires'] ); ?>
                                </span>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php echo esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="payment-method-actions">
                        <?php foreach ( $method['actions'] as $key => $action ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                            <?php if ( $key === 'delete' ) : ?>
                                <a href="<?php echo esc_url( $action['url'] ); ?>" class="delete-method" title="<?php echo esc_attr( $action['name'] ); ?>">
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/trash can icon.png' ); ?>" alt="<?php echo esc_attr( $action['name'] ); ?>" />
                                </a>
                            <?php elseif ( $key !== 'default' ) : ?>
                                <a href="<?php echo esc_url( $action['url'] ); ?>" class="button <?php echo sanitize_html_class( $key ); ?>"><?php echo esc_html( $action['name'] ); ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>

<?php else : ?>
    <div class="no-payment-methods">
        <p><?php esc_html_e( 'No saved payment methods found.', 'woocommerce' ); ?></p>
    </div>
<?php endif; ?>

<?php if ( WC()->payment_gateways->get_available_payment_gateways() ) : ?>
    <div class="add-payment-method">
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>" class="button add-payment-method-button">
            <?php esc_html_e( 'Add Payment Method', 'woocommerce' ); ?>
        </a>
    </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_payment_methods', $has_methods ); ?>