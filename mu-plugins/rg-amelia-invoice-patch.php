<?php
/**
 * Rive Gosh — Amelia Invoice Fixes (v2.0)
 *
 * FIX 1 (CRITICAL): AMELIA_UPLOADS_URL http/https mismatch.
 * Hostinger terminates SSL at LiteSpeed — PHP sees HTTP. Amelia uses
 * set_url_scheme() which returns http://. But company.pictureFullPath
 * is stored as https://. str_replace fails silently → no logo in PDF.
 * Pre-defining AMELIA_UPLOADS_URL with https:// fixes the path lookup.
 *
 * FIX 2: Invoice template logo sizing (50x50 square → 120x42 proportional).
 * Amelia hardcodes width:50px height:50px on the invoice logo.
 * Auto-patches invoice.inc after any Amelia update.
 */

// FIX 1: Force AMELIA_UPLOADS_URL to use https
// Must fire before Amelia plugin loads (mu-plugins load first)
add_action("muplugins_loaded", "rg_fix_amelia_uploads_url", 1);
function rg_fix_amelia_uploads_url() {
    if (!defined("AMELIA_UPLOADS_URL")) {
        $upload_dir = wp_upload_dir(null, false);
        if (!empty($upload_dir["baseurl"])) {
            $url = set_url_scheme($upload_dir["baseurl"], "https");
            define("AMELIA_UPLOADS_URL", $url);
        }
    }
}

// FIX 2: Auto-patch invoice.inc logo sizing
add_action("init", "rg_amelia_invoice_patch_apply", 1);
add_action("upgrader_process_complete", "rg_amelia_invoice_patch_on_upgrade", 10, 2);

function rg_amelia_invoice_patch_on_upgrade($upgrader, $hook_extra) {
    $plugins = isset($hook_extra["plugins"]) ? $hook_extra["plugins"] : array();
    if (in_array("ameliabooking/ameliabooking.php", $plugins, true)) {
        rg_amelia_invoice_patch_apply();
    }
}

function rg_amelia_invoice_patch_apply() {
    $template = WP_PLUGIN_DIR . "/ameliabooking/templates/invoice/invoice.inc";
    if (!file_exists($template) || !is_writable($template)) { return; }
    $content = file_get_contents($template);
    if (strpos($content, "width: 130px") !== false) { return; }

    $patches = array(
        array(
            "      .invoice-header .invoice-header-first-line table {\n          float: right;\n      }",
            "      .invoice-header .invoice-header-first-line table {\n          float: right;\n          width: 130px;\n          overflow: visible;\n      }"
        ),
        array(
            "      .invoice-header .invoice-header-first-line table tr td:first-child {\n          vertical-align: middle;\n          padding-right: 16px\n      }",
            "      .invoice-header .invoice-header-first-line table tr td:first-child {\n          vertical-align: middle;\n          padding-right: 0;\n          width: 130px;\n          overflow: visible;\n      }"
        ),
        array(
            "      .invoice-header .invoice-header-first-line img {\n          width: 50px;\n          height: 50px;\n      }",
            "      .invoice-header .invoice-header-first-line img {\n          width: 120px;\n          height: 42px;\n          display: block;\n      }"
        ),
    );

    foreach ($patches as $pair) {
        if (strpos($content, $pair[0]) !== false) {
            $content = str_replace($pair[0], $pair[1], $content);
        }
    }
    file_put_contents($template, $content);
}
