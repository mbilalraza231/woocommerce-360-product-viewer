<?php

/**
 * Central configuration constants for the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes/config
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Woocommerce_360_Viewer_Config {

	/**
	 * The unique name/slug of the plugin.
	 */
	const PLUGIN_NAME = 'woocommerce-360-viewer';

	/**
	 * Current version of the plugin (SemVer).
	 */
	const PLUGIN_VERSION = '1.0.0';

	/**
	 * Minimum required WooCommerce version.
	 */
	const WC_MIN_VERSION = '5.0';

	/**
	 * Text domain for translations.
	 */
	const TEXT_DOMAIN = 'woocommerce-360-viewer';

}
