<?php
/**
 * Plugin Name: RG Checkout Luxury
 * Description: Scoped luxury skin for /checkout/ (page-id-15) — hero H2 size,
 *              coupon toggle stable dark bg, payment-request buttons skin,
 *              contrast floor on all text.
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.page-id-15 ONLY (zero bleed).                        ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Problems (2026-04-20 — user Daniel screenshots):                 ║
 * ║  1. H2 "your destination" = 46px — too big for checkout hero.    ║
 * ║  2. Coupon toggle (.woocommerce-form-coupon-toggle) bg flickers  ║
 * ║     white↔dark on scroll (intermittent / stale cached CSS).      ║
 * ║  3. Apple Pay / Google Pay payment-request buttons render in     ║
 * ║     default Stripe theme — don't match luxury skin.              ║
 * ║  4. "Place order" button needs luxury champagne style.           ║
 * ║                                                                   ║
 * ║ Contrast floor (WCAG AA 4.5:1 minimum):                          ║
 * ║  - all readable text ≥ rgba(230, 225, 195, 0.88) on dark         ║
 * ║  - primary gold = #CCC593 on rgb(15,12,8) = ratio ~ 8.9:1 ✓      ║
 * ║                                                                   ║
 * ║ NO functionality touches. NO form-field renames. NO plugin       ║
 * ║ reconfiguration. CSS only.                                       ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	?>
	<style id="rg-checkout-luxury">
	/* ==================================================================
	 * HERO H2 — bring from 46px → 28px (still luxurious, not shouting)
	 * ================================================================== */
	body#colibri.page-id-15 h2.h-global-transition-all,
	body#colibri.page-id-15 .entry-title,
	body#colibri.page-id-15 .h-heading h2 {
		font-size: 28px !important;
		line-height: 1.2 !important;
		letter-spacing: 0.04em !important;
	}

	/* ==================================================================
	 * COUPON TOGGLE — stable dark bg, readable link, subtle gold border
	 * ================================================================== */
	body#colibri.page-id-15 .woocommerce-form-coupon-toggle,
	body#colibri.page-id-15 .woocommerce-info,
	body#colibri.page-id-15 .woocommerce-form-coupon-toggle .woocommerce-info {
		background-color: rgba(20, 16, 10, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		border-left-width: 3px !important;
		border-left-color: #CCC593 !important;
		color: rgba(230, 225, 195, 0.88) !important;
		padding: 14px 18px !important;
		border-radius: 3px !important;
	}
	body#colibri.page-id-15 .woocommerce-form-coupon-toggle a,
	body#colibri.page-id-15 .woocommerce-form-coupon-toggle .showcoupon,
	body#colibri.page-id-15 .woocommerce-info a {
		color: #CCC593 !important;
		text-decoration: underline !important;
		text-underline-offset: 3px !important;
	}
	body#colibri.page-id-15 .woocommerce-form-coupon {
		background-color: rgba(20, 16, 10, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		padding: 16px !important;
		border-radius: 3px !important;
	}
	body#colibri.page-id-15 .woocommerce-form-coupon input[type="text"] {
		background-color: rgba(15, 12, 8, 0.9) !important;
		color: rgba(240, 235, 225, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
	}
	body#colibri.page-id-15 .woocommerce-form-coupon button {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
		border: 1px solid #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.04em !important;
	}

	/* ==================================================================
	 * ORDER REVIEW TABLE — ensure labels/totals contrast
	 * ================================================================== */
	body#colibri.page-id-15 .woocommerce-checkout-review-order-table th,
	body#colibri.page-id-15 .woocommerce-checkout-review-order-table td {
		color: rgba(240, 235, 225, 0.9) !important;
		border-color: rgba(204, 197, 147, 0.15) !important;
	}
	body#colibri.page-id-15 .woocommerce-checkout-review-order-table tr.order-total th,
	body#colibri.page-id-15 .woocommerce-checkout-review-order-table tr.order-total td,
	body#colibri.page-id-15 .woocommerce-checkout-review-order-table tr.order-total .amount {
		color: #CCC593 !important;
		font-weight: 600 !important;
		font-size: 17px !important;
	}

	/* ==================================================================
	 * PAYMENT BOX — tighten border, ensure labels readable
	 * ================================================================== */
	body#colibri.page-id-15 #payment,
	body#colibri.page-id-15 .woocommerce-checkout-payment {
		background-color: rgba(20, 16, 10, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
	}
	body#colibri.page-id-15 #payment ul.payment_methods li label,
	body#colibri.page-id-15 #payment .payment_box {
		color: rgba(240, 235, 225, 0.9) !important;
	}
	body#colibri.page-id-15 #payment .payment_box {
		background-color: rgba(15, 12, 8, 0.7) !important;
		border: 1px solid rgba(204, 197, 147, 0.15) !important;
		color: rgba(230, 225, 195, 0.88) !important;
	}

	/* ==================================================================
	 * PAYMENT REQUEST BUTTONS (Apple Pay / Google Pay)
	 * Stripe's PRB renders as a black button by default — keep black
	 * but add champagne-gold 1px outline to tie into luxury palette.
	 * ================================================================== */
	body#colibri.page-id-15 #wc-stripe-payment-request-button,
	body#colibri.page-id-15 .wc-stripe-payment-request-button-separator,
	body#colibri.page-id-15 .wc-stripe-payment-request-wrapper {
		background-color: transparent !important;
	}
	body#colibri.page-id-15 #wc-stripe-payment-request-button button,
	body#colibri.page-id-15 #wc-stripe-payment-request-button .StripeElement {
		border: 1px solid rgba(204, 197, 147, 0.5) !important;
		border-radius: 4px !important;
		box-shadow: 0 1px 6px rgba(0, 0, 0, 0.25) !important;
	}
	body#colibri.page-id-15 .wc-stripe-payment-request-button-separator {
		color: rgba(220, 215, 200, 0.7) !important;
		border-top: 1px solid rgba(204, 197, 147, 0.15) !important;
		margin: 18px 0 !important;
	}

	/* ==================================================================
	 * PLACE ORDER BUTTON — champagne gold solid
	 * ================================================================== */
	body#colibri.page-id-15 #place_order,
	body#colibri.page-id-15 button#place_order {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
		border: 1px solid #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		padding: 14px 32px !important;
		font-size: 15px !important;
	}
	body#colibri.page-id-15 #place_order:hover {
		background-color: #E3DBA8 !important;
		border-color: #E3DBA8 !important;
	}

	/* ==================================================================
	 * FORM LABELS — slightly brighter for readability
	 * ================================================================== */
	body#colibri.page-id-15 .woocommerce form .form-row label,
	body#colibri.page-id-15 .woocommerce-checkout label {
		color: rgba(240, 235, 225, 0.85) !important;
		font-size: 13px !important;
		letter-spacing: 0.02em !important;
	}
	</style>
	<?php
}, 99999 );
