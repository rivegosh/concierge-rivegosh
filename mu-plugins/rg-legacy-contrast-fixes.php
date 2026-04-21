<?php
/**
 * Plugin Name: Rive Gosh — Legacy Contrast Fixes
 * Description: Eradicates two legacy design regressions that block readability on the
 *   dark-themed Rive Gosh skin:
 *   (1) Legacy white diagonal-pattern bg image (transportation-services-01-*.png) still
 *       referenced by 23 published pages (Gold Account, Access Membership, Innovation Story,
 *       Transfer Request, Appointment, etc.). On the dark skin it renders as a white
 *       slab that makes the gold body copy invisible. We scan the CSSOM on load and
 *       inline-override any element still using that image URL.
 *   (2) WCFM progress step indicator (Plans / Registration / Confirmation / Thank You)
 *       uses color #2a3344 (dark navy) for .active and .done states — invisible on the
 *       dark body. Replace with white text + gold border/dot to match brand.
 *   (3) v1.1.0 — ROOT-CAUSE SWEEP across 20+ broken pages. Six selectors repair them all:
 *       - `.woocommerce-page .content .h-section { background: rgb(245,250,253) }` —
 *         Colibri's default WC section bg (light-blue). Affects Innovation Story,
 *         Multi-Level Affiliate, Private Driver, VIP Events, Access Membership, etc.
 *       - `.overlay-image-layer` — wrapper leftover from legacy bg image; collapses
 *         to white once the image is removed. Seen on Innovation Story.
 *       - `.h-pricing-item__inner` — Colibri pricing card default white bg. Access
 *         Membership has 3 cards; Gold Account / Membership Pricing likely too.
 *       - `.am-empty`, `.am-elf` — Amelia empty-state / list-filter panels. Seen on
 *         Luxury Room, Ultra Luxury Cars, Gastronomy, Premium Brands, Tourism,
 *         Book-a-Ride NY, Luxury Ski Resort, Palace Hotel, VIP Events.
 *       - `body.woocommerce-page .h-column__inner` — dangling white columns inside
 *         Amelia service pages (Colibri col has explicit white fill).
 *       The JS nuke pass now also transparents any `.h-column__inner` / `.h-section`
 *       inside a `.woocommerce-page` body that still computes to near-white.
 *   NOTE: Does NOT touch the Booking Pro Panel / Professional Dashboard routes.
 * Version: 1.1.1 (2026-04-17)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	// Never run inside the WCFM vendor dashboard (professional panel)
	if ( function_exists( 'wcfm_is_vendor_page' ) && wcfm_is_vendor_page() ) return;
	?>
	<style id="rg-legacy-contrast-css">
	/* WCFM progress steps: dark navy → white/gold for visibility on dark bg */
	.wcfm-membership-wrapper .wc-progress-steps li.done,
	.wcfm-membership-wrapper .wc-progress-steps li.active,
	.woocommerce-progress-form-wrapper .wc-progress-steps li.done,
	.woocommerce-progress-form-wrapper .wc-progress-steps li.active {
		color: #ffffff !important;
		border-color: #ccc593 !important;
	}
	.wcfm-membership-wrapper .wc-progress-steps li.done::before,
	.wcfm-membership-wrapper .wc-progress-steps li.active::before,
	.woocommerce-progress-form-wrapper .wc-progress-steps li.done::before,
	.woocommerce-progress-form-wrapper .wc-progress-steps li.active::before {
		border-color: #ccc593 !important;
		background: #ccc593 !important;
	}
	/* Lift inactive step color slightly for a11y (was dim-gold on black) */
	.wcfm-membership-wrapper .wc-progress-steps,
	.woocommerce-progress-form-wrapper .wc-progress-steps {
		color: #e0d9b8 !important;
	}

	/* ========== v1.1.0 ROOT-CAUSE SWEEP ========== */

	/* (A) Colibri global WC section bg (light-blue #f5fafd) → dark body shows through */
	.woocommerce-page .content .h-section,
	.woocommerce-page .content .h-section-global-spacing {
		background: transparent !important;
	}

	/* (B) Legacy image overlay wrapper — collapses to white once bg-image is stripped */
	.overlay-image-layer {
		background: transparent !important;
	}

	/* (C) Pricing cards — DEFERRED to source-level fix.
	 *   Attempted cascade override of `.h-pricing-item__inner` bg on page 70698
	 *   (Access Membership) fails: even inline !important styles are reset to
	 *   CSS-initial values. Neither CSSOM nor DevTools exposes the winning rule.
	 *   Likely LiteSpeed critical-CSS injection or a constructible stylesheet
	 *   attaching via a mechanism outside document.styleSheets. Forcing white
	 *   text as we originally did makes cards unreadable when the bg override
	 *   fails — so the pricing-card bg/text overrides are removed. Colibri's
	 *   default (white card + dark text) remains readable on any page.
	 *   Follow-up: edit the page's Colibri JSON on disk to change the card
	 *   bg at source rather than fighting runtime cascade. */

	/* (D) Amelia empty-state / list-filter panels — default white → transparent gold */
	.am-empty,
	.am-elf,
	.am-empty *,
	.am-elf * {
		background: transparent !important;
	}
	.am-empty,
	.am-elf {
		color: #e0d9b8 !important;
		border-color: rgba(204, 197, 147, 0.3) !important;
	}

	/* (E) Dangling white h-column__inner inside WC/Amelia pages */
	body.woocommerce-page .h-column__inner,
	body:has(.am-empty) .h-column__inner,
	body:has(.am-elf) .h-column__inner,
	body:has(.am-cat__wrapper) .h-column__inner {
		background-color: transparent !important;
	}
	</style>
	<script id="rg-legacy-contrast-js">
	(function () {
		var BAD = 'transportation-services-01';
		function nuke() {
			// Pass 1: rewrite any CSS rule (recursing into @media) that references the legacy image
			function walk(rules) {
				for (var i = 0; i < rules.length; i++) {
					var r = rules[i];
					if (r.type === 1) {
						var bg = r.style && r.style.backgroundImage;
						if (bg && bg.indexOf(BAD) !== -1) {
							r.style.setProperty('background-image', 'none', 'important');
						}
					} else if (r.type === 4 || r.type === 12) {
						try { walk(r.cssRules); } catch (e) {}
					}
				}
			}
			var sheets = document.styleSheets;
			for (var s = 0; s < sheets.length; s++) {
				try { walk(sheets[s].cssRules); } catch (e) {}
			}
			// Pass 2: catch anything still rendered with that computed background
			var all = document.querySelectorAll('*');
			for (var j = 0; j < all.length; j++) {
				try {
					var cs = getComputedStyle(all[j]);
					if (cs.backgroundImage && cs.backgroundImage.indexOf(BAD) !== -1) {
						all[j].style.setProperty('background-image', 'none', 'important');
					}
				} catch (e) {}
			}

			// Pass 3 (v1.1.0): on WC/Amelia pages, transparent any h-column__inner /
			//   h-section / h-text still computing to near-white (handles Colibri
			//   per-page style-local-* rules we can't reach via selector).
			var isDarkPage = document.body.classList.contains('woocommerce-page')
				|| document.querySelector('.am-empty, .am-elf, .am-cat__wrapper');
			if (isDarkPage) {
				var darkTargets = document.querySelectorAll(
					'.h-column__inner, .h-section, .h-text, .overlay-image-layer'
				);
				for (var k = 0; k < darkTargets.length; k++) {
					try {
						var csd = getComputedStyle(darkTargets[k]);
						var m = csd.backgroundColor.match(/rgba?\(([^)]+)\)/);
						if (!m) continue;
						var parts = m[1].split(',').map(function(x){ return parseFloat(x); });
						var r = parts[0], g = parts[1], b = parts[2];
						var a = parts.length > 3 ? parts[3] : 1;
						if (a > 0.5 && r > 230 && g > 230 && b > 230) {
							// Skip partner logo gallery (legit white for logos)
							if (darkTargets[k].closest('.h-photo-gallery')) continue;
							darkTargets[k].style.setProperty('background-color', 'transparent', 'important');
						}
					} catch (e) {}
				}
			}
		}
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', nuke);
		} else {
			nuke();
		}
	})();
	</script>
	<?php
}, 99999 );
