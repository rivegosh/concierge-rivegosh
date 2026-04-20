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

        var fallbackMode = false; // true when Maps JS tile API unavailable

        function injectMap(infoStep) {
            if (mapInjected) return;
            if (!window.google || !window.google.maps) return;
            mapInjected = true;

            infoStep.classList.add('rg-info-with-map');

            var panel = document.createElement('div');
            panel.id = 'rg-map-panel';
            infoStep.appendChild(panel);

            var label = document.createElement('div');
            label.id = 'rg-map-panel-label';
            label.textContent = 'Route Preview';
            infoStep.appendChild(label);

            // Watch for Google's error container injected into the panel
            // (fires on ExpiredKeyMapError / key restriction before setTimeout can react)
            var mapErrObs = new MutationObserver(function () {
                if (panel.querySelector('.gm-err-container, .gm-err-message, .gm-err')) {
                    mapErrObs.disconnect();
                    fallbackMode = true;
                    showFallbackPanel(panel, label, lastPickup, lastDest);
                }
            });
            mapErrObs.observe(panel, { childList: true, subtree: true });

            // Try full tile map
            try {
                dirService = new google.maps.DirectionsService();
                mapInstance = new google.maps.Map(panel, {
                    center: { lat: 37.0902, lng: -95.7129 },
                    zoom: 5,
                    styles: DARK_STYLE,
                    disableDefaultUI: true,
                    zoomControl: true,
                });
                dirRenderer = new google.maps.DirectionsRenderer({
                    polylineOptions: { strokeColor: '#ccc593', strokeWeight: 4 },
                    suppressMarkers: false,
                });
                dirRenderer.setMap(mapInstance);
            } catch (e) {
                fallbackMode = true;
                mapErrObs.disconnect();
                showFallbackPanel(panel, label, '', '');
            }

            wireAddressListeners();
        }

        function showFallbackPanel(panel, label, pickup, dest) {
            panel.innerHTML = '';
            panel.style.cssText = 'display:flex;flex-direction:column;align-items:center;justify-content:center;background:#0f0c08;border:1px solid rgba(204,197,147,0.35);border-radius:8px;padding:24px;box-sizing:border-box;';

            var icon = document.createElement('div');
            icon.innerHTML = '<svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#ccc593" stroke-width="1.5"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>';
            panel.appendChild(icon);

            var msg = document.createElement('div');
            msg.style.cssText = 'color:rgba(204,197,147,0.7);font-size:12px;text-align:center;margin:12px 0 4px;letter-spacing:0.06em;';
            msg.textContent = pickup && dest ? 'Route ready' : 'Enter pickup & destination';
            panel.appendChild(msg);

            var link = document.createElement('a');
            link.id = 'rg-map-route-link';
            link.target = '_blank';
            link.rel = 'noopener';
            link.style.cssText = 'display:inline-block;margin-top:12px;padding:10px 20px;background:transparent;border:1px solid rgba(204,197,147,0.5);border-radius:4px;color:#ccc593;font-size:11px;letter-spacing:0.1em;text-transform:uppercase;text-decoration:none;cursor:pointer;transition:border-color 0.2s;';
            link.textContent = 'View Route on Google Maps';
            link.style.opacity = (pickup && dest) ? '1' : '0.3';
            link.style.pointerEvents = (pickup && dest) ? 'auto' : 'none';

            if (pickup && dest) {
                link.href = 'https://www.google.com/maps/dir/?api=1&origin=' + encodeURIComponent(pickup) + '&destination=' + encodeURIComponent(dest) + '&travelmode=driving';
            } else {
                link.href = '#';
            }
            panel.appendChild(link);

            if (label) {
                label.textContent = pickup && dest ? 'Route ready — click to open' : '';
            }
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
            var pair = getPickupDestPair();
            if (!pair || !pair.pickupEl) return;

            var pickup = pair.pickupEl.value.trim();
            var dest = pair.destEl ? pair.destEl.value.trim() : '';
            if (!pickup || !dest) return;

            if (pickup === lastPickup && dest === lastDest) return;
            lastPickup = pickup;
            lastDest = dest;

            // Fallback mode: just update the link button
            if (fallbackMode || !dirService || !dirRenderer) {
                var panel = document.getElementById('rg-map-panel');
                var label = document.getElementById('rg-map-panel-label');
                if (panel) showFallbackPanel(panel, label, pickup, dest);
                return;
            }

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
