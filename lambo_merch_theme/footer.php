<?php
/**
 * The template for displaying the footer
 *
 * @package Lambo_Merch
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <div class="container">
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
                                    <li><a href="<?php echo esc_url(home_url('/wishlist')); ?>"><?php esc_html_e('Favs / Wishlist', 'lambo-merch'); ?></a></li>
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
                            <div class="email-signup">
                                <form action="#" method="post" class="newsletter-form">
                                    <div class="email-input-wrap">
                                        <div class="email-placeholder">
                                            <span><?php esc_html_e('Enter your email', 'lambo-merch'); ?></span>
                                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icons/arrow.png" alt="Submit" width="20">
                                        </div>
                                        <input type="email" name="email" placeholder="" required>
                                        <button type="submit" class="arrow-btn" style="display:none;">
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
            </div><!-- .container -->
        </div><!-- .footer-widgets -->
        
        <div class="footer-bottom">
            <!-- Image removed - replaced with CSS background color -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>
                                &copy; <?php echo date('Y'); ?> BAVARIAN RENNSPORT |
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

<?php wp_footer(); ?>

</body>
</html>