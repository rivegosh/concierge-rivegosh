<?php
/**
 * Plugin Name: RG Appointment Stepper Mobile Compact
 * Description: Mobile-only (<=767px) compact 4-across stepper on /appointment/
 *              (page 44401). Hides text labels, keeps number + icon. Reduces
 *              vertical space from ~400px stacked to ~60px horizontal strip.
 *              Desktop unaffected. Scoped to page-id-44401 only.
 * Version: 1.2.0
 * Created: 2026-04-23
 *
 * Rollback: delete this file. Stepper reverts to vertical stack on mobile.
 *
 * Revision log:
 *   1.0.0 — WRONG SELECTOR (body.page-id-X #colibri pattern, broken per Rule 8)
 *   1.1.0 — corrected to body#colibri.page-id-44401, display:none on c9/c12/c15/c18
 *           → but this killed the representative icons (plane/car/cal/person)
 *           because sealed plugin renders them via ::after on those same elements
 *   1.2.0 — hide only the h5 text (which has ::before text content) so the
 *           parent div's ::after icon still renders. Add explicit alignment.
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
			align-items: stretch !important;
		}
		/* All 4 step-column wrappers → 25% width */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-row > .h-column {
			flex: 0 0 25% !important;
			max-width: 25% !important;
			min-width: 0 !important;
		}
		/* Hide only the h5 text elements (keep parent .h-heading so ::after icon renders) */
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"] h5,
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"] h5,
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"] h5,
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"] h5 {
			display: none !important;
		}
		/* Heading wrapper: collapse height to just icon ::after */
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"],
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"] {
			margin: 0 !important;
			padding: 0 !important;
			min-height: 0 !important;
		}
		/* Compact stepper container */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] {
			padding: 10px 6px !important;
			margin-bottom: 24px !important;
		}
		/* Each step's vertical stack — tight, centered */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-column__inner {
			padding: 4px 2px !important;
			gap: 8px !important;
			align-items: center !important;
			justify-content: center !important;
			flex-direction: column !important;
		}
		/* Number circle — square, centered */
		body#colibri.page-id-44401 [data-colibri-id="44401-c6"] .h-icon {
			width: 26px !important;
			height: 26px !important;
			min-width: 26px !important;
			margin: 0 auto !important;
			flex-shrink: 0 !important;
		}
		/* ::after icons (plane/car/cal/person) — explicit size for mobile */
		body#colibri.page-id-44401 [data-colibri-id="44401-c9"]::after,
		body#colibri.page-id-44401 [data-colibri-id="44401-c12"]::after,
		body#colibri.page-id-44401 [data-colibri-id="44401-c15"]::after,
		body#colibri.page-id-44401 [data-colibri-id="44401-c18"]::after {
			width: 22px !important;
			height: 22px !important;
			display: block !important;
			margin: 0 auto !important;
		}
	}
	</style>
	<?php
}, 100000 );
