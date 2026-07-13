<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://blank
 * @since      1.0.0
 *
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/public
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */
class Woocommerce_360_Viewer_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_360_Viewer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_360_Viewer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woocommerce_360_Viewer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woocommerce_360_Viewer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/viewer.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'wp360Settings', [
			'autoSpin' => (int) get_option('wp360_auto_spin', 0),
			'dragRotation' => (int) get_option('wp360_drag_rotation', 1),
			'speed'    => (int) get_option('wp360_speed', 80),
			'zoomEnable' => (int) get_option('wp360_zoom_enable', 1),
			'zoomOnHover' => (int) get_option('wp360_zoom_on_hover', 1),
			'zoomOnClick' => (int) get_option('wp360_zoom_on_click', 1),
			'zoomLevel'  => (float) get_option('wp360_zoom_level', 1.5),
			'inertia'    => (float) get_option('wp360_inertia', 0.92),
			'hotspots'   => (int) get_option('wp360_hotspots', 0),
			'showControls' => (int) get_option('wp360_show_controls', 1),
		]);

	}

	/**
	 * Render the [wp360] shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render_shortcode($atts) {
		$atts = shortcode_atts([
			'images' => ''
		], $atts);

		$images = explode(',', $atts['images']);
		$auto_spin = get_option('wp360_auto_spin', 0);
		$spin_speed = get_option('wp360_speed', 80);

		ob_start(); ?>

		<div class="wp360-container"
			 data-images='<?php echo json_encode($images); ?>'
			 data-auto-spin='<?php echo esc_attr($auto_spin); ?>'
			 data-spin-speed='<?php echo esc_attr($spin_speed); ?>'>
			<p>360 Viewer Loading...</p>
		</div>

		<?php return ob_get_clean();
	}

	/**
	 * Show the 360 viewer on the WooCommerce product page.
	 */
	public function show_on_product() {
		global $product;

		if ( ! $product ) return;

		$images = get_post_meta($product->get_id(), 'wp360_images', true);

		if (!$images) return;

		echo do_shortcode('[wp360 images="' . esc_attr($images) . '"]');
	}

}
