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
  
  /* Main Menu Styling */
  #site-navigation {
    display: none !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    background-color: #000 !important;
    padding: 20px !important;
    z-index: 999999 !important;
    width: 300px !important;
    height: 100vh !important;
    border-right: 1px solid #444 !important;
    overflow-y: auto !important;
    box-shadow: 2px 0 10px rgba(0,0,0,0.5) !important;
  }
  
  body.menu-open #site-navigation,
  #site-navigation.toggled {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }
  
  body.menu-open:before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 99999;
  }
  
  .menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #333;
  }
  
  .menu-title {
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    text-transform: uppercase;
  }
  
  .close-menu {
    background: none;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .close-menu:hover {
    color: #999;
  }
  
  .main-navigation ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  
  .main-navigation ul li {
    margin-bottom: 15px;
  }
  
  .main-navigation ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    text-transform: uppercase;
    display: block;
    padding: 8px 0;
    transition: color 0.3s ease;
  }
  
  .main-navigation ul li a:hover {
    color: #999;
  }

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

    /* Logo sizing + centering (removed shift to avoid blocking icons) */
    .mobile-header .logo img {
      width: 50%;
      height: auto;
    }
    .mobile-header .logo {
      margin: 0 auto;
    }
  }
</style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Main Navigation Menu (outside the header for proper positioning) -->
<nav id="site-navigation" class="main-navigation">
  <div class="menu-header">
    <span class="menu-title">MENU</span>
    <button class="close-menu">×</button>
  </div>
  <?php
  if (has_nav_menu('main_menu')) {
    wp_nav_menu(
      array(
        'theme_location' => 'main_menu',
        'menu_id'        => 'main-menu',
        'container'      => 'div',
        'container_class' => 'main-menu-container',
        'fallback_cb'    => false,
      )
    );
  } else {
    // Fallback menu with basic links
    echo '<div class="main-menu-container"><ul id="main-menu" class="menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/shop')) . '">Shop</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
    echo '</ul></div>';
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
                <a href="https://lambomerch.madefreshdev.cloud/search-2/" class="header-icon-link search-icon">
                  <span class="icon-text">SEARCH</span>
                  <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
                  <img src="<?php echo esc_url( get_template_directory_uri() . '/images/icons/search.png' ); ?>"
                       alt="Search" class="header-icon">
                </a>
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
    <a href="/search-2/" class="search-icon">
      <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/search.png"
           alt="Search">
    </a>
    <a href="/favs-2/" class="fav-icon">
      <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/favs.png"
           alt="Favorites">
    </a>
    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="account-icon">
      <span style="position: absolute; width: 100%; height: 100%; z-index: 1;"></span>
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/my_account.png"
           alt="My Account">
    </a>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon-link">
      <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/cart.png"
           alt="Cart" class="header-icon">
      <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
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
