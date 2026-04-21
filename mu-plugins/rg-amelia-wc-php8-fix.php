<?php
/**
 * Plugin Name: RG Amelia WC PHP8 Fix
 * Description: Fixes "There was an error processing your order" caused by
 *              Amelia WooCommerceService.php:3199 TypeError in PHP 8.
 *              array_key_exists('booked', $data) crashes when $data is ""
 *              (empty string from wc_get_order_item_meta on non-Amelia items).
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root cause (2026-04-21 — WC log fatal-errors):                   ║
 * ║  PHP 8 changed array_key_exists() to throw TypeError when arg #2 ║
 * ║  is not an array (was silently false in PHP 7).                   ║
 * ║  Amelia's WooCommerceService::orderCreated() hooks into           ║
 * ║  woocommerce_checkout_order_created (priority 10) and calls      ║
 * ║  array_key_exists('booked', $data) BEFORE !empty($data) check.  ║
 * ║  For order items with no 'ameliabooking' meta, $data = "" →      ║
 * ║  TypeError → WooCommerce shows generic "error processing" msg.   ║
 * ║                                                                   ║
 * ║ Fix strategy:                                                     ║
 * ║  Hook into woocommerce_checkout_order_created at priority 1      ║
 * ║  (fires before Amelia's priority 10). For each order item that   ║
 * ║  lacks a proper array in its 'ameliabooking' meta, write an      ║
 * ║  empty array []. Amelia then sees [] (falsy empty array) and     ║
 * ║  skips the item via !empty($data) — no crash, no side-effects.  ║
 * ║                                                                   ║
 * ║ This is safe: items WITH Amelia booking data (arrays) are        ║
 * ║  untouched (is_array check). Items WITHOUT are set to [], which  ║
 * ║  Amelia correctly identifies as non-bookings and ignores.        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'woocommerce_checkout_order_created', function ( $order ) {
	foreach ( $order->get_items() as $item_id => $item ) {
		$meta = $item->get_meta( 'ameliabooking' );
		if ( ! is_array( $meta ) ) {
			// Write an empty array so Amelia's array_key_exists calls
			// don't crash (PHP 8 TypeError) on empty-string meta values.
			wc_update_order_item_meta( $item_id, 'ameliabooking', [] );
		}
	}
}, 1 ); // Priority 1 — runs before Amelia's priority 10
