<?php
/**
 * Template Name: Checkout Template
 * Description: Merged custom checkout page template for Lambo Merch.
 */
defined( 'ABSPATH' ) || exit;

// Process checkout if needed
if ( isset( $_POST['is_checkout_submit'] ) && $_POST['is_checkout_submit'] === '1' ) {
    // This ensures we get redirected to the order-received page after checkout
    add_filter( 'woocommerce_get_checkout_order_received_url', function( $url, $order ) {
        // Make sure we redirect to our custom template for order received
        $order_id = $order->get_id();
        $order_key = $order->get_order_key();
        return wc_get_endpoint_url( 'order-received', $order_id, wc_get_checkout_url() ) . '?key=' . $order_key;
    }, 10, 2);
}

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
.coupon-form input[type="text"] {
  width: 70%;
  padding: 10px;
  background-color: #333333;
  border: 1px solid #444444;
  color: #ffffff;
}
.coupon-form button {
  width: 25%;
  padding: 10px;
  background-color: #ff0000;
  border: none;
  color: #ffffff;
  cursor: pointer;
  margin-left: 5%;
}
.coupon-form.active {
  display: block;
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
.billing-column {
  flex: 1;
  min-width: 300px;
}
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
  <h2 class="checkout-heading">Checkout</h2>
  
  <!-- Returning Customer Login Box -->
  <div class="checkout-info-box">
    <p>Returning customer? <span class="checkout-link" id="login-trigger">Click here to login</span></p>
  </div>
  <div id="login-form" style="display: none; margin-bottom: 15px;">
    <?php 
      woocommerce_login_form([
        'message'  => '',
        'redirect' => wc_get_checkout_url(),
        'hidden'   => false,
      ]); 
    ?>
  </div>
  
  <!-- Coupon Code Box -->
  <div class="checkout-info-box">
    <p>Have a coupon? <span class="checkout-link" id="coupon-trigger">Click here to enter your code</span></p>
  </div>
  <div id="coupon-form" class="coupon-form">
    <form method="post" action="<?php echo esc_url(wc_get_cart_url()); ?>">
      <input type="text" name="coupon_code" placeholder="Coupon code">
      <button type="submit" name="apply_coupon" value="Apply coupon">Apply</button>
      <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
    </form>
  </div>
  
  <!-- Billing & Shipping Details -->
  <div class="billing-details">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h2 class="checkout-heading" style="margin-bottom: 0;">Billing Details</h2>
      <div class="checkbox-row" style="margin: 0;">
        <input type="checkbox" name="ship_to_different_address" id="ship_to_different_address" value="1" <?php checked(WC()->checkout->get_value('ship_to_different_address'), 1); ?>>
        <label for="ship_to_different_address">Ship to a different address?</label>
      </div>
    </div>
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
      <!-- Add nonce field for security -->
      <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
      <div class="billing-form">
        <!-- Billing Details Column -->
        <div class="billing-column">
          <div class="form-row">
            <input type="text" name="billing_first_name" id="billing_first_name" placeholder="First name *" required>
          </div>
          <div class="form-row">
            <input type="text" name="billing_last_name" id="billing_last_name" placeholder="Last name *" required>
          </div>
          <div class="form-row">
            <input type="text" name="billing_company" id="billing_company" placeholder="Company (optional)">
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="billing_address_1" id="billing_address_1" placeholder="Street address *" required>
          </div>
          <div class="form-row">
            <input type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc. (optional)">
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="billing_city" id="billing_city" placeholder="Town / City *" required>
          </div>
          <div class="form-row address-field update_totals_on_change">
            <select name="billing_country" id="billing_country" class="country_to_state">
              <option value="">Select country / region *</option>
              <?php 
                $countries = WC()->countries->get_countries();
                foreach ( $countries as $code => $name ) {
                  echo '<option value="' . esc_attr( $code ) . '">' . esc_html( $name ) . '</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="billing_state" id="billing_state" placeholder="State / Province *" required>
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="billing_postcode" id="billing_postcode" placeholder="ZIP Code *" required>
          </div>
          <div class="form-row">
            <input type="email" name="billing_email" id="billing_email" placeholder="Email *" required>
          </div>
          <div class="form-row">
            <input type="tel" name="billing_phone" id="billing_phone" placeholder="Phone number *" required>
          </div>
          <div class="checkbox-row">
            <input type="checkbox" name="createaccount" id="createaccount" value="1">
            <label for="createaccount">Create an account?</label>
          </div>
        </div>
        <!-- Shipping Details Column (hidden by default) -->
        <div class="shipping-column" id="shipping-column" style="display: none;">
          <div class="form-row">
            <input type="text" name="shipping_first_name" id="shipping_first_name" placeholder="First name *" required>
          </div>
          <div class="form-row">
            <input type="text" name="shipping_last_name" id="shipping_last_name" placeholder="Last name *" required>
          </div>
          <div class="form-row">
            <input type="text" name="shipping_company" id="shipping_company" placeholder="Company (optional)">
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="shipping_address_1" id="shipping_address_1" placeholder="Street address *" required>
          </div>
          <div class="form-row">
            <input type="text" name="shipping_address_2" id="shipping_address_2" placeholder="Apartment, suite, unit, etc. (optional)">
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="shipping_city" id="shipping_city" placeholder="Town / City *" required>
          </div>
          <div class="form-row address-field update_totals_on_change">
            <select name="shipping_country" id="shipping_country" class="country_to_state" required>
              <option value="">Select country / region *</option>
              <?php 
                foreach ( $countries as $code => $name ) {
                  echo '<option value="' . esc_attr( $code ) . '">' . esc_html( $name ) . '</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="shipping_state" id="shipping_state" placeholder="State / Province *" required>
          </div>
          <div class="form-row address-field update_totals_on_change">
            <input type="text" name="shipping_postcode" id="shipping_postcode" placeholder="ZIP Code *" required>
          </div>
          <div class="form-row">
            <textarea name="order_comments" id="order_comments" placeholder="Notes about your order, e.g., special delivery notes." rows="4"></textarea>
          </div>
        </div>
        
        <!-- Hidden fields for shipping address when "Ship to different address" is unchecked -->
        <div id="shipping-same-as-billing-fields" style="display: none;">
          <!-- These fields will be populated by JS before form submission -->
          <input type="hidden" name="shipping_first_name" id="same_as_billing_first_name">
          <input type="hidden" name="shipping_last_name" id="same_as_billing_last_name">
          <input type="hidden" name="shipping_company" id="same_as_billing_company">
          <input type="hidden" name="shipping_address_1" id="same_as_billing_address_1">
          <input type="hidden" name="shipping_address_2" id="same_as_billing_address_2">
          <input type="hidden" name="shipping_city" id="same_as_billing_city">
          <input type="hidden" name="shipping_country" id="same_as_billing_country">
          <input type="hidden" name="shipping_state" id="same_as_billing_state">
          <input type="hidden" name="shipping_postcode" id="same_as_billing_postcode">
        </div>
      </div>
      
      <!-- Order Summary -->
      <h2 class="checkout-heading">Your Order</h2>
      <div class="order-summary">
        <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
          <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
            $_product     = $cart_item['data'];
            $quantity     = $cart_item['quantity'];
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
                      <span style="font-size:0.8em; color:#aaa;"> &ndash; Size: <?php echo esc_html( $size_display ); ?></span>
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
                  $packages = WC()->shipping->get_packages();
                  if ( empty( $packages ) || ! WC()->cart->needs_shipping() ) {
                    echo 'Enter your address to view shipping options.';
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
      
      <!-- Payment Method and Place Order -->
      <div class="payment-methods">
        <?php woocommerce_checkout_payment( $checkout ); ?>
      </div>
    </form>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle login form display
  const loginTrigger = document.getElementById('login-trigger');
  const loginForm = document.getElementById('login-form');
  if (loginTrigger && loginForm) {
    loginTrigger.addEventListener('click', () => {
      loginForm.style.display = (loginForm.style.display === 'none') ? 'block' : 'none';
    });
  }
  
  // Toggle coupon form display
  const couponTrigger = document.getElementById('coupon-trigger');
  const couponForm = document.getElementById('coupon-form');
  if (couponTrigger && couponForm) {
    couponTrigger.addEventListener('click', () => {
      couponForm.classList.toggle('active');
      if (couponForm.classList.contains('active')) {
        const codeInput = couponForm.querySelector('input[name="coupon_code"]');
        if (codeInput) setTimeout(() => codeInput.focus(), 100);
      }
    });
  }
  
  // Set up visibility toggle for shipping fields
  const shipCheckbox = document.getElementById('ship_to_different_address');
  const shippingFields = document.getElementById('shipping-column');
  const shippingSameAsBillingFields = document.getElementById('shipping-same-as-billing-fields');
  
  // Function to handle shipping fields display based on checkbox
  function toggleShippingFields() {
    const isShipDifferent = shipCheckbox.checked;
    
    // Toggle visibility of fields
    shippingFields.style.display = isShipDifferent ? 'block' : 'none';
    shippingSameAsBillingFields.style.display = isShipDifferent ? 'none' : 'block';
    
    // Toggle required attribute on shipping fields
    const requiredFields = [
      'shipping_first_name', 'shipping_last_name', 'shipping_address_1',
      'shipping_city', 'shipping_country', 'shipping_state', 'shipping_postcode'
    ];
    
    requiredFields.forEach(fieldId => {
      const field = document.getElementById(fieldId);
      if (field) {
        if (isShipDifferent) {
          field.setAttribute('required', 'required');
        } else {
          field.removeAttribute('required');
        }
      }
    });
    
    // If shipping to same address, copy billing values to hidden shipping fields
    if (!isShipDifferent) {
      updateHiddenShippingFields();
    }
  }
  
  // Function to copy billing values to hidden shipping fields
  function updateHiddenShippingFields() {
    const billingFields = [
      'first_name', 'last_name', 'company', 'address_1', 'address_2', 
      'city', 'state', 'postcode', 'country'
    ];
    
    billingFields.forEach(field => {
      const billingField = document.getElementById('billing_' + field);
      const hiddenShippingField = document.getElementById('same_as_billing_' + field);
      
      if (billingField && hiddenShippingField) {
        hiddenShippingField.value = billingField.value;
      }
    });
  }
  
  // Apply initial state and add change listener
  if (shipCheckbox && shippingFields && shippingSameAsBillingFields) {
    // Set initial state
    toggleShippingFields();
    
    // Add change event listener
    shipCheckbox.addEventListener('change', toggleShippingFields);
    
    // Add input listeners to billing fields to update hidden shipping fields
    const billingFields = [
      'first_name', 'last_name', 'company', 'address_1', 'address_2', 
      'city', 'state', 'postcode', 'country'
    ];
    
    billingFields.forEach(field => {
      const billingField = document.getElementById('billing_' + field);
      
      if (billingField) {
        // Update shipping field when billing field changes
        billingField.addEventListener('input', function() {
          if (!shipCheckbox.checked) {
            const hiddenShippingField = document.getElementById('same_as_billing_' + field);
            if (hiddenShippingField) {
              hiddenShippingField.value = this.value;
            }
          }
        });
      }
    });
  }
  
  // Handle form submission
  const checkoutForm = document.querySelector('form.checkout.woocommerce-checkout');
  if (checkoutForm) {
    checkoutForm.addEventListener('submit', function(e) {
      // Final check to ensure fields are properly set up
      if (shipCheckbox.checked) {
        // If shipping to different address, make sure shipping fields are enabled
        // and hidden fields are disabled
        const hiddenFields = shippingSameAsBillingFields.querySelectorAll('input');
        hiddenFields.forEach(field => {
          field.setAttribute('disabled', 'disabled');
        });
        
        // Enable all shipping fields to ensure they're submitted
        const visibleShippingInputs = shippingFields.querySelectorAll('input, select, textarea');
        visibleShippingInputs.forEach(field => {
          field.removeAttribute('disabled');
        });
        
        // Add a flag indicating shipping to different address
        const shipDiffAddressFlag = document.createElement('input');
        shipDiffAddressFlag.type = 'hidden';
        shipDiffAddressFlag.name = 'ship_to_different_address';
        shipDiffAddressFlag.value = '1';
        checkoutForm.appendChild(shipDiffAddressFlag);
      } else {
        // If shipping to same address, copy billing values to shipping fields
        const billingFields = [
          'first_name', 'last_name', 'company', 'address_1', 'address_2', 
          'city', 'state', 'postcode', 'country'
        ];
        
        billingFields.forEach(field => {
          const billingValue = document.getElementById('billing_' + field).value;
          const shippingField = document.getElementById('shipping_' + field);
          
          // Create a shipping field if it doesn't exist
          if (!shippingField) {
            const newField = document.createElement('input');
            newField.type = 'hidden';
            newField.name = 'shipping_' + field;
            newField.id = 'shipping_' + field;
            newField.value = billingValue;
            checkoutForm.appendChild(newField);
          } else {
            // Update existing shipping field
            shippingField.value = billingValue;
            // Make sure it's not disabled
            shippingField.removeAttribute('disabled');
          }
        });
        
        // Disable visible shipping section fields to prevent conflicts
        const visibleShippingInputs = shippingFields.querySelectorAll('input, select, textarea');
        visibleShippingInputs.forEach(field => {
          field.setAttribute('disabled', 'disabled');
        });
      }
      
      // Add a flag to indicate we're submitting the checkout form
      const hiddenFlag = document.createElement('input');
      hiddenFlag.type = 'hidden';
      hiddenFlag.name = 'is_checkout_submit';
      hiddenFlag.value = '1';
      checkoutForm.appendChild(hiddenFlag);
      
      // Log the form data for debugging
      console.log('Shipping to different address:', shipCheckbox.checked);
    });
  }
  
  // Style Stripe payment elements after they load
  function styleStripeElements() {
    document.querySelectorAll('.payment_box, .wc-stripe-elements-field').forEach(el => {
      el.style.backgroundColor = '#333333';
      el.style.color = '#ffffff';
    });
    document.querySelectorAll('.payment_method_stripe label').forEach(label => {
      label.style.color = '#ffffff';
    });
    document.querySelectorAll('.stripe-card-group, .wc-stripe-elements-field').forEach(container => {
      container.style.backgroundColor = '#333333';
      container.style.border = '1px solid #444444';
      container.style.padding = '15px';
    });
  }
  
  // Wait for Stripe elements to appear, then style them
  const stripeInterval = setInterval(() => {
    const stripeElements = document.querySelectorAll('.wc-stripe-elements-field, .payment_box');
    if (stripeElements.length > 0) {
      styleStripeElements();
      clearInterval(stripeInterval);
    }
  }, 500);
});
</script>

<?php get_footer(); ?>
