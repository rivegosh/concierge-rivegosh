<?php
/**
 * Plugin Name: Rive Gosh — Email As Username
 * Description: Auto-generates user_login from the email prefix at UM registration
 *              so customers don't have to pick a username. UM's login form already
 *              accepts "Username or E-mail", so existing users are unaffected.
 * Author: Rive Gosh / Chi (PAI)
 * Version: 1.0.0
 * Created: 2026-04-17
 *
 * WHY: Daniel (product owner) tested registration as a customer and hit the
 * Username field as unnecessary friction. Removing the field from the form
 * alone breaks UM because it requires user_login at wp_insert_user(). This
 * filter fills it in programmatically from the email local-part, with
 * uniqueness guarded by username_exists().
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'um_submit_form_data', 'rivegosh_auto_username_from_email', 1, 2 );
function rivegosh_auto_username_from_email( $data, $mode ) {
	if ( $mode !== 'register' ) {
		return $data;
	}
	if ( ! empty( $data['user_login'] ) ) {
		return $data; // respect explicit value if another plugin set one
	}
	$email = isset( $data['user_email'] ) ? trim( $data['user_email'] ) : '';
	if ( ! $email || ! is_email( $email ) ) {
		return $data; // let UM surface the email validation error
	}
	$local = strtolower( strtok( $email, '@' ) );
	$base  = sanitize_user( $local, true );
	if ( ! $base ) {
		$base = 'user';
	}
	$base      = substr( $base, 0, 24 ); // UM field max_chars was 24
	$candidate = $base;
	$i         = 1;
	while ( username_exists( $candidate ) ) {
		$suffix    = (string) $i;
		$candidate = substr( $base, 0, 24 - strlen( $suffix ) ) . $suffix;
		$i++;
		if ( $i > 1000 ) {
			$candidate = substr( $base, 0, 17 ) . substr( md5( uniqid( '', true ) ), 0, 6 );
			break;
		}
	}
	$data['user_login'] = $candidate;
	return $data;
}

// Some UM code paths read $_POST directly before um_submit_form_data fires
// (e.g., early validation hooks). Mirror the generation there too, guarded
// so it only runs on actual UM register POSTs.
add_action( 'um_pre_args_setup', 'rivegosh_auto_username_prefill_post', 1, 1 );
function rivegosh_auto_username_prefill_post( $post_form ) {
	if ( empty( $post_form['mode'] ) || $post_form['mode'] !== 'register' ) {
		return;
	}
	if ( ! empty( $_POST['user_login'] ) ) {
		return;
	}
	$email = isset( $_POST['user_email'] ) ? trim( wp_unslash( $_POST['user_email'] ) ) : '';
	if ( ! $email || ! is_email( $email ) ) {
		return;
	}
	$local = strtolower( strtok( $email, '@' ) );
	$base  = sanitize_user( $local, true );
	if ( ! $base ) {
		$base = 'user';
	}
	$base      = substr( $base, 0, 24 );
	$candidate = $base;
	$i         = 1;
	while ( username_exists( $candidate ) ) {
		$suffix    = (string) $i;
		$candidate = substr( $base, 0, 24 - strlen( $suffix ) ) . $suffix;
		$i++;
		if ( $i > 1000 ) {
			$candidate = substr( $base, 0, 17 ) . substr( md5( uniqid( '', true ) ), 0, 6 );
			break;
		}
	}
	$_POST['user_login'] = $candidate;
}
