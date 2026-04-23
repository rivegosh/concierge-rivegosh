<?php
/**
 * Plugin Name: RG Amelia Cart Title White
 * Description: Makes the Amelia wizard Cart-step title text white on the dark
 *              theme. Target: <div class="am-fs__cart-title"> which renders
 *              "You can find below the appointments you selected for booking..."
 *              Currently inherits a dark color making it invisible on dark bg.
 *              Scoped to .amelia-v2-booking .am-fs__cart-title — zero bleed.
 * Version: 1.0.0
 * Created: 2026-04-23
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-cart-title-white">
	body .amelia-v2-booking .am-fs__cart-title,
	html body .amelia-v2-booking .am-fs__cart-title {
		color: rgba(255, 255, 255, 0.85) !important;
	}
	</style>
	<?php
}, 100000 );
