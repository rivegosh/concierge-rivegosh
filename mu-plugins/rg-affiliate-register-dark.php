<?php
/**
 * Plugin Name: RG Affiliate Register Dark
 * Description: Gold-standard dark-luxury reskin for the Affiliate
 *              Registration form at /affiliate-register/ (page-id-5572).
 *              Matches /vendor-membership/ visual language. Fixes:
 *              - "Registration" title was 60px Cormorant (overwhelming) →
 *                right-sized 28px, kept Cormorant Garamond serif
 *              - Form had no card wrapper → dark luxury card with champagne
 *                hairline border
 *              - Inputs: WHITE bg + BLACK text (per Daniel's spec)
 *              - Labels: champagne on dark
 *              - CONFIRM button: champagne chip with dark text
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-22
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 5572 ) ) return;
	?>
	<style id="rg-affiliate-register-dark">

	/* ==================================================================
	 * 1. "Registration" title — reduce 60px → 28px, keep serif
	 * ================================================================== */
	html body.page-id-5572 h1,
	html body.page-id-5572 h2,
	html body.page-id-5572 h3,
	html body.page-id-5572 #wcfm_affiliate_registration_form h1,
	html body.page-id-5572 #wcfm_affiliate_registration_form h2,
	html body.page-id-5572 .wcfm_affiliate_registration_form h2 {
		font-family: "Cormorant Garamond", serif !important;
		font-size: 28px !important;
		font-weight: 500 !important;
		letter-spacing: 0.04em !important;
		color: #CCC593 !important;
		text-align: center !important;
		margin: 0 0 24px 0 !important;
		line-height: 1.2 !important;
	}

	/* ==================================================================
	 * 2. Form card — dark luxury wrapper
	 * ================================================================== */
	html body.page-id-5572 #wcfm_affiliate_registration_form,
	html body.page-id-5572 form.wcfm,
	html body.page-id-5572 .wcfm-affiliate-register-wrapper {
		background: rgba(20, 16, 10, 0.75) !important;
		background-color: rgba(20, 16, 10, 0.75) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		border-radius: 4px !important;
		padding: 32px !important;
		max-width: 720px !important;
		margin: 40px auto !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* ==================================================================
	 * 3. Labels — champagne on dark
	 * ================================================================== */
	html body.page-id-5572 label,
	html body.page-id-5572 .wcfm_title,
	html body.page-id-5572 .wcfm-message {
		color: rgba(204, 197, 147, 0.90) !important;
		font-weight: 500 !important;
	}

	/* ==================================================================
	 * 4. Input fields — WHITE bg + BLACK text (gold standard)
	 * ================================================================== */
	html body.page-id-5572 input.wcfm-text,
	html body.page-id-5572 input.wcfm_ele,
	html body.page-id-5572 input[type="text"],
	html body.page-id-5572 input[type="email"],
	html body.page-id-5572 input[type="tel"],
	html body.page-id-5572 input[type="number"],
	html body.page-id-5572 input[type="password"],
	html body.page-id-5572 select,
	html body.page-id-5572 textarea {
		background: #ffffff !important;
		color: #0a0a0a !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		border-radius: 3px !important;
		padding: 10px 12px !important;
		font-size: 14px !important;
	}
	html body.page-id-5572 input:focus,
	html body.page-id-5572 select:focus,
	html body.page-id-5572 textarea:focus {
		border-color: #CCC593 !important;
		outline: none !important;
		box-shadow: 0 0 0 2px rgba(204, 197, 147, 0.25) !important;
	}
	html body.page-id-5572 input::placeholder {
		color: rgba(10, 10, 10, 0.45) !important;
	}

	/* ==================================================================
	 * 5. Checkboxes — champagne accent
	 * ================================================================== */
	html body.page-id-5572 input[type="checkbox"],
	html body.page-id-5572 input[type="radio"] {
		accent-color: #CCC593 !important;
		width: 16px !important;
		height: 16px !important;
	}

	/* ==================================================================
	 * 6. Links (Terms & Conditions)
	 * ================================================================== */
	html body.page-id-5572 a {
		color: #CCC593 !important;
	}
	html body.page-id-5572 a:hover {
		color: #E5D599 !important;
	}

	/* ==================================================================
	 * 7. CONFIRM button — champagne chip (gold standard)
	 * ================================================================== */
	html body.page-id-5572 button,
	html body.page-id-5572 input[type="submit"],
	html body.page-id-5572 .wcfm_submit_button,
	html body.page-id-5572 a.wcfm_submit_button {
		background: rgba(204, 197, 147, 0.92) !important;
		background-color: rgba(204, 197, 147, 0.92) !important;
		color: #0a0a0a !important;
		border: 0 !important;
		border-radius: 3px !important;
		padding: 11px 22px !important;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif !important;
		font-weight: 600 !important;
		font-size: 13px !important;
		text-transform: uppercase !important;
		letter-spacing: 0.1em !important;
		cursor: pointer !important;
		text-shadow: none !important;
	}
	html body.page-id-5572 button:hover,
	html body.page-id-5572 input[type="submit"]:hover {
		background: #CCC593 !important;
	}

	</style>
	<?php
}, 100014 );
