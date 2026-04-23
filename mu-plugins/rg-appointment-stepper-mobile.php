<?php
/**
 * Plugin Name: RG Appointment Stepper Mobile Compact
 * Description: Mobile-only (<=767px) compact 4-across stepper on /appointment/
 *              (page 44401). Hides text labels, keeps number + icon. Reduces
 *              vertical space from ~400px stacked to ~110px horizontal strip.
 *              Desktop unaffected. Scoped to page-id-44401 only.
 * Version: 1.4.1
 * Created: 2026-04-23
 *
 * Rollback: delete this file. Stepper reverts to vertical stack on mobile.
 *
 * Revision log:
 *   1.0.0 — wrong selector (broken per CLAUDE.md Rule 8)
 *   1.1.0 — corrected selector, hid c9/c12/c15/c18 wholesale
 *   1.2.0 — preserved ::after representative icons (hid only h5 text)
 *   1.3.0 — divider polish: champagne gold short lines (was white full-height),
 *           vertically center number+icon group, bigger gap between them
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 44401 ) ) return;
	?>
	<style id="rg-appointment-stepper-mobile">
	@media (max-width: 767px) {
		/* Stepper row stays horizontal */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-row {
			flex-direction: row !important;
			flex-wrap: nowrap !important;
			justify-content: space-between !important;
			align-items: stretch !important;
		}
		/* 4 step-columns equal width */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-row > .h-column {
			flex: 0 0 25% !important;
			max-width: 25% !important;
			min-width: 0 !important;
		}
		/* Hide text labels inside heading — keep heading for ::after icon */
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"] h5,
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"] h5,
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"] h5,
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"] h5 {
			display: none !important;
		}
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"] {
			margin: 0 !important;
			padding: 0 !important;
			min-height: 0 !important;
		}
		/* Stepper container — compact */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] {
			padding: 14px 6px !important;
			margin-bottom: 24px !important;
		}
		/* Each step: push group down with bigger top padding, wider gap */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-column__inner {
			padding: 30px 4px 16px 4px !important;
			gap: 36px !important;
			align-items: center !important;
			justify-content: flex-start !important;
			flex-direction: column !important;
		}
		/* Number circle — perfectly square, centered */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-icon {
			width: 26px !important;
			height: 26px !important;
			min-width: 26px !important;
			min-height: 26px !important;
			margin: 0 auto !important;
			flex-shrink: 0 !important;
		}
		/* Representative icon (::after on heading divs) — square, centered, bigger */
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"]::after,
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"]::after,
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"]::after,
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"]::after {
			width: 24px !important;
			height: 24px !important;
			display: block !important;
			margin: 0 auto !important;
			background-size: contain !important;
			background-repeat: no-repeat !important;
			background-position: center !important;
		}
		/* DIVIDER: kill the default white full-height border, add short champagne line */
		body#colibri.page-id-44401 [data-colibri-id="44401-c7"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c10"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c13"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c16"] {
			border-right: none !important;
			border-left: none !important;
			position: relative !important;
		}
		/* Champagne gold divider — 50% height, vertically centered */
		body#colibri.page-id-44401 [data-colibri-id="44401-c7"]::before,
		body#colibri.page-id-44401 [data-colibri-id="44401-c10"]::before,
		body#colibri.page-id-44401 [data-colibri-id="44401-c13"]::before {
			content: "" !important;
			position: absolute !important;
			right: 0 !important;
			top: 25% !important;
			height: 50% !important;
			width: 1px !important;
			background-color: rgba(204, 197, 147, 0.5) !important;
			display: block !important;
		}
		/* Last column (c16) — no divider after */
		body#colibri.page-id-44401 [data-colibri-id="44401-c16"]::before {
			display: none !important;
		}
	}
	</style>
	<?php
}, 100000 );
