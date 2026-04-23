<?php
/**
 * Plugin Name: RG Amelia Phone Input Fix
 * Description: Phone field inside Amelia booking wizard — typed text must be white.
 *              Amelia uses MazUI vue component: <input id="MazInput" class="am-input-phone
 *              m-phone-number-input__input maz-flex-1 m-input-input ...">
 *              Earlier versions targeted ".m-phone-number-input__input input" assuming that
 *              class was a wrapper — it's actually the input itself. v1.5.0 targets the
 *              correct element class chain.
 * Version: 1.5.0
 * Created: 2026-04-23
 * Revision:
 *   1.0.0 — wrong library (.iti__tel-input from v2)
 *   1.1.0 — right v3 class but as wrapper (it's the input)
 *   1.2.0 — var-only override (ineffective)
 *   1.3.0 — direct color on wrong selector chain
 *   1.4.0 — aggressive selectors + autofill, STILL wrong element path
 *   1.5.0 — targets real rendered element via #MazInput + .m-phone-number-input__input
 *           + .am-input-phone as SELF, not nested input
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-phone-input-fix">
	/* Amelia's phone input is MazUI <input id="MazInput"> with multiple classes.
	   Target the element directly — these classes are ON the input, not on wrappers. */
	html body .amelia-v2-booking input.m-phone-number-input__input,
	html body .amelia-v2-booking input.am-input-phone,
	html body .amelia-v2-booking input#MazInput,
	html body .amelia-v2-booking input.m-input-input[type="tel"],
	html body:has(.amelia-v2-booking) input#MazInput {
		color: #ffffff !important;
		-webkit-text-fill-color: #ffffff !important;
		caret-color: #ffffff !important;
		padding-left: 14px !important;
	}
	/* Placeholder on the same element */
	html body .amelia-v2-booking input.m-phone-number-input__input::placeholder,
	html body .amelia-v2-booking input.am-input-phone::placeholder,
	html body .amelia-v2-booking input#MazInput::placeholder,
	html body .amelia-v2-booking input.m-phone-number-input__input::-webkit-input-placeholder {
		color: rgba(255, 255, 255, 0.55) !important;
		-webkit-text-fill-color: rgba(255, 255, 255, 0.55) !important;
		opacity: 1 !important;
	}
	/* Autofill override — Chrome's autofill can mask text color */
	html body .amelia-v2-booking input.m-phone-number-input__input:-webkit-autofill,
	html body .amelia-v2-booking input#MazInput:-webkit-autofill,
	html body .amelia-v2-booking input.m-phone-number-input__input:-webkit-autofill:focus,
	html body .amelia-v2-booking input.m-phone-number-input__input:-webkit-autofill:hover {
		-webkit-text-fill-color: #ffffff !important;
		caret-color: #ffffff !important;
		transition: background-color 9999s ease-in-out 0s;
	}
	</style>
	<?php
}, 100000 );
