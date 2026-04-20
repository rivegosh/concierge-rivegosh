<?php
/**
 * Plugin Name: RG — Amelia Send Access Link Modal (Dark Luxury)
 * Description: Reskins the Amelia V3 "Send Access Link" customer-panel login card (.am-asi) with the Rive Gosh dark palette: #0f0c08 panel, champagne gold #CCC593 text, gold Send button with readable dark label. Fixes white-on-white input text.
 * Author:      RG
 * Version:     2.1.0
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ─────────────────────────────────────────────────────────────── ║
 * ║  Frozen gold-standard reskin. Verified visually via Chrome       ║
 * ║  screenshot on 2026-04-17 and signed off.                        ║
 * ║                                                                  ║
 * ║  If the Amelia Send Access Link / customer-panel login modal    ║
 * ║  looks wrong later, FIX THE CAUSE (another mu-plugin, Amelia    ║
 * ║  plugin update, theme override) — do NOT gut or rewrite this    ║
 * ║  file. Ship additive overrides in a NEW mu-plugin if adjustment ║
 * ║  is genuinely needed.                                            ║
 * ║                                                                  ║
 * ║  WHY THIS FILE EXISTS: Amelia ships two rendering engines. Our   ║
 * ║  legacy rg-amelia-contrast.php covers V2 (.am-dialog). The      ║
 * ║  Send Access Link card is rendered by V3 using .am-asi — a      ║
 * ║  completely different class prefix. Without these overrides the ║
 * ║  modal is a white card with invisible white-on-white input      ║
 * ║  text.                                                           ║
 * ║                                                                  ║
 * ║  GitHub: rivegosh/concierge-rivegosh#77                          ║
 * ║  Commit of record: 8a21139                                      ║
 * ╚══════════════════════════════════════════════════════════════════╝
 *
 * V3 component classes discovered in:
 *   wp-content/plugins/ameliabooking/v3/public/assets/customerPanel.*.css
 * Real wrapper is .am-asi / .am-asi-sign-in (NOT .am-dialog — that's V2).
 * Do NOT append to rg-amelia-contrast.php — concurrent-session wipe hazard.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_amelia_access_link_css', 99999 );
function rg_amelia_access_link_css() {
    ?>
    <style id="rg-amelia-access-link">
    /* === AMELIA V3 "SEND ACCESS LINK" — DARK LUXURY RESKIN v2 === */

    /* Override the CSS custom props scoped to the card — cascades to all children */
    body .am-asi,
    body .am-asi-sign-in,
    body .amelia-v2-booking .am-asi,
    body #amelia-container .am-asi {
        --am-c-main-bgr: #0f0c08 !important;
        --am-c-main-heading-text: #CCC593 !important;
        --am-c-main-text: rgba(240,235,225,0.92) !important;
        --am-c-main-text-op70: rgba(240,235,225,0.78) !important;
        --am-c-main-text-op60: rgba(240,235,225,0.65) !important;
        --am-c-main-text-op40: rgba(204,197,147,0.35) !important;
        --am-c-main-text-op25: rgba(0,0,0,0.55) !important;
        --am-c-primary: #CCC593 !important;
        --am-c-error: #d4847a !important;
        background: #0f0c08 !important;
        background-color: #0f0c08 !important;
        border: 1px solid rgba(204,197,147,0.35) !important;
        border-radius: 4px !important;
        box-shadow:
            0 20px 60px rgba(0,0,0,0.6),
            0 0 0 1px rgba(204,197,147,0.15) !important;
        color: rgba(240,235,225,0.92) !important;
    }

    /* Title "Send Access Link" */
    body .am-asi .am-asi__header,
    body #amelia-container .am-asi .am-asi__header {
        color: #CCC593 !important;
        font-family: 'Cormorant Garamond', serif !important;
        font-weight: 500 !important;
        letter-spacing: 0.04em !important;
    }

    /* Description text */
    body .am-asi .am-asi__text,
    body #amelia-container .am-asi .am-asi__text,
    body .am-asi .am-asi__footer-text,
    body .am-asi .am-asi__email {
        color: rgba(240,235,225,0.82) !important;
        font-family: 'Inter', sans-serif !important;
    }

    /* Footer links (e.g. "Back to Login") */
    body .am-asi .am-asi__footer-link {
        color: #CCC593 !important;
    }

    /* Form labels */
    body .am-asi .el-form-item__label,
    body .am-asi .am-ff__item-label,
    body .am-asi label {
        color: rgba(204,197,147,0.9) !important;
        font-family: 'Inter', sans-serif !important;
    }

    /* Required red asterisk — keep readable red */
    body .am-asi .el-form-item__label:before,
    body .am-asi .am-required,
    body .am-asi [class*="asterisk"] {
        color: #d4847a !important;
    }

    /* Email input — fixes white-on-white typing bug */
    body .am-asi input,
    body .am-asi input[type="text"],
    body .am-asi input[type="email"],
    body .am-asi .el-input__wrapper,
    body .am-asi .el-input__inner,
    body #amelia-container .am-asi input,
    body #amelia-container .am-asi .el-input__wrapper,
    body #amelia-container .am-asi .el-input__inner {
        background: rgba(20,16,10,0.95) !important;
        background-color: rgba(20,16,10,0.95) !important;
        border: 1px solid rgba(204,197,147,0.35) !important;
        border-radius: 2px !important;
        color: rgba(240,235,225,0.98) !important;
        -webkit-text-fill-color: rgba(240,235,225,0.98) !important;
        caret-color: #CCC593 !important;
        box-shadow: none !important;
        font-family: 'Inter', sans-serif !important;
    }
    body .am-asi input::placeholder,
    body .am-asi .el-input__inner::placeholder,
    body #amelia-container .am-asi input::placeholder {
        color: rgba(204,197,147,0.45) !important;
        -webkit-text-fill-color: rgba(204,197,147,0.45) !important;
    }
    body .am-asi input:focus,
    body .am-asi .el-input__wrapper:focus-within,
    body .am-asi .el-input__inner:focus {
        border-color: rgba(204,197,147,0.85) !important;
        box-shadow: 0 0 0 3px rgba(204,197,147,0.14) !important;
        outline: none !important;
    }
    /* Autofill (Chrome) — kill the white autofill background */
    body .am-asi input:-webkit-autofill,
    body .am-asi input:-webkit-autofill:hover,
    body .am-asi input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px rgba(20,16,10,0.95) inset !important;
        -webkit-text-fill-color: rgba(240,235,225,0.98) !important;
        caret-color: #CCC593 !important;
    }

    /* Send button */
    body .am-asi .am-asi__btn,
    body .am-asi .am-asi__btn button,
    body .am-asi .el-button,
    body #amelia-container .am-asi .el-button {
        background: linear-gradient(180deg, #d4c78d 0%, #b8a769 100%) !important;
        background-color: #CCC593 !important;
        border: 1px solid rgba(204,197,147,0.95) !important;
        border-radius: 2px !important;
        color: #0f0c08 !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.4) !important;
        transition: all 0.2s ease !important;
    }
    body .am-asi .am-asi__btn *,
    body .am-asi .el-button * {
        color: #0f0c08 !important;
        -webkit-text-fill-color: #0f0c08 !important;
    }
    body .am-asi .el-button:hover {
        background: linear-gradient(180deg, #e0d49a 0%, #c4b47a 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 6px 20px rgba(204,197,147,0.28) !important;
    }

    /* Top feedback messages (success/error alerts) */
    body .am-asi .am-asi__top-message,
    body .am-asi .el-alert {
        background: rgba(20,16,10,0.9) !important;
        color: rgba(240,235,225,0.92) !important;
    }

    /* Error text under input */
    body .am-asi .el-form-item__error {
        color: #d4847a !important;
    }

    /* Social divider */
    body .am-asi .am-asi__social-divider:before,
    body .am-asi .am-asi__social-divider:after,
    body .amelia-v2-booking #amelia-container .am-asi .am-asi__social-divider:before,
    body .amelia-v2-booking #amelia-container .am-asi .am-asi__social-divider:after {
        background: rgba(204,197,147,0.2) !important;
    }
    body .am-asi .am-asi__social-divider span {
        color: rgba(204,197,147,0.6) !important;
    }

    /* Close / X icons inside the card */
    body .am-asi .el-alert__closebtn,
    body .am-asi [class*="close"] {
        color: rgba(204,197,147,0.7) !important;
    }
    </style>
    <?php
}
