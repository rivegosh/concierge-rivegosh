<?php
/**
 * Plugin Name: Rive Gosh — Appointment Gallery Hide
 * Description: Hides the Amelia service/package gallery section on /appointment/
 *              (page 44401). All 54 vehicle services have exactly 1 photo; showing
 *              a dark empty gallery area + "View all photos" button for a single
 *              image is confusing UX. The vehicle photo is already visible as a
 *              thumbnail in the service card above. Removes the dark box entirely.
 * Author: RG
 * Version: 1.2.0
 * Created: 2026-04-18
 * Updated: 2026-04-18
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. Verified visually via Chrome          ║
 * ║  screenshot on 2026-04-18 and signed off.                        ║
 * ║                                                                   ║
 * ║  If the gallery area on /appointment/ looks wrong later, FIX THE ║
 * ║  CAUSE (Amelia update renaming .am-fcis__gallery class, or a     ║
 * ║  service gaining multiple photos) — do NOT delete this file.     ║
 * ║  Ship additive overrides in a NEW mu-plugin if needed.           ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: Amelia's service detail step renders a    ║
 * ║  full gallery UI (.am-fcis__gallery) for all services regardless ║
 * ║  of photo count. DB audit 2026-04-18 confirmed 54/55 vehicle     ║
 * ║  services have exactly 1 photo — the gallery shows as a large    ║
 * ║  dark empty area with a "View all photos" button. Removed per    ║
 * ║  Daniel UX decision.                                             ║
 * ║                                                                   ║
 * ║  CSS HISTORY: v1.0.0 used bare .am-fcis__gallery (0,1,0).       ║
 * ║  v1.1.0 added .amelia-v2-booking parent (0,2,0) to beat         ║
 * ║  rg-amelia-contrast.php's competing display:flex !important.     ║
 * ║  v1.2.0: nuclear CSS (1,3,1) + JS MutationObserver fallback     ║
 * ║  that sets inline display:none !important — immune to all CSS.   ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#82                          ║
 * ║  Commit of record: TBD (update after merge)                      ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_appointment_gallery_hide', 99999 );
function rg_appointment_gallery_hide() {
    if ( ! is_page( 44401 ) ) return;
    ?>
    <style id="rg-appointment-gallery-hide">
    /*
     * NUCLEAR CSS — specificity (1,3,1):
     * body.page-id-44401 = (0,1,1)
     * .amelia-v2-booking  = (0,1,0)
     * #amelia-container   = (1,0,0)
     * .am-fcis__gallery   = (0,1,0)
     * Total               = (1,3,1)
     *
     * Beats:
     * - rg-amelia-contrast.php: .amelia-v2-booking [class*="fcis__gallery"] = (0,2,0) !important
     * - Amelia catalogForm CSS: .amelia-v2-booking #amelia-container .am-fcis__gallery = (1,2,0)
     * - Any future rule short of inline !important (handled by JS below)
     */
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcis__gallery,
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcip__gallery,
    body.page-id-44401 .amelia-v2-booking .am-fcis__gallery,
    body.page-id-44401 .amelia-v2-booking .am-fcip__gallery,
    body.page-id-44401 .amelia-v2-booking [class*="fcis__gallery"]:not([class*="gallery-hero"]):not([class*="gallery-thumb"]):not([class*="gallery-btn"]):not([class*="gallery-icon"]),
    body.page-id-44401 .amelia-v2-booking [class*="fcip__gallery"]:not([class*="gallery-hero"]):not([class*="gallery-thumb"]):not([class*="gallery-btn"]):not([class*="gallery-icon"]) {
        display: none !important;
        min-height: 0 !important;
        max-height: 0 !important;
        overflow: hidden !important;
        visibility: hidden !important;
    }
    </style>

    <script type="text/javascript" id="rg-gallery-js-kill">
    /* JS fallback: MutationObserver sets inline display:none !important on gallery elements.
       Inline style.setProperty with 'important' priority beats ALL stylesheet rules including
       !important declarations — guaranteed hide regardless of CSS specificity battles. */
    (function() {
        function killGalleries(root) {
            var gallerySelectors = [
                '.am-fcis__gallery',
                '.am-fcip__gallery'
            ];
            gallerySelectors.forEach(function(sel) {
                var els = (root.querySelectorAll ? root : document).querySelectorAll(sel);
                els.forEach(function(el) {
                    /* Skip sub-elements inside the gallery (hero photo, thumbs, btn) */
                    if (el.className.indexOf('gallery-hero') === -1 &&
                        el.className.indexOf('gallery-thumb') === -1 &&
                        el.className.indexOf('gallery-btn') === -1) {
                        el.style.setProperty('display', 'none', 'important');
                        el.style.setProperty('min-height', '0', 'important');
                        el.style.setProperty('max-height', '0', 'important');
                        el.style.setProperty('visibility', 'hidden', 'important');
                    }
                });
            });
        }

        /* Run on existing DOM immediately */
        killGalleries(document);

        /* Watch for Vue rendering gallery elements after user clicks Continue */
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) {
                        /* Check the node itself */
                        if (node.className && typeof node.className === 'string') {
                            if (node.className.indexOf('am-fcis__gallery') !== -1 ||
                                node.className.indexOf('am-fcip__gallery') !== -1) {
                                if (node.className.indexOf('gallery-hero') === -1 &&
                                    node.className.indexOf('gallery-thumb') === -1 &&
                                    node.className.indexOf('gallery-btn') === -1) {
                                    node.style.setProperty('display', 'none', 'important');
                                    node.style.setProperty('min-height', '0', 'important');
                                    node.style.setProperty('max-height', '0', 'important');
                                    node.style.setProperty('visibility', 'hidden', 'important');
                                }
                            }
                        }
                        /* Check descendants */
                        killGalleries(node);
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    })();
    </script>
    <?php
}
