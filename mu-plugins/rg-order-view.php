<?php
/**
 * Plugin Name: RG Order View Redesign
 * Description: Cleans up WooCommerce order detail page for the dark portal.
 *   CSS injection tied directly to woocommerce_view_order hook firing — no endpoint check.
 * Version: 1.2
 */

$GLOBALS['rg_on_order_view'] = false;

add_action( 'woocommerce_view_order', 'rg_order_view_setup', 1 );
function rg_order_view_setup( $order_id ) {
    $GLOBALS['rg_on_order_view'] = true;
    $GLOBALS['rg_current_order_id'] = $order_id;

    echo '<div class="rg-order-toolbar">';
    echo '<a href="' . esc_url( wc_get_account_endpoint_url( 'orders' ) ) . '" class="rg-btn-back">&#8592; Invoices</a>';
    echo '<button onclick="window.print()" class="rg-btn-pdf">&#8595; Download PDF</button>';
    echo '</div>';

    add_action( 'wp_footer', 'rg_order_view_css', 99999 );
    add_action( 'wp_footer', 'rg_order_view_js', 99999 );
}

function rg_order_view_js() {
    if ( empty( $GLOBALS['rg_on_order_view'] ) ) return;
    ?>
    <script>
    (function() {
        var cells = document.querySelectorAll('.woocommerce-table--order-details .product-name');
        cells.forEach(function(cell) {
            cell.innerHTML = cell.innerHTML.replace(/<br[^>]*>\s*Appointment Info\s*<br[^>]*>/gi, '<br>');
        });
    })();
    </script>
    <?php
}

function rg_order_view_css() {
    if ( empty( $GLOBALS['rg_on_order_view'] ) ) return;
    ?>
    <style id="rg-order-view-css">
    .woocommerce-MyAccount-navigation { display: none !important; }
    .woocommerce-MyAccount-content { width: 100% !important; float: none !important; padding: 0 !important; }
    .woocommerce-MyAccount-content > h2:not(.woocommerce-order-details__title) { display: none !important; }
    .woocommerce-MyAccount-content > form { display: none !important; }
    .woocommerce-order-notes { display: none !important; }
    .order-actions--heading { display: none !important; }
    tr:has(.order-actions--heading) { display: none !important; }
    .wcfm-support-action, .order-actions-button { display: none !important; }
    .rg-order-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 24px; padding-bottom: 16px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .rg-btn-back {
        color: rgba(255,255,255,0.5) !important; font-size: 11px; letter-spacing: 0.1em;
        text-transform: uppercase; text-decoration: none !important;
        border: 1px solid rgba(255,255,255,0.2); padding: 7px 16px; border-radius: 2px;
    }
    .rg-btn-back:hover { color: #fff !important; border-color: rgba(255,255,255,0.5); }
    .rg-btn-pdf {
        background: transparent; border: 1px solid #c9a96e; color: #c9a96e !important;
        font-size: 12px; letter-spacing: 0.1em; text-transform: uppercase;
        padding: 8px 22px; border-radius: 2px; cursor: pointer; font-family: inherit;
    }
    .rg-btn-pdf:hover { background: #c9a96e; color: #1a1a1a !important; }
    .woocommerce-order-overview, .woocommerce-thankyou-order-received,
    p.woocommerce-notice { color: rgba(255,255,255,0.5) !important; font-size: 13px !important; margin-bottom: 20px !important; }
    p.woocommerce-notice strong { color: #c9a96e !important; }
    p.woocommerce-notice a { color: #c9a96e !important; }
    .woocommerce-order-details__title {
        font-size: 10px !important; letter-spacing: 0.14em !important;
        text-transform: uppercase !important; color: rgba(201,169,110,0.6) !important;
        font-weight: 600 !important; margin: 24px 0 10px !important;
    }
    .woocommerce-table--order-details {
        font-size: 15px !important; border-collapse: collapse !important;
        width: 100% !important; background: transparent !important;
        border: 1px solid rgba(255,255,255,0.08) !important;
    }
    .woocommerce-table--order-details thead th {
        background: rgba(255,255,255,0.04) !important; color: #c9a96e !important;
        font-size: 10px !important; letter-spacing: 0.12em !important;
        text-transform: uppercase !important; padding: 10px 16px !important;
        border-bottom: 1px solid rgba(255,255,255,0.08) !important;
    }
    .woocommerce-table--order-details tbody td {
        color: rgba(255,255,255,0.85) !important; padding: 14px 16px !important;
        border-bottom: 1px solid rgba(255,255,255,0.05) !important;
        background: transparent !important; line-height: 1.6 !important;
        vertical-align: top; font-size: 15px !important;
    }
    .woocommerce-table--order-details tfoot td,
    .woocommerce-table--order-details tfoot th {
        border-top: 1px solid rgba(201,169,110,0.3) !important;
        color: #c9a96e !important; font-size: 15px !important;
        padding: 12px 16px !important; border-bottom: none !important;
        background: transparent !important;
    }
    .woocommerce-table--order-details .product-name,
    .woocommerce-table--order-details .product-name a {
        color: rgba(255,255,255,0.9) !important; text-decoration: none !important;
        font-size: 15px !important;
    }
    .wc-item-meta .wc-item-meta-label { display: none !important; }
    .woocommerce-table--order-details td strong {
        color: rgba(201,169,110,0.8) !important; font-size: 12px !important;
        font-weight: 600; letter-spacing: 0.04em; display: block; margin-top: 6px;
    }
    .woocommerce-table--order-details td br + br { display: none !important; }
    .woocommerce-table--order-details td p,
    .woocommerce-table--order-details .wc-item-meta p {
        color: rgba(255,255,255,0.6) !important; font-size: 13px !important;
        line-height: 1.5 !important; margin: 2px 0 !important;
    }
    .woocommerce-column__title {
        font-size: 10px !important; letter-spacing: 0.12em; text-transform: uppercase;
        color: rgba(201,169,110,0.6) !important; margin-bottom: 8px !important;
    }
    .woocommerce-customer-details address {
        color: rgba(255,255,255,0.6) !important; font-size: 13px !important;
        line-height: 1.6 !important; font-style: normal;
        border: none !important; padding: 0 !important;
    }
    .woocommerce-columns--addresses { margin-top: 24px !important; }
    @media print {
        .rg-portal-sidebar-v2, #rg-portal-sidebar, .rg-btn-back,
        nav, .colibri-header-row, .site-header, footer,
        .woocommerce-MyAccount-navigation { display: none !important; }
        body { background: #fff !important; color: #000 !important; padding: 20px !important; }
        .woocommerce-MyAccount-content { padding: 0 !important; width: 100% !important; }
        .rg-btn-pdf, .rg-order-toolbar { display: none !important; }
        .woocommerce-table--order-details th { background: #f0f0f0 !important; color: #333 !important; }
        .woocommerce-table--order-details td { color: #000 !important; border-color: #ddd !important; }
    }
    </style>
    <?php
}
