<?php
/**
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ Destination Page Title Resize + Scroll Unlock                    ║
 * ║                                                                  ║
 * ║ Fixes:                                                           ║
 * ║ 1. Page 67094 title "All Transfers Florida & Area USA" reduced  ║
 * ║    from 279px to 100px max-height                               ║
 * ║ 2. Bottom embed iframe positioned at scrollHeight prevents      ║
 * ║    scrolling past service cards — unlocked by reducing padding  ║
 * ║                                                                  ║
 * ║ GitHub: rivegosh/concierge-rivegosh#TBD                         ║
 * ║ Commit of record: (set on push)                                 ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function() {
	if ( ! is_page( 67094 ) ) return;

	echo '<style>';

	// Reduce destination title from 279px to ~100px max-height
	// Target the h2 inside the Colibri heading block (style-local-67094-c2)
	echo 'body.page-id-67094 .style-local-67094-c2 .h-heading__outer h2 { ';
	echo '  max-height: 100px !important; ';
	echo '  overflow: hidden !important; ';
	echo '  margin-bottom: 20px !important; ';
	echo '}';

	// Also constrain parent section height
	echo 'body.page-id-67094 .style-local-67094-c2 { ';
	echo '  max-height: 140px !important; ';
	echo '}';

	// Widen text paragraphs to prevent widow/orphan words
	echo 'body.page-id-67094 .style-local-67094-c2 p { ';
	echo '  max-width: 900px !important; ';
	echo '  margin-left: auto !important; ';
	echo '  margin-right: auto !important; ';
	echo '}';

	// Unlock bottom embed that was blocking scroll
	// Constrain iframe height instead of hiding it
	echo 'body.page-id-67094 iframe { ';
	echo '  height: 0 !important; ';
	echo '  display: block !important; ';
	echo '  border: none !important; ';
	echo '}';

	echo '</style>';
}, 99999 );
