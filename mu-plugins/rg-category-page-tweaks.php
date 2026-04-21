<?php
/**
 * Plugin Name: Rive Gosh — Amelia Category Page Tweaks
 * Description: On Amelia category listing pages (All Transfers Washington DC, NY, etc.):
 *   (1) clamps the oversized page-title heading — Colibri's per-page style class has no
 *   desktop override, so it falls through to body h2{3em}. Scope: body:has(.am-cat__wrapper)
 *   to auto-apply on every Amelia category page; :not([class*="style-local-61866-"]) excludes
 *   the shared "Your Destination" sub-heading (which lives in template-block page 61866).
 *   (2) hides .am-fcil__filter — the Amelia services search input is noise on a curated catalog.
 * Version: 1.0.0 (2026-04-17)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-category-page-tweaks-css">
	body:has(.am-cat__wrapper) .h-heading__outer:not([class*="style-local-61866-"]) h1,
	body:has(.am-cat__wrapper) .h-heading__outer:not([class*="style-local-61866-"]) h2,
	body:has(.am-cat__wrapper) .h-heading__outer:not([class*="style-local-61866-"]) h3 {
		font-size: clamp(26px, 4.5vw, 52px) !important;
		line-height: 1.25 !important;
	}
	.am-fcil__filter { display: none !important; }
	</style>
	<?php
}, 99999 );
