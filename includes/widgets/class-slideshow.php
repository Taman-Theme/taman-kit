<?php
/**
 * Elementor slideshow Widget.
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
 * Slideshow class
 */
class Slideshow extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve slideshow widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-slideshow';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve slideshow widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Slideshow', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve slideshow widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-post-slider';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the slideshow widget belongs to.
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
	 * Register slideshow widget controls.
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

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'content_slideshow' );

		$repeater->start_controls_tab(
			'slideshow_general',
			array(
				'label' => esc_html__( 'Content', 'taman-kit' ),
			)
		);

		$repeater->add_control(
			'slideshow_image',
			array(
				'label' => __( 'Choose Image', 'taman-kit' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$repeater->add_control(
			'slideshow_title',
			array(
				'label'   => __( 'Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'slideshow_description',
			array(
				'label'   => __( 'Description', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'slideshow_setting',
			array(
				'label' => esc_html__( 'Setting', 'taman-kit' ),
			)
		);

		$repeater->add_control(
			'Ken_Burns',
			array(
				'label'        => __( 'Ken Burns Effect', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'taman-kit' ),
				'label_off'    => __( 'Disable', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'off',
			)
		);

		$repeater->add_control(
			'ken_burns_reverse',
			array(
				'label'        => __( 'Ken Burns Reverse', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'taman-kit' ),
				'label_off'    => __( 'Disable', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'Ken_Burns' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'slideshow_transform',
			array(
				'label'     => __( 'Transform Origin', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => taman_kit_transform_origin(),
				'default'   => 'uk-transform-origin-center-left',
				'condition' => array(
					'Ken_Burns' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'show_overlay',
			array(
				'label'        => __( 'Show Overlay', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'taman-kit' ),
				'label_off'    => __( 'Hide', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$repeater->add_control(
			'slideshow_position',
			array(
				'label'     => __( 'Overlay Position', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => taman_kit_position(),
				'condition' => array(
					'show_overlay' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'slideshow_transitions',
			array(
				'label'     => __( 'Overlay Transitions', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => taman_kit_transitions(),
				'condition' => array(
					'show_overlay' => 'yes',
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'slidshow_style_tab',
			array(
				'label' => esc_html__( 'Style', 'taman-kit' ),
			)
		);

		$repeater->add_responsive_control(
			'width-overlay',
			array(
				'label'      => __( 'Overlay Width', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tk-slidshow-overlay.uk-overlay' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$repeater->add_responsive_control(
			'height-overlay',
			array(
				'label'      => __( 'Overlay Height', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tk-slidshow-overlay.uk-overlay' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$repeater->add_control(
			'overlay-background',
			array(
				'label'     => __( 'Overlay Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tk-slidshow-overlay.uk-overlay' => 'background: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'title-color',
			array(
				'label'     => __( 'Title Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} h3.tk-slidshow-title' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_control(
			'p-color',
			array(
				'label'     => __( 'Description Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{CURRENT_ITEM}} .tk-slidshow-p' => 'color: {{VALUE}}',
				),
			)
		);

		$repeater->add_responsive_control(
			'title_align',
			array(
				'label'     => esc_html__( 'Title Align', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => ' center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'taman-kit' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'taman-kit' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'taman-kit' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} h3.tk-slidshow-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$repeater->add_responsive_control(
			'des_align',
			array(
				'label'     => esc_html__( 'Description Align', 'taman-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => ' center',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'taman-kit' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'taman-kit' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'taman-kit' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tk-slidshow-p' => 'text-align: {{VALUE}};',
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'title_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'separator' => 'after',
				'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} h3.tk-slidshow-title',
			)
		);
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'p_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'separator' => 'after',
				'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}} .tk-slidshow-p',
			)
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'slideshow',
			array(
				'label'       => __( 'Slideshow Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'slideshow_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'slideshow_title'       => '',
						'slideshow_description' => '',
						'slideshow_position'    => 'uk-position-bottom',
						'slideshow_transitions' => 'uk-transition-slide-bottom',
					),

				),
				'title_field' => '{{{ slideshow_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_setting',
			array(
				'label' => 'Settings',
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => __( 'Autoplay', 'taman-kit' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'taman-kit' ),
				'label_off'    => __( 'Disable', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'autoplay_interval',
			array(
				'label'     => __( 'Autoplay Interval', 'taman-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '5000',
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'infinite_scrolling',
			array(
				'label'        => __( 'Infinite scrolling', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Enable', 'taman-kit' ),
				'label_off'    => __( 'Disable', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'slideshow_animation',
			array(
				'label'   => __( 'Animation', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => taman_kit_slide_animation(),
				'default' => 'fade',
			)
		);

		$this->add_control(
			'slideshow_navigate',
			array(
				'label'   => __( 'Navigation', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'slidenav'  => 'Slidenav',
					'dotnav'    => 'Dotnav',
					'dotandnav' => 'Dotnav & Slidenav',
					'thumbnav'  => 'Thumbnav',
				),
				'default' => 'dotandnav',
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

		$this->add_responsive_control(
			'width-slidshow',
			array(
				'label'      => __( 'Width', 'taman-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} #tk-slideshow-{{ID}}' => 'width: {{SIZE}}{{UNIT}};',
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
	 * Render slideshow widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$autoplay = ( 'yes' === $settings['autoplay'] ) ? 'true' : 'false';
		$infinite = ( 'yes' === $settings['infinite_scrolling'] ) ? 'false' : 'true';

		$interval   = $settings['autoplay_interval'];
		$animation  = $settings['slideshow_animation'];
		$navigate   = $settings['slideshow_navigate'];
		$item_index = -1;

		$this->add_render_attribute(
			'slidshow',
			array(
				'class'        => array(
					'tk-slideshow-' . esc_attr( $this->get_id() ),
					'tk-slidshow',
					'uk-position-relative',
					'uk-visible-toggle',

				),
				'id'           => 'tk-slideshow-' . esc_attr( $this->get_id() ),
				'uk-slideshow' => 'animation: ' . $animation . ';autoplay:' . $autoplay . ';autoplay-interval:' . $interval . ';finite:' . $infinite . ';',
				'tabindex'     => '-1',
			),
		);

		?>
<div <?php echo $this->get_render_attribute_string( 'slidshow' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<ul class="uk-slideshow-items">

		<?php
		if ( $settings['slideshow'] ) {
			foreach ( $settings['slideshow'] as $item ) {

				echo '<li class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . ' tk-slidshow-item-' . esc_attr( $item['_id'] ) . '">';

				if ( 'yes' === $item['ken_burns_reverse'] ) {

					$reverse = ( 'yes' === $item['Ken_Burns'] ) ? 'uk-animation-reverse' : null;

					echo ' <div class="uk-position-cover uk-animation-kenburns ' . esc_attr( $reverse ) . ' ' . esc_attr( $item['slideshow_transform'] ) . '">
								<img src="' . esc_url( $item['slideshow_image']['url'] ) . '" alt="" uk-cover>
								</div>';

				} else {
					echo '<img src="' . esc_url( $item['slideshow_image']['url'] ) . '" alt="" uk-cover>';
				}

				if ( 'yes' === $item['show_overlay'] ) :

					echo '<div class="tk-slidshow-overlay uk-overlay uk-overlay-primary uk-text-center ' . esc_attr( $item['slideshow_position'] ) . ' ' . esc_attr( $item['slideshow_transitions'] ) . '">';

					echo ' <h3 class="tk-slidshow-title uk-margin-remove">' . esc_html( $item['slideshow_title'] ) . '</h3>
							<p class="tk-slidshow-p uk-margin-remove">' . esc_html( $item['slideshow_description'] ) . '</p>';

					echo '</div>';

							endif;

				echo '</li>';

			}
		}

		?>

	</ul>

		<?php if ( 'slidenav' === $navigate || 'dotandnav' === $navigate ) : ?>
			<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
				uk-slideshow-item="previous"></a>
			<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
				uk-slideshow-item="next"></a>
		<?php endif; ?>

		<?php if ( 'dotnav' === $navigate || 'dotandnav' === $navigate ) : ?>
				<ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>
		<?php endif; ?>

		<?php if ( 'thumbnav' === $navigate ) : ?>

		<div class="uk-position-bottom-center uk-position-small">
			<ul class="uk-thumbnav">

			<?php
			if ( $settings['slideshow'] ) {
				foreach ( $settings['slideshow'] as $item ) {

					$item_index ++;

					?>

				<li uk-slideshow-item="<?php echo esc_attr( $item_index ); ?>"><a href="#">
					<?php echo '<img src="' . esc_url( $item['slideshow_image']['url'] ) . '" width="100" alt=""></a>'; ?>
				</li>

					<?php
				}
			}
			?>
			</ul>
		</div>
		<?php endif; ?>


</div>


		<?php

	}

				/**
				 * Undocumented function
				 */
	protected function _content_template() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		?>

	<# 
			var navigate = settings.slideshow_navigate;
			if( settings.autoplay == 'yes' ){
				autoplay = 'true';
			}else{
				autoplay = 'false';
			};

			if( settings.infinite_scrolling == 'yes' ){
				infinite = 'false';
			}else{
				infinite = 'true';
			};

			view.addRenderAttribute(
				'slidshow_key',
					{
						'id': 'tk-slideshow-' + settings._id,
						'uk-slideshow': 'animation: ' + settings.slideshow_animation + ';autoplay:' +  autoplay + ';autoplay-interval:'  +  settings.autoplay_interval + ';finite:' + infinite +';',
						'tabindex': '-1',
						'class': [
							'uk-position-relative ',
							'uk-visible-toggle',
							'tk-slideshow-'+ settings._id,
							'tk-slidshow',
						],
					}
				); 

				#>

		<# if ( settings.slideshow.length ) { #>

			<div {{{ view.getRenderAttributeString( 'slidshow_key' ) }}} >

				<ul class="uk-slideshow-items">

					<# _.each( settings.slideshow, function( item ) { #>

						<li class="elementor-repeater-item-{{ item._id }} tk-slidshow-item-{{ item._id }}">

						<# if ( 'yes' == item.Ken_Burns ) { 

						var reverse = ( 'yes' == item.ken_burns_reverse) ? 'uk-animation-reverse' : null; #>

							<div class='uk-position-cover  uk-animation-kenburns {{{reverse}}} {{{ item.slideshow_transform }}}'>
								<img src="{{{ item.slideshow_image.url }}}" alt="" uk-cover>';
							</div>


						<# }else{ #>
							<img src="{{{ item.slideshow_image.url }}}" alt="" uk-cover>';
							<# }; #>

							<# if ( 'yes' == item.show_overlay ) { #>

								<div
									class="tk-slidshow-overlay uk-overlay uk-overlay-primary uk-text-center {{{ item.slideshow_transitions }}} {{{ item.slideshow_position }}} ">

									<h3 class="tk-slidshow-title uk-margin-remove">{{{ item.slideshow_title }}}</h3>
									<p class="tk-slidshow-p uk-margin-remove">{{{ item.slideshow_description }}}</p>

								</div>

							<# }; #>

						</li>
					<# }); #>

				</ul>

				<# if ( 'slidenav'== navigate || 'dotandnav' == navigate){ #>

						<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
							uk-slideshow-item="previous"></a>
						<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
							uk-slideshow-item="next"></a>
				<# } #>

				<# if ( 'dotnav'== navigate || 'dotandnav' == navigate){ #>

					<ul class="uk-slideshow-nav uk-dotnav uk-flex-center uk-margin"></ul>

				<# } #>

				<# if ( 'thumbnav'== navigate ){ 
					var item_index = -1; #>
					<div class="uk-position-bottom-center uk-position-small">
						<ul class="uk-thumbnav">

							<# _.each( settings.slideshow, function( item ) { 
								item_index ++; #>
								<li uk-slideshow-item="{{{ item_index }}}"><a href="#">
									<?php echo '<img src="{{{ item.slideshow_image.url }}}" width="100" alt=""></a>'; ?>
								</li>
							<# }); #>

						</ul>
					</div>
				<# } #>

			</div>

	<# } #>
		<?php
	}
}
