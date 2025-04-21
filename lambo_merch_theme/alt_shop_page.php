<?php
/**
 * Template Name: Shop Page
 *
 * This is a custom template for displaying the shop page with WooCommerce integration.
 *
 * @package Lambo_Merch
 */

get_header();

// Set up shop query
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'paged'          => $paged,
    'orderby'        => isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'menu_order',
);

// Handle filtering by category if set
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['category']),
        ),
    );
}

// Handle price ordering if set
if (isset($_GET['orderby']) && $_GET['orderby'] == 'price') {
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = '_price';
    $args['order'] = 'ASC';
}

$products = new WP_Query($args);
?>

<main id="primary" class="site-main">
    <div class="container">
        <!-- Shop Header -->
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">Shop the <span class="text-red">Luxe</span> Lane</h1>
                <div class="shop-description">
                    <p>Welcome to the LAMBO MERCH — your destination for premium gear built for speed, style, and status. Explore our handpicked collection of high-end apparel, accessories, and collectibles crafted for true Lambo enthusiasts.</p>
                    <p>New drops hit fast. The best pieces go faster. <a href="#subscribe" class="text-red">Subscribe now</a> to unlock early access and never miss an exclusive release.</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo/LM_logo_footer.png" alt="Lambo Merch Logo" class="img-fluid">
            </div>
        </div>

        <!-- Filter and Products -->
        <div class="shop-container mt-5">
            <!-- Left sidebar with filters -->
            <div class="shop-sidebar">
                <div class="shop-filters" style="background-color: #000000;">
                    <h3>Filter by</h3>
                    <ul class="filter-list">
                        <li class="<?php echo (!isset($_GET['orderby']) || $_GET['orderby'] == 'menu_order') ? 'active' : ''; ?>">
                            <a href="<?php echo esc_url(remove_query_arg('orderby')); ?>" class="text-red">Default</a>
                        </li>
                        <li class="<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'price') ? 'active' : ''; ?>">
                            <a href="<?php echo esc_url(add_query_arg('orderby', 'price')); ?>" class="text-red">Price</a>
                        </li>
                        <li class="<?php echo (isset($_GET['orderby']) && $_GET['orderby'] == 'category') ? 'active' : ''; ?>">
                            <a href="<?php echo esc_url(add_query_arg('orderby', 'category')); ?>" class="text-red">Category</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="shop-main">
                <?php if ($products->have_posts()) : ?>
                    <div class="row">
                        <?php while ($products->have_posts()) : $products->the_post(); ?>
                            <?php global $product; ?>
                            <div class="col-md-6 mb-4">
                                <a href="<?php the_permalink(); ?>" class="product-link">
                                    <div class="product-card" style="position: relative; padding: 0; background: none;">
                                        <!-- Product Image -->
                                        <?php 
                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('woocommerce_thumbnail', array('class' => 'img-fluid'));
                                        } else {
                                            echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" class="img-fluid">';
                                        }
                                        ?>
                                        
                                        <!-- Price display in corner -->
                                        <div style="position: absolute; bottom: 30px; right: 50px; color: white; font-size: 1.2rem; font-style: italic;">
                                            <?php echo '$' . $product->get_price(); ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination text-center mt-4">
                        <ul class="list-inline">
                            <?php if ($paged > 1) : ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo get_pagenum_link($paged - 1); ?>" class="pagination-arrow">&laquo;</a>
                                </li>
                            <?php else: ?>
                                <li class="list-inline-item">
                                    <span class="pagination-arrow disabled">&laquo;</span>
                                </li>
                            <?php endif; ?>
                            
                            <?php
                            $total_pages = $products->max_num_pages;
                            for ($i = 1; $i <= $total_pages; $i++) :
                                if ($i == $paged) : ?>
                                    <li class="list-inline-item active">
                                        <span class="current-page"><?php echo $i; ?></span>
                                    </li>
                                <?php else : ?>
                                    <li class="list-inline-item">
                                        <a href="<?php echo get_pagenum_link($i); ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endif;
                            endfor; ?>
                            
                            <?php if ($paged < $total_pages) : ?>
                                <li class="list-inline-item">
                                    <a href="<?php echo get_pagenum_link($paged + 1); ?>" class="pagination-arrow">&raquo;</a>
                                </li>
                            <?php else: ?>
                                <li class="list-inline-item">
                                    <span class="pagination-arrow disabled">&raquo;</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="no-products">No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<!-- Add custom CSS for this page -->
<style>
/* Shop Layout */
.shop-container {
    display: flex;
    width: 100%;
    gap: 30px;
}

.shop-sidebar {
    width: 25%;
    flex-shrink: 0;
}

.shop-main {
    width: 75%;
    flex-grow: 1;
}

/* Product Styling */
.product-card {
    transition: transform 0.3s ease;
    margin-bottom: 30px;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-link {
    display: block;
    text-decoration: none;
}

/* Pagination */
.pagination {
    margin-top: 40px;
}

.pagination ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

.pagination li {
    display: inline-block;
    margin: 0 5px;
}

.pagination a, .pagination span {
    display: block;
    padding: 8px 12px;
    background-color: #222;
    color: #fff;
    text-decoration: none;
}

.pagination li.active span {
    background-color: #ff0000;
}

.pagination .pagination-arrow {
    font-weight: bold;
}

.pagination .disabled {
    background-color: #333;
    color: #555;
    cursor: not-allowed;
}

/* Filter Styling */
.text-red {
    color: #ff0000;
}

.filter-list {
    list-style: none;
    padding: 0;
}

.filter-list li {
    margin-bottom: 10px;
}

.filter-list li a {
    color: #fff;
    text-decoration: none;
}

.filter-list li.active a {
    color: #ff0000;
    font-weight: bold;
}

.shop-filters {
    padding: 20px;
}

/* Responsive Layout */
@media (max-width: 768px) {
    .shop-container {
        flex-direction: column;
    }
    
    .shop-sidebar,
    .shop-main {
        width: 100%;
    }
}
</style>

<?php get_footer(); ?>