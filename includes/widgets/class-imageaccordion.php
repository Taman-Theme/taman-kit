<?php
/**
 * Elementor Image Accordion Widget.
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
use \Elementor\Plugin;
use Elementor\Core\Schemes;
use Elementor\Control_Media;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Core\Responsive\Responsive;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * ImageAccordion class
 */
class ImageAccordion extends \Elementor\Widget_Base {

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
			'taman-kit-imageaccordion',
			TAMAN_KIT_URL . 'public/css/widgets/imageaccordion.css',
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
		return array( 'taman-kit-imageaccordion' );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve imageaccordion widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-imageaccordion';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve imageaccordion widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'ImageAccordion', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve imageaccordion widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-slideshow';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the imageaccordion widget belongs to.
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
	 * Register imageaccordion widget controls.
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

		$repeater->add_control(
			'_image',
			array(
				'label' => __( 'Choose Image', 'taman-kit' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$repeater->add_control(
			'_title',
			array(
				'label'   => __( 'Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Lorem ipsum dolor',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'_description',
			array(
				'label'   => __( 'Description', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'imageaccordion',
			array(
				'label'       => __( 'Imageaccordion Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'_title'       => 'Lorem ipsum dolor',
						'_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
					),

					array(
						'_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'_title'       => 'Lorem ipsum dolor',
						'_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
					),
					array(
						'_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'_title'       => 'Lorem ipsum dolor',
						'_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
					),
					array(
						'_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'_title'       => 'Lorem ipsum dolor',
						'_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
					),
					array(
						'_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'_title'       => 'Lorem ipsum dolor',
						'_description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
					),

				),
				'title_field' => '{{{ _title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_imageaccordion',
			array(
				'label' => __( 'Settings', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'Style__imageaccordion',
			array(
				'label'   => __( 'Style', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => __( 'Style 1', 'taman-kit' ),
					'2' => __( 'Style 2', 'taman-kit' ),
					'3' => __( 'Style 3', 'taman-kit' ),
					'4' => __( 'Style 4', 'taman-kit' ),
					'5' => __( 'Style 5', 'taman-kit' ),
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
			'_style_section',
			array(
				'label' => esc_html__( 'Style', 'taman-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'_height',
			array(
				'label'      => __( 'Height', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 350,
				),
				'selectors'  => array(
					'{{WRAPPER}} .tk-flexbox-slider' => 'height: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->end_controls_section();

			/**
			 * OverLay Style
			 */

			$this->start_controls_section(
				'_overlay_style',
				array(
					'label' => esc_html__( 'OverLay', 'taman-kit' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

			$this->add_control(
				'overlay_bg__color',
				array(
					'label'     => __( 'Overlay Background', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => array(
						'#tk-imageaccordion-{{ID}} .tk-flexbox-slide:after' => 'background-color: {{VALUE}}',
					),
				)
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				array(
					'name'     => 'overlay_gradient_color',
					'label'    => __( 'Overlay Gradient Background', 'plugin-domain' ),
					'types'    => array( 'gradient' ),
					'selector' => '#tk-imageaccordion-{{ID}} .tk-flexbox-slide:after',
				)
			);

			$this->add_control(
				'tex_block_bg__color',
				array(
					'label'     => __( 'Text Block Background', 'taman-kit' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'separator' => 'before',
					'selectors' => array(
						'#tk-imageaccordion-{{ID}}  .tk-text-block' => 'background-color: {{VALUE}}',
					),
				)
			);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'tex_block_gradient_color',
				'label'    => __( 'Text Block Gradient Background', 'plugin-domain' ),
				'types'    => array( 'gradient' ),
				'selector' => '#tk-imageaccordion-{{ID}}  .tk-text-block',
			)
		);

		$this->add_responsive_control(
			'text_block_width',
			array(
				'label'      => __( 'Text Block Width', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'separator'  => 'before',
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '400',
				),
				'selectors'  => array(
					'{{WRAPPER}} #tk-imageaccordion-{{ID}} .tk-flexbox-slide .tk-text-block' => '
                    max-width: {{SIZE}}{{UNIT}};
                    width: {{SIZE}}{{UNIT}};',
				),
			),
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'text_block_border',
				'label'    => __( 'Text Block Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} #tk-imageaccordion-{{ID}} .tk-flexbox-slide .tk-text-block',
			)
		);

		$this->add_responsive_control(
			'text_block_border_radius',
			array(
				'label'      => esc_html__( 'Text Block Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #tk-imageaccordion-{{ID}} .tk-flexbox-slide .tk-text-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_block_padding',
			array(
				'label'      => __( 'Text Block Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #tk-imageaccordion-{{ID}} .tk-flexbox-slide .tk-text-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

			$this->end_controls_section();

			/**
			 * Typography Style
			 */

			$this->start_controls_section(
				'tk-flexbox_typography',
				array(
					'label' => esc_html__( 'Typography', 'taman-kit' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

		$this->add_control(
			'tk-flexbox_title__color',
			array(
				'label'     => __( 'Title', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-imageaccordion-{{ID}} .tk-flexbox-slide .tk-text-block h3' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'tk-flexbox_description__color',
			array(
				'label'     => __( 'Description', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-imageaccordion-{{ID}} .tk-flexbox-slide .text p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tk-flexbox_title_typography',
				'label'    => esc_html__( 'Title Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '#tk-imageaccordion-{{ID}} .tk-flexbox-slide .tk-text-block h3',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tk-flexbox_des_typography',
				'label'    => esc_html__( 'Description Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '#tk-imageaccordion-{{ID}} .tk-flexbox-slide .text p',
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
	 * Render imageaccordion widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$imageaccordion = $settings['imageaccordion'];
		$style          = $settings['Style__imageaccordion'];

		$this->add_render_attribute(
			'imageaccordion',
			array(
				'class' => array(
					'tk-imageaccordion-' . esc_attr( $this->get_id() ),
					'tk-imageaccordion',
					'tk-flexbox-slider',
					'tk-flexbox-slider-' . $style,

				),
				'id'    => 'tk-imageaccordion-' . esc_attr( $this->get_id() ),
			),
		);

		?>
<div class="tk-imageaccordion-container">
	<!--effect #1 -->
	<div class="tk-imageaccordion-contain">
		<div
			<?php echo $this->get_render_attribute_string( 'imageaccordion' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			foreach ( $imageaccordion as $item ) {

				echo '<div class="tk-flexbox-slide uk-cover-container">';
				echo '<img src="' . esc_url( $item['_image']['url'] ) . '" alt="' . esc_attr( $item['_title'] ) . '" uk-cover>';
				echo '<div class="tk-text-block">';
				echo ' <h3>' . esc_html( $item['_title'] ) . '</h3> ';
				echo '<div class="text">
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren</p>
                </div>
                </div>
            </div>';

			}

			?>
		</div>
	</div>

</div>
		<?php
	}

}
