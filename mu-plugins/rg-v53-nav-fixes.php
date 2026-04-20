<?php
/**
 * rg-v53-nav-fixes.php
 * Fix 1: WCFM non-vendor redirect → vendor-membership (not WooCommerce account)
 * Fix 2: Remove dead "recent orders" link from WooCommerce My Account welcome text
 */

// Fix 1: Redirect non-vendors hitting /professional-space/ to vendor-membership page
add_filter( 'wcfm_restrict_redirect_url', 'rg_wcfm_non_vendor_redirect' );
function rg_wcfm_non_vendor_redirect( $url ) {
    return home_url( '/vendor-membership/' );
}

// Fix 2: Override WooCommerce My Account default welcome message (has dead orders link)
add_filter( 'woocommerce_account_content', 'rg_remove_dead_orders_welcome', 5 );
function rg_remove_dead_orders_welcome( $content ) {
    // The default text includes "view your recent orders" with a dead link — strip it
    $content = preg_replace(
        '/<p class="woocommerce-notice woocommerce-notice--info woocommerce-info">.*?<\/p>/si',
        '',
        $content
    );
    return $content;
}
