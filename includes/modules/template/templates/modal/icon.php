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
if ( ! isset( $settings['button_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
	// add old default.
	$settings['button_icon'] = '';
}

		$has_icon = ! empty( $settings['button_icon'] );

if ( $has_icon ) {
	$this->add_render_attribute( 'i', 'class', $settings['button_icon'] );
	$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
}

if ( ! $has_icon && ! empty( $settings['select_button_icon']['value'] ) ) {
	$has_icon = true;
}
		$migrated = isset( $settings['__fa4_migrated']['select_button_icon'] );
		$is_new   = ! isset( $settings['button_icon'] ) && Icons_Manager::is_migration_allowed();

if ( $has_icon ) {
	?>
			<span class="tk-button-icon tk-icon">
		<?php
		if ( $is_new || $migrated ) {
			Icons_Manager::render_icon( $settings['select_button_icon'], array( 'aria-hidden' => 'true' ) );
		} elseif ( ! empty( $settings['button_icon'] ) ) {
			?>
				<i <?php echo $this->get_render_attribute_string( 'i' );   // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></i>
			<?php
		}
		?>
			</span>
	<?php
}
