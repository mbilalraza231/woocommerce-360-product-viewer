<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woocommerce_360_Viewer
 * @subpackage Woocommerce_360_Viewer/includes
 * @author     Bilal Raza <mbilalraza1023@gmail.com>
 */
class Woocommerce_360_Viewer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woocommerce_360_Viewer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = Woocommerce_360_Viewer_Config::PLUGIN_NAME;
		$this->version     = Woocommerce_360_Viewer_Config::PLUGIN_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Config:       Central constants.
	 * - Loader:       Orchestrates the hooks of the plugin.
	 * - i18n:         Defines internationalization functionality.
	 * - Log:          Debug and error logging utility.
	 * - Settings:     Handles plugin settings registration.
	 * - Admin:        Defines all hooks for the admin area.
	 * - Frontend:     Defines all hooks for the public side of the site.
	 * - Shortcode:    Handles the [wp360] shortcode.
	 * - ProductDetail: Handles WooCommerce single product page integration.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$plugin_path = plugin_dir_path( dirname( __FILE__ ) );

		/**
		 * Config — central constants.
		 */
		require_once $plugin_path . 'includes/config/class-woocommerce-360-viewer-config.php';

		/**
		 * Helper — hook loader.
		 */
		require_once $plugin_path . 'includes/helper/class-woocommerce-360-viewer-loader.php';

		/**
		 * Helper — debug/error logger.
		 */
		require_once $plugin_path . 'includes/helper/class-woocommerce-360-viewer-log.php';

		/**
		 * Core — internationalization.
		 */
		require_once $plugin_path . 'includes/core/class-woocommerce-360-viewer-i18n.php';

		/**
		 * Admin — settings registration.
		 */
		require_once $plugin_path . 'includes/admin/class-woocommerce-360-viewer-settings.php';

		/**
		 * Admin — admin area hooks and UI.
		 */
		require_once $plugin_path . 'admin/class-woocommerce-360-viewer-admin.php';

		/**
		 * Frontend — public-facing asset enqueues.
		 */
		require_once $plugin_path . 'includes/frontend/class-woocommerce-360-viewer-frontend.php';

		/**
		 * Frontend — shortcode rendering.
		 */
		require_once $plugin_path . 'includes/frontend/class-woocommerce-360-viewer-shortcode.php';

		/**
		 * Frontend — WooCommerce product page integration.
		 */
		require_once $plugin_path . 'includes/frontend/class-woocommerce-360-viewer-product-detail.php';

		$this->loader = new Woocommerce_360_Viewer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woocommerce_360_Viewer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woocommerce_360_Viewer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin    = new Woocommerce_360_Viewer_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_settings = new Woocommerce_360_Viewer_Settings();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_page' );
		$this->loader->add_action( 'admin_init', $plugin_settings, 'register_settings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_frontend       = new Woocommerce_360_Viewer_Frontend( $this->get_plugin_name(), $this->get_version() );
		$plugin_shortcode      = new Woocommerce_360_Viewer_Shortcode();
		$plugin_product_detail = new Woocommerce_360_Viewer_Product_Detail();

		// Frontend assets
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_scripts' );

		// Shortcode
		$this->loader->add_shortcode( 'wp360', $plugin_shortcode, 'render_shortcode' );

		// WooCommerce product page
		$this->loader->add_action( 'woocommerce_before_single_product_summary', $plugin_product_detail, 'show_on_product', 20 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woocommerce_360_Viewer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
