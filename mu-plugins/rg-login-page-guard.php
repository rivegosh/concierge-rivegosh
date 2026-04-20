<?php
/**
 * Plugin Name: Rive Gosh — Login Page Guard
 * Description: Logged-in users who land on /login-2/ (UM login page) get sent
 *              straight to /booking-vip/ instead of seeing UM's profile stub.
 * Author: Rive Gosh / Chi (PAI)
 * Version: 1.0.0
 * Created: 2026-04-17
 *
 * WHY: /login-2/ is the UM login form page — needed so guests can log in.
 * When an ALREADY-LOGGED-IN user hits it (e.g. clicking "Login to our site"
 * in the welcome email), UM renders a small "your account / logout" profile
 * stub which Daniel (product owner) called out as ugly. We short-circuit
 * that by sending logged-in users straight to their reservations dashboard.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'template_redirect', 'rivegosh_login_page_guard', 1 );
function rivegosh_login_page_guard() {
	if ( ! is_user_logged_in() ) {
		return;
	}
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	// Match the UM login page by post ID (73396) OR by request path, since
	// the theme sometimes proxies /login-2/ through different queries.
	$is_login_page = false;
	if ( is_page( 73396 ) ) {
		$is_login_page = true;
	} else {
		$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
		if ( $path && trim( $path, '/' ) === 'login-2' ) {
			$is_login_page = true;
		}
	}
	if ( ! $is_login_page ) {
		return;
	}
	wp_safe_redirect( home_url( '/booking-vip/' ), 302 );
	exit;
}
