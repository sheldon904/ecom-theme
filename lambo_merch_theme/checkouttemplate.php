<?php
/**
 * Template Name: Checkout Template
 * Description: Merged custom checkout page template for Lambo Merch.
 */
defined( 'ABSPATH' ) || exit;

get_header();

// Clear notices and get the checkout object
wc_clear_notices();
$checkout = WC()->checkout;
?>
<style>
/* Checkout Page Styles */
#primary.site-main {
  color: #ffffff;
}
.checkout-heading {
  color: #ff0000;
  font-style: italic;
  margin-bottom: 1.5rem;
  font-size: 2rem;
}
.checkout-info-box {
  background-color: #333333;
  padding: 15px;
  margin-bottom: 15px;
  width: 100%;
  color: #ffffff;
}
.checkout-link {
  color: #ffffff;
  text-decoration: underline;
  cursor: pointer;
}
.coupon-form {
  display: none;
  background-color: #222222;
  padding: 15px;
  margin-bottom: 15px;
  width: 100%;
}
.billing-details {
  margin-top: 30px;
  margin-bottom: 20px;
}
.billing-form {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}
.billing-column,
.shipping-column {
  flex: 1;
  min-width: 300px;
}
.form-row {
  margin-bottom: 15px;
}
.form-row input[type="text"],
.form-row input[type="email"],
.form-row input[type="tel"],
.form-row select,
.form-row textarea {
  width: 100%;
  padding: 12px;
  background-color: #333333;
  border: 1px solid #444444;
  color: #ffffff;
}
.checkbox-row {
  margin: 15px 0;
  display: flex;
  align-items: center;
}
.checkbox-row input[type="checkbox"] {
  margin-right: 10px;
}
.order-summary {
  margin-top: 30px;
  background-color: #222222;
  padding: 20px;
}
.order-item {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px solid #333333;
}
.order-item-image {
  width: 60px;
  height: 60px;
  margin-right: 15px;
}
.order-item-details {
  flex: 1;
}
.order-item-name {
  font-weight: bold;
  color: #ffffff;
}
.order-item-price {
  color: #ffffff;
}
.order-item-quantity {
  width: 60px;
  text-align: center;
  margin: 0 15px;
}
.order-item-total {
  color: #ffffff;
  font-weight: bold;
  width: 80px;
  text-align: right;
}
.order-totals {
  margin-top: 20px;
}
.order-total-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}
.order-total-label {
  color: #ffffff;
}
.order-total-value {
  color: #ffffff;
  font-weight: bold;
}
.payment-methods {
  margin-top: 30px;
}
/* Make Stripe section gray */
.payment_method_stripe,
.payment_method_stripe .payment_box {
  background-color: #333333 !important;
  padding: 15px;
  border-radius: 4px;
}
/* Place Order button override */
.place-order-button {
  background-color: #ff0000;
  color: #ffffff;
  padding: 15px 30px;
  border: none;
  text-transform: uppercase;
  font-weight: bold;
  margin-top: 20px;
  cursor: pointer;
  width: 100%;
}
@media (max-width: 767px) {
  .billing-form {
    flex-direction: column;
  }
  .billing-column,
  .shipping-column {
    width: 100%;
  }
  .order-item {
    flex-wrap: wrap;
  }
  .order-item-quantity,
  .order-item-total {
    margin-top: 10px;
  }
}
</style>

