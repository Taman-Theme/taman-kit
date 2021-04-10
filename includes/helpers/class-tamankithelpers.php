<?php
/**
 * Class TamanKitHelpers
 *
 * @package taman-kit.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'TamanKitHelpers' ) ) {
	/**
	 * Helpers Class for Taman Kit
	 *
	 * @since 1.0.0
	 */
	class TamanKitHelpers {

		/**
		 * Instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 * @var TamanKitHelpers The single instance of the class.
		 */
		private static $instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @static
		 *
		 * @return TamanKitHelpers  An instance of the class.
		 */
		public static function instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;

		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {

			if ( $this->is_active( 'elementor.php' ) ) {

				add_action( 'wp_enqueue_scripts', array( $this, 'register_style' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			}

			$this->initialize_hooks();

		}


		/**
		 * Initialize the plugin.
		 *
		 * @since 1.0.0
		 */
		public function initialize_hooks() {

			add_action(
				'tamankit_initialize_hooks',
				function() {
					$this->load_files(
						array(
							'includes/helpers/helpers',
							'includes/base/global-var',
							'includes/modules/class-templates',
						)
					);
				}
			);

			do_action( 'tamankit_initialize_hooks' );
		}

		/**
		 * Taman Kit Ver.
		 *
		 * @since 1.0.0
		 */
		public function taman_kit_ver() {
			$ver = TAMAN_KIT_VER;
			$dev = time();
			return $dev;
		}


		/**
		 * Registers a stylesheets.
		 *
		 * @since 1.0.0
		 */
		public function register_style() {

			wp_register_style( 'taman-kit-style', TAMAN_KIT_URL . 'public/css/style.css', array(), $this->taman_kit_ver(), 'all' );

			if ( ! $this->taman_kit_themes() ) {

				wp_register_style( 'taman-kit-uikit', TAMAN_KIT_URL . 'public/css/uikit/uikit.min.css', array(), $this->taman_kit_ver(), 'all' );
				wp_enqueue_style( 'taman-kit-uikit' );
				wp_style_add_data( 'taman-kit-uikit', 'rtl', 'replace' );

			}

			wp_enqueue_style( 'taman-kit-style' );

		}

		/**
		 * Registers a scripts.
		 *
		 * @since 1.0.0
		 */
		public function register_scripts() {

			wp_register_script( 'taman-kit', TAMAN_KIT_URL . 'public/js/taman-kit.js', array(), self::taman_kit_ver(), true );
			wp_register_script( 'tk-morphext', TAMAN_KIT_URL . 'public/js/morphext/morphext.min.js', array(), self::taman_kit_ver(), true );

			if ( ! $this->taman_kit_themes() ) {
				wp_register_script( 'taman-kit_uikit', TAMAN_KIT_URL . 'public/js/uikit/uikit.min.js', array(), self::taman_kit_ver(), true );
				wp_enqueue_script( 'taman-kit_uikit' );

			}

			wp_enqueue_script( 'taman-kit' );
		}


		/**
		 * Check if a plugin is active
		 *
		 * @param string $plugin_main_file main file of the plugin, eg. woocommerce.php.
		 * @return bool True if plugin is active, false otherwise.
		 */
		public static function is_active( $plugin_main_file ) {

			// get the list of plugins.
			$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

			// escape characters that have special meaning in regex.
			$plugin_main_file    = preg_quote( $plugin_main_file, '/' );
			$is_plugin_installed = false;

			// Loop through the active plugins.
			foreach ( $active_plugins as $plugin ) {
				if ( preg_match( '/.+\/' . $plugin_main_file . '/', $plugin ) ) {
					$is_plugin_installed = true;
					break;
				}
			}

			return $is_plugin_installed;
		}

		/**
		 * Check if a plugin is network active
		 *
		 * @param string $plugin_main_file main file of the plugin, eg. woocommerce.php.
		 * @return bool True if plugin is active, false otherwise.
		 */
		public static function is_network_active( $plugin_main_file ) {

			// if not a multisite, don't check.
			if ( ! is_multisite() ) {
				return false;
			}

			// get the list of plugins.
			$active_plugins = get_site_option( 'active_sitewide_plugins' );

			// escape characters that have special meaning in regex.
			$plugin_main_file = preg_quote( $plugin_main_file, '/' );
			$is_plugin_active = false;

			// Loop through the active plugins.
			foreach ( $active_plugins as $plugin_name => $plugin_activation ) {
				if ( preg_match( '/.+\/' . $plugin_main_file . '/', $plugin_name ) ) {
					$is_plugin_active = true;
					break;
				}
			}

			return $is_plugin_active;
		}

		/**
		 * Check if a must use (mu) plugin exists.
		 *
		 * Mu plugins are always active. So there's no need to check if they are.
		 * active or not. We just need to check that they are in the list.
		 *
		 * @param string $plugin_main_file main file of the plugin, eg. woocommerce.php.
		 * @return bool True if plugin matches, false otherwise.
		 */
		public static function is_mu_active( $plugin_main_file ) {
			$_mu_plugins = get_mu_plugins();

			if ( isset( $_mu_plugins[ $plugin_main_file ] ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Loads specified PHP files from the plugin directory.
		 *
		 * @access public
		 *
		 * @param array $file_names PHP files from the plugin directory.
		 */
		public function load_files( $file_names = array() ) {
			foreach ( $file_names as $file_name ) {
				$path = TAMAN_KIT_DIR . '/' . $file_name . '.php';
				if ( file_exists( $path ) ) {
					require_once $path;
				}
			}
		}

		/**
		 * Taman themes function
		 */
		public function taman_kit_themes() {

			$taman_theme       = wp_get_theme()->get( 'Name' );
			$parent_theme      = wp_get_theme( get_template() );
			$parent_theme_name = $parent_theme->get( 'Name' );

			$themes = array( 'Taman', 'Idealx' );

			if ( true === in_array( $taman_theme, $themes, true ) || true === in_array( $parent_theme_name, $themes, true ) ) {
				return true;
			}

		}


	}

}
