<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Handles enqueueing of frontend CSS and JavaScript assets.
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

class Woocommerce_360_Viewer_Frontend {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  1.0.0
	 * @param  string $plugin_name  The name of the plugin.
	 * @param  string $version      The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since  1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			$this->plugin_name,
			WP360_PLUGIN_URL . 'css/style.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since  1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			$this->plugin_name,
			WP360_PLUGIN_URL . 'js/viewer.js',
			array(),
			$this->version,
			false
		);

		wp_localize_script( $this->plugin_name, 'wp360Settings', [
			'autoSpin'     => (int)   get_option( 'wp360_auto_spin', 0 ),
			'dragRotation' => (int)   get_option( 'wp360_drag_rotation', 1 ),
			'speed'        => (int)   get_option( 'wp360_speed', 80 ),
			'zoomEnable'   => (int)   get_option( 'wp360_zoom_enable', 1 ),
			'zoomOnHover'  => (int)   get_option( 'wp360_zoom_on_hover', 1 ),
			'zoomOnClick'  => (int)   get_option( 'wp360_zoom_on_click', 1 ),
			'zoomLevel'    => (float) get_option( 'wp360_zoom_level', 1.5 ),
			'inertia'      => (float) get_option( 'wp360_inertia', 0.92 ),
			'hotspots'     => (int)   get_option( 'wp360_hotspots', 0 ),
			'showControls' => (int)   get_option( 'wp360_show_controls', 1 ),
		] );
	}

}
