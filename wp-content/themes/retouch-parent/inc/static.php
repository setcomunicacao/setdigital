<?php if ( ! defined( 'ABSPATH' ) ) die( 'Direct access forbidden.' );
/**
 * Include static files: javascript and css
 */

$template_directory_uri = get_template_directory_uri();

/**
 * Enqueue scripts and styles for the front end.
 */

wp_deregister_style( 'fw-main' );
wp_deregister_style( 'fw-font-awesome' );
wp_deregister_style( 'fw-shortcode-testimonials' );
wp_deregister_style( 'fw-shortcode-section' );
wp_deregister_style( 'fw-shortcode-section-backround-video' );
wp_deregister_style( 'fw-ext-builder-frontend-grid' );
wp_deregister_style( 'fw-ext-forms-default-styles' );

// Load our main stylesheet.
wp_enqueue_style(
    'fw-theme-style',
    esc_url(get_stylesheet_uri()),
    array(),
    ''
);

// Load prettyPhoto stylesheet.
wp_enqueue_style(
    'print',
    esc_url($template_directory_uri . '/css/print.css'),
    array(),
    '',
    'print'
);


if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

wp_enqueue_script(
    'head',
    esc_url($template_directory_uri . '/js/head.js'),
    array( 'jquery' ),
    '',
    true
);

wp_enqueue_script(
    'mobile',
    esc_url($template_directory_uri . '/js/mobile.js'),
    array( 'jquery' ),
    '',
    true
);

wp_enqueue_script(
    'scripts',
    esc_url($template_directory_uri . '/js/scripts.js'),
    array( 'jquery' ),
    '',
    true
);

wp_enqueue_script(
    'carousel-3d',
    esc_url($template_directory_uri . '/js/carousel-3d.js'),
    array( 'jquery' ),
    '',
    true
);