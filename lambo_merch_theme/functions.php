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
			'main_menu' => esc_html__( 'Main Menu', 'lambo-merch' ),
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
	// Add Source Sans Pro font with higher priority (1)
	wp_enqueue_style('source-sans-pro', 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap', array(), null, 'all');
	// Enqueue Georgia font (already available as system font)
	
	// Main stylesheet
	wp_enqueue_style( 'lambo-merch-style', get_stylesheet_uri(), array(), LAMBO_MERCH_VERSION );
	
	// Bootstrap CSS (if needed)
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.5.3' );
	
	// Font Awesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '5.15.1' );
	
	// Custom CSS
	wp_enqueue_style( 'lambo-merch-custom', get_template_directory_uri() . '/css/custom.css', array(), LAMBO_MERCH_VERSION );
	
	// Header Fixes CSS
	wp_enqueue_style( 'lambo-merch-header-fixes', get_template_directory_uri() . '/css/header-fixes.css', array(), LAMBO_MERCH_VERSION );
	
	// Menu Fixes CSS
	wp_enqueue_style( 'lambo-merch-menu-fixes', get_template_directory_uri() . '/css/menu-fixes.css', array(), LAMBO_MERCH_VERSION );
	
	// Header and Footer Font Overrides CSS - Load last to ensure it takes precedence
	wp_enqueue_style( 'lambo-merch-header-footer-fonts', get_template_directory_uri() . '/css/header-footer-fonts.css', array(), LAMBO_MERCH_VERSION );
	
	// Wishlist CSS and JS
	wp_enqueue_style( 'lambo-merch-wishlist', get_template_directory_uri() . '/css/wishlist.css', array(), LAMBO_MERCH_VERSION );
	
	// Add the ajaxurl to the head for all pages
	echo '<script type="text/javascript">
		var ajaxurl = "' . admin_url('admin-ajax.php') . '";
	</script>';
	
	// Enqueue the global wishlist script with higher priority to ensure it loads early
	wp_enqueue_script( 'lambo-merch-global-wishlist', get_template_directory_uri() . '/js/global-wishlist.js', array( 'jquery' ), LAMBO_MERCH_VERSION, false );
	wp_localize_script( 'lambo-merch-global-wishlist', 'lambo_wishlist_params', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );
	
	// Original wishlist script (now dependent on global wishlist script)
	wp_enqueue_script( 'lambo-merch-wishlist', get_template_directory_uri() . '/js/wishlist.js', array( 'jquery', 'lambo-merch-global-wishlist' ), LAMBO_MERCH_VERSION, true );
	wp_localize_script( 'lambo-merch-wishlist', 'lambo_wishlist_params', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	) );
	// Search CSS - load on all pages for FiboSearch integration
	wp_enqueue_style( 'lambo-merch-search', get_template_directory_uri() . '/css/search.css', array(), LAMBO_MERCH_VERSION );
	
	// My Account CSS and JS - only load on account pages
	if ( is_account_page() ) {
		wp_enqueue_style( 'lambo-merch-myaccount', get_template_directory_uri() . '/css/my-account.css', array(), LAMBO_MERCH_VERSION );
		wp_enqueue_script( 'lambo-merch-myaccount-js', get_template_directory_uri() . '/js/my-account.js', array( 'jquery' ), LAMBO_MERCH_VERSION, true );
		
		// Add a class to body for specific my account styling
		add_filter( 'body_class', function( $classes ) {
			$classes[] = 'lambo-myaccount-page';
			return $classes;
		});
	}
	
	// Checkout CSS and JS - only load on checkout page
	if ( is_checkout() || is_page_template( 'checkoutpage.php' ) ) {
		wp_enqueue_style( 'lambo-merch-checkout', get_template_directory_uri() . '/css/checkout.css', array(), LAMBO_MERCH_VERSION );
		wp_enqueue_script( 'lambo-merch-checkout-js', get_template_directory_uri() . '/js/checkout.js', array( 'jquery' ), LAMBO_MERCH_VERSION, true );
		
		// Add a class to body for specific checkout styling
		add_filter( 'body_class', function( $classes ) {
			$classes[] = 'lambo-checkout-page';
			return $classes;
		});
	}
	
	// Order Received / Thank You page CSS
	if ( is_wc_endpoint_url( 'order-received' ) ) {
		wp_enqueue_style( 'lambo-merch-order-received', get_template_directory_uri() . '/css/order-received.css', array(), LAMBO_MERCH_VERSION );
		
		// Add a class to body for specific order received styling
		add_filter( 'body_class', function( $classes ) {
			$classes[] = 'lambo-order-received-page';
			return $classes;
		});
		
		// Add extra head content for order-received page if the file exists
		$thankyou_head_file = get_template_directory() . '/woocommerce/checkout/thankyou-head.php';
		if (file_exists($thankyou_head_file)) {
			add_action('wp_head', function() use ($thankyou_head_file) {
				include_once($thankyou_head_file);
			}, 999);
		}
	}
	
	// Bootstrap JS
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '4.5.3', true );
	
	// Navigation script
	wp_enqueue_script( 'lambo-merch-navigation', get_template_directory_uri() . '/js/navigation.js', array(), LAMBO_MERCH_VERSION, true );

	// Custom scripts
	wp_enqueue_script( 'lambo-merch-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), LAMBO_MERCH_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Make sure ajaxurl is available
	?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
	<?php
	
	// Add simple favorites system script (replaces previous implementation)
	wp_enqueue_script( 'lambo-merch-simple-favorites', get_template_directory_uri() . '/js/simple-favorites.js', array( 'jquery' ), LAMBO_MERCH_VERSION, true );
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
 * Load simple favorites functions
 */
require get_template_directory() . '/inc/simple-favorites.php';

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


function lambomerch_enqueue_video_handler() {
    // Register the script (no dependencies)
    wp_register_script(
        'lambomerch-video', 
        get_template_directory_uri() . '/js/video-handler.js', 
        [], 
        '1.0', 
        true  // load in footer
    );
    wp_enqueue_script('lambomerch-video');
}
add_action('wp_enqueue_scripts', 'lambomerch_enqueue_video_handler');



/**
 * Redirect variable products to a custom template file
 * This hook runs before the template is loaded
 * DISABLED - using unified template approach instead
 */
// function lambo_merch_redirect_variable_products() {
//     // Only run on the single product page
//     if (!is_product()) {
//         return;
//     }
//     
//     global $post, $product;
//     
//     // Ensure we have a valid product
//     if (!is_object($product)) {
//         $product = wc_get_product($post->ID);
//     }
//     
//     // Check if this is a variable product
//     if (is_object($product) && $product->is_type('variable')) {
//         // Include our custom template instead of letting WooCommerce load the default
//         include(get_template_directory() . '/woocommerce/variable-product.php');
//         // Stop WordPress from loading any other templates
//         exit();
//     }
// }
// add_action('template_redirect', 'lambo_merch_redirect_variable_products', 999);

/**
 * Alternative approach using woocommerce_locate_template
 * This function redirects variable products to use the variable-product.php template
 * DISABLED - using unified template approach instead
 */
// function lambo_merch_variable_product_template($template, $template_name, $template_path) {
//     // Only modify the single product template
//     if ($template_name !== 'single-product.php') {
//         return $template;
//     }
//     
//     // Check if we're viewing a product
//     if (!is_product()) {
//         return $template;
//     }
//     
//     // Get the current product
//     global $product;
//     
//     // If product doesn't exist yet, try to get it from the global post
//     if (!is_object($product) || !is_a($product, 'WC_Product')) {
//         global $post;
//         if (is_object($post) && isset($post->ID)) {
//             $product = wc_get_product($post->ID);
//         }
//     }
//     
//     // If we have a valid product and it's a variable product
//     if (is_object($product) && is_a($product, 'WC_Product') && $product->is_type('variable')) {
//         $theme_dir = get_template_directory();
//         $variable_template = $theme_dir . '/woocommerce/variable-product.php';
//         
//         // If the template exists, use it instead of the default
//         if (file_exists($variable_template)) {
//             return $variable_template;
//         }
//     }
//     
//     return $template;
// }
// add_filter('woocommerce_locate_template', 'lambo_merch_variable_product_template', 999, 3);

/**
 * Register and load custom templates
 */
function lambo_merch_register_templates() {
    // Check if pages exist, if not create them
    $wishlist_page = get_page_by_path('wishlist');
    if (!$wishlist_page) {
        wp_insert_post(array(
            'post_title' => 'Favorites',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'wishlist',
        ));
    }
    
    $search_page = get_page_by_path('search');
    if (!$search_page) {
        wp_insert_post(array(
            'post_title' => 'Search',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'search',
        ));
    }
}
add_action('init', 'lambo_merch_register_templates');

/**
 * AJAX handler for adding products to cart from wishlist
 */
function lambo_merch_add_to_cart() {
    // Verify nonce
    if (isset($_POST['security'])) {
        $nonce_verified = wp_verify_nonce($_POST['security'], 'lambo_add_to_cart_nonce');
        
        if (!$nonce_verified) {
            // Try with WooCommerce nonce as fallback
            $nonce_verified = wp_verify_nonce($_POST['security'], 'woocommerce-add-to-cart');
            
            if (!$nonce_verified) {
                wp_send_json_error(array('message' => 'Security check failed'));
                return;
            }
        }
    }
    
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Product ID not provided'));
        return;
    }
    
    $product_id = absint($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
    
    // Check if the product exists and can be purchased
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(array('message' => 'Product does not exist'));
        return;
    }
    
    // For debugging
    error_log("Adding to cart: Product ID: $product_id, Quantity: $quantity");
    
    // Handle variable products
    if ($product->is_type('variable')) {
        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : 0;
        
        if ($variation_id > 0) {
            // If variation ID is provided, use it
            $variation = wc_get_product($variation_id);
            
            if (!$variation || $variation->get_parent_id() != $product_id) {
                wp_send_json_error(array('message' => 'Invalid variation ID'));
                return;
            }
            
            // For debugging
            error_log("Using variation ID: $variation_id");
            
            // Get variation attributes
            $variation_data = wc_get_product_variation_attributes($variation_id);
            
            // Add to cart
            $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation_data);
        } else {
            // If no variation ID provided, get the default variation
            $available_variations = $product->get_available_variations();
            
            if (!empty($available_variations)) {
                $variation_id = $available_variations[0]['variation_id'];
                $variation_data = wc_get_product_variation_attributes($variation_id);
                
                // For debugging
                error_log("Using default variation ID: $variation_id");
                
                $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation_data);
            } else {
                wp_send_json_error(array('message' => 'This product requires variation selection'));
                return;
            }
        }
    } else {
        // Simple product
        $added = WC()->cart->add_to_cart($product_id, $quantity);
    }
    
    if ($added) {
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();
        
        // Generate cart fragments
        $fragments = apply_filters(
            'woocommerce_add_to_cart_fragments',
            array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
            )
        );
        
        wp_send_json_success(array(
            'fragments' => $fragments,
            'cart_count' => WC()->cart->get_cart_contents_count(),
            'cart_hash' => WC()->cart->get_cart_hash(),
        ));
    } else {
        // Clear previous notices
        wc_clear_notices();
        
        // Get new notices
        $notices = wc_get_notices();
        $error_message = !empty($notices['error']) ? $notices['error'][0]['notice'] : 'Failed to add product to cart';
        
        error_log("Failed to add to cart. Error: $error_message");
        
        wp_send_json_error(array('message' => $error_message));
    }
    
    wp_die();
}
add_action('wp_ajax_lambo_add_to_cart', 'lambo_merch_add_to_cart');
add_action('wp_ajax_nopriv_lambo_add_to_cart', 'lambo_merch_add_to_cart');

