<?php
/**
 * Plugin Name: Rive Gosh — Misc CSS / Page Tweaks
 * Description: Consolidates four non-critical CSS-injection files that share no
 *   page overlap and have no protected-file banners. Merged 2026-04-20. Ref: #65.
 *
 *   Sections:
 *   (A) Legacy Contrast Fixes — WCFM progress steps + white bg sweeps across 20+
 *       pages. Skipped on vendor dashboard. (was rg-legacy-contrast-fixes.php v1.1.1)
 *   (B) Amelia Category Page Tweaks — heading clamp + hide filter input.
 *       (was rg-category-page-tweaks.php v1.0.0)
 *   (C) Account Page Layout — UM account (page 73404) column spread.
 *       (was rg-account-layout.php v1.1.0)
 *   (D) Gold Account "Secret of Success" Layout Fix — page 64453 invisible text +
 *       column swap + image size. (was rg-gold-account-secret-of-success.php v1.3.0)
 *
 * Version: 1.0.0 (2026-04-20)
 * GitHub: rivegosh/concierge-rivegosh#65
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {

	// =========================================================================
	// (A) LEGACY CONTRAST FIXES
	// Skip on the WCFM vendor dashboard — those pages handle their own styles.
	// =========================================================================
	if ( ! function_exists( 'wcfm_is_vendor_page' ) || ! wcfm_is_vendor_page() ) :
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
	/* Lift inactive step color slightly for a11y */
	.wcfm-membership-wrapper .wc-progress-steps,
	.woocommerce-progress-form-wrapper .wc-progress-steps {
		color: #e0d9b8 !important;
	}

	/* (A1) Colibri global WC section bg (light-blue #f5fafd) → dark body shows through */
	.woocommerce-page .content .h-section,
	.woocommerce-page .content .h-section-global-spacing {
		background: transparent !important;
	}

	/* (A2) Legacy image overlay wrapper — collapses to white once bg-image is stripped */
	.overlay-image-layer {
		background: transparent !important;
	}

	/* (A3) Amelia empty-state / list-filter panels — default white → transparent gold */
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

	/* (A4) Dangling white h-column__inner inside WC/Amelia pages */
	body.woocommerce-page .h-column__inner,
	body:has(.am-empty) .h-column__inner,
	body:has(.am-elf) .h-column__inner,
	body:has(.am-cat__wrapper) .h-column__inner {
		background-color: transparent !important;
	}

	/* ── Nav sub-menu fallback: WC pages missing h-dropdown-menu class ──
	   Root cause: Colibri omits h-dropdown-menu + h-menu-horizontal on
	   .h-menu on WooCommerce pages. Without those classes, the Colibri
	   rules (.h-dropdown-menu>...{opacity:0}) don't match and sub-menus
	   stay visible and position:static (pushing content down).
	   This rule replicates the behaviour without requiring those classes.
	   On pages that DO have h-dropdown-menu, Colibri's higher-specificity
	   rule takes precedence — this is a silent fallback only. */
	.h-menu > div > .colibri-menu-container > ul.colibri-menu li.menu-item-has-children {
		position: relative;
	}
	.h-menu > div > .colibri-menu-container > ul.colibri-menu li > ul.sub-menu {
		position: absolute;
		top: 100%;
		left: 0;
		z-index: 99999;
		opacity: 0;
		pointer-events: none;
		transition: opacity 0.15s ease;
		min-width: 200px;
	}
	.h-menu > div > .colibri-menu-container > ul.colibri-menu li.menu-item-has-children:hover > ul.sub-menu {
		opacity: 1;
		pointer-events: auto;
	}
	/* Colibri omits has-offcanvas-mobile class on WC pages → hamburger
	   icon renders at full column height on desktop. Hide it above tablet. */
	@media (min-width: 992px) {
		.h-hamburger-button { display: none !important; }
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

			// Pass 3: on WC/Amelia pages, transparent any h-column__inner /
			//   h-section / h-text still computing to near-white
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
	endif; // end vendor-dashboard guard

	// =========================================================================
	// (B) AMELIA CATEGORY PAGE TWEAKS
	// CSS :has selector scopes these rules to Amelia category pages automatically.
	// =========================================================================
	?>
	<style id="rg-category-page-tweaks-css">
	body:has(.am-cat__wrapper) .h-heading__outer:not([class*="style-local-61866-"]) h1,
	body:has(.am-cat__wrapper) .h-heading__outer:not([class*="style-local-61866-"]) h2,
	body:has(.am-cat__wrapper) .h-heading__outer:not([class*="style-local-61866-"]) h3 {
		font-size: clamp(26px, 4.5vw, 52px) !important;
		line-height: 1.25 !important;
	}
	.am-fcil__filter { display: none !important; }
	/* Remove white photographer backdrop from catalog card images via CSS.
	   multiply: white(255)×dark-bg≈dark, black-car(0)×anything=0. No img edit needed. */
	.am-fcil__item-hero { mix-blend-mode: multiply; }
	</style>

	<?php
	// =========================================================================
	// (C) ACCOUNT PAGE LAYOUT — page 73404 only
	// =========================================================================
	if ( is_page( 73404 ) ) :
	?>
	<style id="rg-account-layout-css">
	/* Desktop (>= 992px): three-column spread */
	@media (min-width: 992px) {
		body.page-id-73404 #post-73404 .um-form {
			margin-left: 28px !important;
			margin-right: 0 !important;
			width: auto !important;
			max-width: none !important;
		}
		body.page-id-73404 #post-73404 .um-account-side {
			width: 280px !important;
			max-width: 280px !important;
		}
		body.page-id-73404 #post-73404 .um-account-main {
			width: 540px !important;
			max-width: 540px !important;
			margin-left: 80px !important;
		}
		body.page-id-73404 #post-73404 .um-account-main input[type="text"],
		body.page-id-73404 #post-73404 .um-account-main input[type="email"],
		body.page-id-73404 #post-73404 .um-account-main input[type="password"],
		body.page-id-73404 #post-73404 .um-account-main input[type="tel"] {
			width: 100% !important;
			max-width: 100% !important;
		}
	}

	/* Mobile (< 992px): balanced padding */
	@media (max-width: 991px) {
		body.page-id-73404 #post-73404 .um-form {
			margin-left: 22px !important;
			margin-right: 22px !important;
			width: auto !important;
			max-width: none !important;
		}
	}
	</style>
	<?php
	endif; // end page 73404

	// =========================================================================
	// (D) GOLD ACCOUNT "SECRET OF SUCCESS" — page 64453 only
	// NOTE: JS uses <!--noptimize--> to prevent LiteSpeed from rewriting the
	//   script tag (LiteSpeed rewrites DOMContentLoaded → DOMContentLiteSpeedLoaded
	//   on inline scripts, silently preventing execution).
	// =========================================================================
	if ( is_page( 64453 ) ) :
	?>
	<style id="rg-gold-account-sos-css">
	/* (D1) Fix invisible text inside c32 text block */
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
	/* Gold emphasis for previously-invisible <strong> tags */
	body.page-id-64453 .style-local-64453-c32 strong,
	body.page-id-64453 .style-local-64453-c32 b {
		color: #ccc593 !important;
	}
	body.page-id-64453 .style-local-64453-c32 ol li::marker,
	body.page-id-64453 .style-local-64453-c32 ul li::marker {
		color: #ccc593 !important;
	}
	body.page-id-64453 .style-local-64453-c32 a:not(.h-button) {
		color: #ccc593 !important;
		text-decoration: underline !important;
	}

	/* (D2) + (D3) Desktop column swap + image size */
	@media (min-width: 992px) {
		body.page-id-64453 .style-local-64453-c29 > .h-row {
			display: flex !important;
			flex-direction: row !important;
			align-items: flex-start !important;
		}
		body.page-id-64453 .style-local-64453-c29 .style-local-64453-c35-outer {
			order: 1 !important;
			flex: 0 0 38% !important;
			max-width: 38% !important;
		}
		body.page-id-64453 .style-local-64453-c29 .style-local-64453-c30-outer {
			order: 2 !important;
			flex: 1 1 auto !important;
			max-width: 62% !important;
		}
		body.page-id-64453 .style-local-64453-c36 {
			max-width: 380px !important;
			max-height: 380px !important;
			width: 100% !important;
			overflow: hidden !important;
			margin-left: auto !important;
			margin-right: auto !important;
		}
		body.page-id-64453 .style-local-64453-c36 img {
			width: 100% !important;
			height: 100% !important;
			object-fit: cover !important;
		}
		body.page-id-64453 .style-local-64453-c36 .h-multiple-image-inside-container,
		body.page-id-64453 .style-local-64453-c36 .ratio-inner {
			max-height: 380px !important;
			overflow: hidden !important;
		}
	}
	</style>
	<!--noptimize--><script id="rg-gold-account-sos-js">
	(function () {
		function nukeGoldAccount() {
			var c32 = document.querySelector('.style-local-64453-c32');
			if (c32) {
				var strongs = c32.querySelectorAll('strong, b, span[style]');
				for (var i = 0; i < strongs.length; i++) {
					strongs[i].style.setProperty('color', '#ccc593', 'important');
				}
				var lists = c32.querySelectorAll('ol, ul');
				for (var j = 0; j < lists.length; j++) {
					lists[j].style.setProperty('color', 'rgba(240, 235, 225, 0.92)', 'important');
				}
			}

			var c36 = document.querySelector('.style-local-64453-c36');
			if (c36) {
				c36.style.setProperty('max-width',    '380px',  'important');
				c36.style.setProperty('max-height',   '380px',  'important');
				c36.style.setProperty('overflow',     'hidden', 'important');
				c36.style.setProperty('aspect-ratio', '1 / 1',  'important');
				c36.style.setProperty('width',        '100%',   'important');
			}

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
	</script><!--/noptimize-->
	<?php
	endif; // end page 64453

}, 99999 );
