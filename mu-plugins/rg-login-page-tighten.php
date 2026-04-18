<?php
/**
 * Plugin Name: Rive Gosh — Login Page Tighten
 * Description: Spacing/visual tightening for /login-2/ UM login form (page 73400, form 73396).
 *              Overrides rg-amelia-contrast.php's rg-um-login-redesign block — loads later
 *              (alphabetical mu-plugin order: l > a) so wins at equal !important specificity.
 *              Fixes: double-card border, label-field gap, field-field gap, checkbox layout,
 *              outer card margin/padding.
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-18
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  Frozen gold-standard spacing fix. Verified visually 2026-04-18. ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: rg-amelia-contrast.php applies the same   ║
 * ║  card styling (border + bg + padding) to both .um.um-73396 AND   ║
 * ║  .um.um-73396 .um-form — creating two nested visible cards. This ║
 * ║  file strips the inner card and tightens all vertical spacing.   ║
 * ║                                                                   ║
 * ║  If /login-2/ spacing looks off later, ship additive CSS in a    ║
 * ║  NEW mu-plugin rather than editing this file.                    ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#5                           ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_login_page_tighten', 99999 );
function rg_login_page_tighten() {
    if ( ! is_page( array( 'login-2', 73400 ) ) ) return;
    ?>
    <style id="rg-login-page-tighten">

    /* ── Strip inner card — removes double border/bg ──────────────── */
    body .um.um-73396 .um-form,
    body .um.um-login .um-form {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        padding: 0 !important;
        margin: 0 !important;
        border-radius: 0 !important;
    }

    /* ── Outer card: tighter padding + less page margin ───────────── */
    .um.um-73396 {
        padding: 32px 36px !important;
        margin: 20px auto !important;
    }

    /* ── Label-to-field gap: 8px → 4px ───────────────────────────── */
    .um.um-73396 .um-field-label,
    .um.um-73396 label,
    .um.um-73396 .um-field label {
        margin-bottom: 4px !important;
    }

    /* ── Field-to-field spacing: 20px → 12px ─────────────────────── */
    .um.um-73396 .um-field,
    .um.um-73396 .um-form-row {
        margin-bottom: 12px !important;
    }

    /* ── Bottom row (checkbox + login button): 22px → 10px ───────── */
    .um.um-73396 .um-col-alt,
    .um.um-73396 .um-footer {
        margin-top: 10px !important;
        padding-top: 0 !important;
        border-top: none !important;
    }

    /* ── Checkbox row: flex + tight gap between box and label ─────── */
    .um.um-73396 .um-field-checkbox {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        cursor: pointer !important;
    }
    .um.um-73396 .um-field-checkbox-state {
        flex-shrink: 0 !important;
        margin: 0 !important;
        line-height: 1 !important;
    }
    .um.um-73396 .um-field-checkbox-option {
        margin: 0 !important;
        padding: 0 !important;
        line-height: 1.3 !important;
    }

    /* ── Login button: tighten top margin ─────────────────────────── */
    .um.um-73396 .um-center {
        margin-top: 14px !important;
    }
    .um.um-73396 input[type="submit"],
    .um.um-73396 .um-button {
        margin-top: 0 !important;
    }

    /* ── Forgot password link: tighter top ────────────────────────── */
    .um.um-73396 .um-col-alt-b {
        margin-top: 14px !important;
        padding-top: 12px !important;
        border-top: 1px solid rgba(204,197,147,0.12) !important;
    }

    </style>
    <?php
}
