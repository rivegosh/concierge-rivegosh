<?php
/**
 * Plugin Name: Rive Gosh — Pro Panel Unnest Card
 * Description: Removes the outer .am-auth card styling on /booking-pro-panel/
 *              so only the inner .am-asi (Amelia's native sign-in card) shows.
 *              Fixes the nested-card look Daniel reported 2026-04-17.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-17
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. Verified visually via Chrome MCP     ║
 * ║  screenshot + Daniel sign-off on 2026-04-17.                    ║
 * ║                                                                  ║
 * ║  If /booking-pro-panel/ login card looks off later, FIX THE    ║
 * ║  CAUSE (another mu-plugin adding card styles, plugin update,    ║
 * ║  LiteSpeed cache) — do NOT gut or rewrite this file. Ship      ║
 * ║  additive overrides in a NEW mu-plugin if adjustment is         ║
 * ║  genuinely needed.                                              ║
 * ║                                                                  ║
 * ║  WHY THIS FILE EXISTS: Two mu-plugins each independently        ║
 * ║  styled the login as a card — rg-amelia-contrast.php styles    ║
 * ║  .am-auth (outer wrapper), rg-amelia-access-link.php styles     ║
 * ║  .am-asi (inner sign-in). Both applied on pro-panel =           ║
 * ║  nested card look. This file neutralizes the outer .am-auth    ║
 * ║  card styling on page-id-54778 only, leaving the inner .am-asi ║
 * ║  gold-bordered card as the single visible container.            ║
 * ║                                                                  ║
 * ║  GitHub: rivegosh/concierge-rivegosh#75                         ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_head', 'rg_pro_panel_unnest_card_css', 999 );
function rg_pro_panel_unnest_card_css() {
	if ( ! is_page( 54778 ) ) {
		return;
	}
	?>
	<style id="rg-pro-panel-unnest-card">
	/* Neutralize the outer .am-auth card on pro-panel so Amelia's
	   native .am-asi card is the only visible container. Keeps text
	   color + font rules (handled elsewhere) but strips the card
	   shell (bg, border, shadow, padding). */
	body.page-id-54778 .amelia-v2-booking .am-auth,
	body.page-id-54778 .am-cap__wrapper.am-auth,
	body.page-id-54778 .am-auth {
		background: transparent !important;
		background-color: transparent !important;
		border: 0 !important;
		border-radius: 0 !important;
		box-shadow: none !important;
		padding: 0 !important;
	}
	/* The wrapper can keep a small top margin for breathing room. */
	body.page-id-54778 .am-cap__wrapper.am-auth {
		margin-top: 24px !important;
	}
	</style>
	<?php
}