/**
 * Product favorites handler - Set favorite status
 */
function lambo_set_product_favorite_status($product_id, $user_id, $status) {
    if (empty($product_id)) {
        return false;
    }
    
    // Ensure we're working with a valid product
    $product = wc_get_product($product_id);
    if (!$product) {
        return false;
    }
    
    // Convert status to boolean and then to string for more reliable storage
    $is_favorite = (bool) $status;
    $value_to_store = $is_favorite ? '1' : '0';
    
    // Get user-specific meta key
    $meta_key = 'lambo_favorite_' . $user_id;
    
    // First delete the existing meta to ensure a clean update
    delete_post_meta($product_id, $meta_key);
    
    // Then add the new meta value
    if ($is_favorite) {
        add_post_meta($product_id, $meta_key, $value_to_store, true);
    }
    
    // Log the update
    error_log(sprintf(
        'Updated product favorite status: Product ID: %d, User ID: %s, Status: %s, Stored Value: %s',
        $product_id,
        $user_id,
        $is_favorite ? 'true' : 'false',
        $value_to_store
    ));
    
    // Double check it was stored correctly
    $stored_value = get_post_meta($product_id, $meta_key, true);
    error_log('Direct check - Stored meta value: ' . var_export($stored_value, true));
    
    return true;
}

