<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\bundle;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    bundle('app')->enqueue();
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    bundle('editor')->enqueue();
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        //'comment-form',
        //'comment-list',
        //'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    // register_sidebar([
    //     'name' => __('Primary', 'sage'),
    //     'id' => 'sidebar-primary',
    // ] + $config);
});



/**
 * Register the post types.
 *
 * @return void
 */
add_action( 'init', function() {
    /**
     * Testimonials
    **/
    register_post_type(
        'testimonials',
        array(
            'labels'          => array(
                'name'          => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'public'          => true,
            'show_ui'         => true,
            'show_in_rest'    => true,
            'supports'        => array(
                'title',
                'custom-fields',
            ),
        )
    );
});

/**
 * Register page types directory with Papi.
 *
 * @return string
 */
// add_filter( 'papi/settings/directories', function () {
//     return __DIR__ . '/Providers/PostTypes';
// } );

/**
 * Disable Gutenberg
 *
 * @return void
 */
function disable_gutenberg( $current_status, $post_type ) {
    return false;
};
add_filter( 'use_block_editor_for_post_type', __NAMESPACE__ . '\\disable_gutenberg', 10, 2 );

/**
 * Disable Comments
 *
 * @return void
 */
function disable_comments() {
    return false;
}
add_filter( 'comments_open', __NAMESPACE__ . '\\disable_comments', 10 , 2 );

/**
 * Remove head content
 *
 * @return void
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
