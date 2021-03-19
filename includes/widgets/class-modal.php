<?php
/**
 * Elementor modal Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 * @package Taman Kit.
 */

namespace TamanKit\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TamanKit\Modules\Templates;

// Elementor Classes.
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Core\Responsive\Responsive;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Undocumented class
 */
class Modal extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve modal widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-modal';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve modal widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Modal', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve modal widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-lightbox';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the modal widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'taman-kit' );
	}

	/**
	 * Retrieve the list of scripts.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array(
			'jquery-cookie',

		);
	}


	/**
	 * Register modal widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		/*
		*==================================================================================
		*
		*==================================== CONTENT TAB =================================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Content', 'taman-kit' ),
			)
		);

		$this->add_control(
			'popup_title',
			array(
				'label'        => __( 'Enable Title', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'title',
			array(
				'label'     => __( 'Title', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => __( 'Modal Title', 'taman-kit' ),
				'condition' => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'popup_type',
			array(
				'label'   => __( 'Type', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'image'       => __( 'Image', 'taman-kit' ),
					'link'        => __( 'Video', 'taman-kit' ),
					'content'     => __( 'Content', 'taman-kit' ),
					'template'    => __( 'Saved Templates', 'taman-kit' ),
					'custom-html' => __( 'Custom HTML', 'taman-kit' ),
				),
				'default' => 'image',
			)
		);

		$this->add_control(
			'image',
			array(
				'label'     => __( 'Choose Image', 'taman-kit' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'popup_type' => 'image',
				),
			)
		);

		$this->add_control(
			'popup_link_video',
			array(
				'label'     => __( 'Video', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'video'   => array(
						'title' => __( 'VIDEO MP4', 'taman-kit' ),
						'icon'  => 'fa fa-video',
					),
					'youtube' => array(
						'title' => __( 'YOUTUBE', 'taman-kit' ),
						'icon'  => 'fa fa-youtube',
					),
					'vimeo'   => array(
						'title' => __( 'VIMEO', 'taman-kit' ),
						'icon'  => 'fa fa-vimeo',
					),
				),
				'default'   => 'video',
				'toggle'    => true,
				'condition' => array(
					'popup_type' => 'link',
				),
			)
		);

		$this->add_control(
			'popup_link',
			array(
				'label'     => __( 'Enter URL', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'popup_type' => 'link',
				),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'     => __( 'Content', 'taman-kit' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => __( 'I am the popup Content', 'taman-kit' ),
				'dynamic'   => array(
					'active' => true,
				),
				'condition' => array(
					'popup_type' => 'content',
				),
			)
		);

		$this->add_control(
			'templates',
			array(
				'label'       => __( 'Choose Template', 'taman-kit' ),
				'type'        => 'tk-query',
				'label_block' => false,
				'multiple'    => false,
				'query_type'  => 'templates-all',
				'condition'   => array(
					'popup_type' => 'template',
				),
			)
		);

		$this->add_control(
			'custom_html',
			array(
				'label'     => __( 'Custom HTML', 'taman-kit' ),
				'type'      => Controls_Manager::CODE,
				'language'  => 'html',
				'condition' => array(
					'popup_type' => 'custom-html',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Content Tab: Layout
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => __( 'Layout', 'taman-kit' ),
			)
		);

		$this->add_control(
			'layout_type',
			array(
				'label'              => __( 'Layout', 'taman-kit' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'standard'   => __( 'Standard', 'taman-kit' ),
					'fullscreen' => __( 'Fullscreen', 'taman-kit' ),
				),
				'default'            => 'standard',
				'frontend_available' => true,
			)
		);

		$this->add_responsive_control(
			'popup_width',
			array(
				'label'      => __( 'Width', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '550',
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1920,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-modal-popup-window-{{ID}}' => 'width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'layout_type' => 'standard',
				),
			)
		);

		$this->add_control(
			'auto_height',
			array(
				'label'        => __( 'Auto Height', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'condition'    => array(
					'layout_type' => 'standard',
				),
			)
		);

		$this->add_responsive_control(
			'popup_height',
			array(
				'label'      => __( 'Height', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '450',
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-modal-popup-window-{{ID}}' => 'height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'auto_height!' => 'yes',
					'layout_type'  => 'standard',
				),
			)
		);

		$this->end_controls_section();

		/*-------------------------------------------------------------*/
		if ( ! taman_kit_is_active() ) {

			$this->start_controls_section(
				'section_upgrade_tamankit',
				array(
					'label' => taman_kit_massage_active( 'title' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'upgrade_tamankit_notice',
				array(
					'label'           => '',
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => taman_kit_massage_active( 'massage' ),
					'content_classes' => 'upgrade-tamankit-notice elementor-panel-alert elementor-panel-alert-info',
				)
			);

			$this->end_controls_section();
		}

		/**------------------------------------------------- */
		$this->start_controls_section(
			'section_trigger',
			array(
				'label' => __( 'Trigger', 'taman-kit' ),
			)
		);

		$this->add_control(
			'trigger',
			array(
				'label'              => __( 'Trigger', 'taman-kit' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'on-click',
				'options'            => array(
					'on-click'    => __( 'On Click', 'taman-kit' ),
					'page-load'   => __( 'On Load', 'taman-kit' ),
					'exit-intent' => __( 'Exit Intent', 'taman-kit' ),
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'trigger_type',
			array(
				'label'     => __( 'Type', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'button',
				'options'   => array(
					'button' => __( 'Button', 'taman-kit' ),
					'icon'   => __( 'Icon', 'taman-kit' ),
					'image'  => __( 'Image', 'taman-kit' ),
				),
				'condition' => array(
					'trigger' => 'on-click',
				),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'     => __( 'Button Text', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Click Here', 'taman-kit' ),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
				),
			)
		);

		$this->add_control(
			'select_button_icon',
			array(
				'label'            => __( 'Button Icon', 'taman-kit' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'button_icon',
				'condition'        => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
				),
			)
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'     => __( 'Icon Position', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'after',
				'options'   => array(
					'after'  => __( 'After', 'taman-kit' ),
					'before' => __( 'Before', 'taman-kit' ),
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
				),
			)
		);

		$this->add_control(
			'select_trigger_icon',
			array(
				'label'            => __( 'Icon', 'taman-kit' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'trigger_icon',
				'condition'        => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'trigger_image',
			array(
				'label'     => __( 'Choose Image', 'taman-kit' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'image',
				),
			)
		);

		$this->add_control(
			'delay',
			array(
				'label'     => __( 'Delay', 'taman-kit' ),
				'title'     => __( 'seconds', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '1',
				'condition' => array(
					'trigger' => 'page-load',
				),
			)
		);

		$this->add_control(
			'display_after_page_load',
			array(
				'label'       => __( 'Display After', 'taman-kit' ),
				'title'       => __( 'day(s)', 'taman-kit' ),
				'description' => __( 'If a user closes the modal box, it will be displayed only after the defined day(s)', 'taman-kit' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1',
				'condition'   => array(
					'trigger' => 'page-load',
				),
			)
		);

		$this->add_control(
			'display_after_exit_intent',
			array(
				'label'       => __( 'Display After', 'taman-kit' ),
				'title'       => __( 'day(s)', 'taman-kit' ),
				'description' => __( 'If a user closes the modal box, it will be displayed only after the defined day(s)', 'taman-kit' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1',
				'condition'   => array(
					'trigger' => 'exit-intent',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Content Tab: Settings
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_settings',
			array(
				'label' => __( 'Settings', 'taman-kit' ),
			)
		);

		$this->add_control(
			'close_button',
			array(
				'label'              => __( 'Show Close Button', 'taman-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => __( 'Yes', 'taman-kit' ),
				'label_off'          => __( 'No', 'taman-kit' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'popup_disable_on',
			array(
				'label'     => __( 'Disable On', 'taman-kit' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => '',
				'options'   => array(
					''       => __( 'None', 'taman-kit' ),
					'tablet' => __( 'Mobile & Tablet', 'taman-kit' ),
					'mobile' => __( 'Mobile', 'taman-kit' ),
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'popup_animation_in',
			array(
				'label'              => __( 'Animation', 'taman-kit' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'options'            => taman_kit_animations(),
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();

		/*
		*==================================================================================
		*
		*=============================== Style Tab: Style =================================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'section_popup_window_style',
			array(
				'label' => __( 'Popup', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'popup_bg',
				'label'    => __( 'Background', 'taman-kit' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.tk-modal-popup-window-{{ID}}.tk-model--dialog-window.uk-modal-dialog',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'popup_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-modal-popup-window-{{ID}}',
			)
		);

		$this->add_control(
			'popup_border_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'#tk-modal-popup-window-{{ID}} .tk-model--dialog-window' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'#tk-modal-popup-window-{{ID}} .uk-modal-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',

				),
			)
		);

		$this->add_responsive_control(
			'popup_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'#tk-modal-popup-window-{{ID}} .uk-modal-body.tk-popup-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'popup_box_shadow',
				'selector'  => '.tk-modal-popup-window-{{ID}}',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Overlay
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_popup_overlay_style',
			array(
				'label' => __( 'Overlay', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay_switch',
			array(
				'label'              => __( 'Overlay', 'taman-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => __( 'Show', 'taman-kit' ),
				'label_off'          => __( 'Hide', 'taman-kit' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'overlay_bg',
				'label'     => __( 'Background', 'taman-kit' ),
				'types'     => array( 'classic', 'gradient' ),
				'exclude'   => array( 'image' ),
				'default'   => '',
				'selector'  => '#tk-modal-popup-window-{{ID}}.tk-model--window.uk-modal',
				'condition' => array(
					'overlay_switch' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Title
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_title_style',
			array(
				'label'     => __( 'Title', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'title_align',
			array(
				'label'     => __( 'Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .uk-modal-header.tk-popup-header.tk-popup-title' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'title_bg',
			array(
				'label'     => __( 'Background Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .uk-modal-header.tk-popup-header.tk-popup-title' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .uk-modal-header.tk-popup-header.tk-popup-title .uk-modal-title' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'title_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-modal-popup-window-{{ID}} .uk-modal-header.tk-popup-header.tk-popup-title',
				'condition'   => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.tk-modal-popup-window-{{ID}} .uk-modal-header.tk-popup-header.tk-popup-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typography',
				'label'     => __( 'Typography', 'taman-kit' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '.tk-modal-popup-window-{{ID}} .uk-modal-header.tk-popup-header.tk-popup-title .uk-modal-title',
				'condition' => array(
					'popup_title' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Content
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_popup_content_style',
			array(
				'label'     => __( 'Content', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'popup_type' => 'content',
				),
			)
		);

		$this->add_responsive_control(
			'content_align',
			array(
				'label'     => __( 'Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'fa fa-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'taman-kit' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .tk-popup-content'   => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'popup_type' => 'content',
				),
			)
		);

		$this->add_control(
			'content_text_color',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .tk-popup-content' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'popup_type' => 'content',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'content_typography',
				'label'     => __( 'Typography', 'taman-kit' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '.tk-modal-popup-window-{{ID}} .tk-popup-content',
				'condition' => array(
					'popup_type' => 'content',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Trigger Icon
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_icon_style',
			array(
				'label'     => __( 'Trigger Icon/Image', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'trigger'       => 'on-click',
					'trigger_type!' => 'button',
				),
			)
		);

		$this->add_responsive_control(
			'icon_align',
			array(
				'label'     => __( 'Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-wrap .tk-modal-popup'   => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => array( 'icon', 'image' ),
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-trigger-icon'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .tk-trigger-icon svg' => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'icon',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Size', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '28',
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 80,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'icon',
				),
			)
		);

		$this->add_responsive_control(
			'icon_image_width',
			array(
				'label'      => __( 'Width', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 1200,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-trigger-image' => 'width: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'image',
				),
			)
		);

		$this->end_controls_section();
		/**---------------------------------------------------------------- */

		/**
				 * Style Tab: Trigger Button
				 * -------------------------------------------------
				 */
		$this->start_controls_section(
			'section_modal_button_style',
			array(
				'label'     => __( 'Trigger Button', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'     => __( 'Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-wrap .tk-modal-popup'   => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'     => __( 'Size', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'md',
				'options'   => array(
					'xs' => __( 'Extra Small', 'taman-kit' ),
					'sm' => __( 'Small', 'taman-kit' ),
					'md' => __( 'Medium', 'taman-kit' ),
					'lg' => __( 'Large', 'taman-kit' ),
					'xl' => __( 'Extra Large', 'taman-kit' ),
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label'     => __( 'Normal', 'taman-kit' ),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_bg_color_normal',
			array(
				'label'     => __( 'Background Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-button' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_text_color_normal',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .tk-modal-popup-button svg' => 'fill: {{VALUE}}',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border_normal',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .tk-modal-popup-button',
				'condition'   => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-modal-popup-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'button_typography',
				'label'     => __( 'Typography', 'taman-kit' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .tk-modal-popup-button',
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-modal-popup-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .tk-modal-popup-button',
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_icon_heading',
			array(
				'label'     => __( 'Button Icon', 'taman-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'       => __( 'Margin', 'taman-kit' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'placeholder' => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'   => array(
					'{{WRAPPER}} .tk-modal-popup-button .tk-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				),
				'condition'   => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label'     => __( 'Hover', 'taman-kit' ),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_bg_color_hover',
			array(
				'label'     => __( 'Background Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-button:hover' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-button:hover' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-modal-popup-button:hover' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_control(
			'button_animation',
			array(
				'label'     => __( 'Animation', 'taman-kit' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'button_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .tk-modal-popup-button:hover',
				'condition' => array(
					'trigger'      => 'on-click',
					'trigger_type' => 'button',
					'button_text!' => '',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Close Button
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_close_button_style',
			array(
				'label'     => __( 'Close Button', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'close_button_position',
			array(
				'label'              => __( 'Position', 'taman-kit' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'uk-modal-close-default',
				'options'            => array(
					'uk-modal-close-default' => __( 'Inside', 'taman-kit' ),
					'uk-modal-close-outside' => __( 'Outside', 'taman-kit' ),

				),
				'frontend_available' => true,
				'condition'          => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'close_button_size',
			array(
				'label'      => __( 'Size', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => '28',
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 80,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_close_button_style' );

		$this->start_controls_tab(
			'tab_close_button_normal',
			array(
				'label'     => __( 'Normal', 'taman-kit' ),
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'close_button_color_normal',
			array(
				'label'     => __( 'Icon Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'close_button_bg',
				'label'     => __( 'Background', 'taman-kit' ),
				'types'     => array( 'classic', 'gradient' ),
				'exclude'   => array( 'image' ),
				'selector'  => '.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button',
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'close_button_border_normal',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button',
				'condition'   => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'close_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'close_button_margin',
			array(
				'label'       => __( 'Margin', 'taman-kit' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'placeholder' => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'   => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				),
				'condition'   => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'close_button_padding',
			array(
				'label'       => __( 'Padding', 'taman-kit' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'placeholder' => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'   => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button' => 'padding-top: {{TOP}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};',
				),
				'condition'   => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_close_button_hover',
			array(
				'label'     => __( 'Hover', 'taman-kit' ),
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'close_button_color_hover',
			array(
				'label'     => __( 'Icon Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button:hover' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'close_button_bg_hover',
				'label'     => __( 'Background', 'taman-kit' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button:hover',
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'close_button_border_hover',
			array(
				'label'     => __( 'Border Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button:hover' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->add_control(
			'close_button_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-modal-popup-window-{{ID}} .tk-modal-popup-close-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'close_button' => 'yes',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/*
	*==================================================================================
	*
	*=============================== Widget Output ====================================
	*
	*==================================================================================
	*/

	/**
	 * Render modal widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		include Templates::get_templatet( 'modal', 'popup' );
	}
}
