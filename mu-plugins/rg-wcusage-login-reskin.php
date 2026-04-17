<?php
/**
 * Plugin Name: RG WCUsage Login Reskin
 * Description: Dark-luxury gold-standard reskin of the WCUsage MLA plugin
 *   login form (WooCommerce form-login rendered inside the affiliate
 *   dashboard shell). Matches /account/ + /booking-pro-panel/ treatment.
 *   Separate file for anti-regression.
 * Author: RG
 * Version: 1.1
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', 'rg_wcusage_login_reskin', 99999 );
function rg_wcusage_login_reskin() {
    ?>
    <style id="rg-wcusage-login-reskin">
    /* ── WCUsage MLA login: gold-standard dark-luxury reskin ──── */
    /* Structure:                                                  */
    /*   <p>You must be logged in…</p>        ← notice (outside)  */
    /*   <div.wcu-form-section>                                    */
    /*     <p.wcusage-login-form-title>Login:</p>  ← heading       */
    /*     <div.wcusage-login-form-section>                        */
    /*       <form.woocommerce-form-login>…</form>                 */

    /* "You must be logged in…" notice (sits above the card) */
    body.page-id-71558 .page-content p:has(+ br + br + .wcu-form-section),
    body .wcu-form-section > p:first-of-type + br + br,
    body .wcu-form-section {
        /* Empty rule kept as selector anchor */
    }

    /* The card wrapper that groups heading + form */
    body .wcu-form-section {
        background: rgba(20,20,20,0.92) !important;
        border: 1px solid rgba(204,197,147,0.18) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important;
        padding: 40px 36px !important;
        max-width: 460px !important;
        margin: 32px auto !important;
        color: #E6E0C8 !important;
        display: block !important;
    }

    /* "Login:" heading — Cormorant serif in white */
    body .wcu-form-section .wcusage-login-form-title,
    body .wcu-form-section > p:first-child {
        color: #FFFFFF !important;
        font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif !important;
        font-weight: 400 !important;
        font-size: 28px !important;
        line-height: 1.2 !important;
        letter-spacing: 0.02em !important;
        text-align: center !important;
        margin: 0 0 24px 0 !important;
        padding: 0 !important;
    }
    body .wcu-form-section .wcusage-login-form-title strong {
        font-weight: 400 !important;
        color: #FFFFFF !important;
    }

    /* Inner section is transparent — card border is on .wcu-form-section */
    body .wcusage-login-form-section {
        background: transparent !important;
        border: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        box-shadow: none !important;
    }

    /* Form rows — remove woocommerce's two-column flex */
    body .wcu-form-section .form-row,
    body .wcu-form-section .form-row-first,
    body .wcu-form-section .form-row-last {
        width: 100% !important;
        float: none !important;
        margin: 0 0 18px 0 !important;
        padding: 0 !important;
    }

    /* Field labels — uppercase small caps */
    body .wcu-form-section label,
    body .wcu-form-section .woocommerce-form__label {
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
    /* Required asterisk in red */
    body .wcu-form-section .required {
        color: #E06B5A !important;
        text-transform: none !important;
    }

    /* Text / password inputs — dark pill */
    body .wcu-form-section input[type="text"],
    body .wcu-form-section input[type="email"],
    body .wcu-form-section input[type="password"],
    body .wcu-form-section input.input-text,
    body .wcu-form-section input.woocommerce-Input {
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
        box-sizing: border-box !important;
        box-shadow: none !important;
        margin: 0 !important;
        transition: border-color .2s ease, box-shadow .2s ease !important;
    }
    body .wcu-form-section input[type="text"]:focus,
    body .wcu-form-section input[type="email"]:focus,
    body .wcu-form-section input[type="password"]:focus {
        outline: none !important;
        border-color: rgba(204,197,147,0.6) !important;
        box-shadow: 0 0 0 3px rgba(204,197,147,0.12) !important;
    }
    body .wcu-form-section input::placeholder {
        color: rgba(255,255,255,0.3) !important;
    }

    /* "Remember me" row — checkbox + label inline, left-aligned */
    body .wcu-form-section .woocommerce-form-login__rememberme {
        background: transparent !important;
        border: 0 !important;
        padding: 0 !important;
        width: auto !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin: 0 0 24px 0 !important;
        color: rgba(255,255,255,0.75) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 12px !important;
        text-transform: none !important;
        letter-spacing: 0.02em !important;
        font-weight: 400 !important;
        cursor: pointer !important;
    }
    body .wcu-form-section input[type="checkbox"] {
        width: 16px !important;
        height: 16px !important;
        margin: 0 !important;
        accent-color: #CCC593 !important;
        cursor: pointer !important;
    }

    /* Login submit button — champagne fill, UPPERCASE charbon */
    body .wcu-form-section button[type="submit"],
    body .wcu-form-section .woocommerce-form-login__submit,
    body .wcu-form-section .woocommerce-button,
    body .wcu-form-section button.button,
    body .wcu-form-section input[type="submit"] {
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
        cursor: pointer !important;
        transition: background-color .2s ease !important;
        margin: 0 0 20px 0 !important;
        padding: 0 !important;
        display: block !important;
    }
    body .wcu-form-section button[type="submit"]:hover,
    body .wcu-form-section .woocommerce-form-login__submit:hover,
    body .wcu-form-section .woocommerce-button:hover {
        background: #E8DFB5 !important;
        color: #0c0c0c !important;
    }

    /* "Lost your password?" link — centered, dimmed, hover gold */
    body .wcu-form-section .lost_password,
    body .wcu-form-section .lost_password a,
    body .wcu-form-section a[href*="lost"] {
        color: rgba(255,255,255,0.6) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 12px !important;
        font-weight: 400 !important;
        text-align: center !important;
        display: block !important;
        text-decoration: none !important;
        margin: 0 !important;
        letter-spacing: 0.02em !important;
    }
    body .wcu-form-section .lost_password a:hover,
    body .wcu-form-section a[href*="lost"]:hover {
        color: #CCC593 !important;
        text-decoration: underline !important;
    }

    /* Kill the extra <br/><br/> gap the plugin adds before the card */
    body.page-id-71558 .page-content br + br {
        display: none !important;
    }
    </style>
    <?php
}
