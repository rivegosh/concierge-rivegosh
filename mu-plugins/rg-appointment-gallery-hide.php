<?php
/**
 * Plugin Name: Rive Gosh — Appointment Gallery Button Hide
 * Description: On /appointment/ (page 44401), hides the "View all photos" button
 *              and thumbnail strip inside Amelia's service gallery, while keeping
 *              the main vehicle photo (gallery-hero) fully visible.
 *              The gallery CONTAINER stays — only the multi-photo UI elements are removed.
 * Author: RG
 * Version: 1.3.0
 * Created: 2026-04-18
 * Updated: 2026-04-19
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard fix. Verified visually via Chrome          ║
 * ║  screenshot on 2026-04-19 and signed off.                        ║
 * ║                                                                   ║
 * ║  If the gallery UI on /appointment/ looks wrong later, FIX THE   ║
 * ║  CAUSE (Amelia update renaming classes) — do NOT delete this.    ║
 * ║  Ship additive overrides in a NEW mu-plugin if needed.           ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: Amelia renders a gallery UI with a        ║
 * ║  "View all photos" button and thumbnail strip regardless of      ║
 * ║  photo count. Daniel UX decision: remove the button/thumbnails,  ║
 * ║  keep the vehicle photo (gallery-hero). DO NOT hide the gallery  ║
 * ║  container — the car photo lives inside it.                     ║
 * ║                                                                   ║
 * ║  CSS HISTORY: v1.0-v1.2 incorrectly hid the entire gallery       ║
 * ║  container, removing the car photo too. v1.3.0 targets only      ║
 * ║  .am-fcis__gallery-btn and .am-fcis__gallery-thumb__wrapper.     ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#82                          ║
 * ║  Commit of record: TBD                                            ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_appointment_gallery_hide', 99999 );
function rg_appointment_gallery_hide() {
    if ( ! is_page( 44401 ) ) return;
    ?>
    <style id="rg-appointment-gallery-hide">
    /*
     * Hide "View all photos" button and thumbnail strip.
     * Keep .am-fcis__gallery container + .am-fcis__gallery-hero (the car photo).
     * Specificity (1,3,1): body.page-id-44401 + .amelia-v2-booking + #amelia-container + class
     */
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcis__gallery-btn,
    body.page-id-44401 .amelia-v2-booking [class*="fcis__gallery-btn"],
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcip__gallery-btn,
    body.page-id-44401 .amelia-v2-booking [class*="fcip__gallery-btn"],
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcis__gallery-thumb__wrapper,
    body.page-id-44401 .amelia-v2-booking [class*="fcis__gallery-thumb__wrapper"],
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcip__gallery-thumb__wrapper,
    body.page-id-44401 .amelia-v2-booking [class*="fcip__gallery-thumb__wrapper"] {
        display: none !important;
    }

    /* Expand hero photo to full width since thumbnail column is hidden */
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcis__gallery-hero,
    body.page-id-44401 .amelia-v2-booking [class*="fcis__gallery-hero"],
    body.page-id-44401 .amelia-v2-booking #amelia-container .am-fcip__gallery-hero,
    body.page-id-44401 .amelia-v2-booking [class*="fcip__gallery-hero"] {
        width: 100% !important;
        border-top-right-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }
    </style>

    <script type="text/javascript" id="rg-gallery-js-kill">
    /* JS fallback: MutationObserver targets only the button + thumb wrapper.
       inline !important via setProperty beats all stylesheet rules. */
    (function() {
        var BTN_SELECTORS = [
            '.am-fcis__gallery-btn',
            '.am-fcip__gallery-btn',
            '.am-fcis__gallery-thumb__wrapper',
            '.am-fcip__gallery-thumb__wrapper'
        ].join(',');

        var HERO_SELECTORS = [
            '.am-fcis__gallery-hero',
            '.am-fcip__gallery-hero'
        ].join(',');

        function applyGalleryFix(root) {
            var scope = (root && root.querySelectorAll) ? root : document;
            scope.querySelectorAll(BTN_SELECTORS).forEach(function(el) {
                el.style.setProperty('display', 'none', 'important');
            });
            scope.querySelectorAll(HERO_SELECTORS).forEach(function(el) {
                el.style.setProperty('width', '100%', 'important');
                el.style.setProperty('border-top-right-radius', '8px', 'important');
                el.style.setProperty('border-bottom-right-radius', '8px', 'important');
            });
        }

        applyGalleryFix(document);

        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) {
                        applyGalleryFix(node);
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    })();
    </script>
    <?php
}
