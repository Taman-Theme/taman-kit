<?php
/**
 * Plugin Helper Functions.
 *
 * @package Taman Kit
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
				'ImageGrid',
				'Label',
				'Leaders',
				'Links',
				'Marquee',
				'Modal',
				'Slideshow',
				'StrokeHeading',
				'Switcher',
				'ImageAccordion',
				'AdvancedHeading',
				'ScrollDown',
				'TextRotator',
			);

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


if ( ! function_exists( 'taman_kit_animations' ) ) {
	/**
	 * Taman kit animations
	 */
	function taman_kit_animations() {

		$animation = array(
			'none'                             => esc_html__( 'None', 'taman-kit' ),
			'uk-animation-fade'                => esc_html__( 'Fade', 'taman-kit' ),
			'uk-animation-scale-up'            => esc_html__( 'Scale up', 'taman-kit' ),
			'uk-animation-scale-down'          => esc_html__( 'Scale down', 'taman-kit' ),
			'uk-animation-shake'               => esc_html__( 'Shake', 'taman-kit' ),
			'uk-animation-slide-top'           => esc_html__( 'Slide top', 'taman-kit' ),
			'uk-animation-slide-bottom'        => esc_html__( 'Slide bottom', 'taman-kit' ),
			'uk-animation-slide-left'          => esc_html__( 'Slide left', 'taman-kit' ),
			'uk-animation-slide-right'         => esc_html__( 'Slide right', 'taman-kit' ),
			'uk-animation-slide-top-small'     => esc_html__( 'Slide top small', 'taman-kit' ),
			'uk-animation-slide-bottom-small'  => esc_html__( 'Slide bottom small', 'taman-kit' ),
			'uk-animation-slide-left-small'    => esc_html__( 'Slide left small', 'taman-kit' ),
			'uk-animation-slide-right-small'   => esc_html__( 'Slide right small', 'taman-kit' ),
			'uk-animation-slide-top-medium'    => esc_html__( 'Slide top medium', 'taman-kit' ),
			'uk-animation-slide-bottom-medium' => esc_html__( 'Slide bottom medium', 'taman-kit' ),
			'uk-animation-slide-left-medium'   => esc_html__( 'Slide left medium', 'taman-kit' ),
			'uk-animation-slide-right-medium'  => esc_html__( 'Slide right medium', 'taman-kit' ),
		);

		return $animation;
	}
}

if ( ! function_exists( 'taman_kit_position' ) ) {
	/**
	 * Taman kit position
	 */
	function taman_kit_position() {

		$position = array(

			''                          => esc_html__( 'please choose position', 'taman-kit' ),
			'uk-position-top'           => esc_html__( 'top', 'taman-kit' ),
			'uk-position-left'          => esc_html__( 'left', 'taman-kit' ),
			'uk-position-right'         => esc_html__( 'right', 'taman-kit' ),
			'uk-position-bottom'        => esc_html__( 'bottom', 'taman-kit' ),
			'uk-position-top-left'      => esc_html__( 'top left', 'taman-kit' ),
			'uk-position-top-center'    => esc_html__( 'top center', 'taman-kit' ),
			'uk-position-top-right'     => esc_html__( 'top right', 'taman-kit' ),
			'uk-position-center'        => esc_html__( 'center', 'taman-kit' ),
			'uk-position-center-left'   => esc_html__( 'center left', 'taman-kit' ),
			'uk-position-center-right'  => esc_html__( 'center right', 'taman-kit' ),
			'uk-position-bottom-left'   => esc_html__( 'bottom left', 'taman-kit' ),
			'uk-position-bottom-center' => esc_html__( 'bottom center', 'taman-kit' ),
			'uk-position-bottom-right'  => esc_html__( 'bottom right', 'taman-kit' ),
			'uk-position-cover'         => esc_html__( 'cover', 'taman-kit' ),

		);

		return $position;
	}
}

if ( ! function_exists( 'taman_kit_transitions' ) ) {
	/**
	 * Taman kit transitions
	 */
	function taman_kit_transitions() {

		$transitions = array(
			'uk-transition-fade'                => esc_html__( 'fade', 'taman-kit' ),
			'uk-transition-scale-up'            => esc_html__( 'scales up', 'taman-kit' ),
			'uk-transition-scale-down'          => esc_html__( 'scales down', 'taman-kit' ),
			'uk-transition-slide-top'           => esc_html__( 'slide in from the top', 'taman-kit' ),
			'uk-transition-slide-bottom'        => esc_html__( 'slide in from the bottom', 'taman-kit' ),
			'uk-transition-slide-left'          => esc_html__( 'slide in from the left', 'taman-kit' ),
			'uk-transition-slide-right'         => esc_html__( 'slide in from the right', 'taman-kit' ),
			'uk-transition-slide-top-small'     => esc_html__( 'slides from top smaller', 'taman-kit' ),
			'uk-transition-slide-bottom-small'  => esc_html__( 'slides from bottom smaller', 'taman-kit' ),
			'uk-transition-slide-left-small'    => esc_html__( 'slides from left smaller', 'taman-kit' ),
			'uk-transition-slide-right-small'   => esc_html__( 'slides from right smaller', 'taman-kit' ),
			'uk-transition-slide-top-medium'    => esc_html__( 'slides from top medium', 'taman-kit' ),
			'uk-transition-slide-bottom-medium' => esc_html__( 'slides from bottom medium', 'taman-kit' ),
			'uk-transition-slide-left-medium'   => esc_html__( 'slides from left medium', 'taman-kit' ),
			'uk-transition-slide-right-medium'  => esc_html__( 'slides from right medium', 'taman-kit' ),
		);

		return $transitions;
	}
}




