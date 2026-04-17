<?php
/**
 * Plugin Name: RG Pro Login Refinements
 * Description: Pro panel login (page-id-54778) text color + footer spacing.
 *   Separate file so concurrent mu-plugin rewrites can't wipe these rules.
 *   Selectors use #amelia-container to beat an earlier #content span:not()
 *   !important rule (specificity 121) in rg-amelia-contrast.php.
 * Author: RG
 * Version: 1.1
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', 'rg_pro_login_refinements', 99999 );
function rg_pro_login_refinements() {
    if ( ! is_page( 54778 ) ) return;
    ?>
    <style id="rg-pro-login-refinements">
    /* Heading + subtitle + labels + footer text → WHITE.
       Specificity 131 (11 body.class + 100 #amelia-container + 10+10 class chain)
       beats the 121 of `#content span:not(...)` that dims everything beige. */
    body.page-id-54778 #amelia-container .am-asi .am-asi__header,
    body.page-id-54778 #amelia-container .am-asi__form .am-ff__item-label,
    body.page-id-54778 #amelia-container .am-asi__footer .am-asi__footer-text,
    body.page-id-54778 #amelia-container .am-asi__footer .am-asi__footer-link,
    body.page-id-54778 #amelia-container .am-asi__footer span,
    body.page-id-54778 #amelia-container .am-asi__footer a {
        color: #FFFFFF !important;
        opacity: 1 !important;
    }
    /* Subtitle slightly dimmed for hierarchy */
    body.page-id-54778 #amelia-container .am-asi .am-asi__text {
        color: rgba(255,255,255,0.75) !important;
        opacity: 1 !important;
    }
    /* Footer row: pushed further down the card */
    body.page-id-54778 #amelia-container .am-asi__footer {
        margin-top: 48px !important;
        padding-top: 20px !important;
        border-top: 1px solid rgba(255,255,255,0.08) !important;
    }
    body.page-id-54778 #amelia-container .am-asi__footer-link {
        font-weight: 500 !important;
        cursor: pointer !important;
    }
    body.page-id-54778 #amelia-container .am-asi__footer-link:hover,
    body.page-id-54778 #amelia-container .am-asi__footer a:hover {
        color: #CCC593 !important;
    }
    /* Sign-In button inner span → DARK on the gold fill */
    body.page-id-54778 #amelia-container button .am-button__inner,
    body.page-id-54778 #amelia-container .am-button .am-button__inner {
        color: #1a1a1a !important;
    }
    </style>
    <?php
}