/**
 * Product favorites handler - Get favorite status
 */
function lambo_get_product_favorite_status($product_id, $user_id) {
    if (empty($product_id)) {
        return false;
    }
    
    // Get user-specific meta key
    $meta_key = 'lambo_favorite_' . $user_id;
    
    // Get the favorite status from product meta
    $is_favorite = get_post_meta($product_id, $meta_key, true);
    
    // Convert to boolean and return
    return (bool) $is_favorite;
}

/**
 * Get all favorite products for a user
 */
function lambo_get_favorite_products($user_id) {
    if (empty($user_id)) {
        error_log('Empty user ID provided to lambo_get_favorite_products');
        return array();
    }
    
    // Meta key for this user's favorites
    $meta_key = 'lambo_favorite_' . $user_id;
    error_log('Looking for favorites with meta key: ' . $meta_key);
    
    // Query products directly through SQL to ensure we get all matching products
    global $wpdb;
    
    $query = $wpdb->prepare("
        SELECT DISTINCT p.ID 
        FROM {$wpdb->posts} p
        JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
        WHERE p.post_type = 'product' 
        AND p.post_status = 'publish'
        AND pm.meta_key = %s
        AND pm.meta_value = '1'
    ", $meta_key);
    
    $product_ids = $wpdb->get_col($query);
    
    error_log('Direct SQL query found ' . count($product_ids) . ' favorite products');
    error_log('SQL Query: ' . $query);
    
    // Return the product IDs we found through direct SQL
    if (!empty($product_ids)) {
        error_log('Returning favorite products from SQL: ' . print_r($product_ids, true));
        return $product_ids;
    }
    
    // Fallback to WP_Query in case direct SQL doesn't work
    error_log('No products found via SQL, trying WP_Query...');
    
    // Query for products with this user's favorite meta key set to true
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => $meta_key,
                'value'   => '1',
                'compare' => '='
            )
        )
    );
    
    $query = new WP_Query($args);
    error_log('WP_Query found ' . $query->post_count . ' posts');
    error_log('WP_Query args: ' . print_r($args, true));
    
    // Return array of product IDs
    $favorite_products = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $favorite_products[] = get_the_ID();
        }
        wp_reset_postdata();
    }
    
    error_log('Returning favorite products from WP_Query: ' . print_r($favorite_products, true));
    return $favorite_products;
}

