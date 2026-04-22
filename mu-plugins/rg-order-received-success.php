<?php
/**
 * Plugin Name: RG Order Received Success
 * Description: Makes /checkout/order-received/ feel complete in both views:
 *              (a) Full view (with ?key=): order-details table layout fixes —
 *                  kills "Appointment Info" gap, stops "1:00 am" line wrap,
 *                  top-aligns the totals column.
 *              (b) Stripped view (no key / guest): prominent green SUCCESS
 *                  banner + Thank-you + Next-steps line so the page reads
 *                  as a complete confirmation even when order details are
 *                  hidden by WC security.
 *              Uses woocommerce_thankyou_order_received_text filter for the
 *              copy and priority 100011 CSS for all layout.
 * Author: RG
 * Version: 1.1.0
 * Created: 2026-04-22
 *
 * WHY THIS FILE EXISTS:
 *   Daniel (through Roderic) requested a luxury "SUCCESS" confirmation banner
 *   on the order-received page after the first real test order (#74130)
 *   revealed a plain-text "Thank you" notice and a cramped order-details
 *   table with big gaps under "Appointment Info" plus "1:00 am" wrapping
 *   onto a new line.
 *
 *   This plugin does NOT edit the sealed rg-order-received-billing-fix.php
 *   (frozen per Rule 9). It ships additive overrides at priority 100011.
 *
 * GitHub: rivegosh/concierge-rivegosh
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Replace the default "Thank you. Your order has been received." with a
 * richer, structured message that styles into a prominent SUCCESS banner.
 * Applies in both stripped (no key) and full views.
 */
add_filter( 'woocommerce_thankyou_order_received_text', function ( $text, $order ) {
	return
		'<span class="rg-success-title">SUCCESS</span>'
		. '<span class="rg-success-msg">Thank you. Your order has been received.</span>'
		. '<span class="rg-success-next">Your chauffeur service will confirm your booking by email shortly.</span>';
}, 20, 2 );

