document.addEventListener('DOMContentLoaded', function() {
    // Only run on checkout page
    if (!document.body.classList.contains('woocommerce-checkout') && 
        !document.querySelector('.woocommerce-checkout') &&
        !document.querySelector('.wp-block-woocommerce-checkout')) {
        return;
    }
    
    // Set the main background to black - only for checkout page
    document.body.style.backgroundColor = '#000000';
    
    // Apply global styles for the page
    applyGlobalStyles();
    
    // Apply initial styling to form fields without affecting user input
    safelyStyleFormFields();
    
    // Only hide coupon form
    hideCouponForm();
    
    // Ensure express checkout elements are visible
    ensureExpressCheckoutVisible();
    
    // Instead of using MutationObserver which causes the form jumping issue,
    // periodically check for new elements that need styling
    // This runs less frequently and doesn't interfere with typing
    setInterval(function() {
        safelyStyleFormFields();
        hideCouponForm();
        ensureExpressCheckoutVisible();
    }, 2000); // Check every 2 seconds - slow enough not to cause issues

    // Only fix the footer email field on checkout page
    const footerEmailInputs = document.querySelectorAll('footer input[type="email"], .footer input[type="email"], #colophon input[type="email"], .site-footer input[type="email"], .email-input-wrap input[type="email"]');
    footerEmailInputs.forEach(function(input) {
        // Only apply these fixes on the checkout page
        if (document.body.classList.contains('woocommerce-checkout')) {
            // Reset any styling that might have been applied
            input.style.backgroundColor = 'transparent';
            input.style.color = '#ffffff';
            input.style.border = 'none';
            input.style.padding = '0';
            input.style.borderRadius = '0';
            input.style.boxShadow = 'none';
            input.style.width = 'auto';
            input.style.height = 'auto';
            input.style.margin = '0';
            input.style.display = 'inline-block';
            input.style.visibility = 'visible';
            input.style.opacity = '1';
            input.style.textIndent = '0';
            
            // Add a specific class to identify it
            input.classList.add('footer-email-exempt');
            
            // Add a mutation observer to ensure styles don't get reapplied
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'style') {
                        // Only reapply styles on the checkout page
                        if (document.body.classList.contains('woocommerce-checkout')) {
                            input.style.backgroundColor = 'transparent';
                            input.style.color = '#ffffff';
                            input.style.border = 'none';
                            input.style.padding = '0';
                            input.style.borderRadius = '0';
                            input.style.boxShadow = 'none';
                            input.style.width = 'auto';
                            input.style.height = 'auto';
                            input.style.margin = '0';
                            input.style.display = 'inline-block';
                            input.style.visibility = 'visible';
                            input.style.opacity = '1';
                            input.style.textIndent = '0';
                        }
                    }
                });
            });
            observer.observe(input, { attributes: true });
        }
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
            
            /* Hide only coupon form */
            .woocommerce-checkout .coupon-form,
            .woocommerce-checkout [class*="coupon-form"] {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                width: 0 !important;
                overflow: hidden !important;
                opacity: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            /* Ensure Express Checkout elements are visible */
            .wc-stripe-payment-request-wrapper,
            .wc-stripe-payment-request-button-separator,
            .payment-request-button,
            .apple-pay-button,
            .google-pay-button,
            .express-checkout-section,
            .express-checkout-container,
            .wp-block-woocommerce-checkout-express-payment-block,
            .wc-block-components-express-payment,
            [class*="wc-stripe-payment-request-"],
            [class*="apple-pay-"],
            [class*="google-pay-"],
            div[class*="express-payment"] {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                height: auto !important;
                width: auto !important;
                overflow: visible !important;
                margin: 10px auto !important;
                max-width: 750px !important;
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
    
    /**
     * This function ensures express checkout buttons are visible
     * It specifically targets payment request buttons from Stripe
     */
    function ensureExpressCheckoutVisible() {
        // Target all express checkout elements
        const expressTargets = [
            '.wc-stripe-payment-request-wrapper',
            '.wc-stripe-payment-request-button-separator',
            '.payment-request-button',
            '.apple-pay-button',
            '.google-pay-button',
            '.express-checkout-section',
            '.express-checkout-container',
            '.wp-block-woocommerce-checkout-express-payment-block',
            '.wc-block-components-express-payment',
            '[class*="wc-stripe-payment-request-"]',
            '[class*="apple-pay-"]',
            '[class*="google-pay-"]',
            'div[class*="express-payment"]'
        ];
        
        // Select all elements matching these targets
        const expressElements = document.querySelectorAll(expressTargets.join(', '));
        
        // Make each element fully visible
        expressElements.forEach(element => {
            if (element) {
                // Force visibility
                element.style.display = 'block';
                element.style.visibility = 'visible';
                element.style.opacity = '1';
                element.style.height = 'auto';
                element.style.width = 'auto';
                element.style.overflow = 'visible';
                element.style.margin = '10px auto';
                element.style.maxWidth = '750px';
                
                // Remove any classes that might hide elements
                element.classList.remove('hidden', 'hide', 'disabled', 'collapsed');
                
                // Check parent elements too
                let parent = element.parentElement;
                while (parent && parent.tagName !== 'BODY') {
                    parent.style.display = 'block';
                    parent.style.visibility = 'visible';
                    parent.style.opacity = '1';
                    parent.style.height = 'auto';
                    parent.style.overflow = 'visible';
                    parent = parent.parentElement;
                }
            }
        });
        
        // If no express elements found, add a console message
        if (expressElements.length === 0) {
            console.log('Express checkout elements not found yet. Will retry.');
        }
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
    
    // We don't need configurePayments anymore as it's been replaced by stylePaymentSection
});
