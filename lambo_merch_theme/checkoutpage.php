<?php
/**
 * Template Name: Checkout Page Template
 * Description: A custom checkout page template for Lambo Merch.
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Remove any notices that might interfere with our custom design
wc_clear_notices();

// Add specific inline styles for payment fields
function lambo_merch_inline_payment_styles() {
    ?>
    <style id="lambo-checkout-inline-styles">
        /* Credit card fields - both iframe and direct */
        .payment_box input,
        .wc-credit-card-form input.wc-credit-card-form-card-number,
        .wc-credit-card-form input.wc-credit-card-form-card-expiry,
        .wc-credit-card-form input.wc-credit-card-form-card-cvc,
        #add_payment_method #payment div.payment_box input.input-text,
        #add_payment_method #payment div.payment_box .wc-credit-card-form-card-number,
        #add_payment_method #payment div.payment_box .wc-credit-card-form-card-expiry,
        #add_payment_method #payment div.payment_box .wc-credit-card-form-card-cvc,
        .woocommerce-checkout #payment div.payment_box input.input-text,
        .woocommerce-checkout #payment div.payment_box .wc-credit-card-form-card-number,
        .woocommerce-checkout #payment div.payment_box .wc-credit-card-form-card-expiry,
        .woocommerce-checkout #payment div.payment_box .wc-credit-card-form-card-cvc {
            background-color: #333333 !important;
            color: #ffffff !important;
            border: 1px solid #444444 !important;
            padding: 12px !important;
            font-size: 16px !important;
            border-radius: 0 !important;
        }
        
        /* Hide express checkout completely */
        .express-checkout-sidebar-wrap,
        .express-payment-section,
        .wc-block-components-express-payment,
        .wp-block-woocommerce-checkout-express-payment-block,
        [class*="express-payment"] {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            width: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            opacity: 0 !important;
        }
        
        /* Payment box backgrounds */
        #payment,
        #payment div.payment_box,
        .wc-block-components-checkout-payment-methods,
        .wc-credit-card-form {
            background-color: #000000 !important;
        }
        
        /* Fix the contact fields gray background issue */
        .wc-block-checkout__contact-fields,
        .wp-block-woocommerce-checkout-contact-information-block,
        .wc-block-components-checkout-step {
            background-color: #000000 !important;
            box-shadow: none !important;
            border: none !important;
        }
        
        /* Stripe payment elements styling - enhanced with more selectors */
        #stripe-payment-data,
        #wc-stripe-cc-form,
        #stripe-card-element,
        #stripe-exp-element,
        #stripe-cvc-element,
        .wc-stripe-elements-field,
        .stripe-card-group,
        .wc-stripe-iban-element-field,
        .StripeElement,
        .StripeElement--focus,
        .StripeElement--invalid,
        .StripeElement--webkit-autofill,
        .wc-payment-form .wc-stripe-elements-field,
        /* Target frames with more liberal patterns */
        iframe[name*="stripe"],
        iframe[id*="stripe"],
        iframe[name*="card"],
        iframe[id*="card"],
        iframe[title*="card"],
        iframe[title*="stripe"],
        iframe[aria-label*="credit"],
        iframe[aria-label*="payment"],
        /* Every child element to be sure */
        #payment div.payment_box iframe,
        #payment iframe,
        .payment_box iframe,
        #stripe-payment-data iframe,
        .stripe-card-element,
        /* Target empty containers that might exist */
        .wc-stripe-card-element-container,
        .ElementsApp iframe,
        /* Direct selectors for Stripe */
        .payment_box input.StripeElement,
        .payment_box .__PrivateStripeElement,
        .stripe-source-field {
            background-color: #333333 !important;
            color: #ffffff !important;
            border: 1px solid #444444 !important;
            padding: 12px !important;
            border-radius: 0 !important;
        }
        
        /* Every possible input - except footer email input */
        .woocommerce-checkout input[type="text"],
        .woocommerce-checkout input[type="email"],
        .woocommerce-checkout input[type="tel"],
        .woocommerce-checkout input[type="number"],
        .woocommerce-checkout input[type="password"],
        .woocommerce-checkout textarea,
        .woocommerce-checkout select,
        .woocommerce-checkout textarea#order_comments,
        .woocommerce-checkout #order_comments,
        #customer_details input[type="text"],
        #customer_details input[type="email"],
        #customer_details input[type="tel"],
        #customer_details input[type="number"],
        #customer_details input[type="password"],
        .checkout-container input[type="text"],
        .checkout-container input[type="email"],
        .checkout-container input[type="tel"],
        .checkout-container input[type="number"],
        .checkout-container input[type="password"],
        #payment input[type="text"],
        #payment input[type="email"],
        #payment input[type="tel"],
        #payment input[type="number"],
        #payment input[type="password"],
        /* Specifically exempt the footer email input */
        input[type="email"]:not(footer input[type="email"]):not(.footer input[type="email"]):not(#colophon input[type="email"]),
        /* Select2 fields */
        .select2-selection,
        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--single,
        .woocommerce form .form-row .select2-container,
        .country_select,
        .state_select,
        .select2-dropdown,
        .select2-container--open .select2-dropdown,
        #billing_country_field .select2-selection,
        #shipping_country_field .select2-selection,
        #billing_state_field .select2-selection,
        #shipping_state_field .select2-selection,
        /* Native select elements */
        select.select,
        select.country_to_state,
        select.state_select,
        .woocommerce-Input.select {
            background-color: #333333 !important;
            color: #ffffff !important;
            border: 1px solid #444444 !important;
            padding: 12px !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        
        /* Select2 dropdown and results */
        .select2-dropdown,
        .select2-results__option,
        .select2-container--default .select2-results__option,
        .select2-search--dropdown .select2-search__field,
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #333333 !important;
            color: #ffffff !important;
        }
        
        /* Select2 arrow color fix */
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #ffffff transparent transparent transparent !important;
        }
        
        /* Fix order notes field specifically */
        textarea#order_comments,
        #order_comments,
        .woocommerce form .form-row textarea#order_comments,
        .woocommerce-checkout textarea {
            background-color: #333333 !important;
            color: #ffffff !important;
            min-height: 100px;
        }
        
        /* Hide default payment methods radio options */
        .wc-block-components-radio-control-accordion-option,
        .wc-block-components-radio-control-accordion-option--checked-option-highlighted {
            display: none !important;
        }
        
        /* Show only Stripe payment method */
        #payment .payment_method_stripe {
            display: block !important;
        }
        
        /* Force Stripe to be shown */
        .wc-block-components-payment-method-icons .wc-block-components-payment-method-icon--stripe {
            display: block !important;
        }
        
        /* Make checkboxes match theme */
        input[type="checkbox"] {
            border-radius: 0 !important;
            background-color: #333333 !important;
            border-color: #444444 !important;
        }
        
        /* Fix mobile number field phone flag issue */
        .wc-block-components-phone-number-input__label {
            position: static !important;
            display: block !important;
            margin-bottom: 5px !important;
        }
        
        .wc-block-components-phone-number-input__flag {
            top: 50% !important;
            transform: translateY(-50%) !important;
        }
        
        /* Explicitly reset footer email input styling */
        footer input[type="email"],
        .footer input[type="email"],
        #colophon input[type="email"],
        .site-footer input[type="email"],
        .footer-email-exempt {
            background-color: initial !important;
            color: initial !important;
            border: initial !important;
            padding: initial !important;
            border-radius: initial !important;
            box-shadow: initial !important;
        }
    /* Exempt footer email input */
