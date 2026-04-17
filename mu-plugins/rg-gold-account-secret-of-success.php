<?php
/**
 * Plugin Name: Rive Gosh — Gold Account "Secret of Success" Layout Fix
 * Description: Page 64453 (Gold Account, slug /golden-account/) has a "Secret of Success"
 *   section with three separate problems verified via Chrome DevTools MCP on 2026-04-17:
 *
 *   (1) INVISIBLE TEXT — the `<strong>` element wrapping "lifetime income affiliate tool"
 *       has inline style `color: rgb(33, 5, 5)` (near-black) baked into post_content.
 *       On the dark body `rgb(15, 12, 8)` it vanishes — reader sees only "A [gap] is a
 *       platform…". Same goes for the <ol> numerals: the OL computes to color `rgb(0,0,0)`
 *       so the "1./2./3." markers disappear on dark bg.
 *
 *   (2) LAYOUT — at desktop (≥992px) Colibri renders text column `c30-outer` on the LEFT
 *       and image column `c35-outer` on the RIGHT. Roderic wants the image on the LEFT
 *       and text on the RIGHT. Swap via flex `order` — no DOM restructure.
 *
 *   (3) IMAGE SIZE — the h-multiple-image `c36` is a 3-image collage. On desktop the
 *       column splits ~50/50 which makes the collage too tall relative to the text.
 *       Cap the image column to ~38% width and enforce aspect-ratio 1/1 to land it
 *       as a smaller square tile on the left.
 *
 *   Surgical: no DOM edits, no post_content rewrites, no removal of Colibri components.
 *   Fully reversible by deleting this file.
 *
 *   v1.1.0 — Added JS nuke pass (same pattern as rg-legacy-contrast-fixes.php).
 *       LiteSpeed critical-CSS beats CSS !important at paint-time; JS inline
 *       style.setProperty('…','important') is the final cascade layer and
 *       always wins. Fixes: strong text color + image height constraint.
 *
 * Version: 1.1.0 (2026-04-17)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 64453 ) ) return;
	?>
	<style id="rg-gold-account-sos-css">
	/* === (1) Fix invisible text inside c32 text block === */
	body.page-id-64453 .style-local-64453-c32,
	body.page-id-64453 .style-local-64453-c32 p,
	body.page-id-64453 .style-local-64453-c32 ol,
	body.page-id-64453 .style-local-64453-c32 ul,
	body.page-id-64453 .style-local-64453-c32 li,
	body.page-id-64453 .style-local-64453-c32 span,
	body.page-id-64453 .style-local-64453-c32 strong,
	body.page-id-64453 .style-local-64453-c32 em,
	body.page-id-64453 .style-local-64453-c32 b {
		color: rgba(240, 235, 225, 0.92) !important;
	}
	/* Emphasis — brighter gold for the previously-invisible <strong> tags */
	body.page-id-64453 .style-local-64453-c32 strong,
	body.page-id-64453 .style-local-64453-c32 b {
		color: #ccc593 !important;
	}
	/* OL numerals use ::marker pseudo; inherit from LI but force explicitly */
	body.page-id-64453 .style-local-64453-c32 ol li::marker,
	body.page-id-64453 .style-local-64453-c32 ul li::marker {
		color: #ccc593 !important;
	}
	/* Any anchor inside the block */
	body.page-id-64453 .style-local-64453-c32 a:not(.h-button) {
		color: #ccc593 !important;
		text-decoration: underline !important;
	}

	/* === (2) + (3) Desktop column swap + image size === */
	@media (min-width: 992px) {
		/* Ensure parent row is a flex container with ordering honored */
		body.page-id-64453 .style-local-64453-c29 > .h-row {
			display: flex !important;
			flex-direction: row !important;
			align-items: flex-start !important;
		}
		/* Image column → LEFT */
		body.page-id-64453 .style-local-64453-c29 .style-local-64453-c35-outer {
			order: 1 !important;
			flex: 0 0 38% !important;
			max-width: 38% !important;
		}
		/* Text column → RIGHT */
		body.page-id-64453 .style-local-64453-c29 .style-local-64453-c30-outer {
			order: 2 !important;
			flex: 1 1 auto !important;
			max-width: 62% !important;
		}
		/* Enforce square on the multi-image element */
		body.page-id-64453 .style-local-64453-c36 {
			aspect-ratio: 1 / 1 !important;
			max-width: 380px !important;
			margin-left: auto !important;
			margin-right: auto !important;
		}
	}
	</style>
	<script id="rg-gold-account-sos-js">
	(function () {
		function nukeGoldAccount() {
			// Fix 1: force strong / bold elements inside c32 to gold
			var c32 = document.querySelector('.style-local-64453-c32');
			if (c32) {
				var strongs = c32.querySelectorAll('strong, b, span[style]');
				for (var i = 0; i < strongs.length; i++) {
					strongs[i].style.setProperty('color', '#ccc593', 'important');
				}
				// OL / UL markers inherit from the list element
				var lists = c32.querySelectorAll('ol, ul');
				for (var j = 0; j < lists.length; j++) {
					lists[j].style.setProperty('color', 'rgba(240, 235, 225, 0.92)', 'important');
				}
			}

			// Fix 2: cap the h-multiple-image to a square ~380px tile
			var c36 = document.querySelector('.style-local-64453-c36');
			if (c36) {
				c36.style.setProperty('max-width',  '380px', 'important');
				c36.style.setProperty('max-height', '380px', 'important');
				c36.style.setProperty('overflow',   'hidden', 'important');
				c36.style.setProperty('aspect-ratio', '1 / 1', 'important');
				c36.style.setProperty('width',  '100%', 'important');
			}

			// Fix 3: image column should not stretch to row height — align to top
			var c35inner = document.querySelector('.style-local-64453-c35');
			if (c35inner) {
				c35inner.style.setProperty('align-self',      'flex-start', 'important');
				c35inner.style.setProperty('justify-content', 'flex-start', 'important');
			}
			var c35outer = document.querySelector('.style-local-64453-c35-outer');
			if (c35outer) {
				c35outer.style.setProperty('align-self', 'flex-start', 'important');
			}
		}

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', nukeGoldAccount);
		} else {
			nukeGoldAccount();
		}
	})();
	</script>
	<?php
}, 99999 );
