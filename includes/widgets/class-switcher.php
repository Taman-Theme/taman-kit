<?php
/**
 * Elementor switcher Widget.
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
 * Switcher class
 */
class Switcher extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve switcher widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'switcher';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve switcher widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Switcher', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve switcher widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-tabs';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the switcher widget belongs to.
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
	 * Register switcher widget controls.
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

		$repeater->start_controls_tabs( 'content_switcher' );

		$repeater->add_control(
			'title_switcher',
			array(
				'label'   => __( 'Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Switcher Item', 'taman-kit' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'tab_icon',
			array(
				'label'   => __( 'Icon', 'taman-kit' ),
				'type'    => \Elementor\Controls_Manager::ICONS,
				'default' => 'far fa-star',
			)
		);

		$repeater->add_control(
			'content__switcher',
			array(
				'label'   => __( 'content', 'taman-kit' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'taman-kit' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'switchers',
			array(
				'label'       => __( 'Switcher Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title_switcher'    => esc_html__( 'Switcher Item', 'taman-kit' ),
						'content__switcher' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'taman-kit' ),
						'tab_icon'          => 'far fa-star',
					),

				),
				'title_field' => '{{{ title_switcher }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section__settings',
			array(
				'label' => esc_html__( 'Settings', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'tab_type',
			array(
				'label'   => __( 'Type', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'uk-tab'       => __( 'Top', 'taman-kit' ),
					'uk-tab-left'  => __( 'Left', 'taman-kit' ),
					'uk-tab-right' => __( 'Right', 'taman-kit' ),

				),
				'default' => 'uk-tab',
			)
		);

		$this->add_control(
			'tab_top_pos',
			array(
				'label'     => __( ' Items Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'tab-top-left'          => __( 'Left', 'taman-kit' ),
					'uk-flex-center'        => __( 'Center', 'taman-kit' ),
					'uk-flex-right'         => __( 'Right', 'taman-kit' ),
					'uk-child-width-expand' => __( 'Justify', 'taman-kit' ),
				),
				'default'   => 'tab-top-left',
				'condition' => array(
					'tab_type' => 'uk-tab',
				),
			)
		);

		$this->add_control(
			'tab_animations',
			array(
				'label'   => __( 'Animations', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => taman_kit_animations(),
				'default' => 'uk-animation-fade',
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
			'tab__style',
			array(
				'label' => esc_html__( 'Style', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'tab_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'#tk-switcher-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tab_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#tk-switcher-{{ID}}',
			)
		);

		$this->add_control(
			'tab_border__radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'#tk-switcher-{{ID}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'tab_box_shadow',
				'selector'  => '#tk-switcher-{{ID}}',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'switcher_bg_color',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-switcher-{{ID}}' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_content_typography',
				'label'    => esc_html__( 'Content Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '#tk-switcher-{{ID}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tab_bar_style',
			array(
				'label' => esc_html__( 'Tab', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'tab_bar_padding',
			array(
				'label'      => __( 'Tab Padding ', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.tk-tab-{{ID}} .tk-switcher-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'tab_bar_item_padding',
			array(
				'label'      => __( 'Item Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'.tk-tab-{{ID}} .tk-switcher-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'switcher_tab__bg_color',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}}' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tab_box__border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-tab-{{ID}}',
			)
		);

		$this->add_control(
			'tab_borderitem_radius',
			array(
				'label'      => __( 'Border Radius', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'#tk-switcher-{{ID}} .tk-switcher-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_title_typography',
				'label'    => esc_html__( 'Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '.tk-tab-{{ID}} .tk-switcher-item a',
			)
		);

		/**------------------------------------------------- */

		$this->start_controls_tabs( 'tabs_tab_style' );

		$this->start_controls_tab(
			'tab_swicher_normal',
			array(
				'label' => esc_html__( 'Normal', 'taman-kit' ),
			)
		);

		$this->add_control(
			'switcher_tab_bg_color',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}} .tk-switcher-item a' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tab_box_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-tab-{{ID}} .tk-switcher-item a',
			)
		);

		$this->add_control(
			'switcher_tab__color',
			array(
				'label'     => __( 'Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}} .tk-switcher-item a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_active_hover',
			array(
				'label' => esc_html__( 'Active', 'taman-kit' ),
			)
		);

		$this->add_control(
			'switcher_tab_bg_active_color',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}} .tk-switcher-item.uk-active a' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tab_active_box_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tk-tab-{{ID}} .tk-switcher-item.uk-active a',
			)
		);

		$this->add_control(
			'switcher_tab__active_color',
			array(
				'label'     => __( 'Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}} .tk-switcher-item.uk-active a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		/**-------------------------------------------- */
		$this->end_controls_section();

		$this->start_controls_section(
			'tab_icon_style',
			array(
				'label' => esc_html__( 'icon', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'tab_padding_icon',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'#tk-switcher-{{ID}} .tk-switcher-item i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon-size',
			array(
				'label'      => __( 'Width', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),

				'selectors'  => array(
					'.tk-tab-{{ID}} .tk-switcher-item i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'switcher_icon__color',
			array(
				'label'     => __( 'Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}} .tk-switcher-item i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'switcher_icon_active_color',
			array(
				'label'     => __( 'Active Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.tk-tab-{{ID}} .tk-switcher-item.uk-active  i' => 'color: {{VALUE}}',
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
	 * Render switcher widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings    = $this->get_settings_for_display();
		$switchers   = $settings['switchers'];
		$_type       = $settings['tab_type'];
		$_animations = $settings['tab_animations'];
		$_pos        = $settings['tab_top_pos'];

		$this->add_render_attribute(
			'tab',
			array(
				'class'  => array(
					'tk-tab-' . esc_attr( $this->get_id() ),
					'tk-tab-box',
					'uk-tab',
					$_type,
					$_pos,
				),
				'id'     => 'tk-tab-' . esc_attr( $this->get_id() ),
				'uk-tab' => 'connect: #tk-component-' . $this->get_id() . '; animation: ' . $_animations,
			),
		);

		?>
<div class="tk-switcher" id="tk-switcher-<?php echo esc_attr( $this->get_id() ); ?>">
	<div class="tk-switchers-inner">

		<?php
		if ( 'uk-tab-left' === $_type ) {

			?>
		<div class="uk-grid" uk-grid>
			<div class="uk-width-auto@m">
			<?php

		} elseif ( 'uk-tab-right' === $_type ) {
			?>
				<div class="uk-grid" uk-grid>
					<div class="uk-width-auto@m uk-flex-last@m">
			<?php } ?>
		<ul
			<?php echo $this->get_render_attribute_string( 'tab' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			if ( $switchers ) {

				foreach ( $switchers as $item ) {
					echo '<li class="tk-switcher-item elementor-repeater-item-' . esc_attr( $item['_id'] ) . '"><a href="#">';

					\Elementor\Icons_Manager::render_icon( $item['tab_icon'], array( 'aria-hidden' => 'true' ) );

					echo esc_html( $item['title_switcher'] );

					echo '</a></li>';

				}
			}
			?>
		</ul>


				<?php if ( 'uk-tab-left' === $_type || 'uk-tab-right' === $_type ) { ?>

				</div>
				<div class="uk-width-expand@m">

				<?php } ?>

				<ul class="uk-switcher uk-margin switcher-<?php echo esc_attr( $_type ); ?>"
					id="tk-component-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php
					if ( $switchers ) {

						foreach ( $switchers as $item ) {
							echo '<li class="tk-switcher-tab-' . esc_attr( $item['_id'] ) . ' elementor-repeater-item-' . esc_attr( $item['_id'] ) . '">';

							echo wp_kses_post( $item['content__switcher'] );

							echo '</li>';

						}
					}
					?>
				</ul>

				<?php
				if ( 'uk-tab-left' === $_type || 'uk-tab-right' === $_type ) {
					?>
						</div>
						</div>
				<?php } ?>

		</div>
	</div>
		<?php

	}

}
