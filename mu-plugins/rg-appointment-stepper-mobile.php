<?php
/**
 * Plugin Name: RG Appointment Stepper Mobile Compact
 * Description: Mobile-only (<=767px) compact 4-across stepper on /appointment/
 *              (page 44401). Hides text labels, keeps number + icon. Reduces
 *              vertical space from ~400px stacked to ~60px horizontal strip.
 *              Desktop unaffected. Scoped to page-id-44401 only.
 * Version: 1.1.0
 * Created: 2026-04-23
 *
 * Rollback: delete this file. Stepper reverts to vertical stack on mobile.
 *
 * v1.0.0 → v1.1.0 fix: v1.0 used `body.page-id-44401 #colibri` selector —
 * WRONG per CLAUDE.md Rule 8. Body has id=colibri, so descendant selector
 * matched nothing. v1.1 uses `body#colibri.page-id-44401` (SAME element).
 * Also switched from .style-865-outer to .h-column direct child (c16-outer
 * uses style-869-outer — would have been missed).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 44401 ) ) return;
	?>
	<style id="rg-appointment-stepper-mobile">
	@media (max-width: 767px) {
		/* Force stepper row to stay horizontal on mobile */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-row {
			flex-direction: row !important;
			flex-wrap: nowrap !important;
			justify-content: space-between !important;
			align-items: center !important;
		}
		/* All 4 step-column wrappers → 25% width (targets .h-column direct child) */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-row > .h-column {
			flex: 0 0 25% !important;
			max-width: 25% !important;
			min-width: 0 !important;
		}
		/* Hide text labels */
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"] {
			display: none !important;
		}
		/* Compact stepper container */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] {
			padding: 8px 6px !important;
			margin-bottom: 24px !important;
		}
		/* Tighten step-column internal spacing */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-column__inner {
			padding: 4px !important;
			gap: 6px !important;
		}
		/* Slightly smaller number-circle + icon */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-icon {
			width: 22px !important;
			height: 22px !important;
		}
	}
	</style>
	<?php
}, 100000 );
