<?php
/**
 * Class scrolldown Widget.
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
 * Scrolldown class
 */
class ScrollDown extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve scrolldown widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-scrolldown';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve scrolldown widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Scroll Down', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve scrolldown widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-scroll';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the scrolldown widget belongs to.
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
	 * Register scrolldown widget controls.
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
			'section_title',
			array(
				'label' => __( 'Title', 'elementor' ),
			)
		);

		$this->add_control(
			'_style',
			array(
				'label'   => __( 'Size', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => array(
					'1' => __( 'Style 1', 'elementor' ),
					'2' => __( 'Style 2', 'elementor' ),
					'3' => __( 'Style 3', 'elementor' ),
					'4' => __( 'Style 4', 'elementor' ),
					'5' => __( 'Style 5', 'elementor' ),
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'     => __( 'Link', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '#',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'scroll_title',
			array(
				'label'       => __( 'Scroll Text', 'taman-kit' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Scroll', 'taman-kit' ),
				'default'     => __( 'Scroll', 'taman-kit' ),
				'condition'   => array(
					'_style'  => '3',
					'_style'  => '4',
					'_style!' => '5',
				),
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
			'section__style',
			array(
				'label' => __( 'Style', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'_align',
			array(
				'label'     => __( 'Align', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => array(
					'left'   => __( 'Left', 'elementor' ),
					'center' => __( 'Center', 'elementor' ),
					'right'  => __( 'Right', 'elementor' ),
				),
				'condition' => array(
					'_style!' => '3',
					'_style!' => '5',
				),
			)
		);

		$this->add_control(
			'_color',
			array(
				'label'     => __( 'Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => array(
					'.tk-scroll-{{ID}} .tk-mousey,.tk-scroll-{{ID}} .tk-scroller,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2 a,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles3.tkscroll a,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles3.tkscroll a:hover,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles4.tkscroll a,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles4.tkscroll a:hover,
					.tk-scroll-{{ID}} .tk-scroll-5,
					.tk-scroll-{{ID}} .tk-scroll-5 a,
					.tk-scroll-{{ID}} .tk-scroll-5 a:hover' => 'color: {{VALUE}}',

					'.tk-scroll-{{ID}} .tk-mousey,.tk-scroll-{{ID}} .tk-scroller,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2 a span::after,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2 a span,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles3 a span,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles4 a span' => 'border-color: {{VALUE}}',

					'.tk-scroll-{{ID}} .tk-scroller' => 'background-color: {{VALUE}}',

				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => '3_style_typography',
				'label'     => esc_html__( 'Content Typography', 'taman-kit' ),
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '.tk-scroll-{{ID}} .tk-section_scroll-styles3.tkscroll a,
                .tk-scroll-{{ID}} .tk-section_scroll-styles4.tkscroll a,
				.tk-scroll-{{ID}} .tk-scroll-5 p .label',
				'condition' => array(
					'_style' => '3',
					'_style' => '4',
					'_style' => '5',
				),
			)
		);

		$this->add_responsive_control(
			'_opacity',
			array(
				'label'      => __( 'Opacity', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => '',
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => .5,
					),
				),

				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-mousey,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2,
					.tk-scroll-{{ID}} .tk-scroll-5 p .label' => 'opacity: .{{SIZE}};',
				),
				'condition'  => array(
					'_style' => '1',
					'_style' => '5',
				),
			)
		);

		$this->add_responsive_control(
			'_height',
			array(
				'label'      => __( 'Height', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 55,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-mousey,.elementor-widget-tk-scrolldown .elementor-widget-container' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
				),

			)
		);

		$this->add_responsive_control(
			'_width',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 3,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-mousey' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
				),

			)
		);

		$this->add_responsive_control(
			'border_width',
			array(
				'label'      => __( 'Border Width', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-mousey' => 'border-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
				),
			)
		);

		$this->add_responsive_control(
			'border_redius',
			array(
				'label'      => __( 'Border Radius', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 25,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-mousey' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
				),
			)
		);

		/**
		 * Style2
		 */

		$this->add_responsive_control(
			'style2_opacity',
			array(
				'label'      => __( 'Opacity', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => '',
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),

				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-section_scroll-styles2' => 'opacity: .{{SIZE}};',
				),
				'condition'  => array(
					'_style' => '2',
				),
			)
		);

		$this->add_responsive_control(
			'border_width_style2',
			array(
				'label'      => __( 'Border Width', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-section_scroll-styles2 a span' => 'border-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '2',
				),
			)
		);

		$this->add_responsive_control(
			'_height_2_style',
			array(
				'label'      => __( 'Height', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 55,
				),
				'selectors'  => array(
					'.elementor-widget-tk-scrolldown .elementor-widget-container,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2 a span,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2 a span::before' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '2',
				),

			)
		);

		$this->add_responsive_control(
			'_width_2_style',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 55,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-section_scroll-styles2 a span,
                    .tk-scroll-{{ID}} .tk-section_scroll-styles2 a span::before' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '2',
				),

			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section__scollrer',
			array(
				'label'     => __( 'Scollrer', 'taman-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'_style' => '1',
				),
			)
		);

		$this->add_responsive_control(
			'scollrer_height',
			array(
				'label'      => __( 'Height', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-scroller' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
				),
			)
		);

		$this->add_responsive_control(
			'scollrer_width',
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
				'default'    => array(
					'unit' => 'px',
					'size' => 3,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-scroller' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
				),
			)
		);

		$this->add_responsive_control(
			'_scollrer',
			array(
				'label'      => __( 'Scroller Space from Top', 'plugin-domain' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'.tk-scroll-{{ID}} .tk-scroller' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'_style' => '1',
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
	 * Render style1.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_style1() {
		$settings = $this->get_settings_for_display();

		$_style = $settings['_style'];
		$link   = $settings['link'];
		$_align = $settings['_align'];

		$this->add_render_attribute(
			'mousey',
			array(
				'class' => array(
					'tk-scroll-' . $this->get_id(),
					'uk-position-relative',
					'tk-scroll-style-' . $_style,
					'tk-scroll-' . $_align,
				),
				'id'    => 'tk-scroll-' . $this->get_id(),
			),
		);

		if ( '1' === $_style ) {
			echo '<div ' . $this->get_render_attribute_string( 'mousey' ) . ' >'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
			echo '<div class="tk-scroll-downs">';
			echo '<a href="' . esc_url( $link ) . '">';

			echo '<div class="tk-mousey">';
			echo '<div class="tk-scroller"></div>';
			echo '</div>';

			echo '</a>';

			echo '</div></div>';

		}

	}


	/**
	 * Render style2.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_style2() {
		$settings = $this->get_settings_for_display();

		$_style = $settings['_style'];
		$link   = $settings['link'];
		$_align = $settings['_align'];

		$this->add_render_attribute(
			'mousey',
			array(
				'class' => array(
					'tk-scroll-' . $this->get_id(),
					'uk-position-relative',
					'tk-scroll-style-' . $_style,
					'tk-scroll-' . $_align,
				),
				'id'    => 'tk-scroll-' . $this->get_id(),
			),
		);

		if ( '2' === $_style ) {
			echo '<div ' . $this->get_render_attribute_string( 'mousey' ) . ' >'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 

			echo '<section class="tk-section_scroll-styles2">
            <a href="' . esc_url( $link ) . '">
            <span></span></a>
        </section>';

			echo '</div>';

		}

	}


	/**
	 * Render style3.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_style3() {
		$settings = $this->get_settings_for_display();

		$_style = $settings['_style'];
		$link   = $settings['link'];
		$_align = $settings['_align'];
		$title  = $settings['scroll_title'];

		$this->add_render_attribute(
			'mousey',
			array(
				'class' => array(
					'tk-scroll-' . $this->get_id(),
					'uk-position-relative',
					'tk-scroll-style-' . $_style,
					'tk-scroll-' . $_align,
				),
				'id'    => 'tk-scroll-' . $this->get_id(),
			),
		);

		if ( '3' === $_style ) {
			echo '<div ' . $this->get_render_attribute_string( 'mousey' ) . ' >'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 

			echo '<section class="tk-section_scroll-styles3 tkscroll">
            <a href="' . esc_url( $link ) . '"><span></span>' . esc_html( $title ) . '</a>
            </section>';

			echo '</div>';

		}

	}


	/**
	 * Render style4.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_style4() {
		$settings = $this->get_settings_for_display();

		$_style = $settings['_style'];
		$link   = $settings['link'];
		$_align = $settings['_align'];
		$title  = $settings['scroll_title'];

		$this->add_render_attribute(
			'mousey',
			array(
				'class' => array(
					'tk-scroll-' . $this->get_id(),
					'uk-position-relative',
					'tk-scroll-style-' . $_style,
					'tk-scroll-' . $_align,
				),
				'id'    => 'tk-scroll-' . $this->get_id(),
			),
		);

		if ( '4' === $_style ) {
			echo '<div ' . $this->get_render_attribute_string( 'mousey' ) . ' >'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 

			echo '<section class="tk-section_scroll-styles4 tkscroll">
            <a href="' . esc_url( $link ) . '"><span></span><span></span><span></span>' . esc_html( $title ) . '</a>
            </section>';

			echo '</div>';

		}

	}



	/**
	 * Render style5.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render_style5() {
		$settings = $this->get_settings_for_display();

		$_style = $settings['_style'];
		$link   = $settings['link'];
		$_align = $settings['_align'];
		$title  = $settings['scroll_title'];

		$this->add_render_attribute(
			'mousey',
			array(
				'class' => array(
					'tk-scroll-' . $this->get_id(),
					'uk-position-relative',
					'tk-scroll-style-' . $_style,
					'tk-scroll-' . $_align,
				),
				'id'    => 'tk-scroll-' . $this->get_id(),
			),
		);

		if ( '5' === $_style ) {
			echo '<div ' . $this->get_render_attribute_string( 'mousey' ) . ' >'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 

			echo '<div class="tk-scroll-5">
			<p> <a href="' . esc_url( $link ) . '">
			<span class="label">' . esc_html__( '&#x2190; Scroll to see more ', 'taman-kit' ) . '</span></a></p>
				</div>';

			echo '</div>';

		}

	}


	/**
	 * Render scrolldown widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$_style = $settings['_style'];

		$_function = 'render_style' . $_style;

		$this->$_function();

	}


}
