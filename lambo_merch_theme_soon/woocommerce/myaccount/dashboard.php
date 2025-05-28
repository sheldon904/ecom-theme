<?php
/**
 * My Account Dashboard
 *
 * Custom dashboard template for Lambo Merch.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="account-dashboard">
    <p><?php
        /* translators: 1: user display name 2: logout url */
        printf(
            __( 'Hello <strong>%1$s</strong>', 'woocommerce' ),
            esc_html( $current_user->display_name )
        );
    ?></p>

    <div class="account-info">
        <p><em><strong><?php esc_html_e( 'Account Information', 'woocommerce' ); ?></strong></em></p>
        <p>
            <em><strong><?php esc_html_e( 'Username:', 'woocommerce' ); ?></strong></em> 
            <?php echo esc_html( $current_user->user_login ); ?>
        </p>
        <p>
            <em><strong><?php esc_html_e( 'Email:', 'woocommerce' ); ?></strong></em> 
            <?php echo esc_html( $current_user->user_email ); ?>
        </p>
    </div>

    <div class="account-actions">
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="woocommerce-Button button">
            <?php esc_html_e( 'Edit Your Information', 'woocommerce' ); ?>
        </a>
        <a class="woocommerce-Button button" href="<?php echo esc_url( wc_logout_url() ); ?>">
            <?php esc_html_e( 'Log Out', 'woocommerce' ); ?>
        </a>
    </div>

    <?php
        /**
         * My Account dashboard.
         *
         * @since 2.6.0
         */
        do_action( 'woocommerce_account_dashboard' );

        /**
         * Deprecated woocommerce_before_my_account action.
         *
         * @deprecated 2.6.0
         */
        do_action( 'woocommerce_before_my_account' );

        /**
         * Deprecated woocommerce_after_my_account action.
         *
         * @deprecated 2.6.0
         */
        do_action( 'woocommerce_after_my_account' );
    ?>
</div>