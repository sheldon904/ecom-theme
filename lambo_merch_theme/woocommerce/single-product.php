<?php
/**
 * The Template for displaying all single products
 *
 * @package Lambo_Merch
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

get_header('shop');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            /**
             * woocommerce_before_main_content hook.
             */
            do_action('woocommerce_before_main_content');
            ?>

            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                
                <?php wc_get_template_part('content', 'single-product'); ?>
                
            <?php endwhile; // end of the loop. ?>

            <?php
            /**
             * woocommerce_after_main_content hook.
             */
            do_action('woocommerce_after_main_content');
            ?>
        </div>
    </div>
</div>

<?php
get_footer('shop');