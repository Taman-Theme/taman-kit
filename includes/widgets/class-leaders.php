<?php
/**
 * Elementor Leaders Widget.
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
 * Leaders class
 */
class Leaders extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Leaders widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-leaders';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Leaders widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Leaders', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Leaders widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-price-list';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Leaders widget belongs to.
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
	 * Register Leaders widget controls.
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

		$repeater->start_controls_tabs( 'content_leaders' );

		$repeater->add_control(
			'title_leaders',
			array(
				'label'   => __( 'Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Leader Item',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'price_leaders',
			array(
				'label'   => __( 'Price', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '20.90',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'price_mark_leaders',
			array(
				'label'   => __( 'Price Mark', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->end_controls_tab();

		$this->add_control(
			'leaders',
			array(
				'label'       => __( 'Leaders Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title_leaders'      => 'Leader Item',
						'price_leaders'      => '20.90',
						'price_mark_leaders' => '$',

					),

				),
				'title_field' => '{{{ title_leaders }}}',
			)
		);

		$this->end_controls_section();

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
			'leader__style',
			array(
				'label' => esc_html__( 'Style', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'fill_leaders',
			array(
				'label'   => __( 'Fill character', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '-',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'leaders_bg',
				'label'    => __( 'Background', 'taman-kit' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '#tk-leader-{{ID}}',
			)
		);

		$this->add_responsive_control(
			'leaders_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'#tk-leader-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'leaders_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#tk-leader-{{ID}}',
			)
		);

		$this->add_control(
			'leaders_border_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'#tk-leader-{{ID}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'leaders_box_shadow',
				'selector'  => '#tk-leader-{{ID}}',
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'leader__typography',
			array(
				'label' => esc_html__( 'Typography', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'leader_title_item_color',
			array(
				'label'     => __( 'Title Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-leader-{{ID}} .tk-leader-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'leader_item_typography',
				'label'    => __( 'Title Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '#tk-leader-{{ID}} .tk-leader-title',
			)
		);

		$this->add_control(
			'price__item_color',
			array(
				'label'     => __( 'Price Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-leader-{{ID}} .tk-leader-price' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_item_typography',
				'label'    => __( 'Price Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '#tk-leader-{{ID}} .tk-leader-price',
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
	 * Render Leaders widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$leaders = $settings['leaders'];
		?>
		<div class="tk-leader" id="tk-leader-<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="tk-leaders-inner">
				<?php
				if ( $leaders ) {

					foreach ( $leaders as $item ) {
						echo '<div class="uk-grid-small uk-grid tk-leader-item-' . esc_attr( $item['_id'] ) . ' elementor-repeater-item-' . esc_attr( $item['_id'] ) . '" uk-grid>';

						echo ' <div class="uk-width-expand tk-leader-title uk-leader" uk-leader="fill: ' . esc_attr( $settings['fill_leaders'] ) . '">' . esc_html( $item['title_leaders'] ) . '</div>';

						echo '<div class="tk-leader-price">' . esc_html( $item['price_mark_leaders'] ) . esc_html( $item['price_leaders'] ) . '</div>';

						echo '</div>';

					}
				}
				?>
			</div>
		</div>
		<?php
	}

}
