<?php
/**
 * Elementor imagegrid Widget.
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
class ImageGrid extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve imagegrid widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tk-imagegrid';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve imagegrid widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Image Grid', 'taman-kit' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve imagegrid widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'taman-kit-editor-icon eicon-gallery-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the imagegrid widget belongs to.
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
	 * Register imagegrid widget controls.
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
			'imagegrid_image',
			array(
				'label' => __( 'Choose Image', 'taman-kit' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$repeater->add_control(
			'imagegrid_title',
			array(
				'label'   => __( 'Title', 'taman-kit' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'imagegrid_description',
			array(
				'label'   => __( 'Description', 'taman-kit' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'imagegrid',
			array(
				'label'       => __( 'ImageGrid Items', 'taman-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'imagegrid_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'imagegrid_title'       => '',
						'imagegrid_description' => '',
					),

					array(
						'imagegrid_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'imagegrid_title'       => '',
						'imagegrid_description' => '',
					),

					array(
						'imagegrid_image'       => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'imagegrid_title'       => '',
						'imagegrid_description' => '',
					),

				),
				'title_field' => '{{{ imagegrid_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'settings_grid',
			array(
				'label' => __( 'Settings', 'taman-kit' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'grid_columns',
			array(
				'label'   => __( 'Grid Columns', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '3',
				'options' => array(
					'1' => __( '1', 'taman-kit' ),
					'2' => __( '2', 'taman-kit' ),
					'3' => __( '3', 'taman-kit' ),
					'4' => __( '4', 'taman-kit' ),
					'5' => __( '5', 'taman-kit' ),
					'6' => __( '6', 'taman-kit' ),
				),
			)
		);

		$this->add_control(
			'grid_columns_mobile',
			array(
				'label'   => __( 'Grid Columns On Mobile', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '2',
				'options' => array(
					'1' => __( '1', 'taman-kit' ),
					'2' => __( '2', 'taman-kit' ),
					'3' => __( '3', 'taman-kit' ),
					'4' => __( '4', 'taman-kit' ),
					'5' => __( '5', 'taman-kit' ),
					'6' => __( '6', 'taman-kit' ),
				),
			)
		);

		$this->add_control(
			'grid-match',
			array(
				'label'        => __( 'Match height', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'off',
			)
		);

		$this->add_control(
			'grid_masonry',
			array(
				'label'        => __( 'Masonry', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'off',
			)
		);

		$this->add_control(
			'grid_lightbox',
			array(
				'label'        => __( 'Lightbox', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'off',
			)
		);

		$this->add_control(
			'grid_lightbox_icon',
			array(
				'label'     => __( 'Icon', 'taman-kit' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-plus',
					'library' => 'solid',
				),
				'condition' => array(
					'grid_lightbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'grid_lightbox_animation',
			array(
				'label'     => __( 'Lightbox Animation', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'scale',
				'options'   => taman_kit_slide_animation(),
				'condition' => array(
					'grid_lightbox' => 'yes',
				),
			)
		);

		$this->add_control(
			'grid_load_animation',
			array(
				'label'        => __( 'Load In Animation', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'off',
			)
		);

		$this->add_control(
			'grid_load_animation_repeat',
			array(
				'label'        => __( 'Repeat', 'taman-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'taman-kit' ),
				'label_off'    => __( 'No', 'taman-kit' ),
				'return_value' => 'yes',
				'default'      => 'off',
				'condition'    => array(
					'grid_load_animation' => 'yes',
				),
			)
		);

		$this->add_control(
			'grid_load__animations',
			array(
				'label'     => __( 'Animation', 'taman-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'uk-animation-fade',
				'options'   => taman_kit_animations(),
				'condition' => array(
					'grid_load_animation' => 'yes',
				),
			)
		);

		$this->add_control(
			'grid_load__animationsdelay',
			array(
				'label'     => __( 'Price', 'plugin-domain' ),
				'type'      => Controls_Manager::NUMBER,
				'step'      => 1,
				'default'   => 500,
				'condition' => array(
					'grid_load_animation' => 'yes',
				),
			)
		);

		$this->add_control(
			'grid_overlay_transitions',
			array(
				'label'   => __( 'Overlay Transitions', 'taman-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'uk-transition-slide-top',
				'options' => taman_kit_transitions(),
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
			'grid_style_section',
			array(
				'label' => esc_html__( 'Style', 'taman-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'grid_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'#tk-imagegrid-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'grid_border',
				'label'       => __( 'Border', 'taman-kit' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '#tk-imagegrid-{{ID}}',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'grid_box_shadow',
				'selector'  => '#tk-imagegrid-{{ID}}',
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
					'#tk-imagegrid-{{ID}}' => 'background: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

			/**
			 * Grid Item Style
			 */

		$this->start_controls_section(
			'grid_item_style',
			array(
				'label' => esc_html__( 'Grid Item', 'taman-kit' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'grid_item_padding',
			array(
				'label'      => __( 'Padding', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} #tk-imagegrid-{{ID}} .tk-grid-img-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'grid_item_margin',
			array(
				'label'      => __( 'Margin', 'taman-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} *+.uk-grid-margin,{{WRAPPER}} .uk-grid-row-small>.uk-grid-margin' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

			/**
			 * OverLay Style
			 */

			$this->start_controls_section(
				'grid_overlay_style',
				array(
					'label' => esc_html__( 'OverLay', 'taman-kit' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			array(
				'name'     => 'overlay_bg_color',
				'label'    => __( 'Background', 'plugin-domain' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '#tk-imagegrid-{{ID}} .uk-overlay-default',
			)
		);

			$this->end_controls_section();

			/**
			 * Icon Style
			 */

			$this->start_controls_section(
				'grid_icon_style',
				array(
					'label' => esc_html__( 'Icon', 'taman-kit' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

		$this->add_control(
			'icon_bg_color',
			array(
				'label'     => __( 'Background', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-imagegrid-{{ID}} .grid-lightbox-icon' => 'Background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon__color',
			array(
				'label'     => __( 'Icon Color', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-imagegrid-{{ID}} .grid-lightbox-icon i' => 'color: {{VALUE}}',
				),
			)
		);

			$this->end_controls_section();

			/**
			 * Typography Style
			 */

			$this->start_controls_section(
				'grid_typography',
				array(
					'label' => esc_html__( 'Typography', 'taman-kit' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);

		$this->add_control(
			'title__color',
			array(
				'label'     => __( 'Title', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-imagegrid-{{ID}} .item-title h3' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'description__color',
			array(
				'label'     => __( 'Description', 'taman-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'#tk-imagegrid-{{ID}} .item-description p' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'grid_title_typography',
				'label'    => esc_html__( 'Title Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '#tk-imagegrid-{{ID}} .item-title h3',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'grid_des_typography',
				'label'    => esc_html__( 'Description Typography', 'taman-kit' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '#tk-imagegrid-{{ID}} .item-description p',
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
	 * Render imagegrid widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$imagegrid             = $settings['imagegrid'];
		$columns               = $settings['grid_columns'];
		$columns_mobile        = $settings['grid_columns_mobile'];
		$grid_match            = $settings['grid-match'];
		$masonry               = $settings['grid_masonry'];
		$lightbox_animation    = $settings['grid_lightbox_animation'];
		$lightbox              = $settings['grid_lightbox'];
		$grid_load_animation   = $settings['grid_load_animation'];
		$load_animation_repeat = $settings['grid_load_animation_repeat'];
		$load__animations      = $settings['grid_load__animations'];
		$delay                 = $settings['grid_load__animationsdelay'];
		$repeat                = ( 'yes' === $load_animation_repeat ) ? 'true' : 'false';
		$_match                = ( 'yes' === $grid_match ) ? 'uk-grid-match' : '';
		$_masonry              = ( 'yes' === $masonry ) ? 'true' : 'false';
		$is_masonry            = 'not-masonry';
		$not_masonry           = null;

		if ( 'yes' === $masonry ) {
			$is_masonry = 'is-masonry';
		}

		$this->add_render_attribute(
			'imagegrid',
			array(
				'class'   => array(
					'tk-imagegrid-' . esc_attr( $this->get_id() ),
					'uk-child-width-1-' . $columns_mobile,
					'uk-child-width-1-' . $columns . '@m',
					'uk-position-relative',
					' uk-grid-column-small',
					'uk-grid-row-small',
					'uk-grid',
					$_match,
					$is_masonry,

				),
				'id'      => 'tk-imagegrid-' . esc_attr( $this->get_id() ),
				'uk-grid' => 'masonry: ' . $_masonry,

			),
		);

		if ( 'yes' === $lightbox ) {
			$this->add_render_attribute(
				'imagegrid',
				'uk-lightbox',
				'animation:' . $lightbox_animation
			);
		}
		if ( 'yes' === $grid_load_animation ) {
			$this->add_render_attribute(
				'imagegrid',
				'uk-scrollspy',
				'target: .tk-grid-img-item; cls: ' . $load__animations . ';repeat: ' . $repeat . '; delay:' . $delay
			);

		}
		?>
<div
		<?php echo $this->get_render_attribute_string( 'imagegrid' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php
		if ( $settings['imagegrid'] ) {
			foreach ( $settings['imagegrid'] as $item ) {

				echo '<div class ="uk-text-center tk-grid-img-item uk-cover-container uk-visible-toggle uk-transition-toggle elementor-repeater-item-' . esc_attr( $item['_id'] ) . '" >';

				echo '<img class="grid-image-item" src="' . esc_url( $item['imagegrid_image']['url'] ) . '" alt="' . esc_attr( $item['imagegrid_title'] ) . '" ' . esc_attr( $not_masonry ) . '></a>';

				echo '<div class="uk-overlay-default uk-position-cover uk-transition-slide-top ' . esc_attr( $settings['grid_overlay_transitions'] ) . '">';

				echo '<div class="uk-position-center uk-text-center">';
				echo '<div class="item-title">';
				echo '<h3>' . esc_html( $item['imagegrid_title'] ) . '</h3>';
				echo ' </div> 
					<div class="item-description">';
				echo '<p>' . esc_html( $item['imagegrid_description'] ) . '</p> </div>';

				if ( 'yes' === $lightbox ) {
					echo '<div class="grid-lightbox-icon">
					<a class="uk-inline" href="' . esc_url( $item['imagegrid_image']['url'] ) . '" data-caption="' . esc_attr( $item['imagegrid_title'] ) . '">';

					\Elementor\Icons_Manager::render_icon( $settings['grid_lightbox_icon'], array( 'aria-hidden' => 'true' ) );
					echo '</a></div>';
				}
				echo ' </div> </div></div>';

			}
		}

		?>
</div>
		<?php

	}

}
