<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
<header class="woocommerce-products-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8 text-left">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="woocommerce-products-header__title page-title">Shop the <span class="text-red">Luxe</span> Lane</h1>
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );
				?>
				
				<?php if ( is_shop() && !is_search() && function_exists('is_filtered') && !is_filtered() ) : ?>
				<div class="shop-description">
					<p>Welcome to the LAMBO MERCH — your destination for premium gear built for speed, style, and status. Explore our handpicked collection of high-end apparel, accessories, and collectibles crafted for true Lambo enthusiasts.</p>
					<p>New drops hit fast. The best pieces go faster. <a href="#footer-newsletter" class="text-red">Subscribe now</a> to unlock early access and never miss an exclusive release.</p>
				</div>
				<?php endif; ?>
			</div>
			<div class="col-md-4 text-right">
				<img src="http://lambomerch.com/wp-content/uploads/2025/05/Big_LM_logo_header-e1746073431746.png" alt="Lambo Merch Logo" class="img-fluid mt-4">
			</div>
		</div>
	</div>
</header>

<div class="container shop-container">
	<div class="row">
		<!-- Mobile filter dropdown - moved to top level for mobile -->
		<div class="mobile-filter-section">
			<div class="mobile-filter-container">
				<h4>Filter by</h4>
				<div class="mobile-filter-dropdown">
					<select id="mobile-filter-select" onchange="window.location.href=this.value">
						<option value="<?php echo esc_url(add_query_arg(array('product-page' => 1, 'orderby' => 'menu_order'), remove_query_arg('orderby'))); ?>" <?php echo (!isset($_GET['orderby']) || $_GET['orderby'] == 'menu_order') ? 'selected' : ''; ?>>Default</option>
						<option value="<?php echo esc_url(add_query_arg(array('product-page' => 1, 'orderby' => 'price'), remove_query_arg('orderby'))); ?>" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'selected' : ''; ?>>Price</option>
						<option value="<?php echo esc_url(add_query_arg(array('product-page' => 1, 'orderby' => 'popularity'), remove_query_arg('orderby'))); ?>" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'popularity') ? 'selected' : ''; ?>>Category</option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-2">
			<div class="shop-filters desktop-only">
				<h4>Filter by</h4>
				<!-- Desktop filter list -->
				<ul class="filter-list desktop-filters">
					<li class="<?php echo (!isset($_GET['orderby']) || $_GET['orderby'] == 'menu_order') ? 'active' : ''; ?>">
						<a href="<?php echo esc_url(add_query_arg(array('product-page' => 1, 'orderby' => 'menu_order'), remove_query_arg('orderby'))); ?>" class="text-red">Default</a>
					</li>
					<li class="<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'active' : ''; ?>">
						<a href="<?php echo esc_url(add_query_arg(array('product-page' => 1, 'orderby' => 'price'), remove_query_arg('orderby'))); ?>" class="text-red">Price</a>
					</li>
					<li class="<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'popularity') ? 'active' : ''; ?>">
						<a href="<?php echo esc_url(add_query_arg(array('product-page' => 1, 'orderby' => 'popularity'), remove_query_arg('orderby'))); ?>" class="text-red">Category</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="col-md-10">
			<?php
			if ( woocommerce_product_loop() ) {

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			}
			?>
		</div>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

?>

<!-- Mobile Responsive CSS for Shop Filters and Logo Fixes -->
<style>
.woocommerce-products-header__title {
    font-family: "Impact", sans-serif !important;
}

/* Mobile Filter Section - Hidden by default on desktop */
.mobile-filter-section {
    display: none;
    width: 100%;
    padding: 0 15px;
    margin-bottom: 20px;
}

.mobile-filter-container {
    text-align: center;
    background-color: #1a1a1a;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #333;
}

/* Desktop Filters - Shown by default */
.desktop-only {
    display: block;
}