if ( ! function_exists( 'taman_kit_slide_animation' ) ) {
	/**
	 * Taman kit slide_animation
	 */
	function taman_kit_slide_animation() {

		$slide_animation = array(
			'slide' => esc_html__( 'slide', 'taman-kit' ),
			'fade'  => esc_html__( 'fade', 'taman-kit' ),
			'scale' => esc_html__( 'scale', 'taman-kit' ),
			'pull'  => esc_html__( 'pull', 'taman-kit' ),
			'push'  => esc_html__( 'push', 'taman-kit' ),
		);

		return $slide_animation;
	}
}


if ( ! function_exists( 'taman_kit_transform_origin' ) ) {
	/**
	 * Taman kit Transform origin
	 */
	function taman_kit_transform_origin() {

		$origin = array(
			'uk-transform-origin-top-left'      => esc_html__( 'from the top left.', 'taman-kit' ),
			'uk-transform-origin-top-center'    => esc_html__( 'from the top', 'taman-kit' ),
			'uk-transform-origin-top-right'     => esc_html__( 'from the top right', 'taman-kit' ),
			'uk-transform-origin-center-left'   => esc_html__( 'from the left', 'taman-kit' ),
			'uk-transform-origin-center-right'  => esc_html__( 'from the right', 'taman-kit' ),
			'uk-transform-origin-bottom-left'   => esc_html__( 'from the bottom left', 'taman-kit' ),
			'uk-transform-origin-bottom-center' => esc_html__( 'from the bottom', 'taman-kit' ),
			'uk-transform-origin-bottom-right'  => esc_html__( 'from the bottom right', 'taman-kit' ),
		);

		return $origin;
	}
}


