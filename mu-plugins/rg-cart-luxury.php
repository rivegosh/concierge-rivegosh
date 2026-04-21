<?php
/**
 * Plugin Name: RG Cart Luxury
 * Description: Scoped luxury skin for /your-booking/ (page-id-14) — dark body,
 *              dark cart table + totals, champagne price contrast, proceed
 *              to checkout button skinned, coupon row readable.
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.page-id-14 ONLY (zero bleed).                        ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Problem (2026-04-20 — Daniel screenshot):                        ║
 * ║  Cart page rendered with white cart totals box, champagne-on-    ║
 * ║  white prices (invisible), light product table — clashed with   ║
 * ║  the dark luxury site theme end-to-end flow.                     ║
 * ║                                                                   ║
 * ║ Contrast floor (WCAG AA 4.5:1 min):                              ║
 * ║  - table text   rgba(240,235,225,0.9) on rgba(20,16,10,0.6)      ║
 * ║  - total amount #CCC593 on rgb(15,12,8) ≈ 8.9:1 ✓                ║
 * ║  - button text #0f0c08 on #CCC593 ≈ 8.9:1 ✓                      ║
 * ║                                                                   ║
 * ║ CSS-only. NO functionality touches.                              ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_cart() && ! is_page( 14 ) ) return;
	?>
	<style id="rg-cart-luxury">
	/* ==================================================================
	 * CART PRODUCT TABLE — dark translucent with gold hairline
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-form,
	body#colibri.page-id-14 .shop_table,
	body#colibri.page-id-14 table.cart,
	body#colibri.page-id-14 .woocommerce-cart-form__contents {
		background-color: rgba(20, 16, 10, 0.6) !important;
		border: 1px solid rgba(204, 197, 147, 0.2) !important;
		border-radius: 3px !important;
	}
	body#colibri.page-id-14 .shop_table th,
	body#colibri.page-id-14 .shop_table td,
	body#colibri.page-id-14 table.cart th,
	body#colibri.page-id-14 table.cart td {
		color: rgba(240, 235, 225, 0.9) !important;
		border-color: rgba(204, 197, 147, 0.15) !important;
		background-color: transparent !important;
	}
	body#colibri.page-id-14 .shop_table thead th {
		color: #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
		font-size: 13px !important;
	}
	body#colibri.page-id-14 .shop_table .product-name a,
	body#colibri.page-id-14 table.cart .product-name a {
		color: rgba(240, 235, 225, 0.95) !important;
	}
	body#colibri.page-id-14 .shop_table .product-price,
	body#colibri.page-id-14 .shop_table .product-subtotal,
	body#colibri.page-id-14 .shop_table .amount,
	body#colibri.page-id-14 table.cart .amount {
		color: #CCC593 !important;
		font-weight: 500 !important;
	}
	body#colibri.page-id-14 .shop_table .product-remove a.remove {
		color: rgba(204, 197, 147, 0.7) !important;
		background: transparent !important;
	}
	body#colibri.page-id-14 .shop_table .product-remove a.remove:hover {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * QTY INPUT
	 * ================================================================== */
	body#colibri.page-id-14 .shop_table .quantity input[type="number"],
	body#colibri.page-id-14 .woocommerce-cart-form input.qty {
		background-color: rgba(15, 12, 8, 0.9) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
		border-radius: 2px !important;
	}

	/* ==================================================================
	 * COUPON ROW
	 * ================================================================== */
	body#colibri.page-id-14 .coupon input[name="coupon_code"],
	body#colibri.page-id-14 .woocommerce-cart-form .coupon input[type="text"] {
		background-color: rgba(15, 12, 8, 0.9) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
	}
	body#colibri.page-id-14 .coupon button[name="apply_coupon"],
	body#colibri.page-id-14 .woocommerce-cart-form button[name="apply_coupon"],
	body#colibri.page-id-14 button[name="update_cart"] {
		background-color: transparent !important;
		color: #CCC593 !important;
		border: 1px solid #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
		font-size: 13px !important;
	}
	body#colibri.page-id-14 .coupon button[name="apply_coupon"]:hover,
	body#colibri.page-id-14 button[name="update_cart"]:hover {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
	}

	/* ==================================================================
	 * CART TOTALS BOX (the white box from Daniel's screenshot)
	 * ================================================================== */
	body#colibri.page-id-14 .cart_totals,
	body#colibri.page-id-14 .cart-collaterals .cart_totals {
		background-color: rgba(20, 16, 10, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.3) !important;
		border-radius: 3px !important;
		padding: 24px !important;
	}
	body#colibri.page-id-14 .cart_totals h2 {
		color: #CCC593 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		font-size: 18px !important;
		margin-bottom: 18px !important;
	}
	body#colibri.page-id-14 .cart_totals .shop_table,
	body#colibri.page-id-14 .cart_totals table {
		background-color: transparent !important;
		border: none !important;
	}
	body#colibri.page-id-14 .cart_totals th,
	body#colibri.page-id-14 .cart_totals td {
		color: rgba(240, 235, 225, 0.9) !important;
		border-color: rgba(204, 197, 147, 0.15) !important;
		background-color: transparent !important;
		padding: 12px 8px !important;
	}
	body#colibri.page-id-14 .cart_totals .cart-subtotal .amount,
	body#colibri.page-id-14 .cart_totals .shipping .amount,
	body#colibri.page-id-14 .cart_totals .tax-rate .amount {
		color: rgba(240, 235, 225, 0.95) !important;
		font-weight: 500 !important;
	}
	body#colibri.page-id-14 .cart_totals .order-total th,
	body#colibri.page-id-14 .cart_totals .order-total td,
	body#colibri.page-id-14 .cart_totals .order-total .amount,
	body#colibri.page-id-14 .cart_totals tr.order-total th,
	body#colibri.page-id-14 .cart_totals tr.order-total td,
	body#colibri.page-id-14 .cart_totals tr.order-total .amount {
		color: #CCC593 !important;
		font-weight: 600 !important;
		font-size: 17px !important;
	}
	body#colibri.page-id-14 .cart_totals .includes_tax,
	body#colibri.page-id-14 .cart_totals small {
		color: rgba(220, 215, 200, 0.7) !important;
	}

	/* ==================================================================
	 * PROCEED TO CHECKOUT BUTTON — solid champagne
	 * ================================================================== */
	body#colibri.page-id-14 .wc-proceed-to-checkout .checkout-button,
	body#colibri.page-id-14 a.checkout-button,
	body#colibri.page-id-14 .checkout-button.button {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
		border: 1px solid #CCC593 !important;
		font-weight: 600 !important;
		letter-spacing: 0.06em !important;
		text-transform: uppercase !important;
		padding: 14px 24px !important;
		font-size: 15px !important;
		border-radius: 3px !important;
	}
	body#colibri.page-id-14 .wc-proceed-to-checkout .checkout-button:hover,
	body#colibri.page-id-14 a.checkout-button:hover {
		background-color: #E3DBA8 !important;
		border-color: #E3DBA8 !important;
	}

	/* ==================================================================
	 * NOTICES (added to cart / removed / errors)
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-message,
	body#colibri.page-id-14 .woocommerce-info,
	body#colibri.page-id-14 .woocommerce-error {
		background-color: rgba(20, 16, 10, 0.9) !important;
		color: rgba(240, 235, 225, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		border-left: 3px solid #CCC593 !important;
		border-radius: 3px !important;
	}
	body#colibri.page-id-14 .woocommerce-message a,
	body#colibri.page-id-14 .woocommerce-info a {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * EMPTY CART
	 * ================================================================== */
	body#colibri.page-id-14 .cart-empty,
	body#colibri.page-id-14 .return-to-shop a.button {
		color: rgba(240, 235, 225, 0.9) !important;
	}
	body#colibri.page-id-14 .return-to-shop .button {
		background-color: transparent !important;
		color: #CCC593 !important;
		border: 1px solid #CCC593 !important;
		letter-spacing: 0.04em !important;
		text-transform: uppercase !important;
	}
	body#colibri.page-id-14 .return-to-shop .button:hover {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
	}

	/* ==================================================================
	 * SHIPPING CALCULATOR (if active)
	 * ================================================================== */
	body#colibri.page-id-14 .shipping-calculator-button {
		color: #CCC593 !important;
		text-decoration: underline !important;
		text-underline-offset: 3px !important;
	}
	body#colibri.page-id-14 .shipping-calculator-form input,
	body#colibri.page-id-14 .shipping-calculator-form select {
		background-color: rgba(15, 12, 8, 0.9) !important;
		color: rgba(240, 235, 225, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
	}
	</style>
	<?php
}, 99999 );
