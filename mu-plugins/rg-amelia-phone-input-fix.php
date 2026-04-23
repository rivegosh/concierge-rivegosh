<?php
/**
 * Plugin Name: RG Amelia Phone Input Fix
 * Description: Fix defects on the phone field inside the Amelia booking wizard:
 *              (1) typed text was black/invisible on dark theme
 *              (2) placeholder "Enter phone" hugged the left edge
 *              Amelia v3 uses its own vue-based m-phone-number-input component —
 *              NOT the intl-tel-input iti__tel-input library (that was v2).
 *              Scoped to .amelia-v2-booking .m-phone-number-input__input only.
 * Version: 1.1.0
 * Created: 2026-04-23
 * Revision: 1.1.0 — corrected selector from .iti__tel-input to .m-phone-number-input__input
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-phone-input-fix">
	/* Amelia v3 phone input — actual <input> is nested inside .m-phone-number-input__input */
	body .amelia-v2-booking .m-phone-number-input__input input,
	body .amelia-v2-booking .m-phone-number-input__input .m-input-wrapper input,
	body .amelia-v2-booking .m-phone-number-input input[type="tel"],
	body .amelia-v2-booking .am-input-phone input {
		color: rgba(255, 255, 255, 0.92) !important;
		padding-left: 14px !important;
	}
	body .amelia-v2-booking .m-phone-number-input__input input::placeholder,
	body .amelia-v2-booking .m-phone-number-input__input input::-webkit-input-placeholder,
	body .amelia-v2-booking .m-phone-number-input__input input::-moz-placeholder,
	body .amelia-v2-booking .m-phone-number-input__input input:-ms-input-placeholder,
	body .amelia-v2-booking .am-input-phone input::placeholder {
		color: rgba(255, 255, 255, 0.55) !important;
		opacity: 1 !important;
	}
	</style>
	<?php
}, 100000 );
