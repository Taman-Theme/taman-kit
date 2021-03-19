<?php
/**
 * Elementor label Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 * @package Taman Kit.
 */

namespace TamanKit\Widgets;

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
class Label extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve label widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'label';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve label widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Label', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve label widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon  eicon-meta-data';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the label widget belongs to.
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
	 * Register label widget controls.
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
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);


		$this->add_control(
			'label_type',
			array(
				'label'   => esc_html__( 'Additional Styles', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'uk-label',
				'options' => array(
					'uk-label uk-label-success' => esc_html__( 'Success', 'taman-kit' ),
					'uk-label uk-label-warning' => esc_html__( 'Warning', 'taman-kit' ),
					'uk-label uk-label-danger'  => esc_html__( 'Danger', 'taman-kit' ),
					'uk-label'                  => esc_html__( 'Default', 'taman-kit' ),
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'      => esc_html__( 'Title', 'taman-kit' ),
				'type'       => Controls_Manager::TEXT,
				'input_type' => 'text',
				'default'    => esc_html__( 'Default', 'taman-kit' ),
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
		*=============================== Style Tab: Style =================================
		*
		*==================================================================================
		*/

		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Content', 'taman-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tk_label_background',
			array(
				'label'     => esc_html__( 'Label Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'tk_label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'tk_label_border',
				'selector' => '{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label',
			)
		);

		$this->add_responsive_control(
			'tk_label_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tk_lable_margin',
			array(
				'label'      => esc_html__( 'Margin', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_typography',
			array(
				'label' => esc_html__( 'Label Typography', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tk_heading_default',
			array(
				'type'  => Controls_Manager::HEADING,
				'label' => esc_html__( 'Default Typography', 'taman-kit' ),
			)
		);

		$this->add_control(
			'tk_label_color',
			array(
				'label'     => esc_html__( 'Font Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tk_label_default_typography',
				'selector' => '{{WRAPPER}} .tk-label-elementor-widget .tk-label.uk-label',
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
	 * Render label widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings   = $this->get_settings_for_display();
		$title      = $settings['title'];
		$label_type = $settings['label_type'];

		$this->add_render_attribute(
			'label-attr',
			array(
				'class' => 'tk-label ' . $label_type,
			)
		);

		echo '<div class="tk-label-elementor-widget tk-elements">';

		echo '<span ' . $this->get_render_attribute_string( 'label-attr' ) . '>' . esc_html( $title ) . '</span>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '</div>';

	}

}
