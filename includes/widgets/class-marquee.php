<?php
/**
 * Elementor marquee Widget.
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
class Marquee extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve marquee widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-marquee';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve marquee widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Marquee', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve marquee widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon  eicon-form-vertical';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the marquee widget belongs to.
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
	 * Register marquee widget controls.
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
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'content_marquee' );

		$repeater->add_control(
			'title_marquee',
			array(
				'label'   => __( 'Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Marquee Item',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'link_marquee',
			array(
				'label'   => __( 'Link', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->end_controls_tab();

		$this->add_control(
			'marquee',
			array(
				'label'       => __( 'Marquee Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title_marquee' => 'Marquee Item',
						'link_marquee'  => '#',

					),
					array(
						'title_marquee' => 'Marquee Item',
						'link_marquee'  => '#',

					),

				),
				'title_field' => '{{{ title_marquee }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'setting_section',
			array(
				'label' => esc_html__( 'Setting', 'taman-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'num_marquee',
			array(
				'label'     => __( 'Animation Speed', 'taman-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 20,
				'selectors' => array(
					'.tk-marquee-{{ID}} .tk-marquee-inner' => 'animation: tkmarquee {{VALUE}}s linear infinite running',
				),
			)
		);

		$this->add_control(
			'marquee_push',
			array(
				'label'        => __( 'Push On Hover', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'off',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
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
			'slidshow__style',
			array(
				'label' => esc_html__( 'Style', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'marquee_bg',
				'label'    => __( 'Background', 'taman-kit' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '.tk-marquee-{{ID}}',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'marquee_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-marquee-{{ID}}',
			)
		);

		$this->add_control(
			'marquee_border_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-marquee-{{ID}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'marquee_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.tk-marquee-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'marquee_box_shadow',
				'selector'  => '.tk-marquee-{{ID}}',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item__style',
			array(
				'label' => esc_html__( 'Item', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'marquee_is_stroke',
			array(
				'label'        => __( 'Texet Stroke', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'off',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'background_color_item',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-marquee-{{ID}} .tk-marquee-item' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'marquee_item_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-marquee-{{ID}} .tk-marquee-item',
			)
		);

		$this->add_control(
			'marquee_border_radius_item',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-marquee-{{ID}} .tk-marquee-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'marquee_item_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.tk-marquee-{{ID}} .tk-marquee-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'marquee_margin_item',
			array(
				'label'      => __( 'Margin', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-marquee-{{ID}} .tk-marquee-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'marquee_item_box_shadow',
				'selector'  => '.tk-marquee-{{ID}} .tk-marquee-item',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_item_color',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-marquee-{{ID}} .tk-marquee-item a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'marquee_item_typography',
				'label'    => __( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '.tk-marquee-{{ID}} .tk-marquee-item a',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_hover_style',
			array(
				'label' => esc_html__( 'Item Hover', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'marquee_is_stroke_hover',
			array(
				'label'        => __( 'Texet Stroke Fill', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'off',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'background_color_item_hover',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-marquee-{{ID}} .tk-marquee-item:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'title_item_hover_color',
			array(
				'label'     => __( 'Text Color hover', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-marquee-{{ID}} .tk-marquee-item a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'marquee_item_hover_box__shadow',
				'selector'  => '.tk-marquee-{{ID}} .tk-marquee-item:hover',
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'marquee_item_hover_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-marquee-{{ID}} .tk-marquee-item:hover',
			)
		);

		$this->add_control(
			'marquee_border_radius_item_hover',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-marquee-{{ID}} .tk-marquee-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
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
	 * Render marquee widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings      = $this->get_settings_for_display();
		$marquee       = $settings['marquee'];
		$_push         = $settings['marquee_push'];
		$push          = ( 'yes' === $_push ) ? 'marquee_push' : '';
		$_stroke       = $settings['marquee_is_stroke'];
		$_stroke_hover = $settings['marquee_is_stroke_hover'];

		$stroke       = ( 'yes' === $_stroke ) ? 'tamanh1-is-stroke' : '';
		$stroke_hover = ( 'yes' === $_stroke_hover ) ? 'tamanh1-is-stroke-hover' : '';

		$this->add_render_attribute(
			'marquee',
			array(
				'class' => array(
					'tk-marquee-' . esc_attr( $this->get_id() ),
					'tk-el-marquee',
					$push,
				),
				'id'    => 'tk-marquee-' . esc_attr( $this->get_id() ),
			),
		);
		?>
		<div <?php echo $this->get_render_attribute_string( 'marquee' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="tk-marquee">
			<div class="tk-marquee-inner">

				<?php
				foreach ( $marquee as $item ) {

					echo '<div class="tk-marquee-item elementor-repeater-item-' . esc_attr( $item['_id'] ) . '  tk-marquee-item-' . esc_attr( $item['_id'] ) . '">';
					echo '<a class="' . esc_attr( $stroke ) . '  ' . esc_attr( $stroke_hover ) . '" href="' . esc_url( $item['link_marquee'] ) . '" >';
					echo esc_html( $item['title_marquee'] );
					echo '</a></div>';

				}
				?>
			</div>

			</div>
		</div>
		<?php
	}

}
