<?php
/**
 * Plugin Name: Rive Gosh — Pro Panel Unnest Card + Inputs
 * Description: On /booking-pro-panel/, neutralizes (a) the outer .am-auth card
 *              so only Amelia's .am-asi card is visible, and (b) the inner
 *              .el-input__wrapper + raw input borders so each field shows as
 *              a SINGLE dark pill, not three nested rectangles. Fixes the
 *              "multiple fields stacked" regression Daniel reported 2026-04-17.
 * Author: RG
 * Version: 1.0.1
 * Created: 2026-04-17
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. v1.0.1 — awaiting Daniel visual     ║
 * ║  sign-off after hard-reload on 2026-04-17.                      ║
 * ║                                                                  ║
 * ║  If /booking-pro-panel/ login card looks off later, FIX THE    ║
 * ║  CAUSE (another mu-plugin adding card styles, plugin update,    ║
 * ║  LiteSpeed cache) — do NOT gut or rewrite this file. Ship      ║
 * ║  additive overrides in a NEW mu-plugin if adjustment is         ║
 * ║  genuinely needed.                                              ║
 * ║                                                                  ║
 * ║  WHY THIS FILE EXISTS:                                          ║
 * ║  Two separate mu-plugins independently style pro-panel login:   ║
 * ║    1. rg-amelia-contrast.php styles .am-auth (outer card) AND  ║
 * ║       .el-input (outer input pill)                              ║
 * ║    2. rg-amelia-access-link.php styles .am-asi (inner card)    ║
 * ║       AND .el-input__wrapper + raw input (inner pills)          ║
 * ║                                                                  ║
 * ║  On pro-panel both apply → THREE nested cards (outer auth,      ║
 * ║  middle asi, inner wrapper) AND THREE nested input borders.     ║
 * ║                                                                  ║
 * ║  This file, scoped to page-id-54778 only, neutralizes the       ║
 * ║  OUTER .am-auth card + the INNER .el-input__wrapper / input    ║
 * ║  borders. Result: ONE card (.am-asi) and ONE input pill per    ║
 * ║  field (.el-input).                                             ║
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

	/* ─────────────────────────────────────────────────────────────
	   INPUTS — strip the INNER two rectangles so only the outer
	   .el-input pill shows. rg-amelia-access-link.php put borders
	   on .el-input__wrapper AND the raw <input>, which stacked
	   with the .el-input pill from rg-amelia-contrast.php →
	   three nested boxes. Kill the inner two here.
	   ───────────────────────────────────────────────────────────── */
	body.page-id-54778 .am-asi .el-input__wrapper,
	body.page-id-54778 .am-auth .el-input__wrapper,
	body.page-id-54778 .amelia-v2-booking .el-input__wrapper {
		background: transparent !important;
		background-color: transparent !important;
		border: 0 !important;
		border-radius: 0 !important;
		box-shadow: none !important;
		padding: 0 !important;
		height: 100% !important;
		width: 100% !important;
	}
	body.page-id-54778 .am-asi input,
	body.page-id-54778 .am-asi input[type="text"],
	body.page-id-54778 .am-asi input[type="email"],
	body.page-id-54778 .am-asi input[type="password"],
	body.page-id-54778 .am-asi .el-input__inner,
	body.page-id-54778 .am-auth input,
	body.page-id-54778 .am-auth input[type="text"],
	body.page-id-54778 .am-auth input[type="email"],
	body.page-id-54778 .am-auth input[type="password"],
	body.page-id-54778 .am-auth .el-input__inner {
		background: transparent !important;
		background-color: transparent !important;
		border: 0 !important;
		border-radius: 0 !important;
		box-shadow: none !important;
		outline: none !important;
	}
	/* Focus state: show the outer .el-input pill only. Kill any
	   focus-within box-shadow on the inner wrapper. */
	body.page-id-54778 .am-asi .el-input__wrapper:focus-within,
	body.page-id-54778 .am-auth .el-input__wrapper:focus-within,
	body.page-id-54778 .am-asi .el-input__inner:focus,
	body.page-id-54778 .am-auth .el-input__inner:focus {
		border: 0 !important;
		box-shadow: none !important;
		outline: none !important;
	}
	</style>
	<?php
}
