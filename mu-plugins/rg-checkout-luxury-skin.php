<?php
/**
 * Plugin Name: RG Checkout Luxury Skin
 * Description: Full dark luxury skin for /checkout/ (page-id-15) — coupon bar,
 *              billing details form fields, order review summary, Stripe card
 *              panel, payment method list, place order button. Complements
 *              rg-checkout-luxury.php (which handles hero H2 + payment-request
 *              buttons) by covering everything else that still rendered white.
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.page-id-15 + body.woocommerce-checkout only.         ║
 * ║ Loads at wp_footer priority 99999 (after base checkout luxury).  ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Problem (2026-04-20 — Daniel screenshot of /checkout/):          ║
 * ║  - Coupon bar white with light text                               ║
 * ║  - Order review right panel entirely white                        ║
 * ║  - Billing form inputs mostly dark but Phone field white          ║
 * ║  - Stripe card number box white panel                             ║
 * ║                                                                   ║
 * ║ Contrast floor: champagne on dark ~9:1 ✓ (WCAG AAA).             ║
 * ║ CSS-only. Zero functionality touches.                            ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-luxury-skin">
	/* ==================================================================
	 * COUPON BAR (top of checkout)
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-form-coupon-toggle,
	body.woocommerce-checkout .woocommerce-info,
	body.page-id-15 .woocommerce-form-coupon-toggle,
	body.page-id-15 .woocommerce-info {
		background-color: rgba(20, 16, 10, 0.92) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.3) !important;
		border-left: 3px solid #CCC593 !important;
		border-radius: 3px !important;
	}
	body.woocommerce-checkout .woocommerce-form-coupon-toggle a,
	body.woocommerce-checkout .woocommerce-info a,
	body.page-id-15 .woocommerce-form-coupon-toggle a,
	body.page-id-15 .woocommerce-info a {
		color: #CCC593 !important;
	}
	body.woocommerce-checkout .checkout_coupon,
	body.page-id-15 .checkout_coupon {
		background-color: rgba(20, 16, 10, 0.7) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
	}

	/* ==================================================================
	 * BILLING / SHIPPING DETAILS FORM
	 * ================================================================== */
	body.woocommerce-checkout h3,
	body.page-id-15 h3 {
		color: #CCC593 !important;
	}
	body.woocommerce-checkout .form-row label,
	body.page-id-15 .form-row label,
	body.woocommerce-checkout .woocommerce-billing-fields label,
	body.page-id-15 .woocommerce-billing-fields label {
		color: rgba(230, 225, 195, 0.85) !important;
	}
	body.woocommerce-checkout .form-row input[type="text"],
	body.woocommerce-checkout .form-row input[type="email"],
	body.woocommerce-checkout .form-row input[type="tel"],
	body.woocommerce-checkout .form-row input[type="number"],
	body.woocommerce-checkout .form-row textarea,
	body.woocommerce-checkout .form-row select,
	body.woocommerce-checkout .select2-selection,
	body.page-id-15 .form-row input[type="text"],
	body.page-id-15 .form-row input[type="email"],
	body.page-id-15 .form-row input[type="tel"],
	body.page-id-15 .form-row input[type="number"],
	body.page-id-15 .form-row textarea,
	body.page-id-15 .form-row select,
	body.page-id-15 .select2-selection {
		background-color: rgba(15, 12, 8, 0.92) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
		border-radius: 2px !important;
	}
	body.woocommerce-checkout .select2-selection__rendered,
	body.page-id-15 .select2-selection__rendered {
		color: rgba(240, 235, 225, 0.95) !important;
	}

	/* ==================================================================
	 * ORDER REVIEW RIGHT PANEL (the white box from Daniel's screenshot)
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-checkout-review-order,
	body.woocommerce-checkout #order_review_heading,
	body.woocommerce-checkout #order_review,
	body.page-id-15 .woocommerce-checkout-review-order,
	body.page-id-15 #order_review_heading,
	body.page-id-15 #order_review {
		background-color: rgba(20, 16, 10, 0.92) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		border-radius: 3px !important;
		color: rgba(240, 235, 225, 0.92) !important;
	}
	body.woocommerce-checkout #order_review_heading,
	body.page-id-15 #order_review_heading {
		color: #CCC593 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		font-size: 16px !important;
		padding: 14px 18px !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table,
	body.woocommerce-checkout table.shop_table.woocommerce-checkout-review-order-table,
	body.page-id-15 .woocommerce-checkout-review-order-table,
	body.page-id-15 table.shop_table.woocommerce-checkout-review-order-table {
		background-color: transparent !important;
		border: none !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table th,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table td,
	body.page-id-15 .woocommerce-checkout-review-order-table th,
	body.page-id-15 .woocommerce-checkout-review-order-table td {
		color: rgba(240, 235, 225, 0.92) !important;
		border-color: rgba(204, 197, 147, 0.15) !important;
		background-color: transparent !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table thead th,
	body.page-id-15 .woocommerce-checkout-review-order-table thead th {
		color: #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
		font-size: 13px !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table .amount,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot .order-total .amount,
	body.page-id-15 .woocommerce-checkout-review-order-table .amount,
	body.page-id-15 .woocommerce-checkout-review-order-table tfoot .order-total .amount {
		color: #CCC593 !important;
		font-weight: 500 !important;
	}
	body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr.order-total th,
	body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr.order-total .amount,
	body.page-id-15 .woocommerce-checkout-review-order-table tfoot tr.order-total th,
	body.page-id-15 .woocommerce-checkout-review-order-table tfoot tr.order-total .amount {
		color: #CCC593 !important;
		font-weight: 600 !important;
		font-size: 16px !important;
	}

	/* ==================================================================
	 * PAYMENT METHOD PANEL (Stripe card box)
	 * ================================================================== */
	body.woocommerce-checkout #payment,
	body.woocommerce-checkout .woocommerce-checkout-payment,
	body.woocommerce-checkout ul.wc_payment_methods,
	body.page-id-15 #payment,
	body.page-id-15 .woocommerce-checkout-payment,
	body.page-id-15 ul.wc_payment_methods {
		background-color: rgba(20, 16, 10, 0.7) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
		color: rgba(240, 235, 225, 0.92) !important;
	}
	body.woocommerce-checkout #payment .payment_methods li,
	body.woocommerce-checkout ul.wc_payment_methods li,
	body.page-id-15 #payment .payment_methods li,
	body.page-id-15 ul.wc_payment_methods li {
		background-color: transparent !important;
		color: rgba(240, 235, 225, 0.92) !important;
		border-color: rgba(204, 197, 147, 0.15) !important;
	}
	body.woocommerce-checkout #payment .payment_methods li label,
	body.woocommerce-checkout ul.wc_payment_methods li label,
	body.page-id-15 #payment .payment_methods li label,
	body.page-id-15 ul.wc_payment_methods li label {
		color: rgba(240, 235, 225, 0.92) !important;
	}
	body.woocommerce-checkout #payment .payment_box,
	body.woocommerce-checkout .wc_payment_method .payment_box,
	body.page-id-15 #payment .payment_box,
	body.page-id-15 .wc_payment_method .payment_box {
		background-color: rgba(15, 12, 8, 0.85) !important;
		color: rgba(230, 225, 195, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
	}
	body.woocommerce-checkout #payment .payment_box::before,
	body.page-id-15 #payment .payment_box::before {
		border-bottom-color: rgba(15, 12, 8, 0.85) !important;
	}
	body.woocommerce-checkout .wc-stripe-elements-field,
	body.woocommerce-checkout .StripeElement,
	body.page-id-15 .wc-stripe-elements-field,
	body.page-id-15 .StripeElement {
		background-color: rgba(15, 12, 8, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.3) !important;
		border-radius: 2px !important;
		padding: 10px 12px !important;
	}
	body.woocommerce-checkout #payment .payment_box p,
	body.woocommerce-checkout #payment .payment_box label,
	body.page-id-15 #payment .payment_box p,
	body.page-id-15 #payment .payment_box label {
		color: rgba(230, 225, 195, 0.9) !important;
	}
	body.woocommerce-checkout #payment .payment_box a,
	body.page-id-15 #payment .payment_box a {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * TERMS + PRIVACY POLICY + PLACE ORDER
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-terms-and-conditions-wrapper,
	body.page-id-15 .woocommerce-terms-and-conditions-wrapper {
		color: rgba(230, 225, 195, 0.85) !important;
	}
	body.woocommerce-checkout .woocommerce-terms-and-conditions-wrapper a,
	body.page-id-15 .woocommerce-terms-and-conditions-wrapper a {
		color: #CCC593 !important;
	}
	body.woocommerce-checkout #place_order,
	body.page-id-15 #place_order {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
		border: 1px solid #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		padding: 14px 28px !important;
		font-size: 15px !important;
		border-radius: 3px !important;
	}
	body.woocommerce-checkout #place_order:hover,
	body.page-id-15 #place_order:hover {
		background-color: #E3DBA8 !important;
		border-color: #E3DBA8 !important;
	}

	/* ==================================================================
	 * NOTICES (errors, info, success during checkout)
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-error,
	body.woocommerce-checkout .woocommerce-message,
	body.page-id-15 .woocommerce-error,
	body.page-id-15 .woocommerce-message {
		background-color: rgba(20, 16, 10, 0.92) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.3) !important;
		border-left: 3px solid #CCC593 !important;
	}
	body.woocommerce-checkout .woocommerce-error a,
	body.woocommerce-checkout .woocommerce-message a,
	body.page-id-15 .woocommerce-error a,
	body.page-id-15 .woocommerce-message a {
		color: #CCC593 !important;
	}
	</style>
	<?php
}, 99999 );
