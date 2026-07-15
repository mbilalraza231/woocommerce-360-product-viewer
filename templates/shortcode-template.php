<?php
/**
 * 360 Viewer Shortcode Template
 *
 * This template can be overridden by copying it to yourtheme/wp-360-viewer/shortcode-template.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="wp360-container"
	 data-images='<?php echo esc_attr( wp_json_encode( $images ) ); ?>'
	 data-auto-spin='<?php echo esc_attr( $auto_spin ); ?>'
	 data-spin-speed='<?php echo esc_attr( $spin_speed ); ?>'>
	<p><?php esc_html_e( '360 Viewer Loading...', 'woocommerce-360-viewer' ); ?></p>
</div>
