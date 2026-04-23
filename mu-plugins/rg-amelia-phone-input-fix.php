<?php
/**
 * Plugin Name: RG Amelia Phone Input Fix
 * Description: Phone field inside Amelia booking wizard — fix typed text color + padding.
 *              Amelia v3's phone input leaves <input> color at browser default (black).
 *              On dark theme, typed text is invisible. Fix: force white color + padding.
 * Version: 1.3.0
 * Created: 2026-04-23
 * Revision:
 *   1.0.0 — wrong selector (.iti__tel-input — Amelia v2 library, not v3)
 *   1.1.0 — correct v3 selector, direct color rule applied
 *   1.2.0 — variable-only override (DID NOT WORK — Amelia ignores var on input color)
 *   1.3.0 — direct color rule (MUST beat browser user-agent default) + variable fallback
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-phone-input-fix">
	/* Variable override for any Amelia internal selector that reads --am-c-ph-inp-text */
	body .amelia-v2-booking {
		--am-c-ph-inp-text: #ffffff;
		--am-c-ph-inp-placeholder: rgba(255, 255, 255, 0.55);
	}
	/* Direct override on the actual <input> element — Amelia leaves color at
	   browser user-agent default (black) which is invisible on dark theme. */
	body .amelia-v2-booking .m-phone-number-input__input input,
	body .amelia-v2-booking .m-phone-number-input__input .m-input-wrapper input,
	body .amelia-v2-booking .m-phone-number-input input[type="tel"] {
		color: #ffffff !important;
		padding-left: 14px !important;
	}
	/* Placeholder hint also needs explicit styling — browser default is grey which
	   can still work on dark but we harmonize with the champagne-on-dark theme. */
	body .amelia-v2-booking .m-phone-number-input__input input::placeholder,
	body .amelia-v2-booking .m-phone-number-input__input input::-webkit-input-placeholder,
	body .amelia-v2-booking .m-phone-number-input input[type="tel"]::placeholder {
		color: rgba(255, 255, 255, 0.55) !important;
		opacity: 1 !important;
	}
	</style>
	<?php
}, 100000 );
