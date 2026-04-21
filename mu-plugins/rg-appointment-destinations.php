<?php
/**
 * Plugin Name: RG Appointment Destinations
 * Description: Two additions to the /appointment/ (page-id-44401) destination grid:
 *              1. CHICAGO card — page /all-transfers-airports-area-chicago-usa/
 *                 exists and is published but was never added to the Colibri grid.
 *                 Injected via JS to match existing h-col-lg-3 card structure exactly.
 *              2. "Other Destinations on Demand" button — /transfer-request/ page
 *                 (page 72053) exists but has no entry point from /appointment/.
 *                 Added as a full-width champagne CTA below the destination grid.
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.page-id-44401 ONLY.                                  ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 44401 ) ) return;
	?>
	<style id="rg-appointment-destinations">

	/* ==================================================================
	 * INJECTED CHICAGO CARD — inherit existing card styles
	 *  The Colibri styles (style-2568, style-2569, style-2570, style-2573)
	 *  already cover the card chrome. We only need the layout wrapper
	 *  to match the existing h-col-lg-3 columns.
	 * ================================================================== */
	.rg-chicago-card {
		display: flex;
	}

	/* ==================================================================
	 * "OTHER DESTINATIONS ON DEMAND" CTA BUTTON BLOCK
	 *  Sits below the destination grid. Full-width champagne ghost button
	 *  that links to /transfer-request/.
	 * ================================================================== */
	#rg-other-destinations {
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 32px 24px 48px;
	}
	#rg-other-destinations a {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		padding: 16px 40px;
		border: 1.5px solid rgba(204, 197, 147, 0.6);
		color: rgba(204, 197, 147, 0.92) !important;
		font-size: 13px !important;
		font-weight: 700;
		letter-spacing: 0.1em;
		text-transform: uppercase;
		text-decoration: none !important;
		background: rgba(204, 197, 147, 0.06);
		transition: background 0.2s, border-color 0.2s;
	}
	#rg-other-destinations a:hover {
		background: rgba(204, 197, 147, 0.14);
		border-color: rgba(204, 197, 147, 0.9);
	}
	#rg-other-destinations svg {
		width: 16px;
		height: 16px;
		fill: rgba(204, 197, 147, 0.85);
		flex-shrink: 0;
	}

	</style>
	<!--noptimize--><script id="rg-appointment-destinations-js">
	(function () {

		var PLANE_SVG = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M384 336l-160-48v114l48 31v31l-80-16-80 16v-31l48-31V288L0 336v-40l160-104V79c0-18 15-31 32-31s32 13 32 31v113l160 104v40z"></path></svg>';

		var CHICAGO_CARD =
			'<div class="h-column h-column-container d-flex h-col-lg-3 h-col-md-6 h-col-12 style-2568-outer rg-chicago-card">' +
				'<div class="d-flex h-flex-basis h-column__inner h-px-lg-3 h-px-md-3 h-px-3 v-inner-lg-3 v-inner-md-3 v-inner-3 style-2568 position-relative">' +
					'<div class="background-wrapper">' +
						'<div class="background-layer background-layer-media-container-lg"><div class="overlay-layer"><div class="overlay-image-layer"></div><div class="shape-layer colibri-shape-many-rounded-squares-blue" style="background-position:center center;background-size:cover;background-repeat:no-repeat;filter:invert(0%)"></div></div></div>' +
						'<div class="background-layer background-layer-media-container-md"><div class="overlay-layer"><div class="overlay-image-layer"></div><div class="shape-layer colibri-shape-many-rounded-squares-blue" style="background-position:center center;background-size:cover;background-repeat:no-repeat;filter:invert(0%)"></div></div></div>' +
						'<div class="background-layer background-layer-media-container"><div class="overlay-layer"><div class="overlay-image-layer"></div><div class="shape-layer colibri-shape-many-rounded-squares-blue" style="background-position:center center;background-size:cover;background-repeat:no-repeat;filter:invert(0%)"></div></div></div>' +
					'</div>' +
					'<div class="w-100 h-y-container h-column__content h-column__v-align flex-basis-100 align-self-lg-center align-self-md-center align-self-center">' +
						'<div class="h-icon style-2569 position-relative h-element">' +
							'<span class="h-svg-icon h-icon__icon style-2569-icon">' + PLANE_SVG + '</span>' +
						'</div>' +
						'<div class="h-global-transition-all h-heading style-2570 position-relative h-element">' +
							'<div class="h-heading__outer style-2570"><h4>CHICAGO</h4></div>' +
						'</div>' +
						'<div class="h-x-container style-2572 position-relative h-element">' +
							'<div class="h-x-container-inner style-2572-spacing">' +
								'<span class="h-button__outer style-2573-outer d-inline-flex h-element">' +
									'<a href="https://rivegosh-concierge.com/all-transfers-airports-area-chicago-usa/" class="d-flex w-100 align-items-center h-button justify-content-lg-center justify-content-md-center justify-content-center style-2573 position-relative">' +
										'<span>BOOK</span>' +
									'</a>' +
								'</span>' +
							'</div>' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>';

		var OTHER_BTN =
			'<div id="rg-other-destinations">' +
				'<a href="https://rivegosh-concierge.com/transfer-request/">' +
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295 233.6V120c0-13.3-10.7-24-24-24s-24 10.7-24 24v128c0 6.4 2.5 12.5 7 17l73.9 73.9c9.4 9.4 24.6 9.4 33.9 0 9.4-9.4 9.4-24.6.1-34z"/></svg>' +
					'Other Destinations — On Demand' +
				'</a>' +
			'</div>';

		function inject() {
			/* Find the destination grid row: the h-row that contains BOOK buttons
			   linking to /all-transfers-airports-area-* URLs */
			var links = document.querySelectorAll('a[href*="all-transfers-airports-area"]');
			if (!links.length) return;

			/* Walk up to the parent h-row */
			var row = null;
			for (var i = 0; i < links.length; i++) {
				var el = links[i];
				while (el && !el.classList.contains('h-row')) el = el.parentElement;
				if (el && el.classList.contains('h-row')) { row = el; break; }
			}
			if (!row) return;

			/* Skip if already injected */
			if (row.querySelector('.rg-chicago-card')) return;

			/* Append Chicago card to the row */
			var tmp = document.createElement('div');
			tmp.innerHTML = CHICAGO_CARD;
			row.appendChild(tmp.firstElementChild);

			/* Append "Other Destinations" button after the row's grandparent section */
			var section = row;
			while (section && section.tagName !== 'SECTION' && !section.classList.contains('h-section')) {
				section = section.parentElement;
			}
			if (section && !document.getElementById('rg-other-destinations')) {
				var btnDiv = document.createElement('div');
				btnDiv.innerHTML = OTHER_BTN;
				section.parentElement.insertBefore(btnDiv.firstElementChild, section.nextSibling);
			}
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', inject);
		} else {
			inject();
		}
	})();
	</script><!--/noptimize-->
	<?php
}, 100011 );
