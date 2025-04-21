<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Lambo_Merch
 */

// Body classes are defined in functions.php

// Pingback header function is defined in functions.php

// Mobile Detect library is included in functions.php

/**
 * Change number of products per row in WooCommerce
 */
function lambo_merch_loop_columns() {
	return 3; // 3 products per row
}
add_filter( 'loop_shop_columns', 'lambo_merch_loop_columns' );

/**
 * Add custom WooCommerce button classes
 */
function lambo_merch_woocommerce_button_classes( $button, $product ) {
	$button = str_replace( 'button', 'button btn btn-red', $button );
	return $button;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'lambo_merch_woocommerce_button_classes', 10, 2 );

/**
 * Modify WooCommerce breadcrumbs
 */
function lambo_merch_woocommerce_breadcrumbs() {
	return array(
		'delimiter'   => ' &rsaquo; ',
		'wrap_before' => '<nav class="woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'lambo-merch' ),
	);
}
add_filter( 'woocommerce_breadcrumb_defaults', 'lambo_merch_woocommerce_breadcrumbs' );

// Custom excerpt function is defined in functions.php

/**
 * Add link to WooCommerce shop page when in admin menu
 */
function lambo_merch_shop_menu_highlight( $parent_file ) {
	global $menu, $submenu, $pagenow, $post;

	if ( isset( $post ) && $post->post_type === 'product' ) {
		$parent_file = 'edit.php?post_type=product';
	}

	return $parent_file;
}
add_filter( 'parent_file', 'lambo_merch_shop_menu_highlight' );
