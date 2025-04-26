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
            'textarea.input-text'
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
        
        // Select dropdowns
        const selectFields = document.querySelectorAll(
            'select.select, ' +
            '.woocommerce-input-wrapper select, ' +
            '.wc-block-components-select .components-custom-select-control__button'
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
    
    // Function to handle Stripe and remove default payment methods
    const configurePayments = function() {
        // Remove default payment methods
        const paymentOptions = document.querySelectorAll('.wc-block-components-radio-control-accordion-option');
        paymentOptions.forEach(option => {
            option.style.display = 'none';
        });
        
        // Remove default payment block entirely
        const paymentBlock = document.querySelector('.wp-block-woocommerce-checkout-payment-block');
        if (paymentBlock) {
            const stripeForm = document.querySelector('#stripe-payment-data, .payment_method_stripe');
            
            // If we have a Stripe form, move it outside
            if (stripeForm) {
                // Create a container for Stripe
                const stripeContainer = document.createElement('div');
                stripeContainer.id = 'custom-stripe-container';
                stripeContainer.style.backgroundColor = '#000000';
                stripeContainer.style.padding = '20px';
                stripeContainer.style.marginBottom = '20px';
                
                // Add a title
                const stripeTitle = document.createElement('h3');
                stripeTitle.innerText = 'Payment Information';
                stripeTitle.style.color = '#ffffff';
                stripeTitle.style.marginBottom = '15px';
                stripeContainer.appendChild(stripeTitle);
                
                // Move the Stripe form
                stripeContainer.appendChild(stripeForm.cloneNode(true));
                
                // Insert before the payment block or replace it
                if (paymentBlock.parentNode) {
                    paymentBlock.parentNode.insertBefore(stripeContainer, paymentBlock);
                    paymentBlock.style.display = 'none';
                }
            }
        }
        
        // Style Stripe elements
        styleStripeElements();
    };
    
    // Function to style Stripe elements 
    const styleStripeElements = function() {
        // Style Stripe fields
        const stripeElements = document.querySelectorAll('.wc-stripe-elements-field, .stripe-card-group, #stripe-payment-data');
        stripeElements.forEach(el => {
            el.style.backgroundColor = '#333333';
            el.style.color = '#ffffff';
            el.style.border = '1px solid #444444';
            el.style.padding = '12px';
            el.style.borderRadius = '0';
        });
        
        // Target credit card frames by any attributes that might identify them
        const frames = document.querySelectorAll('iframe[id*="card"], iframe[name*="card"], iframe[title*="card"], iframe[id*="stripe"], iframe[name*="stripe"]');
        
        frames.forEach(frame => {
            try {
                // Try to access the frame's document (only works for same-origin frames)
                const frameDocument = frame.contentDocument || frame.contentWindow.document;
                
                // Add a style element directly to the frame
                let styleEl = frameDocument.getElementById('lambo-card-styling');
                if (!styleEl) {
                    styleEl = frameDocument.createElement('style');
                    styleEl.id = 'lambo-card-styling';
                    styleEl.textContent = `
                        body, html { background: transparent !important; }
                        input, .InputElement, .InputContainer {
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
                const inputs = frameDocument.querySelectorAll('input');
                inputs.forEach(input => {
                    input.style.backgroundColor = '#333333';
                    input.style.color = '#ffffff';
                    input.style.border = '1px solid #444444';
                    input.style.padding = '12px';
                    input.style.borderRadius = '0';
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
    };
    
    // Run once at start
    enforceStyles();
    
    // Then run periodically to catch anything that might have changed
    setInterval(enforceStyles, 1000);
});