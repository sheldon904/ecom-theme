<?php
/**
 * The Template for displaying all single products
 *
 * @package Lambo_Merch
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header('shop'); 
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            /**
             * Hook: woocommerce_before_main_content.
             */
            do_action( 'woocommerce_before_main_content' );
            
            while ( have_posts() ) : the_post();
                global $product;
            ?>
            
            <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
                <div class="row product-detail-main">
                    <!-- Left Column - Product Image -->
                    <div class="col-md-6 product-image-column">
                        <!-- Modified to show only a single image without zoom feature -->
                        <div class="single-product-image">
                            <?php 
                            // Display only the main product image
                            $image_id = $product->get_image_id();
                            if ($image_id) {
                                echo wp_get_attachment_image($image_id, 'full', false, array('class' => 'img-fluid'));
                            } else {
                                echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" class="img-fluid">';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Right Column - Product Details -->
                    <div class="col-md-6 product-details-column">
                        <div class="product-details-content">
                            <h1 class="product-title"><?php the_title(); ?></h1>
                            
                            <div class="product-price-container">
                                <div class="price"><?php echo $product->get_price_html(); ?></div>
                                
                                <?php if ( ! $product->is_type('variable') ) : ?>
                                    <div class="stock-status">
                                        <?php if ( $product->is_in_stock() ) : ?>
                                            <span class="in-stock"><?php esc_html_e( 'In Stock', 'lambo-merch' ); ?></span>
                                        <?php else : ?>
                                            <span class="out-of-stock"><?php esc_html_e( 'Out of Stock', 'lambo-merch' ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-short-description">
                                <?php echo apply_filters( 'woocommerce_short_description', $product->get_short_description() ); ?>
                            </div>
                            
                            <!-- Limited edition notice - moved here and appears only once -->
                            <div class="exclusive-product-notice">
                                <p><?php echo esc_html__( 'Limited edition - Don\'t miss out!', 'lambo-merch' ); ?></p>
                            </div>
                            
                            <div class="product-add-to-cart">
                                <?php
                                /**
                                 * Hook: woocommerce_single_product_summary
                                 */
                                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
                                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
                                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
                                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
                                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
                                
                                do_action('woocommerce_single_product_summary');
                                ?>
                            </div>
                            
                            <div class="wishlist-button">
                                <?php
                                // Check if YITH WooCommerce Wishlist is active
                                if ( function_exists( 'YITH_WCWL' ) ) : ?>
                                    <?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
                                <?php else : ?>
                                    <button class="add-to-wishlist">Add to Wishlist</button>
                                <?php endif; ?>
                            </div>
                            
                            <hr class="details-divider">
                        </div><!-- .product-details-content -->
                    </div><!-- .product-details-column -->
                </div><!-- .product-detail-main -->
                
                <!-- Product Tabs Section - Removed Reviews, only keeping Details -->
                <div class="row product-tabs-section">
                    <div class="col-md-12">
                        <div class="product-tabs">
                            <ul class="tabs-nav">
                                <li class="active">
                                    <a href="#details" class="tab-link" data-tab="details">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/backgrounds/Rectangle 10.png" class="tab-bg" alt="">
                                        <span>Details</span>
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="tabs-content">
                                <div id="details" class="tab-content active">
                                    <div class="product-description">
                                        <?php echo wpautop( $product->get_description() ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .product-tabs-section -->
            </div><!-- #product-<?php the_ID(); ?> -->
            
            <?php
            endwhile; // End of the Loop.
            do_action( 'woocommerce_after_main_content' );
            ?>
        </div><!-- .col-md-12 -->
    </div><!-- .row -->
</div><!-- .container -->

<!-- Related Products Section - Modified to extend to edges of window -->
<div class="related-products-full-width">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Top Related Products</h2>
                <div class="related-products-row" style="justify-content: space-evenly;">
                    <?php
                    $related_products = wc_get_related_products( $product->get_id(), 3 );
                    
                    if ( $related_products ) {
                        echo '<div class="related-products-container">';
                        foreach ( $related_products as $related_product_id ) {
                            $related_product = wc_get_product( $related_product_id );
                            ?>
                            <div class="related-product">
                                <a href="<?php echo esc_url( get_permalink( $related_product_id ) ); ?>">
                                    <?php echo $related_product->get_image( 'medium' ); ?>
                                    <div class="product-price"><?php echo $related_product->get_price_html(); ?></div>
                                </a>
                            </div>
                            <?php
                        }
                        echo '</div>';
                    } else {
                        echo '<p class="no-related">No related products found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer('shop'); ?>

<style>
/* Remove zoom feature */
.woocommerce-product-gallery__trigger {
    display: none !important;
}

/* Hide thumbnails */
.woocommerce-product-gallery__wrapper .flex-control-thumbs {
    display: none !important;
}

/* Make background black not dark gray */
.woocommerce-tabs, 
.woocommerce div.product .woocommerce-tabs .panel,
.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
    background-color: #000000 !important;
}

/* Details tab styling */
.product-tabs-section .tabs-content {
    background-color: #282828 !important;
    padding: 30px;
    border-radius: 3px;
}

/* Styled related products section */
.related-products-full-width {
    background-color: #464646 !important;
    padding: 60px 0;
    margin-top: 50px;
    width: 100%;
}

/* Center the related products */
.related-products-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.related-product {
    flex: 0 0 30%;
    max-width: 350px;
    position: relative;
}

/* Style the prices like in alt-shop.php */
.related-product .product-price {
    position: absolute;
    bottom: 30px;
    right: 50px;
    color: white !important;
    font-size: 1.2rem;
    font-style: italic;
}

/* Make sure all prices in related products are white */
.related-product .product-price span,
.related-product .product-price .woocommerce-Price-amount,
.related-product .product-price bdi,
.related-product .product-price .amount {
    color: white !important;
}

/* Single image display */
.single-product-image {
    margin-bottom: 30px;
}

/* Responsive styling */
@media (max-width: 768px) {
    .related-products-container {
        flex-direction: column;
        align-items: center;
    }
    
    .related-product {
        flex: 0 0 100%;
        max-width: 90%;
        margin-bottom: 30px;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Tab functionality
    $('.tab-link').on('click', function(e) {
        e.preventDefault();
        var tab = $(this).data('tab');
        
        // Remove active class from all tabs
        $('.tab-link').parent().removeClass('active');
        $('.tab-content').removeClass('active');
        
        // Add active class to the selected tab
        $(this).parent().addClass('active');
        $('#' + tab).addClass('active');
    });
    
    // Remove the woocommerce zoom functionality
    $('.woocommerce-product-gallery').each(function() {
        $(this).removeClass('woocommerce-product-gallery--with-images');
        $(this).removeClass('woocommerce-product-gallery--with-zoom');
    });
    
    // Remove duplicate "Limited edition" notice if it exists twice
    if ($('.exclusive-product-notice').length > 1) {
        $('.exclusive-product-notice').eq(1).remove();
    }
});
</script>