/**
 * Get a consistent guest ID for non-logged in users
 */
function lambo_get_guest_id() {
    // Check if we already have a guest ID in the cookie
    if (isset($_COOKIE['lambo_guest_id'])) {
        return 'guest_' . $_COOKIE['lambo_guest_id'];
    }
    
    // Generate a new guest ID
    $guest_id = md5(uniqid('guest_', true));
    
    // Set cookie for 30 days
    setcookie('lambo_guest_id', $guest_id, time() + (30 * DAY_IN_SECONDS), '/');
    
    return 'guest_' . $guest_id;
}

/**
 * AJAX handler for toggling favorite product status
 */
function lambo_toggle_favorite_product() {
    // Verify required data
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Product ID not provided'));
        return;
    }
    
    // Sanitize the product ID
    $product_id = absint($_POST['product_id']);
    error_log('Toggle favorite for product ID: ' . $product_id);
    
    // Get current user ID (use a consistent guest ID for non-logged-in users)
    $user_id = is_user_logged_in() ? get_current_user_id() : lambo_get_guest_id();
    error_log('User ID for favorite toggle: ' . $user_id);
    
    // Get current favorite status
    $current_status = lambo_get_product_favorite_status($product_id, $user_id);
    error_log('Current favorite status: ' . ($current_status ? 'true' : 'false'));
    
    // Toggle status (set to the opposite of current status)
    $new_status = !$current_status;
    error_log('New favorite status: ' . ($new_status ? 'true' : 'false'));
    
    // Update the favorite status
    $result = lambo_set_product_favorite_status($product_id, $user_id, $new_status);
    error_log('Set favorite status result: ' . ($result ? 'success' : 'failure'));
    
    // Force to update to refresh cache for this user
    wp_cache_flush();
    
    // Double-check the status was updated
    $check_status = lambo_get_product_favorite_status($product_id, $user_id);
    error_log('After update, favorite status is: ' . ($check_status ? 'true' : 'false'));
    
    // Verify product meta in database
    global $wpdb;
    $meta_key = 'lambo_favorite_' . $user_id;
    $meta_value = get_post_meta($product_id, $meta_key, true);
    error_log('Database meta value for ' . $meta_key . ' on product ' . $product_id . ': ' . var_export($meta_value, true));
    
    if ($result) {
        $all_favorites = lambo_get_favorite_products($user_id);
        error_log('All favorites after update: ' . print_r($all_favorites, true));
        
        wp_send_json_success(array(
            'message'     => $new_status ? 'Product added to favorites' : 'Product removed from favorites',
            'product_id'  => $product_id,
            'status'      => $new_status,
            'product_ids' => $all_favorites,
            'meta_key'    => $meta_key,
            'meta_value'  => $meta_value
        ));
    } else {
        wp_send_json_error(array('message' => 'Failed to update favorite status'));
    }
    
    wp_die();
}
add_action('wp_ajax_lambo_toggle_favorite', 'lambo_toggle_favorite_product');
add_action('wp_ajax_nopriv_lambo_toggle_favorite', 'lambo_toggle_favorite_product');

