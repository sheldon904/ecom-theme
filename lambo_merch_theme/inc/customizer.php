<?php
/**
 * Lambo Merch Theme Customizer
 *
 * @package Lambo_Merch
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function lambo_merch_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'lambo_merch_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'lambo_merch_customize_partial_blogdescription',
			)
		);
	}

	// Add Theme Options Panel
	$wp_customize->add_panel(
		'lambo_merch_theme_options',
		array(
			'title'       => esc_html__( 'Theme Options', 'lambo-merch' ),
			'description' => esc_html__( 'Configure theme settings', 'lambo-merch' ),
			'priority'    => 130,
		)
	);

	// Header Options Section
	$wp_customize->add_section(
		'lambo_merch_header_options',
		array(
			'title'    => esc_html__( 'Header Options', 'lambo-merch' ),
			'panel'    => 'lambo_merch_theme_options',
			'priority' => 10,
		)
	);

	// Footer Options Section
	$wp_customize->add_section(
		'lambo_merch_footer_options',
		array(
			'title'    => esc_html__( 'Footer Options', 'lambo-merch' ),
			'panel'    => 'lambo_merch_theme_options',
			'priority' => 20,
		)
	);

	// Social Media Section
	$wp_customize->add_section(
		'lambo_merch_social_options',
		array(
			'title'    => esc_html__( 'Social Media', 'lambo-merch' ),
			'panel'    => 'lambo_merch_theme_options',
			'priority' => 30,
		)
	);

	// Homepage Section
	$wp_customize->add_section(
		'lambo_merch_homepage_options',
		array(
			'title'    => esc_html__( 'Homepage Options', 'lambo-merch' ),
			'panel'    => 'lambo_merch_theme_options',
			'priority' => 40,
		)
	);

	// Contact Info Section
	$wp_customize->add_section(
		'lambo_merch_contact_options',
		array(
			'title'    => esc_html__( 'Contact Information', 'lambo-merch' ),
			'panel'    => 'lambo_merch_theme_options',
			'priority' => 50,
		)
	);

	// Footer Copyright Text
	$wp_customize->add_setting(
		'lambo_merch_footer_copyright',
		array(
			'default'           => '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_footer_copyright',
		array(
			'label'       => esc_html__( 'Footer Copyright Text', 'lambo-merch' ),
			'section'     => 'lambo_merch_footer_options',
			'type'        => 'textarea',
			'description' => esc_html__( 'Enter your copyright text here. You can use HTML.', 'lambo-merch' ),
		)
	);

	// Social Media - Facebook
	$wp_customize->add_setting(
		'lambo_merch_facebook_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_facebook_url',
		array(
			'label'   => esc_html__( 'Facebook URL', 'lambo-merch' ),
			'section' => 'lambo_merch_social_options',
			'type'    => 'url',
		)
	);

	// Social Media - Instagram
	$wp_customize->add_setting(
		'lambo_merch_instagram_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_instagram_url',
		array(
			'label'   => esc_html__( 'Instagram URL', 'lambo-merch' ),
			'section' => 'lambo_merch_social_options',
			'type'    => 'url',
		)
	);

	// Social Media - YouTube
	$wp_customize->add_setting(
		'lambo_merch_youtube_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_youtube_url',
		array(
			'label'   => esc_html__( 'YouTube URL', 'lambo-merch' ),
			'section' => 'lambo_merch_social_options',
			'type'    => 'url',
		)
	);

	// Contact Email
	$wp_customize->add_setting(
		'lambo_merch_contact_email',
		array(
			'default'           => 'info@lambomerch.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_contact_email',
		array(
			'label'   => esc_html__( 'Contact Email', 'lambo-merch' ),
			'section' => 'lambo_merch_contact_options',
			'type'    => 'email',
		)
	);

	// Contact Phone
	$wp_customize->add_setting(
		'lambo_merch_contact_phone',
		array(
			'default'           => '+1 (800) LAMBO-MERCH',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_contact_phone',
		array(
			'label'   => esc_html__( 'Contact Phone', 'lambo-merch' ),
			'section' => 'lambo_merch_contact_options',
			'type'    => 'text',
		)
	);

	// Homepage Hero Title
	$wp_customize->add_setting(
		'lambo_merch_hero_title',
		array(
			'default'           => 'Luxury Merch for Lambo Enthusiasts',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_hero_title',
		array(
			'label'   => esc_html__( 'Hero Title', 'lambo-merch' ),
			'section' => 'lambo_merch_homepage_options',
			'type'    => 'text',
		)
	);

	// Homepage CTA Button Text
	$wp_customize->add_setting(
		'lambo_merch_cta_text',
		array(
			'default'           => 'SHOP NOW',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_cta_text',
		array(
			'label'   => esc_html__( 'CTA Button Text', 'lambo-merch' ),
			'section' => 'lambo_merch_homepage_options',
			'type'    => 'text',
		)
	);

	// Homepage CTA Button URL
	$wp_customize->add_setting(
		'lambo_merch_cta_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'lambo_merch_cta_url',
		array(
			'label'       => esc_html__( 'CTA Button URL', 'lambo-merch' ),
			'section'     => 'lambo_merch_homepage_options',
			'type'        => 'url',
			'description' => esc_html__( 'Leave empty to link to the shop page', 'lambo-merch' ),
		)
	);
}
add_action( 'customize_register', 'lambo_merch_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function lambo_merch_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function lambo_merch_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function lambo_merch_customize_preview_js() {
	wp_enqueue_script( 'lambo-merch-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), LAMBO_MERCH_VERSION, true );
}
add_action( 'customize_preview_init', 'lambo_merch_customize_preview_js' );

/**
 * Get customizer setting value
 */
function lambo_merch_get_option( $key, $default = '' ) {
	$value = get_theme_mod( $key, $default );
	return $value;
}