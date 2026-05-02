<?php

// Load assets
function wp360_load_assets()
{
    wp_enqueue_script(
        'wp360-js',
        plugin_dir_url(dirname(__FILE__)) . 'assets/js/viewer.js',
        array(),
        '1.0',
        true
    );

    wp_enqueue_style(
        'wp360-css',
        plugin_dir_url(dirname(__FILE__)) . 'assets/css/style.css'
    );

    // 🔥 PASS SETTINGS TO JS
    wp_localize_script('wp360-js', 'wp360Settings', [
        'autoSpin' => (int) get_option('wp360_auto_spin', 0),
        'dragRotation' => (int) get_option('wp360_drag_rotation', 1),
        'speed'    => (int) get_option('wp360_speed', 80),

        // NEW
        'zoomEnable' => (int) get_option('wp360_zoom_enable', 1),
        'zoomOnHover' => (int) get_option('wp360_zoom_on_hover', 1),
        'zoomLevel'  => (float) get_option('wp360_zoom_level', 1.5),
        'inertia'    => (float) get_option('wp360_inertia', 0.92),
        'hotspots'   => (int) get_option('wp360_hotspots', 0),
        'showControls' => (int) get_option('wp360_show_controls', 1),
    ]);
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
    $auto_spin = get_option('wp360_auto_spin', 0);
    $spin_speed = get_option('wp360_speed', 80);

    ob_start(); ?>

    <div class="wp360-container"
         data-images='<?php echo json_encode($images); ?>'
         data-auto-spin='<?php echo $auto_spin; ?>'
         data-spin-speed='<?php echo $spin_speed; ?>'>
        <p>360 Viewer Loading...</p>
    </div>

    <?php return ob_get_clean();
}

add_shortcode('wp360', 'wp360_shortcode');

// WooCommerce Integration
add_action('woocommerce_before_single_product_summary', 'wp360_show_on_product', 20);

function wp360_show_on_product() {

    global $product;

    $images = get_post_meta($product->get_id(), 'wp360_images', true);

    if (!$images) return;

    echo do_shortcode('[wp360 images="' . esc_attr($images) . '"]');
}