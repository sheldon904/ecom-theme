<?php
/**
 * Template Name: Checkout Template
 * Description: Custom checkout template that uses the standard WooCommerce checkout with custom styling.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="site-main lambo-checkout-page">
  <div class="container">
    <h2 class="checkout-heading">Checkout</h2>
    
    <?php 
    // Simply output the standard WooCommerce checkout shortcode
    echo do_shortcode('[woocommerce_checkout]');
    ?>
  </div>
</main>

<style>
/* Basic styling for the checkout page */
.lambo-checkout-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

/* Main heading */
.checkout-heading {
  color: #ff0000;
  font-style: italic;
  margin-bottom: 1.5rem;
  font-size: 2rem;
}

/* Main background color */
.lambo-checkout-page,
.woocommerce-checkout {
  background-color: #000000;
  color: #ffffff;
}

/* Info boxes (returning customer & coupon) */
.woocommerce-form-login-toggle .woocommerce-info,
.woocommerce-form-coupon-toggle .woocommerce-info {
  background-color: #333333;
  color: #ffffff;
  border-top-color: #444444;
}

.woocommerce-form-login-toggle .woocommerce-info a,
.woocommerce-form-coupon-toggle .woocommerce-info a {
  color: #ffffff;
  text-decoration: underline;
}

/* Login form */
.woocommerce-form-login {
  background-color: #222222;
  border: 1px solid #333333;
  padding: 20px;
  margin-bottom: 20px;
  color: #ffffff;
}

/* Coupon form */
.checkout_coupon {
  background-color: #222222;
  border: 1px solid #333333 !important;
  padding: 20px;
  margin-bottom: 20px;
}

/* Form fields */
.woocommerce-checkout .form-row .input-text,
.woocommerce-checkout .form-row select,
.woocommerce-checkout .form-row textarea,
.select2-container--default .select2-selection--single {
  background-color: #333333;
  border: 1px solid #444444;
  color: #ffffff;
  padding: 10px;
}

/* Labels */
.woocommerce-checkout label {
  color: #ffffff;
}

/* Order review table */
#order_review_heading {
  color: #ff0000;
  font-style: italic;
  margin-top: 30px;
  margin-bottom: 15px;
  font-size: 1.8rem;
}

#order_review {
  background-color: #222222;
  padding: 20px;
  color: #ffffff;
}

.woocommerce-checkout-review-order-table th,
.woocommerce-checkout-review-order-table td {
  color: #ffffff;
  padding: 15px 10px;
  border-bottom: 1px solid #333333;
}

/* Payment section */
#payment {
  background-color: #222222 !important;
  border-radius: 0;
}

#payment div.payment_box {
  background-color: #333333;
  color: #ffffff;
}

#payment div.payment_box::before {
  border-bottom-color: #333333;
}

#payment .payment_methods {
  border-bottom: 1px solid #444444;
}

#payment .payment_methods label {
  color: #ffffff;
}

/* Stripe elements */
.wc-stripe-elements-field,
.wc-stripe-iban-element-field {
  background-color: #333333 !important;
  border: 1px solid #444444 !important;
  padding: 12px !important;
}

/* Hide express checkout options */
.wc-proceed-to-checkout .wc-proceed-to-checkout-apple-pay-button,
.wc-stripe-payment-request-wrapper {
  display: none !important;
}

/* Place order button */
#place_order {
  background-color: #ff0000 !important;
  color: #ffffff !important;
  border: none !important;
  padding: 15px 20px !important;
  text-transform: uppercase;
  font-weight: bold;
  width: 100%;
}

#place_order:hover {
  background-color: #cc0000 !important;
}

/* Two column layout */
@media (min-width: 768px) {
  #customer_details,
  #order_review {
    width: 48%;
    float: left;
  }
  
  #customer_details {
    margin-right: 4%;
  }
  
  /* Clear the floats */
  .woocommerce-checkout:after {
    content: "";
    display: table;
    clear: both;
  }
  
  /* Move shipping checkbox next to billing heading */
  #ship-to-different-address {
    position: absolute;
    top: 0;
    right: 0;
  }
  
  .woocommerce-billing-fields {
    position: relative;
  }
}

/* Mobile adjustments */
@media (max-width: 767px) {
  .woocommerce-checkout .col2-set .col-1,
  .woocommerce-checkout .col2-set .col-2,
  #order_review {
    width: 100%;
    float: none;
  }
  
  #order_review_heading {
    margin-top: 30px;
  }
}
</style>

<script>
jQuery(document).ready(function($) {
  // Hide any payment request buttons (Google Pay, etc.)
  $('.wc-stripe-payment-request-button-separator, .wc-stripe-payment-request-wrapper').hide();
  
  // Enhance form elements with proper styling
  function styleCheckoutElements() {
    // Style all form fields
    $('.woocommerce-checkout .input-text, .woocommerce-checkout select, .woocommerce-checkout textarea').css({
      'background-color': '#333333',
      'color': '#ffffff',
      'border': '1px solid #444444',
      'padding': '10px'
    });
    
    // Style payment boxes
    $('#payment, #payment div.payment_box').css({
      'background-color': '#222222',
      'color': '#ffffff'
    });
    
    // Style Stripe elements
    $('.wc-stripe-elements-field, .wc-stripe-iban-element-field').css({
      'background-color': '#333333',
      'border': '1px solid #444444',
      'padding': '15px'
    });
    
    // Make Place Order button full width and styled
    $('#place_order').css({
      'background-color': '#ff0000',
      'color': '#ffffff',
      'border': 'none',
      'width': '100%',
      'text-transform': 'uppercase',
      'font-weight': 'bold',
      'padding': '15px 20px'
    });
    
    // On desktop, position shipping checkbox next to billing heading
    if ($(window).width() >= 768) {
      $('.woocommerce-billing-fields').css('position', 'relative');
      $('#ship-to-different-address').css({
        'position': 'absolute',
        'top': '0',
        'right': '0'
      });
    }
  }
  
  // Run styling function
  styleCheckoutElements();
  
  // Re-run on checkout update
  $(document.body).on('updated_checkout', function() {
    styleCheckoutElements();
    
    // Hide payment request buttons that might have been added
    $('.wc-stripe-payment-request-button-separator, .wc-stripe-payment-request-wrapper').hide();
  });
  
  // On window resize, adjust layout
  $(window).resize(function() {
    if ($(window).width() >= 768) {
      $('.woocommerce-billing-fields').css('position', 'relative');
      $('#ship-to-different-address').css({
        'position': 'absolute',
        'top': '0',
        'right': '0'
      });
    } else {
      $('#ship-to-different-address').css({
        'position': 'static'
      });
    }
  });
});
</script>

<?php get_footer(); ?>