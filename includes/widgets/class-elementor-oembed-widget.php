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
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

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
		return esc_html__( 'Textrotator', 'taman-kit' );
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
		return 'taman-kit-editor-icon fa fa-divide';
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
			'jquery-simple-text-rotator',
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
			'url',
			array(
				'label'       => esc_html__( 'URL to embed', 'taman-kit' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'url',
				'placeholder' => esc_html__( 'https://your-link.com', 'taman-kit' ),
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

	}

	/*
	*==================================================================================
	*
	*=============================== Style Tab: Style =================================
	*
	*==================================================================================
	*/







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

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'textrotator',
			array(
				'class' => array(
					'tk-textrotator-' . $this->get_id(),
					'textrotator-elementor-widget',
				),
				'id'    => 'tk-textrotator-' . $this->get_id(),
			),
		);

		echo '<div  ' . $this->get_render_attribute_string( 'textrotator' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 

		echo '</div>';

	}

}