if ( ! function_exists( 'taman_kit_tooltip_animations' ) ) {
	/**
	 * Taman kit taman kit tooltip animations
	 */
	function taman_kit_tooltip_animations() {

		$tooltip = array(
			''                  => __( 'Default', 'taman-kit' ),
			'bounce'            => __( 'Bounce', 'taman-kit' ),
			'flash'             => __( 'Flash', 'taman-kit' ),
			'pulse'             => __( 'Pulse', 'taman-kit' ),
			'rubberBand'        => __( 'rubberBand', 'taman-kit' ),
			'shake'             => __( 'Shake', 'taman-kit' ),
			'swing'             => __( 'Swing', 'taman-kit' ),
			'tada'              => __( 'Tada', 'taman-kit' ),
			'wobble'            => __( 'Wobble', 'taman-kit' ),
			'bounceIn'          => __( 'bounceIn', 'taman-kit' ),
			'bounceInDown'      => __( 'bounceInDown', 'taman-kit' ),
			'bounceInLeft'      => __( 'bounceInLeft', 'taman-kit' ),
			'bounceInRight'     => __( 'bounceInRight', 'taman-kit' ),
			'bounceInUp'        => __( 'bounceInUp', 'taman-kit' ),
			'bounceOut'         => __( 'bounceOut', 'taman-kit' ),
			'bounceOutDown'     => __( 'bounceOutDown', 'taman-kit' ),
			'bounceOutLeft'     => __( 'bounceOutLeft', 'taman-kit' ),
			'bounceOutRight'    => __( 'bounceOutRight', 'taman-kit' ),
			'bounceOutUp'       => __( 'bounceOutUp', 'taman-kit' ),
			'fadeIn'            => __( 'fadeIn', 'taman-kit' ),
			'fadeInDown'        => __( 'fadeInDown', 'taman-kit' ),
			'fadeInDownBig'     => __( 'fadeInDownBig', 'taman-kit' ),
			'fadeInLeft'        => __( 'fadeInLeft', 'taman-kit' ),
			'fadeInLeftBig'     => __( 'fadeInLeftBig', 'taman-kit' ),
			'fadeInRight'       => __( 'fadeInRight', 'taman-kit' ),
			'fadeInRightBig'    => __( 'fadeInRightBig', 'taman-kit' ),
			'fadeInUp'          => __( 'fadeInUp', 'taman-kit' ),
			'fadeInUpBig'       => __( 'fadeInUpBig', 'taman-kit' ),
			'fadeOut'           => __( 'fadeOut', 'taman-kit' ),
			'fadeOutDown'       => __( 'fadeOutDown', 'taman-kit' ),
			'fadeOutDownBig'    => __( 'fadeOutDownBig', 'taman-kit' ),
			'fadeOutLeft'       => __( 'fadeOutLeft', 'taman-kit' ),
			'fadeOutLeftBig'    => __( 'fadeOutLeftBig', 'taman-kit' ),
			'fadeOutRight'      => __( 'fadeOutRight', 'taman-kit' ),
			'fadeOutRightBig'   => __( 'fadeOutRightBig', 'taman-kit' ),
			'fadeOutUp'         => __( 'fadeOutUp', 'taman-kit' ),
			'fadeOutUpBig'      => __( 'fadeOutUpBig', 'taman-kit' ),
			'flip'              => __( 'flip', 'taman-kit' ),
			'flipInX'           => __( 'flipInX', 'taman-kit' ),
			'flipInY'           => __( 'flipInY', 'taman-kit' ),
			'flipOutX'          => __( 'flipOutX', 'taman-kit' ),
			'flipOutY'          => __( 'flipOutY', 'taman-kit' ),
			'lightSpeedIn'      => __( 'lightSpeedIn', 'taman-kit' ),
			'lightSpeedOut'     => __( 'lightSpeedOut', 'taman-kit' ),
			'rotateIn'          => __( 'rotateIn', 'taman-kit' ),
			'rotateInDownLeft'  => __( 'rotateInDownLeft', 'taman-kit' ),
			'rotateInDownLeft'  => __( 'rotateInDownRight', 'taman-kit' ),
			'rotateInUpLeft'    => __( 'rotateInUpLeft', 'taman-kit' ),
			'rotateInUpRight'   => __( 'rotateInUpRight', 'taman-kit' ),
			'rotateOut'         => __( 'rotateOut', 'taman-kit' ),
			'rotateOutDownLeft' => __( 'rotateOutDownLeft', 'taman-kit' ),
			'rotateOutDownLeft' => __( 'rotateOutDownRight', 'taman-kit' ),
			'rotateOutUpLeft'   => __( 'rotateOutUpLeft', 'taman-kit' ),
			'rotateOutUpRight'  => __( 'rotateOutUpRight', 'taman-kit' ),
			'hinge'             => __( 'Hinge', 'taman-kit' ),
			'rollIn'            => __( 'rollIn', 'taman-kit' ),
			'rollOut'           => __( 'rollOut', 'taman-kit' ),
			'zoomIn'            => __( 'zoomIn', 'taman-kit' ),
			'zoomInDown'        => __( 'zoomInDown', 'taman-kit' ),
			'zoomInLeft'        => __( 'zoomInLeft', 'taman-kit' ),
			'zoomInRight'       => __( 'zoomInRight', 'taman-kit' ),
			'zoomInUp'          => __( 'zoomInUp', 'taman-kit' ),
			'zoomOut'           => __( 'zoomOut', 'taman-kit' ),
			'zoomOutDown'       => __( 'zoomOutDown', 'taman-kit' ),
			'zoomOutLeft'       => __( 'zoomOutLeft', 'taman-kit' ),
			'zoomOutRight'      => __( 'zoomOutRight', 'taman-kit' ),
			'zoomOutUp'         => __( 'zoomOutUp', 'taman-kit' ),
		);

		return $tooltip;
	}
}





if ( ! function_exists( 'taman_kit_box_shadow' ) ) {
	/**
	 * Taman kit taman kit Boxshadow
	 */
	function taman_kit_box_shadow() {

		$box_shadow = array(
			'none'                       => esc_html__( 'None', 'taman' ),
			'uk-box-shadow-small'        => esc_html__( 'small box shadow', 'taman' ),
			'uk-box-shadow-medium'       => esc_html__( 'medium box shadow', 'taman' ),
			'uk-box-shadow-large'        => esc_html__( 'large box shadow', 'taman' ),
			'uk-box-shadow-xlarge'       => esc_html__( 'very large box shadow', 'taman' ),
			'uk-box-shadow-bottom'       => esc_html__( 'Box shadow bottom', 'taman' ),
			'uk-box-shadow-hover-small'  => esc_html__( 'small box shadow on hover', 'taman' ),
			'uk-box-shadow-hover-medium' => esc_html__( 'medium box shadow on hover', 'taman' ),
			'uk-box-shadow-hover-large'  => esc_html__( 'large box shadow on hover', 'taman' ),
			'uk-box-shadow-hover-xlarge' => esc_html__( 'very large box shadow on hover', 'taman' ),
		);

		return $box_shadow;

	}
}
