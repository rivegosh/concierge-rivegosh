<?php
/**
 * Plugin Name: RG Wizard Continue Button
 * Description: Styling + stability fix for the CONTINUE button in the Amelia
 *              booking wizard (.am-fs__main-footer .am-button-continue).
 *              Problems (2026-04-21 — Daniel screenshots):
 *              1. Button too narrow (~117px) — hard to hit, low visibility.
 *              2. Font too small (11px) — button undersells the CTA.
 *              3. Position shifts visually between steps (Cart step adds
 *                 "Book another" on the left → flex layout re-flows → CONTINUE
 *                 appears at a different x-offset than single-button steps).
 *              Fix: min-width:240px, font-size:13px, font-weight:700, explicit
 *              dark text. Stability via min-width prevents width jitter between
 *              steps. Footer is position:absolute;bottom:0 (Amelia built-in) —
 *              we preserve that and don't touch top/bottom anchoring.
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: .amelia-v2-booking #amelia-container .am-fs__main-footer  ║
 * ║ Priority 100007 — fires after all existing mu-plugins.           ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root causes (2026-04-21):                                        ║
 * ║  .am-button--default sets an auto/narrow intrinsic width. Amelia ║
 * ║  sealed CSS sets font-size:11px on .am-button--default. The      ║
 * ║  footer uses justify-content:flex-end — when Cart step adds a    ║
 * ║  second "Book another" button, CONTINUE shifts left visually.    ║
 * ║  Fix: min-width:240px locks button at ≥240px regardless of step. ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_singular() ) return;
	?>
	<style id="rg-wizard-continue-btn">

	/* ==================================================================
	 * 1. CONTINUE BUTTON — size, weight, text colour
	 *    .am-button-continue is the specific class Amelia adds to the
	 *    step-navigation CONTINUE button (distinct from package popups).
	 *    min-width:240px doubles the ~117px natural size; font-size:13px
	 *    is +2pt over Amelia's sealed 11px default.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-fs__main-footer .am-button-continue {
		min-width: 240px !important;
		font-size: 13px !important;
		font-weight: 700 !important;
		color: #0a0a0a !important;
		letter-spacing: 0.03em !important;
	}
	.amelia-v2-booking #amelia-container .am-fs__main-footer .am-button-continue .am-button__inner,
	.amelia-v2-booking #amelia-container .am-fs__main-footer .am-button-continue .am-button__inner span {
		color: #0a0a0a !important;
		font-size: 13px !important;
		font-weight: 700 !important;
	}

	/* ==================================================================
	 * 2. FOOTER STABILITY — consistent height so button never jumps
	 *    The footer is already position:absolute;bottom:0 (Amelia-built).
	 *    Enforcing min-height ensures it doesn't collapse or resize when
	 *    a second button ("Book another") is added on Cart step.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-fs__main-footer {
		min-height: 74px !important;
		align-items: center !important;
		box-sizing: border-box !important;
	}

	</style>
	<?php
}, 100007 );
