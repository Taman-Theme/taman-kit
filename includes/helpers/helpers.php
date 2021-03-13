<?php
/**
 * Enqueue style and scripts.
 *
 * @package Taman
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( TamanKitHelpers::is_active( 'elementor.php' ) ) {

	add_action( 'elementor/elements/categories_registered', 'taman_kit_add_elementor_widget_categories' );

	add_action(
		'tamankit_register_widget_hooks',
		function() {
			TamanKit_RegisterWidget::register_widget(
				array(
					'Buttons',
				)
			);
		}
	);


}


/**
 * Creating a New Elementor Category Taman Kit
 *
 * @param [type] $elements_manager .
 */
function taman_kit_add_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'taman-kit',
		array(
			'title' => esc_html__( 'Taman Kit', 'taman-kit' ),
			'icon'  => 'fa fa-plug',
		)
	);

}



/**
 * Check if Taman Kit is active
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'taman_kit_is_active' ) ) {
	/**
	 * Check if Taman core is active
	 */
	function taman_kit_is_active() {

		$plugin = TamanKitHelpers::is_active( 'taman-core.php' );

		return $plugin;
	}
}
