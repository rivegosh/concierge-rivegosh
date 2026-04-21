<?php
/**
 * Plugin Name: RG Appointment Destinations
 * Description: Adds "Other Destinations on Demand" button below the destination grid
 *              on /appointment/ (page-id-44401). Links to /transfer-request/ (page 72053).
 *              Chicago card removed per Daniel request (2026-04-23).
 * Version: 1.1.0
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

		var OTHER_BTN =
			'<div id="rg-other-destinations">' +
				'<a href="https://rivegosh-concierge.com/transfer-request/">' +
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295 233.6V120c0-13.3-10.7-24-24-24s-24 10.7-24 24v128c0 6.4 2.5 12.5 7 17l73.9 73.9c9.4 9.4 24.6 9.4 33.9 0 9.4-9.4 9.4-24.6.1-34z"/></svg>' +
					'Other Destinations — On Demand' +
				'</a>' +
			'</div>';

		function inject() {
			/* Find any BOOK link pointing to a transfer state page */
			var links = document.querySelectorAll('a[href*="all-transfers-airports-area"]');
			if (!links.length) return;

			/* Walk up to the parent h-section */
			var section = null;
			for (var i = 0; i < links.length; i++) {
				var el = links[i];
				while (el && !el.classList.contains('h-section')) el = el.parentElement;
				if (el && el.classList.contains('h-section')) { section = el; break; }
			}
			if (!section) return;

			/* Append "Other Destinations" button after the section */
			if (!document.getElementById('rg-other-destinations')) {
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
