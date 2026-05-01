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


add_action('admin_menu', function () {
    add_menu_page(
        'WP 360 Viewer Settings',
        'WP 360 Viewer',
        'manage_options',
        'wp360-settings',
        'wp360_settings_page'
    );
});

function wp360_settings_page() {
    ?>
    <div class="wrap">
        <h1>WP 360 Viewer Settings</h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('wp360_settings_group');
            do_settings_sections('wp360_settings_group');
            ?>

            <label>
                Auto Spin:
                <input type="checkbox" name="wp360_auto_spin" value="1" <?php checked(1, get_option('wp360_auto_spin'), true); ?> />
            </label>

            <br><br>

            <label>
                Spin Speed:
                <input type="number" name="wp360_speed" value="<?php echo get_option('wp360_speed', 80); ?>">
            </label>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', function () {
    register_setting('wp360_settings_group', 'wp360_auto_spin');
    register_setting('wp360_settings_group', 'wp360_speed');
});