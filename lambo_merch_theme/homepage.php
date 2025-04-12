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
?>

<main id="primary" class="site-main">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-12 text-center">
                <img src="http://ecom-test.local/wp-content/uploads/2025/04/Big_LM_logo.png" alt="Lamborghini Merch Logo" class="img-fluid" />
                <h1 style="font-family: 'Georgia', serif; font-style: italic;">Luxury Merch for Lambo Enthusiasts</h1>
            </div>
            
            <div class="col-12 text-center position-relative">
                <!-- T-shirt box with SHOP NOW button overlay -->
                <div class="shop-box-container">
                    <img src="http://ecom-test.local/wp-content/uploads/2025/04/Shop_Box.png" alt="Lamborghini T-shirts for sale shop box" class="img-responsive centerimage" />
                    <a href="/shop" class="shop-now-button">SHOP NOW</a>
                </div>
            </div>
            
            <div class="col-12 p-0">
                <!-- Video image that stays centered -->
                <div class="video-container">
                    <img src="http://ecom-test.local/wp-content/uploads/2025/04/Video.png" alt="Lamborghini Video" />
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();