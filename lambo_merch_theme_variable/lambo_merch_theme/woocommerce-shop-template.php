<?php
/**
 * Template Name: WooCommerce Shop Page
 *
 * This is a custom template for integrating with WooCommerce shop functionality.
 *
 * @package Lambo_Merch
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">Shop the <span class="text-red">Luxe</span> Lane</h1>
                <div class="shop-description">
                    <p>Welcome to the LAMBO MERCH - your destination for premium gear built for speed, style, and status. Explore our handpicked collection of high-end apparel, accessories, and collectibles crafted for true Lambo enthusiasts.</p>
                    <p>New drops hit fast, the best pieces go faster. <span class="text-red">Subscribe now</span> to unlock early access and never miss an exclusive release.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo/Big_LM_logo.png" alt="Lambo Merch Logo" class="img-fluid">
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-md-3 order-md-2">
                <div class="shop-filters">
                    <h3>Filter by</h3>
                    <ul class="filter-list">
                        <li class="active">
                            <a href="<?php echo esc_url(add_query_arg('orderby', 'menu_order', wc_get_page_permalink('shop'))); ?>" class="text-red">Default</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(add_query_arg('orderby', 'price', wc_get_page_permalink('shop'))); ?>" class="text-red">Price</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(add_query_arg('orderby', 'popularity', wc_get_page_permalink('shop'))); ?>" class="text-red">Category</a>
                        </li>
                    </ul>
                    
                    <?php
                    /**
                     * Hook: woocommerce_sidebar.
                     *
                     * @hooked woocommerce_get_sidebar - 10
                     */
                    do_action('woocommerce_sidebar');
                    ?>
                </div>
            </div>
            
            <div class="col-md-9 order-md-1">
                <?php
                // Display WooCommerce content
                echo do_shortcode('[products limit="4" columns="2" paginate="true"]');
                
                // Or you can use a custom query
                /*
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'orderby'        => isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : 'menu_order',
                );
                
                $loop = new WP_Query($args);
                
                if ($loop->have_posts()) {
                    echo '<div class="row">';
                    
                    while ($loop->have_posts()) : $loop->the_post();
                        global $product;
                        
                        echo '<div class="col-md-6 mb-4">';
                        echo '<div class="product-card">';
                        
                        // Product Image
                        echo '<a href="' . get_permalink() . '">';
                        echo woocommerce_get_product_thumbnail('woocommerce_thumbnail');
                        echo '</a>';
                        
                        // Product Title
                        echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                        
                        // Product Price
                        echo '<span class="price">' . $product->get_price_html() . '</span>';
                        
                        // Add to Cart Button
                        echo '<a href="' . esc_url($product->add_to_cart_url()) . '" class="btn btn-red add-to-cart">' . esc_html__('Add to Cart', 'lambo-merch') . '</a>';
                        
                        echo '</div>';
                        echo '</div>';
                    endwhile;
                    
                    echo '</div>';
                    
                    // Pagination
                    echo '<div class="row">';
                    echo '<div class="col-12">';
                    echo '<div class="product-pagination">';
                    
                    $total_pages = $loop->max_num_pages;
                    
                    if ($total_pages > 1) {
                        $current_page = max(1, get_query_var('paged'));
                        
                        echo '<a href="' . get_pagenum_link($current_page - 1) . '" class="pagination-arrow pagination-prev' . ($current_page == 1 ? ' disabled' : '') . '"><i class="fa fa-arrow-left"></i></a>';
                        
                        echo '<span class="pagination-page">Page ' . $current_page . ' of ' . $total_pages . '</span>';
                        
                        echo '<a href="' . get_pagenum_link($current_page + 1) . '" class="pagination-arrow pagination-next' . ($current_page == $total_pages ? ' disabled' : '') . '"><i class="fa fa-arrow-right"></i></a>';
                    }
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    
                    wp_reset_postdata();
                } else {
                    echo __('No products found', 'lambo-merch');
                }
                */
                ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();