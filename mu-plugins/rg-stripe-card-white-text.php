<?php
/**
 * Plugin Name: RG Stripe Card White Text
 * Description: Stripe Elements card inputs render INSIDE an iframe — external CSS
 *              can't reach the typed text. The only path is Stripe.js config via
 *              `wc_stripe_params.elements_styling`. Default is #31325F (navy) which
 *              appears blue on the dark checkout theme. We override to pure white,
 *              champagne icon, and white-translucent placeholder.
 * Version: 1.0.0
 * Created: 2026-04-23
 *
 * How Stripe reads this: woocommerce-gateway-stripe/assets/js/stripe.js line 91
 *   elementStyles = wc_stripe_params.elements_styling ? wc_stripe_params.elements_styling : elementStyles;
 * Default shape it expects (stripe.js line 74):
 *   { base: { iconColor, color, fontSize, '::placeholder': { color } } }
 * We mirror exact shape to avoid Stripe.js silently falling back.
 *
 * Scope: fires ONLY when WC Stripe gateway loads its params (checkout + order-pay).
 * Zero blast radius outside card input fields.
 *
 * Rollback: delete this file. Stripe reverts to default #31325F.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'wc_stripe_params', 'rg_stripe_card_white_text_styling', 20 );

function rg_stripe_card_white_text_styling( $params ) {
	if ( ! is_array( $params ) ) return $params;

	$params['elements_styling'] = array(
		'base' => array(
			'iconColor'     => '#CCC593',          // champagne gold (matches theme)
			'color'         => '#ffffff',          // typed digits pure white
			'fontSize'      => '15px',             // match Amelia/checkout body sizing
			'fontFamily'    => 'Inter, sans-serif', // match site typography
			'::placeholder' => array(
				'color' => 'rgba(255, 255, 255, 0.55)', // white at 55% opacity
			),
		),
		'invalid' => array(
			'color'     => '#ff8a8a', // soft red for invalid state, still visible on dark
			'iconColor' => '#ff8a8a',
		),
	);

	return $params;
}
