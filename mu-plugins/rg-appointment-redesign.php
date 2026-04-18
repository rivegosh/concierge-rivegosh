<?php
/**
 * Plugin Name: Rive Gosh — Appointment Page Redesign
 * Description: Dark-luxury reskin of /appointment/ page (ID 44401).
 *              Stepper ribbon (vertical layout with number + label + representative icon)
 *              + destination gallery (11 city cards) with champagne-gold hairline,
 *              centered airplane icons, and solid charbon background.
 *              Scope-guarded by is_page( 44401 ) — zero bleed to other pages.
 * Author: RG
 * Version: 1.2.3
 * Created: 2026-04-18
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard reskin. Verified visually via Chrome        ║
 * ║  screenshot on 2026-04-18 and signed off by Roderic.             ║
 * ║                                                                   ║
 * ║  If the /appointment/ page (stepper ribbon or destination grid)   ║
 * ║  looks wrong later, FIX THE CAUSE (another mu-plugin, Colibri     ║
 * ║  theme update, LiteSpeed config, post_content edit) — do NOT gut  ║
 * ║  or rewrite this file. Ship additive overrides in a NEW           ║
 * ║  mu-plugin if genuinely needed.                                   ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS:                                            ║
 * ║  Issue #68 reskinned Amelia catalog + wizard + WCFM, but the      ║
 * ║  rg_home_redesign() function inside rg-amelia-contrast.php        ║
 * ║  targets Colibri section 61860-c2 (home page grid), NOT 44401-*   ║
 * ║  (appointment page). The appointment page was left with white     ║
 * ║  cards + diagonal crosshatch watermark textures + franglais copy  ║
 * ║  ("enter your informations"), clashing with the charbon/gold      ║
 * ║  rebrand. This plugin skins the 44401 section-set only.           ║
 * ║                                                                   ║
 * ║  Isolated from rg-amelia-contrast.php deliberately: per memory,   ║
 * ║  that file is rewritten by concurrent CC sessions and lacks a     ║
 * ║  regression sweep. Isolated files survive; appended ones don't.   ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#80                           ║
 * ║  Commit of record: see CLAUDE.md protected mu-plugins registry    ║
 * ╚══════════════════════════════════════════════════════════════════╝
 *
 * Rollback: delete this file + `wp litespeed-purge all`. No DB writes.
 * Brand tokens from issue #41. CSS deploy pattern from issue #49.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 44401 ) ) return;
	?>
<style id="rg-appointment-redesign">
/* ═══════════════════════════════════════════════════════════════
   RG APPOINTMENT REDESIGN v1.2
   ═══════════════════════════════════════════════════════════════ */

/* 1. Kill watermark textures on both sections */
#colibri [data-colibri-id="44401-c6"] .shape-layer,
#colibri [data-colibri-id="44401-c19"] .shape-layer,
#colibri [data-colibri-id="44401-c6"] .overlay-image-layer,
#colibri [data-colibri-id="44401-c19"] .overlay-image-layer {
	display: none !important;
	background-image: none !important;
	opacity: 0 !important;
}

/* 2. Solid charbon backgrounds — kill parallax photo */
#colibri [data-colibri-id="44401-c2"],
#colibri [data-colibri-id="44401-c19"] {
	background: #1A1A1A !important;
}
#colibri [data-colibri-id="44401-c19"] .background-wrapper,
#colibri [data-colibri-id="44401-c19"] .background-layer,
#colibri [data-colibri-id="44401-c19"] .paraxify {
	display: none !important;
	background-image: none !important;
}

/* 3. Hero H2 */
#colibri [data-colibri-id="44401-c5"] h2,
#colibri [data-colibri-id="44401-c5"] .h-heading {
	color: #CCC593 !important;
	font-family: "Cormorant Garamond", Georgia, serif !important;
	font-weight: 400 !important;
	letter-spacing: 0.01em !important;
}

/* ══════════════════════════════════════════════════════════════
   STEPPER — section 44401-c6 (VERTICAL layout v1.2)
   Columns c7 / c10 / c13 / c16
   Icons (now number dots) c8 / c11 / c14 / c17
   Headings c9 / c12 / c15 / c18 — representative icons via ::after
   ══════════════════════════════════════════════════════════════ */

/* Ribbon container: rounded rectangle with subtle gold hairline */
#colibri [data-colibri-id="44401-c6"] {
	background: transparent !important;
	max-width: 960px !important;
	margin: 0 auto 48px auto !important;
	padding: 18px 20px !important;
	border: 1px solid rgba(204, 197, 147, 0.25) !important;
	border-radius: 20px !important;
	background-color: rgba(20, 20, 20, 0.85) !important;
	backdrop-filter: blur(8px);
	-webkit-backdrop-filter: blur(8px);
}

