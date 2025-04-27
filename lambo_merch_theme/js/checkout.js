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
    
    // Function to hide express checkout
    const hideExpressCheckout = function() {
        // Hide all possible express checkout elements
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
    };
    
    // Hide express checkout right away
    hideExpressCheckout();
    
    // Hide coupon form in totals
    const hideCouponForm = function() {
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
    };
    
    // Hide coupon form right away
    hideCouponForm();

    // Apply custom styling to input fields
    const styleFormFields = function() {
        // All text input fields
        const inputFields = document.querySelectorAll(
            '.wc-block-components-text-input input[type="text"], ' +
            '.wc-block-components-text-input input[type="email"], ' + 
            '.wc-block-components-text-input input[type="tel"], ' +
            '.wc-block-components-text-input input[type="number"], ' +
            '.woocommerce-input-wrapper input, ' +
            '.woocommerce-input-wrapper textarea, ' +
            '.wc-credit-card-form-card-number, ' +
            '.wc-credit-card-form-card-expiry, ' +
            '.wc-credit-card-form-card-cvc, ' +
            '.wc-block-components-form .wc-block-components-text-input input, ' +
            'input.input-text, ' +
            'input.wc-credit-card-form-card-cvc, ' +
            'input.wc-credit-card-form-card-expiry, ' +
            'input.wc-credit-card-form-card-number, ' +
            '.payment_box input, ' +
            'form.checkout input.input-text, ' +
            '#payment input[type="text"], ' +
            '#payment input[type="email"], ' +
            '#payment input[type="tel"], ' +
            '#payment input[type="number"], ' +
            '#payment input[type="password"], ' +
            'select.select, ' +
            'textarea.input-text, ' +
            '#order_comments, ' +
            'textarea#order_comments'
        );
        
        inputFields.forEach(field => {
            field.style.backgroundColor = '#333333';
            field.style.border = '1px solid #444444';
            field.style.color = '#ffffff';
            field.style.padding = '12px';
            field.style.borderRadius = '0';
            field.style.fontSize = '16px';
            
            // Add focus event handlers for better user experience
            field.addEventListener('focus', function() {
                this.style.borderColor = '#ff0000';
                this.style.boxShadow = 'none';
            });
            
            field.addEventListener('blur', function() {
                this.style.borderColor = '#444444';
            });
        });
        
        // Direct style injection for all inputs on the page
        const styleTag = document.createElement('style');
        styleTag.textContent = `
            /* All form fields */
            input[type="text"],
            input[type="email"],
            input[type="tel"],
            input[type="number"],
            input[type="password"],
            textarea,
            select,
            textarea#order_comments,
            #order_comments,
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
            #shipping_state_field .select2-selection {
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
            .woocommerce form .form-row textarea#order_comments {
                background-color: #333333 !important;
                color: #ffffff !important;
                min-height: 100px;
            }
        `;
        document.head.appendChild(styleTag);
        
        // Credit card specific fields - direct targeting
        // These payment fields are often in iframes or loaded dynamically after page load
        setTimeout(function() {
            const cardFrames = document.querySelectorAll('iframe[id*="card"], iframe[name*="card"], iframe[title*="card"]');
            cardFrames.forEach(frame => {
                try {
                    const frameDoc = frame.contentDocument || frame.contentWindow.document;
                    const cardInputs = frameDoc.querySelectorAll('input');
                    cardInputs.forEach(input => {
                        input.style.backgroundColor = '#333333';
                        input.style.color = '#ffffff';
                        input.style.border = '1px solid #444444';
                    });
                } catch (e) {
                    // Ignore cross-origin errors
                }
            });
        }, 1000);
        
        // Select dropdowns - more comprehensive selectors
        const selectFields = document.querySelectorAll(
            'select, ' +
            'select.select, ' +
            '.woocommerce-input-wrapper select, ' +
            '.country_select, ' + 
            '.state_select, ' +
            '.wc-block-components-select .components-custom-select-control__button, ' +
            '.woocommerce form .form-row .select2-container .select2-selection, ' +
            '#billing_country_field .select2-selection, ' +
            '#shipping_country_field .select2-selection, ' +
            '#billing_state_field .select2-selection, ' +
            '#shipping_state_field .select2-selection, ' +
            '.select2-container--default .select2-selection--single, ' +
            '.select2-container .select2-selection--single, ' +
            '.select2-dropdown'
        );
        
        selectFields.forEach(select => {
            select.style.backgroundColor = '#333333';
            select.style.border = '1px solid #444444';
            select.style.color = '#ffffff';
            select.style.padding = '12px';
            select.style.borderRadius = '0';
            select.style.fontSize = '16px';
        });
    };
    
    // Run immediately
    styleFormFields();
    
    // Set up a MutationObserver to catch dynamically loaded elements
    const bodyObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes && mutation.addedNodes.length > 0) {
                // Check if any of the added nodes are relevant
                for (let i = 0; i < mutation.addedNodes.length; i++) {
                    const node = mutation.addedNodes[i];
                    if (node.nodeType === 1) { // ELEMENT_NODE
                        // Re-run our styling function
                        styleFormFields();
                        
                        // Hide express checkout elements again
                        hideExpressCheckout();
                        
                        // Hide coupon form again
                        hideCouponForm();
                        
                        // Ensure any containers added have black background
                        const containers = document.querySelectorAll('.wc-block-checkout, .wp-block-woocommerce-checkout, #payment, .woocommerce form, .checkout-container');
                        containers.forEach(container => {
                            container.style.backgroundColor = '#000000';
                        });
                    }
                }
            }
        });
    });
    
    // Start observing the document body for DOM changes
    bodyObserver.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // Function to handle Stripe and preserve default payment methods
    const configurePayments = function() {
        // Make sure Stripe payment section is visible and styled correctly
        const stripeForms = document.querySelectorAll('#stripe-payment-data, .wc-stripe-elements-field, .payment_method_stripe, .stripe-card-group');
        stripeForms.forEach(form => {
            if (form) {
                form.style.display = 'block';
                form.style.visibility = 'visible';
                form.style.opacity = '1';
                form.style.backgroundColor = '#333333';
                form.style.border = '1px solid #444444';
                
                // Make all the parent elements visible too
                let parent = form.parentNode;
                while (parent) {
                    parent.style.display = 'block';
                    parent.style.visibility = 'visible';
                    parent.style.opacity = '1';
                    if (parent.classList.contains('payment_box') || 
                        parent.classList.contains('payment_method_stripe')) {
                        parent.style.backgroundColor = '#000000';
                    }
                    parent = parent.parentNode;
                    if (parent === document.body) break;
                }
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
        
        // Ensure the Stripe payment iframe is visible
        const stripeIframes = document.querySelectorAll('iframe[id*="stripe"], iframe[name*="stripe"], iframe[id*="card"], iframe[name*="card"], iframe[title*="card"]');
        stripeIframes.forEach(iframe => {
            iframe.style.display = 'block';
            iframe.style.visibility = 'visible';
            iframe.style.opacity = '1';
            iframe.style.height = 'auto';
            iframe.style.minHeight = '40px';
            
            // Make parent containers visible too
            if (iframe.parentNode) {
                iframe.parentNode.style.display = 'block';
                iframe.parentNode.style.visibility = 'visible';
                iframe.parentNode.style.opacity = '1';
            }
        });
        
        // Style but don't hide the payment block
        const paymentBlock = document.querySelector('.wp-block-woocommerce-checkout-payment-block');
        if (paymentBlock) {
            paymentBlock.style.backgroundColor = '#000000';
            paymentBlock.style.display = 'block';
            paymentBlock.style.visibility = 'visible';
            paymentBlock.style.opacity = '1';
        }
        
        // Style Stripe elements
        styleStripeElements();
    };
    
    // Function to style Stripe elements 
    const styleStripeElements = function() {
        // Style Stripe fields - more comprehensive selectors
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
            el.style.backgroundColor = '#333333';
            el.style.color = '#ffffff';
            el.style.border = '1px solid #444444';
            el.style.padding = '12px';
            el.style.borderRadius = '0';
        });

        // Add style tag to document head for cross-origin iframe targeting
        const stripeStyle = document.createElement('style');
        stripeStyle.textContent = `
            /* Direct element targeting for Stripe */
            .stripe-card-element, 
            .wc-stripe-elements-field,
            .wc-stripe-iban-element-field,
            #stripe-card-element,
            #stripe-exp-element,
            #stripe-cvc-element,
            .StripeElement,
            #payment div.payment_box iframe,
            .payment_box iframe,
            #stripe-payment-data iframe,
            iframe[id*="stripe"],
            iframe[name*="stripe"],
            iframe[id*="card"],
            iframe[name*="card"],
            iframe[title*="card"],
            iframe[title*="stripe"] {
                background-color: #333333 !important;
                color: #ffffff !important;
                border: 1px solid #444444 !important;
            }
            
            /* Target Select2 dropdowns */
            .select2-container--default .select2-selection--single,
            .select2-container--default .select2-results__option,
            .select2-dropdown,
            .select2-search--dropdown .select2-search__field,
            #billing_country_field .select2-selection,
            #shipping_country_field .select2-selection,
            #billing_state_field .select2-selection,
            #shipping_state_field .select2-selection {
                background-color: #333333 !important;
                color: #ffffff !important;
                border-color: #444444 !important;
            }
            
            /* Target order notes field specifically */
            #order_comments,
            textarea#order_comments,
            .woocommerce-checkout textarea#order_comments {
                background-color: #333333 !important;
                color: #ffffff !important;
                border: 1px solid #444444 !important;
            }
        `;
        document.head.appendChild(stripeStyle);
        
        // Target credit card frames
        const frames = document.querySelectorAll('iframe[id*="card"], iframe[name*="card"], iframe[title*="card"], iframe[id*="stripe"], iframe[name*="stripe"]');
        
        frames.forEach(frame => {
            // Style the iframe container
            if (frame.parentNode) {
                frame.parentNode.style.backgroundColor = '#333333';
                frame.parentNode.style.border = '1px solid #444444';
                frame.parentNode.style.padding = '0';
            }
            
            // Style the iframe itself
            frame.style.backgroundColor = '#333333';
            
            try {
                // Try to access the frame's document (only works for same-origin frames)
                const frameDocument = frame.contentDocument || frame.contentWindow.document;
                
                // Add a style element directly to the frame
                let styleEl = frameDocument.getElementById('lambo-card-styling');
                if (!styleEl) {
                    styleEl = frameDocument.createElement('style');
                    styleEl.id = 'lambo-card-styling';
                    styleEl.textContent = `
                        body, html { background: #333333 !important; }
                        input, .InputElement, .InputContainer, .StripeElement, 
                        .StripeElement--empty, .StripeElement--focus, .StripeElement--invalid,
                        div, span, p {
                            background-color: #333333 !important;
                            color: #ffffff !important;
                            border: 1px solid #444444 !important;
                            padding: 12px !important;
                            font-size: 16px !important;
                            border-radius: 0 !important;
                        }
                    `;
                    frameDocument.head.appendChild(styleEl);
                }
                
                // Directly style input elements
                const inputs = frameDocument.querySelectorAll('input, div, span');
                inputs.forEach(input => {
                    input.style.backgroundColor = '#333333';
                    input.style.color = '#ffffff';
                    input.style.border = '1px solid #444444';
                });
            } catch (e) {
                // Ignore cross-origin errors
            }
        });
    };

    // Continuous enforcement of our styles
    const enforceStyles = function() {
        // Reapply all our customizations
        hideExpressCheckout();
        hideCouponForm();
        styleFormFields();
        configurePayments(); // New function to handle payment methods
        
        // Set specific areas to black background
        document.body.style.backgroundColor = '#000000';
        
        const containers = document.querySelectorAll(
            '.wc-block-checkout, ' + 
            '.wp-block-woocommerce-checkout, ' + 
            '.wc-block-components-sidebar, ' + 
            '.wc-block-components-main, ' +
            '.woocommerce-checkout form, ' +
            '.woocommerce-checkout #payment, ' + 
            '.wc-credit-card-form, ' + 
            '.payment_box, ' +
            '.checkout-container, ' +
            '.woocommerce, ' +
            '.woocommerce-checkout'
        );
        
        containers.forEach(container => {
            container.style.backgroundColor = '#000000';
            container.style.color = '#ffffff';
        });
        
        // IMPORTANT: Ensure footer email field is NOT styled
        const footerEmailInputs = document.querySelectorAll('footer input[type="email"], .footer input[type="email"], #colophon input[type="email"], .site-footer input[type="email"]');
        footerEmailInputs.forEach(input => {
            input.style.backgroundColor = '';
            input.style.color = '';
            input.style.border = '';
            input.classList.add('footer-email-exempt');
        });
        
        // CRITICAL: Make sure Stripe payment elements are always visible
        const stripeElements = document.querySelectorAll('#payment, #stripe-payment-data, .wc-stripe-elements-field, .payment_method_stripe, .stripe-card-group, iframe[id*="stripe"], iframe[name*="stripe"], iframe[id*="card"], iframe[name*="card"], iframe[title*="card"]');
        stripeElements.forEach(el => {
            el.style.display = 'block';
            el.style.visibility = 'visible';
            el.style.opacity = '1';
            
            // Set z-index to ensure visibility
            if (el.style.zIndex < 100) {
                el.style.zIndex = '100';
            }
            
            // Make sure all parent elements are visible too
            let parent = el.parentNode;
            while (parent && parent !== document.body) {
                parent.style.display = 'block';
                parent.style.visibility = 'visible';
                parent.style.opacity = '1';
                parent = parent.parentNode;
            }
        });
    };
    
    // Run once at start
    enforceStyles();
    
    // Then run periodically to catch anything that might have changed
    setInterval(enforceStyles, 1000);
});