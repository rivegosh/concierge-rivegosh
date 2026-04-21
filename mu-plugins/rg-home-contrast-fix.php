<?php
/**
 * Plugin Name: RG Home Contrast Fix
 * Description: Fixes inline-styled dark-on-dark body text and champagne-on-
 *              champagne button text on the home page (page-id-61860). Content
 *              was authored in the old "Top VIP Driver" site with a light bg,
 *              migrated to dark luxury Rive Gosh — inline styles like
 *              color: rgb(7,7,7) and color: rgb(26,25,24) now sit on a
 *              near-black section and are invisible (ratio 1.02–1.11).
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body#colibri.home.page-id-61860 ONLY (zero bleed).        ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Violations found by contrast scanner (2026-04-20):               ║
 * ║  - "means traveling beyond..." rgb(7,7,7) on dark  — 1.02:1      ║
 * ║  - "Exclusive Partnerships..."  #000  on dark       — 1.08:1      ║
 * ║  - "Access to the platform..."  rgb(26,25,24) dark  — 1.11:1      ║
 * ║  - "Get The Golden Account" champagne on champagne  — 1.00:1      ║
 * ║                                                                   ║
 * ║ Fix: override inline colors via :is() + high-specificity          ║
 * ║      selector targeting Colibri's style-NNNN slots.              ║
 * ║ Contrast after: champagne on dark ≈ 9:1 ✓ (WCAG AAA)             ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_front_page() && ! is_home() ) return;
	?>
	<style id="rg-home-contrast-fix">
	/* ==================================================================
	 * DARK TEXT ON DARK SECTIONS — override inline color styles
	 * The migrated Colibri h-text widgets still carry old inline colors
	 * from the light-bg era ("rgb(7,7,7)", "rgb(26,25,24)", "#000").
	 * Force champagne for readability.
	 * ================================================================== */
	body#colibri.home.page-id-61860 .h-text.style-2897,
	body#colibri.home.page-id-61860 .h-text.style-2897 p,
	body#colibri.home.page-id-61860 .h-text.style-2897 p span,
	body#colibri.home.page-id-61860 .h-text.style-2897 p strong,
	body#colibri.home.page-id-61860 .h-text.style-2978,
	body#colibri.home.page-id-61860 .h-text.style-2978 p,
	body#colibri.home.page-id-61860 .h-text.style-2978 p span,
	body#colibri.home.page-id-61860 .h-text.style-2978 p strong,
	body#colibri.home.page-id-61860 .h-text.style-3000,
	body#colibri.home.page-id-61860 .h-text.style-3000 p,
	body#colibri.home.page-id-61860 .h-text.style-3000 p span,
	body#colibri.home.page-id-61860 .h-text.style-3000 p strong,
	body#colibri.home.page-id-61860 .h-text.style-3000 p em {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* Broad backstop — any h-text paragraph on home with inline style
	   pointing to a dark color (rgb values < 50 all three) */
	body#colibri.home.page-id-61860 .h-text [style*="color: rgb(0"],
	body#colibri.home.page-id-61860 .h-text [style*="color:rgb(0"],
	body#colibri.home.page-id-61860 .h-text [style*="color: rgb(7"],
	body#colibri.home.page-id-61860 .h-text [style*="color:rgb(7"],
	body#colibri.home.page-id-61860 .h-text [style*="color: rgb(26"],
	body#colibri.home.page-id-61860 .h-text [style*="color:rgb(26"],
	body#colibri.home.page-id-61860 .h-text [style*="color: #000"],
	body#colibri.home.page-id-61860 .h-text [style*="color:#000"],
	body#colibri.home.page-id-61860 .h-text [style*="color: #111"],
	body#colibri.home.page-id-61860 .h-text [style*="color:#111"] {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* Bare <p> tags inside h-text that computed as pure black
	   (no inline style but theme default black) */
	body#colibri.home.page-id-61860 .h-text p:not([style]) {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* ==================================================================
	 * "GET THE GOLDEN ACCOUNT" — champagne on champagne button
	 * The Colibri h-link (style-2958 / style-2966) has a champagne
	 * background but the text is ALSO champagne at 0.85 opacity (1.0:1).
	 * Force dark text.
	 * ================================================================== */
	body#colibri.home.page-id-61860 a.h-link.style-2958,
	body#colibri.home.page-id-61860 a.h-link.style-2958 span,
	body#colibri.home.page-id-61860 a.h-link.style-2966,
	body#colibri.home.page-id-61860 a.h-link.style-2966 span {
		color: #0f0c08 !important;
		font-weight: 600 !important;
	}

	/* Defensive — catch any other golden-account button variants */
	body#colibri.home.page-id-61860 a.h-link[style*="background-color: rgb(204"],
	body#colibri.home.page-id-61860 a.h-link[style*="background:rgb(204"],
	body#colibri.home.page-id-61860 a.h-link[style*="background-color:#CCC593"],
	body#colibri.home.page-id-61860 a.h-link[style*="background: #CCC593"] {
		color: #0f0c08 !important;
	}
	body#colibri.home.page-id-61860 a.h-link[style*="background-color: rgb(204"] span,
	body#colibri.home.page-id-61860 a.h-link[style*="background:rgb(204"] span,
	body#colibri.home.page-id-61860 a.h-link[style*="background-color:#CCC593"] span,
	body#colibri.home.page-id-61860 a.h-link[style*="background: #CCC593"] span {
		color: #0f0c08 !important;
	}
	</style>
	<?php
}, 99998 );
