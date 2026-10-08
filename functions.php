<?php
/**
 * Starter Demo theme setup.
 *
 * @package Starter_Demo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme supports and menus.
 */
function starter_demo_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	// Same stylesheet in the editor, so pages look the same while editing.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary menu', 'starter-demo' ),
			'footer'  => __( 'Footer menu', 'starter-demo' ),
		)
	);
}
add_action( 'after_setup_theme', 'starter_demo_setup' );

/**
 * Front-end assets. filemtime() busts the cache after every deploy.
 */
function starter_demo_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'starter-demo-main', $uri . '/assets/css/main.css', array(), (string) filemtime( $dir . '/assets/css/main.css' ) );
	wp_enqueue_script( 'starter-demo-main', $uri . '/assets/js/main.js', array(), (string) filemtime( $dir . '/assets/js/main.js' ), array( 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'starter_demo_assets' );

/**
 * Own category for the section patterns in the block inserter.
 * Files in /patterns are registered by WordPress automatically.
 */
function starter_demo_pattern_category() {
	register_block_pattern_category( 'starter-demo', array( 'label' => __( 'Site sections', 'starter-demo' ) ) );
}
add_action( 'init', 'starter_demo_pattern_category' );

/**
 * Render a pattern file to plain block markup (strips the PHP header).
 *
 * @param string $name Pattern file name without extension.
 * @return string
 */
function starter_demo_pattern_markup( $name ) {
	$file = get_template_directory() . '/patterns/' . $name . '.php';

	if ( ! file_exists( $file ) ) {
		return '';
	}

	ob_start();
	include $file;
	return trim( (string) ob_get_clean() );
}

/**
 * On first activation: create Home and Contact pages from the patterns,
 * set Home as the front page and build a primary menu. Runs once.
 */
function starter_demo_create_demo_content() {
	if ( get_option( 'starter_demo_content_created' ) ) {
		return;
	}

	$pages = array(
		'home'    => array(
			'title'    => 'Home',
			'patterns' => array( 'hero', 'features', 'testimonials', 'cta' ),
		),
		'contact' => array(
			'title'    => 'Contact',
			'patterns' => array( 'contact' ),
		),
	);

	$ids = array();

	foreach ( $pages as $slug => $page ) {
		$existing = get_page_by_path( $slug );

		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}

		$content = implode( "\n\n", array_map( 'starter_demo_pattern_markup', $page['patterns'] ) );

		$ids[ $slug ] = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => $content,
			)
		);
	}

	if ( ! empty( $ids['home'] ) && ! is_wp_error( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $ids['home'] );
	}

	// Primary menu: Home + Contact.
	$locations = get_theme_mod( 'nav_menu_locations', array() );

	if ( empty( $locations['primary'] ) ) {
		$menu_id = wp_create_nav_menu( 'Primary' );

		if ( ! is_wp_error( $menu_id ) ) {
			foreach ( $ids as $page_id ) {
				if ( $page_id && ! is_wp_error( $page_id ) ) {
					wp_update_nav_menu_item(
						$menu_id,
						0,
						array(
							'menu-item-object-id' => (int) $page_id,
							'menu-item-object'    => 'page',
							'menu-item-type'      => 'post_type',
							'menu-item-status'    => 'publish',
						)
					);
				}
			}

			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	update_option( 'starter_demo_content_created', 1 );
}
add_action( 'after_switch_theme', 'starter_demo_create_demo_content' );
