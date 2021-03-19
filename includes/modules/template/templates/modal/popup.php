<?php
/**
 * Render popup box.
 *
 * @since 1.0.0
 * @package Taman Kit.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use TamanKit\Modules\Templates;

$settings = $this->get_settings_for_display();
$popid    = $this->get_id();
$this->add_render_attribute( 'modal-popup', 'class', 'tk-modal-popup-' . $popid );

$is_editor = \Elementor\Plugin::instance()->editor->is_edit_mode();

$showclose      = $settings['close_button'];
$close_position = $settings['close_button_position'];
$layout_type    = $settings['layout_type'];
$animation_in   = $settings['popup_animation_in'];
$is_fullscreen  = ( 'fullscreen' === $settings['layout_type'] ) ? 'uk-modal-full' : '';

$this->add_render_attribute(
	'close-button',
	array(
		'class'    => array(
			'tk-modal-popup-close-button',
			$close_position,

		),
		'uk-close' => '',
	)
);

if ( 'template' === $settings['popup_type'] || 'image' === $settings['popup_type'] || 'content' === $settings['popup_type'] || 'custom-html' === $settings['popup_type'] ) {

	$this->add_render_attribute( 'modal-popup', 'data-type', 'inline' );

} elseif ( 'link' === $settings['popup_type'] ) {

	$this->add_render_attribute( 'modal-popup', 'data-type', 'iframe' );

} else {

	$this->add_render_attribute( 'modal-popup', 'data-type', $settings['popup_type'] );
}

if ( 'link' === $settings['popup_type'] ) {

	$this->add_render_attribute( 'modal-popup', 'data-src', $settings['popup_link']['url'] );
	$this->add_render_attribute( 'modal-popup', 'data-iframe-class', 'tk-modal-popup-window tk-modal-popup-window-' . esc_attr( $this->get_id() ) );

} else {

	$this->add_render_attribute( 'modal-popup', 'data-src', '#tk-modal-popup-window-' . esc_attr( $this->get_id() ) );
}

		// Trigger.
if ( 'other' !== $settings['trigger'] ) {

	$this->add_render_attribute( 'modal-popup', 'data-trigger-element', '.tk-modal-popup-link-' . esc_attr( $this->get_id() ) );
}

if ( 'on-click' === $settings['trigger'] && 'button' === $settings['trigger_type'] ) {

	$pp_button_html_tag = 'span';

	$this->add_render_attribute(
		'button',
		array(
			'class'     => array(
				'tk-modal-popup-button',
				'tk-modal-popup-link',
				'tk-modal-popup-link-' . esc_attr( $this->get_id() ),
				'elementor-button',
				'elementor-size-' . $settings['button_size'],
			),
			'uk-toggle' => '#tk-modal-popup-window-' . esc_attr( $this->get_id() ),

		),
	);

	if ( $settings['button_animation'] ) {
		$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_animation'] );
	}
} elseif ( 'page-load' === $settings['trigger'] ) {

	$pp_delay = 1000;

	if ( '' !== $settings['delay'] ) {

		$pp_delay = $settings['delay'] * 1000;

	}

	$this->add_render_attribute( 'modal-popup', 'data-delay', $pp_delay );

	if ( '' !== $settings['display_after_page_load'] ) {

		$this->add_render_attribute( 'modal-popup', 'data-display-after', $settings['display_after_page_load'] );
	}
} elseif ( 'exit-intent' === $settings['trigger'] ) {

	if ( '' !== $settings['display_after_exit_intent'] ) {
		$this->add_render_attribute( 'modal-popup', 'data-display-after', $settings['display_after_exit_intent'] );
	}
} elseif ( 'other' === $settings['trigger'] ) {

	if ( '' !== $settings['element_identifier'] ) {
		$this->add_render_attribute( 'modal-popup', 'data-trigger-element', $settings['element_identifier'] );
	}
}

$elementor_bp_tablet = get_option( 'elementor_viewport_lg' );
$elementor_bp_mobile = get_option( 'elementor_viewport_md' );
$bp_tablet           = ! empty( $elementor_bp_tablet ) ? $elementor_bp_tablet : 1025;
$bp_mobile           = ! empty( $elementor_bp_mobile ) ? $elementor_bp_mobile : 768;

if ( 'tablet' === $settings['popup_disable_on'] ) {

	$popup_disable_on = $bp_tablet;

} elseif ( 'mobile' === $settings['popup_disable_on'] ) {

	$popup_disable_on = $bp_mobile;

} else {

	$popup_disable_on = '';

}

if ( $popup_disable_on ) {
	$this->add_render_attribute( 'modal-popup', 'data-disable-on', $popup_disable_on );
}

// Popup Window.
$this->add_render_attribute(
	'modal-popup-window',
	array(
		'class'    => array( 'tk-model--window uk-modal', $is_fullscreen ),
		'id'       => 'tk-modal-popup-window-' . esc_attr( $this->get_id() ),
		'uk-modal' => '',
	)
);


// Popup Window dialog.
$this->add_render_attribute(
	'modal-dialog',
	array(
		'class' => array( $animation_in, 'uk-margin-auto-vertical tk-model--dialog-window  uk-modal-dialog tk-modal-popup-window tk-modal-popup-window-' . esc_attr( $this->get_id() ) ),
	)
);

?>
<div id="tk-modal-popup-wrap-<?php echo esc_attr( $this->get_id() ); ?>" class="tk-modal-popup-wrap">

	<div
		<?php echo $this->get_render_attribute_string( 'modal-popup' );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

		<?php

		if ( 'page-load' === $settings['trigger'] || 'page-load' === $settings['trigger'] || 'exit-intent' === $settings['trigger'] ) {

			echo '<button class="tkb-btn tkb-btn-success" id="tk-openmodal" uk-toggle = "#tk-modal-popup-window-' . esc_attr( $this->get_id() ) . '"hidden ></button>';

		}


		if ( 'on-click' === $settings['trigger'] ) {

			if ( 'button' === $settings['trigger_type'] ) {

				printf( '<%1$s %2$s>', $pp_button_html_tag, $this->get_render_attribute_string( 'button' ) );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				if ( 'before' === $settings['button_icon_position'] ) {

					include Templates::get_templatet( 'modal', 'icon' );

				}

				if ( ! empty( $settings['button_text'] ) ) {

					printf( '<span %1$s>', $this->get_render_attribute_string( 'button_text' ) );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo esc_attr( $settings['button_text'] );
					printf( '</span>' );

				}

				if ( 'after' === $settings['button_icon_position'] ) {

					include Templates::get_templatet( 'modal', 'icon' );
				}
					printf( '</%1$s>', $pp_button_html_tag );

			} elseif ( 'icon' === $settings['trigger_type'] ) {

				include Templates::get_templatet( 'modal', 'trigger-icon' );

			} elseif ( 'image' === $settings['trigger_type'] ) {

				$trigger_image = $this->get_settings_for_display( 'trigger_image' );

				if ( ! empty( $trigger_image['url'] ) ) {

					printf( '<img class="tk-trigger-image tk-modal-popup-link %1$s" src="%2$s" %3$s>', 'tk-modal-popup-link-' . esc_attr( $this->get_id() ), esc_url( $trigger_image['url'] ), 'uk-toggle = "#tk-modal-popup-window-' . esc_attr( $this->get_id() ) . '"' );
				}
			}
		} else {

			if ( $is_editor ) {
				?>
				<div class="tk-editor-message uk-placeholder uk-background-muted" style="text-align: center;">
					<h5>
						<?php printf( 'Modal Popup ID - %1$s', esc_attr( $this->get_id() ) ); ?>
					</h5>
					<p>
						<?php esc_html_e( 'To edit the "Popup Box" settings Click here.', 'taman-kit' ); ?>
					</p>
					<button class="tkb-btn elementor-button elementor-size-sm" id="tk-openmodal" uk-toggle = "#tk-modal-popup-window-<?php echo esc_attr( $this->get_id() ); ?>" ><?php echo esc_html__( 'Open Popup', 'taman-kit' ); ?></button>
					<p>
						<?php esc_html_e( 'This text will not be visible on frontend.', 'taman-kit' ); ?>
					</p>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>

<div
	<?php echo $this->get_render_attribute_string( 'modal-popup-window' );   // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div <?php echo $this->get_render_attribute_string( 'modal-dialog' );   // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >

		<?php if ( 'yes' === $showclose ) : ?>
			<a <?php echo $this->get_render_attribute_string( 'close-button' );   // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> ></a>
		<?php endif; ?>

		<?php if ( 'yes' === $settings['popup_title'] && '' !== $settings['title'] ) { ?>

		<div class="uk-modal-header tk-popup-title tk-popup-header">
			<h2 class="uk-modal-title">
				<?php echo esc_html( $settings['title'] ); ?>
			</h2>
		</div>

			<?php
		}
			echo '<div class="uk-modal-body tk-popup-content" id="tk-popup-content">';

		if ( 'image' === $settings['popup_type'] ) {


				$image = $this->get_settings_for_display( 'image' );
				echo '<img src="' . esc_url( $image['url'] ) . '">';

		} elseif ( 'link' === $settings['popup_type'] ) {

			$videotype  = $settings['popup_link_video'];
			$popup_link = $settings['popup_link'];

			if ( 'video' === $videotype ) {

				echo '<video src="' . esc_url( $popup_link ) . '" controls playsinline uk-video></video>';

			} elseif ( 'youtube' === $videotype ) {

				echo '<iframe src="' . esc_url( $popup_link ) . '" width="1920" height="1080" frameborder="0" uk-video uk-responsive></iframe>';


			} elseif ( 'vimeo' === $videotype ) {

				echo '<iframe src="' . esc_url( $popup_link ) . '" width="1280" height="720" frameborder="0" uk-video uk-responsive></iframe>';

			} else {
				echo '';
			}
		} elseif ( 'content' === $settings['popup_type'] ) {

			global $wp_embed;

			$content = wpautop( $wp_embed->autoembed( $settings['content'] ) ); // Get content HTML.
			echo do_shortcode( $content ); // Process code for shortcode and then output it.

		} elseif ( 'template' === $settings['popup_type'] ) {

			if ( ! empty( $settings['templates'] ) ) {

				$pp_template_id = $settings['templates'];

				echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $pp_template_id );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} elseif ( 'custom-html' === $settings['popup_type'] ) {

			echo $settings['custom_html'];  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		} else {

			echo '';
		}

				echo '</div>';
		?>
	</div>
</div>
