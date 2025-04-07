<?php
/**
 * Template Name: Home Page
 *
 * The template for displaying the home page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Lambo_Merch
 */

get_header();

// Load Mobile Detect to handle responsive content
$detect = new Mobile_Detect();
?>

<main id="primary" class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="hero-title">Luxury Merch for Lambo Enthusiasts</h1>
                    
                    <div class="hero-slider">
                        <div class="hero-slider-container">
                            <?php 
                            // Display hero slider if a field exists, otherwise display default content
                            if (function_exists('get_field') && get_field('hero_slider')) {
                                echo get_field('hero_slider');
                            } else {
                                // Default slider content
                                ?>
                                <div class="hero-slide">
                                    <div class="product-showcase">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/product-showcase.jpg" alt="Product Showcase" class="img-fluid">
                                        <div class="cta-button">
                                            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-red">SHOP NOW</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="video-container">
                        <?php 
                        if (function_exists('get_field') && get_field('featured_video')) {
                            // Display video from ACF field
                            echo get_field('featured_video');
                        } else {
                            // Default video thumbnail with play button
                            ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/video-placeholder.jpg" alt="Lamborghini Video" class="img-fluid">
                            <a href="#" class="play-button" data-video-id="your-video-id">
                                <i class="fa fa-play"></i>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title text-center">Featured Products</h2>
                </div>
            </div>
            
            <div class="row">
                <?php
                // Check if WooCommerce is active
                if (class_exists('WooCommerce')) {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'featured',
                                'operator' => 'IN',
                            ),
                        ),
                    );
                    $loop = new WP_Query($args);
                    if ($loop->have_posts()) {
                        while ($loop->have_posts()) : $loop->the_post();
                            global $product;
                            ?>
                            <div class="col-md-3">
                                <div class="product-card">
                                    <a href="<?php echo get_permalink($loop->post->ID); ?>">
                                        <?php 
                                        if (has_post_thumbnail($loop->post->ID)) {
                                            echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog', array('class' => 'img-fluid'));
                                        } else {
                                            echo '<img src="' . get_template_directory_uri() . '/images/placeholder.png" alt="Product Image" class="img-fluid">';
                                        }
                                        ?>
                                        <h3><?php the_title(); ?></h3>
                                    </a>
                                    <span class="price"><?php echo $product->get_price_html(); ?></span>
                                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="btn btn-red add-to-cart">Add to Cart</a>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    } else {
                        echo '<div class="col-md-12"><p>No featured products found</p></div>';
                    }
                    wp_reset_postdata();
                } else {
                    echo '<div class="col-md-12"><p>WooCommerce is not installed</p></div>';
                }
                ?>
            </div>
            
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn-red btn-lg">View All Products</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title">SUBSCRIBE FOR DISCOUNTS & DROPS</h2>
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
    </section>

    <!-- Social Media Section -->
    <section class="social-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="section-title">FOLLOW</h2>
                    <div class="social-icons">
                        <a href="#" target="_blank" class="social-icon"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank" class="social-icon"><i class="fa fa-instagram"></i></a>
                        <a href="#" target="_blank" class="social-icon"><i class="fa fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();