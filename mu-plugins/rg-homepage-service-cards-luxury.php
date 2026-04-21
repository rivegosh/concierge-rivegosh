<?php
/**
 * Plugin Name: RG Homepage Service Cards — Luxury
 * Description: Luxury skin for the 3 service cards on the homepage (page-id-61860):
 *              BOOK AN AIRPORT TRANSFER (c4), 4H/8H/12H PRIVATE DRIVER (c9), VIP REQUEST (c14).
 * Version: 1.0.1
 * Author: Roderic / Chi
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║                                                                   ║
 * ║ Scope: body.page-id-61860 only (zero bleed to other pages).      ║
 * ║                                                                   ║
 * ║ Problem (2026-04-20): 3 homepage service cards render as white   ║
 * ║ boxes (bg #fff) with an almost-invisible gold border             ║
 * ║ (rgba(196,178,118,0.18)) — clashes with the dark luxury body.    ║
 * ║ Body text is 11px Ovo at 60% opacity, title near-black.          ║
 * ║                                                                   ║
 * ║ Fix: translucent dark card, solid champagne-gold hairline border ║
 * ║ (#CCC593), title flipped to gold, body text bumped to 15px with  ║
 * ║ generous line-height, padding enlarged for vertical breathing    ║
 * ║ room. Icon + divider untouched (gold circles already luxurious). ║
 * ║                                                                   ║
 * ║ DESIGN-ONLY. NO functionality/links/DOM changes.                 ║
 * ║                                                                   ║
 * ║ Selector pattern notes (KB #49 lessons):                         ║
 * ║  - #colibri IS the <body> — use body#colibri.page-id-61860       ║
 * ║    same-element, NOT descendant "body X #colibri Y".             ║
 * ║  - Border uses longhand border-*-color (shorthand interacts      ║
 * ║    badly with Colibri's per-side !important longhands).          ║
 * ║  - Title uses double-nested parent selector                      ║
 * ║    [data-colibri-id="c4"] [data-colibri-id="c6"] h4 to out-      ║
 * ║    specify Colibri's single-parent "[c4] h4" !important rule.    ║
 * ║  - NO CSS transition — backgrounded tabs throttle transitions    ║
 * ║    and computed border-color never lands at target.              ║
 * ║                                                                   ║
 * ║ Card colibri-ids:  61860-c4 / 61860-c9 / 61860-c14               ║
 * ║ Title ids:         61860-c6 / 61860-c11 / 61860-c16              ║
 * ║ Body text ids:     61860-c8 / 61860-c13 / 61860-c18              ║
 * ║                                                                   ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 61860 ) && ! is_front_page() ) return;
	?>
	<style id="rg-homepage-service-cards-luxury">
	/* ============================================================
	 * Card shell — dark translucent
	 * ============================================================ */
	body#colibri.page-id-61860 [data-colibri-id="61860-c4"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c9"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c14"] {
		background-color: rgba(15, 12, 8, 0.55) !important;
		border-top-width: 1px !important;
		border-right-width: 1px !important;
		border-bottom-width: 1px !important;
		border-left-width: 1px !important;
		border-top-style: solid !important;
		border-right-style: solid !important;
		border-bottom-style: solid !important;
		border-left-style: solid !important;
		border-top-color: #CCC593 !important;
		border-right-color: #CCC593 !important;
		border-bottom-color: #CCC593 !important;
		border-left-color: #CCC593 !important;
		border-radius: 4px !important;
		padding: 48px 36px !important;
		box-shadow: 0 2px 18px rgba(0, 0, 0, 0.25) !important;
	}

	/* ============================================================
	 * Title — champagne gold. Double-nested parent selector to
	 * out-specify Colibri's [data-colibri-id="c4"] h4 !important.
	 * ============================================================ */
	body#colibri.page-id-61860 [data-colibri-id="61860-c4"] [data-colibri-id="61860-c6"] h4,
	body#colibri.page-id-61860 [data-colibri-id="61860-c9"] [data-colibri-id="61860-c11"] h4,
	body#colibri.page-id-61860 [data-colibri-id="61860-c14"] [data-colibri-id="61860-c16"] h4,
	body#colibri.page-id-61860 [data-colibri-id="61860-c4"] [data-colibri-id="61860-c6"] h4 a,
	body#colibri.page-id-61860 [data-colibri-id="61860-c9"] [data-colibri-id="61860-c11"] h4 a,
	body#colibri.page-id-61860 [data-colibri-id="61860-c14"] [data-colibri-id="61860-c16"] h4 a {
		color: #CCC593 !important;
		line-height: 1.25 !important;
		letter-spacing: 0.02em !important;
	}

	/* ============================================================
	 * Body text — 15px / 1.7 / warm light on dark
	 * ============================================================ */
	body#colibri.page-id-61860 [data-colibri-id="61860-c4"] [data-colibri-id="61860-c8"] p,
	body#colibri.page-id-61860 [data-colibri-id="61860-c9"] [data-colibri-id="61860-c13"] p,
	body#colibri.page-id-61860 [data-colibri-id="61860-c14"] [data-colibri-id="61860-c18"] p,
	body#colibri.page-id-61860 [data-colibri-id="61860-c4"] [data-colibri-id="61860-c8"] .h-text,
	body#colibri.page-id-61860 [data-colibri-id="61860-c9"] [data-colibri-id="61860-c13"] .h-text,
	body#colibri.page-id-61860 [data-colibri-id="61860-c14"] [data-colibri-id="61860-c18"] .h-text {
		font-size: 15px !important;
		line-height: 1.7 !important;
		color: rgba(230, 225, 195, 0.88) !important;
	}

	/* ============================================================
	 * Vertical breathing — spacing between icon / title / divider / body
	 * ============================================================ */
	body#colibri.page-id-61860 [data-colibri-id="61860-c5"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c10"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c15"] {
		margin-bottom: 18px !important;
	}
	body#colibri.page-id-61860 [data-colibri-id="61860-c6"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c11"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c16"] {
		margin-bottom: 14px !important;
	}
	body#colibri.page-id-61860 [data-colibri-id="61860-c7"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c12"],
	body#colibri.page-id-61860 [data-colibri-id="61860-c17"] {
		margin-bottom: 18px !important;
	}
	</style>
	<?php
}, 99999 );
