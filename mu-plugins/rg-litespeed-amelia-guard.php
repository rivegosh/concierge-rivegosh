<?php
/**
 * Plugin Name: Rive Gosh — LiteSpeed × Amelia Guard
 * Description: Locks LiteSpeed JS minify/defer OFF so Amelia's webpack dynamic
 *              imports (customer-panel chunks) keep resolving. Prevents the
 *              /booking-pro-panel/ blank-page regression from returning if
 *              someone flips the toggle in LiteSpeed admin.
 * Author: RG
 * Version: 1.0.2
 * Created: 2026-04-17
 * Updated: 2026-04-20 (v1.0.2 — skip on Amelia admin pages per #75 / Daniel Customizer block)
 * Review-by: 2026-10-17
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. Verified visually via Chrome MCP     ║
 * ║  screenshot on 2026-04-17 and signed off by Daniel.             ║
 * ║                                                                  ║
 * ║  If /booking-pro-panel/ or the Amelia booking wizard renders    ║
 * ║  blank later, FIX THE CAUSE (another mu-plugin, plugin update, ║
 * ║  LiteSpeed admin toggle) — do NOT gut or rewrite this file.    ║
 * ║  Ship additive overrides in a NEW mu-plugin if adjustment is    ║
 * ║  genuinely needed.                                              ║
 * ║                                                                  ║
 * ║  WHY THIS FILE EXISTS: LiteSpeed's JS minify+combine bundles    ║
 * ║  Amelia's webpack dynamic-import chunks into a single file      ║
 * ║  whose chunk references 404 → ChunkLoadError → Vue mount        ║
 * ║  aborts → blank booking pages. This guard re-asserts            ║
 * ║  optm-js_min=0 + optm-js_defer=0 on admin_init (priority 1)    ║
 * ║  so an admin Save in LiteSpeed → Page Optimization → JS         ║
 * ║  cannot silently reintroduce the regression.                    ║
 * ║                                                                  ║
 * ║  GitHub: rivegosh/concierge-rivegosh#75                         ║
 * ║  Commit of record: 43dcc68                                      ║
 * ╚══════════════════════════════════════════════════════════════════╝
 *
 * WHY: DEFCON 1 incident 2026-04-17 — /booking-pro-panel/ rendered empty
 * because LiteSpeed bundled Amelia's webpack chunks into one minified file
 * (c85d2f56…js). That file referenced chunk 193 via dynamic import() but
 * chunk 193 was no longer emitted as a standalone file → 404 →
 * ChunkLoadError → Vue panel mount aborted → blank page. Disabling
 * optm-js_min + optm-js_defer at the option layer fixed it, but any admin
 * save in LiteSpeed → Page Optimization → JS can silently flip it back.
 *
 * This guard re-asserts the safe values on every admin_init. It also
 * prevents bulk option imports from reintroducing the regression.
 *
 * HOW TO UNLOCK (if Amelia or LiteSpeed ship a compat fix):
 * 1. Test on staging with optm-js_min=1. Verify /booking-pro-panel/
 *    loads a login card (height > 500px, 2 inputs, 1 button).
 * 2. Verify network: no 404 on /wp-content/litespeed/js/*.js.
 * 3. Remove or rename this file. Delete /wp-content/litespeed/js.
 * 4. wp litespeed-purge all.
 * 5. Re-test /booking-pro-panel/ AND the booking wizard (Persons +
 *    Extras steps), which also use dynamic imports.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'admin_init', 'rivegosh_litespeed_amelia_guard', 1 );
function rivegosh_litespeed_amelia_guard() {
	// v1.0.2: Skip on Amelia's own admin screens so option writes + error_log
	// can't interfere with the Customizer / Settings AJAX save lifecycle.
	// The guard still fires on every OTHER admin page load, so LS toggles
	// are re-asserted within one click of any non-Amelia admin nav.
	if ( isset( $_GET['page'] ) && is_string( $_GET['page'] ) && strpos( $_GET['page'], 'wpamelia-' ) === 0 ) {
		return;
	}
	if ( wp_doing_ajax() ) {
		$action = isset( $_REQUEST['action'] ) ? (string) $_REQUEST['action'] : '';
		if ( $action && strpos( $action, 'wpamelia' ) !== false ) {
			return;
		}
	}

	// Only act if LiteSpeed Cache is active.
	if ( ! function_exists( 'run_litespeed_cache' ) && ! class_exists( 'LiteSpeed\Core' ) ) {
		return;
	}

	$locked = array(
		'optm-js_min'   => 0,
		'optm-js_defer' => 0,
	);

	foreach ( $locked as $key => $want ) {
		$opt_name = 'litespeed.conf.' . $key;
		$current  = get_option( $opt_name, null );
		if ( $current === null ) {
			continue; // LS not initialized yet — don't create rogue rows.
		}
		if ( (int) $current !== $want ) {
			update_option( $opt_name, $want );
			error_log( sprintf(
				'[rg-litespeed-amelia-guard] reset %s from %s to %s',
				$opt_name,
				var_export( $current, true ),
				var_export( $want, true )
			) );
		}
	}
}

// Defensive: if someone toggles via the LS admin UI and it writes through
// the plugin's own update path, we re-assert on shutdown of that admin
// request too. LiteSpeed saves into the same option rows, so the admin_init
// hook on the NEXT request will correct it — this is belt + suspenders.
add_action( 'litespeed_settings_save', 'rivegosh_litespeed_amelia_guard_post_save', 99 );
function rivegosh_litespeed_amelia_guard_post_save() {
	rivegosh_litespeed_amelia_guard();
}
