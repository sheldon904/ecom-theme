/**
 * Link Payment Button Diagnostic Script
 * 
 * This script helps identify where the "Pay with Link" button is coming from
 * and provides detailed information for debugging.
 * 
 * Usage: Add this script to your browser's console on the product or checkout page
 */

(function() {
    console.log("=== Link Payment Button Diagnostic ===");
    
    function findLinkElements() {
        const linkSelectors = [
            // Direct selectors
            '[data-payment-method="stripe_link"]',
            '[data-payment-method="link"]', 
            '[data-testid="link-button"]',
            '.stripe-link-button',
            '.wcpay-link-button',
            '.wc-stripe-link-button',
            '.woocommerce-payments-link-button',
            
            // WooCommerce Payments specific
            '.wcpay-express-checkout-link',
            '.wcpay-payment-request-link',
            '[data-wcpay-method="link"]',
            
            // Generic patterns
            '[class*="link-button"]:not([class*="paypal"]):not([class*="apple"]):not([class*="google"])',
            '[id*="link-button"]:not([id*="paypal"]):not([id*="apple"]):not([id*="google"])',
            '[aria-label*="Pay with Link"]',
            '[aria-label*="Link"][aria-label*="payment"]',
            
            // Stripe Elements
            '.Payment-RequestButton--Link',
            '[data-express-checkout-type="link"]',
            '[data-element-type="linkButton"]',
            '[data-express-payment-type="stripe_link"]'
        ];
        
        let foundElements = [];
        
        linkSelectors.forEach(selector => {
            try {
                const elements = document.querySelectorAll(selector);
                elements.forEach(el => {
                    foundElements.push({
                        element: el,
                        selector: selector,
                        tagName: el.tagName,
                        className: el.className,
                        id: el.id,
                        innerHTML: el.innerHTML.substring(0, 200),
                        parentElement: el.parentElement
                    });
                });
            } catch(e) {
                console.warn("Error with selector:", selector, e);
            }
        });
        
        return foundElements;
    }
    
    function findTextBasedElements() {
        const allElements = document.querySelectorAll('*:not(script):not(style)');
        let textElements = [];
        
        allElements.forEach(el => {
            if (el.textContent && 
                (el.textContent.includes('Pay with Link') || 
                 el.textContent.includes('Link payment') ||
                 el.textContent.includes('Stripe Link')) &&
                !el.textContent.includes('Apple') &&
                !el.textContent.includes('Google') &&
                !el.textContent.includes('PayPal')) {
                
                textElements.push({
                    element: el,
                    textContent: el.textContent.trim(),
                    tagName: el.tagName,
                    className: el.className,
                    id: el.id
                });
            }
        });
        
        return textElements;
    }
    
    function checkPluginInfo() {
        console.log("\n=== Plugin Detection ===");
        
        // Check for WooCommerce Payments
        if (window.wcpayStripe) {
            console.log("✓ WooCommerce Payments detected");
            console.log("wcpayStripe object:", window.wcpayStripe);
        }
        
        // Check for Stripe
        if (window.Stripe) {
            console.log("✓ Stripe.js detected");
            console.log("Stripe version:", window.Stripe.version || "Unknown");
        }
        
        // Check for WooCommerce
        if (window.wc_checkout_params) {
            console.log("✓ WooCommerce checkout detected");
        }
        
        // Check for payment method configurations
        const paymentMethods = document.querySelectorAll('.payment_method');
        console.log(`Found ${paymentMethods.length} payment methods:`, paymentMethods);
    }
    
    function analyzeCSS() {
        console.log("\n=== CSS Analysis ===");
        
        // Check if our CSS rules are applied
        const testElement = document.createElement('div');
        testElement.className = 'wcpay-link-button';
        testElement.style.position = 'absolute';
        testElement.style.top = '-9999px';
        document.body.appendChild(testElement);
        
        const computedStyle = window.getComputedStyle(testElement);
        console.log("Link button display style:", computedStyle.display);
        console.log("Link button visibility:", computedStyle.visibility);
        
        document.body.removeChild(testElement);
        
        // Check for our custom styles
        const styleSheets = Array.from(document.styleSheets);
        let foundLinkRules = [];
        
        styleSheets.forEach(sheet => {
            try {
                const rules = Array.from(sheet.cssRules || sheet.rules || []);
                rules.forEach(rule => {
                    if (rule.selectorText && 
                        (rule.selectorText.includes('link-button') || 
                         rule.selectorText.includes('wcpay-link'))) {
                        foundLinkRules.push({
                            selector: rule.selectorText,
                            cssText: rule.cssText
                        });
                    }
                });
            } catch(e) {
                // Ignore CORS errors
            }
        });
        
        console.log("Found Link-related CSS rules:", foundLinkRules);
    }
    
    function checkNetworkRequests() {
        console.log("\n=== Network Monitoring ===");
        
        // Override fetch to monitor requests
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            const url = args[0];
            if (typeof url === 'string' && 
                (url.includes('link') || url.includes('express-checkout')) &&
                !url.includes('apple') && !url.includes('google')) {
                console.log("Intercepted Link-related request:", url);
            }
            return originalFetch.apply(this, args);
        };
        
        // Override XMLHttpRequest
        const originalXHR = window.XMLHttpRequest.prototype.open;
        window.XMLHttpRequest.prototype.open = function(method, url) {
            if (url && (url.includes('link') || url.includes('express-checkout')) && 
                !url.includes('apple') && !url.includes('google')) {
                console.log("Intercepted Link-related XHR:", url);
            }
            return originalXHR.apply(this, arguments);
        };
        
        console.log("Network monitoring enabled. Link-related requests will be logged.");
    }
    
    // Run diagnostics
    console.log("\n=== Starting Diagnostic ===");
    
    checkPluginInfo();
    
    const linkElements = findLinkElements();
    console.log("\n=== Direct Link Elements Found ===");
    console.log(`Found ${linkElements.length} elements:`, linkElements);
    
    const textElements = findTextBasedElements();
    console.log("\n=== Text-based Link Elements Found ===");
    console.log(`Found ${textElements.length} elements:`, textElements);
    
    analyzeCSS();
    checkNetworkRequests();
    
    // Set up monitoring for dynamically added elements
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) { // Element node
                    const newLinkElements = findLinkElements();
                    const newTextElements = findTextBasedElements();
                    
                    if (newLinkElements.length > linkElements.length || 
                        newTextElements.length > textElements.length) {
                        console.log("\n=== NEW LINK ELEMENTS DETECTED ===");
                        console.log("New elements:", [...newLinkElements, ...newTextElements]);
                    }
                }
            });
        });
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
    
    console.log("\n=== Diagnostic Complete ===");
    console.log("Monitoring for dynamic Link elements...");
    
    // Expose functions globally for manual testing
    window.linkDiagnostic = {
        findLinkElements,
        findTextBasedElements,
        checkPluginInfo,
        analyzeCSS
    };
    
    console.log("Use window.linkDiagnostic for manual testing");
})();