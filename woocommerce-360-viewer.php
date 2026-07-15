<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://blank
 * @since             1.0.0
 * @package           Woocommerce_360_Viewer
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce 360 Viewer
 * Plugin URI:        https://blank
 * Description:       Lightweight, responsive 360° product viewer plugin for WordPress and WooCommerce
 * Version:           1.0.0
 * Author:            Bilal Raza
 * Author URI:        https://blank/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce-360-viewer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin constants — used throughout the codebase for clean path resolution.
 */
define( 'WOOCOMMERCE_360_VIEWER_VERSION', '1.0.0' );
define( 'WP360_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP360_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/core/class-woocommerce-360-viewer-activator.php
 */
function activate_woocommerce_360_viewer() {
	require_once WP360_PLUGIN_DIR . 'includes/core/class-woocommerce-360-viewer-activator.php';
	Woocommerce_360_Viewer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/core/class-woocommerce-360-viewer-deactivator.php
 */
function deactivate_woocommerce_360_viewer() {
	require_once WP360_PLUGIN_DIR . 'includes/core/class-woocommerce-360-viewer-deactivator.php';
	Woocommerce_360_Viewer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woocommerce_360_viewer' );
register_deactivation_hook( __FILE__, 'deactivate_woocommerce_360_viewer' );

/**
 * Load the Config class first — it provides constants to every other class.
 */
require WP360_PLUGIN_DIR . 'includes/config/class-woocommerce-360-viewer-config.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require WP360_PLUGIN_DIR . 'includes/class-woocommerce-360-viewer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woocommerce_360_viewer() {

	$plugin = new Woocommerce_360_Viewer();
	$plugin->run();

}
run_woocommerce_360_viewer();
