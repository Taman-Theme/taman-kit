<?php
/**
 * Elementor Alert Widget.
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
class Alert extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve alert widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'alert';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve alert widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Alert', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve alert widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-alert';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the alert widget belongs to.
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
	 * Register alert widget controls.
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

		$this->add_control(
			'alert_type',
			array(
				'label'   => __( 'Type', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'uk-alert-primary' => __( 'Primary', 'taman-kit' ),
					'uk-alert-success' => __( 'Success', 'taman-kit' ),
					'uk-alert-warning' => __( 'Warning', 'taman-kit' ),
					'uk-alert-danger'  => __( 'Danger', 'taman-kit' ),
					'custom'           => __( 'Custom', 'taman-kit' ),
				),
				'default' => 'uk-alert-primary',
			)
		);

		$this->add_control(
			'alert_title',
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
				'default'   => __( 'Alert Title', 'taman-kit' ),
				'condition' => array(
					'alert_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'   => __( 'Content', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'taman-kit' ),

			)
		);

		$this->end_controls_section();

		/**
		 * Content Tab: Settings
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_layout',
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

		$this->end_controls_section();

		/**============================== */
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
			'section_alert_style',
			array(
				'label'     => __( 'Alert', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'alert_type' => 'custom',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'alert_bg',
				'label'     => __( 'Background', 'taman-kit' ),
				'types'     => array( 'classic', 'gradient' ),
				'condition' => array(
					'alert_type' => 'custom',
				),

				'selector'  => '.tk-alert-{{ID}}.tk-alert-box.uk-alert.custom',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'alert_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-alert-{{ID}}.tk-alert-box.uk-alert.custom',
				'condition'   => array(
					'alert_type' => 'custom',
				),

			)
		);

		$this->add_control(
			'alert_border_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					'alert_type' => 'custom',
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'.tk-alert-{{ID}}.tk-alert-box.uk-alert.custom' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'alert_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'condition'  => array(
					'alert_type' => 'custom',
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.tk-alert-{{ID}}.tk-alert-box.uk-alert.custom' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'alert_box_shadow',
				'selector'  => '.tk-alert-{{ID}}.tk-alert-box.uk-alert.custom',
				'separator' => 'before',
				'condition' => array(
					'alert_type' => 'custom',
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
					'alert_title' => 'yes',
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
					'{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert h3.tk-alert-tittle' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'alert_title' => 'yes',
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
					'{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert h3.tk-alert-tittle' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'alert_title' => 'yes',
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
					'{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert h3.tk-alert-tittle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'alert_title' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typography',
				'label'     => __( 'Typography', 'taman-kit' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert h3.tk-alert-tittle',
				'condition' => array(
					'alert_title' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Content
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_alert_content_style',
			array(
				'label' => __( 'Content', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert p'   => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => __( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .tk-alert-{{ID}}.tk-alert-box.uk-alert p',
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
	 * Render alert widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$alert_type  = $settings['alert_type'];
		$alert_title = $settings['alert_title'];
		$title       = $settings['title'];
		$content     = $settings['content'];
		$close       = $settings['close_button'];

		$this->add_render_attribute(
			'alert',
			array(
				'class'    => array(
					'tk-alert-' . esc_attr( $this->get_id() ),
					'tk-alert-box',
					'uk-alert',
					$alert_type,
				),
				'id'       => 'tk-alert-' . esc_attr( $this->get_id() ),
				'uk-alert' => '',
			),
		);

		?>

		<div <?php echo $this->get_render_attribute_string( 'alert' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

				<?php if ( 'yes' === $close ) : ?>
				<a class="tk-alert-close uk-alert-close" uk-close></a>
				<?php endif; ?>

				<?php if ( 'yes' === $alert_title ) : ?>
				<h3 class="tk-alert-tittle"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>

				<p><?php echo esc_html( $content ); ?></p>

		</div>

		<?php
	}

}
