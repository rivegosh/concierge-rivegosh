<?php
/**
 * Plugin Name: RG Stripe UPE Appearance
 * Description: WooCommerce Gateway Stripe 10.6+ UPE injection of Stripe
 *              Elements appearance. UPE has a cache-hit branch: if
 *              wc_stripe_upe_params.appearance is set, UPE skips its client-side
 *              DOM scan entirely and applies our config. This makes the card
 *              inputs viewport-independent (bug Stephane hit on Android / Daniel
 *              in responsive view was theme flipping between "stripe" and
 *              "night" based on Colibri column bg color extracted via isLight()).
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * Ref: class-wc-stripe-upe-payment-gateway.php:507 apply_filters('wc_stripe_upe_params', ...)
 *      build/upe-classic.js cache-hit: const s = Re()?.[i]; if (s) return s;
 *
 * Rollback: delete this file. UPE reverts to DOM scanning (viewport-dependent).
 *
 * Scope: fires only when UPE params are localized (checkout + order-pay).
 * Zero blast radius outside card input fields.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'wc_stripe_upe_params', 'rg_stripe_upe_appearance_lock', 20 );

// Also handle the blocks checkout variant (site currently uses classic, but
// Daniel may enable blocks checkout later — this is a no-op until he does).
add_filter( 'wc_stripe_blocks_params', 'rg_stripe_upe_appearance_lock', 20 );

function rg_stripe_upe_appearance_lock( $params ) {
	if ( ! is_array( $params ) ) return $params;

	$appearance = array(
		'theme'     => 'night',
		'variables' => array(
			'colorBackground'      => '#0f0c08',
			'colorText'            => '#ffffff',
			'colorTextPlaceholder' => 'rgba(255, 255, 255, 0.55)',
			'colorPrimary'         => '#CCC593',
			'colorDanger'          => '#ff8a8a',
			'colorIconTab'         => '#CCC593',
			'colorIconTabSelected' => '#CCC593',
			'fontFamily'           => 'Inter, system-ui, sans-serif',
			'fontSizeBase'         => '15px',
			'borderRadius'         => '6px',
		),
		'rules'     => array(
			'.Input' => array(
				'color'           => '#ffffff',
				'backgroundColor' => 'rgba(20, 16, 10, 0.4)',
				'border'          => '1px solid rgba(204, 197, 147, 0.3)',
			),
			'.Input:focus' => array(
				'border'     => '1px solid #CCC593',
				'boxShadow'  => '0 0 0 1px #CCC593',
			),
			'.Input--invalid' => array(
				'color'  => '#ff8a8a',
				'border' => '1px solid #ff8a8a',
			),
			'.Label' => array(
				'color'      => '#CCC593',
				'fontWeight' => '500',
			),
			'.Tab' => array(
				'color'           => '#CCC593',
				'backgroundColor' => 'rgba(20, 16, 10, 0.4)',
				'border'          => '1px solid rgba(204, 197, 147, 0.2)',
			),
			'.Tab--selected' => array(
				'color'           => '#ffffff',
				'backgroundColor' => 'rgba(204, 197, 147, 0.12)',
				'border'          => '1px solid #CCC593',
			),
		),
	);

	$params['appearance'] = $appearance;

	// blocksAppearance key is used by the block checkout path in upe-classic.js.
	// Same config works for both — sub-agent verified both branches read the same shape.
	$params['blocksAppearance'] = $appearance;

	return $params;
}
