<?php
/**
 * Plugin Name: RG Order Received Billing Fix
 * Description: Counter-skin that catches the WHITE Billing Address card + light
 *              email pill on the order-received "Thank You" page. The base
 *              rg-order-received-luxury.php targets standard WooCommerce
 *              markup (.woocommerce-customer-details address), but Colibri /
 *              theme override renders a custom layout (ORDER NUMBER strip +
 *              ORDER DETAILS + BILLING ADDRESS cards) with different classes.
 *              This plugin casts a wider net scoped to body.woocommerce-order-
 *              received only — zero bleed.
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-order-received only.                     ║
 * ║ Priority: wp_footer 99999 (after base order-received luxury).    ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Problem (2026-04-20 — Daniel screenshot):                        ║
 * ║  - "Thank you for your order" text dark on dark (invisible)       ║
 * ║  - "BILLING ADDRESS" card light gray with dark text               ║
 * ║  - Email pill inside billing card has white background            ║
 * ║                                                                   ║
 * ║ Contrast floor: champagne text on dark ~9:1 ✓ (WCAG AAA).        ║
 * ║ CSS-only.                                                         ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_wc_endpoint_url' ) ) return;
	if ( ! is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-order-received-billing-fix">
	/* ==================================================================
	 * "THANK YOU FOR YOUR ORDER" paragraph — force champagne
	 * The theme renders this as bare <p> without woocommerce-notice class.
	 * ================================================================== */
	body.woocommerce-order-received p,
	body.woocommerce-order-received .entry-content p,
	body.woocommerce-order-received main p,
	body.woocommerce-order-received .h-section p {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* ==================================================================
	 * BILLING ADDRESS + SHIPPING ADDRESS cards — broad net
	 * The theme uses classes like .woocommerce-column--billing-address or
	 * a custom layout. We override ANY .address / address element / any
	 * element with "address" or "billing" in class name within the order
	 * received body.
	 * ================================================================== */
	body.woocommerce-order-received address,
	body.woocommerce-order-received .woocommerce-column--billing-address,
	body.woocommerce-order-received .woocommerce-column--shipping-address,
	body.woocommerce-order-received .woocommerce-column--billing-address address,
	body.woocommerce-order-received .woocommerce-column--shipping-address address,
	body.woocommerce-order-received .billing-address,
	body.woocommerce-order-received .shipping-address,
	body.woocommerce-order-received [class*="billing-address"],
	body.woocommerce-order-received [class*="shipping-address"],
	body.woocommerce-order-received [class*="customer-details"] address,
	body.woocommerce-order-received [class*="customer-details"] > div,
	body.woocommerce-order-received .h-section [class*="address"] {
		background-color: rgba(20, 16, 10, 0.7) !important;
		color: rgba(230, 225, 195, 0.92) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		border-radius: 3px !important;
		padding: 18px 22px !important;
		font-style: normal !important;
		line-height: 1.75 !important;
	}
	body.woocommerce-order-received address p,
	body.woocommerce-order-received address span,
	body.woocommerce-order-received .woocommerce-column--billing-address p,
	body.woocommerce-order-received .woocommerce-column--shipping-address p,
	body.woocommerce-order-received .billing-address p,
	body.woocommerce-order-received .shipping-address p,
	body.woocommerce-order-received [class*="billing-address"] p,
	body.woocommerce-order-received [class*="shipping-address"] p,
	body.woocommerce-order-received [class*="billing-address"] span,
	body.woocommerce-order-received [class*="shipping-address"] span {
		color: rgba(230, 225, 195, 0.92) !important;
		background-color: transparent !important;
	}

	/* ==================================================================
	 * EMAIL PILL / INLINE EMAIL DISPLAY — kill the white pill bg
	 * ================================================================== */
	body.woocommerce-order-received address a,
	body.woocommerce-order-received .woocommerce-column a,
	body.woocommerce-order-received [class*="billing-address"] a,
	body.woocommerce-order-received [class*="shipping-address"] a {
		color: #CCC593 !important;
		background-color: transparent !important;
	}
	body.woocommerce-order-received address a[href^="mailto:"],
	body.woocommerce-order-received [class*="billing-address"] a[href^="mailto:"],
	body.woocommerce-order-received [class*="shipping-address"] a[href^="mailto:"] {
		background-color: transparent !important;
		color: #CCC593 !important;
		padding: 0 !important;
		border-radius: 0 !important;
	}
	body.woocommerce-order-received .email,
	body.woocommerce-order-received .customer-email,
	body.woocommerce-order-received [class*="email"] {
		background-color: transparent !important;
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * Broad defensive — any element with white/light bg inside the
	 * order-received page gets darkened.
	 * ================================================================== */
	body.woocommerce-order-received [style*="background-color: #fff"],
	body.woocommerce-order-received [style*="background-color:#fff"],
	body.woocommerce-order-received [style*="background-color: rgb(255"],
	body.woocommerce-order-received [style*="background-color:rgb(255"],
	body.woocommerce-order-received [style*="background: #fff"],
	body.woocommerce-order-received [style*="background:#fff"],
	body.woocommerce-order-received [style*="background-color: #F"],
	body.woocommerce-order-received [style*="background-color: #E"],
	body.woocommerce-order-received [style*="background-color: rgb(24"] {
		background-color: rgba(20, 16, 10, 0.7) !important;
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* ==================================================================
	 * Section titles on the order-received page
	 * ================================================================== */
	body.woocommerce-order-received h2,
	body.woocommerce-order-received h3,
	body.woocommerce-order-received .woocommerce-column__title,
	body.woocommerce-order-received [class*="column__title"] {
		color: #CCC593 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
	}
	</style>
	<?php
}, 99999 );
