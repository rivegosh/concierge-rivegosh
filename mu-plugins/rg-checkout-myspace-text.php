<?php
/**
 * Plugin Name: RG Checkout MySpace Text
 * Description: My Space section content on /checkout/ order review:
 *              bumps font 2pt (14px → 16px) and tightens line-height
 *              (1.5 → 1.25) so the free-text note reads as a distinct
 *              block rather than running into surrounding meta rows.
 *              Target: all dd > p after the LAST dt in dl.variation
 *              (which is always the MY SPACE section header).
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout dl.variation ONLY.              ║
 * ║ Priority 100010 — fires after rg-checkout-order-hierarchy        ║
 * ║ (100008) which sets the base 14px / line-height:1.5.             ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-myspace-text">

	/* ==================================================================
	 * MY SPACE section content — 16px, tighter line-height
	 *  dl.variation dt:last-of-type ~ dd selects every dd that is a
	 *  sibling of the last dt (MY SPACE: header). These are the free-text
	 *  notes the customer entered, not labelled field rows.
	 *  rg-checkout-order-hierarchy (100008) set dd p → 14px / 1.5.
	 *  We override at priority 100010 — higher load order + equal or
	 *  higher specificity wins.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dt:last-of-type ~ dd p,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dt:last-of-type ~ dd {
		font-size: 16px !important;
		line-height: 1.25 !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}

	</style>
	<?php
}, 100010 );
