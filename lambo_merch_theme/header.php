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
	
	<!-- Force load Source Sans Pro -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
	
	<style>
		body, p, span, div, li, a, button, input, select, textarea {
			font-family: 'Source Sans Pro', sans-serif !important;
		}
		h1, h2, h3, h4, h5, h6, .woocommerce-loop-product__title {
			font-family: 'Georgia', serif !important;
			font-style: italic !important;
		}
	</style>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'lambo-merch' ); ?></a>

	<header id="masthead" class="site-header sticky">
		<div class="header-main">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12">
						<div class="header-content">
							<div class="header-left">
								<a href="#" class="menu-toggle">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/menu_bars.png' ); ?>" alt="Menu" class="menu-icon">
									<span class="menu-text">MENU</span>
								</a>
								
								<div class="nav-links">
									<a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="nav-link">SHOP</a>
									<span class="nav-separator">|</span>
									<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="nav-link">ABOUT</a>
									<span class="nav-separator">|</span>
									<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="nav-link">CONTACT</a>
								</div>
							</div>
							
							<div class="header-right">
								<a href="<?php echo esc_url( home_url( '/search' ) ); ?>" class="header-icon-link">
									<span class="icon-text">SEARCH</span>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/search.png' ); ?>" alt="Search" class="header-icon">
								</a>
								
								<a href="<?php echo esc_url( home_url( '/wishlist' ) ); ?>" class="header-icon-link">
									<span class="icon-text">FAVS</span>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/favs.png' ); ?>" alt="Favorites" class="header-icon">
								</a>
								
								<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account' ) ); ?>" class="header-icon-link">
									<span class="icon-text">MY ACCOUNT</span>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/my_account.png' ); ?>" alt="My Account" class="header-icon">
								</a>
								
								<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'cart' ) : home_url( '/cart' ) ); ?>" class="header-icon-link">
									<span class="icon-text">CART</span>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/cart.png' ); ?>" alt="Cart" class="header-icon">
									<?php if ( class_exists( 'WooCommerce' ) ) : ?>
										<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
									<?php endif; ?>
								</a>
							</div>
						</div>
						
						<nav id="site-navigation" class="main-navigation">
							<div class="primary-menu-container">
								<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
										'container'      => false,
										'menu_class'     => 'menu',
										'fallback_cb'    => 'wp_page_menu',
									)
								);
								?>
							</div>
						</nav><!-- #site-navigation -->
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .header-main -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">