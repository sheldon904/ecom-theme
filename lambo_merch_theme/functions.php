<?php
/**
 * Lambo Merch functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Lambo_Merch
 */

if ( ! defined( 'LAMBO_MERCH_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'LAMBO_MERCH_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function lambo_merch_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'lambo-merch', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// Custom image sizes for the theme
	add_image_size( 'lambo-featured', 1200, 600, true );
	add_image_size( 'lambo-product', 600, 600, true );
	add_image_size( 'lambo-thumbnail', 300, 300, true );

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'lambo-merch' ),
			'footer' => esc_html__( 'Footer Menu', 'lambo-merch' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'lambo_merch_custom_background_args',
			array(
				'default-color' => '000000',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'lambo_merch_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lambo_merch_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lambo_merch_content_width', 1200 );
}
add_action( 'after_setup_theme', 'lambo_merch_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lambo_merch_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'lambo-merch' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'lambo-merch' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'lambo-merch' ),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Add widgets here for the shop page.', 'lambo-merch' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'lambo-merch' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'First footer widget area', 'lambo-merch' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'lambo-merch' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Second footer widget area', 'lambo-merch' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'lambo-merch' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Third footer widget area', 'lambo-merch' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="footer-widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'lambo_merch_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lambo_merch_scripts() {
	// Enqueue Google Fonts
	wp_enqueue_style( 'lambo-merch-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap', array(), null );
	
	// Main stylesheet
	wp_enqueue_style( 'lambo-merch-style', get_stylesheet_uri(), array(), LAMBO_MERCH_VERSION );
	
	// Bootstrap CSS (if needed)
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.5.3' );
	
	// Font Awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '5.15.1' );
	
	// Custom CSS
	wp_enqueue_style( 'lambo-merch-custom', get_template_directory_uri() . '/css/custom.css', array(), LAMBO_MERCH_VERSION );
	
	// Bootstrap JS
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '4.5.3', true );
	
	// Navigation script
	wp_enqueue_script( 'lambo-merch-navigation', get_template_directory_uri() . '/js/navigation.js', array(), LAMBO_MERCH_VERSION, true );

	// Custom scripts
	wp_enqueue_script( 'lambo-merch-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), LAMBO_MERCH_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lambo_merch_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load custom walker for Bootstrap navigation
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Add Mobile Detect library
 */
require get_template_directory() . '/inc/mobile-detect.php';

/**
 * Implement custom Walker Class for Bootstrap nav menu
 */
class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Start Level
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	/**
	 * Start Element
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$li_attributes = '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Add active class
		if ( in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-parent', $classes ) ) {
			$classes[] = 'active';
		}

		// Add dropdown class to li if has children
		if ( $args->has_children ) {
			$classes[] = 'dropdown';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		// Add dropdown toggle for parent menu items
		if ( $args->has_children && $depth === 0 ) {
			$attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		// Add caret for dropdown menu
		if ( $args->has_children && $depth === 0 ) {
			$item_output .= ' <span class="caret"></span>';
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Display Element
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		// Display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = !empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = !empty( $children_elements[$element->$id_field] );

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// Descend only when the depth is right and there are children for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
			foreach( $children_elements[ $id ] as $child ){
				if ( !isset($newlevel) ) {
					$newlevel = true;
					// Start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array($this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			// End the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array($this, 'end_lvl'), $cb_args);
		}

		// End this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array($this, 'end_el'), $cb_args);
	}
}

/**
 * Register Custom Navigation Walker
 */
function register_navwalker() {
	require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

/**
 * Add custom body classes
 * 
 * @param array $classes Classes for the body element.
 * @return array
 */
function lambo_merch_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add a class if the site is viewed on mobile
	$detect = new Mobile_Detect();
	if ( $detect->isMobile() && !$detect->isTablet() ) {
		$classes[] = 'is-mobile';
	} elseif ( $detect->isTablet() ) {
		$classes[] = 'is-tablet';
	}

	// Add class for WooCommerce pages
	if ( class_exists( 'WooCommerce' ) ) {
		if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
			$classes[] = 'woocommerce-page';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'lambo_merch_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function lambo_merch_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'lambo_merch_pingback_header' );

/**
 * Change number of products that are displayed per page (shop page)
 */
function lambo_merch_shop_per_page( $cols ) {
	return 12;
}
add_filter( 'loop_shop_per_page', 'lambo_merch_shop_per_page', 20 );

/**
 * Add custom image sizes to media library
 */
function lambo_merch_custom_image_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'lambo-featured' => __( 'Lambo Featured', 'lambo-merch' ),
		'lambo-product' => __( 'Lambo Product', 'lambo-merch' ),
		'lambo-thumbnail' => __( 'Lambo Thumbnail', 'lambo-merch' ),
	) );
}
add_filter( 'image_size_names_choose', 'lambo_merch_custom_image_sizes' );

/**
 * Modify WooCommerce "Related Products" output
 */
function lambo_merch_related_products_args( $args ) {
	$args['posts_per_page'] = 4; // 4 related products
	$args['columns'] = 4; // arranged in 4 columns
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'lambo_merch_related_products_args' );

/**
 * Custom function to display limited excerpt
 */
function lambo_merch_excerpt( $limit ) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if ( count($excerpt) >= $limit ) {
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt) . '...';
	} else {
		$excerpt = implode(" ", $excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
	return $excerpt;
}

/**
 * Custom pagination for blog posts
 */
function lambo_merch_pagination() {
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	
	echo '<div class="pagination">';
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'type' => 'list'
	) );
	echo '</div>';
}

