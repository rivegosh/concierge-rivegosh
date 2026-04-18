<?php
/**
 * Plugin Name: Rive Gosh — Login Forms Tighten
 * Description: Spacing/visual tightening for all UM + WC login forms.
 *              Covers: /login-2/ (UM 73396), /register/ (UM 73395),
 *              /my-orders/ (WC login, page 16).
 *              Overrides rg-amelia-contrast.php — loads later (l > a alphabetical)
 *              so wins at equal !important specificity.
 * Author: RG
 * Version: 1.1.0
 * Created: 2026-04-18
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  WHY THIS FILE EXISTS:                                            ║
 * ║  1. rg-amelia-contrast.php styles BOTH .um.um-73396 AND its      ║
 * ║     child .um-form with the card treatment → two nested cards.   ║
 * ║     This strips the inner card so only one border shows.         ║
 * ║  2. .um-col-alt has text-align:center !important which centers   ║
 * ║     the "Keep me signed in" text even in a flex label. This      ║
 * ║     overrides it to left-align the checkbox row.                 ║
 * ║  3. Extends the same dark luxury treatment + spacing to          ║
 * ║     /register/ (um-73395) and /my-orders/ (WC form).            ║
 * ║                                                                   ║
 * ║  If spacing looks off later, ship additive CSS in a NEW          ║
 * ║  mu-plugin rather than editing this file.                        ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#5                           ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_login_page_tighten', 99999 );
function rg_login_page_tighten() {
    $is_login    = is_page( array( 'login-2', 73400 ) );
    $is_register = is_page( array( 'register', 73401 ) );
    $is_myorders = is_page( 16 );

    if ( ! ( $is_login || $is_register || $is_myorders ) ) return;
    ?>
    <style id="rg-login-page-tighten">

    <?php if ( $is_login ) : ?>
    /* ══════════════════════════════════════════════════════════════
     * /login-2/ — UM form 73396
     * ══════════════════════════════════════════════════════════════ */

    /* Strip inner card — removes the double border/bg */
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

    /* Outer card: tighter padding + less vertical page margin */
    .um.um-73396 {
        padding: 32px 36px !important;
        margin: 20px auto !important;
    }

    /* Label-to-field gap: 8px → 4px */
    .um.um-73396 .um-field-label,
    .um.um-73396 label,
    .um.um-73396 .um-field label {
        margin-bottom: 4px !important;
    }

    /* Field-to-field spacing: 20px → 12px */
    .um.um-73396 .um-field,
    .um.um-73396 .um-form-row {
        margin-bottom: 12px !important;
    }

    /* Bottom row (checkbox + login): tighter top */
    .um.um-73396 .um-col-alt,
    .um.um-73396 .um-footer {
        margin-top: 10px !important;
        padding-top: 0 !important;
        border-top: none !important;
        text-align: left !important;
    }

    /* Checkbox row: use UM's native absolute+padding-left layout (reliable),
       indent the row 20px from the card edge, keep text left-aligned.
       Flex was causing children to stack vertically due to UM internal overrides. */
    .um.um-73396 .um-col-alt {
        padding-left: 20px !important;
    }
    .um.um-73396 .um-field-c .um-field-area {
        text-align: left !important;
    }
    .um.um-73396 .um-field-checkbox {
        position: relative !important;
        display: block !important;
        padding-left: 26px !important;
        text-align: left !important;
        cursor: pointer !important;
        min-height: 18px !important;
    }
    .um.um-73396 .um-field-checkbox-state {
        position: absolute !important;
        left: 0 !important;
        top: 1px !important;
        margin: 0 !important;
        line-height: 1 !important;
    }
    .um.um-73396 .um-field-checkbox-option {
        display: inline !important;
        margin: 0 !important;
        padding: 0 !important;
        text-align: left !important;
        line-height: 1.3 !important;
    }

    /* Login button: tighter top */
    .um.um-73396 .um-center {
        margin-top: 14px !important;
        text-align: center !important;
    }
    .um.um-73396 input[type="submit"],
    .um.um-73396 .um-button {
        margin-top: 0 !important;
    }

    /* Forgot password: hairline separator, tighter */
    .um.um-73396 .um-col-alt-b {
        margin-top: 14px !important;
        padding-top: 12px !important;
        border-top: 1px solid rgba(204,197,147,0.12) !important;
        text-align: center !important;
    }
    <?php endif; ?>

    <?php if ( $is_register ) : ?>
    /* ══════════════════════════════════════════════════════════════
     * /register/ — UM form 73395
     * rg-amelia-contrast.php styles .um-73396 only — this provides
     * the same dark luxury card + spacing for the register form.
     * ══════════════════════════════════════════════════════════════ */

    html:has(.um-73395) body { background-color: #0a0a0a !important; }
    html:has(.um-73395) .overlay-image-layer { background-image: none !important; opacity: 0 !important; }

    .um.um-73395 {
        background: rgba(14,11,7,0.88) !important;
        backdrop-filter: blur(28px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(28px) saturate(180%) !important;
        border: 1px solid rgba(204,197,147,0.22) !important;
        border-radius: 12px !important;
        padding: 32px 36px !important;
        max-width: 440px !important;
        margin: 20px auto !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5) !important;
    }
    body .um.um-73395 .um-form {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .um.um-73395 .um-field-label,
    .um.um-73395 label,
    .um.um-73395 .um-field label {
        color: rgba(220,213,170,0.92) !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        margin-bottom: 4px !important;
        display: block !important;
    }
    .um.um-73395 input[type="text"],
    .um.um-73395 input[type="email"],
    .um.um-73395 input[type="password"],
    .um.um-73395 .um-form-field {
        background: rgba(24,20,12,0.95) !important;
        color: rgba(220,213,170,0.95) !important;
        border: 1px solid rgba(204,197,147,0.25) !important;
        border-radius: 6px !important;
        padding: 14px 16px !important;
        font-size: 14px !important;
        height: auto !important;
        box-shadow: none !important;
    }
    .um.um-73395 input[type="text"]:focus,
    .um.um-73395 input[type="email"]:focus,
    .um.um-73395 input[type="password"]:focus {
        border-color: rgba(204,197,147,0.6) !important;
        outline: none !important;
    }
    .um.um-73395 input::placeholder { color: rgba(220,213,170,0.35) !important; }
    .um.um-73395 .um-field,
    .um.um-73395 .um-form-row { margin-bottom: 12px !important; }
    .um.um-73395 input[type="submit"],
    .um.um-73395 .um-button {
        background: rgba(204,197,147,0.95) !important;
        color: #0a0a0a !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 14px 24px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        width: 100% !important;
        margin-top: 6px !important;
    }
    .um.um-73395 a {
        color: rgba(204,197,147,0.85) !important;
        font-size: 12px !important;
    }
    .um.um-73395 a:hover { color: rgba(220,213,170,1) !important; }
    .um.um-73395 .um-col-alt,
    .um.um-73395 .um-col-alt-b,
    .um.um-73395 .um-footer {
        margin-top: 10px !important;
        text-align: center !important;
    }
    /* Register checkbox (terms, if present) */
    .um.um-73395 .um-field-checkbox {
        display: flex !important;
        align-items: center !important;
        justify-content: flex-start !important;
        gap: 8px !important;
        text-align: left !important;
    }
    .um.um-73395 .um-field-checkbox-state {
        position: static !important;
        flex-shrink: 0 !important;
        margin: 0 !important;
    }
    .um.um-73395 .um-field-checkbox-option {
        position: static !important;
        text-align: left !important;
        margin: 0 !important;
        padding-left: 0 !important;
    }
    <?php endif; ?>

    <?php if ( $is_myorders ) : ?>
    /* ══════════════════════════════════════════════════════════════
     * /my-orders/ — WooCommerce login form (page 16)
     * Dark luxury treatment matching /login-2/ aesthetic.
     * ══════════════════════════════════════════════════════════════ */

    body.page-id-16 .woocommerce-form-login {
        background: rgba(14,11,7,0.88) !important;
        backdrop-filter: blur(28px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(28px) saturate(180%) !important;
        border: 1px solid rgba(204,197,147,0.22) !important;
        border-radius: 12px !important;
        padding: 32px 36px !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5) !important;
    }
    body.page-id-16 .woocommerce-form-login label {
        color: rgba(220,213,170,0.92) !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        margin-bottom: 4px !important;
        display: block !important;
    }
    body.page-id-16 .woocommerce-form-login .woocommerce-Input,
    body.page-id-16 .woocommerce-form-login input.input-text {
        background: rgba(24,20,12,0.95) !important;
        color: rgba(220,213,170,0.95) !important;
        border: 1px solid rgba(204,197,147,0.25) !important;
        border-radius: 6px !important;
        padding: 14px 16px !important;
        font-size: 14px !important;
        height: auto !important;
        box-shadow: none !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    body.page-id-16 .woocommerce-form-login .woocommerce-Input:focus {
        border-color: rgba(204,197,147,0.6) !important;
        outline: none !important;
    }
    body.page-id-16 .woocommerce-form-login .form-row { margin-bottom: 12px !important; }
    /* WC checkbox: flex + left-align */
    body.page-id-16 .woocommerce-form-login__rememberme {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-align: left !important;
        color: rgba(220,213,170,0.75) !important;
        font-size: 12px !important;
        font-weight: 400 !important;
        text-transform: none !important;
        letter-spacing: 0.02em !important;
        margin-bottom: 16px !important;
    }
    body.page-id-16 .woocommerce-form-login__rememberme input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        margin: 0 !important;
        flex-shrink: 0 !important;
        accent-color: #CCC593 !important;
    }
    body.page-id-16 .woocommerce-form-login__rememberme span {
        text-align: left !important;
    }
    body.page-id-16 .woocommerce-form-login__submit,
    body.page-id-16 .woocommerce-form-login .woocommerce-button {
        background: rgba(204,197,147,0.95) !important;
        color: #0a0a0a !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 14px 24px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        width: 100% !important;
        display: block !important;
        cursor: pointer !important;
    }
    body.page-id-16 .woocommerce-form-login a,
    body.page-id-16 .woocommerce-form-login .lost_password a {
        color: rgba(204,197,147,0.85) !important;
        font-size: 12px !important;
    }
    <?php endif; ?>

    </style>
    <?php
}
