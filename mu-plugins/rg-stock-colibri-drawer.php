<?php
/**
 * Plugin Name: RG Stock Colibri Drawer
 * Description: Removes functions.php's rivegosh_custom_drawer_v43 so Colibri's
 *              native offcanvas drawer is used as-is (stock behavior).
 *              This replaces the disabled rg-drawer-override.php. That plugin
 *              USED to suppress the functions.php drawer AND inject its own
 *              (which itself had hardcoded menu fallbacks blocking Daniel).
 *              Now we suppress only — Colibri native takes over.
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * Reversal: delete this file AND re-enable rg-drawer-override.php.disabled-2026-04-23.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	remove_action( 'wp_footer', 'rivegosh_custom_drawer_v43', 99998 );
}, 20 );
