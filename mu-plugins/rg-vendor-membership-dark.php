<?php
/**
 * Plugin Name: RG Vendor Membership Dark
 * Description: Dark-luxury skin for the WCFM Vendor Membership wizard on
 *              /vendor-membership/ (page-id-3918). The stock WCFM form
 *              renders on a white card with champagne-gold text — produces
 *              34 WCAG contrast violations (per scanner), including
 *              "Plans"/"Profile" stepper labels rendering at 1.00 ratio
 *              (white-on-white, literally invisible). All form labels were
 *              champagne-on-white at 1.75 ratio (fails AA 4.5 by a mile).
 *              This plugin forces a dark card background + champagne text
 *              + dark input fields, matching the rest of the site.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-22
 *
 * WHY THIS FILE EXISTS:
 *   Daniel's DEFCON-0 complaint 2026-04-22: subscription form is unusable —
 *   "it's all white, we can't see shit, even when we type into the field".
 *   Scanner confirmed 34 violations. This plugin is the surgical fix.
 *
 *   Does NOT modify any sealed plugin. Scoped body.page-id-3918 — zero bleed.
 *
 * GitHub: rivegosh/concierge-rivegosh (see #103/#104 and follow-up issue)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 3918 ) ) return;
	?>
	<style id="rg-vendor-membership-dark">

	/* ==================================================================
	 * 1. MAIN FORM CARD — dark background, champagne hairline border
	 *    WCFM wraps the wizard in several possible containers depending
	 *    on step. Hit all of them defensively.
	 * ================================================================== */
	body.page-id-3918 .wcfm-membership-wrapper,
	body.page-id-3918 .wcfmvm-membership-form-wrapper,
	body.page-id-3918 .wcfmvm_membership_plans_wrapper,
	body.page-id-3918 .wcfmvm_membership_register_form,
	body.page-id-3918 #wcfmvm_membership_register_form_wrap,
	body.page-id-3918 .wcfmvm_membership_confirmation,
	body.page-id-3918 form.wcfm,
	body.page-id-3918 .wcfmmembership {
		background: rgba(20, 16, 10, 0.55) !important;
		background-color: rgba(20, 16, 10, 0.55) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		border-radius: 4px !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* ==================================================================
	 * 2. STEPPER (Plans → Profile → Confirmation → Thank You)
	 *    Stock WCFM renders stepper labels in white — invisible on our
	 *    dark background once (1) kicks in. Force champagne gold.
	 * ================================================================== */
	body.page-id-3918 .wcfmvm_membership_wizard_steps,
	body.page-id-3918 .wcfmvm_membership_steps,
	body.page-id-3918 .wcfm_membership_steps {
		background: transparent !important;
	}
	body.page-id-3918 .wcfmvm_membership_wizard_steps a,
	body.page-id-3918 .wcfmvm_membership_wizard_steps li,
	body.page-id-3918 .wcfmvm_membership_wizard_steps span,
	body.page-id-3918 .wcfmvm_membership_steps a,
	body.page-id-3918 .wcfmvm_membership_steps li,
	body.page-id-3918 .wcfm_membership_steps a,
	body.page-id-3918 .wcfm_membership_steps li {
		color: rgba(204, 197, 147, 0.60) !important;
		background: transparent !important;
	}
	body.page-id-3918 .wcfmvm_membership_wizard_steps a.active,
	body.page-id-3918 .wcfmvm_membership_wizard_steps a.done,
	body.page-id-3918 .wcfmvm_membership_wizard_steps li.active,
	body.page-id-3918 .wcfmvm_membership_wizard_steps li.done,
	body.page-id-3918 .wcfmvm_membership_steps a.active,
	body.page-id-3918 .wcfmvm_membership_steps a.done,
	body.page-id-3918 .wcfmvm_membership_steps li.active,
	body.page-id-3918 .wcfmvm_membership_steps li.done,
	body.page-id-3918 .wcfm_membership_steps a.active,
	body.page-id-3918 .wcfm_membership_steps a.done,
	body.page-id-3918 .wcfm_membership_steps li.active,
	body.page-id-3918 .wcfm_membership_steps li.done {
		color: #CCC593 !important;
		background: transparent !important;
	}

	/* ==================================================================
	 * 3. LABELS & DESCRIPTIONS — champagne on dark
	 * ================================================================== */
	body.page-id-3918 label,
	body.page-id-3918 .wcfm_title,
	body.page-id-3918 .wcfm-message,
	body.page-id-3918 .description,
	body.page-id-3918 .wcfm_store_slug,
	body.page-id-3918 .wcfm_store_slug_verified,
	body.page-id-3918 .wcfm_page_options_desc,
	body.page-id-3918 h1, body.page-id-3918 h2, body.page-id-3918 h3,
	body.page-id-3918 h4, body.page-id-3918 h5, body.page-id-3918 h6 {
		color: rgba(204, 197, 147, 0.90) !important;
	}

	/* ==================================================================
	 * 4. INPUT FIELDS — LIGHT background + BLACK typed text (per Daniel)
	 *    Labels stay champagne-on-dark (section 3). Inputs are crisp
	 *    off-white with black text so typing is always visible.
	 *
	 *    WCFM's own rules target `input.wcfm-text` (spec 0,1,1) and beat
	 *    a plain `input[type=...]` (spec 0,0,1,1). Stack selectors +
	 *    `html body.page-id-3918` prefix so specificity comfortably wins.
	 * ================================================================== */
	html body.page-id-3918 input.wcfm-text,
	html body.page-id-3918 input.wcfm_ele,
	html body.page-id-3918 select.wcfm-select,
	html body.page-id-3918 textarea.wcfm-textarea,
	html body.page-id-3918 form input[type="text"],
	html body.page-id-3918 form input[type="email"],
	html body.page-id-3918 form input[type="tel"],
	html body.page-id-3918 form input[type="url"],
	html body.page-id-3918 form input[type="number"],
	html body.page-id-3918 form input[type="password"],
	html body.page-id-3918 form input[type="search"],
	html body.page-id-3918 form select,
	html body.page-id-3918 form textarea {
		background: #ffffff !important;
		background-color: #ffffff !important;
		color: #0a0a0a !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		border-radius: 3px !important;
		padding: 10px 12px !important;
		font-size: 14px !important;
	}
	html body.page-id-3918 input.wcfm-text:focus,
	html body.page-id-3918 input.wcfm_ele:focus,
	html body.page-id-3918 form input[type="text"]:focus,
	html body.page-id-3918 form input[type="email"]:focus,
	html body.page-id-3918 form input[type="tel"]:focus,
	html body.page-id-3918 form input[type="number"]:focus,
	html body.page-id-3918 form select:focus,
	html body.page-id-3918 form textarea:focus {
		border-color: #CCC593 !important;
		outline: none !important;
		box-shadow: 0 0 0 2px rgba(204, 197, 147, 0.25) !important;
	}
	html body.page-id-3918 input::placeholder,
	html body.page-id-3918 textarea::placeholder {
		color: rgba(10, 10, 10, 0.45) !important;
	}
	body.page-id-3918 input[type="text"]:focus,
	body.page-id-3918 input[type="email"]:focus,
	body.page-id-3918 input[type="tel"]:focus,
	body.page-id-3918 input[type="number"]:focus,
	body.page-id-3918 select:focus,
	body.page-id-3918 textarea:focus {
		border-color: rgba(204, 197, 147, 0.70) !important;
		outline: none !important;
		box-shadow: 0 0 0 2px rgba(204, 197, 147, 0.10) !important;
	}
	body.page-id-3918 input::placeholder,
	body.page-id-3918 textarea::placeholder {
		color: rgba(204, 197, 147, 0.45) !important;
	}

	/* ==================================================================
	 * 5. SELECT2 dropdown (Country field uses it)
	 * ================================================================== */
	html body.page-id-3918 .select2-container--default .select2-selection--single,
	html body.page-id-3918 .select2-container--default .select2-selection--multiple {
		background: #ffffff !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		color: #0a0a0a !important;
		min-height: 42px !important;
	}
	html body.page-id-3918 .select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #0a0a0a !important;
		line-height: 40px !important;
		padding-left: 12px !important;
	}
	html body.page-id-3918 .select2-container--default .select2-selection--single .select2-selection__arrow b {
		border-color: #0a0a0a transparent transparent transparent !important;
	}
	/* Select2 dropdown panel teleports to body — use body:has() so it
	   only matches when the membership page is mounted. Keep panel
	   light + black text for consistency with the triggers above. */
	body:has(.page-id-3918) .select2-container .select2-dropdown,
	body:has(.wcfmvm_country_to_select) .select2-container .select2-dropdown {
		background: #ffffff !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		color: #0a0a0a !important;
	}
	body:has(.page-id-3918) .select2-container .select2-results__option,
	body:has(.wcfmvm_country_to_select) .select2-container .select2-results__option {
		background: #ffffff !important;
		color: #0a0a0a !important;
	}
	body:has(.page-id-3918) .select2-container .select2-results__option--highlighted,
	body:has(.wcfmvm_country_to_select) .select2-container .select2-results__option--highlighted {
		background: rgba(204, 197, 147, 0.20) !important;
		color: #0a0a0a !important;
	}
	body:has(.page-id-3918) .select2-container .select2-search__field,
	body:has(.wcfmvm_country_to_select) .select2-container .select2-search__field {
		background: #ffffff !important;
		color: #0a0a0a !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
	}

	/* ==================================================================
	 * 6. LINKS — Terms & Conditions, store slug URL preview
	 * ================================================================== */
	body.page-id-3918 a {
		color: #CCC593 !important;
	}
	body.page-id-3918 a:hover {
		color: #E5D599 !important;
		text-decoration: underline !important;
	}

	/* ==================================================================
	 * 7. BUTTONS — Subscribe Now, CONFIRM, << PLANS, RE-SEND CODE
	 *    Champagne chip style. Back/secondary buttons: outline.
	 * ================================================================== */
	body.page-id-3918 button,
	body.page-id-3918 input[type="submit"],
	body.page-id-3918 .wcfmvm-submit,
	body.page-id-3918 a.wcfmvm-submit,
	body.page-id-3918 .wcfmvm_membership_subscribe_button,
	body.page-id-3918 .wcfm_membership_subscribe_button {
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
		text-decoration: none !important;
	}
	body.page-id-3918 button:hover,
	body.page-id-3918 input[type="submit"]:hover,
	body.page-id-3918 .wcfmvm-submit:hover {
		background: #CCC593 !important;
	}
	/* << PLANS back button: outline only */
	body.page-id-3918 .wcfmvm-plans-back,
	body.page-id-3918 button.wcfmvm-plans-back,
	body.page-id-3918 a.wcfmvm-plans-back,
	body.page-id-3918 .wcfm_membership_back {
		background: transparent !important;
		background-color: transparent !important;
		color: rgba(204, 197, 147, 0.85) !important;
		border: 1px solid rgba(204, 197, 147, 0.40) !important;
	}
	body.page-id-3918 .wcfmvm-plans-back:hover {
		background: rgba(204, 197, 147, 0.08) !important;
		color: #CCC593 !important;
	}
	/* RE-SEND CODE, and other secondary small buttons */
	body.page-id-3918 .wcfmvm_email_verification_resend,
	body.page-id-3918 button.wcfmvm_email_verification_resend {
		background: transparent !important;
		color: rgba(204, 197, 147, 0.85) !important;
		border: 1px solid rgba(204, 197, 147, 0.30) !important;
		padding: 6px 14px !important;
		font-size: 11px !important;
	}

	/* ==================================================================
	 * 8. CHECKBOX & RADIO — champagne accent
	 * ================================================================== */
	body.page-id-3918 input[type="checkbox"],
	body.page-id-3918 input[type="radio"] {
		accent-color: #CCC593 !important;
		width: 16px !important;
		height: 16px !important;
	}

	/* ==================================================================
	 * 9. PLAN CARDS (Plans step) — dark card, champagne header
	 *    Stock WCFM renders these orange — catastrophically off-brand.
	 * ================================================================== */
	body.page-id-3918 .wcfmvm_membership_plan,
	body.page-id-3918 .wcfm_membership_plan,
	body.page-id-3918 .wcfmmembership_plan {
		background: rgba(20, 16, 10, 0.75) !important;
		background-color: rgba(20, 16, 10, 0.75) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		color: rgba(230, 225, 195, 0.95) !important;
		border-radius: 4px !important;
		overflow: hidden !important;
	}
	body.page-id-3918 .wcfmvm_plan_title,
	body.page-id-3918 .wcfm_membership_plan_title,
	body.page-id-3918 .wcfmmembership_plan_title,
	body.page-id-3918 .wcfmvm_membership_plan_title {
		background: rgba(204, 197, 147, 0.08) !important;
		background-color: rgba(204, 197, 147, 0.08) !important;
		color: #CCC593 !important;
		border-bottom: 1px solid rgba(204, 197, 147, 0.20) !important;
		padding: 16px !important;
		font-family: 'Cormorant Garamond', serif !important;
		font-size: 22px !important;
		font-weight: 500 !important;
		letter-spacing: 0.04em !important;
	}
	body.page-id-3918 .wcfmvm_plan_price,
	body.page-id-3918 .wcfm_membership_plan_price,
	body.page-id-3918 .wcfmmembership_plan_price {
		background: transparent !important;
		color: #CCC593 !important;
		font-size: 32px !important;
		font-weight: 700 !important;
	}
	body.page-id-3918 .wcfmvm_plan_popular,
	body.page-id-3918 .wcfm_membership_plan_popular,
	body.page-id-3918 .wcfmmembership_plan_popular,
	body.page-id-3918 .wcfmvm_plan_popular_tag {
		background: rgba(204, 197, 147, 0.92) !important;
		background-color: rgba(204, 197, 147, 0.92) !important;
		color: #0a0a0a !important;
		font-weight: 600 !important;
		letter-spacing: 0.1em !important;
		text-transform: uppercase !important;
	}

	/* ==================================================================
	 * 10. REQUIRED ASTERISKS — keep red-ish but tone down
	 * ================================================================== */
	body.page-id-3918 .wcfm_title .required,
	body.page-id-3918 .required,
	body.page-id-3918 label .required {
		color: #d68a8a !important;
	}

	/* ==================================================================
	 * 11. Hero sections + surrounding white (if any) — force transparent
	 * ================================================================== */
	body.page-id-3918 .entry-content,
	body.page-id-3918 .page-content,
	body.page-id-3918 .post-content {
		background: transparent !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* ==================================================================
	 * 12. CONFIRMATION STEP (?vmstep=confirmation)
	 *     Stock WCFM renders: (a) left "Review your plan" card with
	 *     bright cyan bg (rgb(99,194,222)), (b) right "Confirmation"
	 *     card with near-white bg, (c) "FREE Plan!!!" message in medium
	 *     grey inset. All catastrophically off-brand. Force dark luxury.
	 * ================================================================== */
	html body.page-id-3918 .wcfm_membership_thankyou_content_wrapper,
	html body.page-id-3918 .wcfmvm_membership_confirmation_wrapper,
	html body.page-id-3918 .wcfmvm_membership_review_wrapper,
	html body.page-id-3918 .wcfmvm_membership_plan_wrapper,
	html body.page-id-3918 .wcfm_membership_plan_wrapper,
	html body.page-id-3918 div[class*="thankyou_content"],
	html body.page-id-3918 div[class*="membership_review"],
	html body.page-id-3918 div[class*="membership_confirmation"] {
		background: rgba(20, 16, 10, 0.75) !important;
		background-color: rgba(20, 16, 10, 0.75) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		color: rgba(230, 225, 195, 0.95) !important;
		border-radius: 4px !important;
	}

	/* Review your plan / Confirmation labels */
	html body.page-id-3918 .wcfmvm_review_label,
	html body.page-id-3918 .wcfmvm_confirmation_label,
	html body.page-id-3918 u,
	html body.page-id-3918 [class*="review"] u,
	html body.page-id-3918 [class*="confirmation"] u {
		color: rgba(204, 197, 147, 0.85) !important;
		text-decoration: none !important;
	}

	/* "Be a Gold Partner" plan title on review card */
	html body.page-id-3918 .wcfm_membership_thankyou_content_wrapper h1,
	html body.page-id-3918 .wcfm_membership_thankyou_content_wrapper h2,
	html body.page-id-3918 .wcfm_membership_thankyou_content_wrapper h3,
	html body.page-id-3918 .wcfm_membership_thankyou_content_wrapper strong,
	html body.page-id-3918 div[class*="membership_review"] h1,
	html body.page-id-3918 div[class*="membership_review"] h2,
	html body.page-id-3918 div[class*="membership_review"] h3,
	html body.page-id-3918 div[class*="membership_review"] strong {
		color: #CCC593 !important;
	}

	/* Free plan message box */
	html body.page-id-3918 .wcfmvm_free_message,
	html body.page-id-3918 .wcfmvm_no_payment_message,
	html body.page-id-3918 .wcfmvm_confirmation_message,
	html body.page-id-3918 div[class*="free_message"],
	html body.page-id-3918 div[class*="no_payment"] {
		background: rgba(8, 6, 4, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.20) !important;
		color: rgba(230, 225, 195, 0.90) !important;
		padding: 20px !important;
		border-radius: 3px !important;
	}

	/* Generic fallback — any div inside membership container with a
	   bright non-dark background gets forced transparent to reveal the
	   dark page bg beneath. Scoped tight to avoid bleed. */
	html body.page-id-3918 .wcfm-membership-wrapper > div,
	html body.page-id-3918 .wcfm-membership-wrapper section > div,
	html body.page-id-3918 form.wcfm > div {
		background-color: transparent;
	}

	</style>
	<?php
}, 100012 );