/* Each step column: vertical stack, centered */
#colibri [data-colibri-id="44401-c6"] .h-column__inner {
	background: transparent !important;
	padding: 14px 10px !important;
	flex-direction: column !important;
	align-items: center !important;
	justify-content: flex-start !important;
	gap: 14px !important;
	text-align: center !important;
}
#colibri [data-colibri-id="44401-c6"] .background-wrapper {
	display: none !important;
}

/* NUMBER DOTS 1/2/3/4 on top (hide original inconsistent SVGs) */
#colibri [data-colibri-id="44401-c6"] .h-icon {
	width: 28px !important;
	height: 28px !important;
	min-width: 28px;
	display: inline-flex !important;
	align-items: center;
	justify-content: center;
	border-radius: 50%;
	border: 1px solid rgba(204, 197, 147, 0.4);
	padding: 0 !important;
	margin: 0 !important;
	position: relative;
}
#colibri [data-colibri-id="44401-c6"] .h-icon svg,
#colibri [data-colibri-id="44401-c6"] .h-svg-icon {
	display: none !important;
	width: 0 !important;
	height: 0 !important;
}
#colibri [data-colibri-id="44401-c6"] .h-icon::before {
	font-family: "Inter", system-ui, sans-serif;
	font-weight: 600;
	font-size: 13px;
	line-height: 1;
	color: #888888;
}
#colibri [data-colibri-id="44401-c8"]::before  { content: "1"; }
#colibri [data-colibri-id="44401-c11"]::before { content: "2"; }
#colibri [data-colibri-id="44401-c14"]::before { content: "3"; }
#colibri [data-colibri-id="44401-c17"]::before { content: "4"; }

/* Step 1 active: gold filled */
#colibri [data-colibri-id="44401-c8"] {
	border-color: #CCC593 !important;
	background: #CCC593 !important;
}
#colibri [data-colibri-id="44401-c8"]::before {
	color: #1A1A1A !important;
}

/* LABELS (middle) — copy refresh via ::before
   NOTE: parent is display:block, not flex — gap: won't apply,
   so push labels down with explicit top margin on each step. */
#colibri [data-colibri-id="44401-c9"],
#colibri [data-colibri-id="44401-c12"],
#colibri [data-colibri-id="44401-c15"],
#colibri [data-colibri-id="44401-c18"] {
	margin-top: 16px !important;
}
#colibri [data-colibri-id="44401-c6"] .h-heading h5 {
	font-size: 0 !important;
	color: transparent !important;
	margin: 0 !important;
	line-height: 1 !important;
}
#colibri [data-colibri-id="44401-c6"] .h-heading h5::before {
	display: block;
	font-family: "Inter", system-ui, sans-serif;
	font-weight: 500;
	font-size: 11px;
	letter-spacing: 0.15em;
	text-transform: uppercase;
	color: #F0EBE1;
	line-height: 1.2;
	white-space: nowrap;
}
#colibri [data-colibri-id="44401-c9"]  h5::before { content: "CHOOSE DESTINATION"; }
#colibri [data-colibri-id="44401-c12"] h5::before { content: "SELECT YOUR CAR"; }
#colibri [data-colibri-id="44401-c15"] h5::before { content: "CHOOSE THE DATES"; }
#colibri [data-colibri-id="44401-c18"] h5::before { content: "ENTER YOUR DETAILS"; }

/* Step 1 active label in champagne gold */
#colibri [data-colibri-id="44401-c9"] h5::before {
	color: #CCC593 !important;
}

/* REPRESENTATIVE ICONS (bottom) — plane / car / calendar / user */
#colibri [data-colibri-id="44401-c9"]::after,
#colibri [data-colibri-id="44401-c12"]::after,
#colibri [data-colibri-id="44401-c15"]::after,
#colibri [data-colibri-id="44401-c18"]::after {
	content: "";
	display: block;
	width: 22px;
	height: 22px;
	margin: 12px auto 0 auto;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center;
	opacity: 0.75;
}
/* Plane */
#colibri [data-colibri-id="44401-c9"]::after {
	background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23CCC593'><path d='M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z'/></svg>");
}
/* Car */
#colibri [data-colibri-id="44401-c12"]::after {
	background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23CCC593'><path d='M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z'/></svg>");
}
/* Calendar */
#colibri [data-colibri-id="44401-c15"]::after {
	background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23CCC593'><path d='M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z'/></svg>");
}
/* User/Details */
#colibri [data-colibri-id="44401-c18"]::after {
	background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23CCC593'><path d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/></svg>");
}

/* Mobile stepper */
@media (max-width: 767px) {
	#colibri [data-colibri-id="44401-c6"] {
		border-radius: 16px !important;
		padding: 14px !important;
	}
}

/* ══════════════════════════════════════════════════════════════
   DESTINATION GALLERY — section 44401-c19
   ══════════════════════════════════════════════════════════════ */

