<?php
/**
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ Colibri Google Fonts Trim — Performance                          ║
 * ║                                                                  ║
 * ║ Problem: Colibri-Page-Builder-Pro enqueues a giant fonts.googleapis.com
 * ║ URL loading ~30 font families (Muli, Open Sans, Playfair, Inter,
 * ║ Cormorant Garamond, Lato, El Messiri, Limelight, Megrim, Montaga,
 * ║ Monoton, Rozha One, Tenor Sans, Unica One, Antic, Antic Didone,
 * ║ Arya, Federo, Josefin Slab, Kumar One Outline, Mirza, Forum,
 * ║ Vidaloka, Oranienbaum, Suranna, Cormorant, Khand, Philosopher,
 * ║ Poiret One, Trirong, Rajdhani, Junge, Alfa Slab One, Ovo).
 * ║                                                                  ║
 * ║ Runtime audit (2026-04-20): only 5 families rendered on the
 * ║ homepage — Inter(1302), Ovo(187), Cormorant Garamond(57),
 * ║ Playfair Display(14), Muli(5). The other ~25 families are
 * ║ loaded but render nowhere.                                       ║
 * ║                                                                  ║
 * ║ Fix: filter style_loader_src to rewrite any fonts.googleapis.com
 * ║ URL so only the 5 used families remain. Colibri's PHP/CSS stays
 * ║ unchanged — we only mutate the outbound request URL.             ║
 * ║                                                                  ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'rg_colibri_fonts_trim_filter' ) ) {
	function rg_colibri_fonts_trim_filter( $src, $handle = '' ) {
		if ( ! is_string( $src ) || strpos( $src, 'fonts.googleapis.com' ) === false ) {
			return $src;
		}

		$whitelist = [
			'Inter',
			'Ovo',
			'Cormorant Garamond',
			'Playfair Display',
			'Muli',
		];

		$parsed = wp_parse_url( $src );
		if ( empty( $parsed['query'] ) ) return $src;

		parse_str( html_entity_decode( $parsed['query'] ), $params );
		if ( empty( $params['family'] ) ) return $src;

		$families_raw = explode( '|', $params['family'] );
		$kept         = [];

		foreach ( $families_raw as $family_spec ) {
			$name_only = explode( ':', $family_spec )[0];
			$name_clean = str_replace( '+', ' ', $name_only );
			if ( in_array( $name_clean, $whitelist, true ) ) {
				$kept[] = $family_spec;
			}
		}

		if ( empty( $kept ) ) return $src;

		$params['family'] = implode( '|', $kept );

		$new_query = http_build_query( $params );
		$new_url   = ( $parsed['scheme'] ?? 'https' ) . '://' . $parsed['host'] . ( $parsed['path'] ?? '' ) . '?' . $new_query;

		return $new_url;
	}
}

add_filter( 'style_loader_src', 'rg_colibri_fonts_trim_filter', 20, 2 );