<main id="primary" class="site-main" style="max-width:1200px; margin:0 auto; padding:2rem;">
  <?php
    // Hook in notices, coupon form, etc.
    if ( $checkout->get_checkout_fields() ) {
      do_action( 'woocommerce_before_checkout_form', $checkout );
    }
  ?>

  <h2 class="checkout-heading">Checkout</h2>

  <?php if ( is_user_logged_in() ) : 
    $current_user = wp_get_current_user(); ?>
    <div class="checkout-info-box">
      <p>Hi <?php echo esc_html( $current_user->display_name ); ?>!</p>
    </div>
  <?php else : ?>
    <div class="checkout-info-box">
      <p>Returning customer? <span class="checkout-link" id="login-trigger">Click here to login</span></p>
    </div>
    <div id="login-form" style="display: none; margin-bottom: 15px;">
      <?php woocommerce_login_form([
        'message'  => '',
        'redirect' => wc_get_checkout_url(),
        'hidden'   => false,
      ]); ?>
    </div>
  <?php endif; ?>

  <?php if ( wc_coupons_enabled() ) : ?>
    <div class="checkout-info-box">
      <p>Have a coupon? <span class="checkout-link showcoupon" id="coupon-trigger">Click here to enter your code</span></p>
    </div>
    <form class="checkout_coupon woocommerce-form-coupon coupon-form" method="post" id="coupon-form" style="display:none;">
      <?php do_action( 'woocommerce_coupon_form' ); ?>
    </form>
  <?php endif; ?>

  <div class="billing-details">
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
      <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

      <div class="billing-form">
        <div class="billing-column">
          <?php foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) : ?>
            <div class="form-row">
              <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="shipping-column" id="shipping-column" style="display: none;">
          <?php foreach ( $checkout->get_checkout_fields( 'shipping' ) as $key => $field ) : ?>
            <div class="form-row">
              <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

      <h2 class="checkout-heading">Your Order</h2>
      <div class="order-summary">
        <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
          <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
            $_product   = $cart_item['data'];
            $quantity   = $cart_item['quantity'];
            $size_display = '';
            if ( $cart_item['variation_id'] && ! empty( $cart_item['variation'] ) ) {
              foreach ( $cart_item['variation'] as $attr => $val ) {
                if ( stripos( $attr, 'size' ) !== false ) {
                  $size_display = $val;
                  break;
                }
              }
            }
          ?>
            <div class="order-item">
              <div style="display: flex; align-items: center; width: 60%;">
                <div class="order-item-image" style="flex: 0 0 80px;">
                  <?php echo $_product->get_image( [80, 80] ); ?>
                </div>
                <div class="order-item-details" style="flex: 1; padding-left: 15px;">
                  <div class="order-item-name">
                    <?php echo esc_html( $_product->get_name() ); ?>
                    <?php if ( $size_display ) : ?>
                      <span style="font-size:0.8em; color:#aaa;"> – Size: <?php echo esc_html( $size_display ); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="order-item-quantity"><?php echo esc_html( $quantity ); ?></div>
              <div class="order-item-price"><?php echo wc_price( $_product->get_price() ); ?></div>
              <div class="order-item-total"><?php echo wc_price( $quantity * $_product->get_price() ); ?></div>
            </div>
          <?php endforeach; ?>

          <div class="order-totals">
            <div class="order-total-row">
              <div class="order-total-label">Subtotal</div>
              <div class="order-total-value"><?php echo wc_price( WC()->cart->get_subtotal() ); ?></div>
            </div>
            <div class="order-total-row">
              <div class="order-total-label">Shipping</div>
              <div class="order-total-value">
                <?php 
                  if ( ! WC()->cart->needs_shipping() ) {
                    echo '—';
                  } else {
                    wc_cart_totals_shipping_html();
                  }
                ?>
              </div>
            </div>
            <div class="order-total-row" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #333333;">
              <div class="order-total-label" style="font-weight: bold;">Total</div>
              <div class="order-total-value" style="color: #ff0000; font-weight: bold;">
                <?php echo wc_price( WC()->cart->get_total() ); ?>
              </div>
            </div>
          </div>
        <?php else : ?>
          <p>Your cart is empty. Please add some products before proceeding to checkout.</p>
        <?php endif; ?>
      </div>

      <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
      </div>

      <div class="payment-methods">
        <?php woocommerce_checkout_payment( $checkout ); ?>
      </div>

      <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
    </form>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle login form
  const loginTrigger = document.getElementById('login-trigger');
  const loginForm = document.getElementById('login-form');
  if (loginTrigger && loginForm) {
    loginTrigger.addEventListener('click', () => {
      loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
    });
  }

  // Toggle coupon form
  const couponTrigger = document.getElementById('coupon-trigger');
  const couponForm = document.getElementById('coupon-form');
  if (couponTrigger && couponForm) {
    couponTrigger.addEventListener('click', e => {
      e.preventDefault();
      couponForm.style.display = couponForm.style.display === 'none' ? 'block' : 'none';
    });
  }

  // Toggle shipping fields
  const shipCheckbox = document.querySelector('input[name="ship_to_different_address"]');
  const shippingFields = document.getElementById('shipping-column');
  if (shipCheckbox && shippingFields) {
    shipCheckbox.addEventListener('change', () => {
      shippingFields.style.display = shipCheckbox.checked ? 'block' : 'none';
    });
  }
});
</script>

<?php get_footer(); ?>