#colibri [data-colibri-id="44401-c19"] .h-column__inner {
	background: #222222 !important;
	border: 1px solid rgba(204, 197, 147, 0.28) !important;  /* champagne gold hairline — visible */
	border-radius: 4px !important;
	padding: 20px 20px !important;
	margin: 8px !important;
	transition: all 220ms cubic-bezier(0.2, 0.8, 0.2, 1) !important;
	position: relative;
	overflow: hidden;
	text-align: center !important;
}

#colibri [data-colibri-id="44401-c19"] .h-column__inner:hover {
	border-color: #CCC593 !important;
	transform: translateY(-2px);
	box-shadow: 0 8px 24px rgba(0,0,0,0.4),
	            inset 0 0 0 1px rgba(204,197,147,0.12);
}

#colibri [data-colibri-id="44401-c19"] .background-wrapper {
	display: none !important;
}

/* City name */
#colibri [data-colibri-id="44401-c19"] .h-heading h4,
#colibri [data-colibri-id="44401-c19"] .h-heading {
	color: #F0EBE1 !important;
	font-family: "Cormorant Garamond", Georgia, serif !important;
	font-weight: 400 !important;
	font-size: 24px !important;
	letter-spacing: 0.02em !important;
	margin: 8px 0 14px 0 !important;
	line-height: 1.2 !important;
	text-transform: uppercase !important;
	text-align: center !important;
}

/* AIRPLANE ICON — hardened centering */
#colibri [data-colibri-id="44401-c19"] .h-icon {
	display: flex !important;
	align-items: center !important;
	justify-content: center !important;
	margin: 0 auto 2px auto !important;
	padding: 0 !important;
	width: 32px !important;
	height: 32px !important;
	text-align: center !important;
}
#colibri [data-colibri-id="44401-c19"] .h-svg-icon,
#colibri [data-colibri-id="44401-c19"] .h-icon__icon {
	display: inline-flex !important;
	align-items: center !important;
	justify-content: center !important;
	width: 100% !important;
	height: 100% !important;
	margin: 0 !important;
	padding: 0 !important;
	text-align: center !important;
}
#colibri [data-colibri-id="44401-c19"] .h-icon svg {
	display: block !important;
	margin: 0 auto !important;
	width: 30px !important;
	height: 30px !important;
	fill: #CCC593 !important;
	opacity: 0.85;
}

/* BOOK button */
#colibri [data-colibri-id="44401-c19"] .h-button {
	background: transparent !important;
	color: #CCC593 !important;
	border: 1px solid #CCC593 !important;
	border-radius: 2px !important;
	padding: 9px 22px !important;
	font-family: "Inter", system-ui, sans-serif !important;
	font-weight: 500 !important;
	font-size: 11px !important;
	letter-spacing: 0.2em !important;
	text-transform: uppercase !important;
	transition: all 180ms ease !important;
	min-width: 110px;
}
#colibri [data-colibri-id="44401-c19"] .h-button:hover {
	background: #CCC593 !important;
	color: #1A1A1A !important;
}
#colibri [data-colibri-id="44401-c19"] .h-button span {
	color: inherit !important;
}

/* Entire card tappable */
#colibri [data-colibri-id="44401-c19"] .h-column__inner .h-button::before {
	content: "";
	position: absolute;
	inset: 0;
	z-index: 1;
}
#colibri [data-colibri-id="44401-c19"] .h-column__inner > * {
	position: relative;
	z-index: 2;
}
#colibri [data-colibri-id="44401-c19"] .h-column__inner .h-button {
	position: relative;
	z-index: 3;
}

/* Mobile destination cards */
@media (max-width: 767px) {
	#colibri [data-colibri-id="44401-c19"] .h-column__inner {
		padding: 18px 14px !important;
		margin: 4px !important;
	}
	#colibri [data-colibri-id="44401-c19"] .h-heading h4 {
		font-size: 20px !important;
	}
	#colibri [data-colibri-id="44401-c19"] .h-icon {
		width: 28px !important;
		height: 28px !important;
	}
	#colibri [data-colibri-id="44401-c19"] .h-icon svg {
		width: 26px !important;
		height: 26px !important;
	}
}

/* ══════════════════════════════════════════════════════════════
   BOTTOM SCROLL ROOM
   Appointment page is short — give the user runway to scroll past
   the destination grid so the last row doesn't sit flush with the
   footer/viewport edge.
   ══════════════════════════════════════════════════════════════ */
#colibri [data-colibri-id="44401-c1"] {
	padding-bottom: 320px !important;
}
@media (max-width: 767px) {
	#colibri [data-colibri-id="44401-c1"] {
		padding-bottom: 200px !important;
	}
}
</style>
	<?php
}, 99999 );
