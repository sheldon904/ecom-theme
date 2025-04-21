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
			<div class="col-md-12 text-center">
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
				
				<?php if ( is_shop() && !is_search() && !is_filtered() ) : ?>
				<div class="shop-description">
					<p>Welcome to the LAMBO MERCH — your destination for premium gear built for speed, style, and status. Explore our handpicked collection of high-end apparel, accessories, and collectibles crafted for true Lambo enthusiasts.</p>
					<p>New drops hit fast. The best pieces go faster. <a href="#newsletter" class="text-red">Subscribe now</a> to unlock early access and never miss an exclusive release.</p>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</header>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="shop-filters">
				<h4>Filter by</h4>
				<ul class="filter-list">
					<li class="active"><a href="#">Default</a></li>
					<li><a href="#">Price</a></li>
					<li><a href="#">Category</a></li>
				</ul>
				<?php
				/**
				 * Hook: woocommerce_sidebar.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action( 'woocommerce_sidebar' );
				?>
			</div>
		</div>
		
		<div class="col-md-9">
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

<div id="newsletter" class="newsletter-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 class="section-title">Subscribe for Discounts & Drops</h2>
				<div class="newsletter-form">
					<form action="#" method="post">
						<div class="form-row">
							<div class="col-md-8 offset-md-2">
								<div class="input-group">
									<input type="email" class="form-control" placeholder="Enter your email" required>
									<div class="input-group-append">
										<button class="btn btn-red" type="submit"><i class="fa fa-arrow-right"></i></button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer( 'shop' );

/**
 * Helper function to determine if current display has active filters
 */
function is_filtered() {
	return isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) || isset( $_GET['rating_filter'] ) || isset( $_GET['filter_color'] ) || isset( $_GET['filter_size'] );
}