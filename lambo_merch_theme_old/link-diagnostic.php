<?php
/**
 * Diagnostic script to identify where Pay with Link is coming from
 * Add ?debug_link=1 to your product page URL to run this
 */

if (isset($_GET['debug_link']) && $_GET['debug_link'] == '1') {
    add_action('wp_footer', 'lambo_merch_link_diagnostic');
}

function lambo_merch_link_diagnostic() {
    ?>
    <script>
    console.log('=== LINK PAYMENT DIAGNOSTIC ===');
    
    // Check active plugins
    if (typeof wc_stripe_payment_request_params !== 'undefined') {
        console.log('WooCommerce Stripe detected:', wc_stripe_payment_request_params);
    }
    
    if (typeof wcpay_config !== 'undefined') {
        console.log('WooCommerce Payments detected:', wcpay_config);
    }
    
    // Find all Link-related elements
    const linkElements = document.querySelectorAll('*');
    const foundElements = [];
    
    linkElements.forEach(el => {
        const text = el.textContent || '';
        const className = el.className || '';
        const id = el.id || '';
        const dataAttrs = Array.from(el.attributes).filter(attr => attr.name.startsWith('data-'));
        
        if (text.toLowerCase().includes('pay with link') || 
            text.toLowerCase().includes('link pay') ||
            className.toLowerCase().includes('link') ||
            id.toLowerCase().includes('link') ||
            dataAttrs.some(attr => attr.value.toLowerCase().includes('link'))) {
            
            foundElements.push({
                element: el,
                tag: el.tagName,
                text: text.slice(0, 50),
                className: className,
                id: id,
                dataAttrs: dataAttrs.map(attr => attr.name + '=' + attr.value)
            });
        }
    });
    
    console.log('Found Link-related elements:', foundElements);
    
    // Check for payment buttons specifically
    const paymentButtons = document.querySelectorAll('button, [role="button"], .payment-method, .express-payment');
    const linkPaymentButtons = [];
    
    paymentButtons.forEach(btn => {
        if (btn.textContent.toLowerCase().includes('link') && 
            !btn.textContent.toLowerCase().includes('apple') &&
            !btn.textContent.toLowerCase().includes('google')) {
            linkPaymentButtons.push(btn);
        }
    });
    
    console.log('Link payment buttons found:', linkPaymentButtons);
    
    // Check for Stripe objects
    if (window.Stripe) {
        console.log('Stripe object available:', window.Stripe);
    }
    
    // Check WooCommerce data
    if (window.wc_add_to_cart_params) {
        console.log('WooCommerce params:', window.wc_add_to_cart_params);
    }
    
    console.log('=== END DIAGNOSTIC ===');
    </script>
    <?php
}
?>