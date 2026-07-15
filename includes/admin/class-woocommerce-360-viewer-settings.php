<?php

/**
 * Handles registration of all plugin settings via the WordPress Settings API.
 *
 * Extracted from the admin class to follow single-responsibility principle.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes/admin
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Woocommerce_360_Viewer_Settings {

	/**
	 * Register all plugin settings with WordPress.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function register_settings() {

		// 1. General Rotation
		register_setting( 'wp360_settings_group', 'wp360_auto_spin' );
		register_setting( 'wp360_settings_group', 'wp360_speed' );

		// 2. User Interaction
		register_setting( 'wp360_settings_group', 'wp360_drag_rotation' );
		register_setting( 'wp360_settings_group', 'wp360_inertia' );

		// 3. Zoom
		register_setting( 'wp360_settings_group', 'wp360_zoom_enable' );
		register_setting( 'wp360_settings_group', 'wp360_zoom_on_hover' );
		register_setting( 'wp360_settings_group', 'wp360_zoom_on_click' );
		register_setting( 'wp360_settings_group', 'wp360_zoom_level' );

		// 4. Features & UI
		register_setting( 'wp360_settings_group', 'wp360_show_controls' );
		register_setting( 'wp360_settings_group', 'wp360_hotspots' );
	}

}
