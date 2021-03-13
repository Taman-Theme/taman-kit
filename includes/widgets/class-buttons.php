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
		return 'eicon-button';
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
	 * @since 2.1.3
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
				'label' => __( 'Buttons', 'taman-kit' ),
			)
		);
		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'buttons_tabs' );

			$repeater->start_controls_tab(
				'button_general',
				array(
					'label' => __( 'Content', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'text',
				array(
					'label'       => __( 'Text', 'taman-kit' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Button #1', 'taman-kit' ),
					'placeholder' => __( 'Button #1', 'taman-kit' ),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);
			$repeater->add_control(
				'tk_icon_type',
				array(
					'label'       => __( 'Icon Type', 'taman-kit' ),
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
					'label'            => __( 'Icon', 'taman-kit' ),
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
					'label'       => __( 'Image', 'taman-kit' ),
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
					'label'     => __( 'Image Size', 'taman-kit' ),
					'default'   => 'full',
					'condition' => array(
						'tk_icon_type' => 'image',
					),
				)
			);
			$repeater->add_control(
				'icon_text',
				array(
					'label'       => __( 'Icon Text', 'taman-kit' ),
					'label_block' => false,
					'type'        => Controls_Manager::TEXT,
					'default'     => __( '1', 'taman-kit' ),
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
					'label'   => __( 'Enable Tooltip', 'taman-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'yes'     => __( 'Yes', 'taman-kit' ),
					'no'      => __( 'No', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'tooltip_content',
				array(
					'label'       => __( 'Tooltip Content', 'taman-kit' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => __( 'I am a tooltip for a button', 'taman-kit' ),
					'placeholder' => __( 'I am a tooltip for a button', 'taman-kit' ),
					'rows'        => 5,
					'condition'   => array(
						'has_tooltip' => 'yes',
					),
				)
			);

			$repeater->add_control(
				'link',
				array(
					'label'       => __( 'Link', 'taman-kit' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => array(
						'active' => true,
					),
					'label_block' => true,
					'placeholder' => __( 'http://your-link.com', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'css_style_classes',
				array(
					'label'       => __( 'Style', 'taman-kit' ),
					'title'       => __( 'Chosse Custom Butoon Style', 'taman-kit' ),
					'label_block' => false,
					'type'        => Controls_Manager::SELECT,
					'default'     => 'style1',
					'options'     => array(
						'style1' => __( 'Style 1', 'taman-kit' ),
						'style2' => __( 'Style 2', 'taman-kit' ),
						'style3' => __( 'Style 3', 'taman-kit' ),
						'style4' => __( 'Style 4', 'taman-kit' ),
						'style5' => __( 'Style 5', 'taman-kit' ),
						'style6' => __( 'Style 6', 'taman-kit' ),
					),
					'dynamic'     => array(
						'active' => true,
					),
				)
			);

			$repeater->add_control(
				'css_id',
				array(
					'label'       => __( 'CSS ID', 'taman-kit' ),
					'title'       => __( 'Add your custom ID WITHOUT the # key. e.g: my-id', 'taman-kit' ),
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
					'label'       => __( 'CSS Classes', 'taman-kit' ),
					'title'       => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'taman-kit' ),
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
					'label' => __( 'Layout', 'taman-kit' ),
				)
			);

			$repeater->add_control(
				'single_button_size',
				array(
					'label'   => __( 'Button Size', 'taman-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => array(
						'default' => __( 'Default', 'taman-kit' ),
						'xs'      => __( 'Extra Small', 'taman-kit' ),
						'sm'      => __( 'Small', 'taman-kit' ),
						'md'      => __( 'Medium', 'taman-kit' ),
						'lg'      => __( 'Large', 'taman-kit' ),
						'xl'      => __( 'Extra Large', 'taman-kit' ),
						'custom'  => __( 'Custom', 'taman-kit' ),
					),
				)
			);

			$repeater->add_responsive_control(
				'single_button_width',
				array(
					'label'      => __( 'Button Width', 'taman-kit' ),
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
					'label'      => __( 'Padding', 'taman-kit' ),
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
					'label' => __( 'Style', 'taman-kit' ),
				)
			);

			$repeater->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'single_title_typography',
					'label'    => __( 'Button Typography', 'taman-kit' ),
					'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}.tk-button .tk-button-title',
				)
			);

			$repeater->add_responsive_control(
				'single_icon_size',
				array(
					'label'     => __( 'Icon Size', 'taman-kit' ),
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
					'label'     => __( 'Normal', 'taman-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'after',
				)
			);
			$repeater->add_control(
				'single_button_bg_color',
				array(
					'label'     => __( 'Background Color', 'taman-kit' ),
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
					'label'     => __( 'Text Color', 'taman-kit' ),
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
					'label'     => __( 'Icon Color', 'taman-kit' ),
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
					'label'       => __( 'Border', 'taman-kit' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} {{CURRENT_ITEM}}.tk-button',
				)
			);
			$repeater->add_control(
				'single_button_border_radius',
				array(
					'label'      => __( 'Border Radius', 'taman-kit' ),
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
					'label'     => __( 'Hover', 'taman-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'after',
				)
			);

			$repeater->add_control(
				'single_button_bg_color_hover',
				array(
					'label'     => __( 'Background Color', 'taman-kit' ),
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
					'label'     => __( 'Text Color', 'taman-kit' ),
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
					'label'     => __( 'Icon Color', 'taman-kit' ),
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
					'label'     => __( 'Border Color', 'taman-kit' ),
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
				'label'       => __( 'Buttons', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array(
					array(
						'text' => __( 'Button #1', 'taman-kit' ),
					),
					array(
						'text' => __( 'Button #2', 'taman-kit' ),
					),
				),
			)
		);
		$this->end_controls_section();

		if ( ! taman_kit_is_active() ) {
			$this->start_controls_section(
				'section_upgrade_tamankit',
				array(
					'label' => apply_filters( 'upgrade_tamankit_title', __( 'Get Tamankit Pro', 'taman-kit' ) ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'upgrade_tamankit_notice',
				array(
					'label'           => '',
					'type'            => Controls_Manager::RAW_HTML,
					/* translators: draft saved date format, see http://php.net/date */
					'raw'             => apply_filters( 'upgrade_tamankit_message', sprintf( __( 'Upgrade to %1$s Pro Version %2$s for 70+ widgets, exciting extensions and advanced features.', 'taman-kit' ), '<a href="#" target="_blank" rel="noopener">', '</a>' ) ),
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
				'label' => __( 'Layout', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'button_size',
			array(
				'label'   => __( 'Buttons Size', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => array(
					'xs' => __( 'Extra Small', 'taman-kit' ),
					'sm' => __( 'Small', 'taman-kit' ),
					'md' => __( 'Medium', 'taman-kit' ),
					'lg' => __( 'Large', 'taman-kit' ),
					'xl' => __( 'Extra Large', 'taman-kit' ),
				),
			)
		);
		$this->add_responsive_control(
			'button_spacing',
			array(
				'label'     => __( 'Buttons Spacing', 'taman-kit' ),
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
				'label'        => __( 'Vertical Alignment', 'taman-kit' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'middle',
				'options'      => array(
					'top'     => array(
						'title' => __( 'Top', 'taman-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle'  => array(
						'title' => __( 'Middle', 'taman-kit' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom'  => array(
						'title' => __( 'Bottom', 'taman-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
					'stretch' => array(
						'title' => __( 'Stretch', 'taman-kit' ),
						'icon'  => 'eicon-v-align-stretch',
					),
				),
				'prefix_class' => 'tk-buttons-valign%s-',
			)
		);

		$this->add_responsive_control(
			'button_align',
			array(
				'label'        => __( 'Horizontal Alignment', 'taman-kit' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'left',
				'options'      => array(
					'left'    => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
					'stretch' => array(
						'title' => __( 'Stretch', 'taman-kit' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'prefix_class' => 'tk-buttons-halign%s-',
			)
		);

		$this->add_responsive_control(
			'content_align',
			array(
				'label'                => __( 'Content Alignment', 'taman-kit' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'left',
				'options'              => array(
					'left'    => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
					'stretch' => array(
						'title' => __( 'Stretch', 'taman-kit' ),
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
				'label'        => __( 'Stack on', 'taman-kit' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'description'  => __( 'Choose a breakpoint where the buttons will stack.', 'taman-kit' ),
				'options'      => array(
					'none'    => __( 'None', 'taman-kit' ),
					'desktop' => __( 'Desktop', 'taman-kit' ),
					'tablet'  => __( 'Tablet', 'taman-kit' ),
					'mobile'  => __( 'Mobile', 'taman-kit' ),
				),
				'prefix_class' => 'tk-buttons-stack-',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
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
				'label' => __( 'Styling', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .tk-button',
			)
		);
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __( 'Normal', 'taman-kit' ),
			)
		);

			$this->add_control(
				'button_bg_color_normal',
				array(
					'label'     => __( 'Background Color', 'taman-kit' ),
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
					'label'     => __( 'Text Color', 'taman-kit' ),
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
					'label'       => __( 'Border', 'taman-kit' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .tk-button',
				)
			);
			$this->add_responsive_control(
				'button_border_radius',
				array(
					'label'      => __( 'Border Radius', 'taman-kit' ),
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
				'label' => __( 'Hover', 'taman-kit' ),
			)
		);

			$this->add_control(
				'button_bg_color_hover',
				array(
					'label'     => __( 'Background Color', 'taman-kit' ),
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
					'label'     => __( 'Text Color', 'taman-kit' ),
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
					'label'     => __( 'Border Color', 'taman-kit' ),
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
					'label' => __( 'Animation', 'taman-kit' ),
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
				'label' => __( 'Icon', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'icon_typography',
				'label'    => __( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .tk-button-icon-number',
			)
		);
		$this->add_responsive_control(
			'icon_position',
			array(
				'label'   => __( 'Icon Position', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => array(
					'after'  => __( 'After', 'taman-kit' ),
					'before' => __( 'Before', 'taman-kit' ),
					'top'    => __( 'Top', 'taman-kit' ),
					'bottom' => __( 'Bottom', 'taman-kit' ),
				),
			)
		);
		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => __( 'Size', 'taman-kit' ),
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
				'label'     => __( 'Spacing', 'taman-kit' ),
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
					'label' => __( 'Normal', 'taman-kit' ),
				)
			);
			$this->add_control(
				'icon_color',
				array(
					'label'     => __( 'Color', 'taman-kit' ),
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
					'label' => __( 'Hover', 'taman-kit' ),
				)
			);

			$this->add_control(
				'icon_color_hover',
				array(
					'label'     => __( 'Color', 'taman-kit' ),
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
				'label' => __( 'Tooltip', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'tooltips_position',
				array(
					'label'   => __( 'Tooltip Position', 'taman-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'top',
					'options' => array(
						'top'          => __( 'Above', 'taman-kit' ),
						'top-left'     => __( 'Top Left', 'taman-kit' ),
						'top-right'    => __( 'Top Right', 'taman-kit' ),
						'bottom'       => __( 'Bottom', 'taman-kit' ),
						'bottom-left'  => __( 'Bottom Left', 'taman-kit' ),
						'bottom-right' => __( 'Bottom Right', 'taman-kit' ),
						'left'         => __( 'Left', 'taman-kit' ),
						'right'        => __( 'Right', 'taman-kit' ),
					),
				)
			);
			$this->add_control(
				'tooltips_align',
				array(
					'label'     => __( 'Text Align', 'taman-kit' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => ' center',
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
					'selectors' => array(
						'{{WRAPPER}} {{CURRENT_ITEM}} .uk-tooltip.uk-active.tooltip' => 'text-align: {{VALUE}};',
					),
				)
			);
			$this->add_responsive_control(
				'tooltips_padding',
				array(
					'label'      => __( 'Padding', 'taman-kit' ),
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
					'label'      => __( 'Border Radius', 'taman-kit' ),
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
					'label'     => __( 'Background Color', 'taman-kit' ),
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
					'label'     => __( 'Color', 'taman-kit' ),
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
