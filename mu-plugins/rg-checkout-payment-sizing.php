<?php
/**
 * Plugin Name: RG Checkout Payment Sizing
 * Description: Typography + input sizing for the payment section on /checkout/
 *              (page-id-15). Problems (2026-04-21):
 *              1. Radio buttons + checkboxes too small (~13px) — hard to tap.
 *              2. Payment method labels ("Stripe", "card") underset at 13px.
 *              3. T&C checkbox text 13px — too small for legal copy.
 *              4. Privacy notice 16px — larger than it needs to be.
 *              Fix: inputs scale(1.5) with margin compensation; labels 15px;
 *              T&C text 14px; privacy notice 13px.
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout #payment ONLY.                  ║
 * ║ Priority 100009 — fires after rg-checkout-order-hierarchy        ║
 * ║ (100008).                                                        ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-payment-sizing">

	/* ==================================================================
	 * 1. RADIO BUTTONS + CHECKBOXES — 50% bigger via scale()
	 *    transform:scale(1.5) enlarges visually without affecting layout
	 *    flow. margin compensation stops the scaled input from overlapping
	 *    adjacent label text. transform-origin:center keeps alignment.
	 * ================================================================== */
	body.woocommerce-checkout #payment input[type="radio"],
	body.woocommerce-checkout #payment input[type="checkbox"] {
		transform: scale(1.5) !important;
		transform-origin: center center !important;
		margin: 3px 8px 3px 3px !important;
		flex-shrink: 0 !important;
	}

	/* ==================================================================
	 * 2. PAYMENT METHOD LABELS — "Stripe", "card", "Credit Card"
	 *    .wc_payment_method label wraps the payment icon + method name.
	 *    15px makes these read as proper option labels.
	 * ================================================================== */
	body.woocommerce-checkout #payment .wc_payment_method label,
	body.woocommerce-checkout #payment .wc_payment_methods .wc_payment_method > label {
		font-size: 15px !important;
		font-weight: 500 !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* ==================================================================
	 * 3. T&C CHECKBOX TEXT — "I have read and agree to the website
	 *    terms and conditions" — +1pt from 13px → 14px.
	 *    Must be un-ticked by default (GDPR active consent — Planet49).
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-terms-and-conditions-checkbox-text,
	body.woocommerce-checkout .woocommerce-terms-and-conditions-checkbox-text a {
		font-size: 14px !important;
	}

	/* ==================================================================
	 * 4. PRIVACY NOTICE — "Your personal data will be used to process
	 *    your order..." — smaller (−3pt: 16px → 13px) as it's background
	 *    legal copy, not a primary CTA.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-privacy-policy-text,
	body.woocommerce-checkout .woocommerce-privacy-policy-text p {
		font-size: 13px !important;
		color: rgba(204, 197, 147, 0.55) !important;
		line-height: 1.5 !important;
	}

	</style>
	<?php
}, 100009 );