footer input[type="email"],
.footer input[type="email"],
#colophon input[type="email"],
.site-footer input[type="email"] {
    background-color: transparent !important;
    color: inherit !important;
    border: none !important;
    padding: initial !important;
}    
    </style>
    <script>
    // This script runs immediately to style the payment fields - more aggressive approach
    document.addEventListener('DOMContentLoaded', function() {
        // Make sure footer email field is not affected
        const footerEmailInputs = document.querySelectorAll('footer input[type="email"], .footer input[type="email"], #colophon input[type="email"], .site-footer input[type="email"]');
        footerEmailInputs.forEach(function(input) {
            // Reset any styling that might have been applied
            input.style.backgroundColor = '';
            input.style.color = '';
            input.style.border = '';
            input.style.borderColor = '';
            input.removeAttribute('style');
            
            // Add a specific class to identify it
            input.classList.add('footer-email-exempt');
        });
        
        // Force Stripe iframe styling with a repeated timer
        function forceStripeStyles() {
            // Explicitly make sure payment elements are visible
            document.querySelectorAll('#payment, #stripe-payment-data, .wc-stripe-elements-field, .payment_method_stripe').forEach(function(el) {
                el.style.display = 'block';
                el.style.visibility = 'visible';
                el.style.opacity = '1';
            });
            // Try to directly access and style Stripe field iframes - runs continuously
            const stripeIframes = document.querySelectorAll('iframe[id*="stripe"], iframe[name*="stripe"], iframe[id*="card"], iframe[name*="card"], iframe[title*="card"]');
            
            stripeIframes.forEach(function(iframe) {
                // Style the parent container
                if (iframe.parentNode) {
                    iframe.parentNode.style.backgroundColor = '#333333';
                    iframe.parentNode.style.border = '1px solid #444444';
                }
                
                // Style the iframe itself
                iframe.style.backgroundColor = '#333333';
                
                try {
                    // Try to access iframe content - will work only for same-origin frames
                    const doc = iframe.contentDocument || iframe.contentWindow.document;
                    
                    // Insert a style tag
                    if (doc.head && !doc.getElementById('stripe-dark-theme')) {
                        const styleEl = doc.createElement('style');
                        styleEl.id = 'stripe-dark-theme';
                        styleEl.textContent = `
                            body, html { background: #333333 !important; }
                            * { background-color: #333333 !important; color: #ffffff !important; }
                            input, .InputElement, .InputContainer, div, span {
                                background-color: #333333 !important;
                                color: #ffffff !important;
                                border-color: #444444 !important;
                            }
                        `;
                        doc.head.appendChild(styleEl);
                    }
                    
                    // Apply direct styles to all elements in the iframe
                    const allElements = doc.querySelectorAll('*');
                    allElements.forEach(function(el) {
                        el.style.backgroundColor = '#333333';
                        el.style.color = '#ffffff';
                    });
                } catch (e) {
                    // Cross-origin access will fail - expected for Stripe
                }
            });
            
            // Style Select2 dropdowns
            const select2Elements = document.querySelectorAll('.select2-selection, .select2-dropdown, .select2-results__option');
            select2Elements.forEach(function(el) {
                el.style.backgroundColor = '#333333';
                el.style.color = '#ffffff';
                el.style.borderColor = '#444444';
            });
            
            // Order notes field
            const orderNotes = document.querySelectorAll('#order_comments, textarea#order_comments');
            orderNotes.forEach(function(el) {
                el.style.backgroundColor = '#333333';
                el.style.color = '#ffffff';
                el.style.border = '1px solid #444444';
            });
        }
        
        // Run immediately
        forceStripeStyles();
        
        // Then continue running to catch dynamically loaded content
        setInterval(forceStripeStyles, 500);
    });
    </script>
    <?php
}
add_action('wp_head', 'lambo_merch_inline_payment_styles');
add_action('wp_footer', 'lambo_merch_inline_payment_styles');