/**
 * AJAX handler for checking a product's favorite status
 */
function lambo_check_favorite_status() {
    // Verify required data
    if (!isset($_POST['product_id'])) {
        wp_send_json_error(array('message' => 'Product ID not provided'));
        return;
    }
    
    // Sanitize the product ID
    $product_id = absint($_POST['product_id']);
    
    // Get current user ID (use a consistent guest ID for non-logged-in users)
    $user_id = is_user_logged_in() ? get_current_user_id() : lambo_get_guest_id();
    
    // Get current favorite status
    $is_favorite = lambo_get_product_favorite_status($product_id, $user_id);
    
    wp_send_json_success(array(
        'product_id' => $product_id,
        'status'     => $is_favorite
    ));
    
    wp_die();
}
add_action('wp_ajax_lambo_check_favorite', 'lambo_check_favorite_status');
add_action('wp_ajax_nopriv_lambo_check_favorite', 'lambo_check_favorite_status');

/**
 * Clear all favorites for debugging if needed
 */
function lambo_clear_all_favorites() {
    global $wpdb;
    
    // Get all product meta keys related to favorites
    $meta_keys = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
            'lambo_favorite_%'
        )
    );
    
    // Delete all favorite meta data
    foreach ($meta_keys as $meta_key) {
        $wpdb->delete(
            $wpdb->postmeta,
            array('meta_key' => $meta_key),
            array('%s')
        );
    }
    
    return count($meta_keys);
}

/**
 * Debug function to check favorites data
 */
function lambo_debug_favorites() {
    global $wpdb;
    
    // Get user ID (guest or logged in)
    $user_id = is_user_logged_in() ? get_current_user_id() : lambo_get_guest_id();
    
    // Meta key for this user
    $meta_key = 'lambo_favorite_' . $user_id;
    
    // Get all favorites meta for this user
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT post_id, meta_key, meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s",
            $meta_key
        )
    );
    
    // Get all meta keys for favorites
    $all_favorite_keys = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT DISTINCT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",
            'lambo_favorite_%'
        )
    );
    
    return array(
        'user_id' => $user_id,
        'meta_key' => $meta_key,
        'favorites' => $results,
        'all_favorite_keys' => $all_favorite_keys
    );
}

/**
 * AJAX handler for debug favorites
 */
function lambo_ajax_debug_favorites() {
    $debug_data = lambo_debug_favorites();
    wp_send_json_success($debug_data);
    wp_die();
}
add_action('wp_ajax_lambo_debug_favorites', 'lambo_ajax_debug_favorites');
add_action('wp_ajax_nopriv_lambo_debug_favorites', 'lambo_ajax_debug_favorites');

/**
 * Legacy AJAX handler for updating user wishlist
 * Kept for backward compatibility
 */
