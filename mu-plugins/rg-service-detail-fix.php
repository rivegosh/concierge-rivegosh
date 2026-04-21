<?php
/**
 * Plugin Name: RG Service Detail Fix
 * Description: Two targeted fixes for Amelia service catalog detail view (.am-fcis):
 *              1. Book Now button invisible — rg-catalog-luxury-reskin.php §8 selector
 *                 (.am-fcis__header .am-button, specificity 1,3,0) beats §6's champagne
 *                 fill rule at the same specificity (§8 is later in file). Sealed plugin
 *                 cannot be edited. Fix: higher-specificity selector (1,4,0) at priority
 *                 100005 restores champagne-gold fill for .am-button--filled in header.
 *              2. Gallery hero black void — adds min-height safety net and img fallback
 *                 in case padding-top:42% resolves to zero on first render.
 * Version: 1.3.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: .amelia-v2-booking #amelia-container .am-fcis only.       ║
 * ║ Priority 100005 — fires after rg-catalog-luxury-reskin.php       ║
 * ║ (99999) and rg-amelia-contrast-sweep.php (100000).               ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root causes (2026-04-21):                                        ║
 * ║  BUTTON: §8 of sealed catalog reskin applies dark bg + dim       ║
 * ║  border/text to ALL .am-button inside .am-fcis__header (1,3,0). ║
 * ║  §6 sets champagne fill for .am-button--filled (same 1,3,0) but ║
 * ║  §8 comes LATER in the same file → §8 wins in specificity tie.  ║
 * ║  Result: Book Now shows as barely-visible dark outline box.      ║
 * ║  Fix: selector (1,4,0) adds .am-button--filled to path + loads   ║
 * ║  at priority 100005 (after 99999) → wins all tiebreakers.        ║
 * ║                                                                   ║
 * ║  GALLERY: .am-fcis__gallery-hero gets padding-top:42% from       ║
 * ║  rg-catalog-luxury-reskin.php for height. Safety-net min-height  ║
 * ║  ensures visibility if padding resolves to zero on first render. ║
 * ║  Also covers <img> based rendering (Amelia may use either).      ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_singular() ) return;
	?>
	<style id="rg-service-detail-fix">

	/* ==================================================================
	 * 0. CATALOG LIST CARD HERO — dark background fill
	 *    .am-fcil__item-hero uses background-image (inline style from Vue)
	 *    with background-size:cover. Its background-color is transparent
	 *    (rgba 0,0,0,0), so transparent PNG areas fall through ALL parent
	 *    transparencies to the page background (white). Fix: dark fill so
	 *    transparent car cutout areas composite onto #0a0a0a, not white.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-fcil__item-hero {
		background-color: #0a0a0a !important;
		background-size: contain !important;
		background-position: center center !important;
	}

	/* ==================================================================
	 * 1. BOOK NOW BUTTON — champagne gold fill
	 *    Specificity (1,4,0) beats sealed §8's (1,3,0).
	 *    Loads at priority 100005 → wins all ties.
	 *    All three selectors cover header-btn, header-action, and base
	 *    header scope to catch any Amelia layout variant.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-fcis__header-btn .am-button.am-button--filled,
	.amelia-v2-booking #amelia-container .am-fcis__header-action .am-button.am-button--filled,
	.amelia-v2-booking #amelia-container .am-fcis__header .am-button.am-button--filled {
		background: rgba(204, 197, 147, 0.92) !important;
		color: #0a0a0a !important;
		border: none !important;
	}
	.amelia-v2-booking #amelia-container .am-fcis__header-btn .am-button.am-button--filled .am-button__inner,
	.amelia-v2-booking #amelia-container .am-fcis__header-action .am-button.am-button--filled .am-button__inner,
	.amelia-v2-booking #amelia-container .am-fcis__header .am-button.am-button--filled .am-button__inner,
	.amelia-v2-booking #amelia-container .am-fcis__header .am-button.am-button--filled .am-button__inner span {
		color: #0a0a0a !important;
		font-weight: 600 !important;
	}

	/* ==================================================================
	 * 2. GALLERY HERO — correct aspect ratio + height + img fallback
	 *    Sealed §5 uses padding-top:42% (tuned for an old image).
	 *    Cadillac PNG is 662×337 (51% tall); Sprinter is 480×484 (101%).
	 *    54% padding-top fits the widest landscape car fully; nearly-
	 *    square vehicles (Sprinter) scale down to fit within contain.
	 *    Min-height 200px is a floor for narrow viewports.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-fcis__gallery,
	.amelia-v2-booking #amelia-container .am-fcip__gallery {
		min-height: 200px !important;
	}
	.amelia-v2-booking #amelia-container .am-fcis__gallery-hero,
	.amelia-v2-booking #amelia-container .am-fcip__gallery-hero {
		padding-top: 54% !important;
		min-height: 200px !important;
	}
	.amelia-v2-booking #amelia-container .am-fcis__gallery-hero img,
	.amelia-v2-booking #amelia-container .am-fcip__gallery-hero img {
		width: 100% !important;
		height: auto !important;
		max-height: 440px !important;
		object-fit: contain !important;
		display: block !important;
	}

	</style>
	<?php
}, 100005 );
