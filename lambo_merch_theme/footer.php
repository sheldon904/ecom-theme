<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
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
						<div class="footer-logo">
							<?php
							if ( has_custom_logo() ) :
								the_custom_logo();
							else :
							?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="custom-logo">
								</a>
							<?php endif; ?>
						</div>
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
							<div class="footer-widget">
								<?php dynamic_sidebar( 'footer-1' ); ?>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="col-md-4">
						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
							<div class="footer-widget">
								<?php dynamic_sidebar( 'footer-2' ); ?>
							</div>
						<?php else : ?>
							<div class="footer-widget">
								<h3 class="footer-widget-title"><?php esc_html_e( 'Shop', 'lambo-merch' ); ?></h3>
								<ul>
									<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Shop', 'lambo-merch' ); ?></a></li>
										<li><a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>"><?php esc_html_e( 'Cart', 'lambo-merch' ); ?></a></li>
										<li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My Account', 'lambo-merch' ); ?></a></li>
									<?php endif; ?>
									<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'lambo-merch' ); ?></a></li>
									<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'lambo-merch' ); ?></a></li>
								</ul>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="col-md-4">
						<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
							<div class="footer-widget">
								<?php dynamic_sidebar( 'footer-3' ); ?>
							</div>
						<?php else : ?>
							<div class="footer-widget">
								<h3 class="footer-widget-title"><?php esc_html_e( 'SUBSCRIBE FOR DISCOUNTS & DROPS', 'lambo-merch' ); ?></h3>
								<div class="footer-newsletter">
									<form action="#" method="post" class="newsletter-form">
										<input type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'lambo-merch' ); ?>" required>
										<button type="submit" class="submit-btn"><i class="fa fa-arrow-right"></i></button>
									</form>
								</div>
								<h3 class="footer-widget-title"><?php esc_html_e( 'FOLLOW', 'lambo-merch' ); ?></h3>
								<div class="social-icons">
									<a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
									<a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
									<a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .footer-widgets -->
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="copyright">
							<p>
								&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> |
								<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'PRIVACY POLICY', 'lambo-merch' ); ?></a> |
								<a href="<?php echo esc_url( home_url( '/terms-of-use' ) ); ?>"><?php esc_html_e( 'TERMS OF USE', 'lambo-merch' ); ?></a> |
								<?php esc_html_e( 'WEBSITE DESIGN BY', 'lambo-merch' ); ?> <a href="https://mediamade.fresh" target="_blank"><?php esc_html_e( 'MEDIA MADE FRESH', 'lambo-merch' ); ?></a>
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