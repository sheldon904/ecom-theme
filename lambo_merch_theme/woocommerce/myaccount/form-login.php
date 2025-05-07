<?php
/**
 * Login Form
 *
 * Custom login form for Lambo Merch theme.
 *
 * @package Lambo_Merch
 */

defined( 'ABSPATH' ) || exit;

?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="u-columns col2-set" id="customer_login">
    <?php // Output WooCommerce notices at top of form container ?>
    <?php wc_print_notices(); ?>
    <div class="u-column1 col-1">

<?php else: ?>

<div id="customer_login">
    <?php wc_print_notices(); ?>

<?php endif; ?>

        <?php do_action( 'woocommerce_before_customer_login_form' ); ?>
        <h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

        <form class="woocommerce-form woocommerce-form-login login" method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <span class="password-input">
                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                </span>
                <div class="password-toggle">
                    <label for="show_login_password" class="password-toggle-label">
                        <input type="checkbox" id="show_login_password" class="show-password-checkbox" />
                        <?php esc_html_e( 'Show password', 'woocommerce' ); ?>
                    </label>
                </div>
            </p>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <p class="form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                </label>
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
            </p>
            <p class="woocommerce-LostPassword lost_password">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
            </p>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

    </div>

    <div class="u-column2 col-2">

        <h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

        <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>

            <?php endif; ?>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                    <span class="password-input">
                        <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                    </span>
                    <div class="password-toggle">
                        <label for="show_reg_password" class="password-toggle-label">
                            <input type="checkbox" id="show_reg_password" class="show-password-checkbox" />
                            <?php esc_html_e( 'Show password', 'woocommerce' ); ?>
                        </label>
                    </div>
                </p>

            <?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <p class="woocommerce-form-row form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
            </p>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>

    </div>

</div>
<?php else: ?>
</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

<style>
/* Notices styling for error messages */
.woocommerce-error {
    margin: 0 0 20px 0 !important;
    padding: 15px 20px !important;
    background-color: rgba(220, 50, 50, 0.8) !important;
    color: #ffffff !important;
    list-style: none !important;
    border-radius: 3px !important;
    font-weight: 500 !important;
    text-align: center !important;
    width: 100% !important;
    display: block !important;
    clear: both !important;
}

/* Position error messages correctly */
.woocommerce-MyAccount-content .woocommerce-error,
.woocommerce-account .woocommerce-error {
    margin-bottom: 30px !important;
    position: relative !important;
    top: auto !important;
    left: auto !important;
    z-index: 10 !important;
}

/* Specifically target error messages in the login form */
#customer_login .woocommerce-error {
    width: 100% !important;
    margin-bottom: 30px !important;
    float: none !important;
}

/* Login form styling */
#customer_login {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 30px !important;
    width: 100% !important;
    margin-top: 30px !important;
}

#customer_login .u-column1,
#customer_login .u-column2 {
    flex: 1 !important;
    min-width: 300px !important;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    #customer_login {
        flex-direction: column !important;
    }
    
    #customer_login .u-column1,
    #customer_login .u-column2 {
        width: 100% !important;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Make sure error notices display properly
    function moveErrorNotices() {
        if ($('.woocommerce-error').length > 0) {
            // Ensure error messages are visible with good spacing
            $('.woocommerce-error').css({
                'display': 'block',
                'width': '100%',
                'margin-top': '0',
                'margin-bottom': '30px',
                'clear': 'both'
            });
            
            // Make sure error messages are visible
            $('.woocommerce-error').show();
        }
    }
    
    // Run on page load
    moveErrorNotices();
    
    // Show/hide password functionality
    $('.show-password-checkbox').change(function() {
        var passwordField = $(this).closest('.woocommerce-form-row').find('input[type="password"]');
        if ($(this).is(':checked')) {
            passwordField.attr('type', 'text');
        } else {
            passwordField.attr('type', 'password');
        }
    });
});
</script>