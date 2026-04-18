<?php
/**
 * Plugin Name: Rive Gosh — Appointment Gallery Hide
 * Description: Hides the Amelia service/package gallery section on /appointment/
 *              (page 44401). All 54 vehicle services have exactly 1 photo; showing
 *              a dark empty gallery area + "View all photos" button for a single
 *              image is confusing UX. The vehicle photo is already visible as a
 *              thumbnail in the service card above. Removes the dark box entirely.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-18
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
 * ║  dark empty area with a "View all photos" button that leads to   ║
 * ║  the same single image. Removed per Daniel UX decision.          ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#82                          ║
 * ║  Commit of record: a53eed2                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_appointment_gallery_hide', 99999 );
function rg_appointment_gallery_hide() {
    if ( ! is_page( 44401 ) ) return;
    ?>
    <style id="rg-appointment-gallery-hide">
    /* Hide the gallery section on the Amelia service detail step.
       .am-fcis__gallery = service view; .am-fcip__gallery = package view.
       DB audit confirmed 54/55 services have 1 photo — gallery UI is dead weight. */
    .am-fcis__gallery,
    .am-fcip__gallery {
        display: none !important;
    }
    </style>
    <?php
}
