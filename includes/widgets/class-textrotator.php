<?php
/**
 * Elementor textrotator Widget.
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
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;


/**
 * Textrotator class
 */
class TextRotator extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve textrotator widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-textrotator';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve textrotator widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Text Rotator', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve textrotator widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-t-letter';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the textrotator widget belongs to.
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
	 * Retrieve the list of scripts.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array(
			'tk-morphext',
		);
	}

	/**
	 * Register textrotator widget controls.
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
			'_start_text',
			array(
				'label'       => esc_html__( 'Beginning Text', 'taman-kit' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Super', 'taman-kit' ),
				'placeholder' => esc_html__( 'Beginning Text', 'taman-kit' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'_end_text',
			array(
				'label'       => esc_html__( 'Ending Text', 'taman-kit' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Text Rotator with Style', 'taman-kit' ),
				'placeholder' => esc_html__( 'End Text', 'taman-kit' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_responsive_control(
			'_align',
			array(
				'label'     => __( 'Alignment', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __( 'Left', 'taman-kit' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __( 'Center', 'taman-kit' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __( 'Right', 'taman-kit' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => __( 'Justified', 'taman-kit' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'a_effect',
			array(
				'label'              => __( 'Effect', 'taman-kit' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'bounceIn',
				'options'            => array(
					'bounceIn'          => __( 'bounceIn', 'taman-kit' ),
					'bounce'            => __( 'bounce', 'taman-kit' ),
					'flash'             => __( 'flash', 'taman-kit' ),
					'pulse'             => __( 'pulse', 'taman-kit' ),
					'rubberBand'        => __( 'rubberBand', 'taman-kit' ),
					'shake'             => __( 'shake', 'taman-kit' ),
					'swing'             => __( 'swing', 'taman-kit' ),
					'tada'              => __( 'tada', 'taman-kit' ),
					'wobble'            => __( 'wobble', 'taman-kit' ),
					'jello'             => __( 'jello', 'taman-kit' ),
					'heartBeat'         => __( 'heartBeat', 'taman-kit' ),
					'bounceInDown'      => __( 'bounceInDown', 'taman-kit' ),
					'bounceInLeft'      => __( 'bounceInLeft', 'taman-kit' ),
					'bounceInRight'     => __( 'bounceInRight', 'taman-kit' ),
					'bounceInUp'        => __( 'bounceInUp', 'taman-kit' ),
					'fadeIn'            => __( 'fadeIn', 'taman-kit' ),
					'fadeInDown'        => __( 'fadeInDown', 'taman-kit' ),
					'fadeInDownBig'     => __( 'fadeInDownBig', 'taman-kit' ),
					'fadeInLeft'        => __( 'fadeInLeft', 'taman-kit' ),
					'fadeInLeftBig'     => __( 'fadeInLeftBig', 'taman-kit' ),
					'fadeInRight'       => __( 'fadeInRight', 'taman-kit' ),
					'fadeInRightBig'    => __( 'fadeInRightBig', 'taman-kit' ),
					'fadeInUp'          => __( 'fadeInUp', 'taman-kit' ),
					'fadeInUpBig'       => __( 'fadeInUpBig', 'taman-kit' ),
					'flip'              => __( 'flip', 'taman-kit' ),
					'flipInX'           => __( 'flipInX', 'taman-kit' ),
					'flipInY'           => __( 'flipInY', 'taman-kit' ),
					'lightSpeedIn'      => __( 'lightSpeedIn', 'taman-kit' ),
					'rotateIn'          => __( 'rotateIn', 'taman-kit' ),
					'rotateInDownLeft'  => __( 'rotateInDownLeft', 'taman-kit' ),
					'rotateInDownRight' => __( 'rotateInDownRight', 'taman-kit' ),
					'rotateInUpLeft'    => __( 'rotateInUpLeft', 'taman-kit' ),
					'rotateInUpRight'   => __( 'rotateInUpRight', 'taman-kit' ),
					'slideInUp'         => __( 'slideInUp', 'taman-kit' ),
					'slideInDown'       => __( 'slideInDown', 'taman-kit' ),
					'slideInLeft'       => __( 'slideInLeft', 'taman-kit' ),
					'slideInRight'      => __( 'slideInRight', 'taman-kit' ),
					'zoomIn'            => __( 'zoomIn', 'taman-kit' ),
					'zoomInDown'        => __( 'zoomInDown', 'taman-kit' ),
					'zoomInLeft'        => __( 'zoomInLeft', 'taman-kit' ),
					'zoomInRight'       => __( 'zoomInRight', 'taman-kit' ),
					'zoomInUp'          => __( 'zoomInUp', 'taman-kit' ),

				),
				'frontend_available' => true,

			)
		);

		$this->add_control(
			'display',
			array(
				'label'              => __( 'Display', 'taman-kit' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'uk-display-inline',
				'options'            => array(
					'uk-display-block'  => __( 'Block', 'taman-kit' ),
					'uk-display-inline' => __( 'Inline', 'taman-kit' ),
				),
				'frontend_available' => true,

			)
		);

		$this->add_control(
			'header_size',
			array(
				'label'   => __( 'HTML Tag', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'a_speed_text',
			array(
				'label'              => esc_html__( 'Speed', 'taman-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => '2000',
				'frontend_available' => true,
				'description'        => esc_html__( 'How many milliseconds until the next word show.', 'taman-kit' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'_rotator',
			array(
				'label'   => __( 'Rotator Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'rotator',
			array(
				'label'       => __( 'Rotator Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'_rotator' => esc_html__( 'Customizable', 'taman-kit' ),
					),
					array(
						'_rotator' => esc_html__( 'Simple', 'taman-kit' ),
					),
					array(
						'_rotator' => esc_html__( 'Easy', 'taman-kit' ),
					),
					array(
						'_rotator' => esc_html__( 'New', 'taman-kit' ),
					),

				),
				'title_field' => '{{{ _rotator }}}',
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
			'section_start_style',
			array(
				'label' => __( 'Start Text', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'start_color',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} #tk-textrotator-{{ID}} .tk-start' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'start_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} #tk-textrotator-{{ID}} .tk-start',
			)
		);

		$this->add_control(
			'start_is_stroke',
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
			'start_is_stroke_hover',
			array(
				'label'        => __( 'Texet Stroke Fill On Hover', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'off',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'condition'    => array(
					'start_is_stroke' => 'yes',
				),
			)
		);

		$this->add_control(
			'start_stroke-width',
			array(
				'label'      => __( 'Stroke Width', 'plugin-domain' ),
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
					'{{WRAPPER}} .tk-start.tamanh1-is-stroke' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'start_is_stroke' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Middle Text
		 */

		$this->start_controls_section(
			'section_middel_style',
			array(
				'label' => __( 'Middle Text', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'middel__color',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'#tk-textrotator-{{ID}} .tk-rotate-{{ID}}' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'middel_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => ' #tk-textrotator-{{ID}} .tk-rotate-{{ID}}',
			)
		);

		$this->add_control(
			'middel_is_stroke',
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
			'middel_is_stroke_hover',
			array(
				'label'        => __( 'Texet Stroke Fill On Hover', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'off',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'condition'    => array(
					'middel_is_stroke' => 'yes',
				),
			)
		);

		$this->add_control(
			'middel_stroke-width',
			array(
				'label'      => __( 'Stroke Width', 'plugin-domain' ),
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
					'{{WRAPPER}} .tk-rotate-{{ID}}.tamanh1-is-stroke' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'middel_is_stroke' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * End Text
		 */

		$this->start_controls_section(
			'section_end_style',
			array(
				'label' => __( 'End Text', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'end__color',
			array(
				'label'     => __( 'Text Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} #tk-textrotator-{{ID}} .tk-end' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'end_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} #tk-textrotator-{{ID}} .tk-end',
			)
		);

		$this->add_control(
			'end_is_stroke',
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
			'end_is_stroke_hover',
			array(
				'label'        => __( 'Texet Stroke Fill On Hover', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'off',
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'condition'    => array(
					'end_is_stroke' => 'yes',
				),
			)
		);

		$this->add_control(
			'end_stroke-width',
			array(
				'label'      => __( 'Stroke Width', 'plugin-domain' ),
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
					'{{WRAPPER}} .tk-end.tamanh1-is-stroke' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'end_is_stroke' => 'yes',
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
	 * Render textrotator widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings    = $this->get_settings_for_display();
		$rotator     = $settings['rotator'];
		$speed       = $settings['a_speed_text'];
		$effect      = $settings['a_effect'];
		$end_text    = $settings['_end_text'];
		$start_text  = $settings['_start_text'];
		$display     = $settings['display'];
		$header_size = $settings['header_size'];

		$start_is_stroke       = $settings['start_is_stroke'];
		$start_is_stroke_hover = $settings['start_is_stroke_hover'];
		$start_stroke          = ( 'yes' === $start_is_stroke ) ? ' tamanh1-is-stroke' : null;
		$start_stroke_hover    = ( 'yes' === $start_is_stroke_hover ) ? ' tamanh1-is-stroke-hover' : null;
		$_start_stroke         = $start_stroke . ' ' . $start_stroke_hover;

		$middel_is_stroke       = $settings['middel_is_stroke'];
		$middel_is_stroke_hover = $settings['middel_is_stroke_hover'];
		$middel_stroke          = ( 'yes' === $middel_is_stroke ) ? ' tamanh1-is-stroke' : null;
		$middel_stroke_hover    = ( 'yes' === $middel_is_stroke_hover ) ? ' tamanh1-is-stroke-hover' : null;
		$_middel_stroke         = $middel_stroke . ' ' . $middel_stroke_hover;

		$end_is_stroke       = $settings['end_is_stroke'];
		$end_is_stroke_hover = $settings['end_is_stroke_hover'];
		$end_stroke          = ( 'yes' === $end_is_stroke ) ? ' tamanh1-is-stroke' : null;
		$end_stroke_hover    = ( 'yes' === $end_is_stroke_hover ) ? ' tamanh1-is-stroke-hover' : null;
		$_end_stroke         = $end_stroke . ' ' . $end_stroke_hover;

		$this->add_render_attribute(
			'textrotator',
			array(
				'class'       => array(
					'tk-textrotator-' . $this->get_id(),
					'textrotator-elementor-widget',
					$display,
				),
				'id'          => 'tk-textrotator-' . $this->get_id(),
				'data-speed'  => $speed,
				'data-effect' => $effect,
			),
		);

		echo '<div  ' . $this->get_render_attribute_string( 'textrotator' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '  <' . esc_attr( $header_size ) . ' class="tk-text-header">
        <span class="tk-start ' . esc_attr( $display ) . ' ' . esc_attr( $_start_stroke ) . '" >' . esc_html( $start_text ) . '</span> 
        <span class="tk-rotate-' . esc_attr( $this->get_id() ) . '  ' . esc_attr( $display ) . ' ' . esc_attr( $_middel_stroke ) . '">';

		foreach ( $rotator as $item ) {

			echo esc_html( $item['_rotator'] ) . ',';
		}
		echo '</span>
        <span class="tk-end ' . esc_attr( $display ) . '">' . esc_html( $end_text ) . '</span></' . esc_attr( $header_size ) . '>';

		echo '</div>';

	}


	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function _content_template() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		?>
	<#
		var speed   = settings.speed,
		_rotator    = settings.rotator,
		speed       = settings.a_speed_text,
		effect      = settings.a_effect,
		end_text    = settings._end_text,
		start_text  = settings._start_text,
		textrotator = '',
		the_id      = view.getID(),
		header_size = settings.header_size,
		display     = settings.display,

		start_is_stroke     = settings.start_is_stroke,
		start_is_stroke_hover = settings.start_is_stroke_hover,
		start_stroke = ('yes' == start_is_stroke) ? ' tamanh1-is-stroke' : null,
		start_stroke_hover = ('yes' == start_is_stroke_hover) ? ' tamanh1-is-stroke-hover' : null,
		_start_stroke = start_stroke + ' ' + start_stroke_hover,


		middel_is_stroke     = settings.middel_is_stroke,
		middel_is_stroke_hover = settings.middel_is_stroke_hover,
		middel_stroke = ('yes' == middel_is_stroke) ? ' tamanh1-is-stroke' : null,
		middel_stroke_hover = ('yes' == middel_is_stroke_hover) ? ' tamanh1-is-stroke-hover' : null,
		_middel_stroke = middel_stroke + ' ' + middel_stroke_hover,

		end_is_stroke     = settings.end_is_stroke,
		end_is_stroke_hover = settings.end_is_stroke_hover,
		end_stroke = ('yes' == end_is_stroke) ? ' tamanh1-is-stroke' : null,
		end_stroke_hover = ('yes' == end_is_stroke_hover) ? ' tamanh1-is-stroke-hover' : null,
		_end_stroke = end_stroke + ' ' + end_stroke_hover;


		view.addRenderAttribute( textrotator, 'class', 'tk-textrotator-' + view.getID() );
		view.addRenderAttribute( textrotator, 'class', 'textrotator-elementor-widget' );
		view.addRenderAttribute( textrotator, 'id', 'tk-textrotator-' + view.getID() );
		view.addRenderAttribute( textrotator, 'data-speed', speed );
		view.addRenderAttribute( textrotator, 'data-effect', effect );
		view.addRenderAttribute( textrotator, 'class', display );

		#>

		<div {{{ view.getRenderAttributeString( textrotator) }}} >
		<{{{header_size}}} class="tk-text-header">
		<span class="tk-start {{{display}}} {{{_start_stroke}}}" >{{{ start_text }}}</span> 
		<span class="tk-rotate-{{{the_id}}} {{{display}}} {{{_middel_stroke}}}">
		<# _.each( settings.rotator, function( item ) { #>
		{{{ item._rotator }}},
			<# }); #>
		</span>
		<span class="tk-end {{{display}}} {{{_end_stroke}}}">{{{ end_text }}}</span></{{{header_size}}}>
		</div>


		<?php
	}

}
