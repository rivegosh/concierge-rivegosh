<?php
/**
 * Rive Gosh — Anti-Regression Health Check (v1.0)
 *
 * Adds a WP-CLI command: wp rg-health
 * Verifies all custom patches, settings, and mu-plugin state.
 * Run after ANY plugin update, theme change, or Hostinger maintenance.
 *
 * Usage: wp rg-health (via SSH)
 */

if (!defined('WP_CLI') || !WP_CLI) return;

WP_CLI::add_command('rg-health', function() {
    $pass = 0;
    $fail = 0;
    $warn = 0;

    $checks = [];

    // 1. AMELIA_UPLOADS_URL must be https
    $url = defined('AMELIA_UPLOADS_URL') ? AMELIA_UPLOADS_URL : '';
    if (strpos($url, 'https://') === 0) {
        $checks[] = ['PASS', 'AMELIA_UPLOADS_URL uses https'];
        $pass++;
    } else {
        $checks[] = ['FAIL', "AMELIA_UPLOADS_URL = '$url' (expected https://)"];
        $fail++;
    }

    // 2. Amelia pictureThumbPath = pictureFullPath (not the cropped thumbnail)
    $s = json_decode(get_option('amelia_settings'), true);
    $full = $s['company']['pictureFullPath'] ?? '';
    $thumb = $s['company']['pictureThumbPath'] ?? '';
    if ($full && $full === $thumb) {
        $checks[] = ['PASS', 'Amelia pictureThumbPath = pictureFullPath (full logo)'];
        $pass++;
    } else {
        $checks[] = ['FAIL', "pictureThumbPath mismatch: '$thumb' vs '$full'"];
        $fail++;
    }

    // 3. Invoice template has our CSS patches
    $tpl = WP_PLUGIN_DIR . '/ameliabooking/templates/invoice/invoice.inc';
    if (file_exists($tpl) && strpos(file_get_contents($tpl), 'width: 130px') !== false) {
        $checks[] = ['PASS', 'invoice.inc CSS patches applied'];
        $pass++;
    } else {
        $checks[] = ['FAIL', 'invoice.inc CSS patches MISSING — run: wp eval "rg_amelia_invoice_patch_apply();"'];
        $fail++;
    }

    // 4. No debug code in invoice files
    $svc = WP_PLUGIN_DIR . '/ameliabooking/src/Application/Services/Invoice/InvoiceApplicationService.php';
    if (file_exists($svc) && strpos(file_get_contents($svc), 'rg_invoice_debug') === false) {
        $checks[] = ['PASS', 'InvoiceApplicationService.php clean (no debug code)'];
        $pass++;
    } else {
        $checks[] = ['WARN', 'Debug code found in InvoiceApplicationService.php'];
        $warn++;
    }

    if (file_exists($tpl) && strpos(file_get_contents($tpl), 'rg_dbg') === false) {
        $checks[] = ['PASS', 'invoice.inc clean (no debug code)'];
        $pass++;
    } else {
        $checks[] = ['WARN', 'Debug code found in invoice.inc'];
        $warn++;
    }

    // 5. MU-plugins exist
    $mu_files = [
        'rg-amelia-contrast.php'      => 'Amelia contrast/reskin CSS',
        'rg-amelia-invoice-btn.php'    => 'Invoice button badge',
        'rg-amelia-invoice-patch.php'  => 'Invoice HTTPS + CSS patch',
        'rg-drawer-override.php'       => 'Mobile drawer (LOCKED)',
        'rg-v52-card-icons.php'        => 'Card icons + nav lock (DO NOT DELETE)',
    ];
    foreach ($mu_files as $file => $desc) {
        $path = WPMU_PLUGIN_DIR . '/' . $file;
        if (file_exists($path)) {
            $checks[] = ['PASS', "$file exists ($desc)"];
            $pass++;
        } else {
            $checks[] = ['FAIL', "$file MISSING ($desc)"];
            $fail++;
        }
    }

    // 6. VIP Client menu item
    $title = get_the_title(63536);
    if ($title === 'VIP Client') {
        $checks[] = ['PASS', 'Menu item 63536 = "VIP Client"'];
        $pass++;
    } else {
        $checks[] = ['WARN', "Menu item 63536 = '$title' (expected 'VIP Client')"];
        $warn++;
    }

    // 7. VIP Client links to Reservations
    $obj_id = get_post_meta(63536, '_menu_item_object_id', true);
    if ($obj_id == 54773) {
        $checks[] = ['PASS', 'VIP Client → Reservations page (54773)'];
        $pass++;
    } else {
        $checks[] = ['WARN', "VIP Client → page $obj_id (expected 54773)"];
        $warn++;
    }

    // 8. Invoices menu item is draft (hidden)
    $inv_status = get_post_status(73420);
    if ($inv_status === 'draft') {
        $checks[] = ['PASS', 'Invoices menu item (73420) is draft/hidden'];
        $pass++;
    } else {
        $checks[] = ['WARN', "Invoices menu item (73420) status = '$inv_status' (expected 'draft')"];
        $warn++;
    }

    // 9. functions.php line count baseline
    $fphp = get_stylesheet_directory() . '/functions.php';
    $lines = file_exists($fphp) ? count(file($fphp)) : 0;
    if ($lines > 0 && $lines <= 3000) {
        $checks[] = ['PASS', "functions.php = $lines lines (baseline: 2645)"];
        $pass++;
    } elseif ($lines > 3000) {
        $checks[] = ['WARN', "functions.php = $lines lines (grown past 3000 — migrate to mu-plugins)"];
        $warn++;
    } else {
        $checks[] = ['FAIL', 'functions.php not found or empty'];
        $fail++;
    }

    // 10. No .bak files in mu-plugins
    $baks = glob(WPMU_PLUGIN_DIR . '/*.bak*');
    if (empty($baks)) {
        $checks[] = ['PASS', 'No .bak files in mu-plugins'];
        $pass++;
    } else {
        $checks[] = ['WARN', count($baks) . ' .bak file(s) in mu-plugins — clean up'];
        $warn++;
    }

    // 11. Amelia invoices feature enabled
    $inv_enabled = $s['featuresIntegrations']['invoices']['enabled'] ?? false;
    if ($inv_enabled) {
        $checks[] = ['PASS', 'Amelia invoices feature enabled'];
        $pass++;
    } else {
        $checks[] = ['FAIL', 'Amelia invoices feature DISABLED'];
        $fail++;
    }

    // Output
    WP_CLI::log('');
    WP_CLI::log('═══ RIVE GOSH HEALTH CHECK ═══════════════════════');
    foreach ($checks as $c) {
        $icon = $c[0] === 'PASS' ? '✅' : ($c[0] === 'FAIL' ? '❌' : '⚠️');
        WP_CLI::log("  $icon {$c[1]}");
    }
    WP_CLI::log('');
    WP_CLI::log("  Results: $pass PASS | $warn WARN | $fail FAIL");
    WP_CLI::log('═══════════════════════════════════════════════════');

    if ($fail > 0) {
        WP_CLI::error("$fail check(s) FAILED — action required!");
    } elseif ($warn > 0) {
        WP_CLI::warning("$warn warning(s) — review recommended.");
    } else {
        WP_CLI::success("All checks passed.");
    }
});