?>

<style>
/* Custom Checkout Form Styling */
body.woocommerce-checkout, 
.woocommerce-checkout #page, 
.woocommerce-checkout #content, 
.woocommerce-checkout #primary, 
.woocommerce-checkout .site-main {
  background: #000000 !important;
  color: #ffffff !important;
}

/* Explicitly target the problematic gray container */
.wc-block-checkout__contact-fields,
.wp-block-woocommerce-checkout-contact-information-block,
.wc-block-components-checkout-step {
  background-color: #000000 !important;
  padding: 0 !important;
  border: none !important;
  box-shadow: none !important;
}

/* Custom input styling */
.wc-block-components-text-input input[type="text"],
.wc-block-components-text-input input[type="email"],
.wc-block-components-text-input input[type="tel"],
.wc-block-components-text-input input[type="number"],
.wc-block-components-text-input textarea,
.wc-block-components-select .components-custom-select-control__button {
  background-color: #333333 !important;
  border: 1px solid #444444 !important;
  color: #ffffff !important;
  padding: 12px !important;
  border-radius: 0 !important;
  font-size: 16px !important;
}

/* Label styling */
.wc-block-components-text-input label,
.wc-block-components-select label {
  color: #ffffff !important;
  font-weight: bold !important;
  position: static !important;
  display: block !important;
  margin-bottom: 5px !important;
}

