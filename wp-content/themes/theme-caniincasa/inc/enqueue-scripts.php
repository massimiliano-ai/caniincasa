<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Additional Scripts (beyond main scripts in functions.php)
 */
function caniincasa_enqueue_additional_scripts() {
    // Enqueue search/filter script on archive pages
    if ( is_post_type_archive( array( 'razze_di_cani', 'allevamenti', 'struttureveterinarie' ) ) || is_tax() ) {
        wp_enqueue_script(
            'caniincasa-search-filter',
            CANIINCASA_THEME_URI . '/js/search-filter.js',
            array( 'jquery', 'caniincasa-main-js' ),
            CANIINCASA_VERSION,
            true
        );
    }

    // Enqueue rating display script on single pages
    if ( is_singular( array( 'razze_di_cani', 'allevamenti' ) ) ) {
        wp_enqueue_script(
            'caniincasa-rating',
            CANIINCASA_THEME_URI . '/js/rating-display.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_additional_scripts', 20 );

/**
 * Enqueue Admin Scripts
 */
function caniincasa_admin_scripts( $hook ) {
    // Only load on post edit pages
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
        return;
    }

    // Admin styles
    wp_enqueue_style(
        'caniincasa-admin',
        CANIINCASA_THEME_URI . '/css/admin.css',
        array(),
        CANIINCASA_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'caniincasa_admin_scripts' );

/**
 * Preload critical resources
 */
function caniincasa_preload_resources() {
    // Preload main stylesheet
    echo '<link rel="preload" href="' . esc_url( get_stylesheet_uri() ) . '" as="style">';

    // Preload main script
    echo '<link rel="preload" href="' . esc_url( CANIINCASA_THEME_URI . '/js/main.js' ) . '" as="script">';
}
add_action( 'wp_head', 'caniincasa_preload_resources', 1 );

/**
 * Add async/defer attributes to scripts
 */
function caniincasa_script_loader_tag( $tag, $handle, $src ) {
    // Add async to non-critical scripts
    $async_scripts = array(
        'caniincasa-search-filter',
        'caniincasa-rating',
    );

    if ( in_array( $handle, $async_scripts ) ) {
        $tag = str_replace( ' src', ' async src', $tag );
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'caniincasa_script_loader_tag', 10, 3 );
