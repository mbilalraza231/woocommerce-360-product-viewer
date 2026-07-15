<?php

/**
 * Handles the [wp360] shortcode rendering.
 *
 * Extracted from the public class to follow single-responsibility principle.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes/frontend
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Woocommerce_360_Viewer_Shortcode {

	/**
	 * Render the [wp360] shortcode.
	 *
	 * @since  1.0.0
	 * @param  array $atts  Shortcode attributes.
	 * @return string       The rendered HTML.
	 */
	public function render_shortcode( $atts ) {

		$atts = shortcode_atts( [
			'images' => '',
		], $atts );

		$images     = explode( ',', $atts['images'] );
		$auto_spin  = get_option( 'wp360_auto_spin', 0 );
		$spin_speed = get_option( 'wp360_speed', 80 );

		ob_start();

		// Try to find the template in the theme first, fallback to the plugin template.
		$template_name = 'shortcode-template.php';
		$template_path = locate_template( 'wp-360-viewer/' . $template_name );

		if ( ! $template_path ) {
			$template_path = WP360_PLUGIN_DIR . 'templates/' . $template_name;
		}

		if ( file_exists( $template_path ) ) {
			include $template_path;
		}

		return ob_get_clean();
	}

}
