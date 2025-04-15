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
        <div class="row mt-5">
            <!-- Left sidebar with filters -->
            <div class="col-md-3">
                <div class="shop-filters">
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
            <div class="col-md-9">
                <?php if ($products->have_posts()) : ?>
                    <div class="row">
                        <?php while ($products->have_posts()) : $products->the_post(); ?>
                            <?php global $product; ?>
                            <div class="col-md-6 mb-4">
                                <div class="product-card" style="background-color: #35495e; padding: 20px; text-align: center; position: relative;">
                                    <!-- Product Image -->
                                    <a href="<?php the_permalink(); ?>">
                                        <?php 
                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail('woocommerce_thumbnail', array('class' => 'img-fluid'));
                                        } else {
                                            echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder" class="img-fluid">';
                                        }
                                        ?>
                                    </a>
                                    
                                    <!-- Price display in corner -->
                                    <div style="position: absolute; bottom: 20px; right: 20px; color: white; font-size: 1.2rem; font-style: italic;">
                                        <?php echo '$' . $product->get_price(); ?>
                                    </div>
                                    
                                    <!-- Add to cart form -->
                                    <?php
                                    // Add to cart functionality
                                    woocommerce_template_loop_add_to_cart();
                                    ?>
                                </div>
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

    <!-- Subscribe Section -->
    <div id="subscribe" class="subscribe-section mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="subscribe-title text-red">SUBSCRIBE FOR DISCOUNTS & DROPS</h2>
                    <div class="email-signup">
                        <form action="#" method="post" class="newsletter-form">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="input-group">
                                        <input type="email" class="form-control" placeholder="Enter your email" required>
                                        <button type="submit" class="btn btn-red">SUBSCRIBE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Add custom CSS for this page -->
<style>
.product-card {
    background-color: #35495e;
    transition: transform 0.3s ease;
    margin-bottom: 30px;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
}

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

.woocommerce a.add_to_cart_button {
    background-color: #ff0000;
    color: #fff;
    text-transform: uppercase;
    font-weight: bold;
    padding: 8px 15px;
    border: none;
    margin-top: 15px;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.woocommerce a.add_to_cart_button:hover {
    background-color: #cc0000;
}

#subscribe {
    padding: 60px 0;
    background-color: #111;
}

.subscribe-title {
    margin-bottom: 30px;
}

.input-group {
    display: flex;
}

.input-group input {
    flex: 1;
    background-color: #222;
    border: none;
    color: #fff;
    padding: 10px 15px;
}

.btn-red {
    background-color: #ff0000;
    color: #fff;
    border: none;
    padding: 10px 20px;
    text-transform: uppercase;
    font-weight: bold;
}
</style>

<?php get_footer(); ?>