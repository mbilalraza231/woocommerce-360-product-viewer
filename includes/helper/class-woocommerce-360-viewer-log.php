<?php

/**
 * Debug and error logging utility.
 *
 * Writes timestamped messages to an error log file at the plugin root.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes/helper
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Woocommerce_360_Viewer_Log {

	/**
	 * Write a timestamped message to the plugin error log.
	 *
	 * @since  1.0.0
	 * @param  string $message  The message to log.
	 * @return void
	 */
	public static function log( $message ) {

		$time = date( 'Y-m-d H:i:s', current_time( 'timestamp' ) );
		$entry = "[{$time}] {$message}" . PHP_EOL;

		$file = WP360_PLUGIN_DIR . 'errorsfile.txt';

		if ( ! file_exists( $file ) ) {
			@file_put_contents( $file, '' );
		}

		if ( is_writable( $file ) ) {
			@file_put_contents( $file, $entry, FILE_APPEND );
		}
	}

	/**
	 * Log an error-level message.
	 *
	 * @since  1.0.0
	 * @param  string $message  The error message.
	 * @return void
	 */
	public static function error( $message ) {
		self::log( '[ERROR] ' . $message );
	}

	/**
	 * Log an info-level message.
	 *
	 * @since  1.0.0
	 * @param  string $message  The info message.
	 * @return void
	 */
	public static function info( $message ) {
		self::log( '[INFO] ' . $message );
	}

}