/**
 * Register custom post types
 */
function lambo_merch_register_post_types() {
	// Custom post type for Testimonials
	register_post_type( 'testimonial',
		array(
			'labels' => array(
				'name' => __( 'Testimonials', 'lambo-merch' ),
				'singular_name' => __( 'Testimonial', 'lambo-merch' ),
				'add_new' => __( 'Add New', 'lambo-merch' ),
				'add_new_item' => __( 'Add New Testimonial', 'lambo-merch' ),
				'edit_item' => __( 'Edit Testimonial', 'lambo-merch' ),
				'new_item' => __( 'New Testimonial', 'lambo-merch' ),
				'view_item' => __( 'View Testimonial', 'lambo-merch' ),
				'search_items' => __( 'Search Testimonials', 'lambo-merch' ),
				'not_found' => __( 'No testimonials found', 'lambo-merch' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash', 'lambo-merch' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-format-quote',
			'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'rewrite' => array( 'slug' => 'testimonials' ),
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'lambo_merch_register_post_types' );

/**
 * Add shortcode for displaying testimonials
 */
function lambo_merch_testimonials_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'count' => 3,
		'order' => 'DESC',
		'orderby' => 'date',
	), $atts, 'testimonials' );
	
	$args = array(
		'post_type' => 'testimonial',
		'posts_per_page' => $atts['count'],
		'order' => $atts['order'],
		'orderby' => $atts['orderby'],
	);
	
	$testimonials = new WP_Query( $args );
	
	$output = '<div class="testimonials-carousel">';
	
	if ( $testimonials->have_posts() ) {
		while ( $testimonials->have_posts() ) {
			$testimonials->the_post();
			
			$output .= '<div class="testimonial-item">';
			$output .= '<div class="testimonial-content">' . get_the_content() . '</div>';
			$output .= '<div class="testimonial-author">' . get_the_title() . '</div>';
			if ( has_post_thumbnail() ) {
				$output .= '<div class="testimonial-image">' . get_the_post_thumbnail( get_the_ID(), 'thumbnail' ) . '</div>';
			}
			$output .= '</div>';
		}
	}
	
	$output .= '</div>';
	
	wp_reset_postdata();
	
	return $output;
}
add_shortcode( 'testimonials', 'lambo_merch_testimonials_shortcode' );

/**
 * Add shortcode for displaying featured products
 */
function lambo_merch_featured_products_shortcode( $atts ) {
	if ( !class_exists( 'WooCommerce' ) ) {
		return '<p>' . __( 'WooCommerce is not active', 'lambo-merch' ) . '</p>';
	}
	
	$atts = shortcode_atts( array(
		'count' => 4,
		'columns' => 4,
		'category' => '',
	), $atts, 'featured_products' );
	
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $atts['count'],
		'tax_query' => array(
			array(
				'taxonomy' => 'product_visibility',
				'field' => 'name',
				'terms' => 'featured',
				'operator' => 'IN',
			),
		),
	);
	
	if ( !empty( $atts['category'] ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => explode( ',', $atts['category'] ),
		);
	}
	
	$products = new WP_Query( $args );
	
	$output = '<div class="woocommerce columns-' . $atts['columns'] . '">';
	$output .= '<ul class="products columns-' . $atts['columns'] . '">';
	
	if ( $products->have_posts() ) {
		while ( $products->have_posts() ) {
			$products->the_post();
			global $product;
			
			$output .= '<li class="product">';
			$output .= '<a href="' . get_permalink() . '">';
			$output .= woocommerce_get_product_thumbnail();
			$output .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
			$output .= '</a>';
			$output .= '<span class="price">' . $product->get_price_html() . '</span>';
			$output .= '<a href="' . esc_url( $product->add_to_cart_url() ) . '" class="button add_to_cart_button">' . esc_html__( 'Add to cart', 'lambo-merch' ) . '</a>';
			$output .= '</li>';
		}
	}
	
	$output .= '</ul>';
	$output .= '</div>';
	
	wp_reset_postdata();
	
	return $output;
}
add_shortcode( 'featured_products', 'lambo_merch_featured_products_shortcode' );