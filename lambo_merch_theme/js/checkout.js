/**
 * Custom JavaScript for the checkout page
 */
document.addEventListener('DOMContentLoaded', function() {
    // Only run on checkout page
    if (!document.body.classList.contains('woocommerce-checkout') && 
        !document.querySelector('.woocommerce-checkout') &&
        !document.querySelector('.wp-block-woocommerce-checkout')) {
        return;
    }
    
    // Set the main background to black - only for checkout page
    document.body.style.backgroundColor = '#000000';
    
    // Global styles that won't interfere with form inputs
    applyGlobalStyles();
    
    // Apply initial styling to form fields without affecting user input
    safelyStyleFormFields();
    
    // Hide elements we don't want to show
    hideExpressCheckout();
    hideCouponForm();
    
    // Configure payment methods
    configurePayments();
    
    // Disable WooCommerce blockUI overlay
    disableWooCommerceOverlay();
    
    // Instead of using MutationObserver which causes the form jumping issue,
    // periodically check for new elements that need styling
    // This runs less frequently and doesn't interfere with typing
    setInterval(function() {
        safelyStyleFormFields();
        hideExpressCheckout();
        hideCouponForm();
        configurePayments();
        disableWooCommerceOverlay();
    }, 2000); // Check every 2 seconds - slow enough not to cause issues
    


    // Make sure footer email field is not affected by checkout styling
function fixFooterEmailInputs() {
    const footerEmailInputs = document.querySelectorAll('footer input[type="email"], .footer input[type="email"], #colophon input[type="email"], .site-footer input[type="email"]');
    footerEmailInputs.forEach(function(input) {
        // Reset any styling that might have been applied
        input.removeAttribute('style');
        
        // Explicitly apply footer-specific styling
        input.style.backgroundColor = '#ffffff';
        input.style.color = '#333333';
        input.style.border = '1px solid #cccccc';
        input.style.padding = '8px 12px';
        input.style.borderRadius = '0';
        input.style.fontSize = '14px';
        input.style.lineHeight = '1.5';
        input.style.boxShadow = 'none';
        input.style.width = 'auto';
        input.style.height = 'auto';
        input.style.margin = '0';
        input.style.display = 'inline-block';
        input.style.boxSizing = 'border-box';
        
        // Add specific classes to identify and protect it
        input.classList.add('footer-email-exempt');
        input.classList.remove('lambo-styled');
        
        // Remove any checkout-specific classes
        input.classList.remove('woocommerce-Input');
        input.classList.remove('input-text');
        
        // Set a data attribute to mark it as fixed
        input.dataset.footerInputFixed = 'true';
        
        // Add a mutation observer to ensure styles don't get reapplied
        if (!input.dataset.hasObserver) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'style' || mutation.attributeName === 'class') {
                        // Re-apply our specific styling after a short delay
                        setTimeout(function() {
                            // If checkout has applied styling, fix it again
                            input.style.backgroundColor = '#ffffff';
                            input.style.color = '#333333';
                            input.style.border = '1px solid #cccccc';
                            input.style.padding = '8px 12px';
                            input.style.borderRadius = '0';
                            input.style.fontSize = '14px';
                            input.style.lineHeight = '1.5';
                            input.style.boxShadow = 'none';
                            input.style.width = 'auto';
                            input.style.height = 'auto';
                            input.style.margin = '0';
                            input.style.display = 'inline-block';
                            input.style.boxSizing = 'border-box';
                            
                            // Ensure our footer-specific classes are applied
                            input.classList.add('footer-email-exempt');
                            input.classList.remove('lambo-styled');
                        }, 50);
                    }
                });
            });
            
            observer.observe(input, { 
                attributes: true,
                attributeFilter: ['style', 'class'] 
            });
            
            input.dataset.hasObserver = 'true';
        }
    });
}

// Call the function initially
fixFooterEmailInputs();

