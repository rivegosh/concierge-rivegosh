<?php
/**
 * Plugin Name: RG Cart Coming Soon Fix
 * Description: Three targeted fixes for /your-booking/ (page-id-14):
 *              1. WC Coming Soon block — black text on dark body → champagne (visible)
 *              2. Cart item meta (Amelia booking details under product name) → champagne
 *              3. Global nav sub-menu link color → champagne (black on dark = invisible)
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope:                                                           ║
 * ║  - body.page-id-14 scoped: cart item meta + coming-soon block   ║
 * ║  - global: nav .sub-menu link color (affects all pages)         ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root causes fixed (2026-04-21):                                  ║
 * ║  1. woocommerce_coming_soon=yes + store_pages_only=yes blocks   ║
 * ║     non-admin users from /your-booking/ (WC cart). The Coming   ║
 * ║     Soon placeholder block renders with color:rgb(0,0,0) on the ║
 * ║     site's dark body (rgb(15,12,8)) → invisible text.           ║
 * ║  2. Amelia WC cart items render booking meta (transfer type,    ║
 * ║     date, airport, passengers) via .woocommerce-cart-item__meta ║
 * ║     which was not covered by rg-cart-luxury.php → black text.  ║
 * ║  3. .sub-menu has color:rgb(0,0,0) globally — all nav dropdown  ║
 * ║     link text inherits black on dark sections.                  ║
 * ║                                                                   ║
 * ║ NOTE: WC Coming Soon woocommerce_coming_soon=yes +              ║
 * ║       woocommerce_store_pages_only=yes means non-admin users    ║
 * ║       CANNOT access /your-booking/ or /checkout/. They see the  ║
 * ║       Coming Soon placeholder. This is intentional (testing     ║
 * ║       mode) but blocks real customer bookings. When store is    ║
 * ║       ready to launch, disable Coming Soon in WC settings or    ║
 * ║       via: wp option update woocommerce_coming_soon no          ║
 * ║                                                                   ║
 * ║ Priority 100000 (fires after rg-cart-luxury.php at 99999).     ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-cart-coming-soon-fix">

	/* ==================================================================
	 * 1. WC COMING SOON BLOCK — champagne text on dark body
	 * Fires for any user (admin or not) who sees the coming-soon placeholder.
	 * Scoped to page-id-14 to avoid bleed.
	 * ================================================================== */
	body.page-id-14 .wp-block-woocommerce-coming-soon,
	body.page-id-14 .woocommerce-coming-soon-store-only,
	body.page-id-14 .woocommerce-coming-soon-store-only *,
	body.page-id-14 .wp-block-woocommerce-coming-soon h1,
	body.page-id-14 .wp-block-woocommerce-coming-soon h2,
	body.page-id-14 .wp-block-woocommerce-coming-soon p,
	body.page-id-14 .wp-block-woocommerce-coming-soon a,
	body.page-id-14 .wp-block-woocommerce-coming-soon .wp-block-heading {
		color: rgba(230, 225, 195, 0.92) !important;
	}
	/* Preview banner shown to admins */
	body.page-id-14 .woocommerce-store-coming-soon-preview-banner,
	body.page-id-14 .woocommerce-store-coming-soon-preview-banner * {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* ==================================================================
	 * 2. CART ITEM META — Amelia booking details shown under product name
	 * rg-cart-luxury.php covers .shop_table td/th but not the meta lines
	 * (transfer type, transfer date, airport, passengers, suitcases).
	 * ================================================================== */
	body#colibri.page-id-14 .woocommerce-cart-item__meta,
	body#colibri.page-id-14 .cart_item .wc-item-meta,
	body#colibri.page-id-14 .cart_item .wc-item-meta li,
	body#colibri.page-id-14 .cart_item .wc-item-meta .wc-item-meta-label,
	body#colibri.page-id-14 .cart_item .item-meta,
	body#colibri.page-id-14 .cart_item dl.variation,
	body#colibri.page-id-14 .cart_item dl.variation dt,
	body#colibri.page-id-14 .cart_item dl.variation dd,
	body#colibri.page-id-14 .cart_item dl.variation p,
	body#colibri.page-id-14 .woocommerce-cart-form .cart_item td * {
		color: rgba(230, 225, 195, 0.85) !important;
	}
	/* Broad backstop: anything inside a cart table row that inherits black */
	body#colibri.page-id-14 table.cart td,
	body#colibri.page-id-14 table.cart td p,
	body#colibri.page-id-14 table.cart td span,
	body#colibri.page-id-14 table.cart td a,
	body#colibri.page-id-14 table.cart td dl,
	body#colibri.page-id-14 table.cart td dt,
	body#colibri.page-id-14 table.cart td dd {
		color: rgba(230, 225, 195, 0.88) !important;
	}
	/* Restore dark text on checkout button (white-on-champagne) */
	body#colibri.page-id-14 .checkout-button,
	body#colibri.page-id-14 a.checkout-button,
	body#colibri.page-id-14 .checkout-button * {
		color: #0f0c08 !important;
	}
	/* Restore gold text on coupon/update buttons */
	body#colibri.page-id-14 button[name="apply_coupon"],
	body#colibri.page-id-14 button[name="update_cart"] {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * 3. NAV SUB-MENU LINKS — global (all pages)
	 * .sub-menu has computed color:rgb(0,0,0) — on dark-bg Colibri sections
	 * this makes all dropdown nav text invisible.
	 * ================================================================== */
	.sub-menu a,
	.sub-menu li a,
	nav .sub-menu a,
	.h-menu .sub-menu a,
	.h-navigation .sub-menu a,
	.h-mobile-menu .sub-menu a {
		color: rgba(230, 225, 195, 0.92) !important;
	}
	.sub-menu a:hover,
	.h-menu .sub-menu a:hover {
		color: #CCC593 !important;
	}

	</style>
	<?php
}, 100000 );
