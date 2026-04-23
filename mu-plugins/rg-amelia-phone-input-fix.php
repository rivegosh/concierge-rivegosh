<?php
/**
 * Plugin Name: RG Amelia Phone Input Fix
 * Description: Fix two defects on the phone field inside the Amelia booking wizard:
 *              (1) placeholder "Enter phone" is dark (invisible on dark theme)
 *              (2) typed text + placeholder hug the left edge of the input
 *              Both only affect .iti__tel-input (intl-tel-input field).
 *              Zero bleed — scoped to .amelia-v2-booking .iti__tel-input only.
 * Version: 1.0.0
 * Created: 2026-04-23
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-phone-input-fix">
	/* Scope: phone input (intl-tel-input) inside Amelia booking wizard only. */
	body .amelia-v2-booking .iti__tel-input,
	body .amelia-v2-booking input.iti__tel-input[type="tel"] {
		padding-left: 14px !important;
		color: rgba(255, 255, 255, 0.92) !important;
	}
	body .amelia-v2-booking .iti__tel-input::placeholder,
	body .amelia-v2-booking .iti__tel-input::-webkit-input-placeholder,
	body .amelia-v2-booking .iti__tel-input::-moz-placeholder,
	body .amelia-v2-booking .iti__tel-input:-ms-input-placeholder {
		color: rgba(255, 255, 255, 0.55) !important;
		opacity: 1 !important;
	}
	</style>
	<?php
}, 100000 );
