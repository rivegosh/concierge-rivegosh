<?php
/**
 * Plugin Name: Rive Gosh — Account Page Layout
 * Description: Spreads the UM Account page (page-id-73404) across the middle column.
 *   Root cause: UM's .um-form has margin-left: 632px / margin-right: 40px that
 *   bunches everything into the right third of the content area. We zero those
 *   out and set explicit widths for .um-account-side (aux nav) + .um-account-main
 *   (form). #post-73404 in the selector adds ID specificity so we beat UM's rules.
 * Version: 1.1.0 (2026-04-17)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 73404 ) ) return;
	?>
	<style id="rg-account-layout-css">
	/* Desktop (>= 992px): three-column spread */
	@media (min-width: 992px) {
		body.page-id-73404 #post-73404 .um-form {
			margin-left: 28px !important;
			margin-right: 0 !important;
			width: auto !important;
			max-width: none !important;
		}
		body.page-id-73404 #post-73404 .um-account-side {
			width: 280px !important;
			max-width: 280px !important;
		}
		body.page-id-73404 #post-73404 .um-account-main {
			width: 540px !important;
			max-width: 540px !important;
			margin-left: 80px !important;
		}
		body.page-id-73404 #post-73404 .um-account-main input[type="text"],
		body.page-id-73404 #post-73404 .um-account-main input[type="email"],
		body.page-id-73404 #post-73404 .um-account-main input[type="password"],
		body.page-id-73404 #post-73404 .um-account-main input[type="tel"] {
			width: 100% !important;
			max-width: 100% !important;
		}
	}

	/* Mobile (< 992px): equalize left/right padding around the form.
	   UM defaults: .um-account has 7px left padding, .um-form has 40px right margin
	   → content hugs the left edge with big right gap. Override to balanced ~22px. */
	@media (max-width: 991px) {
		body.page-id-73404 #post-73404 .um-form {
			margin-left: 22px !important;
			margin-right: 22px !important;
			width: auto !important;
			max-width: none !important;
		}
	}
	</style>
	<?php
}, 99999 );
