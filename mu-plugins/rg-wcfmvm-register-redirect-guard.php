<?php
/**
 * Plugin Name: RG WCFM Vendor Membership Register Redirect Guard
 * Description: WCFM's register JS at line 477-480 of
 *              wcfmvm-script-membership-registration.js traps window.location redirect
 *              INSIDE a slideDown() callback on a specific .wcfm-message selector. If
 *              that selector returns an empty jQuery set (element missing, wrong class
 *              chain, display:none !important, or DOM edge), slideDown() runs on nothing
 *              and the callback NEVER fires — user account is created but UI freezes and
 *              redirect never happens. This plugin adds a safety net: listens for ANY
 *              ajaxComplete whose payload contains "wcfmvm-memberships-registration",
 *              parses the response, and if status=true + redirect URL present, forces
 *              window.location after a 1500ms delay (to let the legitimate slideDown
 *              callback run first if it works).
 * Version: 1.1.0
 * Revision: 1.0.0 was broken — searched for "wcfmvm-memberships-registration" but
 *           actual controller value is "wcfm-memberships-registration" (no vm).
 *           Also settings.data is FormData object not string. v1.1.0 uses
 *           FormData.get('controller') + correct name.
 * Created: 2026-04-23
 *
 * Rollback: delete this file. Form reverts to WCFM default behavior (frozen UI).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	if ( ! is_page( 3918 ) ) return;
	?>
	<script id="rg-wcfmvm-register-redirect-guard">
	(function($){
		$(document).ajaxComplete(function(event, xhr, settings) {
			if ( ! settings || ! settings.data ) return;
			// WCFM submits with FormData — read controller field directly
			var isRegistration = false;
			try {
				if ( typeof settings.data === "string" ) {
					isRegistration = settings.data.indexOf("wcfm-memberships-registration") !== -1;
				} else if ( settings.data instanceof FormData ) {
					isRegistration = ( settings.data.get("controller") === "wcfm-memberships-registration" );
				}
			} catch(e) {}
			if ( ! isRegistration ) return;
			try {
				var r = JSON.parse(xhr.responseText);
				if ( r && (r.status === true || r.status === "true") && r.redirect ) {
					// Wait 1.5s — lets legitimate slideDown callback redirect first if it works.
					// If still on same page after that, force the redirect.
					setTimeout(function() {
						if ( window.location.href.indexOf(r.redirect) === -1 ) {
							console.log("[RG-Guard] WCFM register redirect trap detected — forcing navigation to:", r.redirect);
							window.location = r.redirect;
						}
					}, 1500);
				}
			} catch(e) {
				console.log("[RG-Guard] WCFM register response parse error:", e);
			}
		});
	})(jQuery);
	</script>
	<?php
}, 100000 );
