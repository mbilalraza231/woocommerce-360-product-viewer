<?php

/**
 * Plugin Name: WP 360 Viewer
 * Description: Simple 360 product rotation plugin
 * Version: 1.0
 */

if (!defined('ABSPATH')) exit;

// Load assets
function wp360_load_assets()
{
    wp_enqueue_script(
        'wp360-js',
        plugin_dir_url(__FILE__) . 'assets/js/viewer.js',
        array(),
        '1.0',
        true
    );

    wp_enqueue_style(
        'wp360-css',
        plugin_dir_url(__FILE__) . 'assets/css/style.css'
    );
}
add_action('wp_enqueue_scripts', 'wp360_load_assets');

/**
 * Render the [wp360] shortcode.
 *
 * @param array<string,string>|string $atts Shortcode attributes.
 * @return string
 */


function wp360_shortcode($atts) {
    $atts = shortcode_atts([
        'images' => ''
    ], $atts);

    $images = explode(',', $atts['images']);

    ob_start(); ?>

    <div class="wp360-container"
         data-images='<?php echo json_encode($images); ?>'>
        <p>360 Viewer Loading...</p>
    </div>

    <?php return ob_get_clean();
}
