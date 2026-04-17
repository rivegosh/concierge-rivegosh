<?php
/**
 * Plugin Name: RG WCUsage Register Reskin
 * Description: Dark-luxury gold-standard reskin of the WCUsage affiliate
 *   registration form on /affiliate-registration/ (page-id-63619).
 *   Builds on rg-wcusage-login-reskin.php (.wcu-form-section card is
 *   shared). Widens card, restyles register-only classes
 *   (.wcu-register-field-col-*, .wcu-reg-terms, #wcu-register-button)
 *   and overrides the plugin's inline #ddbc89 button fill.
 *   Separate file for anti-regression (concurrent-session wipe defense).
 * Author: RG
 * Version: 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', 'rg_wcusage_register_reskin', 99999 );
function rg_wcusage_register_reskin() {
    if ( ! is_page( 63619 ) ) return;
    ?>
    <style id="rg-wcusage-register-reskin">
    /* ── WCUsage affiliate register: gold-standard reskin ─────── */
    /* Card wrapper is already dark-gold from rg-wcusage-login-    */
    /* reskin (.wcu-form-section cross-page). Widen for 2-col form.*/
    body.page-id-63619 .wcu-form-section,
    body.page-id-63619 .wcu-form-section.wcu-form-section-pro {
        max-width: 640px !important;
        padding: 44px 40px !important;
    }

    /* "Register New Affiliate Account:" heading — serif white */
    body.page-id-63619 .wcu-form-section .wcusage-register-form-title,
    body.page-id-63619 .wcu-form-section > p.wcusage-register-form-title {
        color: #FFFFFF !important;
        font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif !important;
        font-weight: 400 !important;
        font-size: 28px !important;
        line-height: 1.2 !important;
        letter-spacing: 0.02em !important;
        text-align: center !important;
        margin: 0 0 28px 0 !important;
        padding: 0 !important;
    }
    body.page-id-63619 .wcu-form-section .wcusage-register-form-title strong {
        font-weight: 400 !important;
        color: #FFFFFF !important;
    }

    /* Form columns: kill the plugin's float/inline-block layout,   */
    /* use flex two-column on ≥560px so First/Last name sit side by */
    /* side, stack on narrow viewports.                             */
    body.page-id-63619 #wcu_form_affiliate_register {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 16px 18px !important;
        width: 100% !important;
    }
    body.page-id-63619 #wcu_form_affiliate_register > p,
    body.page-id-63619 #wcu_form_affiliate_register > div {
        float: none !important;
        clear: none !important;
        margin: 0 !important;
        padding: 0 !important;
        box-sizing: border-box !important;
    }
    /* Full-width rows */
    body.page-id-63619 .wcu-register-field-col,
    body.page-id-63619 .wcu-register-field-col-email,
    body.page-id-63619 .wcu-register-field-col-password,
    body.page-id-63619 .wcu-register-field-col-password-confirm,
    body.page-id-63619 .wcu-register-field-col-1,
    body.page-id-63619 .wcu-register-field-col-2 {
        flex: 1 1 100% !important;
        min-width: 0 !important;
    }
    /* Two-col: first/last name + password pair on ≥560px */
    @media (min-width: 560px) {
        body.page-id-63619 .wcu-register-field-col-1,
        body.page-id-63619 .wcu-register-field-col-2 {
            flex: 1 1 calc(50% - 10px) !important;
        }
    }

    /* Labels — uppercase small caps champagne */
    body.page-id-63619 .wcu-form-section label,
    body.page-id-63619 #wcu_form_affiliate_register label {
        color: rgba(230,224,200,0.85) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        line-height: 1.4 !important;
        display: block !important;
        margin: 0 0 8px 0 !important;
    }

    /* Inputs — dark pill 50px */
    body.page-id-63619 .wcu-form-section input[type="text"],
    body.page-id-63619 .wcu-form-section input[type="email"],
    body.page-id-63619 .wcu-form-section input[type="password"],
    body.page-id-63619 .wcu-form-section input[type="tel"],
    body.page-id-63619 .wcu-form-section input[type="url"],
    body.page-id-63619 .wcu-form-section input.input-text,
    body.page-id-63619 .wcu-form-section input.form-control,
    body.page-id-63619 #wcu_form_affiliate_register input[type="text"],
    body.page-id-63619 #wcu_form_affiliate_register input[type="email"],
    body.page-id-63619 #wcu_form_affiliate_register input[type="password"] {
        background: rgba(255,255,255,0.04) !important;
        border: 1px solid rgba(230,224,200,0.15) !important;
        border-radius: 8px !important;
        color: #FFFFFF !important;
        height: 50px !important;
        line-height: 50px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 15px !important;
        padding: 0 16px !important;
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        box-shadow: none !important;
        margin: 0 !important;
        display: block !important;
        transition: border-color .2s ease, box-shadow .2s ease !important;
    }
    body.page-id-63619 .wcu-form-section input:focus {
        outline: none !important;
        border-color: rgba(204,197,147,0.6) !important;
        box-shadow: 0 0 0 3px rgba(204,197,147,0.12) !important;
    }
    body.page-id-63619 .wcu-form-section input::placeholder {
        color: rgba(255,255,255,0.3) !important;
    }

    /* ── Terms row: checkbox left, small text right, inline flex ── */
    body.page-id-63619 .wcu-reg-terms {
        display: flex !important;
        align-items: flex-start !important;
        flex: 1 1 100% !important;
        gap: 10px !important;
        margin: 4px 0 18px 0 !important;
        padding: 0 !important;
    }
    body.page-id-63619 .wcu-reg-terms > span:first-child {
        flex: 0 0 auto !important;
        margin: 2px 0 0 0 !important;
        padding: 0 !important;
    }
    body.page-id-63619 .wcu-reg-terms > span:last-child {
        flex: 1 1 auto !important;
        color: rgba(255,255,255,0.75) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 12px !important;
        font-weight: 400 !important;
        letter-spacing: 0.02em !important;
        line-height: 1.5 !important;
    }
    body.page-id-63619 .wcu-reg-terms > span:last-child p {
        margin: 0 !important;
        padding: 0 !important;
        color: inherit !important;
        font-size: inherit !important;
        line-height: inherit !important;
    }
    body.page-id-63619 .wcu-reg-terms a {
        color: #CCC593 !important;
        text-decoration: underline !important;
    }
    body.page-id-63619 .wcu-reg-terms a:hover {
        color: #E8DFB5 !important;
    }
    body.page-id-63619 .wcu-reg-terms input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        margin: 0 !important;
        padding: 0 !important;
        accent-color: #CCC593 !important;
        cursor: pointer !important;
        vertical-align: top !important;
    }

    /* ── Captcha: center on its own row ─────────────────────── */
    body.page-id-63619 .captcha_wrapper {
        flex: 1 1 100% !important;
        display: flex !important;
        justify-content: center !important;
        margin: 8px 0 !important;
    }

    /* ── Submit Application: gold pill charbon text ────────── */
    /* Specificity 101 (body + id) beats plugin's 100 !important */
    body.page-id-63619 .wcu-register-form-button {
        flex: 1 1 100% !important;
        margin: 8px 0 0 0 !important;
        padding: 0 !important;
        text-align: center !important;
    }
    body.page-id-63619 #wcu-register-button {
        background: #CCC593 !important;
        background-color: #CCC593 !important;
        color: #1a1a1a !important;
        border: 0 !important;
        border-radius: 8px !important;
        height: 52px !important;
        width: 100% !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        letter-spacing: 0.14em !important;
        text-transform: uppercase !important;
        text-shadow: none !important;
        cursor: pointer !important;
        transition: background-color .2s ease !important;
        margin: 0 !important;
        padding: 0 !important;
        display: block !important;
        box-shadow: none !important;
    }
    body.page-id-63619 #wcu-register-button:hover {
        background: #E8DFB5 !important;
        background-color: #E8DFB5 !important;
        color: #0c0c0c !important;
    }

    /* Honeypot + spinner stay hidden as plugin intended */
    body.page-id-63619 #wcu_form_affiliate_register > div[style*="display: none"] {
        display: none !important;
    }
    body.page-id-63619 .register-spinner {
        color: #CCC593 !important;
    }

    /* Kill stray clearfix DIVs that break flex layout */
    body.page-id-63619 #wcu_form_affiliate_register > div[style*="clear"] {
        display: none !important;
    }
    </style>
    <?php
}
