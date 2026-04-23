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
 *              ajaxComplete whose payload contains "wcfm-memberships-registration",
 *              parses the response, and if status=true + redirect URL present, forces
 *              window.location after a 1200ms delay (to let the legitimate slideDown
 *              callback run first if it works).
 * Version: 1.3.0
 * Revision: 1.0.0 was broken — searched for "wcfmvm-memberships-registration" but
 *           actual controller value is "wcfm-memberships-registration" (no vm).
 *           Also settings.data is FormData object not string. v1.1.0 uses
 *           FormData.get('controller') + correct name.
 *           v1.2.0 fixes LiteSpeed delay-JS race — inline script was rewritten to
 *           type="litespeed/javascript" and deferred until user interaction. Race
 *           condition: submit XHR could complete before the handler registered.
 *           Fix: data-no-optimize="1" + output BEFORE wp_footer via wp_print_scripts
 *           priority, plus boot/per-ajax diagnostic logs so we can observe in console.
 * Created: 2026-04-23
 *
 * Rollback: delete this file. Form reverts to WCFM default behavior (frozen UI).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Output as early as possible in <head> via wp_head (priority 1) so jQuery
// ajaxComplete handler is bound before ANY XHR fires on the page.
// data-no-optimize="1" + data-cfasync="false" tell LiteSpeed + Cloudflare
// to skip delay/defer processing. Script id kept for revert-grep.
add_action( 'wp_head', function () {
	if ( ! is_page( 3918 ) ) return;
	?>
	<script id="rg-wcfmvm-register-redirect-guard" data-no-optimize="1" data-cfasync="false">
	(function(){
		function arm() {
			if ( typeof window.jQuery === "undefined" ) { setTimeout(arm, 50); return; }
			var $ = window.jQuery;
			console.log("[RG-Guard v1.2.0] armed on /vendor-membership/");
			$(document).ajaxComplete(function(event, xhr, settings) {
				try {
					var ctrl = "";
					if ( settings && settings.data ) {
						if ( typeof settings.data === "string" ) {
							var m = settings.data.match(/controller=([^&]+)/);
							if ( m ) ctrl = decodeURIComponent(m[1]);
						} else if ( settings.data instanceof FormData ) {
							ctrl = settings.data.get("controller") || "";
						}
					}
					console.log("[RG-Guard] ajaxComplete — controller:", ctrl, "status:", xhr.status);
					if ( ctrl !== "wcfm-memberships-registration" ) return;
					var r = JSON.parse(xhr.responseText);
					console.log("[RG-Guard] WCFM register response:", r);
					if ( r && (r.status === true || r.status === "true") && r.redirect ) {
						console.log("[RG-Guard] force-redirect NOW to:", r.redirect);
						// v1.3.0: was 1200ms — reduced to 150ms after DEFCON0 report that
						// the "white screen" was actually the transition delay. Now near-instant.
						setTimeout(function() {
							if ( window.location.href !== r.redirect ) {
								console.log("[RG-Guard] forcing navigation");
								window.location.assign(r.redirect);
							}
						}, 150);
					} else {
						console.log("[RG-Guard] no redirect action — status/redirect missing");
					}
				} catch(e) {
					console.log("[RG-Guard] handler error:", e, "responseText first 200:", (xhr && xhr.responseText) ? xhr.responseText.substring(0,200) : "(none)");
				}
			});
		}
		arm();
	})();
	</script>
	<?php
}, 1 );
