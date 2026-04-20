<?php
/**
 * Plugin Name: RG Homepage Luxury Banner
 * Description: Replaces "World of Luxury in One Place" collage section (page 61860 → data-colibri-id="61860-c19")
 *              with a 350px-tall full-width horizontal banner (airport horizon image).
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * WHY: The two-collage luxury section was dead vertical space. Daniel/Roderic asked
 * for a single horizontal banner there instead — airport/horizon aesthetic matches
 * the chauffeur/transfer core service. Section c19 contains the heading caption +
 * both side-by-side image collages (total ~1072px tall); we hide it and inject a
 * 350px banner slot in its place.
 *
 * HOW: front-page only (is_front_page). CSS hides c19 + injects ::after on its
 * parent (c2) with background-image of the uploaded banner. Using ::after on the
 * PARENT sidesteps the "hidden ancestor" trap — c19's own ::after would inherit
 * display:none.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function() {
	if ( ! is_front_page() ) return;

	$banner_url = content_url( 'uploads/2026/04/rg-homepage-plane-horizon.jpg' );

	echo '<style id="rg-homepage-luxury-placeholder">';

	/* Hide the entire luxury collage section */
	echo 'body#colibri.page-id-61860 [data-colibri-id="61860-c19"] { ';
	echo '  display: none !important; ';
	echo '}';

	/* Banner: inject as a sibling block after c19 (visible), full viewport width,
	   350px tall, image cropped on horizon via object-position.
	   We wrap the banner in a custom <div> injected via JS so it survives Colibri. */
	echo '#rg-homepage-banner { ';
	echo '  display: block !important; ';
	echo '  width: 100% !important; ';
	echo '  height: 350px !important; ';
	echo '  margin: 50px 0 !important; ';
	echo '  padding: 0 !important; ';
	echo '  background-image: url("' . esc_url( $banner_url ) . '") !important; ';
	echo '  background-size: cover !important; ';
	echo '  background-position: center 55% !important; ';
	echo '  background-repeat: no-repeat !important; ';
	echo '  background-color: #0a0a0a !important; ';
	echo '}';

	echo '</style>';

	/* Inject the banner div directly after c19 in the DOM (c19 is display:none so
	   it reserves no space — banner sits naturally in the document flow). */
	?>
	<script id="rg-homepage-luxury-placeholder-js">
	(function() {
		function inject() {
			if ( document.getElementById('rg-homepage-banner') ) return;
			var c19 = document.querySelector('[data-colibri-id="61860-c19"]');
			if ( ! c19 || ! c19.parentNode ) return;
			var banner = document.createElement('div');
			banner.id = 'rg-homepage-banner';
			banner.setAttribute('role', 'img');
			banner.setAttribute('aria-label', 'Airport runway horizon at sunrise');
			c19.parentNode.insertBefore( banner, c19.nextSibling );
		}
		if ( document.readyState === 'loading' ) {
			document.addEventListener( 'DOMContentLoaded', inject );
		} else {
			inject();
		}
	})();
	</script>
	<?php
}, 99999 );