// Set up a periodic check to ensure footer email fields stay styled correctly
setInterval(fixFooterEmailInputs, 1000);




    /**
     * Apply global styles to the page via a style tag
     * This is safe and won't affect input behavior
     */
    function applyGlobalStyles() {
        const styleTag = document.createElement('style');
        styleTag.id = 'lambo-checkout-styles';
        styleTag.textContent = `
            /* Global container styling */
            body.woocommerce-checkout,
            body.woocommerce-checkout #content,
            .woocommerce-checkout .site-content,
            .woocommerce-checkout .entry-content,
            .woocommerce-checkout .woocommerce {
                background-color: #000000 !important;
                color: #ffffff !important;
            }
            
            /* Form field styling */
            .woocommerce-checkout input[type="text"],
            .woocommerce-checkout input[type="email"],
            .woocommerce-checkout input[type="tel"],
            .woocommerce-checkout input[type="number"],
            .woocommerce-checkout input[type="password"],
            .woocommerce-checkout textarea,
            .woocommerce-checkout select,
            .woocommerce-checkout .select2-selection,
            .woocommerce-checkout .wc-block-components-text-input input,
            .woocommerce-checkout #payment input {
                background-color: #333333 !important;
                color: #ffffff !important;
                border: 1px solid #444444 !important;
                padding: 12px !important;
                border-radius: 0 !important;
                font-size: 16px !important;
                line-height: 1.5 !important;
                box-shadow: none !important;
                transition: border-color 0.3s ease !important;
            }
            
            /* Focus styles */
            .woocommerce-checkout input:focus,
            .woocommerce-checkout textarea:focus,
            .woocommerce-checkout select:focus,
            .woocommerce-checkout .select2-container--focus .select2-selection {
                border-color: #ff0000 !important;
                outline: none !important;
            }
            
            /* Select2 dropdown styling */
            .select2-dropdown,
            .select2-container--default .select2-selection--single,
            .select2-container--default .select2-search--dropdown .select2-search__field,
            .select2-container--default .select2-results__option {
                background-color: #333333 !important;
                color: #ffffff !important;
                border-color: #444444 !important;
            }
            
            /* Hide coupon form and express checkout */
            .woocommerce-checkout .coupon-form,
            .woocommerce-checkout [class*="coupon-form"],
            .woocommerce-checkout .wp-block-woocommerce-checkout-express-payment-block,
            .woocommerce-checkout [class*="express-payment"] {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                width: 0 !important;
                overflow: hidden !important;
                opacity: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            /* Payment methods containers */
            .woocommerce-checkout #payment,
            .woocommerce-checkout .payment_box,
            .woocommerce-checkout .wc-stripe-elements-field,
            .woocommerce-checkout .stripe-card-group {
                background-color: #000000 !important;
                color: #ffffff !important;
            }
            
            /* Stripe iframe containers */
            .woocommerce-checkout .wc-stripe-elements-field,
            .woocommerce-checkout .stripe-card-group {
                border: 1px solid #444444 !important;
                padding: 12px !important;
            }
        `;
        document.head.appendChild(styleTag);
    }
    
    /**
     * Safely style form fields without disrupting input
     * This uses classnames rather than direct style manipulation
     */
    function safelyStyleFormFields() {
        // Add a class to the body element to help with CSS targeting
        document.body.classList.add('lambo-checkout-page');
        
        // Get only checkout form fields, not footer or other forms
        const checkoutForms = document.querySelectorAll(
            'form.checkout, ' +
            '.woocommerce-checkout form, ' +
            '#customer_details, ' +
            '.woocommerce-checkout-payment'
        );
        
        checkoutForms.forEach(form => {
            // Only target form fields within checkout forms
            const formFields = form.querySelectorAll(
                'input[type="text"], input[type="email"], input[type="tel"], ' +
                'input[type="number"], input[type="password"], textarea, select, ' +
                '.select2-selection'
            );
            
            formFields.forEach(field => {
                if (!field.classList.contains('lambo-styled')) {
                    field.classList.add('lambo-styled');
                    
                    // Add event listeners safely without recreating elements
                    field.addEventListener('focus', handleFieldFocus);
                    field.addEventListener('blur', handleFieldBlur);
                }
            });
        });
        
        // Exempt any footer fields from styling
        document.querySelectorAll('footer input, .footer input, #colophon input, .site-footer input').forEach(field => {
            field.classList.remove('lambo-styled');
            field.classList.add('footer-email-exempt');
        });
    }
    
    /**
     * Handler for field focus events
     */
    function handleFieldFocus(e) {
        e.target.style.borderColor = '#ff0000';
    }
    
    /**
     * Handler for field blur events
     */
    function handleFieldBlur(e) {
        e.target.style.borderColor = '#444444';
    }
    
    /**
     * Hide express checkout options
     */
    function hideExpressCheckout() {
        const expressElements = [
            '.wp-block-woocommerce-checkout-express-payment-block',
            '.wc-block-components-express-payment',
            '.wc-block-components-express-payment--from-saved-payment-methods',
            '.express-payment-section',
            '[class*="express-payment"]'
        ];
        
        expressElements.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.display = 'none';
                element.style.visibility = 'hidden';
                element.style.height = '0';
                element.style.width = '0';
                element.style.overflow = 'hidden';
                element.style.opacity = '0';
                element.style.margin = '0';
                element.style.padding = '0';
            });
        });
    }
    
    /**
     * Hide coupon form
     */
    function hideCouponForm() {
        const couponElements = [
            '.wp-block-woocommerce-checkout-order-summary-coupon-form-block',
            '.woocommerce-checkout .coupon-form',
            '.coupon-form',
            '[class*="coupon-form"]'
        ];
        
        couponElements.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.display = 'none';
            });
        });
    }
    
    /**
     * Configure payment methods
     */
    function configurePayments() {
        // Make sure Stripe payment section is visible and styled correctly
        const stripeForms = document.querySelectorAll('#stripe-payment-data, .wc-stripe-elements-field, .payment_method_stripe, .stripe-card-group');
        stripeForms.forEach(form => {
            if (form) {
                form.style.display = 'block';
                form.style.visibility = 'visible';
                form.style.opacity = '1';
                form.style.backgroundColor = '#333333';
                form.style.border = '1px solid #444444';
            }
        });
        
        // Make sure payment methods section is visible
        const paymentMethods = document.querySelectorAll(
            '.payment_methods, ' +
            '.wc_payment_methods, ' +
            '.woocommerce-checkout-payment, ' +
            '#payment, ' +
            '.wc-stripe-elements-field, ' +
            '.wc-stripe-iban-element-field, ' +
            '#stripe-payment-data, ' +
            '#stripe-card-element, ' +
            '#wc-stripe-cc-form'
        );
        
        paymentMethods.forEach(method => {
            if (method) {
                method.style.display = 'block';
                method.style.visibility = 'visible';
                method.style.opacity = '1';
            }
        });
        
        // Style Stripe elements
        styleStripeElements();
        
        // Handle place order button styling
        stylePlaceOrderButton();
    }
    
    /**
     * Apply styling to place order button
     * This fixes the white flash when clicking
     */
    function stylePlaceOrderButton() {
        const placeOrderBtn = document.querySelector('#place_order');
        if (placeOrderBtn) {
            // Apply direct styling
            placeOrderBtn.style.backgroundColor = '#ff0000';
            placeOrderBtn.style.color = '#ffffff';
            placeOrderBtn.style.textTransform = 'uppercase';
            placeOrderBtn.style.fontWeight = 'bold';
            placeOrderBtn.style.padding = '1rem 2rem';
            placeOrderBtn.style.border = 'none';
            placeOrderBtn.style.width = '100%';
            placeOrderBtn.style.transition = 'none';
            placeOrderBtn.style.webkitAppearance = 'none';
            placeOrderBtn.style.borderRadius = '0';
            placeOrderBtn.style.boxShadow = 'none';
            placeOrderBtn.style.outline = 'none';
            
            // Prevent any default button behavior
            placeOrderBtn.addEventListener('mousedown', function(e) {
                this.style.backgroundColor = '#cc0000';
            });
            
            placeOrderBtn.addEventListener('mouseup', function(e) {
                this.style.backgroundColor = '#ff0000';
            });
            
            // Prevent the default focus outline which can cause flashing
            placeOrderBtn.addEventListener('focus', function(e) {
                this.style.outline = 'none';
                this.style.boxShadow = 'none';
                this.style.backgroundColor = '#ff0000';
            });
            
            // Prevent default form submission behavior to avoid the overlay
            const form = placeOrderBtn.closest('form');
            if (form) {
                placeOrderBtn.addEventListener('click', function(e) {
                    // Let the normal form submission happen but prevent any overlay effects
                    setTimeout(function() {
                        disableWooCommerceOverlay();
                    }, 10);
                });
            }
        }
    }
    
    /**
     * Style Stripe elements
     */
    function styleStripeElements() {
        // Style Stripe fields
        const stripeElements = document.querySelectorAll(
            '.wc-stripe-elements-field, ' +
            '.stripe-card-group, ' +
            '#stripe-payment-data, ' +
            '.wc-stripe-iban-element-field, ' +
            '.StripeElement, ' +
            '.stripe-card-element, ' +
            '.wc-credit-card-form, ' +
            '.payment_box, ' +
            '#add_payment_method #payment div.payment_box, ' +
            '.woocommerce-checkout #payment div.payment_box, ' +
            '#stripe-card-element, ' +
            '#stripe-exp-element, ' +
            '#stripe-cvc-element, ' +
            '.payment_method_stripe, ' +
            '#wc-stripe-cc-form'
        );
        
        stripeElements.forEach(el => {
            if (el) {
                el.style.backgroundColor = '#333333';
                el.style.color = '#ffffff';
                el.style.border = '1px solid #444444';
                el.style.padding = '12px';
                el.style.borderRadius = '0';
            }
        });
    }
    
    /**
     * Disable the WooCommerce overlay that appears when submitting the form
     */
    function disableWooCommerceOverlay() {
        // Remove existing overlay if present
        const existingOverlays = document.querySelectorAll('.blockUI, .blockOverlay, .processing, .blockPage, .blockElement, div[class*="block-overlay"]');
        existingOverlays.forEach(overlay => {
            overlay.remove();
        });
        
        // If jQuery is available (WooCommerce uses it for blockUI)
        if (typeof jQuery !== 'undefined') {
            // Unblock any blocked elements
            jQuery('.blockUI').parent().removeClass('processing').unblock();
            
            // Override the blockUI plugin if it exists
            if (jQuery.fn.block) {
                // Store the original block function
                const originalBlock = jQuery.fn.block;
                
                // Override the block function to do nothing
                jQuery.fn.block = function(opts) {
                    // Just return the element without blocking
                    return this;
                };
                
                // Override the blockUI function 
                if (jQuery.blockUI) {
                    jQuery.blockUI.defaults.overlayCSS.opacity = 0;
                    jQuery.blockUI.defaults.overlayCSS.backgroundColor = 'transparent';
                    
                    // Override the blockUI function
                    const originalBlockUI = jQuery.blockUI;
                    jQuery.blockUI = function(opts) {
                        // Do nothing
                        return;
                    };
                }
            }
            
            // Disable checkout form loading state
            jQuery('form.checkout').removeClass('processing');
            jQuery('.woocommerce-checkout-payment, .woocommerce-checkout').unblock();
        }
        
        // Remove processing class from body and form
        document.body.classList.remove('processing');
        const checkoutForm = document.querySelector('form.checkout');
        if (checkoutForm) {
            checkoutForm.classList.remove('processing');
        }
        
        // Add CSS to prevent any future overlays
        if (!document.getElementById('disable-wc-overlay-style')) {
            const style = document.createElement('style');
            style.id = 'disable-wc-overlay-style';
            style.textContent = `
                .blockUI, .blockOverlay, .blockPage, .blockElement, .processing:before, 
                .woocommerce-checkout-payment-overlay, div[class*="block-overlay"],
                .woocommerce .blockUI.blockOverlay {
                    display: none !important;
                    opacity: 0 !important;
                    background-color: transparent !important;
                    background: none !important;
                    border: none !important;
                    position: static !important;
                    z-index: -1 !important;
                    width: 0 !important;
                    height: 0 !important;
                    overflow: hidden !important;
                }
                
                body.processing * {
                    cursor: default !important;
                }
                
                form.processing {
                    opacity: 1 !important;
                }
                
                /* Override inline styles */
                [style*="block-overlay"], [style*="blockUI"], [style*="blockOverlay"], 
                [style*="z-index: 1000"], [style*="z-index:1000"],
                [style*="position: fixed"], [style*="position:fixed"] {
                    display: none !important;
                    opacity: 0 !important;
                    z-index: -1 !important;
                }
            `;
            document.head.appendChild(style);
        }
        
        // Hook into the submit event of the checkout form
        const checkoutFormEl = document.querySelector('form.checkout, form.woocommerce-checkout');
        if (checkoutFormEl && !checkoutFormEl.dataset.overlayDisabled) {
            checkoutFormEl.dataset.overlayDisabled = 'true';
            
            checkoutFormEl.addEventListener('submit', function(e) {
                // Prevent the default overlay
                setTimeout(function() {
                    disableWooCommerceOverlay();
                }, 10);
            });
            
            // Find the place order button and add direct event listener
            const placeOrderBtn = checkoutFormEl.querySelector('#place_order');
            if (placeOrderBtn) {
                placeOrderBtn.addEventListener('click', function(e) {
                    // Prevent any processing classes or overlays
                    setTimeout(function() {
                        disableWooCommerceOverlay();
                    }, 10);
                });
            }
        }
    }
});