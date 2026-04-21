<?php
/**
 * Plugin Name: RG Checkout Coupon Fix
 * Description: Four targeted fixes on /checkout/ (page-id-15):
 *              1. Coupon toggle double-padding — outer wrapper also got
 *                 padding: 14px from rg-checkout-luxury, making it 127px
 *                 for one text line. Fix: zero out outer, keep inner only.
 *              2. WC default blue left border on .woocommerce-info not
 *                 overridden on mobile — explicitly kills it.
 *              3. Mobile billing section white background — Colibri column
 *                 wrapping #customer_details has white bg on narrow viewports.
 *              4. showcoupon link colour — higher-specificity champagne.
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout + body.page-id-15 ONLY.         ║
 * ║ Priority 100004 — fires after rg-checkout-billing-dark (100002). ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root causes (2026-04-21 — Daniel screenshots):                   ║
 * ║  1. rg-checkout-luxury.php applies the same padding + dark bg    ║
 * ║     to BOTH .woocommerce-form-coupon-toggle (outer) AND          ║
 * ║     .woocommerce-info (inner child). The outer wrapper adds      ║
 * ║     28px extra vertical space → 127px for a single-line box.     ║
 * ║  2. WC default .woocommerce-info has border-left: 3px solid      ║
 * ║     blue (#3d9cd2). On mobile, the override from luxury plugin   ║
 * ║     may not have sufficient specificity without body#colibri.    ║
 * ║  3. Colibri wraps WC checkout content in .h-column__content /   ║
 * ║     .entry-content which can have white bg on mobile viewports.  ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-coupon-fix">

	/* ==================================================================
	 * 1. COUPON TOGGLE — zero out outer wrapper, style only the inner
	 *    rg-checkout-luxury.php applied padding + bg to both outer and
	 *    inner, causing the outer to double-pad to 127px.
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-form-coupon-toggle,
	body.page-id-15 .woocommerce-form-coupon-toggle {
		padding: 0 !important;
		background: transparent !important;
		border: none !important;
		border-radius: 0 !important;
		margin-bottom: 16px !important;
	}
	/* Kill WooCommerce's default thick blue left border on .woocommerce-info */
	body.woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info,
	body.woocommerce-checkout .woocommerce-info,
	body.page-id-15 .woocommerce-form-coupon-toggle .woocommerce-info,
	body.page-id-15 .woocommerce-info {
		background-color: rgba(20, 16, 10, 0.88) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		border-left: 3px solid #CCC593 !important;
		color: rgba(230, 225, 195, 0.88) !important;
		padding: 10px 16px !important;
		border-radius: 3px !important;
		margin: 0 !important;
		/* Ensure no WC icon pseudo-element bleeds */
		display: flex !important;
		align-items: center !important;
		gap: 6px !important;
	}
	/* WC injects a ::before icon — kill or keep neutral */
	body.woocommerce-checkout .woocommerce-info::before,
	body.page-id-15 .woocommerce-info::before {
		color: #CCC593 !important;
		font-size: 14px !important;
		line-height: 1 !important;
	}

	/* ==================================================================
	 * 2. showcoupon LINK — champagne gold, higher specificity
	 * ================================================================== */
	body.woocommerce-checkout .woocommerce-form-coupon-toggle a.showcoupon,
	body.woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info a,
	body.woocommerce-checkout .woocommerce-info a.showcoupon,
	body.page-id-15 .woocommerce-form-coupon-toggle a,
	body.page-id-15 .woocommerce-info a {
		color: #CCC593 !important;
		text-decoration: underline !important;
		text-underline-offset: 3px !important;
	}

	/* ==================================================================
	 * 3. MOBILE BILLING — kill white bg on Colibri column containers
	 *    On narrow viewports, .h-column__content / .entry-content can
	 *    render white behind #customer_details dark wrapper.
	 * ================================================================== */
	body.woocommerce-checkout .entry-content,
	body.woocommerce-checkout .h-column__content,
	body.woocommerce-checkout .h-column,
	body.woocommerce-checkout .woocommerce,
	body.woocommerce-checkout .woocommerce-page,
	body.page-id-15 .entry-content,
	body.page-id-15 .h-column__content,
	body.page-id-15 .h-column,
	body.page-id-15 .woocommerce {
		background-color: transparent !important;
	}
	/* Also cover the WC checkout form wrapper itself */
	body.woocommerce-checkout form.woocommerce-checkout,
	body.page-id-15 form.woocommerce-checkout {
		background-color: transparent !important;
	}
	/* On mobile, WC wraps billing in .woocommerce-billing-fields */
	body.woocommerce-checkout .woocommerce-billing-fields,
	body.woocommerce-checkout .woocommerce-shipping-fields,
	body.woocommerce-checkout .woocommerce-additional-fields,
	body.page-id-15 .woocommerce-billing-fields,
	body.page-id-15 .woocommerce-shipping-fields {
		background-color: transparent !important;
	}

	/* ==================================================================
	 * 4. select2 COUNTRY — fix vertical alignment ("France" at bottom)
	 *    select2 wraps country in .select2-selection--single with fixed
	 *    height; rendered text may drop to bottom if line-height > height.
	 * ================================================================== */
	body.woocommerce-checkout .select2-container--default .select2-selection--single,
	body.page-id-15 .select2-container--default .select2-selection--single {
		height: 44px !important;
		display: flex !important;
		align-items: center !important;
		background-color: rgba(15, 12, 8, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
		border-radius: 2px !important;
	}
	body.woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__rendered,
	body.page-id-15 .select2-container--default .select2-selection--single .select2-selection__rendered {
		color: rgba(230, 225, 195, 0.92) !important;
		line-height: 1.4 !important;
		padding: 0 30px 0 12px !important;
		width: 100% !important;
	}
	body.woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__arrow,
	body.page-id-15 .select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 44px !important;
		top: 0 !important;
	}
	body.woocommerce-checkout .select2-container--default .select2-selection--single .select2-selection__arrow b,
	body.page-id-15 .select2-container--default .select2-selection--single .select2-selection__arrow b {
		border-top-color: rgba(204, 197, 147, 0.7) !important;
	}

	</style>
	<?php
}, 100004 );
