<?php
/**
 * Plugin Name: RG Cart Order Hierarchy
 * Description: Typography hierarchy for /your-booking/ (page-id-14) cart item
 *              meta rendering. Problems (2026-04-22):
 *              1. dt labels ("Appointment Info:", "My Space:") float:left →
 *                 collide with following dd text on same line
 *              2. Inline <strong>/<b> labels in dd render at 20px/700 →
 *                 bigger than the dt labels, inverted hierarchy
 *              3. "service:" stored lowercase by Amelia — cosmetic
 *              4. "Rive gosh" wrapped in <a class="wcfm_dashboard_item_title">
 *                 → styled as partner-dashboard link, not a plain value
 *              5. Price + Subtotal cells at 16px — under-weighted vs. all
 *                 the meta text
 *              Fix: unify label styling (11px uppercase champagne), clear
 *              float, bump price to 19px, neutralize wcfm link on MY SPACE.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-22
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ─────────────────────────────────────────────────────────────── ║
 * ║  Frozen gold-standard fix. Verified visually via Chrome          ║
 * ║  screenshot on 2026-04-22 and signed off.                        ║
 * ║                                                                   ║
 * ║  If the /your-booking/ (cart) order review looks wrong later,    ║
 * ║  FIX THE CAUSE — do NOT gut or rewrite this file. Ship additive  ║
 * ║  overrides in a NEW mu-plugin if needed.                         ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: Amelia WC cart item meta renders as a      ║
 * ║  dl.variation with TWO dts (Appointment Info, My Space) and dd[0] ║
 * ║  containing 9 inline <strong>/<b> labels at 20px/700 — bigger    ║
 * ║  than the dt at 16px/400. Inverted hierarchy + float:left         ║
 * ║  collisions made the cart unreadable. Unifies labels at 11px     ║
 * ║  uppercase champagne (matching checkout order-hierarchy pattern). ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh (cart cleanup)              ║
 * ║  Commit of record: TBD                                           ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_cart() && ! is_page( 14 ) ) return;
	?>
	<style id="rg-cart-order-hierarchy">

	/* ==================================================================
	 * 1. dl.variation dt — unify as 11px uppercase champagne labels
	 *    Kills WooCommerce default `float:left` that caused "Appointment
	 *    Info:" and "Local Time:" to collide on the same line.
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dt {
		float: none !important;
		display: block !important;
		clear: both !important;
		font-size: 11px !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.08em !important;
		color: rgba(204, 197, 147, 0.85) !important;
		margin: 14px 0 4px !important;
		line-height: 1.4 !important;
	}
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dt:first-of-type {
		margin-top: 4px !important;
	}

	/* ==================================================================
	 * 2. dl.variation dd — block flow, consistent 13px value text
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd {
		margin: 0 0 8px 0 !important;
		clear: both !important;
		font-size: 13px !important;
		color: rgba(230, 225, 195, 0.95) !important;
		line-height: 1.5 !important;
	}
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd p {
		margin: 0 0 4px 0 !important;
		font-size: 13px !important;
		line-height: 1.5 !important;
		color: rgba(230, 225, 195, 0.95) !important;
		font-weight: 400 !important;
	}

	/* ==================================================================
	 * 3. Inline <strong>/<b> labels inside dd — the 9 field labels
	 *    (Local Time, Client Time, service, VIP Driver, Total Number of
	 *    People, Custom Fields, Your Airport Arrival/Departure, Special
	 *    request, How many suitcase). Render them as mini-labels ABOVE
	 *    their values so hierarchy reads cleanly.
	 *    text-transform:uppercase incidentally normalizes "service:".
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd p strong,
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd p b {
		display: inline !important;
		font-size: 11px !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.06em !important;
		color: rgba(204, 197, 147, 0.80) !important;
		margin-right: 6px !important;
		line-height: 1.4 !important;
	}

	/* ==================================================================
	 * 4. MY SPACE free-text dd — slightly bigger, override wcfm link styles
	 *    dd.variation-MySpace contains <a class="wcfm_dashboard_item_title">
	 *    which normally styles as a partner-dashboard link. Neutralize it
	 *    so "Rive gosh" reads as a normal value.
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd.variation-MySpace p,
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dt:last-of-type ~ dd p {
		font-size: 15px !important;
		line-height: 1.3 !important;
	}
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd.variation-MySpace a.wcfm_dashboard_item_title,
	body#colibri.page-id-14 .woocommerce-cart-form dl.variation dd.variation-MySpace a {
		font-size: 15px !important;
		font-weight: 400 !important;
		color: rgba(230, 225, 195, 0.95) !important;
		text-decoration: none !important;
		background: transparent !important;
		padding: 0 !important;
	}

	/* ==================================================================
	 * 5. Price + Subtotal columns — 19px champagne bold, top-aligned
	 *    Currently 16px, under-weighted vs. the dense meta block in
	 *    td.product-name.
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form td.product-price,
	body#colibri.page-id-14 .woocommerce-cart-form td.product-subtotal {
		font-size: 19px !important;
		font-weight: 700 !important;
		color: rgba(204, 197, 147, 0.95) !important;
		vertical-align: top !important;
		padding-top: 18px !important;
	}

	/* ==================================================================
	 * 6. Top-align name + thumbnail + quantity cells so rows don't
	 *    middle-align against the tall meta column.
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form td.product-name,
	body#colibri.page-id-14 .woocommerce-cart-form td.product-thumbnail,
	body#colibri.page-id-14 .woocommerce-cart-form td.product-quantity,
	body#colibri.page-id-14 .woocommerce-cart-form td.product-remove {
		vertical-align: top !important;
		padding-top: 18px !important;
	}

	/* ==================================================================
	 * 7. Product name "SUV Airport Transfer ..." — slightly bigger,
	 *    champagne to anchor the row as a heading
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form td.product-name > a,
	body#colibri.page-id-14 .woocommerce-cart-form td.product-name .product-name-link {
		font-size: 16px !important;
		font-weight: 600 !important;
		color: rgba(230, 225, 195, 0.95) !important;
		display: block !important;
		margin-bottom: 10px !important;
	}

	</style>
	<?php
}, 100010 );
