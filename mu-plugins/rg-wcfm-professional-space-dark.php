<?php
/**
 * Plugin Name: RG WCFM Professional Space Dark
 * Description: Dark-luxury skin for the WCFM vendor dashboard ("Professional
 *              Space") at /professional-space/* (page-id-20). Stock WCFM
 *              ships a light-grey main content area + cyan "active" sidebar
 *              highlight + near-white DataTables — catastrophically off-brand
 *              against the rest of the dark-luxury site. Scanner on
 *              /professional-space/orderslist/ confirmed 23 contrast
 *              violations (Orders/Purchased/Date/Actions table headers
 *              champagne-on-white at 1.59 ratio, "No data in the table"
 *              at 1.09 ratio, filter tabs at 1.60).
 * Author: RG
 * Version: 1.0.0
 * Created: 2026-04-22
 *
 * WHY THIS FILE EXISTS:
 *   Daniel on 2026-04-22: "we also have this problem when I get the email
 *   and it comes back to my account, my store vendor account, my store.
 *   Another problem with contrast."
 *   Scope: body.page-id-20. Zero bleed to other pages.
 *
 * GitHub: rivegosh/concierge-rivegosh
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', function () {
	// Only fire on page-id-20 (and its /professional-space/* subroutes).
	global $post;
	$page_id = 0;
	if ( is_object( $post ) && isset( $post->ID ) ) $page_id = (int) $post->ID;
	if ( $page_id !== 20 ) {
		// Also handle WCFM's virtual endpoints that may not have $post set yet.
		if ( strpos( $_SERVER['REQUEST_URI'] ?? '', '/professional-space' ) === false ) return;
	}
	?>
	<style id="rg-wcfm-professional-space-dark">

	/* ==================================================================
	 * 1. MAIN CONTENT CONTAINER — dark bg, champagne text
	 * ================================================================== */
	html body.page-id-20 #wcfm-main-contentainer,
	html body.page-id-20 .wcfm-main-contentainer,
	html body.page-id-20 #wcfm_content_wrapper,
	html body.page-id-20 .wcfm-container,
	html body.page-id-20 .wcfm-content,
	html body.page-id-20 .wcfm-collapse-content,
	html body.page-id-20 .collapse.wcfm-collapse,
	html body.page-id-20 .wcfm-page-wrap {
		background: rgba(20, 16, 10, 0.85) !important;
		background-color: rgba(20, 16, 10, 0.85) !important;
		color: rgba(230, 225, 195, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		border-radius: 4px !important;
	}

	/* ==================================================================
	 * 2. SIDEBAR — dark with champagne active state (kill cyan #17A2B8)
	 * ================================================================== */
	html body.page-id-20 #wcfm_menu,
	html body.page-id-20 .wcfm-side-menu,
	html body.page-id-20 .wcfm-collapse-menu,
	html body.page-id-20 .wcfm-sidebar {
		background: rgba(12, 10, 6, 0.95) !important;
		background-color: rgba(12, 10, 6, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}
	html body.page-id-20 #wcfm_menu a,
	html body.page-id-20 #wcfm_menu .wcfm_menu_item,
	html body.page-id-20 .wcfm-side-menu a,
	html body.page-id-20 .wcfm-side-menu .wcfm_menu_item {
		color: rgba(230, 225, 195, 0.85) !important;
		background: transparent !important;
		background-color: transparent !important;
	}
	html body.page-id-20 #wcfm_menu a.active,
	html body.page-id-20 #wcfm_menu .wcfm_menu_item.active,
	html body.page-id-20 .wcfm_menu_item.active,
	html body.page-id-20 a.wcfm_menu_item.active,
	html body.page-id-20 #wcfm_menu a.active *,
	html body.page-id-20 .wcfm_menu_item.active *,
	html body.page-id-20 a.wcfm_menu_item.active * {
		background: rgba(204, 197, 147, 0.92) !important;
		background-color: rgba(204, 197, 147, 0.92) !important;
		color: #0a0a0a !important;
	}
	/* Icons inside active menu item too */
	html body.page-id-20 #wcfm_menu a.active i,
	html body.page-id-20 #wcfm_menu a.active svg,
	html body.page-id-20 #wcfm_menu .wcfm_menu_item.active i,
	html body.page-id-20 #wcfm_menu .wcfm_menu_item.active svg {
		color: #0a0a0a !important;
		fill: #0a0a0a !important;
	}
	html body.page-id-20 #wcfm_menu a:hover,
	html body.page-id-20 .wcfm_menu_item:hover {
		background: rgba(204, 197, 147, 0.08) !important;
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * 3. PAGE HEADER BAR ("Orders", cart/bell/help icons)
	 * ================================================================== */
	html body.page-id-20 .wcfm-page-head,
	html body.page-id-20 .wcfm-content-head,
	html body.page-id-20 .wcfm_page_heading {
		background: rgba(12, 10, 6, 0.95) !important;
		color: #CCC593 !important;
		border-bottom: 1px solid rgba(204, 197, 147, 0.18) !important;
	}
	html body.page-id-20 .wcfm-page-head h1,
	html body.page-id-20 .wcfm-page-head h2,
	html body.page-id-20 .wcfm_page_heading h1,
	html body.page-id-20 .wcfm_page_heading h2 {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * 4. FILTER TABS (All | Pending | Processing | On hold | Completed …)
	 * ================================================================== */
	html body.page-id-20 .wcfm-filter-tabs,
	html body.page-id-20 .wcfm-report-filter,
	html body.page-id-20 .subsubsub {
		background: transparent !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}
	html body.page-id-20 .subsubsub a,
	html body.page-id-20 .wcfm-filter-tabs a {
		color: rgba(204, 197, 147, 0.85) !important;
		background: transparent !important;
	}
	html body.page-id-20 .subsubsub a.current,
	html body.page-id-20 .subsubsub a.active,
	html body.page-id-20 .wcfm-filter-tabs a.active {
		color: #CCC593 !important;
		font-weight: 600 !important;
	}

	/* ==================================================================
	 * 5. DATATABLES — table bg dark, headers champagne, rows champagne text
	 * ================================================================== */
	html body.page-id-20 .dataTables_wrapper,
	html body.page-id-20 .dataTables_length,
	html body.page-id-20 .dataTables_filter,
	html body.page-id-20 .dataTables_info,
	html body.page-id-20 .dataTables_paginate {
		background: transparent !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}
	html body.page-id-20 table.dataTable,
	html body.page-id-20 table.display,
	html body.page-id-20 table.wcfm-table {
		background: rgba(12, 10, 6, 0.85) !important;
		background-color: rgba(12, 10, 6, 0.85) !important;
		color: rgba(230, 225, 195, 0.95) !important;
		border: 1px solid rgba(204, 197, 147, 0.18) !important;
	}
	html body.page-id-20 table.dataTable thead,
	html body.page-id-20 table.dataTable thead th,
	html body.page-id-20 table.dataTable tfoot,
	html body.page-id-20 table.dataTable tfoot th {
		background: rgba(20, 16, 10, 0.95) !important;
		background-color: rgba(20, 16, 10, 0.95) !important;
		color: #CCC593 !important;
		border-color: rgba(204, 197, 147, 0.20) !important;
	}
	html body.page-id-20 table.dataTable tbody tr {
		background: transparent !important;
		color: rgba(230, 225, 195, 0.95) !important;
	}
	html body.page-id-20 table.dataTable tbody tr:hover,
	html body.page-id-20 table.dataTable tbody tr:nth-child(even) {
		background: rgba(204, 197, 147, 0.04) !important;
	}
	html body.page-id-20 table.dataTable td,
	html body.page-id-20 table.dataTable th {
		border-color: rgba(204, 197, 147, 0.12) !important;
	}
	html body.page-id-20 .dataTables_empty {
		color: rgba(204, 197, 147, 0.70) !important;
		background: transparent !important;
	}

	/* ==================================================================
	 * 6. EXPORT BUTTONS (PRINT / PDF / EXCEL / CSV) — champagne chips
	 * ================================================================== */
	html body.page-id-20 .dt-buttons .dt-button,
	html body.page-id-20 .dt-buttons button,
	html body.page-id-20 .wcfm-action-btn,
	html body.page-id-20 button.wcfm_submit_button,
	html body.page-id-20 a.wcfm_submit_button,
	html body.page-id-20 .wcfm-button {
		background: rgba(204, 197, 147, 0.92) !important;
		background-color: rgba(204, 197, 147, 0.92) !important;
		color: #0a0a0a !important;
		border: 0 !important;
		padding: 8px 16px !important;
		border-radius: 3px !important;
		font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif !important;
		font-weight: 600 !important;
		letter-spacing: 0.08em !important;
		text-transform: uppercase !important;
		font-size: 12px !important;
		text-shadow: none !important;
	}
	html body.page-id-20 .dt-buttons .dt-button:hover {
		background: #CCC593 !important;
	}

	/* ==================================================================
	 * 7. INPUT + SELECT + DATE RANGE — white bg + black text
	 * ================================================================== */
	html body.page-id-20 input[type="text"],
	html body.page-id-20 input[type="email"],
	html body.page-id-20 input[type="tel"],
	html body.page-id-20 input[type="number"],
	html body.page-id-20 input[type="search"],
	html body.page-id-20 input[type="date"],
	html body.page-id-20 select,
	html body.page-id-20 textarea,
	html body.page-id-20 .dataTables_filter input,
	html body.page-id-20 .wcfm-date-range-picker {
		background: #ffffff !important;
		color: #0a0a0a !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		border-radius: 3px !important;
		padding: 8px 10px !important;
	}
	html body.page-id-20 input::placeholder {
		color: rgba(10, 10, 10, 0.45) !important;
	}

	/* Select2 fields (Filter by product, Show all) */
	html body.page-id-20 .select2-container--default .select2-selection--single,
	html body.page-id-20 .select2-container--default .select2-selection--multiple {
		background: #ffffff !important;
		border: 1px solid rgba(204, 197, 147, 0.55) !important;
		color: #0a0a0a !important;
		min-height: 36px !important;
	}
	html body.page-id-20 .select2-container--default .select2-selection__rendered {
		color: #0a0a0a !important;
		line-height: 34px !important;
	}

	/* ==================================================================
	 * 8. PAGINATION + INFO + SEARCH LABEL
	 *    Force their containers transparent so the dark page bg shows
	 *    through and champagne text is readable.
	 * ================================================================== */
	/* Force all DataTables wrappers transparent — catches any parent
	   with a stock light bg that's still showing through. */
	html body.page-id-20 .dataTables_wrapper,
	html body.page-id-20 .dataTables_wrapper > div,
	html body.page-id-20 .dataTables_wrapper > .row,
	html body.page-id-20 .dataTables_wrapper .row > div,
	html body.page-id-20 .dataTables_info,
	html body.page-id-20 .dataTables_paginate,
	html body.page-id-20 .dataTables_filter,
	html body.page-id-20 .dataTables_length {
		background: transparent !important;
		background-color: transparent !important;
	}
	html body.page-id-20 .dataTables_info,
	html body.page-id-20 .dataTables_paginate a,
	html body.page-id-20 .dataTables_filter,
	html body.page-id-20 .dataTables_filter label,
	html body.page-id-20 .dataTables_length,
	html body.page-id-20 .dataTables_length label {
		color: rgba(230, 225, 195, 0.95) !important;
	}

	/* Select2 placeholder "Filter by product ..." */
	html body.page-id-20 .select2-container--default .select2-selection__placeholder,
	html body.page-id-20 .select2-selection__placeholder {
		color: rgba(10, 10, 10, 0.65) !important;
	}
	html body.page-id-20 .dataTables_paginate .paginate_button {
		color: rgba(204, 197, 147, 0.85) !important;
		background: transparent !important;
		border: 1px solid rgba(204, 197, 147, 0.30) !important;
	}
	html body.page-id-20 .dataTables_paginate .paginate_button.current {
		color: #0a0a0a !important;
		background: rgba(204, 197, 147, 0.92) !important;
		border-color: rgba(204, 197, 147, 0.92) !important;
	}

	/* ==================================================================
	 * 9. LINKS inside dashboard (sidebar logo, help text, etc.)
	 * ================================================================== */
	html body.page-id-20 #wcfm-main-contentainer a:not(.dt-button):not(.wcfm-button):not(.wcfm_menu_item):not(.paginate_button) {
		color: #CCC593 !important;
	}
	html body.page-id-20 #wcfm-main-contentainer a:hover {
		color: #E5D599 !important;
	}

	/* ==================================================================
	 * 10. Notification bell + help icons (sidebar top-right circles)
	 * ================================================================== */
	html body.page-id-20 .wcfm-notification-badge,
	html body.page-id-20 .wcfm_notification {
		background: rgba(204, 197, 147, 0.20) !important;
		color: #CCC593 !important;
	}

	</style>
	<?php
}, 100013 );
