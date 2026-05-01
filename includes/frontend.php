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