/* Payment method styling */
.wc-block-components-payment-method-label {
  color: #ffffff !important;
}

.wc-block-components-payment-method-icons {
  display: none;
}

/* Hide express payment section */
.wp-block-woocommerce-checkout-express-payment-block {
  display: none !important;
}

/* Remove coupon section in totals */
.wp-block-woocommerce-checkout-order-summary-coupon-form-block {
  display: none !important;
}

/* Order summary styling */
.wp-block-woocommerce-checkout-order-summary-block {
  background: #000000;
  padding: 1.5rem;
}

/* Place order button */
.wc-block-components-checkout-place-order-button {
  background-color: #ff0000 !important;
  color: #ffffff !important;
  text-transform: uppercase !important;
  font-weight: bold !important;
  padding: 1rem 2rem !important;
  border: none !important;
  width: 100% !important;
  transition: background-color 0.3s ease !important;
}

.wc-block-components-checkout-place-order-button:hover {
  background-color: #cc0000 !important;
}

/* Mobile-specific styles */
@media (max-width: 767px) {
  .wc-block-checkout {
    padding: 1rem;
  }
  
  /* Stack fields better on mobile */
  .wc-block-components-checkout-step {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }
}
</style>

<main id="primary" class="site-main">
  <div class="checkout-container" style="max-width:1200px; margin:0 auto; padding:2rem; background:#000000;">
    <h1 class="page-title" style="text-align:center; margin-bottom:2rem; color:#ff0000; font-style:italic;">
      Checkout
    </h1>
    
    <?php
    // Configure WooCommerce to show only Stripe payment method
    add_filter('woocommerce_available_payment_gateways', function($gateways) {
        // Keep only Stripe
        foreach ($gateways as $key => $gateway) {
            if ($key !== 'stripe') {
                unset($gateways[$key]);
            }
        }
        return $gateways;
    }, 999);
    
    // Force Stripe to be enabled
    add_filter('option_woocommerce_stripe_settings', function($settings) {
        if (is_array($settings)) {
            $settings['enabled'] = 'yes';
        }
        return $settings;
    });
    
    // Output custom WooCommerce checkout form
    echo do_shortcode('[woocommerce_checkout]');
    
    // Add WooCommerce Stripe support
    if (class_exists('WC_Stripe')) {
        ?>
        <div id="stripe-payment-placeholder" style="display:none;">
            <!-- Hidden container to ensure Stripe scripts load -->
            <div id="stripe-payment-data"></div>
        </div>
        <?php
    }
    ?>
    
    <script>
    // Script to apply custom styling to dynamically loaded elements
    document.addEventListener('DOMContentLoaded', function() {
      // Set the background to black
      document.body.style.backgroundColor = "#000000";
      
      // Continuously enforce black background on contact fields section
      setInterval(function() {
        const contactFields = document.querySelectorAll('.wc-block-checkout__contact-fields, .wp-block-woocommerce-checkout-contact-information-block, .wc-block-components-checkout-step');
        contactFields.forEach(field => {
          field.style.backgroundColor = "#000000";
          field.style.boxShadow = "none";
          field.style.border = "none";
        });
        
        // Fix the mobile phone number field
        const mobileFields = document.querySelectorAll('.wc-block-components-phone-number-input');
        mobileFields.forEach(field => {
          const label = field.querySelector('label');
          if (label) {
            label.style.position = 'static';
            label.style.display = 'block';
            label.style.marginBottom = '5px';
          }
          
          const flag = field.querySelector('.wc-block-components-phone-number-input__flag');
          if (flag) {
            flag.style.top = '50%';
            flag.style.transform = 'translateY(-50%)';
          }
        });
        
        // Hide express checkout
        const expressCheckout = document.querySelectorAll('.wp-block-woocommerce-checkout-express-payment-block');
        expressCheckout.forEach(section => {
          section.style.display = 'none';
        });
        
        // Hide coupon form
        const couponForm = document.querySelectorAll('.wp-block-woocommerce-checkout-order-summary-coupon-form-block');
        couponForm.forEach(form => {
          form.style.display = 'none';
        });
      }, 500);
    });
    </script>
  </div>
</main>

<?php
get_footer();