<?php
/**
 * Plugin Name: RG Checkout Billing Dark
 * Description: Darkens the WooCommerce checkout billing wrapper (#customer_details
 *              / .col2-set) which was rgb(255,255,255) — making all champagne
 *              labels invisible (1.16:1). Also bumps dl.variation dt label
 *              opacity 0.5 → 0.72 (scanner found 3.50:1, below AA floor).
 *              Fixes "+ N" payment-method logo count badge (1.04:1 dark-on-dark).
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout + body.page-id-15 ONLY.         ║
 * ║ Priority 100002 — fires after rg-checkout-review-polish (100001).║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root cause (2026-04-21 contrast scanner, 23 violations):         ║
 * ║  WooCommerce renders billing fields inside #customer_details     ║
 * ║  (.col2-set) with background-color: rgb(255,255,255) from its    ║
 * ║  own base stylesheet. rg-checkout-luxury-skin.php darkened the   ║
 * ║  inputs but never set a bg on this wrapper — champagne labels   ║
 * ║  (rgba 240,235,225,0.85) landed on white → ratio 1.16:1.         ║
 * ║                                                                   ║
 * ║ Also: dl.variation dt was set to rgba(204,197,147,0.5) →         ║
 * ║  3.50:1 on dark bg (below WCAG AA 4.5:1). Bumped to 0.72.        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-billing-dark">

	/* ==================================================================
	 * THE ROOT FIX — kill the white wrapper background
	 * #customer_details.col2-set is the parent of ALL billing labels.
	 * ================================================================== */
	body.woocommerce-checkout #customer_details,
	body.woocommerce-checkout .col2-set,
	body.page-id-15 #customer_details,
	body.page-id-15 .col2-set {
		background-color: rgba(20, 16, 10, 0.7) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 4px !important;
		padding: 24px !important;
	}
	/* Inner column containers */
	body.woocommerce-checkout #customer_details .col-1,
	body.woocommerce-checkout #customer_details .col-2,
	body.page-id-15 #customer_details .col-1,
	body.page-id-15 #customer_details .col-2 {
		background-color: transparent !important;
	}

	/* ==================================================================
	 * dt LABEL OPACITY FIX — bump 0.5 → 0.72 (4.6:1 on dark bg ✓)
	 * Covers "Appointment Info:", "My Space:", and any other meta dt.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dt,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td .wc-item-meta dt,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation dt,
	body.page-id-15 .woocommerce-checkout-review-order-table td .wc-item-meta dt {
		color: rgba(204, 197, 147, 0.72) !important;
	}

	/* ==================================================================
	 * PAYMENT LOGOS "+ N" COUNT BADGE (1.04:1 — dark on dark)
	 * ================================================================== */
	body.woocommerce-checkout .payment-methods--logos-count,
	body.page-id-15 .payment-methods--logos-count {
		color: rgba(204, 197, 147, 0.8) !important;
		background-color: transparent !important;
	}

	</style>
	<?php
}, 100002 );
