<?php
/**
 * Add payment method form
 *
 * Custom add payment method form for Lambo Merch.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

if ( $available_gateways ) : ?>
    <h2><?php esc_html_e( 'Add Payment Method', 'woocommerce' ); ?></h2>

    <form id="add_payment_method" method="post">
        <div id="payment" class="woocommerce-Payment">
            <ul class="woocommerce-PaymentMethods payment_methods methods">
                <?php
                // Chosen Method.
                if ( count( $available_gateways ) ) {
                    current( $available_gateways )->set_current();
                }

                foreach ( $available_gateways as $gateway ) {
                    ?>
                    <li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $gateway->id ); ?> payment_method_<?php echo esc_attr( $gateway->id ); ?>">
                        <div class="payment-method-option">
                            <input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
                            <label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( $gateway->get_title() ); ?></label>
                            <?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
                                <div class="payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
                                    <?php $gateway->payment_fields(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>

            <?php do_action( 'woocommerce_add_payment_method_form_bottom' ); ?>

            <div class="form-row">
                <?php wp_nonce_field( 'woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce' ); ?>
                <button type="submit" class="woocommerce-Button woocommerce-Button--alt button alt" id="place_order" value="<?php esc_attr_e( 'Add payment method', 'woocommerce' ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></button>
                <input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
            </div>
        </div>
    </form>
<?php else : ?>
    <p class="woocommerce-notice woocommerce-notice--info woocommerce-info"><?php esc_html_e( 'Sorry, it seems that there are no payment methods which support adding a new payment method. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ); ?></p>
<?php endif; ?>