<?php
/**
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ Destination Page Title Resize + Scroll Unlock                    ║
 * ║                                                                  ║
 * ║ Page 67094 ("All Transfers Airports & Area Florida USA")         ║
 * ║                                                                  ║
 * ║ Fixes:                                                           ║
 * ║ 1. Title h2 capped at 100px max-height (was 279px native)       ║
 * ║ 2. transition:none on the h2 kills the Colibri 0.5s max-height  ║
 * ║    animation that used to render as a "massive zoom" on load   ║
 * ║    (v1.1.0 2026-04-20 — Daniel feedback)                       ║
 * ║ 3. Bottom padding below the Amelia catalog widget so users can  ║
 * ║    scroll past the last service card row (full-width template   ║
 * ║    hides .page-footer, so without padding the embed hits the    ║
 * ║    viewport edge on shorter screens)                            ║
 * ║                                                                  ║
 * ║ v1.0.0 initial (title-only)                                     ║
 * ║ v1.1.0 2026-04-20 — kill zoom transition, add scroll padding   ║
 * ║        below the embed. Removed dead iframe rule (page uses     ║
 * ║        .amelia-v2-booking DIV, not an iframe).                 ║
 * ║                                                                  ║
 * ║ GitHub: rivegosh/concierge-rivegosh#TBD                         ║
 * ║ Commit of record: (set on push)                                 ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function() {
	if ( ! is_page( 67094 ) ) return;

	echo '<style id="rg-67094-fixes">';

	// Title: cap at 100px + disable max-height transition so the late-CSS
	// injection doesn't animate a shrink on first paint. The h2's inherited
	// transition covers max-height, transform and filter — overriding with
	// "none" stops ALL of them, which is what we want for a stable landing.
	echo 'body.page-id-67094 .style-local-67094-c2 .h-heading__outer h2 { ';
	echo '  max-height: 100px !important; ';
	echo '  overflow: hidden !important; ';
	echo '  margin-bottom: 20px !important; ';
	echo '  transition: none !important; ';
	echo '  -webkit-transition: none !important; ';
	echo '  animation: none !important; ';
	echo '}';

	// Constrain the parent section + kill its transitions too (Colibri
	// applies the same transition set on h-section wrappers).
	echo 'body.page-id-67094 .style-local-67094-c2 { ';
	echo '  max-height: 140px !important; ';
	echo '  transition: none !important; ';
	echo '  -webkit-transition: none !important; ';
	echo '}';

	// Center + narrow the intro paragraph to avoid widow lines.
	echo 'body.page-id-67094 .style-local-67094-c2 p { ';
	echo '  max-width: 900px !important; ';
	echo '  margin-left: auto !important; ';
	echo '  margin-right: auto !important; ';
	echo '}';

	// Scroll-past-embed: the page-footer is display:none on this template,
	// so add breathing room below the Amelia catalog widget + its section
	// so shorter viewports can scroll past the last card row.
	echo 'body.page-id-67094 .amelia-v2-booking { ';
	echo '  padding-bottom: 160px !important; ';
	echo '}';
	echo 'body.page-id-67094 #page-top .page-content { ';
	echo '  padding-bottom: 40px !important; ';
	echo '}';

	echo '</style>';
}, 99999 );
