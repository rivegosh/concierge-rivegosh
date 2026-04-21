<?php
/**
 * Plugin Name: RG Checkout Order Hierarchy
 * Description: Typography hierarchy + price clarity for the WooCommerce order
 *              review table on /checkout/ (page-id-15). Problems (2026-04-21):
 *              1. Price ($143) floats vertically in the middle of the product
 *                 row because td.product-total defaults to vertical-align:middle.
 *              2. All booking meta (Local Time, Client Time, Service, Custom
 *                 Fields) renders at the same 11px weight — no hierarchy.
 *              3. Section headers (APPOINTMENT INFO, Custom Fields, MY SPACE)
 *                 look identical to field labels.
 *              Fix: pin price to top + bigger; dt labels → small-caps champagne;
 *              dd values → 13px white; product name → 15px; Total row prominent.
 * Version: 1.1.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout table.shop_table ONLY.          ║
 * ║ Priority 100008 — fires after rg-checkout-review-polish (100001) ║
 * ║ and rg-checkout-billing-dark (100002).                           ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-order-hierarchy">

	/* ==================================================================
	 * 1. PRICE — pin to top of row, make it prominent
	 *    WC default: vertical-align:middle → price floats mid-row.
	 *    Fix: top-align + enlarge so $143 reads as the KEY number.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td.product-total {
		vertical-align: top !important;
		padding-top: 18px !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td.product-total .woocommerce-Price-amount,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td.product-total .amount {
		font-size: 18px !important;
		font-weight: 700 !important;
		color: rgba(204, 197, 147, 0.97) !important;
		letter-spacing: 0.01em !important;
	}

	/* ==================================================================
	 * 2. PRODUCT NAME — service title line
	 *    Slightly larger + brighter so it reads as the heading.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td.product-name {
		font-size: 14px !important;
		color: rgba(230, 225, 195, 0.95) !important;
		font-weight: 600 !important;
		vertical-align: top !important;
		padding-top: 14px !important;
	}

	/* ==================================================================
	 * 3. BOOKING META BLOCK — separator + breathing room
	 *    More top-margin so "APPOINTMENT INFO:" breathes away from the
	 *    product name line above it.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation {
		margin-top: 18px !important;
		padding-top: 14px !important;
		border-top: 1px solid rgba(204, 197, 147, 0.15) !important;
	}

	/* ==================================================================
	 * 4. dt LABELS — small champagne caps
	 *    Section headers (APPOINTMENT INFO, Custom Fields, MY SPACE) and
	 *    field labels (Local Time, Client Time, etc.) are all dt elements.
	 *    Uppercase + 0.07em tracking + 65% opacity gives the "label" look.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation dt {
		display: block !important;
		float: none !important;
		color: rgba(204, 197, 147, 0.65) !important;
		font-size: 10px !important;
		font-weight: 700 !important;
		letter-spacing: 0.07em !important;
		text-transform: uppercase !important;
		margin-top: 10px !important;
		margin-bottom: 2px !important;
		padding: 0 !important;
		width: 100% !important;
	}
	/* First dt (APPOINTMENT INFO) — tight bottom to close gap to first field */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation dt:first-child {
		margin-top: 0 !important;
		margin-bottom: 4px !important;
		line-height: 1.2 !important;
		color: rgba(204, 197, 147, 0.85) !important;
		font-size: 11px !important;
	}

	/* ==================================================================
	 * 5. dd VALUES — white, 13px, readable
	 *    Empty dd (after section headers like APPOINTMENT INFO:) gets
	 *    zero height so it doesn't add gap.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation dd {
		display: block !important;
		float: none !important;
		color: rgba(230, 225, 195, 0.92) !important;
		font-size: 13px !important;
		font-weight: 400 !important;
		margin: 0 0 2px 0 !important;
		padding: 0 !important;
		width: 100% !important;
	}
	/* Empty dd after section headers — collapse */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation dd:empty {
		display: none !important;
	}

	/* ==================================================================
	 * 5b. dd INNER CONTENT — p and strong inside each booking field
	 *     rg-checkout-review-polish sets dd p → 12px, dd strong → 11px.
	 *     Override to +2pt each. text-transform:capitalize on strong
	 *     fixes "service:" → "Service:" without touching other labels.
	 * ================================================================== */
	/* td in path matches rg-checkout-review-polish specificity (it uses td dl.variation)
	   so with equal specificity our later priority (100008 > 100001) wins */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dd p,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation p {
		font-size: 14px !important;
		color: rgba(230, 225, 195, 0.92) !important;
		line-height: 1.5 !important;
		margin: 0 0 3px 0 !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dd strong,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation p strong {
		font-size: 13px !important;
		font-weight: 600 !important;
		color: rgba(204, 197, 147, 0.78) !important;
		text-transform: capitalize !important;
	}

	/* ==================================================================
	 * 6. LOCAL TIME — first real value after APPOINTMENT INFO header
	 *    Target the 2nd dt (Local Time) + its dd for special prominence.
	 *    nth-of-type(2) = Local Time label; nth-of-type(3) dd = the value.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation dt:nth-of-type(2) {
		color: rgba(204, 197, 147, 0.9) !important;
		font-size: 11px !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table dl.variation dd:nth-of-type(1) {
		color: rgba(255, 255, 255, 0.97) !important;
		font-size: 14px !important;
		font-weight: 500 !important;
		margin-bottom: 6px !important;
	}

	/* ==================================================================
	 * 7. TABLE HEADER ROW — PRODUCT / SUBTOTAL labels
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table thead th {
		font-size: 10px !important;
		letter-spacing: 0.1em !important;
		text-transform: uppercase !important;
		color: rgba(204, 197, 147, 0.5) !important;
		padding-bottom: 10px !important;
		border-bottom: 1px solid rgba(204, 197, 147, 0.15) !important;
	}

	/* ==================================================================
	 * 8. SUBTOTAL / TAX / TOTAL ROWS — hierarchy bottom section
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .cart-subtotal th,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .cart-subtotal td,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .tax-rate th,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .tax-rate td {
		font-size: 13px !important;
		color: rgba(204, 197, 147, 0.7) !important;
		padding-top: 10px !important;
		padding-bottom: 6px !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total th,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total td {
		padding-top: 14px !important;
		padding-bottom: 14px !important;
		border-top: 1px solid rgba(204, 197, 147, 0.2) !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total th {
		font-size: 14px !important;
		font-weight: 700 !important;
		color: rgba(230, 225, 195, 0.95) !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total .woocommerce-Price-amount,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total .amount {
		font-size: 22px !important;
		font-weight: 700 !important;
		color: rgba(204, 197, 147, 1) !important;
		letter-spacing: 0.01em !important;
	}

	</style>
	<?php
}, 100008 );
