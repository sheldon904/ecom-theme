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
  /* Desktop vs Mobile */
  .desktop-header { display: block; }
  .mobile-header  { display: none; }

  @media (max-width: 767px) {
    /* Hide desktop, show mobile */
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
      padding: 0.1rem 1rem; /* snug top/bottom */
    }

    /* Push page content below sticky header */
    body,
    #content {
      padding-top: 3.5rem; /* adjust if header height changes */
    }

    /* Icon container */
    .mobile-header .icon-set {
      display: flex;
      align-items: center;
    }
    .mobile-header .icon-set a {
      margin-right: 1rem;  /* generous spacing */
    }
    .mobile-header .icon-set img {
      width: auto;
      height: 28px;
    }

    /* Logo sizing + shift left */
    .mobile-header .logo img {
      width: 50%;         /* half the header width */
      height: auto;
    }
    .mobile-header .logo {
      margin-left: -20%;  /* move logo left by 20% */
    }
  }
</style>


</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- DESKTOP HEADER (unchanged) -->
<div class="desktop-header">
  <header id="masthead" class="site-header sticky">
    <div class="header-main">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-12">
            <div class="header-content">
              <div class="header-left">
                <a href="#" class="menu-toggle">
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
                <a href="<?php echo esc_url( home_url( '/search' ) ); ?>" class="header-icon-link">
                  <span class="icon-text">SEARCH</span>
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/search.png' ); ?>"
                       alt="Search" class="header-icon">
                </a>
                <a href="<?php echo esc_url( home_url( '/wishlist' ) ); ?>" class="header-icon-link">
                  <span class="icon-text">FAVS</span>
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/favs.png' ); ?>"
                       alt="Favorites" class="header-icon">
                </a>
                <a href="<?php echo esc_url( home_url( '/cart' ) ); ?>" class="header-icon-link">
                  <span class="icon-text">CART</span>
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/cart.png' ); ?>"
                       alt="Cart" class="header-icon">
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
    <a href="<?php echo esc_url( home_url( '/search' ) ); ?>">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/search.png"
           alt="Search">
    </a>
    <a href="<?php echo esc_url( home_url( '/wishlist' ) ); ?>">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/favs.png"
           alt="Favorites">
    </a>
    <a href="https://lambomerch.madefreshdev.cloud/cart/">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/cart.png"
           alt="Cart">
    </a>
  </div>

  <div class="logo text-center">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png"
           alt="Lambo Merch Logo">
    </a>
  </div>

  <div class="right-placeholder"><!-- plugin menu drops here --></div>
</div>

<div id="content" class="site-content">
