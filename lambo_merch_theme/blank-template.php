<?php
/**
 * Template Name: General Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package Lambo_Merch
 * 
 * 
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content();
endwhile; 
 ?>
<?php get_footer(); ?>