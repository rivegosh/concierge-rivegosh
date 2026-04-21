<?php
/**
 * Plugin Name: RG Mail Reply-To Guard
 * Description: Strips ANY Reply-To header on outgoing mail when the address
 *              does not belong to rivegosh-concierge.com or rivegosh.com.
 *              Hostinger's inbound filter on daniel@rivegosh-concierge.com
 *              soft-bounces every email whose Reply-To points to an external
 *              domain (Grace's gmail, customer gmails, yahoo, etc.), causing
 *              silent vendor-notification deliverability loss on real orders.
 * Version: 1.1.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: wp_mail filter (priority 9999).                           ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ EVIDENCE (Brevo events API, 2026-04-20):                         ║
 * ║  TEST 2 Reply-To=grace@gmail.com       → softBounces (bad)       ║
 * ║  TEST 3 no Reply-To                    → delivered  (good)       ║
 * ║  TEST 4 Reply-To=daniel@rivegosh.com   → delivered  (good)       ║
 * ║  TEST 6 Reply-To=test@gmail.com        → softBounces (bad)       ║
 * ║  → Hostinger rejects ANY external Reply-To, not Grace-specific.  ║
 * ║                                                                   ║
 * ║ WHY THE MAIN ADMIN EMAIL STAYS AS gracevincentstripe@gmail.com:  ║
 * ║  user ID 1 is tied to Stripe ownership + vendor records (Daniel  ║
 * ║  confirmed 2026-04-20). We neutralize the outbound side-effect   ║
 * ║  only — no admin-account change.                                 ║
 * ║                                                                   ║
 * ║ BEHAVIOR:                                                         ║
 * ║  - Reply-To with @rivegosh-concierge.com or @rivegosh.com → KEEP ║
 * ║  - Reply-To with any other domain                        → STRIP ║
 * ║  - No Reply-To header                                    → leave ║
 * ║  - Fallback: mail clients use From: contact@rivegosh-            ║
 * ║    concierge.com (set by WP Mail SMTP).                          ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'wp_mail', function ( $atts ) {
	if ( empty( $atts['headers'] ) ) return $atts;

	// Domains we trust not to trigger Hostinger's inbound filter.
	$allowed_domains = array( 'rivegosh-concierge.com', 'rivegosh.com' );

	$is_array = is_array( $atts['headers'] );
	$headers = $is_array ? $atts['headers'] : preg_split( "/\r\n|\r|\n/", (string) $atts['headers'] );

	$kept = array();
	foreach ( $headers as $h ) {
		$line = trim( (string) $h );
		if ( $line === '' ) continue;

		// Only inspect Reply-To lines — everything else passes untouched.
		if ( stripos( $line, 'reply-to:' ) !== 0 ) {
			$kept[] = $h;
			continue;
		}

		// Is this Reply-To on a trusted domain? Keep it. Otherwise drop it.
		$keep = false;
		foreach ( $allowed_domains as $d ) {
			if ( stripos( $line, '@' . $d ) !== false ) {
				$keep = true;
				break;
			}
		}
		if ( $keep ) $kept[] = $h;
	}

	$atts['headers'] = $is_array ? $kept : implode( "\r\n", $kept );
	return $atts;
}, 9999 );
