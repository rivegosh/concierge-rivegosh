<?php
/**
 * Plugin Name: RG Amelia Copy Fix
 * Description: Rewrites awkward English strings in the Amelia booking wizard.
 *              Uses the `gettext_wpamelia` filter so we intercept the exact source
 *              string AFTER gettext lookup — works across all locales including
 *              en_US where the string is its own msgid.
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * Growable: add more entries to $rg_amelia_copy_map[] as Daniel surfaces more.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'gettext_wpamelia', 'rg_amelia_copy_fix', 20, 3 );

function rg_amelia_copy_fix( $translation, $text, $domain ) {
	static $map = null;
	if ( $map === null ) {
		$map = array(
			'You can find below the appointments you selected for booking. If you want to book more, click on the button below.'
				=> 'Here are your selected services. To add another, choose one below.',
		);
	}

	// Check both the incoming $text (source) AND $translation (already-translated)
	// so this works in en_US (where text == translation) AND localized sites.
	if ( isset( $map[ $text ] ) ) {
		return $map[ $text ];
	}
	if ( isset( $map[ $translation ] ) ) {
		return $map[ $translation ];
	}

	return $translation;
}