function lambo_merch_update_user_wishlist() {
    if (!isset($_POST['wishlist'])) {
        wp_send_json_error(array('message' => 'Wishlist data not provided'));
        return;
    }
    
    $wishlist = $_POST['wishlist'];
    
    // Validate the wishlist data
    if (!is_array($wishlist)) {
        // Try to decode if it's a JSON string
        $wishlist = json_decode(stripslashes($wishlist), true);
        
        if (!is_array($wishlist)) {
            $wishlist = array();
        }
    }
    
    // Sanitize the wishlist array - ensure all items are strings for consistency
    $sanitized_wishlist = array();
    foreach ($wishlist as $item) {
        if (!empty($item)) {
            // Convert to string to maintain consistency with JavaScript
            $sanitized_wishlist[] = (string) $item;
        }
    }
    
    // Debug log
    error_log('Updating wishlist: ' . print_r($sanitized_wishlist, true));
    
    // For logged-in users, update user meta
    if (is_user_logged_in()) {
        $current_user_id = get_current_user_id();
        // First, completely delete the meta to avoid stale data
        delete_user_meta($current_user_id, 'lambo_wishlist');
        // Then add the new wishlist data
        update_user_meta($current_user_id, 'lambo_wishlist', $sanitized_wishlist);
        error_log("Updated wishlist for user ID $current_user_id with data: " . print_r($sanitized_wishlist, true));
    }
    
    // The cookie is handled by JavaScript, so we only need to acknowledge the update
    wp_send_json_success(array(
        'message' => 'Wishlist updated successfully',
        'wishlist' => $sanitized_wishlist,
        'user_logged_in' => is_user_logged_in()
    ));
    wp_die();
}
add_action('wp_ajax_lambo_update_user_wishlist', 'lambo_merch_update_user_wishlist');
add_action('wp_ajax_nopriv_lambo_update_user_wishlist', 'lambo_merch_update_user_wishlist');

/**
 * Disable FiboSearch form submission on Enter key
 * This keeps only the suggestions dropdown active
 */
add_filter('dgwt/wcas/scripts/disable_submit', '__return_true');

/**
 * Handle FiboSearch redirections to prevent critical errors
 * This redirects FiboSearch queries to our custom search results template
 */
function lambo_merch_handle_fibosearch_redirect() {
    // Check if this is a FiboSearch query
    if (isset($_GET['dgwt_wcas']) && isset($_GET['s'])) {
        // Get the search query
        $search_query = sanitize_text_field($_GET['s']);
        $post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : 'product';
        
        // First, try to find the FiboSearch results page
        $fibo_page = get_page_by_path('fibosearch-results');
        
        if ($fibo_page) {
            // Use the FiboSearch results page
            $search_page_url = get_permalink($fibo_page->ID);
        } else {
            // Fallback to search debug page
            $debug_page = get_page_by_path('search-debug');
            if ($debug_page) {
                $search_page_url = get_permalink($debug_page->ID);
            } else {
                // Last resort - standard search page
                $search_page_url = home_url('/search-2/');
            }
        }
        
        // Build redirect URL with search parameters
        $redirect_url = add_query_arg(array(
            's' => $search_query,
            'post_type' => $post_type,
            'dgwt_search' => '1', // Mark as coming from FiboSearch
        ), $search_page_url);
        
        wp_safe_redirect($redirect_url);
        exit;
    }
}
add_action('template_redirect', 'lambo_merch_handle_fibosearch_redirect', 5);

/**
 * Register the search templates as pages in WordPress
 */
function lambo_merch_register_search_pages() {
    // Check if fibosearch-results page exists
    $fibo_page = get_page_by_path('fibosearch-results');
    if (!$fibo_page) {
        // Create FiboSearch results page
        wp_insert_post(array(
            'post_title'     => 'FiboSearch Results',
            'post_name'      => 'fibosearch-results',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template'  => 'fibosearch-results.php',
        ));
    }
    
    // Check if search-debug page exists
    $debug_page = get_page_by_path('search-debug');
    if (!$debug_page) {
        // Create search debug page
        wp_insert_post(array(
            'post_title'     => 'Search Debug',
            'post_name'      => 'search-debug',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template'  => 'search-debug.php',
        ));
    }
}

/**
 * Add pre_get_posts filter to ensure search works correctly
 */
