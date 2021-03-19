<?php
/**
 * Elementor Links Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 * @package Taman Kit.
 */

namespace TamanKit\Widgets;

// Elementor Classes.
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Undocumented class
 */
class Links extends \Elementor\Widget_Base {

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
			'taman-kit-links',
			TAMAN_KIT_URL . 'public/css/widgets/links.css',
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
		return array( 'taman-kit-links' );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve Links widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Links';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Links widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Links', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Links widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-editor-link';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Links widget belongs to.
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
	 * Register Links widget controls.
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
			'section_link_effects',
			array(
				'label' => esc_html__( 'Link Effects', 'taman-kit' ),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'taman-kit' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => esc_html__( 'Click Here', 'taman-kit' ),
			)
		);

		$this->add_control(
			'secondary_text',
			array(
				'label'     => esc_html__( 'Secondary Text', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => esc_html__( 'Click Here', 'taman-kit' ),
				'condition' => array(
					'effect' => 'effect-9',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'taman-kit' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => 'https://www.your-link.com',
				'default'     => array(
					'url' => '#',
				),
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'   => esc_html__( 'Effect', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'effect-1'  => esc_html__( 'Effect 1', 'taman-kit' ),
					'effect-2'  => esc_html__( 'Effect 2', 'taman-kit' ),
					'effect-3'  => esc_html__( 'Effect 3', 'taman-kit' ),
					'effect-4'  => esc_html__( 'Effect 4', 'taman-kit' ),
					'effect-5'  => esc_html__( 'Effect 5', 'taman-kit' ),
					'effect-6'  => esc_html__( 'Effect 6', 'taman-kit' ),
					'effect-7'  => esc_html__( 'Effect 7', 'taman-kit' ),
					'effect-8'  => esc_html__( 'Effect 8', 'taman-kit' ),
					'effect-9'  => esc_html__( 'Effect 9', 'taman-kit' ),
					'effect-10' => esc_html__( 'Effect 10', 'taman-kit' ),
					'effect-11' => esc_html__( 'Effect 11', 'taman-kit' ),
					'effect-12' => esc_html__( 'Effect 12', 'taman-kit' ),
					'effect-13' => esc_html__( 'Effect 13', 'taman-kit' ),
					'effect-14' => esc_html__( 'Effect 14', 'taman-kit' ),
					'effect-15' => esc_html__( 'Effect 15', 'taman-kit' ),
					'effect-16' => esc_html__( 'Effect 16', 'taman-kit' ),
					'effect-17' => esc_html__( 'Effect 17', 'taman-kit' ),
					'effect-18' => esc_html__( 'Effect 18', 'taman-kit' ),
					'effect-19' => esc_html__( 'Effect 19', 'taman-kit' ),
					'effect-20' => esc_html__( 'Effect 20', 'taman-kit' ),
					'effect-21' => esc_html__( 'Effect 21', 'taman-kit' ),
				),
				'default' => 'effect-1',
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'     => esc_html__( 'Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'taman-kit' ),
						'icon'  => 'fa fa-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'taman-kit' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'taman-kit' ),
						'icon'  => 'fa fa-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justified', 'taman-kit' ),
						'icon'  => 'fa fa-align-justify',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
		*=============================== Style Tab: Style =================================
		*
		*==================================================================================
		*/
		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Link Effects', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'label'    => esc_html__( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.tk-link',
			)
		);

		$this->add_responsive_control(
			'divider_title_width',
			array(
				'label'      => esc_html__( 'Width', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 200,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .tk-link-effect-19'      => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .tk-link-effect-19 span' => 'transform-origin: 50% 50% calc(-{{SIZE}}{{UNIT}}/2)',
				),
				'condition'  => array(
					'effect' => 'effect-19',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_link_style' );

		$this->start_controls_tab(
			'tab_link_normal',
			array(
				'label' => esc_html__( 'Normal', 'taman-kit' ),
			)
		);

		$this->add_control(
			'link_color_normal',
			array(
				'label'     => esc_html__( 'Link Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} a.tk-link,
					{{WRAPPER}} .tk-link-effect-15:before,
					{{WRAPPER}} .tk-link-effect-16, {{WRAPPER}} .tk-link-effect-17:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'background_color_normal',
			array(
				'label'     => esc_html__( 'Background Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-link-effect-4 span,
					{{WRAPPER}} .tk-link-effect-20 span' => 'background-color: {{VALUE}};',

					'{{WRAPPER}} .tk-link-effect-2 span' => 'background: {{VALUE}};',

				),
			)
		);

		$this->add_control(
			'link_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-link-effect-8:before,
					{{WRAPPER}}  a.tk-link-effect-12::before,
					{{WRAPPER}}  a.tk-link-effect-12::after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tk-link-effect-11'       => 'border-top-color: {{VALUE}};',

					'
					{{WRAPPER}} a.tk-link-effect-2:hover span:before,
					{{WRAPPER}} a.tk-link-effect-2:focus span:before,
					{{WRAPPER}} .tk-link-effect-2 span:before, 
					{{WRAPPER}} a.tk-link-effect-3::after,
					{{WRAPPER}} a.tk-link-effect-4::after,
					{{WRAPPER}} a.tk-link-effect-5 span:before,
					{{WRAPPER}} .tk-link-effect-6:before,
					{{WRAPPER}} .tk-link-effect-6:after,
					{{WRAPPER}} .tk-link-effect-7:before,
					{{WRAPPER}} .tk-link-effect-7:after,
					{{WRAPPER}} .tk-link-effect-10:hover:before,
					{{WRAPPER}}  .tk-link-effect-10:before,
					{{WRAPPER}} .tk-link-effect-14:before,
					{{WRAPPER}} .tk-link-effect-14:after,
					{{WRAPPER}} a.tk-link-effect-17::after,
					{{WRAPPER}} .tk-link-effect-18:before,
					{{WRAPPER}} .tk-link-effect-18:after,
					{{WRAPPER}} a.tk-link-effect-19:before,
					{{WRAPPER}} a.tk-link-effect-19:after' => 'background: {{VALUE}};',
					'{{WRAPPER}} .tk-link-effect-1:before,
					{{WRAPPER}} .tk-link-effect-1:after,
					{{WRAPPER}} .tk-link-effect-10:hover:before,
					{{WRAPPER}}  .tk-link-effect-10:before,
					{{WRAPPER}} a.tk-link-effect-5 span:before' => 'color: {{VALUE}};',

					'{{WRAPPER}} .tk-link-effect-20 span'  => 'box-shadow: inset 0 3px {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_link_hover',
			array(
				'label' => esc_html__( 'Hover', 'taman-kit' ),
			)
		);

		$this->add_control(
			'link_color_hover',
			array(
				'label'     => esc_html__( 'Link Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} a.tk-link:hover,
					{{WRAPPER}} .tk-link-effect-10:before,
					{{WRAPPER}} .tk-link-effect-11:before,
					{{WRAPPER}}  a.tk-link-effect-16::before,
					{{WRAPPER}} .tk-link-effect-15,
					{{WRAPPER}} .tk-link-effect-16:before,
					{{WRAPPER}} .tk-link-effect-20 span:before' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'background_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-link-effect-4 span:before, {{WRAPPER}} .tk-link-effect-10:before,
					 {{WRAPPER}} .tk-link-effect-20 span:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'link_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .tk-link-effect-8:after' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tk-link-effect-11:before' => 'border-bottom-color: {{VALUE}};',

					'{{WRAPPER}} .tk-link-effect-9:before, 
					{{WRAPPER}} .tk-link-effect-9:after,
					{{WRAPPER}} .tk-link-effect-10:hover:before,
					{{WRAPPER}}  .tk-link-effect-10:before, 
					{{WRAPPER}} .tk-link-effect-14:hover:before, 
					{{WRAPPER}} .tk-link-effect-14:focus:before, 
					{{WRAPPER}} .tk-link-effect-14:hover:after, 
					{{WRAPPER}} .tk-link-effect-14:focus:after, 
					{{WRAPPER}} .tk-link-effect-17:after, 
					{{WRAPPER}} .tk-link-effect-18:hover:before, 
					{{WRAPPER}} .tk-link-effect-18:focus:before, 
					{{WRAPPER}} .tk-link-effect-18:hover:after, 
					{{WRAPPER}} .tk-link-effect-18:focus:after, 
					{{WRAPPER}} .tk-link-effect-21:before, 
					{{WRAPPER}} .tk-link-effect-21:after' => 'background: {{VALUE}};',

					'{{WRAPPER}} .tk-link-effect-10:before,
					{{WRAPPER}} .tk-link-effect-17'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .tk-link-effect-13:hover:before, {{WRAPPER}} .tk-link-effect-13:focus:before' => 'color: {{VALUE}}; text-shadow: 10px 0 {{VALUE}}, -10px 0 {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

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
	 * Render Links widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// get our input from the widget settings.

		$pa_link_text           = ! empty( $settings['text'] ) ? $settings['text'] : '';
		$pa_link_secondary_text = ! empty( $settings['secondary_text'] ) ? $settings['secondary_text'] : '';

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'link', $settings['link'] );
		}

		$this->add_render_attribute( 'link', 'class', 'tk-link ' );

		if ( $settings['effect'] ) {
			$this->add_render_attribute( 'link', 'class', 'uk-transition-toggle tk-link-' . $settings['effect'] );
		}

		if ( 'effect-5' === $settings['effect'] || 'effect-19' === $settings['effect'] || 'effect-20' === $settings['effect'] || 'effect-2' === $settings['effect'] ) {
			$this->add_render_attribute( 'tk-link-text', 'data-hover', $pa_link_text );
		}

		if ( 'effect-15' === $settings['effect'] || 'effect-16' === $settings['effect'] || 'effect-17' === $settings['effect'] || 'effect-18' === $settings['effect'] ) {
			$this->add_render_attribute( 'tk-link-text-2', 'data-hover', $pa_link_text );
		}
		?>

		<a <?php echo $this->get_render_attribute_string( 'link' ); ?><?php echo $this->get_render_attribute_string( 'tk-link-text-2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

			<span <?php echo $this->get_render_attribute_string( 'tk-link-text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php echo esc_html( $pa_link_text ); ?>
			</span>

			<?php if ( 'effect-9' === $settings['effect'] ) {  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span><?php echo esc_attr( $pa_link_secondary_text ); ?></span>
			<?php } ?>

		</a>

		<?php
	}

	/**
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 */
	protected function _content_template() {} // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

}
