<?php
/**
 * Plugin Name: Rive Gosh — Booking VIP Guest Redirect
 * Description: Intercepts logged-out users who land on /booking-vip/ (the
 *              Amelia Customer Panel page) BEFORE Amelia fires its own redirect.
 *              Amelia falls back to wp_login_url() which WooCommerce overrides
 *              to /my-orders/ — wrong destination. This guard sends guests to
 *              /login-2/ (UM login page) with redirect_to=/booking-vip/ so they
 *              land on their reservations dashboard after logging in.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-18
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. Verified visually 2026-04-18 —        ║
 * ║  clicking VIP Client header link while logged out now goes to    ║
 * ║  /login-2/ instead of /my-orders/.                               ║
 * ║                                                                   ║
 * ║  If VIP Client → /my-orders/ regression returns, FIX THE CAUSE   ║
 * ║  (Amelia update changing its login redirect, WC overriding        ║
 * ║  wp_login_url, or this file removed) — do NOT delete this file.  ║
 * ║  Ship additive overrides in a NEW mu-plugin if needed.           ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: Amelia Customer Panel on page 54773        ║
 * ║  (/booking-vip/) detects logged-out users and redirects via      ║
 * ║  wp_login_url(). WooCommerce overrides wp_login_url() to return  ║
 * ║  /my-orders/ (its My Account page, ID 16). Daniel reported this  ║
 * ║  as a bug: "clicking VIP Client takes me to /my-orders/".        ║
 * ║  This file fires at template_redirect priority 1 — before Amelia ║
 * ║  — and sends guests to /login-2/ with ?redirect_to=/booking-vip/ ║
 * ║  so UM returns them to reservations after login.                 ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#79                          ║
 * ║  Commit of record: c00c21d                                       ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'template_redirect', 'rg_booking_vip_guest_redirect', 1 );
function rg_booking_vip_guest_redirect() {
	if ( is_user_logged_in() ) {
		return;
	}
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	// Match /booking-vip/ by page ID (54773) — stable across slug changes.
	// Also match by path as belt+suspenders (Amelia can obscure the query var).
	$is_booking_vip = is_page( 54773 );
	if ( ! $is_booking_vip ) {
		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
		if ( $path && trim( $path, '/' ) === 'booking-vip' ) {
			$is_booking_vip = true;
		}
	}

	if ( ! $is_booking_vip ) {
		return;
	}

	$login_url = home_url( '/login-2/' );
	$redirect  = add_query_arg( 'redirect_to', rawurlencode( home_url( '/booking-vip/' ) ), $login_url );
	wp_safe_redirect( $redirect, 302 );
	exit;
}
