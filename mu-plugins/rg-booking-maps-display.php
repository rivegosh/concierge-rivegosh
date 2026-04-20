<?php
/**
 * Plugin Name: Rive Gosh — Booking Maps Display
 * Description: Injects a live Google Maps route panel into the Amelia "Your Information"
 *   step. Watches for .am-fs__info in .amelia-v2-booking, then shows origin→destination
 *   route when both address fields are filled. Custom fields: #20 Pickup, #21 Destination,
 *   #27 Pickup (secondary service set).
 * Version: 1.0.0 (2026-04-20)
 * GitHub: rivegosh/concierge-rivegosh
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {

    // Only inject where Amelia is present — no page restriction needed;
    // MutationObserver activates only when .amelia-v2-booking is in DOM.
    if ( ! class_exists( 'AmeliaBooking\Infrastructure\WP\InstallActions\ActivationSettingsHook' ) &&
         ! defined( 'AMELIA_VERSION' ) ) {
        return;
    }

    // Address field IDs: 20 = Pickup, 21 = Destination (service set A)
    //                    27 = Pickup (service set B — maps to first address field in that flow)
    $api_key = get_option( 'amelia_settings' );
    $api_key = is_string( $api_key ) ? json_decode( $api_key, true ) : $api_key;
    $gmap_key = isset( $api_key['general']['gMapApiKey'] ) ? esc_js( $api_key['general']['gMapApiKey'] ) : '';

    ?>
    <style id="rg-maps-display-css">
    #rg-map-panel {
        width: 100%;
        height: 320px;
        margin-top: 24px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid rgba(204, 197, 147, 0.35);
        background: #0f0c08;
        flex-shrink: 0;
    }
    /* Slide the info form beside the map on desktop */
    @media (min-width: 992px) {
        .rg-info-with-map {
            display: flex !important;
            flex-direction: row !important;
            gap: 24px !important;
            align-items: flex-start !important;
        }
        .rg-info-with-map .am-fs__info-form {
            flex: 0 0 360px !important;
            min-width: 0 !important;
        }
        .rg-info-with-map #rg-map-panel {
            flex: 1 1 auto !important;
            height: 440px !important;
            margin-top: 0 !important;
        }
    }
    /* Dark map label strip */
    #rg-map-panel-label {
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: rgba(204,197,147,0.6);
        margin-top: 8px;
        text-align: center;
    }
    </style>
    <!--noptimize--><script id="rg-maps-display-js">
    (function () {
        // Field IDs for address autocomplete inputs (Amelia renders id="amelia-address-autocomplete-{id}")
        var FIELD_PAIRS = [
            { pickup: 20, dest: 21 },  // Service set A (3 services)
            { pickup: 27, dest: 28 },  // Service set B (36 services) — 28 is text-area but used as dest
        ];

        var mapInstance = null, dirService = null, dirRenderer = null;
        var mapInjected = false;
        var lastPickup = '', lastDest = '';

        // Dark luxury map styles
        var DARK_STYLE = [
            { elementType: 'geometry', stylers: [{ color: '#1a1a1a' }] },
            { elementType: 'labels.text.fill', stylers: [{ color: '#ccc593' }] },
            { elementType: 'labels.text.stroke', stylers: [{ color: '#1a1a1a' }] },
            { featureType: 'road', elementType: 'geometry', stylers: [{ color: '#2c2c2c' }] },
            { featureType: 'road', elementType: 'geometry.stroke', stylers: [{ color: '#111' }] },
            { featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#3d3d3d' }] },
            { featureType: 'water', elementType: 'geometry', stylers: [{ color: '#0f0c08' }] },
            { featureType: 'water', elementType: 'labels.text.fill', stylers: [{ color: '#ccc593' }] },
            { featureType: 'poi', stylers: [{ visibility: 'off' }] },
            { featureType: 'transit', stylers: [{ visibility: 'off' }] },
        ];

        function getPickupDestPair() {
            // Try each pair — return the first one where we find the pickup field
            for (var i = 0; i < FIELD_PAIRS.length; i++) {
                var p = document.getElementById('amelia-address-autocomplete-' + FIELD_PAIRS[i].pickup);
                if (p) {
                    var d = document.getElementById('amelia-address-autocomplete-' + FIELD_PAIRS[i].dest);
                    if (!d) {
                        // dest might be a text-area — try input with that id
                        d = document.querySelector('[id="amelia-address-autocomplete-' + FIELD_PAIRS[i].dest + '"]');
                    }
                    return { pickupEl: p, destEl: d };
                }
            }
            return null;
        }

        function injectMap(infoStep) {
            if (mapInjected) return;
            if (!window.google || !window.google.maps) return;
            mapInjected = true;

            // Wrap infoStep content in flex row on desktop
            infoStep.classList.add('rg-info-with-map');

            var panel = document.createElement('div');
            panel.id = 'rg-map-panel';
            infoStep.appendChild(panel);

            var label = document.createElement('div');
            label.id = 'rg-map-panel-label';
            label.textContent = 'Route Preview';
            infoStep.appendChild(label);

            dirService = new google.maps.DirectionsService();
            mapInstance = new google.maps.Map(panel, {
                center: { lat: 48.8566, lng: 2.3522 },
                zoom: 10,
                styles: DARK_STYLE,
                disableDefaultUI: true,
                zoomControl: true,
            });
            dirRenderer = new google.maps.DirectionsRenderer({
                polylineOptions: { strokeColor: '#ccc593', strokeWeight: 4 },
                suppressMarkers: false,
            });
            dirRenderer.setMap(mapInstance);

            wireAddressListeners();
        }

        function wireAddressListeners() {
            // Watch for address dropdown disappearing from body → selection was made
            var bodyObs = new MutationObserver(function (muts) {
                muts.forEach(function (m) {
                    m.removedNodes.forEach(function (node) {
                        if (node.nodeType === 1 && node.classList && node.classList.contains('am-address-dropdown')) {
                            setTimeout(tryUpdateRoute, 150);
                        }
                    });
                });
            });
            bodyObs.observe(document.body, { childList: true });

            // Also fallback: listen for input events (covers manual typing + paste)
            var pair = getPickupDestPair();
            if (pair && pair.pickupEl) {
                pair.pickupEl.addEventListener('input', debounce(tryUpdateRoute, 1200));
            }
            if (pair && pair.destEl) {
                pair.destEl.addEventListener('input', debounce(tryUpdateRoute, 1200));
            }
        }

        function tryUpdateRoute() {
            if (!dirService || !dirRenderer) return;
            var pair = getPickupDestPair();
            if (!pair || !pair.pickupEl) return;

            var pickup = pair.pickupEl.value.trim();
            var dest = pair.destEl ? pair.destEl.value.trim() : '';
            if (!pickup || !dest) return;

            // Avoid redundant API calls
            if (pickup === lastPickup && dest === lastDest) return;
            lastPickup = pickup;
            lastDest = dest;

            dirService.route({
                origin: pickup,
                destination: dest,
                travelMode: google.maps.TravelMode.DRIVING,
            }, function (result, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    dirRenderer.setDirections(result);
                    var label = document.getElementById('rg-map-panel-label');
                    if (label && result.routes[0] && result.routes[0].legs[0]) {
                        var leg = result.routes[0].legs[0];
                        label.textContent = leg.distance.text + ' · ' + leg.duration.text;
                    }
                }
            });
        }

        function debounce(fn, ms) {
            var t;
            return function () { clearTimeout(t); t = setTimeout(fn, ms); };
        }

        function watchAmelia() {
            var amelia = document.querySelector('.amelia-v2-booking');
            if (!amelia) {
                // Retry after brief delay — wizard may not be mounted yet
                setTimeout(watchAmelia, 600);
                return;
            }
            var observer = new MutationObserver(function () {
                var infoStep = amelia.querySelector('.am-fs__info');
                if (infoStep && !mapInjected) {
                    if (window.google && window.google.maps) {
                        injectMap(infoStep);
                    } else {
                        // Maps not loaded yet — poll until ready
                        var poll = setInterval(function () {
                            if (window.google && window.google.maps) {
                                clearInterval(poll);
                                injectMap(infoStep);
                            }
                        }, 200);
                    }
                }
                // Reset when user navigates away from info step
                if (!amelia.querySelector('.am-fs__info') && mapInjected) {
                    mapInjected = false;
                    lastPickup = '';
                    lastDest = '';
                }
            });
            observer.observe(amelia, { childList: true, subtree: true });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', watchAmelia);
        } else {
            watchAmelia();
        }
    })();
    </script><!--/noptimize-->
    <?php
}, 99999 );
