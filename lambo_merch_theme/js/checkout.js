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
    
    // Instead of using MutationObserver which causes the form jumping issue,
    // periodically check for new elements that need styling
    // This runs less frequently and doesn't interfere with typing
    setInterval(function() {
        safelyStyleFormFields();
        hideExpressCheckout();
        hideCouponForm();
        configurePayments();
    }, 2000); // Check every 2 seconds - slow enough not to cause issues
    
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
        // Add a class to all form fields that need styling
        const formFields = document.querySelectorAll(
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
});