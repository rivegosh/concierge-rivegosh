<?php
/**
 * Plugin Name: RG Checkout Review Polish
 * Description: Two targeted fixes on /checkout/ (page-id-15):
 *              1. Billing form — input placeholder visibility (dark-on-dark) +
 *                 slightly brighter labels
 *              2. Order review right panel — dl.variation layout reset so
 *                 "Appointment Info" / "Local Time" stack as blocks (not inline),
 *                 bold meta labels shrunk to 11px, line-height tightened.
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout + body.page-id-15 ONLY.         ║
 * ║ Loads at wp_footer priority 100001 (after all other checkout     ║
 * ║ skins — rg-checkout-luxury.php at 99999,                         ║
 * ║ rg-checkout-luxury-skin.php at 99999).                           ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root causes (2026-04-21 — Roderic screenshot):                   ║
 * ║  1. ::placeholder never set → browser default grey on near-black ║
 * ║     bg = invisible (Postcode / Town / Phone fields look empty).  ║
 * ║  2. WooCommerce default dl.variation: dt has float:left → dt     ║
 * ║     "Appointment Info:" and first dd bold "Local Time:" appear   ║
 * ║     inline on same line. Fix: float:none; display:block on both. ║
 * ║  3. strong inside td inherits Colibri gold at full weight →      ║
 * ║     labels oversized/heavy. Reduce to 11px / rgba(204,197,147,   ║
 * ║     0.75) inside the order review td only.                       ║
 * ║                                                                   ║
 * ║ is_wc_endpoint_url('order-received') exclusion NOT needed here   ║
 * ║ as scope guards are woocommerce-checkout body class only.        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-review-polish">

	/* ==================================================================
	 * 1. BILLING FORM — placeholder visibility + label brightness
	 * ================================================================== */
	body.woocommerce-checkout .form-row input::placeholder,
	body.woocommerce-checkout .form-row textarea::placeholder,
	body.page-id-15 .form-row input::placeholder,
	body.page-id-15 .form-row textarea::placeholder {
		color: rgba(204, 197, 147, 0.38) !important;
		-webkit-text-fill-color: rgba(204, 197, 147, 0.38) !important;
	}
	/* Slightly brighter labels — existing skin is 0.85, push to 0.92 */
	body.woocommerce-checkout .form-row label,
	body.woocommerce-checkout .woocommerce-billing-fields label,
	body.page-id-15 .form-row label,
	body.page-id-15 .woocommerce-billing-fields label {
		color: rgba(230, 225, 195, 0.92) !important;
		font-size: 12px !important;
		letter-spacing: 0.03em !important;
	}
	/* Required asterisk — keep readable red, not gold */
	body.woocommerce-checkout .form-row .required,
	body.page-id-15 .form-row .required {
		color: #d4847a !important;
	}
	/* Section headings (Billing details, Additional information) */
	body.woocommerce-checkout h3#order_review_heading,
	body.woocommerce-checkout .woocommerce-billing-fields h3,
	body.woocommerce-checkout .woocommerce-additional-fields h3,
	body.page-id-15 .woocommerce-billing-fields h3,
	body.page-id-15 .woocommerce-additional-fields h3 {
		color: #CCC593 !important;
		font-size: 15px !important;
		letter-spacing: 0.05em !important;
		text-transform: uppercase !important;
		border-bottom: 1px solid rgba(204, 197, 147, 0.2) !important;
		padding-bottom: 8px !important;
		margin-bottom: 16px !important;
	}
	/* select2 dropdown item text (Country/Region options) */
	body.woocommerce-checkout .select2-results__option,
	body.page-id-15 .select2-results__option {
		color: rgba(230, 225, 195, 0.92) !important;
		background-color: rgba(20, 16, 10, 0.97) !important;
	}
	body.woocommerce-checkout .select2-results__option--highlighted,
	body.page-id-15 .select2-results__option--highlighted {
		background-color: rgba(204, 197, 147, 0.18) !important;
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * 2. ORDER REVIEW RIGHT PANEL — dl.variation / Amelia meta layout
	 *
	 * WooCommerce default: dt { float:left } causes "Appointment Info:"
	 * and "Local Time:" to appear on the same line. Reset to block.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td .wc-item-meta,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation,
	body.page-id-15 .woocommerce-checkout-review-order-table td .wc-item-meta {
		margin: 5px 0 0 0 !important;
		padding: 0 !important;
	}
	/* dt label (e.g. "Appointment Info:") — block, small, muted gold */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dt,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td .wc-item-meta dt,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation dt,
	body.page-id-15 .woocommerce-checkout-review-order-table td .wc-item-meta dt {
		float: none !important;
		display: block !important;
		width: auto !important;
		margin: 0 !important;
		padding: 0 !important;
		font-size: 10px !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.06em !important;
		color: rgba(204, 197, 147, 0.5) !important;
		line-height: 1.8 !important;
	}
	/* dd value — block, flush left, compact */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dd,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td .wc-item-meta dd,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation dd,
	body.page-id-15 .woocommerce-checkout-review-order-table td .wc-item-meta dd {
		float: none !important;
		display: block !important;
		margin: 0 0 6px 0 !important;
		padding: 0 !important;
	}
	/* Paragraphs inside dd */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dd p,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation p,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation dd p,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation p {
		font-size: 12px !important;
		line-height: 1.55 !important;
		margin: 0 0 2px 0 !important;
		color: rgba(230, 225, 195, 0.82) !important;
	}
	/* Bold meta labels inside dd (Local Time, Client Time, VIP Driver, etc.)
	   These inherit Colibri's global gold at full weight — shrink them */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation dd strong,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td dl.variation p strong,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td .wc-item-meta strong,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation dd strong,
	body.page-id-15 .woocommerce-checkout-review-order-table td dl.variation p strong,
	body.page-id-15 .woocommerce-checkout-review-order-table td .wc-item-meta strong {
		font-size: 11px !important;
		font-weight: 600 !important;
		color: rgba(204, 197, 147, 0.78) !important;
	}
	/* "My Space: Rive gosh" link — force champagne, not teal/blue */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td a,
	body.page-id-15 .woocommerce-checkout-review-order-table td a {
		color: #CCC593 !important;
	}
	/* Product name line — slightly more prominent than meta */
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td.product-name,
	body.page-id-15 .woocommerce-checkout-review-order-table td.product-name {
		font-size: 13px !important;
		line-height: 1.5 !important;
	}

	</style>
	<?php
}, 100001 );
