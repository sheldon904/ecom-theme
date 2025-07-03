<?php
/**
 * The template for displaying the footer
 *
 * @package Lambo_Merch
 */

// Handle footer newsletter form submission
$footer_form_message = '';
$footer_form_success = false;

if ($_POST && isset($_POST['footer_newsletter_nonce']) && wp_verify_nonce($_POST['footer_newsletter_nonce'], 'footer_newsletter_action')) {
    $email = sanitize_email($_POST['email']);
    
    if (!empty($email) && is_email($email)) {
        // Get admin email
        $admin_email = get_option('admin_email');
        
        // Email subject and headers
        $subject = 'New Newsletter Subscription from ' . get_bloginfo('name');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Email body
        $message = '<html><body>';
        $message .= '<h2>New Newsletter Subscription</h2>';
        $message .= '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
        $message .= '<p><strong>Date:</strong> ' . date('Y-m-d H:i:s') . '</p>';
        $message .= '<p><strong>Source:</strong> Footer Newsletter Form</p>';
        $message .= '<p><strong>Page:</strong> ' . esc_url($_SERVER['HTTP_REFERER']) . '</p>';
        $message .= '</body></html>';
        
        // Send email
        if (wp_mail($admin_email, $subject, $message, $headers)) {
            $footer_form_success = true;
            $footer_form_message = 'Thanks for subscribing!';
            // Clear the form by unsetting POST data on success
            unset($_POST['email']);
        } else {
            $footer_form_message = 'Error sending subscription. Please try again.';
        }
    } else {
        $footer_form_message = 'Please enter a valid email address.';
    }
}

// Include Mobile_Detect library if not already included
if (!class_exists('Mobile_Detect')) {
    require_once get_template_directory() . '/inc/mobile-detect.php';
}

