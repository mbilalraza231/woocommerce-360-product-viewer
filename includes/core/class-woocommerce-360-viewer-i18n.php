<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://_
 * @since      1.0.0
 *
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */
class Woocommerce_360_Viewer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-360-viewer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
