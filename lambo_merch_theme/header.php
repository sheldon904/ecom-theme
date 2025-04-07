<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Lambo_Merch
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'lambo-merch' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header-main">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-3">
						<div class="site-branding">
							<?php
							if ( has_custom_logo() ) :
								the_custom_logo();
							else :
							?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo/Big_LM_logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="custom-logo">
								</a>
							<?php endif; ?>
						</div><!-- .site-branding -->
					</div>

					<div class="col-md-9">
						<div class="header-right">
							<nav id="site-navigation" class="main-navigation">
								<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
									<span class="menu-toggle-icon"></span>
									<?php esc_html_e( 'MENU', 'lambo-merch' ); ?>
								</button>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
										'container'      => 'div',
										'container_class' => 'primary-menu-container',
										'menu_class'     => 'menu',
										'fallback_cb'    => 'wp_page_menu',
									)
								);
								?>
							</nav><!-- #site-navigation -->

							<div class="header-icons">
								<a href="<?php echo esc_url( home_url( '/search' ) ); ?>" class="search-icon">
									<i class="fas fa-search"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'SEARCH', 'lambo-merch' ); ?></span>
								</a>
								
								<?php if ( class_exists( 'WooCommerce' ) ) : ?>
								<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="account-icon">
									<i class="fas fa-user"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'MY ACCOUNT', 'lambo-merch' ); ?></span>
								</a>
								
								<a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" class="cart-icon">
									<i class="fas fa-shopping-cart"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'CART', 'lambo-merch' ); ?></span>
									<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
								</a>
								<?php endif; ?>
							</div><!-- .header-icons -->
						</div><!-- .header-right -->
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .header-main -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">