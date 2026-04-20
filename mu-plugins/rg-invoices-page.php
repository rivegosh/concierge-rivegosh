<?php
/**
 * Plugin Name: RG Invoices Page Styles
 * Description: Styles WooCommerce orders (Invoices) page for the dark portal.
 *              Hides internal WC nav, removes "Browse Products" CTA, custom empty state.
 * Version: 1.1
 */

// ── Replace WooCommerce empty-orders notice with a clean portal message ──
add_action( 'woocommerce_no_orders', 'rg_no_orders_override', 1 );
function rg_no_orders_override() {
    // Remove WooCommerce's default notice (which includes Browse Products link)
    remove_action( 'woocommerce_no_orders', 'woocommerce_no_orders', 10 );
    echo '<p class="rg-no-invoices">No invoices yet. Your payment history will appear here once a booking is confirmed.</p>';
}

// ── CSS: dark portal styling for orders page ─────────────────────────────
add_action( 'wp_footer', 'rg_invoices_page_css', 99999 );
function rg_invoices_page_css() {
    if ( ! function_exists('is_account_page') || ! is_account_page() ) return;
    ?>
    <style id="rg-invoices-css">

    /* ─── Hide WooCommerce internal My Account nav ─────────────────── */
    .woocommerce-MyAccount-navigation { display: none !important; }

    /* ─── Full-width content area ──────────────────────────────────── */
    .woocommerce-MyAccount-content {
        width: 100% !important;
        float: none !important;
        padding: 0 !important;
    }

    /* ─── Hide WC dashboard welcome text ───────────────────────────── */
    .woocommerce-account .woocommerce > .woocommerce-MyAccount-content > p:first-child {
        display: none !important;
    }

    /* ─── Hide "Browse Products" button in WC notices ──────────────── */
    .woocommerce-MyAccount-content .woocommerce-info .button,
    .woocommerce-MyAccount-content .woocommerce-message .button,
    .woocommerce-MyAccount-content .woocommerce-notice .button {
        display: none !important;
    }

    /* ─── Restyle WC info/message notices to match dark portal ─────── */
    .woocommerce-MyAccount-content .woocommerce-info,
    .woocommerce-MyAccount-content .woocommerce-message,
    .woocommerce-MyAccount-content .woocommerce-notice {
        background: rgba(255,255,255,0.04) !important;
        border-top: none !important;
        border-left: 2px solid rgba(201,169,110,0.4) !important;
        color: rgba(255,255,255,0.5) !important;
        font-size: 13px;
        letter-spacing: 0.04em;
        padding: 20px 24px !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }
    .woocommerce-MyAccount-content .woocommerce-info::before,
    .woocommerce-MyAccount-content .woocommerce-message::before {
        display: none !important;
    }

    /* ─── Custom empty state ───────────────────────────────────────── */
    .rg-no-invoices {
        color: rgba(255,255,255,0.35) !important;
        font-size: 13px !important;
        letter-spacing: 0.06em;
        text-align: center !important;
        padding: 56px 0 !important;
        margin: 0 !important;
        text-transform: uppercase;
    }

    /* ─── Orders table ─────────────────────────────────────────────── */
    .woocommerce-orders-table,
    .woocommerce table.shop_table {
        background: transparent !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-collapse: collapse !important;
        width: 100% !important;
        font-size: 13px;
        letter-spacing: 0.05em;
    }
    .woocommerce-orders-table th,
    .woocommerce table.shop_table th {
        background: rgba(255,255,255,0.04) !important;
        color: #c9a96e !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.1em;
        padding: 14px 16px !important;
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
    }
    .woocommerce-orders-table td,
    .woocommerce table.shop_table td {
        color: rgba(255,255,255,0.85) !important;
        padding: 14px 16px !important;
        border-bottom: 1px solid rgba(255,255,255,0.06) !important;
        background: transparent !important;
        vertical-align: middle;
    }
    .woocommerce-orders-table tr:last-child td { border-bottom: none !important; }

    /* ─── Status badges ────────────────────────────────────────────── */
    .woocommerce-orders-table .woocommerce-orders-table__cell-order-status mark {
        background: rgba(201,169,110,0.15) !important;
        color: #c9a96e !important;
        padding: 3px 10px;
        border-radius: 3px;
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* ─── View/Pay button ──────────────────────────────────────────── */
    .woocommerce-orders-table .button {
        background: transparent !important;
        border: 1px solid #c9a96e !important;
        color: #c9a96e !important;
        font-size: 11px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 6px 14px !important;
        border-radius: 2px;
        text-decoration: none !important;
        display: inline-block !important; /* override the hide-button rule above */
    }
    .woocommerce-orders-table .button:hover {
        background: #c9a96e !important;
        color: #1a1a1a !important;
    }

    </style>
    <?php
}