function lambo_merch_search_products($query) {
    // Only modify search queries on the frontend
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        // Set post_type to product for all searches coming from FiboSearch
        if (isset($_GET['dgwt_wcas']) || isset($_GET['post_type']) && $_GET['post_type'] == 'product') {
            $query->set('post_type', 'product');
            
            // Add product visibility taxonomy filter for better results
            $tax_query = array(
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'exclude-from-search',
                    'operator' => 'NOT IN',
                ),
            );
            $query->set('tax_query', $tax_query);
        }
    }
    return $query;
}
add_filter('pre_get_posts', 'lambo_merch_search_products');

/**
 * Make sure FiboSearch's AJAX works properly
 */
function lambo_merch_fibosearch_ajax_support() {
    // This ensures the AJAX search functionality works correctly
    if (class_exists('DgoraWcas\\Engines\\TNTSearchMySQL\\Config')) {
        // For TNT Search engine support
        add_filter('dgwt/wcas/tnt/mysql/indexer/taxonomies', function($taxonomies) {
            return array('product_cat', 'product_tag');
        });
    }
}
add_action('init', 'lambo_merch_fibosearch_ajax_support');

// Register search pages on init
add_action('init', 'lambo_merch_register_search_pages');

/**
 * Additional FiboSearch configuration and fixes
 */
function lambo_merch_fibosearch_config() {
    // Only proceed if FiboSearch is active
    if (!class_exists('DgoraWcas\\Multilingual')) {
        return;
    }
    
    // 1. Set search results page to our custom template
    add_filter('dgwt/wcas/settings/load_value/key=search_results_page', function($value) {
        $page = get_page_by_path('fibosearch-results');
        if ($page) {
            return $page->ID;
        }
        return $value;
    });
    
    // 2. Disable FiboSearch form AJAX submission to use standard form with our redirection
    add_filter('dgwt/wcas/scripts/use_ajax_for_form_submission', '__return_false');

    // 3. Add custom class to FiboSearch form for easier styling
    add_filter('dgwt/wcas/form/classes', function($classes) {
        $classes[] = 'lambo-fibosearch-form';
        return $classes;
    });
    
    // 4. Increase number of suggestions shown
    add_filter('dgwt/wcas/settings/load_value/key=suggestions_limit', function() {
        return 10; // Show 10 search suggestions
    });
    
    // 5. Make sure form redirection works properly
    add_filter('dgwt/wcas/form/action', function($action) {
        return home_url('/'); // Base form action to home URL
    });

    // 6. Add hidden fields to ensure search works
    add_action('dgwt/wcas/search_form/after', function() {
        echo '<input type="hidden" name="post_type" value="product">';
    });
}
add_action('init', 'lambo_merch_fibosearch_config');

/**
 * Properly handle checkout redirection to order received page
 */
function lambo_merch_checkout_redirect_to_thankyou() {
    // If we're already on the order-received endpoint, do nothing - let templates handle it
    if (is_wc_endpoint_url('order-received')) {
        return;
    }
    
    // For order completion, ensure we redirect properly
    if (is_checkout() && isset($_POST['woocommerce-process-checkout-nonce'])) {
        add_action('woocommerce_thankyou', function($order_id) {
            $order = wc_get_order($order_id);
            if ($order) {
                // Force redirect to the order-received page with our template
                $thankyou_url = $order->get_checkout_order_received_url();
                wp_redirect($thankyou_url);
                exit;
            }
        }, 1); // Priority 1 to run before anything else
    }
}
add_action('template_redirect', 'lambo_merch_checkout_redirect_to_thankyou', 5);

/**
 * Override WooCommerce get_checkout_url to ensure redirections work correctly
 */
function lambo_merch_override_checkout_url($url) {
    // If we've just processed a checkout, redirect to order received page
    if (isset($_GET['order-received']) && !empty($_GET['order-received'])) {
        $order_id = absint($_GET['order-received']);
        $order_key = isset($_GET['key']) ? wc_clean($_GET['key']) : '';
        
        if ($order_id > 0) {
            $order = wc_get_order($order_id);
            if ($order && $order->get_order_key() === $order_key) {
                return $order->get_checkout_order_received_url();
            }
        }
    }
    
    return $url;
}
add_filter('woocommerce_get_checkout_url', 'lambo_merch_override_checkout_url', 99);