add_action( 'wp_footer', function () {
	if ( ! function_exists( 'is_wc_endpoint_url' ) ) return;
	if ( ! is_wc_endpoint_url( 'order-received' ) ) return;
	?>
	<style id="rg-order-received-success">

	/* ==================================================================
	 * 1. SUCCESS BANNER (woocommerce-notice)
	 *    Target the top info-notice that contains our filtered spans.
	 *    Green accent + larger typography. Keeps dark-luxury body.
	 * ================================================================== */
	body.woocommerce-order-received .woocommerce-notice,
	body.woocommerce-order-received .woocommerce-thankyou-order-received,
	body.woocommerce-order-received .woocommerce-notice--info {
		background: rgba(122, 167, 128, 0.06) !important;
		border-left: 4px solid #7aa780 !important;
		padding: 24px 28px !important;
		border-radius: 4px !important;
		color: rgba(230, 225, 195, 0.95) !important;
		margin: 24px 0 24px !important;
	}

	body.woocommerce-order-received .rg-success-title {
		display: block !important;
		font-size: 24px !important;
		font-weight: 700 !important;
		letter-spacing: 0.08em !important;
		color: #7aa780 !important;
		line-height: 1.15 !important;
		margin: 0 0 10px 0 !important;
		text-transform: uppercase !important;
	}

	body.woocommerce-order-received .rg-success-msg {
		display: block !important;
		font-size: 18px !important;
		font-weight: 500 !important;
		color: rgba(230, 225, 195, 0.95) !important;
		line-height: 1.4 !important;
		margin: 0 0 8px 0 !important;
	}

	body.woocommerce-order-received .rg-success-next {
		display: block !important;
		font-size: 14px !important;
		color: rgba(204, 197, 147, 0.85) !important;
		font-style: italic !important;
		line-height: 1.5 !important;
		margin: 0 !important;
	}

	/* ==================================================================
	 * 1b. TIGHTEN GAP between order-overview strip and the details/billing
	 *     cards below it. Default WC + Colibri spacing creates a ~80-100px
	 *     dead zone around the Amelia QR-code paragraph. Keep breathing
	 *     room but halve the wasted space.
	 * ================================================================== */
	body.woocommerce-order-received .woocommerce-order-overview,
	body.woocommerce-order-received ul.woocommerce-order-overview.woocommerce-thankyou-order-details {
		margin: 16px 0 20px 0 !important;
	}
	body.woocommerce-order-received .woocommerce-order-details,
	body.woocommerce-order-received section.woocommerce-order-details,
	body.woocommerce-order-received .woocommerce-customer-details,
	body.woocommerce-order-received section.woocommerce-customer-details {
		margin-top: 24px !important;
	}
	/* Amelia's "Thank you for your order! Your QR code..." paragraph */
	body.woocommerce-order-received .woocommerce > p,
	body.woocommerce-order-received .entry-content > p,
	body.woocommerce-order-received .page-content > p {
		margin: 12px 0 !important;
		line-height: 1.5 !important;
	}

	/* ==================================================================
	 * 1c. BILLING ADDRESS — dark luxury. The sealed
	 *     rg-order-received-billing-fix.php catches some cases but misses
	 *     the outer white card and the inner gray address box seen on
	 *     order #74131. Force dark on all billing containers + address
	 *     block, champagne text, champagne hairline.
	 * ================================================================== */
	body.woocommerce-order-received .woocommerce-customer-details,
	body.woocommerce-order-received section.woocommerce-customer-details,
	body.woocommerce-order-received .woocommerce-column,
	body.woocommerce-order-received .woocommerce-column--billing-address,
	body.woocommerce-order-received .woocommerce-column--shipping-address {
		background: transparent !important;
		background-color: transparent !important;
		box-shadow: none !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details address,
	body.woocommerce-order-received .woocommerce-column address {
		background: rgba(20, 16, 10, 0.4) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		color: rgba(230, 225, 195, 0.95) !important;
		padding: 20px 22px !important;
		border-radius: 4px !important;
		font-style: normal !important;
		line-height: 1.6 !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details address p,
	body.woocommerce-order-received .woocommerce-column address p {
		color: rgba(230, 225, 195, 0.95) !important;
		margin: 0 0 4px 0 !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details address a,
	body.woocommerce-order-received .woocommerce-column address a {
		color: rgba(230, 225, 195, 0.95) !important;
		text-decoration: none !important;
		background: transparent !important;
	}
	body.woocommerce-order-received .woocommerce-customer-details h2,
	body.woocommerce-order-received .woocommerce-column h2 {
		color: rgba(204, 197, 147, 0.85) !important;
		background: transparent !important;
		font-size: 13px !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.12em !important;
		margin: 0 0 14px 0 !important;
		padding: 0 !important;
	}
	/* Icons inside the address block (phone/email icons) — champagne tint */
	body.woocommerce-order-received .woocommerce-customer-details address svg,
	body.woocommerce-order-received .woocommerce-column address svg,
	body.woocommerce-order-received .woocommerce-customer-details address i,
	body.woocommerce-order-received .woocommerce-column address i {
		color: rgba(204, 197, 147, 0.70) !important;
		fill: rgba(204, 197, 147, 0.70) !important;
	}

	/* ==================================================================
	 * 2. ORDER DETAILS TABLE — column sizing
	 *    Widen name column, narrow totals column so "1:00 am" doesn't wrap,
	 *    top-align totals column so price sits next to product row.
	 * ================================================================== */
	body.woocommerce-order-received table.shop_table.order_details th.product-name,
	body.woocommerce-order-received table.shop_table.order_details td.product-name {
		width: auto !important;
	}
	body.woocommerce-order-received table.shop_table.order_details th.product-total,
	body.woocommerce-order-received table.shop_table.order_details td.product-total {
		width: 140px !important;
		min-width: 140px !important;
		white-space: nowrap !important;
		text-align: right !important;
		vertical-align: top !important;
		padding-top: 18px !important;
	}
	/* tfoot rows (Subtotal/Tax/Total/Payment method) — allow wrap when
	   needed (e.g. "Credit / Debit Card" longer than a price) */
	body.woocommerce-order-received table.shop_table.order_details tfoot td {
		white-space: normal !important;
	}

	/* ==================================================================
	 * 3. Order-received meta structure — DIFFERENT from cart.
	 *    Amelia renders order-received product-name meta as raw text nodes
	 *    + <br> tags + <hr>, NOT as <dl class="variation"> used on cart.
	 *    5 consecutive <br>s after the "My Space" section create a ~120px
	 *    empty gap above "Appointment Info". Collapse those runs here.
	 *
	 *    br + br { display:none } keeps ONE line break between adjacent
	 *    items but hides runs of 2+ consecutive BRs that create empty
	 *    vertical space. Single BRs (between field rows) survive.
	 * ================================================================== */
	body.woocommerce-order-received table.shop_table td.product-name br + br {
		display: none !important;
	}

	/* ==================================================================
	 * 4. Section separator <hr> — tighten margins, champagne hairline
	 * ================================================================== */
	body.woocommerce-order-received table.shop_table td.product-name hr {
		margin: 10px 0 !important;
		border: 0 !important;
		border-top: 1px solid rgba(204, 197, 147, 0.20) !important;
		height: 0 !important;
	}

	/* ==================================================================
	 * 5. Inline <strong>/<b> field labels — "Local Time:", "Client Time:",
	 *    "service:", "VIP Driver:", etc. Amelia renders these at body size
	 *    (~16-20px). Normalize to 11px uppercase champagne to match cart.
	 * ================================================================== */
	body.woocommerce-order-received table.shop_table td.product-name strong,
	body.woocommerce-order-received table.shop_table td.product-name b {
		display: inline !important;
		font-size: 11px !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.08em !important;
		color: rgba(204, 197, 147, 0.85) !important;
		margin-right: 6px !important;
		line-height: 1.4 !important;
	}
	/* Product quantity "× 1" stays at normal body size, not mini-label */
	body.woocommerce-order-received table.shop_table td.product-name strong.product-quantity {
		font-size: 14px !important;
		font-weight: 400 !important;
		text-transform: none !important;
		letter-spacing: 0 !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* ==================================================================
	 * 6. wc-item-meta list (My Space) — tighter spacing, champagne label
	 * ================================================================== */
	body.woocommerce-order-received table.shop_table td.product-name ul.wc-item-meta {
		margin: 8px 0 !important;
		padding: 0 !important;
		list-style: none !important;
	}
	body.woocommerce-order-received table.shop_table td.product-name ul.wc-item-meta li {
		margin: 0 0 4px 0 !important;
	}
	body.woocommerce-order-received table.shop_table td.product-name ul.wc-item-meta strong.wc-item-meta-label {
		font-size: 11px !important;
		font-weight: 600 !important;
		text-transform: uppercase !important;
		letter-spacing: 0.08em !important;
		color: rgba(204, 197, 147, 0.85) !important;
	}

	</style>
	<?php
}, 100011 );
