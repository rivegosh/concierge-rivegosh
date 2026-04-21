<?php
/**
 * Plugin Name: RG Checkout Select2 Dropdown
 * Description: Dark luxury skin for the select2 country/state open dropdown on
 *              /checkout/ (page-id-15). select2 teleports the open dropdown to
 *              <body> as a direct child — rg-checkout-coupon-fix.php §4 only
 *              styles the collapsed trigger (.select2-selection--single).
 *              This plugin targets the live dropdown panel, search field, and
 *              option items that appear when the user opens the Country field.
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: body.woocommerce-checkout + body.page-id-15 ONLY.         ║
 * ║ Priority 100006 — fires after rg-checkout-coupon-fix (100004).   ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root cause (2026-04-21 — Daniel screenshot):                     ║
 * ║  select2 appends .select2-dropdown to document.body directly.    ║
 * ║  Default WooCommerce + select2 styles give the dropdown a        ║
 * ║  white background and dark option text. On our dark luxury body  ║
 * ║  this produces: white panel over dark page + "France" option     ║
 * ║  barely visible (light text on near-white bg in hover state).   ║
 * ║  body.woocommerce-checkout is the ancestor that works for scope  ║
 * ║  because body IS the class element (unlike Amelia poppers which  ║
 * ║  escape to a different teleport root).                           ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_checkout() && ! is_page( 15 ) ) return;
	if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-checkout-select2-dropdown">

	/* ==================================================================
	 * 1. DROPDOWN PANEL — dark luxury container
	 *    .select2-dropdown is appended to body as direct child.
	 *    body.woocommerce-checkout is the ancestor → scope works.
	 * ================================================================== */
	body.woocommerce-checkout .select2-dropdown,
	body.page-id-15 .select2-dropdown {
		background-color: rgba(15, 12, 8, 0.97) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
		border-radius: 2px !important;
		box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6) !important;
	}

	/* ==================================================================
	 * 2. SEARCH FIELD — the filter input inside the open dropdown
	 * ================================================================== */
	body.woocommerce-checkout .select2-search--dropdown .select2-search__field,
	body.page-id-15 .select2-search--dropdown .select2-search__field {
		background-color: rgba(20, 16, 10, 0.9) !important;
		border: 1px solid rgba(204, 197, 147, 0.25) !important;
		color: rgba(230, 225, 195, 0.92) !important;
		border-radius: 2px !important;
		padding: 6px 10px !important;
		outline: none !important;
	}
	body.woocommerce-checkout .select2-search--dropdown .select2-search__field::placeholder,
	body.page-id-15 .select2-search--dropdown .select2-search__field::placeholder {
		color: rgba(204, 197, 147, 0.4) !important;
	}

	/* ==================================================================
	 * 3. OPTION ITEMS — default, highlighted, and selected states
	 * ================================================================== */
	body.woocommerce-checkout .select2-results__option,
	body.page-id-15 .select2-results__option {
		color: rgba(230, 225, 195, 0.88) !important;
		background-color: transparent !important;
		padding: 8px 12px !important;
	}
	/* Hover / keyboard-highlighted state */
	body.woocommerce-checkout .select2-results__option--highlighted,
	body.woocommerce-checkout .select2-results__option--highlighted[aria-selected],
	body.page-id-15 .select2-results__option--highlighted,
	body.page-id-15 .select2-results__option--highlighted[aria-selected] {
		background-color: rgba(204, 197, 147, 0.15) !important;
		color: rgba(230, 225, 195, 1) !important;
	}
	/* Already-selected item */
	body.woocommerce-checkout .select2-results__option[aria-selected="true"],
	body.page-id-15 .select2-results__option[aria-selected="true"] {
		background-color: rgba(204, 197, 147, 0.08) !important;
		color: rgba(204, 197, 147, 0.85) !important;
	}

	/* ==================================================================
	 * 4. RESULTS CONTAINER — ensure no white bg bleeds through
	 * ================================================================== */
	body.woocommerce-checkout .select2-results,
	body.woocommerce-checkout .select2-results__options,
	body.page-id-15 .select2-results,
	body.page-id-15 .select2-results__options {
		background-color: transparent !important;
	}

	</style>
	<?php
}, 100006 );