/* Mobile and Tablet Responsive Styles */
@media (max-width: 1024px) {
    /* Hide desktop filters on mobile/tablet */
    .desktop-only {
        display: none !important;
    }
    
    /* Show mobile filter section on mobile/tablet */
    .mobile-filter-section {
        display: block !important;
        order: -1; /* Place at top */
    }
    
    /* Hide the sidebar column completely on mobile */
    .col-md-2 {
        display: none !important;
    }
    
    /* Make product column full width on mobile */
    .col-md-10 {
        width: 100% !important;
        flex: none !important;
        max-width: 100% !important;
    }
    
    /* Style the mobile filter container */
    .mobile-filter-container h4 {
        color: #fff;
        font-size: 18px;
        margin-bottom: 15px;
        text-transform: uppercase;
        font-weight: 600;
    }
    
    /* Style the dropdown select */
    .mobile-filter-dropdown select {
        width: 100%;
        max-width: 300px;
        padding: 12px 20px;
        background-color: #000;
        color: #fff;
        border: 2px solid #ff0000;
        border-radius: 8px;
        font-size: 16px;
        font-family: 'Source Sans Pro', sans-serif;
        font-weight: 600;
        appearance: none;
        background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAiIGhlaWdodD0iNiIgdmlld0JveD0iMCAwIDEwIDYiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik01IDZMMCAwSDEwTDUgNloiIGZpbGw9IiNGRjAwMDAiLz4KPHN2Zz4K');
        background-repeat: no-repeat;
        background-position: right 20px center;
        padding-right: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .mobile-filter-dropdown select:hover,
    .mobile-filter-dropdown select:focus {
        border-color: #fff;
        box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
    }
    
    /* Adjust shop container layout for mobile */
    .shop-container .row {
        flex-direction: column;
    }
}

/* Logo Mobile Fixes - Shop Page Header */
@media (max-width: 1024px) {
    /* Fix the shop page header logo */
    .woocommerce-products-header .col-md-4 img {
        max-width: 200px !important;
        height: auto !important;
        width: auto !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 auto !important;
    }
    
    /* Center the logo column */
    .woocommerce-products-header .col-md-4 {
        text-align: center !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 10px !important;
    }
    
    /* Adjust header layout for mobile */
    .woocommerce-products-header .row {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .woocommerce-products-header .col-md-8,
    .woocommerce-products-header .col-md-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
    }
    
    /* Center the title and description on mobile */
    .woocommerce-products-header .col-md-8 {
        text-align: center !important;
        margin-bottom: 20px !important;
    }
    
    /* Mobile header height fixes (global mobile header) */
    .mobile-header {
        height: auto !important;
        min-height: 80px !important;
        padding: 10px 15px !important;
        overflow: visible !important;
    }
    
    /* Ensure mobile header logo stays within bounds and is centered */
    .mobile-header .logo {
        flex: 1 !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        max-width: calc(100% - 160px) !important;
    }
    
    /* Mobile header logo image responsive sizing */
    .mobile-header .logo img {
        max-width: 100% !important;
        max-height: 60px !important;
        height: auto !important;
        width: auto !important;
        object-fit: contain !important;
    }
    
    /* Adjust body padding for the responsive header */
    body, #content {
        padding-top: 100px !important;
    }
    
    /* Icon sets sizing to prevent overlap */
    .mobile-header .icon-set {
        flex: 0 0 80px !important;
        display: flex !important;
        justify-content: space-around !important;
        align-items: center !important;
    }
    
    .mobile-header .icon-set img {
        max-width: 24px !important;
        max-height: 24px !important;
    }
    
    /* Menu toggle positioning */
    .mobile-menu-toggle {
        flex: 0 0 30px !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
}

/* Tablet specific adjustments */
@media (min-width: 768px) and (max-width: 1024px) {
    .mobile-header .logo img {
        max-height: 70px !important;
    }
    
    .woocommerce-products-header .col-md-4 img {
        max-height: 100px !important;
        max-width: 250px !important;
    }
    
    body, #content {
        padding-top: 110px !important;
    }
}

/* Very small mobile devices */
@media (max-width: 480px) {
    .mobile-header .logo img {
        max-height: 50px !important;
    }
    
    .woocommerce-products-header .col-md-4 img {
        max-width: 150px !important;
    }
    
    .mobile-header {
        padding: 8px 10px !important;
    }
    
    body, #content {
        padding-top: 90px !important;
    }
}

/* Tablet Portrait and Landscape Margins */
@media (min-width: 768px) and (max-width: 1366px) {
    .container {
        max-width: 90% !important;
    }
}
</style>

<!-- Newsletter section moved to footer -->

<?php
get_footer( 'shop' );

