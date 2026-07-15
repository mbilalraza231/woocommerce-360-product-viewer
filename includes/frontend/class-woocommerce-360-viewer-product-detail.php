<?php

/**
 * Handles the WooCommerce product page integration for the 360 viewer.
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

class Woocommerce_360_Viewer_Product_Detail {

	/**
	 * Show the 360 viewer on the WooCommerce single product page.
	 *
	 * Hooked to 'woocommerce_before_single_product_summary'.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function show_on_product() {

		global $product;

		if ( ! $product ) {
			return;
		}

		$images = get_post_meta( $product->get_id(), 'wp360_images', true );

		if ( ! $images ) {
			return;
		}

		echo do_shortcode( '[wp360 images="' . esc_attr( $images ) . '"]' );
	}

}
