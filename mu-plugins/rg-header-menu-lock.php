<?php
/**
 * Plugin Name: Rive Gosh — Header Menu Lock (Affiliate Dashboard)
 * Description: Auto-restores the Affiliate Dashboard top-level menu item +
 *              its 2 children (Affiliate Registration, Multi Level Affiliate)
 *              in the header-menu (term_id 86) if any are missing. Guards
 *              against silent DB deletions by concurrent CC sessions or
 *              wp-admin nav-editor mistakes.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-17
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. Verified visually via live curl       ║
 * ║  (menu-item-74053 renders menu-item-has-children + <ul           ║
 * ║  class="sub-menu"> with 2 items) on 2026-04-17 and signed off    ║
 * ║  by Daniel.                                                       ║
 * ║                                                                   ║
 * ║  If the desktop header nav's 3rd dropdown (Affiliate Dashboard)  ║
 * ║  or its 2 children go missing later, FIX THE CAUSE (another      ║
 * ║  mu-plugin auto-restoring a 2-item menu, wp-admin nav editor,    ║
 * ║  plugin update) — do NOT gut or rewrite this file. Ship           ║
 * ║  additive overrides in a NEW mu-plugin if genuinely needed.      ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: Between 2026-04-15 and 2026-04-17, the    ║
 * ║  Affiliate Dashboard menu item (73499) + its 2 children were     ║
 * ║  HARD-deleted from wp_posts by an unknown process (concurrent    ║
 * ║  CC session? admin nav editor?). No commit records it. This      ║
 * ║  guard runs on admin_init and restores the 3 items if missing.   ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#78                          ║
 * ║  Commit of record: TBD (set after push)                          ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'admin_init', 'rg_header_menu_lock_affiliate', 5 );
function rg_header_menu_lock_affiliate() {
	$menu_term_id = 86;

	$parent_cfg = array(
		'title'     => 'Affiliate Dashboard',
		'object_id' => 73098,
	);

	$children_cfg = array(
		array( 'title' => 'Affiliate Registration', 'object_id' => 63619 ),
		array( 'title' => 'Multi Level Affiliate',  'object_id' => 71558 ),
	);

	$items = wp_get_nav_menu_items( $menu_term_id );
	if ( $items === false ) {
		return;
	}

	$parent_id = 0;
	foreach ( $items as $it ) {
		if ( (int) $it->object_id === $parent_cfg['object_id'] && (int) $it->menu_item_parent === 0 ) {
			$parent_id = (int) $it->ID;
			break;
		}
	}

	if ( ! $parent_id ) {
		$parent_id = wp_update_nav_menu_item( $menu_term_id, 0, array(
			'menu-item-title'     => $parent_cfg['title'],
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $parent_cfg['object_id'],
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => 0,
		) );
		if ( is_wp_error( $parent_id ) || ! $parent_id ) {
			error_log( '[rg-header-menu-lock] FAILED to restore parent Affiliate Dashboard: ' . ( is_wp_error( $parent_id ) ? $parent_id->get_error_message() : 'unknown' ) );
			return;
		}
		error_log( sprintf( '[rg-header-menu-lock] RESTORED parent Affiliate Dashboard as menu item %d → page %d', $parent_id, $parent_cfg['object_id'] ) );
		$items = wp_get_nav_menu_items( $menu_term_id );
	}

	foreach ( $children_cfg as $child ) {
		$found = false;
		foreach ( $items as $it ) {
			if ( (int) $it->object_id === $child['object_id'] && (int) $it->menu_item_parent === $parent_id ) {
				$found = true;
				break;
			}
		}
		if ( ! $found ) {
			$new_id = wp_update_nav_menu_item( $menu_term_id, 0, array(
				'menu-item-title'     => $child['title'],
				'menu-item-object'    => 'page',
				'menu-item-object-id' => $child['object_id'],
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent_id,
			) );
			if ( is_wp_error( $new_id ) || ! $new_id ) {
				error_log( sprintf( '[rg-header-menu-lock] FAILED to restore child %s: %s', $child['title'], is_wp_error( $new_id ) ? $new_id->get_error_message() : 'unknown' ) );
				continue;
			}
			error_log( sprintf( '[rg-header-menu-lock] RESTORED child %s (page %d) as menu item %d under parent %d', $child['title'], $child['object_id'], $new_id, $parent_id ) );
		}
	}
}
