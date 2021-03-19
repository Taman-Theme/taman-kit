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
			$widget = array(
				'Alert',
				'Buttons',
				'Links',
				'Label',
				'Modal',
			);

			$widget[] = 'Circleprogress';
			$widget[] = 'Progress';
			$widget[] = 'Instagram';
			$widget[] = 'Contactform7';
			$widget[] = 'Divider';
			$widget[] = 'Counter';
			$widget[] = 'CountDown';

			TamanKit_RegisterWidget::register_widget( $widget );
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
		$plugin = false;

		return $plugin;
	}
}

if ( ! function_exists( 'taman_kit_massage_active' ) ) {
	/**
	 * Massage active.
	 *
	 * @param string $massage massage or title to return.
	 */
	function taman_kit_massage_active( $massage ) {

		if ( 'title' === $massage ) {
			$_title = apply_filters( 'upgrade_tamankit_title', esc_html__( 'Get Tamankit Pro', 'taman-kit' ) );

			return $_title;
		}

		if ( 'massage' === $massage ) {
			/* translators: draft saved date format, see http://php.net/date */
			$_masssage = apply_filters( 'upgrade_tamankit_message', sprintf( esc_html__( 'Upgrade to %1$s Pro Version %2$s for 70+ widgets, exciting extensions and advanced features.', 'taman-kit' ), '<a href="#" target="_blank" rel="noopener">', '</a>' ) );

			return $_masssage;
		}

	}
}



/**
 * Undocumented function
 */
function taman__kit_enqueue_scripts() {
	wp_register_script(
		'lottie-js',
		TAMAN_KIT_URL . 'public/js/lottie.js',
		array(),
		TamanKitHelpers::taman_kit_ver(),
		true
	);

	wp_register_script(
		'jquery-countdown',
		TAMAN_KIT_URL . 'public/js/jquery-countdown.js',
		array(),
		TamanKitHelpers::taman_kit_ver(),
		true
	);

	wp_register_script( 'anime-js', TAMAN_KIT_URL . 'public/js/anime.min.js', array(), TamanKitHelpers::taman_kit_ver(), true );
	wp_register_script( 'jquery-cookie', TAMAN_KIT_URL . 'public/js/jquery.cookie.js', array(), TamanKitHelpers::taman_kit_ver(), true );

}
add_action( 'wp_enqueue_scripts', 'taman__kit_enqueue_scripts' );



	/**
	 * Enqueue editor scripts
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
function taman_kit_enqueue_editor_scripts() {

	wp_register_style(
		'taman-kit-editor',
		TAMAN_KIT_URL . 'public/css/editor.css',
		array(),
		TamanKitHelpers::taman_kit_ver(),
		'all'
	);

	wp_enqueue_style( 'taman-kit-editor' );
}

	add_action( 'elementor/editor/after_enqueue_scripts', 'taman_kit_enqueue_editor_scripts' );


function taman_kit_animations() {

	$animation = array(
		'none'                             => esc_html__( 'None', 'taman' ),
		'uk-animation-fade'                => esc_html__( 'Fade', 'taman' ),
		'uk-animation-scale-up'            => esc_html__( 'Scale up', 'taman' ),
		'uk-animation-scale-down'          => esc_html__( 'Scale down', 'taman' ),
		'uk-animation-shake'               => esc_html__( 'Shake', 'taman' ),
		'uk-animation-slide-top'           => esc_html__( 'Slide top', 'taman' ),
		'uk-animation-slide-bottom'        => esc_html__( 'Slide bottom', 'taman' ),
		'uk-animation-slide-left'          => esc_html__( 'Slide left', 'taman' ),
		'uk-animation-slide-right'         => esc_html__( 'Slide right', 'taman' ),
		'uk-animation-slide-top-small'     => esc_html__( 'Slide top small', 'taman' ),
		'uk-animation-slide-bottom-small'  => esc_html__( 'Slide bottom small', 'taman' ),
		'uk-animation-slide-left-small'    => esc_html__( 'Slide left small', 'taman' ),
		'uk-animation-slide-right-small'   => esc_html__( 'Slide right small', 'taman' ),
		'uk-animation-slide-top-medium'    => esc_html__( 'Slide top medium', 'taman' ),
		'uk-animation-slide-bottom-medium' => esc_html__( 'Slide bottom medium', 'taman' ),
		'uk-animation-slide-left-medium'   => esc_html__( 'Slide left medium', 'taman' ),
		'uk-animation-slide-right-medium'  => esc_html__( 'Slide right medium', 'taman' ),
	);

	return $animation;
}
