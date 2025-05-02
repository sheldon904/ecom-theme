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

    // Make sure footer email field is not affected
    const footerEmailInputs = document.querySelectorAll('footer input[type="email"], .footer input[type="email"], #colophon input[type="email"], .site-footer input[type="email"]');
    footerEmailInputs.forEach(function(input) {
        // Reset any styling that might have been applied
        input.style.backgroundColor = '';
        input.style.color = '';
        input.style.border = '';
        input.style.borderColor = '';
        input.style.padding = '';
        input.style.borderRadius = '';
        input.style.fontSize = '';
        input.style.lineHeight = '';
        input.style.boxShadow = '';
        input.style.width = '';
        input.style.height = '';
        input.style.margin = '';
        input.removeAttribute('style');
        
        // Add a specific class to identify it
        input.classList.add('footer-email-exempt');
        
        // Add a mutation observer to ensure styles don't get reapplied
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'style') {
                    input.removeAttribute('style');
                }
            });
        });
        observer.observe(input, { attributes: true });
    });

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
            .woocommerce-checkout input[type="text"]:not(.footer-email-exempt),
            .woocommerce-checkout input[type="email"]:not(.footer-email-exempt),
            .woocommerce-checkout input[type="tel"]:not(.footer-email-exempt),
            .woocommerce-checkout input[type="number"]:not(.footer-email-exempt),
            .woocommerce-checkout input[type="password"]:not(.footer-email-exempt),
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
            .woocommerce-checkout input:not(.footer-email-exempt):focus,
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
    
    function handleFieldFocus(e) {
        e.target.style.borderColor = '#ff0000';
    }
    function handleFieldBlur(e) {
        e.target.style.borderColor = '#444444';
    }
    
    function hideExpressCheckout() {
        const expressElements = [
            '.wp-block-woocommerce-checkout-express-payment-block',
            '.wc-block-components-express-payment',
            '.wc-block-components-express-payment--from-saved-payment-methods',
            '.express-payment-section',
            '[class*="express-payment"]'
        ];
        expressElements.forEach(selector => {
            document.querySelectorAll(selector).forEach(element => {
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
    
    function hideCouponForm() {
        const couponElements = [
            '.wp-block-woocommerce-checkout-order-summary-coupon-form-block',
            '.woocommerce-checkout .coupon-form',
            '.coupon-form',
            '[class*="coupon-form"]'
        ];
        couponElements.forEach(selector => {
            document.querySelectorAll(selector).forEach(element => {
                element.style.display = 'none';
            });
        });
    }
    
    function configurePayments() {
        // Additional payment method configurations can go here if needed
    }
});