/**
 * WCFM Store Setup Wizard — the page vendors land on AFTER
 * subscribing. URL pattern: /?store-setup=yes, body.wcfm-store-setup.
 * Stock WCFM ships this with a light-grey body bg + cyan accents —
 * completely off-brand. Scope via body class to avoid any bleed.
 *
 * Uses wp_head (not wp_footer) because WC Setup Wizard uses a minimal
 * template that doesn't always call wp_footer. Rules are scoped to
 * body.wcfm-store-setup so zero bleed to other pages.
 */
add_action( 'wp_head', function () {
	?>
	<style id="rg-wcfm-store-setup-dark">

	/* Body + wizard card */
	html body.wcfm-store-setup {
		background: #0f0c08 !important;
		background-color: #0f0c08 !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}
	html body.wcfm-store-setup #wc-logo,
	html body.wcfm-store-setup .wc-setup-content,
	html body.wcfm-store-setup .wcfm-store-setup-content,
	html body.wcfm-store-setup .wc-setup-steps {
		background: rgba(20, 16, 10, 0.75) !important;
		background-color: rgba(20, 16, 10, 0.75) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}
	html body.wcfm-store-setup .wc-setup-content,
	html body.wcfm-store-setup .wcfm-store-setup-content {
		padding: 32px !important;
	}

	/* Store Setup heading (was cyan) */
	html body.wcfm-store-setup h1,
	html body.wcfm-store-setup h2,
	html body.wcfm-store-setup h3,
	html body.wcfm-store-setup #logo,
	html body.wcfm-store-setup .wc-logo {
		color: #CCC593 !important;
	}

	/* Stepper labels (Store, Payment, Ready!) */
	html body.wcfm-store-setup .wc-setup-steps li {
		color: rgba(204, 197, 147, 0.75) !important;
	}
	html body.wcfm-store-setup .wc-setup-steps li.active {
		color: #CCC593 !important;
		border-color: #CCC593 !important;
	}
	html body.wcfm-store-setup .wc-setup-steps li.done {
		color: rgba(204, 197, 147, 0.85) !important;
		border-color: rgba(204, 197, 147, 0.85) !important;
	}
	html body.wcfm-store-setup .wc-setup-steps li::before,
	html body.wcfm-store-setup .wc-setup-steps li::after {
		border-color: rgba(204, 197, 147, 0.30) !important;
		background: transparent !important;
	}

	/* Body text + labels inside wizard */
	html body.wcfm-store-setup .wc-setup-content p,
	html body.wcfm-store-setup .wc-setup-content label,
	html body.wcfm-store-setup .wc-setup-content span,
	html body.wcfm-store-setup .wc-setup-content td,
	html body.wcfm-store-setup .wc-setup-content th {
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* Input fields — WHITE bg, BLACK text (consistent with vendor-membership) */
	html body.wcfm-store-setup input[type="text"],
	html body.wcfm-store-setup input[type="email"],
	html body.wcfm-store-setup input[type="tel"],
	html body.wcfm-store-setup input[type="url"],
	html body.wcfm-store-setup input[type="number"],
	html body.wcfm-store-setup input[type="password"],
	html body.wcfm-store-setup select,
	html body.wcfm-store-setup textarea {
		background: #ffffff !important;
		color: #0a0a0a !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		border-radius: 3px !important;
		padding: 10px 12px !important;
	}
	html body.wcfm-store-setup input::placeholder {
		color: rgba(10, 10, 10, 0.45) !important;
	}

	/* Primary button (Let's go!, Next, Continue) */
	html body.wcfm-store-setup .button-primary,
	html body.wcfm-store-setup .button.button-next,
	html body.wcfm-store-setup .wcfm_submit_button,
	html body.wcfm-store-setup a.button-primary {
		background: rgba(204, 197, 147, 0.92) !important;
		background-color: rgba(204, 197, 147, 0.92) !important;
		color: #0a0a0a !important;
		border: 0 !important;
		border-radius: 3px !important;
		padding: 11px 22px !important;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.1em !important;
		text-decoration: none !important;
		text-shadow: none !important;
	}
	html body.wcfm-store-setup .button-primary:hover {
		background: #CCC593 !important;
		color: #0a0a0a !important;
	}

	/* Secondary / "Not right now" / skip button */
	html body.wcfm-store-setup .button:not(.button-primary),
	html body.wcfm-store-setup .wc-setup-actions a:not(.button-primary) {
		background: transparent !important;
		color: rgba(204, 197, 147, 0.85) !important;
		border: 1px solid rgba(204, 197, 147, 0.40) !important;
		border-radius: 3px !important;
		padding: 11px 22px !important;
		text-transform: uppercase !important;
		letter-spacing: 0.08em !important;
		text-decoration: none !important;
	}

	/* Links */
	html body.wcfm-store-setup a {
		color: #CCC593 !important;
	}

	</style>
	<?php
}, 100013 );
