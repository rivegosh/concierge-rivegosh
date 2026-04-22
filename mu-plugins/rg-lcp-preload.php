<?php
/**
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ LCP Preload + Resource Hints                                      ║
 * ║                                                                   ║
 * ║ Problem (2026-04-20 PSI mobile): Perf 62, LCP 6.8s, FCP 4.5s on   ║
 * ║ homepage. Hero is a 5-slide Colibri slideshow using CSS           ║
 * ║ background-image — invisible to the browser preloader. First      ║
 * ║ visible slide ("slideshow-image current", z-index 1001, opacity   ║
 * ║ 1) is vitesse-de-voiture...ai-generative.jpg. Paint waits on      ║
 * ║ CSS → JS → slideshow init → image fetch.                          ║
 * ║                                                                   ║
 * ║ Fix:                                                              ║
 * ║ 1) preconnect to fonts.gstatic.com, fonts.googleapis.com,         ║
 * ║    use.fontawesome.com, i0.wp.com (saves TLS handshake time)      ║
 * ║ 2) preload the first-rendered hero slide, homepage-only           ║
 * ║                                                                   ║
 * ║ Note (2026-04-22): imagesrcset was attempted and reverted —       ║
 * ║ Colibri slideshow uses CSS background-image (not <img>), which    ║
 * ║ does not consume imagesrcset. Adding srcset caused the browser    ║
 * ║ to fetch the srcset variant AND the CSS-referenced scaled.jpg     ║
 * ║ (double fetch, net +376 KB desktop). href must match the exact    ║
 * ║ URL referenced by CSS background-image to satisfy that request    ║
 * ║ from the preload cache.                                           ║
 * ║                                                                   ║
 * ║ Revert: delete this file.                                         ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function() {
	echo "\n<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
	echo "<link rel='preconnect' href='https://fonts.googleapis.com' crossorigin>\n";
	echo "<link rel='preconnect' href='https://use.fontawesome.com' crossorigin>\n";
	echo "<link rel='preconnect' href='https://i0.wp.com' crossorigin>\n";

	if ( is_front_page() ) {
		$hero = 'https://rivegosh-concierge.com/wp-content/uploads/2025/10/vitesse-de-voiture-de-luxe-par-un-batiment-moderne-au-crepuscule-ai-generative-scaled.jpg';
		echo "<link rel='preload' as='image' fetchpriority='high' href='" . esc_url( $hero ) . "'>\n";
	}
}, 1 );
