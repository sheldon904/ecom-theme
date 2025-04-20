<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <header class="woocommerce-products-header">
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
                    <p>Welcome to the LAMBO MERCH - your destination for premium gear built for speed, style, and status. Explore our handpicked collection of high-end apparel, accessories, and collectibles crafted for true Lambo enthusiasts.</p>
                    <p>New drops hit fast, the best pieces go faster. <span class="text-red">Subscribe now</span> to unlock early access and never miss an exclusive release.</p>
                </div>
                <?php endif; ?>
            </header>
        </div>
        
        <div class="col-md-4 text-center">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo/Big_LM_logo.png" alt="Lambo Merch Logo" class="img-fluid mt-4">
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-3 order-md-2">
            <div class="shop-filters">
                <h3>Filter by</h3>
                <ul class="filter-list">
                    <li class="<?php echo (!isset($_GET['orderby']) || $_GET['orderby'] == 'menu_order') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(add_query_arg('orderby', 'menu_order', wc_get_page_permalink('shop'))); ?>" class="text-red">Default</a>
                    </li>
                    <li class="<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(add_query_arg('orderby', 'price', wc_get_page_permalink('shop'))); ?>" class="text-red">Price</a>
                    </li>
                    <li class="<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'popularity') ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url(add_query_arg('orderby', 'popularity', wc_get_page_permalink('shop'))); ?>" class="text-red">Category</a>
                    </li>
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
        
        <div class="col-md-9 order-md-1">
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