/**
 * Fix shipping address handling in checkout
 * Ensure ship_to_different_address is properly processed
 */
function lambo_merch_fix_shipping_address($order_id) {
    // Only run on checkout submission
    if (!is_checkout() || !did_action('woocommerce_checkout_order_processed')) {
        return;
    }
    
    // Get the order
    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }
    
    // Check if shipping to different address
    $ship_to_different = !empty($_POST['ship_to_different_address']);
    
    // If shipping to different address, ensure shipping fields are used
    if ($ship_to_different && isset($_POST['shipping_first_name'])) {
        // Retrieve shipping fields from POST
        $shipping_fields = array(
            'first_name'    => isset($_POST['shipping_first_name']) ? sanitize_text_field($_POST['shipping_first_name']) : '',
            'last_name'     => isset($_POST['shipping_last_name']) ? sanitize_text_field($_POST['shipping_last_name']) : '',
            'company'       => isset($_POST['shipping_company']) ? sanitize_text_field($_POST['shipping_company']) : '',
            'address_1'     => isset($_POST['shipping_address_1']) ? sanitize_text_field($_POST['shipping_address_1']) : '',
            'address_2'     => isset($_POST['shipping_address_2']) ? sanitize_text_field($_POST['shipping_address_2']) : '',
            'city'          => isset($_POST['shipping_city']) ? sanitize_text_field($_POST['shipping_city']) : '',
            'state'         => isset($_POST['shipping_state']) ? sanitize_text_field($_POST['shipping_state']) : '',
            'postcode'      => isset($_POST['shipping_postcode']) ? sanitize_text_field($_POST['shipping_postcode']) : '',
            'country'       => isset($_POST['shipping_country']) ? sanitize_text_field($_POST['shipping_country']) : '',
        );
        
        // Update order shipping address
        foreach ($shipping_fields as $key => $value) {
            if (!empty($value)) {
                update_post_meta($order_id, '_shipping_' . $key, $value);
            }
        }
    } elseif (!$ship_to_different) {
        // If shipping to same address, copy billing address to shipping
        $billing_fields = array(
            'first_name', 'last_name', 'company', 'address_1', 'address_2', 
            'city', 'state', 'postcode', 'country'
        );
        
        foreach ($billing_fields as $field) {
            // Use dynamic method name to get billing field value
            $getter = 'get_billing_' . $field;
            $billing_value = $order->$getter();
            if (!empty($billing_value)) {
                update_post_meta($order_id, '_shipping_' . $field, $billing_value);
            }
        }
    }
}
add_action('woocommerce_checkout_update_order_meta', 'lambo_merch_fix_shipping_address', 20);

/**
 * Handle "ship to different address" checkbox in checkout
 */
function lambo_merch_handle_shipping_fields($fields) {
    // If set to ship to different address, ensure those fields are required
    if (!empty($_POST['ship_to_different_address']) && $_POST['ship_to_different_address'] == '1') {
        // Get shipping field keys
        $shipping_fields = array(
            'shipping_first_name', 'shipping_last_name', 'shipping_address_1',
            'shipping_city', 'shipping_postcode', 'shipping_country', 'shipping_state'
        );
        
        // Make them required if shipping to different address
        foreach ($shipping_fields as $field_key) {
            if (isset($fields[$field_key])) {
                $fields[$field_key]['required'] = true;
            }
        }
    }
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'lambo_merch_handle_shipping_fields', 20);

/**
 * Fix address copying - explicitly copy billing to shipping when needed
 */
function lambo_merch_copy_billing_to_shipping($order, $data) {
    // If not shipping to different address, copy billing to shipping
    if (empty($data['ship_to_different_address'])) {
        // Fields to copy
        $fields = array(
            'first_name', 'last_name', 'company', 'address_1', 'address_2',
            'city', 'state', 'postcode', 'country'
        );
        
        foreach ($fields as $field) {
            // Use setter methods to update shipping fields
            $billing_getter = 'get_billing_' . $field;
            $shipping_setter = 'set_shipping_' . $field;
            
            if (method_exists($order, $billing_getter) && method_exists($order, $shipping_setter)) {
                $order->$shipping_setter($order->$billing_getter());
            }
        }
    }
    
    return $order;
}
add_filter('woocommerce_checkout_create_order', 'lambo_merch_copy_billing_to_shipping', 10, 2);

