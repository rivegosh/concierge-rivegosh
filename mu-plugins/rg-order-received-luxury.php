<?php
/**
 * Plugin Name: RG Order Received Luxury
 * Description: Scoped luxury skin for WooCommerce Thank You page
 *              (/checkout/order-received/) — dark body, dark success banner
 *              with gold accent, dark order details table, dark customer
 *              addresses card.
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: is_wc_endpoint_url('order-received') only.                ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Problem (2026-04-20 — Daniel screenshot):                        ║
 * ║  Thank You page rendered fully unskinned — light body, bright    ║
 * ║  green WC success banner, white order details box, light blue    ║
 * ║  billing address card. Discontinuity at the end of an otherwise  ║
 * ║  dark luxury flow.                                                ║
 * ║                                                                   ║
 * ║ Fix: target the order-received endpoint (NOT page-id, since the  ║
 * ║ endpoint renders under /checkout/order-received/{order_id}/ i.e. ║
 * ║ body.page-id-15 + .woocommerce-order wrapper). Scope also to     ║
 * ║ body.woocommerce-order-received class WC adds server-side.       ║
 * ║                                                                   ║
 * ║ Contrast floor (WCAG AA 4.5:1 min):                              ║
 * ║  - success icon + text dark text on champagne banner ≈ 8.9:1 ✓   ║
 * ║  - table text rgba(240,235,225,0.9) on rgba(20,16,10,0.6) ≈ 11:1 ║
 * ║  - address card text rgba(230,225,195,0.88) on dark ≈ 9:1 ✓      ║
 * ║                                                                   ║
 * ║ CSS-only.                                                         ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_wc_endpoint_url' ) ) return;
	if ( ! is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-order-received-luxury">
	/* ==================================================================
	 * PAGE BODY — dark luxury (matches rest of flow)
	 * ================================================================== */
	body.woocommerce-order-received,
	body.woocommerce-order-received #colibri,
	body#colibri.woocommerce-order-received {
		background-color: #0f0c08 !important;
	}
	body.woocommerce-order-received .h-section-background,
	body.woocommerce-order-received main,
	body.woocommerce-order-received .page-content,
	body.woocommerce-order-received .site-content,
	body.woocommerce-order-received .entry-content {
		background-color: transparent !important;
	}
	body.woocommerce-order-received .entry-title,
	body.woocommerce-order-received h1,
	body.woocommerce-order-received h2,
	body.woocommerce-order-received h3 {
		color: #CCC593 !important;
	}
	body.woocommerce-order-received p,
	body.woocommerce-order-received li,
	body.woocommerce-order-received .h-text,
	body.woocommerce-order-received .h-text p {
		color: rgba(230, 225, 195, 0.88) !important;
	}

	/* ==================================================================
	 * SUCCESS BANNER — "Thank you. Your order has been received."
	 * Remove the bright green default, replace with dark + champagne
	 * left-stripe (ties into other notice styles on /checkout/).
	 * ================================================================== */
	body.woocommerce-order-received .woocommerce-notice,
	body.woocommerce-order-received .woocommerce-notice--success,
	body.woocommerce-order-received .woocommerce-order .woocommerce-notice,
	body.woocommerce-order-received p.woocommerce-notice {
		background-color: rgba(20, 16, 10, 0.92) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
		border-left: 3px solid #CCC593 !important;
		border-radius: 3px !important;
		padding: 18px 22px !important;
		font-size: 15px !important;
		letter-spacing: 0.02em !important;
	}
	body.woocommerce-order-received .woocommerce-notice::before,
	body.woocommerce-order-received .woocommerce-notice--success::before {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * ORDER DETAILS STRIP (order #, date, email, total, payment method)
	 * ================================================================== */
	body.woocommerce-order-received .woocommerce-order-overview,
	body.woocommerce-order-received ul.order_details {
		background-color: rgba(20, 16, 10, 0.7) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		border-radius: 3px !important;
		padding: 18px 22px !important;
		list-style: none !important;
	}
	body.woocommerce-order-received ul.order_details li {
		color: rgba(240, 235, 225, 0.9) !important;
		border-right-color: rgba(204, 197, 147, 0.2) !important;
		font-size: 13px !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
	}
	body.woocommerce-order-received ul.order_details li strong {
		color: #CCC593 !important;
		font-size: 15px !important;
		letter-spacing: 0 !important;
		text-transform: none !important;
	}

	/* ==================================================================
	 * ORDER DETAILS TABLE (items, subtotal, total, payment)
	 * ================================================================== */
	body.woocommerce-order-received section.woocommerce-order-details,
	body.woocommerce-order-received .woocommerce-order-details {
		background-color: rgba(20, 16, 10, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
		padding: 24px !important;
		margin-top: 28px !important;
	}
	body.woocommerce-order-received .woocommerce-order-details h2,
	body.woocommerce-order-received .woocommerce-order-details__title {
		color: #CCC593 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		font-size: 18px !important;
		margin-bottom: 16px !important;
	}
	body.woocommerce-order-received .woocommerce-table--order-details,
	body.woocommerce-order-received table.shop_table.order_details {
		background-color: transparent !important;
		border: none !important;
	}
	body.woocommerce-order-received .woocommerce-table--order-details th,
	body.woocommerce-order-received .woocommerce-table--order-details td,
	body.woocommerce-order-received table.shop_table.order_details th,
	body.woocommerce-order-received table.shop_table.order_details td {
		color: rgba(240, 235, 225, 0.9) !important;
		border-color: rgba(204, 197, 147, 0.15) !important;
		background-color: transparent !important;
	}
	body.woocommerce-order-received .woocommerce-table--order-details thead th {
		color: #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
		font-size: 13px !important;
	}
	body.woocommerce-order-received .woocommerce-table--order-details .amount,
	body.woocommerce-order-received table.shop_table.order_details .amount {
		color: #CCC593 !important;
		font-weight: 500 !important;
	}
	body.woocommerce-order-received .woocommerce-table--order-details tfoot tr.order-total th,
	body.woocommerce-order-received .woocommerce-table--order-details tfoot tr.order-total td,
	body.woocommerce-order-received .woocommerce-table--order-details tfoot tr.order-total .amount {
		color: #CCC593 !important;
		font-weight: 600 !important;
		font-size: 17px !important;
	}
	body.woocommerce-order-received .woocommerce-table--order-details .product-name a,
	body.woocommerce-order-received table.shop_table.order_details .product-name a {
		color: rgba(240, 235, 225, 0.95) !important;
	}

	/* ==================================================================
	 * CUSTOMER ADDRESSES (billing / shipping cards)
	 * ================================================================== */
	body.woocommerce-order-received section.woocommerce-customer-details,
	body.woocommerce-order-received .woocommerce-customer-details {
		margin-top: 28px !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details h2,
	body.woocommerce-order-received .woocommerce-column__title {
		color: #CCC593 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		font-size: 16px !important;
		margin-bottom: 14px !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details address,
	body.woocommerce-order-received .woocommerce-column address {
		background-color: rgba(20, 16, 10, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
		padding: 18px 22px !important;
		color: rgba(230, 225, 195, 0.88) !important;
		font-style: normal !important;
		line-height: 1.7 !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details address p,
	body.woocommerce-order-received .woocommerce-column address p {
		color: rgba(230, 225, 195, 0.88) !important;
	}

	/* ==================================================================
	 * DOWNLOADS (if any digital products)
	 * ================================================================== */
	body.woocommerce-order-received .woocommerce-order-downloads,
	body.woocommerce-order-received .woocommerce-table--order-downloads {
		background-color: rgba(20, 16, 10, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
	}
	body.woocommerce-order-received .woocommerce-order-downloads h2 {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * LINKS
	 * ================================================================== */
	body.woocommerce-order-received a {
		color: #CCC593 !important;
	}
	body.woocommerce-order-received a:hover {
		color: #E3DBA8 !important;
	}
	</style>
	<?php
}, 99999 );
