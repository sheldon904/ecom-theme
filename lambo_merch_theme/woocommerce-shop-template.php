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
    <div style="background: red; color: white; text-align: center; padding: 10px; font-size: 24px; font-weight: bold;">VISITED</div>
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
        
        <!-- Mobile filter dropdown - visible only on mobile/tablet -->
        <div class="mobile-filter-section">
            <div class="mobile-filter-container">
                <h4>Filter by</h4>
                <div class="mobile-filter-dropdown">
                    <select id="mobile-filter-select" onchange="window.location.href=this.value">
                        <option value="<?php echo esc_url(add_query_arg('orderby', 'menu_order', wc_get_page_permalink('shop'))); ?>" <?php echo (!isset($_GET['orderby']) || $_GET['orderby'] == 'menu_order') ? 'selected' : ''; ?>>Default</option>
                        <option value="<?php echo esc_url(add_query_arg('orderby', 'price', wc_get_page_permalink('shop'))); ?>" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'selected' : ''; ?>>Price</option>
                        <option value="<?php echo esc_url(add_query_arg('orderby', 'popularity', wc_get_page_permalink('shop'))); ?>" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'popularity') ? 'selected' : ''; ?>>Category</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-3 order-md-2 desktop-filters-column">
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

<style>
/* Mobile Filter Section - Hidden by default on desktop */
.mobile-filter-section {
    display: none;
    width: 100%;
    padding: 0 15px;
    margin-bottom: 30px;
    margin-top: 30px;
}

.mobile-filter-container {
    text-align: center;
    background-color: #1a1a1a;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #333;
}

.mobile-filter-container h4 {
    color: #fff;
    font-size: 18px;
    margin-bottom: 15px;
    text-transform: uppercase;
    font-weight: 600;
}

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

/* Mobile and Tablet Responsive Styles */
@media (max-width: 1024px) {
    /* Show mobile filter section on mobile/tablet */
    .mobile-filter-section {
        display: block !important;
    }
    
    /* Hide desktop filters on mobile/tablet */
    .desktop-filters-column {
        display: none !important;
    }
    
    /* Make product column full width on mobile */
    .col-md-9 {
        width: 100% !important;
        flex: none !important;
        max-width: 100% !important;
    }
    
    /* Fix logo sizing on mobile */
    .col-md-4 img {
        max-width: 200px !important;
        max-height: 80px !important;
        height: auto !important;
        width: auto !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 auto !important;
    }
    
    /* Center the logo column */
    .col-md-4 {
        text-align: center !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 10px !important;
    }
    
    /* Adjust header layout for mobile */
    .container .row:first-child {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .col-md-8,
    .col-md-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: none !important;
    }
    
    /* Center the title and description on mobile */
    .col-md-8 {
        text-align: center !important;
        margin-bottom: 20px !important;
    }
}

/* Tablet specific adjustments */
@media (min-width: 768px) and (max-width: 1024px) {
    .col-md-4 img {
        max-height: 100px !important;
        max-width: 250px !important;
    }
}

/* Very small mobile devices */
@media (max-width: 480px) {
    .col-md-4 img {
        max-height: 60px !important;
        max-width: 150px !important;
    }
    
    .mobile-filter-container {
        padding: 15px;
    }
    
    .mobile-filter-container h4 {
        font-size: 16px;
    }
    
    .mobile-filter-dropdown select {
        font-size: 14px;
        padding: 10px 15px;
        padding-right: 40px;
    }
}
</style>

<?php
get_footer();