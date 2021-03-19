<?php
/**
 * Render popup box button icon output on the frontend.
 *
 * @since 1.0.0
 * @package Taman Kit.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Icons_Manager;

$settings = $this->get_settings_for_display();

		// Trigger Button Icon.
if ( ! isset( $settings['trigger_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
	// Add old default.
	$settings['trigger_icon'] = '';
}

		$has_icon = ! empty( $settings['trigger_icon'] );

if ( $has_icon ) {
	$this->add_render_attribute( 'trigger-i', 'class', $settings['trigger_icon'] );
	$this->add_render_attribute( 'trigger-i', 'aria-hidden', 'true' );
}

if ( ! $has_icon && ! empty( $settings['select_trigger_icon']['value'] ) ) {
	$has_icon = true;
}
		$migrated = isset( $settings['__fa4_migrated']['select_trigger_icon'] );
		$is_new   = ! isset( $settings['trigger_icon'] ) && Icons_Manager::is_migration_allowed();

if ( $has_icon ) {
	?>
			<span class="tk-trigger-icon tk-icon tk-modal-popup-link tk-modal-popup-link-<?php echo esc_attr( $this->get_id() ); ?>" <?php echo 'uk-toggle = "#tk-modal-popup-window-' . esc_attr( $this->get_id() ) . '"'; ?> >
		<?php
		if ( $is_new || $migrated ) {
			Icons_Manager::render_icon( $settings['select_trigger_icon'], array( 'aria-hidden' => 'true' ) );
		} elseif ( ! empty( $settings['trigger_icon'] ) ) {
			?>
					<i <?php echo $this->get_render_attribute_string( 'trigger-i' );   // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></i>
			<?php
		}
		?>
			</span>
	<?php
}
