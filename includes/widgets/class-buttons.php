<?php
/**
 * Elementor Buttons Widget.
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

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

/**
 * Buttons Widget
 */
class Buttons extends \Elementor\Widget_Base {

	/**
	 * Widget base constructor.
	 *
	 * Initializing the widget base class.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array      $data Widget data. Default is an empty array.
	 * @param array|null $args Optional. Widget default arguments. Default is null.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style(
			'taman-buttons',
			TAMAN_KIT_URL . 'public/css/widgets/buttons.css',
			array(),
			\TamanKitHelpers::taman_kit_ver(),
			'all'
		);
	}

	/**
	 * Get style dependencies.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_style_depends() {
		return array( 'taman-buttons' );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve Buttons widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'buttons';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Buttons widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Buttons', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Buttons widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-button';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Buttons widget belongs to.
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
	 * Register buttons widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function _register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->register_controls();
	}

	/**
	 * Register buttons widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/*
		*==================================================================================
		*
		*==================================== CONTENT TAB =================================
		*
		*==================================================================================
		*/

		/**
		 * Content Tab: Buttons
		 */
		$this->start_controls_section(
			'section_list',
			array(
				'label' => esc_html__( 'Buttons', 'taman-kit' ),
			)
		);
		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'buttons_tabs' );

			$repeater->start_controls_tab(
				'button_general',
				array(
					'label' => esc_html__( 'Content', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'text',
				array(
					'label'       => esc_html__( 'Text', 'taman-kit' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Button #1', 'taman-kit' ),
					'placeholder' => esc_html__( 'Button #1', 'taman-kit' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
			$repeater->add_control(
				'tk_icon_type',
				array(
					'label'       => esc_html__( 'Icon Type', 'taman-kit' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'toggle'      => false,
					'default'     => 'icon',
					'options'     => array(
						'none'  => array(
							'title' => esc_html__( 'None', 'taman-kit' ),
							'icon'  => 'fa fa-ban',
						),
						'icon'  => array(
							'title' => esc_html__( 'Icon', 'taman-kit' ),
							'icon'  => 'fa fa-star',
						),
						'image' => array(
							'title' => esc_html__( 'Image', 'taman-kit' ),
							'icon'  => 'fa fa-picture-o',
						),
						'text'  => array(
							'title' => esc_html__( 'Text', 'taman-kit' ),
							'icon'  => 'fa fa-hashtag',
						),
					),
				)
			);
			$repeater->add_control(
				'selected_icon',
				array(
					'label'            => esc_html__( 'Icon', 'taman-kit' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => true,
					'default'          => array(
						'value'   => 'fas fa-check',
						'library' => 'fa-solid',
					),
					'fa4compatibility' => 'button_icon',
					'condition'        => array(
						'tk_icon_type' => 'icon',
					),
				)
			);
			$repeater->add_control(
				'icon_img',
				array(
					'label'       => esc_html__( 'Image', 'taman-kit' ),
					'label_block' => true,
					'type'        => Controls_Manager::MEDIA,
					'default'     => array(
						'url' => Utils::get_placeholder_image_src(),
					),
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'tk_icon_type' => 'image',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array(
					'name'      => 'icon_img',
					'label'     => esc_html__( 'Image Size', 'taman-kit' ),
					'default'   => 'full',
					'condition' => array(
						'tk_icon_type' => 'image',
					),
				)
			);
			$repeater->add_control(
				'icon_text',
				array(
					'label'       => esc_html__( 'Icon Text', 'taman-kit' ),
					'label_block' => false,
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( '1', 'taman-kit' ),
					'dynamic'     => array(
						'active' => true,
					),
					'condition'   => array(
						'tk_icon_type' => 'text',
					),
				)
			);

			$repeater->add_control(
				'has_tooltip',
				array(
					'label'   => esc_html__( 'Enable Tooltip', 'taman-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'yes'     => esc_html__( 'Yes', 'taman-kit' ),
					'no'      => esc_html__( 'No', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'tooltip_content',
				array(
					'label'       => esc_html__( 'Tooltip Content', 'taman-kit' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => esc_html__( 'I am a tooltip for a button', 'taman-kit' ),
					'placeholder' => esc_html__( 'I am a tooltip for a button', 'taman-kit' ),
					'rows'        => 5,
					'condition'   => array(
						'has_tooltip' => 'yes',
					),
				)
			);

			$repeater->add_control(
				'link',
				array(
					'label'       => esc_html__( 'Link', 'taman-kit' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
					'placeholder' => esc_html__( 'http://your-link.com', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'css_style_classes',
				array(
					'label'       => esc_html__( 'Style', 'taman-kit' ),
					'title'       => esc_html__( 'Chosse Custom Butoon Style', 'taman-kit' ),
					'label_block' => false,
					'type'        => Controls_Manager::SELECT,
					'default'     => 'style1',
					'options'     => array(
						'style1' => esc_html__( 'Style 1', 'taman-kit' ),
						'style2' => esc_html__( 'Style 2', 'taman-kit' ),
						'style3' => esc_html__( 'Style 3', 'taman-kit' ),
						'style4' => esc_html__( 'Style 4', 'taman-kit' ),
						'style5' => esc_html__( 'Style 5', 'taman-kit' ),
						'style6' => esc_html__( 'Style 6', 'taman-kit' ),
					),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				'css_id',
				array(
					'label'       => esc_html__( 'CSS ID', 'taman-kit' ),
					'title'       => esc_html__( 'Add your custom ID WITHOUT the # key. e.g: my-id', 'taman-kit' ),
					'label_block' => false,
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
			$repeater->add_control(
				'css_classes',
				array(
					'label'       => esc_html__( 'CSS Classes', 'taman-kit' ),
					'title'       => esc_html__( 'Add your custom class WITHOUT the dot. e.g: my-class', 'taman-kit' ),
					'label_block' => false,
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'button_layout_tab',
				array(
					'label' => esc_html__( 'Layout', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'single_button_size',
				array(
					'label'   => esc_html__( 'Button Size', 'taman-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'taman-kit' ),
						'xs'      => esc_html__( 'Extra Small', 'taman-kit' ),
						'sm'      => esc_html__( 'Small', 'taman-kit' ),
						'md'      => esc_html__( 'Medium', 'taman-kit' ),
						'lg'      => esc_html__( 'Large', 'taman-kit' ),
						'xl'      => esc_html__( 'Extra Large', 'taman-kit' ),
						'custom'  => esc_html__( 'Custom', 'taman-kit' ),
					),
				)
			);

			$repeater->add_responsive_control(
				'single_button_width',
				array(
					'label'      => esc_html__( 'Button Width', 'taman-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%' ),
					'range'      => array(
						'px' => array(
							'min'  => 10,
							'max'  => 800,
							'step' => 1,
						),
					),
					'selectors'  => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button' => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition'  => array(
						'single_button_size' => 'custom',
					),
				)
			);

			$repeater->add_responsive_control(
				'single_button_padding',
				array(
					'label'      => esc_html__( 'Padding', 'taman-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'button_style_tabs',
				array(
					'label' => esc_html__( 'Style', 'taman-kit' ),
				)
			);

			$repeater->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'single_title_typography',
					'label'    => esc_html__( 'Button Typography', 'taman-kit' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.tk-button .tk-button-title',
				)
			);

			$repeater->add_responsive_control(
				'single_icon_size',
				array(
					'label'     => esc_html__( 'Icon Size', 'taman-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min'  => 5,
							'max'  => 100,
							'step' => 1,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} span.tk-button-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .tk-button-icon-image img' => 'width: {{SIZE}}{{UNIT}};',
					),
					'condition' => array(
						'tk_icon_type!' => 'none',
					),
				)
			);

			$repeater->add_control(
				'single_normal_options',
				array(
					'label'     => esc_html__( 'Normal', 'taman-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'after',
				)
			);
			$repeater->add_control(
				'single_button_bg_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button' => 'background: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:after' => 'background: {{VALUE}};',
					),
				)
			);
			$repeater->add_control(
				'single_text_color',
				array(
					'label'     => esc_html__( 'Text Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button' => 'color: {{VALUE}};',
					),
				)
			);
			$repeater->add_control(
				'single_icon_color',
				array(
					'label'     => esc_html__( 'Icon Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button .tk-buttons-icon-wrapper span' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button .tk-buttons-icon-wrapper .tk-icon svg' => 'fill: {{VALUE}};',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'        => 'single_button_border',
					'label'       => esc_html__( 'Border', 'taman-kit' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} {{CURRENT_ITEM}}.tk-button',
				)
			);
			$repeater->add_control(
				'single_button_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'taman-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

					),
				)
			);

			$repeater->add_control(
				'single_hover_options',
				array(
					'label'     => esc_html__( 'Hover', 'taman-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'after',
				)
			);

			$repeater->add_control(
				'single_button_bg_color_hover',
				array(
					'label'     => esc_html__( 'Background Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:hover' => 'background: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'single_text_color_hover',
				array(
					'label'     => esc_html__( 'Text Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:hover' => 'color: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'single_icon_color_hover',
				array(
					'label'     => esc_html__( 'Icon Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:hover .tk-buttons-icon-wrapper span' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:hover .tk-buttons-icon-wrapper .tk-icon svg' => 'fill: {{VALUE}};',
					),
				)
			);

			$repeater->add_control(
				'single_border_color_hover',
				array(
					'label'     => esc_html__( 'Border Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}}.tk-button:hover' => 'border-color: {{VALUE}};',
					),
				)
			);

			$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'buttons',
			array(
				'label'       => esc_html__( 'Buttons', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array(
					array(
						'text' => esc_html__( 'Button #1', 'taman-kit' ),
					),
					array(
						'text' => esc_html__( 'Button #2', 'taman-kit' ),
					),
				),
			)
		);
		$this->end_controls_section();

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

		/*
		*==================================================================================
		*
		*=============================== Style Tab: Layout =================================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'button_layout',
			array(
				'label' => esc_html__( 'Layout', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'button_size',
			array(
				'label'   => esc_html__( 'Buttons Size', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => array(
					'xs' => esc_html__( 'Extra Small', 'taman-kit' ),
					'sm' => esc_html__( 'Small', 'taman-kit' ),
					'md' => esc_html__( 'Medium', 'taman-kit' ),
					'lg' => esc_html__( 'Large', 'taman-kit' ),
					'xl' => esc_html__( 'Extra Large', 'taman-kit' ),
				),
			)
		);
		$this->add_responsive_control(
			'button_spacing',
			array(
				'label'     => esc_html__( 'Buttons Spacing', 'taman-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .tk-buttons-group .tk-button:not(:last-child)'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'(desktop){{WRAPPER}}.tk-buttons-stack-desktop .tk-buttons-group .tk-button:not(:last-child)'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(tablet){{WRAPPER}}.tk-buttons-stack-tablet .tk-buttons-group .tk-button:not(:last-child)'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}}.tk-buttons-stack-mobile .tk-buttons-group .tk-button:not(:last-child)'  => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'vertical_align',
			array(
				'label'        => esc_html__( 'Vertical Alignment', 'taman-kit' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'middle',
				'options'      => array(
					'top'     => array(
						'title' => esc_html__( 'Top', 'taman-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle'  => array(
						'title' => esc_html__( 'Middle', 'taman-kit' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom'  => array(
						'title' => esc_html__( 'Bottom', 'taman-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
					'stretch' => array(
						'title' => esc_html__( 'Stretch', 'taman-kit' ),
						'icon'  => 'eicon-v-align-stretch',
					),
				),
				'prefix_class' => 'tk-buttons-valign%s-',
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'        => esc_html__( 'Horizontal Alignment', 'taman-kit' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'left',
				'options'      => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
					'stretch' => array(
						'title' => esc_html__( 'Stretch', 'taman-kit' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'prefix_class' => 'tk-buttons-halign%s-',
			)
		);

		$this->add_responsive_control(
			'content_align',
			array(
				'label'                => esc_html__( 'Content Alignment', 'taman-kit' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'left',
				'options'              => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
					'stretch' => array(
						'title' => esc_html__( 'Stretch', 'taman-kit' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'selectors_dictionary' => array(
					'left'    => 'flex-start',
					'center'  => 'center',
					'right'   => 'flex-end',
					'stretch' => 'stretch',
				),
				'selectors'            => array(
					'{{WRAPPER}} .tk-button .tk-button-content-wrapper'   => 'justify-content: {{VALUE}};',
				),
				'condition'            => array(
					'button_align' => 'stretch',
				),
			)
		);

		$this->add_control(
			'stack_on',
			array(
				'label'        => esc_html__( 'Stack on', 'taman-kit' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'description'  => esc_html__( 'Choose a breakpoint where the buttons will stack.', 'taman-kit' ),
				'options'      => array(
					'none'    => esc_html__( 'None', 'taman-kit' ),
					'desktop' => esc_html__( 'Desktop', 'taman-kit' ),
					'tablet'  => esc_html__( 'Tablet', 'taman-kit' ),
					'mobile'  => esc_html__( 'Mobile', 'taman-kit' ),
				),
				'prefix_class' => 'tk-buttons-stack-',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/*
		*==================================================================================
		*
		*=============================== Style Tab: Styling =================================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'section_info_box_button_style',
			array(
				'label' => esc_html__( 'Styling', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .tk-button',
			)
		);
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'taman-kit' ),
			)
		);

			$this->add_control(
				'button_bg_color_normal',
				array(
					'label'     => esc_html__( 'Background Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'scheme'    => array(
						'type'  => Scheme_Color::get_type(),
						'value' => Scheme_Color::COLOR_4,
					),
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-button' => 'background: {{VALUE}};',
					),
				)
			);
			$this->add_control(
				'button_text_color_normal',
				array(
					'label'     => esc_html__( 'Text Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-button' => 'color: {{VALUE}}',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'        => 'button_border_normal',
					'label'       => esc_html__( 'Border', 'taman-kit' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .tk-button',
				)
			);
			$this->add_responsive_control(
				'button_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'taman-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} .tk-button'       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .tk-button:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'button_box_shadow',
					'selector' => '{{WRAPPER}} .tk-button',
				)
			);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'taman-kit' ),
			)
		);

			$this->add_control(
				'button_bg_color_hover',
				array(
					'label'     => esc_html__( 'Background Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-button:hover' => 'background: {{VALUE}};',
					),
				)
			);
			$this->add_control(
				'button_text_color_hover',
				array(
					'label'     => esc_html__( 'Text Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-button:hover' => 'color: {{VALUE}}',
					),
				)
			);
			$this->add_control(
				'button_border_color_hover',
				array(
					'label'     => esc_html__( 'Border Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-button:hover' => 'border-color: {{VALUE}}',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'button_box_shadow_hover',
					'selector' => '{{WRAPPER}} .tk-button:hover',
				)
			);
			$this->add_control(
				'button_animation',
				array(
					'label' => esc_html__( 'Animation', 'taman-kit' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				)
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		*==================================================================================
		*
		*=============================== Style Tab: Icon ==================================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'section_icon_style',
			array(
				'label' => esc_html__( 'Icon', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'icon_typography',
				'label'    => esc_html__( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .tk-button-icon-number',
			)
		);
		$this->add_responsive_control(
			'icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => array(
					'after'  => esc_html__( 'After', 'taman-kit' ),
					'before' => esc_html__( 'Before', 'taman-kit' ),
					'top'    => esc_html__( 'Top', 'taman-kit' ),
					'bottom' => esc_html__( 'Bottom', 'taman-kit' ),
				),
			)
		);
		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => esc_html__( 'Size', 'taman-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => '',
				),
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .tk-button-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tk-button-icon-image img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'icon_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'taman-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 8,
				),
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .tk-icon-before .tk-buttons-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tk-icon-after .tk-buttons-icon-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tk-icon-top .tk-buttons-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tk-icon-bottom .tk-buttons-icon-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_icon_style' );

			$this->start_controls_tab(
				'tab_icon_normal',
				array(
					'label' => esc_html__( 'Normal', 'taman-kit' ),
				)
			);
			$this->add_control(
				'icon_color',
				array(
					'label'     => esc_html__( 'Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-buttons-icon-wrapper span' => 'color: {{VALUE}};',
						'{{WRAPPER}} .tk-buttons-icon-wrapper .tk-icon svg' => 'fill: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tab_icon_hover',
				array(
					'label' => esc_html__( 'Hover', 'taman-kit' ),
				)
			);

			$this->add_control(
				'icon_color_hover',
				array(
					'label'     => esc_html__( 'Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'{{WRAPPER}} .tk-button:hover .tk-buttons-icon-wrapper .tk-button-icon' => 'color: {{VALUE}};',
						'{{WRAPPER}} .tk-button:hover .tk-buttons-icon-wrapper .tk-icon svg' => 'fill: {{VALUE}};',
					),
				)
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*
		*==================================================================================
		*
		*=============================== Style Tab: Tooltip ===============================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'section_tooltip_style',
			array(
				'label' => esc_html__( 'Tooltip', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'tooltips_position',
				array(
					'label'   => esc_html__( 'Tooltip Position', 'taman-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'top'          => esc_html__( 'Above', 'taman-kit' ),
						'top-left'     => esc_html__( 'Top Left', 'taman-kit' ),
						'top-right'    => esc_html__( 'Top Right', 'taman-kit' ),
						'bottom'       => esc_html__( 'Bottom', 'taman-kit' ),
						'bottom-left'  => esc_html__( 'Bottom Left', 'taman-kit' ),
						'bottom-right' => esc_html__( 'Bottom Right', 'taman-kit' ),
						'left'         => esc_html__( 'Left', 'taman-kit' ),
						'right'        => esc_html__( 'Right', 'taman-kit' ),
					),
				)
			);
			$this->add_control(
				'tooltips_align',
				array(
					'label'     => esc_html__( 'Text Align', 'taman-kit' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => ' center',
					'options'   => array(
						'left'   => array(
							'title' => esc_html__( 'Left', 'taman-kit' ),
							'icon'  => 'fa fa-align-left',
						),
						'center' => array(
							'title' => esc_html__( 'Center', 'taman-kit' ),
							'icon'  => 'fa fa-align-center',
						),
						'right'  => array(
							'title' => esc_html__( 'Right', 'taman-kit' ),
							'icon'  => 'fa fa-align-right',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip' => 'text-align: {{VALUE}};',
					),
				)
			);
			$this->add_responsive_control(
				'tooltips_padding',
				array(
					'label'      => esc_html__( 'Padding', 'taman-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->add_responsive_control(
				'tooltips_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'taman-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'      => 'tooltips_typography',
					'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
					'separator' => 'after',
					'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip',
				)
			);
			$the_id = $item['_id'];
			$this->add_control(
				'tooltips_background_color',
				array(
					'label'     => esc_html__( 'Background Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#000000',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip'     => 'background: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip:after' => 'border-top-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip.tk-left .elementor-repeater-item-callout:after' => 'border-left-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip.tk-right .elementor-repeater-item-callout:after' => 'border-right-color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip.tk-bottom .elementor-repeater-item-callout:after' => 'border-bottom-color: {{VALUE}};',
					),
				)
			);
			$this->add_control(
				'tooltips_color',
				array(
					'label'     => esc_html__( 'Color', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip' => 'color: {{VALUE}};',
					),
				)
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'      => 'tooltips_box_shadow',
					'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip',
					'separator' => '',
				)
			);

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
	 * Render buttons widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$fallback_defaults = array(
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		);

		// Button Animation.
		$button_animation = '';
		if ( $settings['button_animation'] ) {
			$button_animation = 'elementor-animation-' . $settings['button_animation'];
		}

		$i = 1;
		?>
		<div class="tk-buttons-group">
			<?php foreach ( $settings['buttons'] as $index => $item ) : ?>
				<?php
				$button_style      = $item['css_style_classes'];
				$button_key        = $this->get_repeater_setting_key( 'button', 'buttons', $index );
				$content_inner_key = $this->get_repeater_setting_key( 'content', 'buttons', $index );

				// Button Size.
				$button_size = ( 'default' !== $item['single_button_size'] ) ? $item['single_button_size'] : $settings['button_size'];

				// Link.
				if ( ! empty( $item['link']['url'] ) ) {
					$this->add_link_attributes( $button_key, $item['link'] );
				}

				// Icon Position.
				$icon_position = '';
				if ( $settings['icon_position'] ) {
					$icon_position = 'tk-icon-' . $settings['icon_position'];
				}
				if ( $settings['icon_position_tablet'] ) {
					$icon_position .= ' tk-icon-' . $settings['icon_position_tablet'] . '-tablet';
				}
				if ( $settings['icon_position_mobile'] ) {
					$icon_position .= ' tk-icon-' . $settings['icon_position_mobile'] . '-mobile';
				}

				$this->add_render_attribute(
					$button_key,
					'class',
					array(
						'tk-button',
						$button_style,
						'elementor-button',
						'elementor-size-' . $button_size,
						'elementor-repeater-item-' . $item['_id'],
						$button_animation,
					)
				);

				// CSS ID.
				if ( $item['css_id'] ) {
					$this->add_render_attribute( $button_key, 'id', $item['css_id'] );
				}

				// Custom Class.
				if ( $item['css_classes'] ) {
					$this->add_render_attribute( $button_key, 'class', $item['css_classes'] );
				}

				// ToolTip.
				if ( 'yes' === $item['has_tooltip'] && ! empty( $item['tooltip_content'] ) ) {
					$ttip_position        = $this->get_tooltip_position( $settings['tooltips_position'] );
					$ttip_position_tablet = $this->get_tooltip_position( $settings['tooltips_position_tablet'] );
					$ttip_position_mobile = $this->get_tooltip_position( $settings['tooltips_position_mobile'] );

					if ( $settings['tooltips_position_tablet'] ) {
						$ttip_tablet = $ttip_position_tablet;
					} else {
						$ttip_tablet = $ttip_position;
					};

					if ( $settings['tooltips_position_mobile'] ) {
						$ttip_mobile = $ttip_position_mobile;
					} else {
						$ttip_mobile = $ttip_position;
					};

					$this->add_render_attribute(
						$button_key,
						array(
							'data-uk-tooltip' => '',
							'title'           => wp_kses_post( $item['tooltip_content'] ),
							'uk-tooltip'      => 'cls: uk-active tooltip tk-' . $item['_id'] . ';pos:' . $ttip_position,
						)
					);
				}

				$this->add_render_attribute(
					$content_inner_key,
					'class',
					array(
						'tk-button-content-inner',
						$icon_position,
					)
				);
				?>
				<a <?php echo $this->get_render_attribute_string( $button_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<div class="tk-button-content-wrapper">
						<span <?php echo $this->get_render_attribute_string( $content_inner_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<?php
							if ( 'none' !== $item['tk_icon_type'] ) {
								$icon_key  = 'icon_' . $i;
								$icon_wrap = 'tk-buttons-icon-wrapper';
								$this->add_render_attribute( $icon_key, 'class', $icon_wrap );
								$migration_allowed = Icons_Manager::is_migration_allowed();
								?>
								<span <?php echo $this->get_render_attribute_string( $icon_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
									<?php
									if ( 'icon' === $item['tk_icon_type'] ) {
										// add old default.
										if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
											$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
										}

										$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
										$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

										if ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) {
											?>
											<span class="tk-button-icon tk-icon">
												<?php
												if ( $is_new || $migrated ) {
													Icons_Manager::render_icon(
														$item['selected_icon'],
														array(
															'class' => 'tk-button-icon',
															'aria-hidden' => 'true',
														)
													);
												} else {
													?>
														<i class="tk-button-icon <?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
														<?php
												}
												?>
											</span>
											<?php
										}
									} elseif ( 'image' === $item['tk_icon_type'] ) {
										printf( '<span class="tk-button-icon-image">%1$s</span>', Group_Control_Image_Size::get_attachment_image_html( $item, 'icon_img', 'icon_img' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									} elseif ( 'text' === $item['tk_icon_type'] ) {
										printf( '<span class="tk-button-icon tk-button-icon-number">%1$s</span>', esc_attr( $item['icon_text'] ) );
									}
									?>
								</span>
								<?php
							}
							if ( $item['text'] ) {
								?>
								<?php
								$text_key = $this->get_repeater_setting_key( 'text', 'buttons', $index );
								$this->add_render_attribute( $text_key, 'class', 'tk-button-title' );
								$this->add_inline_editing_attributes( $text_key, 'none' );
								?>

								<span <?php echo $this->get_render_attribute_string( $text_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php
									echo esc_html( $item['text'] );
								?>
								</span>
							<?php } ?>
						</span>
					</div>
				</a>
				<?php
				$i++;
			endforeach;
			?>
		</div>
		<?php
	}

	/**
	 * Tooltip Position
	 *
	 * @param string $tk_position  get the tooltip position.
	 */
	protected function get_tooltip_position( $tk_position ) {
		switch ( $tk_position ) {
			case 'top':
				$tk_position = 'top';
				break;

			case 'top-left':
				$tk_position = 'top-left';
				break;

			case 'top-right':
				$tk_position = 'top-right';
				break;
			case 'bottom':
				$tk_position = 'bottom';
				break;
			case 'bottom-left':
					$tk_position = 'bottom-left';
				break;
			case 'bottom-right':
						$tk_position = 'bottom-right';
				break;
			case 'left':
							$tk_position = 'left';
				break;
			case 'right':
								$tk_position = 'right';
				break;

			default:
				$tk_position = 'top';
				break;
		}

		return $tk_position;
	}

	/**
	 * Render buttons widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.1.3
	 * @access protected
	 */
	protected function content_template() {
		?>
		<div class="tk-buttons-group">
			<# var i = 1; #>
			<#
			function get_tooltip_position( $tk_position ) {
				switch ( $tk_position ) {
					case 'top':
						$tk_position = 'top';
						break;

					case 'top-left':
						$tk_position = 'top-left';
						break;

					case 'top-right':
						$tk_position = 'top-right';
						break;
					case 'bottom':
						$tk_position = 'bottom';
						break;
					case 'bottom-left':
							$tk_position = 'bottom-left';
						break;
					case 'bottom-right':
								$tk_position = 'bottom-right';
						break;
					case 'left':
									$tk_position = 'left';
						break;
					case 'right':
										$tk_position = 'right';
						break;

					default:
						$tk_position = 'top';
						break;
				}

				return $tk_position;
			}
			#>
			<# _.each( settings.buttons, function( item, index ) { #>
				<#
				var button_key = 'button_' + i,
					content_inner_key = 'content-inner_' + i,
					buttonSize = '',
					iconPosition = '',
					iconsHTML = {},
					migrated = {};

				if ( item.single_button_size != 'default' ) {
					buttonSize = item.single_button_size;
				} else {
					buttonSize = settings.button_size;
				}

				if ( settings.icon_position ) {
					iconPosition = 'tk-icon-' + settings.icon_position;
				}

				if ( settings.icon_position_tablet ) {
					iconPosition += ' tk-icon-' + settings.icon_position_tablet + '-tablet';
				}

				if ( settings.icon_position_mobile ) {
					iconPosition += ' tk-icon-' + settings.icon_position_mobile + '-mobile';
				}

				view.addRenderAttribute(
					button_key,
					{
						'id': item.css_id,
						'class': [
							'tk-button '
							+ item.css_style_classes,
							'elementor-button',
							'elementor-size-' + buttonSize,
							'elementor-repeater-item-' + item._id,
							'elementor-animation-' + settings.button_animation,
							item.css_classes,

						],
					}
				);

				if ( item.has_tooltip == 'yes' && item.tooltip_content != '' ) {
					var ttip_tablet;
					var ttip_mobile;

					if ( settings.tooltips_position_tablet ) {
						ttip_tablet = settings.tooltips_position_tablet;
					} else { 
						ttip_tablet = settings.tooltips_position;
					};
					if ( settings.tooltips_position_mobile ) {
						ttip_mobile = settings.tooltips_position_mobile;
					} else { 
						ttip_mobile = settings.tooltips_position;
					};

					view.addRenderAttribute(
						button_key,
						{
							'data-uk-tooltip':'',
							'title': item.tooltip_content,
							' uk-tooltip': 'cls: uk-active tooltip tk-'+ item._id + ';pos:' + settings.tooltips_position,
						}
					);
				}

				if ( item.link.url != '' ) {
					view.addRenderAttribute( button_key, 'href', item.link.url );

					if ( item.link.is_external ) {
						view.addRenderAttribute( button_key, 'target', '_blank' );
					}

					if ( item.link.nofollow ) {
						view.addRenderAttribute( button_key, 'rel', 'nofollow' );
					}
				}

				view.addRenderAttribute(
					content_inner_key,
					{
						'class': [
							'tk-button-content-inner',
							iconPosition,
						],
					}
				);
				#>
				<a {{{ view.getRenderAttributeString( button_key ) }}}>
					<div class="tk-button-content-wrapper">
						<span {{{ view.getRenderAttributeString( content_inner_key ) }}}>
							<# if ( item.tk_icon_type != 'none' ) { #>
								<#
									var icon_key = 'icon_' + i;

									view.addRenderAttribute( icon_key, 'class', 'tk-buttons-icon-wrapper' );
								#>
								<span {{{ view.getRenderAttributeString( icon_key ) }}}>
									<# if ( item.tk_icon_type == 'icon' ) { #>
										<# if ( item.button_icon || item.selected_icon.value ) { #>
											<span class="tk-button-icon tk-icon">
											<#
												iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden': true }, 'i', 'object' );
												migrated[ index ] = elementor.helpers.isIconMigrated( item, 'selected_icon' );
												if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.button_icon || migrated[ index ] ) ) { #>
													{{{ iconsHTML[ index ].value }}}
												<# } else { #>
													<i class="{{ item.button_icon }}" aria-hidden="true"></i>
												<# }
											#>
											</span>
										<# } #>
									<# } else if ( item.tk_icon_type == 'image' ) { #>
										<span class="tk-button-icon-image">
											<#
											var image = {
												id: item.icon_img.id,
												url: item.icon_img.url,
												size: item.icon_img_size,
												dimension: item.icon_img_custom_dimension,
												model: view.getEditModel()
											};
											var image_url = elementor.imagesManager.getImageUrl( image );
											#>
											<img src="{{{ image_url }}}">
										</span>
									<# } else if ( item.tk_icon_type == 'text' ) { #>
										<span class="tk-button-icon tk-button-icon-number">
											{{{ item.icon_text }}}
										</span>
									<# } #>
								</span>
							<# } #>

							<# if ( item.text != '' ) { #>
								<#
									var text_key = 'text_' + i;

									view.addRenderAttribute( text_key, 'class', 'tk-button-title' );

									view.addInlineEditingAttributes( text_key, 'none' );
								#>

								<span {{{ view.getRenderAttributeString( text_key ) }}}>
									{{{ item.text }}}
								</span>
							<# } #>
						</span>
					</div>
				</a>
			<# i++ } ); #>
		</div>
		<?php
	}

	/**
	 * Render divider widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * Remove this after Elementor v3.3.0
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->content_template();
	}

}
