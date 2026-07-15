<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://blank
 * @since      1.0.0
 *
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for the admin-specific
 * stylesheet, JavaScript, and settings page.
 *
 * Settings registration has been extracted to:
 * includes/admin/class-woocommerce-360-viewer-settings.php
 *
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/admin
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */
class Woocommerce_360_Viewer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			$this->plugin_name . '-admin',
			WP360_PLUGIN_URL . 'css/woocommerce-360-viewer-admin.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			$this->plugin_name . '-admin',
			WP360_PLUGIN_URL . 'js/woocommerce-360-viewer-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);

	}

	/**
	 * Add the settings page to the admin menu.
	 *
	 * @since    1.0.0
	 */
	public function add_settings_page() {
		add_menu_page(
			'WP 360 Viewer Settings',
			'360 Viewer',
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_settings_page' ),
			'dashicons-360',
			100
		);
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_settings_page() {
		require_once WP360_PLUGIN_DIR . 'templates/admin-settings-template.php';
	}

}
