<?php

/**
 * Autoloader for the WP 360 Viewer plugin.
 *
 * Automatically loads plugin classes so we don't need manual require_once statements.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'woocommerce_360_viewer_autoloader' ) ) {

	function woocommerce_360_viewer_autoloader( $class_name ) {

		// Only load our plugin's classes
		if ( 0 !== strpos( $class_name, 'Woocommerce_360_Viewer' ) ) {
			return;
		}

		// Convert class name to file name (e.g. Woocommerce_360_Viewer_Admin -> class-woocommerce-360-viewer-admin.php)
		$file_name = 'class-' . str_replace( '_', '-', strtolower( $class_name ) ) . '.php';

		// 1. Check if it's the main orchestrator class (which sits directly in includes/)
		if ( 'class-woocommerce-360-viewer.php' === $file_name ) {
			$file_path = WP360_PLUGIN_DIR . 'includes/' . $file_name;
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
				return;
			}
		}

		// 2. Check all sub-directories within includes/
		$directories = array(
			'admin/',
			'config/',
			'core/',
			'frontend/',
			'helper/'
		);

		foreach ( $directories as $directory ) {
			$file_path = WP360_PLUGIN_DIR . 'includes/' . $directory . $file_name;
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
				return;
			}
		}

	}

	spl_autoload_register( 'woocommerce_360_viewer_autoloader' );
}
