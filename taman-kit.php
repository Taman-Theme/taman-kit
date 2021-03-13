<?php
/**
 * Plugin Name:       Taman Kit
 * Plugin URI:        https://#
 * Description:       Custom addons for Elementor page builder.
 * Version:           1.0.0
 * Author:            Mohamed Taman
 * Author URI:        https://profiles.wordpress.org/mohamedtaman
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       taman-kit
 * Domain Path:       /languages
 *
 * @package taman-kit.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TAMAN_KIT_VER', '1.0.0' );
define( 'TAMAN_KIT_DIR', plugin_dir_path( __FILE__ ) );
define( 'TAMAN_KIT_BASE', plugin_basename( __FILE__ ) );
define( 'TAMAN_KIT_URL', plugins_url( '/', __FILE__ ) );


require_once TAMAN_KIT_DIR . '/includes/class-tamankit.php';
/**
 * Load the Plugin Class.
 */
function taman_kit_init() {
	TamanKit::instance();
}

add_action( 'plugins_loaded', 'taman_kit_init' );
