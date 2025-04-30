<?php
/**
 * The header for our theme
 *
 * Displays everything up until <div id="content">
 *
 * @package Lambo_Merch
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <style>
    /* … your existing styles … */
    .desktop-header { display: block; }
    .mobile-header  { display: none; }
    /* … media queries, etc … */
    @media (max-width: 767px) {
      .desktop-header { display: none !important; }
      .mobile-header  {
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        background: #000;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
        padding: 0.1rem 1rem;
      }
      body,
      #content {
        padding-top: 3.5rem;
      }
    }
  </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Main Navigation Menu (outside the header for proper positioning) -->
<nav id="site-navigation" class="main-navigation">
  <div class="menu-header">
    <div class="menu-logo">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png" alt="Lambo Merch Logo">
    </div>
    <span class="menu-title"></span>
    <button class="close-menu">×</button>
  </div>
  <?php
  if ( has_nav_menu( 'main_menu' ) ) {
    wp_nav_menu( array(
      'theme_location'  => 'main_menu',
      'menu_id'         => 'main-menu',
      'container'       => 'div',
      'container_class' => 'main-menu-container',
      'fallback_cb'     => false,
    ) );
  }
  ?>
</nav>

<!-- DESKTOP HEADER -->
<div class="desktop-header">
  <header id="masthead" class="site-header sticky">
    <div class="header-main">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-12">
            <div class="header-content">
              <div class="header-left">
                <a href="#" class="menu-toggle" id="desktop-menu-toggle">
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/menu_bars.png' ); ?>"
                       alt="Menu" class="menu-icon">
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
                <!-- FiboSearch bar -->
                <div class="header-search">
                  <?php echo do_shortcode( '[fibosearch]' ); ?>
                </div>

                <a href="/favs-2/" class="header-icon-link">
                  <span class="icon-text">FAVS</span>
                  <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/favs.png' ); ?>"
                       alt="Favorites" class="header-icon">
                </a>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="header-icon-link">
                  <span class="icon-text">MY ACCOUNT</span>
                  <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
                  <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/my_account.png"
                       alt="My Account" class="header-icon">
                </a>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon-link">
                  <span class="icon-text">CART</span>
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/cart.png' ); ?>"
                       alt="Cart" class="header-icon">
                  <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</div>

<!-- MOBILE HEADER -->
<div class="mobile-header">
  <div class="icon-set d-flex">
    <!-- FiboSearch bar (mobile) -->
    <div class="mobile-search">
      <?php echo do_shortcode( '[fibosearch]' ); ?>
    </div>

    <a href="/favs-2/" class="fav-icon">
      <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/favs.png" alt="Favorites">
    </a>
    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="account-icon">
      <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/my_account.png" alt="My Account">
    </a>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon">
      <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/cart.png" alt="Cart">
      <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    </a>
  </div>

  <div class="logo text-center">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png"
           alt="Lambo Merch Logo">
    </a>
  </div>

  <a href="#" class="mobile-menu-toggle">
    <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/menu_bars.png' ); ?>"
         alt="Menu" class="menu-icon">
  </a>
</div>

<div id="content" class="site-content">
