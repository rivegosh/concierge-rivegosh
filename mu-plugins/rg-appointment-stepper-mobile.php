<?php
/**
 * Plugin Name: RG Appointment Stepper Mobile Compact
 * Description: Mobile-only (<=767px) compact 4-across stepper on /appointment/
 *              (page 44401). Hides text labels, keeps number + icon. Reduces
 *              vertical space from ~400px stacked to ~60px horizontal strip.
 *              Desktop unaffected. Scoped to page-id-44401 only.
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * Rollback: delete this file. Stepper reverts to vertical stack on mobile.
 *
 * Priority 100000 (after sealed rg-appointment-redesign.php at default 10)
 * — our CSS appears later in HTML, wins on equal-specificity tiebreak.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 44401 ) ) return;
	?>
	<style id="rg-appointment-stepper-mobile">
	@media (max-width: 767px) {
		/* Force stepper row to stay horizontal on mobile (Colibri default: stack) */
		body.page-id-44401 #colibri [data-colibri-id="44401-c6"] .h-row {
			flex-direction: row !important;
			flex-wrap: nowrap !important;
			justify-content: space-between !important;
			align-items: center !important;
		}
		/* Each of the 4 step-column wrappers → 25% width (no full-width stack) */
		body.page-id-44401 #colibri [data-colibri-id="44401-c6"] .style-865-outer {
			flex: 0 0 25% !important;
			max-width: 25% !important;
			min-width: 0 !important;
		}
		/* Hide text labels (CHOOSE DESTINATION / SELECT YOUR CAR / etc) */
		body.page-id-44401 #colibri [data-colibri-id="44401-c9"],
		body.page-id-44401 #colibri [data-colibri-id="44401-c12"],
		body.page-id-44401 #colibri [data-colibri-id="44401-c15"],
		body.page-id-44401 #colibri [data-colibri-id="44401-c18"] {
			display: none !important;
		}
		/* Compact the stepper container */
		body.page-id-44401 #colibri [data-colibri-id="44401-c6"] {
			padding: 8px 6px !important;
			margin-bottom: 24px !important;
		}
		/* Tighten internal spacing within each step column */
		body.page-id-44401 #colibri [data-colibri-id="44401-c6"] .h-column__inner {
			padding: 4px !important;
			gap: 6px !important;
		}
		/* Slightly smaller number-circle + icon */
		body.page-id-44401 #colibri [data-colibri-id="44401-c6"] .h-icon {
			width: 22px !important;
			height: 22px !important;
		}
	}
	</style>
	<?php
}, 100000 );
