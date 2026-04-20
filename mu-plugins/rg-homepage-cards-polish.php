<?php
/**
 * Plugin Name: RG Homepage Cards Polish
 * Description: Homepage (page 61860) 3-card section — proper circles, bigger icons,
 *              title spacing, larger body copy, champagne-gold "Very Important Person" text.
 * Version: 1.5.0
 * Created: 2026-04-20
 *
 * DOM discovered via Chrome MCP (2026-04-20):
 *   Ancestor chain: c1 → c2 → c3 → c4/c9/c14 → c5/c10/c15 (icon)
 *                                            → c6/c11/c16 (heading)
 *                                            → c7/c12/c17 (divider)
 *                                            → c8/c13/c18 (body)
 *   c15 .h-svg-icon = visible gold circle
 *   c15 svg         = airplane/clock/star SVG
 *   c18 p strong    = "Very Important Person (VIP)" span
 *
 * SPECIFICITY BATTLE (v1.5.0 final):
 *   Colibri ships rules at (1,3,2) using:
 *     body#colibri.page-id-61860 [data-colibri-id="cX"] [data-colibri-id="cY"] p
 *   We beat that with (1,4,2) by chaining THREE nested data-colibri-id attrs:
 *     body#colibri.page-id-61860 [data-colibri-id="c3"] [data-colibri-id="cX"] [data-colibri-id="cY"] p
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function() {
	if ( ! is_front_page() ) return;

	echo '<style id="rg-homepage-cards-polish">';

	/* ─── CIRCLE: proper 1:1 aspect, slightly larger ─────────────── */
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c5"] .h-svg-icon, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c10"] .h-svg-icon, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c15"] .h-svg-icon { ';
	echo '  width: 50px !important; ';
	echo '  height: 50px !important; ';
	echo '  padding: 20px !important; ';
	echo '  box-sizing: content-box !important; ';
	echo '  aspect-ratio: 1 / 1 !important; ';
	echo '  display: inline-flex !important; ';
	echo '  align-items: center !important; ';
	echo '  justify-content: center !important; ';
	echo '  border-radius: 50% !important; ';
	echo '  line-height: 0 !important; ';
	echo '}';

	/* ─── ICON SVG: larger (was 22px) ────────────────────────────── */
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c5"] .h-svg-icon svg, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c10"] .h-svg-icon svg, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c15"] .h-svg-icon svg { ';
	echo '  width: 32px !important; ';
	echo '  height: 32px !important; ';
	echo '  flex-shrink: 0 !important; ';
	echo '}';

	/* ─── TITLE SPACING: ::before pseudo-injects gap above title ─── */
	/* Colibri sets c15 icon's margin via shorthand `margin: -70px ...px 10px ...px !important` */
	/* which beats any longhand margin-bottom override. Sidestep by adding */
	/* a spacer ::before on the heading (c6/c11/c16) — clean, no cascade fight. */
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c6"]::before, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c11"]::before, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c16"]::before { ';
	echo '  content: "" !important; ';
	echo '  display: block !important; ';
	echo '  height: 20px !important; ';
	echo '  width: 100% !important; ';
	echo '}';

	/* ─── BODY TEXT: larger + line-height (1,4,2) beats (1,3,2) ─── */
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c3"] [data-colibri-id="61860-c4"] [data-colibri-id="61860-c8"] p, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c3"] [data-colibri-id="61860-c9"] [data-colibri-id="61860-c13"] p, ';
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c3"] [data-colibri-id="61860-c14"] [data-colibri-id="61860-c18"] p { ';
	echo '  font-size: 16px !important; ';
	echo '  line-height: 1.7 !important; ';
	echo '}';

	/* ─── "VERY IMPORTANT PERSON" <strong>: champagne gold ───────── */
	echo '#colibri .style-local-61860-c18 p strong, ';
	echo '#colibri .style-local-61860-c18 strong { ';
	echo '  color: rgba(201, 169, 110, 1) !important; ';
	echo '  font-weight: 700 !important; ';
	echo '}';

	echo '</style>';
}, 99999 );