$detect = new Mobile_Detect;
// Check if user is on a mobile device like an iPhone
$is_mobile = $detect->isMobile() && !$detect->isTablet();
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                <?php if ($is_mobile): // Mobile footer layout ?>
                
                <div class="row">
                    <div class="col-12 text-center">
                        <!-- Mobile footer logo at 25% size -->
                        <div class="footer-logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link" rel="home">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo/LM_logo_footer.png" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="custom-logo">
                            </a>
                        </div>
                        
                        <!-- Vertically stacked navigation -->
                        <div class="footer-nav text-center">
                            <ul>
                            <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop', 'lambo-merch'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About', 'lambo-merch'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'lambo-merch'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/my-account')); ?>"><?php esc_html_e('My Account', 'lambo-merch'); ?></a></li>
                            <li><a href="/favs-2/"><?php esc_html_e('Favs / Wishlist', 'lambo-merch'); ?></a></li>
                            </ul>
                        </div>
                        
                        <!-- Subscribe section -->
                        <div class="subscribe-section">
                            <h3 class="subscribe-title"><?php esc_html_e('SUBSCRIBE FOR DISCOUNTS & DROPS', 'lambo-merch'); ?></h3>
                            
                            <?php if (!empty($footer_form_message)): ?>
                                <div style="margin-bottom: 15px; padding: 10px; border-radius: 5px; text-align: center; <?php echo $footer_form_success ? 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;' : 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'; ?>">
                                    <?php echo esc_html($footer_form_message); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="email-signup">
                                <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" class="newsletter-form">
                                    <?php wp_nonce_field('footer_newsletter_action', 'footer_newsletter_nonce'); ?>
                                    <div class="email-input-wrap">
                                        <div class="email-placeholder">
                                            <span><?php esc_html_e('Enter your email', 'lambo-merch'); ?></span>
                                        </div>
                                        <input type="email" name="email" placeholder="" <?php echo is_checkout() ? 'class="footer-email-exempt"' : ''; ?> required value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" aria-label="Email for newsletter" style="min-height: 48px; min-width: 48px;">
                                        <button type="submit" class="arrow-btn" aria-label="Submit email for newsletter" style="min-height: 48px; min-width: 48px;">
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/arrow.png" alt="Submit">
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Social icons in a row -->
                            <h3 class="follow-title"><?php esc_html_e('FOLLOW', 'lambo-merch'); ?></h3>
                            <div class="social-icons">
                                <a href="https://www.instagram.com/bavarianrennsport/" target="_blank" class="social-icon facebook-instagram">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/facebook_instagram.png" alt="Facebook/Instagram">
                                </a>
                                <a href="https://www.youtube.com/channel/UC7z8YdJu3WhzR7jli6qTIqQ" target="_blank" class="social-icon youtube">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/youtube.png" alt="YouTube">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php else: // Desktop footer layout ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-content-wrapper">
                            <div class="footer-logo">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="custom-logo-link" rel="home">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/logo/LM_logo_footer.png" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="custom-logo">
                                </a>
                            </div>
                            
                            <div class="footer-nav">
                                <ul>
                                    <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop', 'lambo-merch'); ?></a></li>
                                    <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About', 'lambo-merch'); ?></a></li>
                                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'lambo-merch'); ?></a></li>
                                    <li><a href="<?php echo esc_url(home_url('/my-account')); ?>"><?php esc_html_e('My Account', 'lambo-merch'); ?></a></li>
                                    <li><a href="/favs-2/"><?php esc_html_e('Favs / Wishlist', 'lambo-merch'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <!-- Intentionally left blank for spacing -->
                    </div>
                    
                    <div class="col-md-4">
                        <div class="subscribe-section">
                            <h3 class="subscribe-title"><center><?php esc_html_e('SUBSCRIBE FOR DISCOUNTS & DROPS', 'lambo-merch'); ?></center></h3>
                            
                            <?php if (!empty($footer_form_message)): ?>
                                <div style="margin-bottom: 15px; padding: 10px; border-radius: 5px; text-align: center; <?php echo $footer_form_success ? 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;' : 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'; ?>">
                                    <?php echo esc_html($footer_form_message); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="email-signup">
                                <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post" class="newsletter-form">
                                    <?php wp_nonce_field('footer_newsletter_action', 'footer_newsletter_nonce'); ?>
                                    <div class="email-input-wrap">
                                        <div class="email-placeholder">
                                            <span><?php esc_html_e('Enter your email', 'lambo-merch'); ?></span>
                                        </div>
                                        <input type="email" name="email" placeholder="" <?php echo is_checkout() ? 'class="footer-email-exempt"' : ''; ?> required value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>" aria-label="Email for newsletter" style="min-height: 48px; min-width: 48px;">
                                        <button type="submit" class="arrow-btn" aria-label="Submit email for newsletter" style="min-height: 48px; min-width: 48px;">
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/arrow.png" alt="Submit">
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <h3 class="follow-title"><center><?php esc_html_e('FOLLOW', 'lambo-merch'); ?></center></h3>
                            <div class="social-icons">
                                <a href="https://www.instagram.com/bavarianrennsport/" target="_blank" class="social-icon facebook-instagram">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/facebook_instagram.png" alt="Facebook/Instagram">
                                </a>
                                <a href="https://www.youtube.com/channel/UC7z8YdJu3WhzR7jli6qTIqQ" target="_blank" class="social-icon youtube">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/youtube.png" alt="YouTube">
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- .row -->
                
                <?php endif; ?>
            </div><!-- .container -->
        </div><!-- .footer-widgets -->
        
        <div class="footer-bottom">
            <!-- Image removed - replaced with CSS background color -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>
                                &copy; <?php echo date('Y'); ?> LAMBO MERCH |
                                <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php esc_html_e('PRIVACY POLICY', 'lambo-merch'); ?></a> |
                                <a href="<?php echo esc_url(home_url('/terms-of-use')); ?>"><?php esc_html_e('TERMS OF USE', 'lambo-merch'); ?></a> |
                                <?php esc_html_e('WEBSITE DESIGN BY', 'lambo-merch'); ?> <a href="https://mediamade.fresh" target="_blank" class="media-made"><?php esc_html_e('MEDIA MADE FRESH', 'lambo-merch'); ?></a>
                            </p>
                        </div>
                    </div>
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .footer-bottom -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Global notification container for wishlist messages -->
<div class="lambo-wishlist-message" style="display: none;"></div>

<?php wp_footer(); ?>

<script>
// Only fix the footer email field on the checkout page
document.addEventListener('DOMContentLoaded', function() {
    if (document.body.classList.contains('woocommerce-checkout')) {
        // Fix for footer email input visibility on checkout page
        function fixFooterEmailInput() {
            const footerEmailInputs = document.querySelectorAll('.site-footer input[type="email"], .email-input-wrap input[type="email"], footer input[type="email"]');
            footerEmailInputs.forEach(function(input) {
                input.style.backgroundColor = 'transparent';
                input.style.color = '#ffffff';
                input.style.display = 'inline-block';
                input.style.visibility = 'visible';
                input.style.opacity = '1';
                input.classList.add('footer-email-exempt');
            });
        }
        
        // Run immediately and then periodically
        fixFooterEmailInput();
        setInterval(fixFooterEmailInput, 1000);
    }
});
</script>

</body>
</html>

<style>
/* Specific fix ONLY for checkout page footer email input */
body.woocommerce-checkout .site-footer input[type="email"],
body.woocommerce-checkout footer input[type="email"],
body.woocommerce-checkout .email-input-wrap input[type="email"] {
    background-color: transparent !important;
    color: #ffffff !important;
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    border: none !important;
    width: auto !important;
    height: auto !important;
    padding: 0 !important;
    margin: 0 !important;
    text-indent: 0 !important;
}

/* Only apply this dark background to checkout page */
body.woocommerce-checkout .email-input-wrap {
    background-color: #0b0c10 !important;
}

@media (max-width: 767px) {
    /* Existing mobile styles... */
    
    /* Increase line height for mobile footer links */
    .footer-nav li {
        margin-bottom: -2%; /* Set negative margin as requested */
    }
    
    .footer-nav a {
        line-height: 0.5; /* Add this line to increase spacing */
        padding: 8px 0; /* Add padding for larger touch target */
        font-size: 18px; /* Slightly larger font size */
        display: inline-block; /* Makes the padding work properly */
    }
        /* Footer logo adjustments */
    .footer-logo {
        margin-bottom: -1%;
        margin-top: -10%;
    }

    /* Subscription section spacing */
    .subscribe-section {
        margin-top: 5%;
    }

    /* Copyright text size */
    .copyright {
        font-size: 10px;
    }
    .footer-logo img {
    max-width: 50%; /* Changed from 25% */
    }
    .subscribe-title {
    font-size: 25px;
    }   
    .social-icon img,
    .facebook-instagram img {
        height: 65px;
        max-height: 65px;
    }
    .youtube img {
    height: 70px;
    max-height: 70px;
    }
    .footer-bottom {
    margin-top: -10px;
    }
}    


</style>