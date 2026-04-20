<?php
/**
 * Plugin Name: RG Amelia Contrast Fix
 * Description: Overrides Amelia customer panel dark-navy text and white popups
 *              to match the site's dark luxury portal theme. Late-CSS pattern per KB #49.
 * Version: 4.1 — reschedule dialog: correct am-csd selectors + wider + contrast
 */

add_action( 'wp_footer', 'rg_amelia_contrast_css', 99999 );
function rg_amelia_contrast_css() {
    if ( ! is_page() ) return;
    ?>
    <style id="rg-amelia-contrast">

    /* ─── Date header (e.g. "April 22, 2026") ─────────────────────── */
    .amelia-v2-booking .am-capa__date {
        color: rgba(201, 169, 110, 0.8) !important;
        font-size: 11px !important;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    /* ─── Appointment card: time + service name ────────────────────── */
    .amelia-v2-booking .am-cc__time,
    .amelia-v2-booking .am-cc__name {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* ─── Appointment card: background ────────────────────────────── */
    .amelia-v2-booking .am-cc,
    .amelia-v2-booking [class*="am-cc__wrapper"],
    .amelia-v2-booking [class*="am-capa__item"] {
        background: rgba(255, 255, 255, 0.04) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* ─── ACTION BUTTONS: cancel, reschedule, expand, dots menu ─── */

    /* All SVG icons in appointment cards */
    .amelia-v2-booking .am-cc svg,
    .amelia-v2-booking [class*="am-cc"] svg,
    .amelia-v2-booking [class*="am-capa__item"] svg,
    .amelia-v2-booking .am-icon-arrow-down svg,
    .amelia-v2-booking .am-icon-arrow-right svg {
        fill: rgba(201, 169, 110, 0.7) !important;
        stroke: rgba(201, 169, 110, 0.7) !important;
        color: rgba(201, 169, 110, 0.7) !important;
    }
    .amelia-v2-booking .am-cc svg:hover,
    .amelia-v2-booking [class*="am-cc"] svg:hover {
        fill: #c9a96e !important;
        stroke: #c9a96e !important;
    }

    /* Icon wrapper elements (three dots, chevrons, action buttons) */
    .amelia-v2-booking [class*="am-cc__dots"],
    .amelia-v2-booking [class*="am-cc__arrow"],
    .amelia-v2-booking [class*="am-cc__action"],
    .amelia-v2-booking [class*="actions"],
    .amelia-v2-booking [class*="collapse"],
    .amelia-v2-booking [class*="chevron"],
    .amelia-v2-booking [class*="toggle"] {
        color: rgba(201, 169, 110, 0.7) !important;
        opacity: 1 !important;
        visibility: visible !important;
    }

    /* Generic: any Amelia icon element */
    .amelia-v2-booking [class*="am-icon"] {
        color: rgba(201, 169, 110, 0.7) !important;
    }
    .amelia-v2-booking [class*="am-icon"]:hover {
        color: #c9a96e !important;
    }

    /* ─── EXPANDED CARD: cancel/reschedule action buttons ───────── */
    .amelia-v2-booking .am-cc__cancel,
    .amelia-v2-booking .am-cc__reschedule,
    .amelia-v2-booking [class*="cancel"],
    .amelia-v2-booking [class*="reschedule"] {
        color: rgba(255, 255, 255, 0.85) !important;
        background: rgba(255, 255, 255, 0.06) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
    .amelia-v2-booking .am-cc__cancel:hover,
    .amelia-v2-booking [class*="cancel"]:hover {
        color: #ff6b6b !important;
        border-color: rgba(255, 107, 107, 0.3) !important;
        background: rgba(255, 107, 107, 0.08) !important;
    }
    .amelia-v2-booking .am-cc__reschedule:hover,
    .amelia-v2-booking [class*="reschedule"]:hover {
        color: #c9a96e !important;
        border-color: rgba(201, 169, 110, 0.3) !important;
        background: rgba(201, 169, 110, 0.08) !important;
    }

    /* ─── DROPDOWN MENU (three dots → popup) ────────────────────── */
    .amelia-v2-booking .el-dropdown-menu,
    .amelia-v2-booking [class*="dropdown-menu"],
    .el-dropdown-menu {
        background: #1a1a1a !important;
        border: 1px solid rgba(201, 169, 110, 0.2) !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.5) !important;
    }
    .amelia-v2-booking .el-dropdown-menu__item,
    .el-dropdown-menu__item {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .amelia-v2-booking .el-dropdown-menu__item:hover,
    .el-dropdown-menu__item:hover {
        background: rgba(201, 169, 110, 0.1) !important;
        color: #c9a96e !important;
    }

    /* ─── EXPANDED APPOINTMENT DETAIL VIEW ──────────────────────── */
    .amelia-v2-booking .am-capa__item__details,
    .amelia-v2-booking [class*="am-cc__details"],
    .amelia-v2-booking [class*="am-cc__info"],
    .amelia-v2-booking [class*="details-wrapper"] {
        background: rgba(255, 255, 255, 0.03) !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
        color: rgba(255, 255, 255, 0.85) !important;
    }

    /* Labels inside expanded view */
    .amelia-v2-booking [class*="am-cc__details"] label,
    .amelia-v2-booking [class*="am-cc__details"] .am-label,
    .amelia-v2-booking [class*="details"] span[class*="label"] {
        color: rgba(201, 169, 110, 0.7) !important;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: 0.08em;
    }

    /* ─── Appointment card hover state ─────────────────────────── */
    .amelia-v2-booking .am-cc:hover,
    .amelia-v2-booking [class*="am-capa__item"]:hover {
        background: rgba(255, 255, 255, 0.07) !important;
        border-color: rgba(201, 169, 110, 0.2) !important;
        cursor: pointer;
    }

    /* ─── Any other Amelia body text ───────────────────────────── */
    .amelia-v2-booking .am-caph__text,
    .amelia-v2-booking .am-fs__main p,
    .amelia-v2-booking .am-fs__main span:not([class*="status"]):not([class*="icon"]) {
        color: rgba(255, 255, 255, 0.75) !important;
    }

    /* ─── Status badge fix (keep visible) ─────────────────────── */
    .amelia-v2-booking [class*="status"] {
        opacity: 1 !important;
    }

    /* ─── Employee Profile popup (Vue Teleport — outside wrapper) ─ */
    .am-popover-popper.el-popper {
        background: #161616 !important;
        border: 1px solid rgba(201, 169, 110, 0.3) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.75) !important;
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .am-popover-popper.el-popper .el-popper__arrow::before {
        background: #161616 !important;
        border-color: rgba(201, 169, 110, 0.2) !important;
    }
    .am-popover-popper.el-popper .el-popover__title {
        color: #c9a96e !important;
        font-size: 10px !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        font-weight: 600 !important;
    }
    .am-popover-popper.el-popper * {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .am-popover-popper .am-badge {
        background-color: rgba(201, 169, 110, 0.12) !important;
        color: #c9a96e !important;
    }
    .am-popover-popper hr,
    .am-popover-popper [class*="divider"],
    .am-popover-popper [class*="separator"] {
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* Date/filter bar background */
    .amelia-v2-booking .am-date-picker,
    .amelia-v2-booking [class*="date-range"],
    .amelia-v2-booking [class*="am-filters"] {
        background: rgba(255,255,255,0.04) !important;
        border-color: rgba(255,255,255,0.1) !important;
        color: rgba(255,255,255,0.8) !important;
    }

    
    /* ══════════════════════════════════════════════════════════════
       RESCHEDULE DIALOG (am-csd = Amelia Customer Side Dialog)
       v4.1: Uses REAL class names from DOM inspection
       ══════════════════════════════════════════════════════════════ */

    /* ─── Parent overflow fix: ancestors clip the wider dialog ── */
    .am-fs__main:has(.am-csd__reschedule),
    .am-fs__main-inner:has(.am-csd__reschedule),
    .am-cap.am-capa-main.am-fs__main-content:has(.am-csd__reschedule) {
        overflow: visible !important;
    }
    .am-fs__main:has(.am-csd__cancel),
    .am-fs__main-inner:has(.am-csd__cancel),
    .am-cap.am-capa-main.am-fs__main-content:has(.am-csd__cancel) {
        overflow: visible !important;
    }

    /* ─── Dialog container: force wider for 7-day calendar ──────── */
    .am-csd__reschedule {
        min-width: 960px !important;
        width: 960px !important;
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        z-index: 99999 !important;
        max-height: 90vh !important;
        overflow-y: auto !important;
        background: rgba(30, 30, 30, 0.98) !important;
        border: 1px solid rgba(201, 169, 110, 0.25) !important;
        border-radius: 12px !important;
        box-shadow: 0 12px 48px rgba(0, 0, 0, 0.8) !important;
    }

    /* ─── Dialog header ─────────────────────────────────────────── */
    .am-csd__reschedule .am-csd__header {
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Title: "Select date and time" — was rgb(26,44,55) = invisible */
    .am-csd__reschedule .am-csd__header-text {
        color: #c9a96e !important;
        font-weight: 600 !important;
    }

    /* Close button (X) */
    .am-csd__reschedule .am-csd__header-btn {
        color: rgba(255, 255, 255, 0.6) !important;
    }
    .am-csd__reschedule .am-csd__header-btn:hover {
        color: #ffffff !important;
    }

    /* ─── Content area: fix overflow clipping Sunday column ──────── */
    .am-csd__reschedule .am-csd__content {
        overflow-x: visible !important;
        overflow-y: auto !important;
        padding: 16px !important;
    }

    /* ─── Calendar wrapper (am-advsc) ──────────────────────────── */
    .am-csd__reschedule .am-advsc__wrapper {
        width: 100% !important;
    }

    /* Calendar header: month/year selectors */
    .am-csd__reschedule .am-advsc__header {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    /* El-select dropdown arrow icon (was rgb(26,44,55)) */
    .am-csd__reschedule .el-select__caret,
    .am-csd__reschedule .el-select__icon,
    .am-csd__reschedule .el-icon {
        color: rgba(201, 169, 110, 0.7) !important;
    }

    /* Timezone label */
    .am-csd__reschedule .am-advsc__time-zone {
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 11px;
    }

    /* ─── FullCalendar grid (fc = FullCalendar) ────────────────── */
    .am-csd__reschedule .fc {
        width: 100% !important;
        max-width: 100% !important;
        table-layout: fixed !important;
        width: 100% !important;
    }

    /* Day header cells (Mon, Tue, Wed...) */
    .am-csd__reschedule .fc-daygrid-body,
    .am-csd__reschedule .fc-daygrid-body table,
    .am-csd__reschedule .fc-scrollgrid {
        width: 100% !important;
        max-width: 100% !important;
        table-layout: fixed !important;
    }
    .am-csd__reschedule .fc-scrollgrid-section > td,
    .am-csd__reschedule .fc-scrollgrid-section > th {
        width: 100% !important;
    }

    .am-csd__reschedule .fc th,
    .am-csd__reschedule .fc .fc-col-header-cell {
        color: rgba(255, 255, 255, 0.6) !important;
    }

    /* Day number cells */
    .am-csd__reschedule .fc td,
    .am-csd__reschedule .fc .fc-daygrid-day {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .am-csd__reschedule .fc .fc-daygrid-day-number,
    .am-csd__reschedule .fc .fc-daygrid-day-top a {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    /* Disabled/past days */
    .am-csd__reschedule .fc .fc-day-disabled,
    .am-csd__reschedule .fc .fc-day-other {
        color: rgba(255, 255, 255, 0.25) !important;
    }

    /* ─── Time slots ───────────────────────────────────────────── */
    .am-csd__reschedule .am-advsc__slots-wrapper {
        color: rgba(255, 255, 255, 0.85) !important;
    }


    /* ─── Date heading (e.g. "April 24, 2026") — invisible navy ── */
    .am-csd__reschedule .am-advsc__slots-heading {
        color: #c9a96e !important;
        font-weight: 600 !important;
    }

    /* ─── Time slot text — dark blue unreadable on dark bg ──────── */
    .am-csd__reschedule .am-advsc__slots-item__inner {
        color: rgba(170, 200, 255, 0.95) !important;
    }
    .am-csd__reschedule .am-advsc__slots-item {
        border-color: rgba(140, 175, 240, 0.35) !important;
        background: rgba(38, 92, 242, 0.08) !important;
    }
    .am-csd__reschedule .am-advsc__slots-item:hover {
        background: rgba(38, 92, 242, 0.2) !important;
        border-color: rgba(140, 175, 240, 0.6) !important;
    }

    /* ─── Inner container overflow fix ─────────────────────────── */
    .am-csd__reschedule .am-csd__inner {
        overflow: visible !important;
    }

    /* ─── Footer: Cancel + Continue buttons ────────────────────── */
    .am-csd__reschedule .am-csd__footer {
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        background: transparent !important;
    }

    /* Cancel button — was rgb(26,44,55) = invisible */
    .am-csd__reschedule .am-csd__footer .am-button--plain,
    .am-csd__reschedule .am-csd__footer .am-button--sec {
        color: rgba(255, 255, 255, 0.7) !important;
        background: transparent !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
    .am-csd__reschedule .am-csd__footer .am-button--plain:hover {
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.3) !important;
    }

    /* Continue button */
    .am-csd__reschedule .am-csd__footer .am-button--filled,
    .am-csd__reschedule .am-csd__footer .am-button--pr {
        background: #c9a96e !important;
        color: #0c0c0c !important;
        border-color: #c9a96e !important;
    }
    .am-csd__reschedule .am-csd__footer .am-button--filled:hover {
        background: #d4b87d !important;
    }

    /* ─── Cancel dialog (same am-csd pattern) ──────────────────── */
    .am-csd__cancel {
        background: rgba(30, 30, 30, 0.98) !important;
        border: 1px solid rgba(201, 169, 110, 0.25) !important;
        border-radius: 12px !important;
    }
    .am-csd__cancel .am-csd__header-text {
        color: #c9a96e !important;
        font-weight: 600 !important;
    }
    .am-csd__cancel .am-csd__header-btn {
        color: rgba(255, 255, 255, 0.6) !important;
    }
    .am-csd__cancel .am-csd__content {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .am-csd__cancel .am-csd__footer .am-button--plain {
        color: rgba(255, 255, 255, 0.7) !important;
        border-color: rgba(255, 255, 255, 0.15) !important;
    }
    .am-csd__cancel .am-csd__footer .am-button--filled {
        background: #ff6b6b !important;
        color: #ffffff !important;
        border-color: #ff6b6b !important;
    }


    </style>
    <?php
}

add_action( 'wp_footer', 'rg_amelia_catalog_css', 99999 );
function rg_amelia_catalog_css() {
    ?>
    <style id="rg-amelia-catalog">

    /* ══════════════════════════════════════════════════════════════
       AMELIA SERVICE CATALOG v1 — Dark Luxury (2026-04-17) — #68
       am-fcil = catalog list  |  am-fcis = service detail
       ══════════════════════════════════════════════════════════════ */

    /* ─── Catalog wrapper: transparent so page bg shows ─────── */
    .amelia-v2-booking .am-fc__wrapper { background: transparent !important; }

    /* ─── "Available - N Services" heading ──────────────────── */
    .amelia-v2-booking .am-fcil__heading {
        color: rgba(204,197,147,0.7) !important;
        font-size: 11px !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
    }

    /* ─── Search bar ─────────────────────────────────────────── */
    .amelia-v2-booking .am-input-wrapper,
    .amelia-v2-booking .el-input__wrapper {
        background: rgba(255,255,255,0.05) !important;
        border-color: rgba(204,197,147,0.2) !important;
        box-shadow: none !important;
    }
    .amelia-v2-booking .el-input__inner {
        color: rgba(255,255,255,0.8) !important;
        background: transparent !important;
    }
    .amelia-v2-booking .am-icon-search { color: rgba(204,197,147,0.5) !important; }

    /* ─── Service catalog cards ──────────────────────────────── */
    .amelia-v2-booking .am-fcil__item {
        background: rgba(255,252,245,0.05) !important;
        border: 1px solid rgba(204,197,147,0.18) !important;
        border-radius: 4px !important;
    }
    .amelia-v2-booking .am-fcil__item:hover {
        border-color: rgba(204,197,147,0.4) !important;
        background: rgba(255,252,245,0.08) !important;
    }
    .amelia-v2-booking .am-fcil__item-inner { background: transparent !important; }

    /* ─── Card name / heading ────────────────────────────────── */
    .amelia-v2-booking .am-fcil__item-name,
    .amelia-v2-booking .am-fcil__item-heading {
        color: rgba(240,235,225,0.92) !important;
        font-family: 'Cormorant Garamond', serif !important;
    }

    /* ─── Card meta: duration, employees ────────────────────── */
    .amelia-v2-booking .am-fcil__item-info,
    .amelia-v2-booking .am-fcil__item-info__inner { color: rgba(204,197,147,0.75) !important; }

    /* ─── Card price ─────────────────────────────────────────── */
    .amelia-v2-booking .am-fcil__item-price,
    .amelia-v2-booking .am-fcil__item-cost { color: rgba(204,197,147,0.9) !important; }

    /* ─── Card footer ────────────────────────────────────────── */
    .amelia-v2-booking .am-fcil__item-footer {
        background: transparent !important;
        border-top: 1px solid rgba(204,197,147,0.1) !important;
    }

    /* ─── Catalog buttons: Continue + View Professionnals ───── */
    .amelia-v2-booking .am-fcil__item-footer .am-button {
        background: transparent !important;
        border: 1px solid rgba(204,197,147,0.45) !important;
        color: rgba(204,197,147,0.9) !important;
    }
    .amelia-v2-booking .am-fcil__item-footer .am-button:hover {
        background: rgba(204,197,147,0.1) !important;
        border-color: rgba(204,197,147,0.8) !important;
        color: rgba(204,197,147,1) !important;
    }

    /* ─── "Continue" primary button: gold fill on hover ─────── */
    .amelia-v2-booking .am-fcil__item-footer .am-button--primary {
        background: rgba(204,197,147,0.12) !important;
        border: 1px solid rgba(204,197,147,0.7) !important;
        color: rgba(204,197,147,1) !important;
    }
    .amelia-v2-booking .am-fcil__item-footer .am-button--primary:hover {
        background: rgb(204,197,147) !important;
        color: #0c0c0c !important;
    }

    /* ══════════════════════════════════════════════════════════════
       SERVICE DETAIL (am-fcis = Full Catalog Item Single)
       ══════════════════════════════════════════════════════════════ */

    .amelia-v2-booking .am-fcis {
        background: rgba(255,252,245,0.03) !important;
        border: 1px solid rgba(204,197,147,0.15) !important;
    }
    .amelia-v2-booking .am-fcis__header {
        background: rgba(255,252,245,0.04) !important;
        border-bottom: 1px solid rgba(204,197,147,0.12) !important;
    }

    /* ─── Service name ───────────────────────────────────────── */
    .amelia-v2-booking .am-fcis__header-name {
        color: rgba(240,235,225,0.92) !important;
        font-family: 'Cormorant Garamond', serif !important;
    }

    /* ─── Price ──────────────────────────────────────────────── */
    .amelia-v2-booking .am-fcis__header-price { color: rgba(204,197,147,0.9) !important; }

    /* ─── "Book Now" button — CRITICAL FIX ──────────────────── */
    .amelia-v2-booking .am-fcis__header-btn,
    .amelia-v2-booking .am-fcis__header-action .am-button {
        background: rgba(204,197,147,0.15) !important;
        border: 1.5px solid rgba(204,197,147,0.85) !important;
        color: rgba(204,197,147,1) !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 12px !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        padding: 10px 24px !important;
        border-radius: 2px !important;
        min-width: 120px !important;
    }
    .amelia-v2-booking .am-fcis__header-btn:hover,
    .amelia-v2-booking .am-fcis__header-action .am-button:hover {
        background: rgb(204,197,147) !important;
        color: #0c0c0c !important;
    }

    /* ─── "Go Back" button ───────────────────────────────────── */
    .amelia-v2-booking .am-fcis__header .am-button--mini {
        background: transparent !important;
        border: 1px solid rgba(255,255,255,0.2) !important;
        color: rgba(255,255,255,0.5) !important;
        font-size: 11px !important;
        letter-spacing: 0.08em !important;
    }
    .amelia-v2-booking .am-fcis__header .am-button--mini:hover {
        color: #fff !important;
        border-color: rgba(255,255,255,0.5) !important;
    }

    /* ─── Description text ───────────────────────────────────── */
    .amelia-v2-booking .am-fcis__header-text,
    .amelia-v2-booking .am-fcis__info-service__desc { color: rgba(220,215,200,0.75) !important; }

    /* ─── Employee cards ─────────────────────────────────────── */
    .amelia-v2-booking .am-fcis__info-employee {
        background: rgba(255,255,255,0.04) !important;
        border: 1px solid rgba(204,197,147,0.15) !important;
    }
    .amelia-v2-booking .am-fcis__info-employee__name { color: rgba(240,235,225,0.85) !important; }
    .amelia-v2-booking .am-fcis__info-employee__description { color: rgba(220,215,200,0.65) !important; }

    /* ─── Mini info / meta ───────────────────────────────────── */
    .amelia-v2-booking .am-fcis__mini-info,
    .amelia-v2-booking .am-fcis__mini-info__inner { color: rgba(204,197,147,0.75) !important; }

    /* ─── Info tabs ──────────────────────────────────────────── */
    .amelia-v2-booking .am-fcis__info-tab { color: rgba(255,255,255,0.65) !important; }
    .amelia-v2-booking .am-fcis__info-tab.am-active {
        color: rgba(204,197,147,1) !important;
        border-bottom-color: rgba(204,197,147,0.8) !important;
    }

    /* ─── Collapse sections ──────────────────────────────────── */
    .amelia-v2-booking .am-collapse-item__heading {
        color: rgba(204,197,147,0.85) !important;
        font-size: 11px !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
    }
    .amelia-v2-booking .am-collapse-item__content { color: rgba(220,215,200,0.7) !important; }

    </style>
    <?php
}

add_action( 'wp_footer', 'rg_amelia_wizard_css', 99999 );
function rg_amelia_wizard_css() {
    ?>
    <style>
    /* === BOOKING WIZARD — DARK LUXURY RESKIN (v1.0) === */

    /* Overlay backdrop */
    .am-dialog-popup.amelia-v2-booking { background: rgba(0,0,0,0.75) !important; }

    /* Main right panel — kill the white */
    .am-fs__wrapper { background: #0f0c08 !important; border-radius: 4px !important; overflow: hidden !important; }
    .am-fs__main { background: #0f0c08 !important; }
    .am-fs__main-inner { background: #0f0c08 !important; }
    .am-fs__main-content { background: #0f0c08 !important; }
    .am-fs__main-heading { background: #0f0c08 !important; border-bottom: 1px solid rgba(204,197,147,0.18) !important; padding: 16px 24px !important; }
    .am-fs__main-heading-inner,
    .am-fs__main-heading-inner-title { color: rgba(204,197,147,0.9) !important; font-family: 'Cormorant Garamond', serif !important; font-size: 18px !important; letter-spacing: 0.08em !important; text-transform: uppercase !important; }
    .am-fs__main-footer { background: #0f0c08 !important; border-top: 1px solid rgba(204,197,147,0.15) !important; padding: 16px 24px !important; }

    /* Sidebar */
    .am-fs-sb { background: #110e09 !important; border-right: 1px solid rgba(204,197,147,0.15) !important; }
    .am-fs-sb__step-inner { color: rgba(240,235,225,0.7) !important; }
    .am-fs-sb__step-heading { color: rgba(240,235,225,0.7) !important; font-family: 'Inter', sans-serif !important; font-size: 12px !important; letter-spacing: 0.06em !important; }
    .am-fs-sb__step.am-active .am-fs-sb__step-heading { color: rgba(204,197,147,1) !important; }
    .am-fs-sb__step.am-active .am-fs-sb__step-icon { color: rgba(204,197,147,1) !important; }
    .am-fs-sb__step-checker { background: rgba(204,197,147,0.15) !important; border-color: rgba(204,197,147,0.5) !important; color: rgba(204,197,147,1) !important; }
    .am-fs-sb__step.am-active .am-fs-sb__step-checker { background: rgba(204,197,147,0.3) !important; border-color: rgba(204,197,147,0.9) !important; }
    .am-fs-sb__support-heading { color: rgba(240,235,225,0.5) !important; font-size: 10px !important; text-transform: uppercase !important; letter-spacing: 0.08em !important; }
    .am-fs-sb__support-email { color: rgba(204,197,147,0.7) !important; font-size: 11px !important; }
    .am-fs-sb__menu-text { color: rgba(240,235,225,0.5) !important; font-size: 11px !important; }
    .am-icon-arrow-circle-right { color: rgba(204,197,147,0.6) !important; }

    /* Calendar container */
    .am-fs-dt__calendar { background: #0f0c08 !important; }
    .am-advsc__wrapper { background: #0f0c08 !important; }
    .am-advsc__duration,
    .am-advsc__time-zone { color: rgba(240,235,225,0.4) !important; font-size: 11px !important; }

    /* Month/year select dropdowns */
    .am-advsc__header { background: #0f0c08 !important; padding: 12px 0 8px !important; }
    .am-select-wrapper { background: transparent !important; }
    .am-select .el-select__wrapper,
    .el-select__wrapper { background: rgba(30,25,15,0.9) !important; border: 1px solid rgba(204,197,147,0.35) !important; border-radius: 2px !important; box-shadow: none !important; color: rgba(204,197,147,0.9) !important; padding: 4px 10px !important; }
    .el-select__selected-item,
    .el-select__placeholder { color: rgba(204,197,147,0.9) !important; font-family: 'Inter', sans-serif !important; font-size: 12px !important; letter-spacing: 0.06em !important; }
    .el-select__suffix { color: rgba(204,197,147,0.6) !important; }

    /* Prev/next month buttons */
    .am-button-group .am-button--secondary { background: rgba(30,25,15,0.9) !important; border: 1px solid rgba(204,197,147,0.3) !important; color: rgba(204,197,147,0.8) !important; }
    .am-button-group .am-button--secondary:hover { border-color: rgba(204,197,147,0.7) !important; color: rgba(204,197,147,1) !important; }

    /* FullCalendar grid */
    .am-advsc.fc,
    .am-advsc .fc-scrollgrid,
    .am-advsc .fc-view-harness,
    .am-advsc .fc-daygrid { background: #0f0c08 !important; border-color: rgba(204,197,147,0.1) !important; }
    .am-advsc .fc-scrollgrid { border: none !important; }
    .am-advsc td, .am-advsc th { border-color: rgba(204,197,147,0.08) !important; }
    .am-advsc .fc-col-header-cell { background: rgba(20,16,10,0.9) !important; }
    .am-advsc .fc-col-header-cell-cushion { color: rgba(204,197,147,0.6) !important; font-family: 'Inter', sans-serif !important; font-size: 11px !important; letter-spacing: 0.1em !important; text-transform: uppercase !important; text-decoration: none !important; }

    /* Day cell frames — override Amelia blue */
    .am-advsc .fc-daygrid-day-frame { background: transparent !important; border: none !important; border-radius: 0 !important; }
    /* Available (bookable) days — champagne gold */
    .am-advsc .fc-daygrid-day:has(.am-advsc__occupancy) .fc-daygrid-day-frame { background: rgba(204,197,147,0.06) !important; border: 1px solid rgba(204,197,147,0.35) !important; border-radius: 3px !important; cursor: pointer !important; }
    .am-advsc .fc-daygrid-day:has(.am-advsc__occupancy) .fc-daygrid-day-frame:hover { background: rgba(204,197,147,0.14) !important; border-color: rgba(204,197,147,0.7) !important; }
    .am-advsc .fc-daygrid-day:has(.am-advsc__occupancy) .fc-daygrid-day-number { color: rgba(240,235,225,0.95) !important; }

    /* Day number colors */
    .am-advsc .fc-daygrid-day { background: #0f0c08 !important; }
    .am-advsc .fc-daygrid-day:hover { background: rgba(204,197,147,0.06) !important; }
    .am-advsc .fc-daygrid-day-number { color: rgba(240,235,225,0.75) !important; font-family: 'Inter', sans-serif !important; font-size: 13px !important; text-decoration: none !important; }
    .am-advsc .fc-day-today { background: rgba(204,197,147,0.08) !important; }
    .am-advsc .fc-day-today .fc-daygrid-day-frame { background: rgba(204,197,147,0.1) !important; border: 1px solid rgba(204,197,147,0.5) !important; }
    .am-advsc .fc-day-today .fc-daygrid-day-number { color: rgba(204,197,147,1) !important; font-weight: 600 !important; }
    .am-advsc .fc-day-disabled .fc-daygrid-day-number,
    .am-advsc .fc-day-other .fc-daygrid-day-number { color: rgba(240,235,225,0.25) !important; }
    .am-advsc__dayGridMonth-disabled .fc-daygrid-day-number { color: rgba(240,235,225,0.2) !important; }
    .am-advsc__dayGridMonth-header-cell .fc-col-header-cell-cushion { color: rgba(204,197,147,0.55) !important; }

    /* Continue button — champagne gold */
    .am-button-continue,
    .am-fs__main-footer .am-button--primary { background: rgba(204,197,147,0.12) !important; border: 1.5px solid rgba(204,197,147,0.8) !important; color: rgba(204,197,147,1) !important; font-family: 'Inter', sans-serif !important; font-size: 11px !important; letter-spacing: 0.14em !important; text-transform: uppercase !important; border-radius: 2px !important; padding: 12px 32px !important; }
    .am-button-continue:not(.is-disabled):hover,
    .am-fs__main-footer .am-button--primary:not(.is-disabled):hover { background: rgba(204,197,147,0.22) !important; border-color: rgba(204,197,147,1) !important; }
    .am-button-continue.is-disabled,
    .am-fs__main-footer .am-button--primary.is-disabled { background: rgba(204,197,147,0.04) !important; border-color: rgba(204,197,147,0.25) !important; color: rgba(204,197,147,0.35) !important; cursor: not-allowed !important; }

    /* Close X button */
    .am-fs__popup-x { color: rgba(204,197,147,0.6) !important; }
    .am-fs__popup-x:hover { color: rgba(204,197,147,1) !important; }

    /* Select popper (month/year dropdown list) */
    .am-select-popper { background: #1a1408 !important; border: 1px solid rgba(204,197,147,0.3) !important; border-radius: 2px !important; box-shadow: 0 8px 24px rgba(0,0,0,0.5) !important; }
    .am-select-option { background: transparent !important; color: rgba(240,235,225,0.8) !important; font-family: 'Inter', sans-serif !important; font-size: 12px !important; }
    .am-select-option:hover,
    .am-select-option.is-hovering { background: rgba(204,197,147,0.1) !important; color: rgba(204,197,147,1) !important; }
    .am-select-option.is-selected { color: rgba(204,197,147,1) !important; font-weight: 500 !important; }

    </style>
    <?php
}


add_action( 'wp_footer', 'rg_wcfm_dark_css', 99999 );
function rg_wcfm_dark_css() { ?>
<style id="rg-wcfm-dark">

/* ── PAGE BACKGROUND ─────────────────────────────────────────── */
body.wcfm-theme-rive-gosh,
body.wcfm-theme-rive-gosh #custom {
    background-color: #0f0c08 !important;
}

/* ── TOP NAV BUTTONS (SUB-AFFILIATES, NETWORK, etc.) ─────────── */
body.wcfm-theme-rive-gosh .ml_wcutablinks,
body.wcfm-theme-rive-gosh a.ml_wcutablinks,
body.wcfm-theme-rive-gosh .ml-wcutabfirst {
    background: rgba(20,16,10,0.85) !important;
    border: 1px solid rgba(204,197,147,0.4) !important;
    color: rgba(204,197,147,0.85) !important;
    font-family: 'Inter', sans-serif !important;
}
body.wcfm-theme-rive-gosh .ml_wcutablinks:hover,
body.wcfm-theme-rive-gosh a.ml_wcutablinks:hover {
    background: rgba(204,197,147,0.12) !important;
    border-color: rgba(204,197,147,0.7) !important;
    color: rgba(204,197,147,1) !important;
}
body.wcfm-theme-rive-gosh .ml_wcutablinks.ml-wcutabactive,
body.wcfm-theme-rive-gosh a.ml_wcutablinks.ml-wcutabactive {
    background: rgba(204,197,147,0.15) !important;
    border-color: rgba(204,197,147,0.8) !important;
    color: rgba(204,197,147,1) !important;
}

/* ── SECTION / PAGE HEADINGS ─────────────────────────────────── */
body.wcfm-theme-rive-gosh h2,
body.wcfm-theme-rive-gosh h3 {
    color: rgba(204,197,147,0.9) !important;
}

/* ── SETTINGS TAB NAV (ul.wcu-settings-tab-nav) ──────────────── */
body.wcfm-theme-rive-gosh .wcu-settings-tabs {
    background: transparent !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-nav {
    display: flex !important;
    flex-wrap: wrap !important;
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
    border-bottom: 1px solid rgba(204,197,147,0.25) !important;
    background: transparent !important;
}
/* All tabs get 2px transparent border so height never shifts */
body.wcfm-theme-rive-gosh .wcu-settings-tab-nav li {
    margin: 0 !important;
    padding: 0 !important;
    border-bottom: 2px solid transparent !important;
    list-style: none !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-nav li a {
    display: block !important;
    padding: 10px 18px !important;
    color: rgba(240,235,225,0.45) !important;
    text-decoration: none !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 11px !important;
    letter-spacing: 0.08em !important;
    text-transform: uppercase !important;
    border: none !important;
    background: transparent !important;
    transition: color 0.15s !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-nav li a:hover {
    color: rgba(204,197,147,0.85) !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-nav li.active {
    border-bottom: 2px solid rgba(204,197,147,0.85) !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-nav li.active a {
    color: rgba(204,197,147,1) !important;
}

/* ── SETTINGS PANEL CONTAINER ────────────────────────────────── */
body.wcfm-theme-rive-gosh .wcu-settings-tab-content,
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane,
body.wcfm-theme-rive-gosh .wcusage_settings_form {
    background: rgba(20,16,10,0.6) !important;
    border: 1px solid rgba(204,197,147,0.2) !important;
    border-radius: 4px !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-content {
    padding: 24px !important;
}

/* ── PANEL HEADINGS & BODY TEXT ──────────────────────────────── */
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane strong,
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane b,
body.wcfm-theme-rive-gosh .wcu-settings-tab-content strong,
body.wcfm-theme-rive-gosh .wcu-settings-tab-content b {
    color: rgba(204,197,147,0.85) !important;
    font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif !important;
    font-size: 11px !important;
    letter-spacing: 0.24em !important;
    text-transform: uppercase !important;
    font-style: normal !important;
    font-weight: 600 !important;
    display: inline-block !important;
    margin: 14px 0 6px !important;
    padding-bottom: 6px !important;
    border-bottom: 1px solid rgba(204,197,147,0.18) !important;
}
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane label,
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane p,
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane td,
body.wcfm-theme-rive-gosh .wcu-settings-tab-pane th {
    color: rgba(240,235,225,0.8) !important;
}

/* ── FORM INPUTS & SELECTS ───────────────────────────────────── */
body.wcfm-theme-rive-gosh input[type="text"],
body.wcfm-theme-rive-gosh input[type="email"],
body.wcfm-theme-rive-gosh input[type="number"],
body.wcfm-theme-rive-gosh input[type="password"],
body.wcfm-theme-rive-gosh select,
body.wcfm-theme-rive-gosh textarea {
    background: rgba(20,16,10,0.9) !important;
    border: 1px solid rgba(204,197,147,0.35) !important;
    color: rgba(240,235,225,0.85) !important;
    font-family: 'Inter', sans-serif !important;
}

/* ── CHECKBOXES ──────────────────────────────────────────────── */
body.wcfm-theme-rive-gosh input[type="checkbox"] {
    accent-color: rgba(204,197,147,0.9) !important;
}

/* ── SAVE CHANGES BUTTON ─────────────────────────────────────── */
body.wcfm-theme-rive-gosh .wcu-save-settings-button,
body.wcfm-theme-rive-gosh input[name="wcu-save-settings"],
body.wcfm-theme-rive-gosh button.wcu-save-settings-button {
    display: block !important;
    margin: 16px auto 0 !important;
    padding: 10px 32px !important;
    background: rgba(204,197,147,0.1) !important;
    border: 1px solid rgba(204,197,147,0.7) !important;
    color: rgba(204,197,147,1) !important;
    font-family: 'Inter', sans-serif !important;
    letter-spacing: 0.08em !important;
    text-transform: uppercase !important;
    font-size: 11px !important;
    cursor: pointer !important;
    border-radius: 2px !important;
}
body.wcfm-theme-rive-gosh .wcu-save-settings-button:hover {
    background: rgba(204,197,147,0.2) !important;
}

/* ── CONNECT TO STRIPE / ACTION LINKS ───────────────────────── */
body.wcfm-theme-rive-gosh .create-stripe-link,
body.wcfm-theme-rive-gosh .wcusage-social-link,
body.wcfm-theme-rive-gosh .wcu-download-qr {
    background: rgba(204,197,147,0.12) !important;
    border: 1.5px solid rgba(204,197,147,0.8) !important;
    color: rgba(204,197,147,1) !important;
}

/* ── TABLES ──────────────────────────────────────────────────── */
body.wcfm-theme-rive-gosh table {
    background: transparent !important;
}
body.wcfm-theme-rive-gosh table th {
    background: rgba(204,197,147,0.08) !important;
    color: rgba(204,197,147,0.9) !important;
    border-bottom: 1px solid rgba(204,197,147,0.25) !important;
}
body.wcfm-theme-rive-gosh table td {
    border-bottom: 1px solid rgba(204,197,147,0.1) !important;
    color: rgba(240,235,225,0.8) !important;
}
body.wcfm-theme-rive-gosh table tr:hover td {
    background: rgba(204,197,147,0.05) !important;
}

/* ── EXPORT BUTTONS ──────────────────────────────────────────── */
body.wcfm-theme-rive-gosh .wcu-button-export {
    background: rgba(20,16,10,0.85) !important;
    border: 1px solid rgba(204,197,147,0.4) !important;
    color: rgba(204,197,147,0.85) !important;
}

</style>
<?php }


add_action( 'wp_footer', 'rg_amelia_page_dark_css', 99999 );
function rg_amelia_page_dark_css() {
    ?>
    <style id="rg-amelia-page-dark">
    /* ══ AMELIA CATALOG PAGES — FULL DARK LUXURY v1.0 (2026-04-17) — #68 ══ */

    /* ─── Root dark: kill browser default white ─── */
    html:has(.am-fc__wrapper),
    html:has(.am-fc__wrapper) body {
        background-color: #0a0a0a !important;
    }

    /* ─── All non-nav sections: dark + no decorative bg-images ─── */
    html:has(.am-fc__wrapper) .h-section:not(.h-navigation),
    html:has(.am-fc__wrapper) .content,
    html:has(.am-fc__wrapper) #page,
    html:has(.am-fc__wrapper) article {
        background-color: #0a0a0a !important;
        background-image: none !important;
    }

    /* ─── Colibri overlay gradient (inline style on heading band) ─── */
    html:has(.am-fc__wrapper) .overlay-image-layer {
        background-image: none !important;
        background-color: transparent !important;
    }

    /* ─── Colibri parallax helpers: grey bleeds through ─── */
    html:has(.am-fc__wrapper) .expand-trigger,
    html:has(.am-fc__wrapper) .contract-trigger {
        background-color: #0a0a0a !important;
    }

    /* ─── Hero: dark gradient at bottom (over grey image edge) ─── */
    html:has(.am-fc__wrapper) .h-hero {
        position: relative !important;
    }
    html:has(.am-fc__wrapper) .h-hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 120px;
        background: linear-gradient(to bottom, transparent, #0a0a0a 75%);
        z-index: 2;
        pointer-events: none;
    }

    /* ─── Intro paragraphs: constrain width + cream color ─── */
    html:has(.am-fc__wrapper) .h-text p,
    html:has(.am-fc__wrapper) .h-text-component p {
        max-width: 760px;
        margin-left: auto !important;
        margin-right: auto !important;
        color: rgba(220,215,200,0.82) !important;
        line-height: 1.75 !important;
    }
    html:has(.am-fc__wrapper) .h-text p strong,
    html:has(.am-fc__wrapper) .h-text-component p strong {
        color: rgba(240,235,225,0.95) !important;
    }

    /* ─── Page heading: gold ─── */
    html:has(.am-fc__wrapper) .h-heading {
        color: rgba(204,197,147,0.9) !important;
    }

    /* ─── am-cat__wrapper: Amelia's own solid white container ─── */
    .amelia-v2-booking .am-cat__wrapper,
    .amelia-v2-booking .am-cat__wrapper.am-fcil,
    .amelia-v2-booking .am-fc__wrapper {
        background: transparent !important;
    }

    /* ─── Price badge: champagne not white ─── */
    .amelia-v2-booking .am-fcil__item-price {
        background: rgba(204,197,147,0.15) !important;
        color: rgba(204,197,147,0.9) !important;
    }
    </style>
    <?php
}


add_action( 'wp_footer', 'rg_amelia_luxury_redesign', 99999 );
function rg_amelia_luxury_redesign() {
    ?>
    <style id="rg-amelia-luxury-redesign">
    /* ══ AMELIA CATALOG — LUXURY REDESIGN v2.0 (2026-04-17) — #68 ══
       Fixes: blue links, icon contrast, badge, full card polish
       ══════════════════════════════════════════════════════════════ */

    /* ── NUCLEAR: kill ALL browser-default blue links in Amelia ── */
    .amelia-v2-booking a,
    .amelia-v2-booking a:link,
    .amelia-v2-booking a:visited,
    .amelia-v2-booking a:hover,
    .amelia-v2-booking a:active {
        color: rgba(190,183,143,0.75) !important;
        text-decoration: none !important;
    }
    .amelia-v2-booking a:hover {
        color: rgba(204,197,147,1) !important;
    }

    /* ── Info row: category links as subtle uppercase labels ──── */
    .amelia-v2-booking .am-fcil__item-info a {
        font-size: 10px !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
        color: rgba(175,168,130,0.65) !important;
    }
    .amelia-v2-booking .am-fcil__item-info a:hover {
        color: rgba(204,197,147,0.9) !important;
    }

    /* ── Info row: ALL text cream/gold, not blue ──────────────── */
    .amelia-v2-booking .am-fcil__item-info,
    .amelia-v2-booking .am-fcil__item-info *,
    .amelia-v2-booking .am-fcil__item-info__inner,
    .amelia-v2-booking .am-fcil__item-info__inner * {
        color: rgba(190,183,143,0.75) !important;
    }

    /* ── Icons inside info row: gold tint ────────────────────── */
    .amelia-v2-booking .am-fcil__item-info svg,
    .amelia-v2-booking .am-fcil__item-info .am-icon,
    .amelia-v2-booking .am-fcil__item-info span[class*="icon"],
    .amelia-v2-booking .am-fcil__item-info span[class*="svg"] {
        color: rgba(204,197,147,0.55) !important;
        fill: rgba(204,197,147,0.55) !important;
    }

    /* ── Service type badge ("Service", "Event" etc) ─────────── */
    .amelia-v2-booking [class*="am-fcil__item-type"],
    .amelia-v2-booking [class*="am-fcil__item-service"],
    .amelia-v2-booking [class*="fcil__badge"],
    .amelia-v2-booking [class*="fcil__tag"] {
        background: rgba(12,10,6,0.88) !important;
        border: 1px solid rgba(204,197,147,0.35) !important;
        color: rgba(204,197,147,0.8) !important;
        border-radius: 2px !important;
        font-size: 9px !important;
        letter-spacing: 0.18em !important;
        text-transform: uppercase !important;
        padding: 3px 8px !important;
    }

    /* ── Price badge: champagne pill ─────────────────────────── */
    .amelia-v2-booking .am-fcil__item-price {
        background: rgba(204,197,147,0.12) !important;
        border: 1px solid rgba(204,197,147,0.35) !important;
        color: rgba(204,197,147,0.95) !important;
        border-radius: 2px !important;
        font-weight: 600 !important;
        letter-spacing: 0.03em !important;
    }

    /* ── Card title: cream white, elegant serif ───────────────── */
    .amelia-v2-booking .am-fcil__item-name,
    .amelia-v2-booking .am-fcil__item-heading,
    .amelia-v2-booking .am-fcil__item-name a,
    .amelia-v2-booking .am-fcil__item-heading a {
        color: rgba(240,235,225,0.95) !important;
        font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif !important;
        font-size: 17px !important;
        letter-spacing: 0.02em !important;
        line-height: 1.35 !important;
    }

    /* ── Card: deeper dark glass, refined gold border ─────────── */
    .amelia-v2-booking .am-fcil__item {
        background: rgba(10,8,5,0.72) !important;
        border: 1px solid rgba(204,197,147,0.16) !important;
        border-radius: 3px !important;
        transition: border-color 0.3s ease, background 0.3s ease !important;
    }
    .amelia-v2-booking .am-fcil__item:hover {
        background: rgba(20,16,10,0.85) !important;
        border-color: rgba(204,197,147,0.38) !important;
        box-shadow: 0 8px 40px rgba(0,0,0,0.5) !important;
    }

    /* ── Footer divider ───────────────────────────────────────── */
    .amelia-v2-booking .am-fcil__item-footer {
        border-top: 1px solid rgba(204,197,147,0.1) !important;
        background: rgba(6,5,3,0.5) !important;
    }

    /* ── "Available — N Services" heading ─────────────────────── */
    .amelia-v2-booking .am-fcil__heading,
    .amelia-v2-booking .am-fcil__heading * {
        color: rgba(180,173,135,0.6) !important;
        letter-spacing: 0.14em !important;
        text-transform: uppercase !important;
        font-size: 10px !important;
    }

    /* ── Search / filter inputs ────────────────────────────────── */
    .amelia-v2-booking .el-input__wrapper,
    .amelia-v2-booking .am-input-wrapper {
        background: rgba(255,255,255,0.04) !important;
        border-color: rgba(204,197,147,0.2) !important;
        box-shadow: none !important;
    }
    .amelia-v2-booking .el-input__inner,
    .amelia-v2-booking input[type="text"] {
        color: rgba(230,225,210,0.85) !important;
        background: transparent !important;
    }
    .amelia-v2-booking .el-input__inner::placeholder {
        color: rgba(180,175,150,0.35) !important;
    }

    /* ── Buttons: ghost gold outline ──────────────────────────── */
    .amelia-v2-booking .am-fcil__item-footer .am-button {
        background: transparent !important;
        border: 1px solid rgba(204,197,147,0.35) !important;
        color: rgba(204,197,147,0.85) !important;
        letter-spacing: 0.06em !important;
        font-size: 12px !important;
        transition: all 0.25s ease !important;
    }
    .amelia-v2-booking .am-fcil__item-footer .am-button:hover {
        background: rgba(204,197,147,0.1) !important;
        border-color: rgba(204,197,147,0.7) !important;
        color: rgba(204,197,147,1) !important;
    }
    .amelia-v2-booking .am-fcil__item-footer .am-button--primary {
        background: rgba(204,197,147,0.1) !important;
        border-color: rgba(204,197,147,0.6) !important;
        color: rgba(204,197,147,1) !important;
    }
    .amelia-v2-booking .am-fcil__item-footer .am-button--primary:hover {
        background: rgba(204,197,147,0.92) !important;
        color: #0c0c0c !important;
    }
    </style>
    <?php
}


add_action( 'wp_footer', 'rg_amelia_detail_redesign', 99999 );
function rg_amelia_detail_redesign() {
    ?>
    <style id="rg-amelia-detail-redesign">
    /* ══ AMELIA DETAIL PAGE REDESIGN v1.0 (2026-04-17) — #68 ══ */

    /* ─── Extend dark bg to detail pages (am-fcis) ──────────── */
    html:has(.am-fcis),
    html:has(.am-fcis) body {
        background-color: #0a0a0a !important;
    }
    html:has(.am-fcis) .h-section:not(.h-navigation),
    html:has(.am-fcis) .content,
    html:has(.am-fcis) #page,
    html:has(.am-fcis) article {
        background-color: #0a0a0a !important;
        background-image: none !important;
    }
    html:has(.am-fcis) .overlay-image-layer {
        background-image: none !important;
        background-color: transparent !important;
    }

    /* ─── Page H1: shrink + gold tone ───────────────────────── */
    html:has(.am-fcis) .h-heading h1,
    html:has(.am-fcis) .h-heading,
    html:has(.am-fc__wrapper) .h-heading h1,
    html:has(.am-fc__wrapper) .h-heading {
        font-size: clamp(22px, 3vw, 32px) !important;
        line-height: 1.2 !important;
        letter-spacing: 0.04em !important;
        color: rgba(204,197,147,0.88) !important;
    }

    /* ─── Intro text: smaller, constrained, cream ────────────── */
    html:has(.am-fcis) .h-text p,
    html:has(.am-fcis) .h-text-component p,
    html:has(.am-fc__wrapper) .h-text p,
    html:has(.am-fc__wrapper) .h-text-component p {
        font-size: 13px !important;
        max-width: 640px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        color: rgba(190,183,143,0.72) !important;
        line-height: 1.7 !important;
    }

    /* ─── Amelia detail header row ───────────────────────────── */
    .amelia-v2-booking .am-fcis__header {
        background: rgba(10,8,5,0.8) !important;
        border: 1px solid rgba(204,197,147,0.18) !important;
        border-radius: 3px !important;
        padding: 14px 20px !important;
    }

    /* ─── Service name: smaller, elegant ─────────────────────── */
    .amelia-v2-booking .am-fcis__header-name,
    .amelia-v2-booking .am-fcis__header-name * {
        font-size: 15px !important;
        font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif !important;
        color: rgba(240,235,225,0.92) !important;
        letter-spacing: 0.03em !important;
        line-height: 1.3 !important;
    }

    /* ─── Detail meta row (category link, duration, capacity) ── */
    .amelia-v2-booking .am-fcis__mini-info,
    .amelia-v2-booking .am-fcis__mini-info * {
        color: rgba(175,168,130,0.7) !important;
        font-size: 11px !important;
        letter-spacing: 0.06em !important;
    }
    .amelia-v2-booking .am-fcis__mini-info a,
    .amelia-v2-booking .am-fcis__mini-info a:link,
    .amelia-v2-booking .am-fcis__mini-info a:visited {
        color: rgba(175,168,130,0.65) !important;
        text-decoration: none !important;
        text-transform: uppercase !important;
        font-size: 10px !important;
    }

    /* ─── Car image: show full car, no cropping ──────────────── */
    /* NOTE: use background-color longhand (not `background` shorthand) so
       Amelia's inline `background-image: url(...)` on .am-fcis__gallery-hero
       survives — the shorthand resets background-image to initial and was
       the cause of the black-rectangle hero bug (2026-04-20). */
    .amelia-v2-booking .am-fcis__media,
    .amelia-v2-booking [class*="fcis__gallery"],
    .amelia-v2-booking .am-fcis__image-wrapper {
        min-height: 240px !important;
        max-height: 300px !important;
        background-color: #0a0a0a !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        overflow: hidden !important;
    }
    .amelia-v2-booking .am-fcis__media img,
    .amelia-v2-booking [class*="fcis__gallery"] img,
    .amelia-v2-booking .am-fcis__image-wrapper img {
        object-fit: contain !important;
        max-height: 280px !important;
        width: auto !important;
        max-width: 85% !important;
        background: transparent !important;
    }

    /* ─── "Go Back" button: dark glass ───────────────────────── */
    .amelia-v2-booking .am-fcis .am-button,
    .amelia-v2-booking [class*="fcis__back"],
    .amelia-v2-booking .am-fcil__back .am-button,
    .amelia-v2-booking .am-button.am-button--plain {
        background: rgba(14,11,7,0.85) !important;
        border: 1px solid rgba(204,197,147,0.3) !important;
        color: rgba(204,197,147,0.75) !important;
        box-shadow: none !important;
    }
    .amelia-v2-booking .am-fcis .am-button:hover,
    .amelia-v2-booking .am-fcil__back .am-button:hover {
        border-color: rgba(204,197,147,0.6) !important;
        color: rgba(204,197,147,1) !important;
        background: rgba(204,197,147,0.08) !important;
    }

    /* ─── "Book Now" / primary CTA: gold fill ────────────────── */
    .amelia-v2-booking .am-fcis__header-action .am-button--filled,
    .amelia-v2-booking .am-fcis__header-btn.am-button--filled {
        background: rgba(204,197,147,0.18) !important;
        border: 1px solid rgba(204,197,147,0.7) !important;
        color: rgba(204,197,147,1) !important;
        letter-spacing: 0.1em !important;
        font-size: 11px !important;
    }
    .amelia-v2-booking .am-fcis__header-action .am-button--filled:hover,
    .amelia-v2-booking .am-fcis__header-btn.am-button--filled:hover {
        background: rgba(204,197,147,0.9) !important;
        color: #0c0c0c !important;
    }

    /* ─── "View all photos" pill ─────────────────────────────── */
    .amelia-v2-booking [class*="view-all"],
    .amelia-v2-booking [class*="fcis__photos"] {
        background: rgba(10,8,5,0.88) !important;
        border: 1px solid rgba(204,197,147,0.3) !important;
        color: rgba(204,197,147,0.8) !important;
        border-radius: 2px !important;
        font-size: 11px !important;
        letter-spacing: 0.1em !important;
    }

    /* ─── Tabs (About Service / Employees) ───────────────────── */
    .amelia-v2-booking .am-fcis__info-tab {
        color: rgba(180,175,145,0.55) !important;
        border-bottom: 2px solid transparent !important;
        font-size: 12px !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
    }
    .amelia-v2-booking .am-fcis__info-tab.am-active,
    .amelia-v2-booking .am-fcis__info-tab--active {
        color: rgba(204,197,147,0.9) !important;
        border-bottom-color: rgba(204,197,147,0.6) !important;
    }

    /* ─── Tab content text ───────────────────────────────────── */
    .amelia-v2-booking .am-fcis__info-service__desc,
    .amelia-v2-booking .am-fcis__info-service__desc *,
    .amelia-v2-booking .am-fcis__info-desc {
        color: rgba(190,183,143,0.72) !important;
        font-size: 13px !important;
        line-height: 1.7 !important;
    }

    /* ─── Wrapper background ─────────────────────────────────── */
    .amelia-v2-booking .am-fcis,
    .amelia-v2-booking .am-fcis__wrapper {
        background: transparent !important;
    }
    </style>
    <?php
}


add_action( 'wp_footer', 'rg_amelia_wizard_contrast_v2', 99999 );
function rg_amelia_wizard_contrast_v2() {
    ?>
    <style id="rg-amelia-wizard-contrast-v2">
    /* ══ BOOKING WIZARD CONTRAST FIX v2.0 (2026-04-17) — #68 ══ */

    /* ─── Europe/Paris timezone: was 0.4 opacity — now readable ─── */
    .am-advsc__time-zone,
    .am-advsc__duration,
    [class*="time-zone"],
    [class*="timezone"] {
        color: rgba(200,193,153,0.82) !important;
        font-size: 11px !important;
        letter-spacing: 0.08em !important;
        background: rgba(204,197,147,0.08) !important;
        border: 1px solid rgba(204,197,147,0.2) !important;
        border-radius: 2px !important;
        padding: 2px 8px !important;
    }

    /* ─── Calendar day column headers: MON TUE WED ... ──────── */
    .am-advsc .fc-col-header-cell-cushion,
    .am-advsc__dayGridMonth-header-cell .fc-col-header-cell-cushion {
        color: rgba(204,197,147,0.65) !important;
        font-size: 10px !important;
        letter-spacing: 0.14em !important;
    }

    /* ─── Month/year selects: force text visible ─────────────── */
    .el-select__wrapper,
    .am-select .el-select__wrapper {
        background: rgba(24,20,12,0.95) !important;
        border: 1px solid rgba(204,197,147,0.4) !important;
        color: rgba(204,197,147,0.95) !important;
        box-shadow: none !important;
    }
    .el-select__selected-item span,
    .el-select__selected-item,
    .el-select__placeholder {
        color: rgba(204,197,147,0.95) !important;
        font-size: 12px !important;
    }
    .el-select-v2__placeholder,
    .el-select__input {
        color: rgba(204,197,147,0.85) !important;
    }

    /* ─── Prev/Next arrows: high contrast circles ────────────── */
    .am-button-group .am-button--secondary,
    .am-button-group .am-button {
        background: rgba(24,20,12,0.95) !important;
        border: 1px solid rgba(204,197,147,0.4) !important;
        color: rgba(204,197,147,0.9) !important;
    }
    .am-button-group .am-button--secondary svg,
    .am-button-group .am-button svg {
        color: rgba(204,197,147,0.9) !important;
        fill: rgba(204,197,147,0.9) !important;
    }

    /* ─── Time slot picker (start/end time inputs) ───────────── */
    .am-fs-dt__time,
    .am-fs-dt__time-inner,
    [class*="am-fs-dt__time"] {
        background: rgba(14,11,7,0.9) !important;
        border: 1px solid rgba(204,197,147,0.2) !important;
        border-radius: 2px !important;
        color: rgba(220,213,170,0.9) !important;
    }

    /* ─── Time slot buttons / selectable times ───────────────── */
    .am-ts__item,
    .am-ts__item-inner,
    [class*="am-ts__"] {
        background: rgba(20,16,10,0.9) !important;
        border: 1px solid rgba(204,197,147,0.18) !important;
        color: rgba(220,213,170,0.85) !important;
        border-radius: 2px !important;
    }
    .am-ts__item:hover,
    .am-ts__item.am-active {
        background: rgba(204,197,147,0.12) !important;
        border-color: rgba(204,197,147,0.6) !important;
        color: rgba(204,197,147,1) !important;
    }
    .am-ts__item.am-disabled,
    .am-ts__item--disabled {
        background: transparent !important;
        border-color: rgba(204,197,147,0.08) !important;
        color: rgba(204,197,147,0.22) !important;
    }

    /* ─── Time label text (start / end / duration) ───────────── */
    .am-fs-dt__time-label,
    [class*="time-label"],
    [class*="time-heading"],
    [class*="am-fs-dt"] label,
    [class*="am-fs-dt"] .am-label {
        color: rgba(190,183,143,0.75) !important;
        font-size: 11px !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
    }

    /* ─── El-UI time/date inputs (start/finish pickers) ─────── */
    .el-date-editor,
    .el-date-editor .el-input__wrapper {
        background: rgba(24,20,12,0.95) !important;
        border-color: rgba(204,197,147,0.35) !important;
        box-shadow: none !important;
    }
    .el-date-editor input,
    .el-date-editor .el-input__inner {
        color: rgba(220,213,170,0.92) !important;
        background: transparent !important;
        font-size: 13px !important;
    }
    .el-date-editor .el-input__prefix,
    .el-date-editor .el-input__suffix {
        color: rgba(204,197,147,0.55) !important;
    }

    /* ─── El-UI date-picker panel (popper) ───────────────────── */
    .el-picker-panel,
    .el-date-picker {
        background: #0f0c08 !important;
        border: 1px solid rgba(204,197,147,0.25) !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.7) !important;
        color: rgba(220,213,170,0.9) !important;
    }
    .el-picker-panel__header-label,
    .el-date-picker__header-label {
        color: rgba(204,197,147,0.9) !important;
        font-size: 13px !important;
    }
    .el-date-table th {
        color: rgba(180,173,135,0.65) !important;
        font-size: 10px !important;
        letter-spacing: 0.1em !important;
        border-bottom: 1px solid rgba(204,197,147,0.1) !important;
    }
    .el-date-table td .el-date-table-cell__text {
        color: rgba(220,213,170,0.85) !important;
        background: transparent !important;
    }
    .el-date-table td.available:hover .el-date-table-cell__text {
        background: rgba(204,197,147,0.12) !important;
        color: rgba(204,197,147,1) !important;
    }
    .el-date-table td.today .el-date-table-cell__text {
        color: rgba(204,197,147,1) !important;
        font-weight: 600 !important;
    }
    .el-date-table td.disabled .el-date-table-cell__text {
        color: rgba(204,197,147,0.2) !important;
        background: transparent !important;
    }
    .el-date-table td.selected .el-date-table-cell__text {
        background: rgba(204,197,147,0.85) !important;
        color: #0c0c08 !important;
        border-radius: 2px !important;
    }

    /* ─── Picker navigation arrows ───────────────────────────── */
    .el-picker-panel__icon-btn,
    .el-date-picker__prev-btn,
    .el-date-picker__next-btn {
        color: rgba(204,197,147,0.7) !important;
    }
    .el-picker-panel__icon-btn:hover {
        color: rgba(204,197,147,1) !important;
    }

    /* ─── "DATE & TIME" step heading ─────────────────────────── */
    .am-fs__main-heading-inner,
    .am-fs__main-heading-inner-title {
        color: rgba(204,197,147,0.92) !important;
    }
    </style>
    <?php
}

/* ============================================================
   CONTRAST AUDIT FIXES — 2026-04-17
   Fixes: sub-menu black text, mobile menu teal, step/wizard
   elements, broad catch-all for any dark text on dark bg.
   ============================================================ */
add_action( 'wp_footer', 'rg_contrast_fixes_css', 99999 );
function rg_contrast_fixes_css() { ?>
<style id="rg-contrast-fixes">

/* ─── Nav sub-menus: black text → cream ─────────────────────── */
body.wcfm-theme-rive-gosh .colibri-menu .sub-menu {
    background: rgba(12,9,5,0.97) !important;
    border: 1px solid rgba(204,197,147,0.18) !important;
    box-shadow: 0 8px 32px rgba(0,0,0,0.7) !important;
}
body.wcfm-theme-rive-gosh .colibri-menu .sub-menu li a,
body.wcfm-theme-rive-gosh .colibri-menu .sub-menu li a:visited {
    color: rgba(240,235,225,0.82) !important;
    background: transparent !important;
}
body.wcfm-theme-rive-gosh .colibri-menu .sub-menu li a:hover {
    color: rgba(204,197,147,1) !important;
    background: rgba(204,197,147,0.07) !important;
}

/* ─── Mobile menu toggle/links: teal → gold ─────────────────── */
body.wcfm-theme-rive-gosh .h-mobile-menu a,
body.wcfm-theme-rive-gosh .h-mobile-menu .h-menu-toggle,
body.wcfm-theme-rive-gosh .h-mobile-menu [class*="toggle"],
body.wcfm-theme-rive-gosh .h-mobile-menu [class*="burger"] {
    color: rgba(204,197,147,0.9) !important;
}
body.wcfm-theme-rive-gosh .h-mobile-menu .sub-menu li a {
    color: rgba(240,235,225,0.82) !important;
    background: transparent !important;
}

/* ─── Checkboxes: ensure accent-color gold on all inputs ─────── */
body.wcfm-theme-rive-gosh input[type="checkbox"],
body.wcfm-theme-rive-gosh input[type="radio"] {
    accent-color: rgba(204,197,147,1) !important;
}

/* ─── Date inputs in summary/filter bars ────────────────────── */
body.wcfm-theme-rive-gosh input[type="date"],
body.wcfm-theme-rive-gosh input[type="datetime-local"] {
    background: rgba(20,16,10,0.9) !important;
    color: rgba(240,235,225,0.85) !important;
    border: 1px solid rgba(204,197,147,0.3) !important;
    border-radius: 3px !important;
    padding: 4px 8px !important;
    color-scheme: dark !important;
}

/* ─── Step/wizard/progress UI (OVA, WCFM plans, registration) ── */
body.wcfm-theme-rive-gosh [class*="step"],
body.wcfm-theme-rive-gosh [class*="wizard-step"],
body.wcfm-theme-rive-gosh [class*="progress-step"],
body.wcfm-theme-rive-gosh [class*="stepper"] {
    color: rgba(240,235,225,0.7) !important;
}
body.wcfm-theme-rive-gosh [class*="step"].active,
body.wcfm-theme-rive-gosh [class*="step"].current,
body.wcfm-theme-rive-gosh [class*="step"].selected,
body.wcfm-theme-rive-gosh [class*="step"]:first-child {
    color: rgba(204,197,147,1) !important;
}
body.wcfm-theme-rive-gosh [class*="step"] span,
body.wcfm-theme-rive-gosh [class*="step"] a,
body.wcfm-theme-rive-gosh [class*="step"] p {
    color: inherit !important;
}

/* ─── WCFM vendor Plans page (plan selection tabs/steps) ─────── */
body.wcfm-theme-rive-gosh .wcfm-plans-tab,
body.wcfm-theme-rive-gosh [class*="wcfm-plan"],
body.wcfm-theme-rive-gosh .wcfm_membership_plans_listing,
body.wcfm-theme-rive-gosh .wcfm-tab-heading {
    color: rgba(240,235,225,0.85) !important;
}
body.wcfm-theme-rive-gosh .wcfm-tab-heading.active,
body.wcfm-theme-rive-gosh .wcfm-tab-heading.wcfm-active {
    color: rgba(204,197,147,1) !important;
    border-bottom-color: rgba(204,197,147,0.85) !important;
}

/* ─── UWP profile page tabs (Plans / Profile) ────────────────── */
body.wcfm-theme-rive-gosh .uwp-profile-header-tabs a,
body.wcfm-theme-rive-gosh [class*="uwp-tab"] a,
body.wcfm-theme-rive-gosh [class*="uwp-profile"] .nav-tabs .nav-link,
body.wcfm-theme-rive-gosh [class*="uwp-profile"] .nav-item a {
    color: rgba(240,235,225,0.75) !important;
    border-bottom: 2px solid transparent !important;
}
body.wcfm-theme-rive-gosh .uwp-profile-header-tabs a.active,
body.wcfm-theme-rive-gosh [class*="uwp-tab"] a.active,
body.wcfm-theme-rive-gosh [class*="uwp-profile"] .nav-tabs .nav-link.active {
    color: rgba(204,197,147,1) !important;
    border-bottom-color: rgba(204,197,147,0.85) !important;
    background: transparent !important;
}

/* ─── Broad catch-all: any remaining black/near-black text ───── */
/* Targets links inside WCFM pages that haven't been styled */
body.wcfm-theme-rive-gosh a:not([class*="button"]):not([class*="btn"]):not(.ml_wcutablinks) {
    color: rgba(204,197,147,0.85) !important;
}
body.wcfm-theme-rive-gosh a:hover:not([class*="button"]):not([class*="btn"]):not(.ml_wcutablinks) {
    color: rgba(204,197,147,1) !important;
}


/* ─── WCU phone input: override white background ─────────────── */
body.wcfm-theme-rive-gosh input#wcu-input-phone,
body.wcfm-theme-rive-gosh .wcu-registration-form input[type="tel"],
body.wcfm-theme-rive-gosh .wcu-registration-form input[type="phone"] {
    background: rgba(20,16,10,0.9) !important;
    color: rgba(240,235,225,0.85) !important;
    border: 1px solid rgba(204,197,147,0.3) !important;
    border-radius: 3px !important;
}

</style>
<?php }

/* ============================================================
   MLA PORTAL DARK LUXURY REDESIGN
   2026-04-17
   Multi-Level Affiliate portal (woo-coupon-usage-pro)
   Pages: multi-level-affiliate (71558), affiliate-dashboard-2 (71222)
   ============================================================ */
add_action( 'wp_footer', 'rg_mla_portal_redesign', 99999 );
function rg_mla_portal_redesign() {
    if ( ! is_page( [ 71558, 71222 ] ) ) return;
    ?>
<style id="rg-mla-portal-redesign">

/* ─── Kill Colibri inherited font-size on MLA headings (120px h3 bug) ──── */
.affiliate-portal-container h1,
.affiliate-portal-container h2,
.affiliate-portal-container h3,
.affiliate-portal-container h4,
.affiliate-portal-container h5,
.affiliate-portal-container h6,
.wcu-user-coupon-title,
.wcu-tab-title,
.settings-title {
    font-size: inherit !important;
    line-height: 1.3 !important;
    font-family: inherit !important;
}

/* ─── Top nav buttons (Sub-Affiliates, Network, etc.) ────────── */
button.ml_wcutablinks,
.affiliate-portal-container button.portal-tablink {
    font-size: 11px !important;
    letter-spacing: 0.18em !important;
    text-transform: uppercase !important;
    padding: 12px 18px !important;
    border: 1px solid rgba(204,197,147,0.22) !important;
    background: rgba(20,16,10,0.55) !important;
    color: rgba(240,235,225,0.72) !important;
    transition: all 0.25s ease !important;
    margin: 2px !important;
    font-weight: 500 !important;
    font-family: inherit !important;
    border-radius: 2px !important;
    cursor: pointer !important;
}
button.ml_wcutablinks:hover {
    border-color: rgba(204,197,147,0.55) !important;
    color: rgba(204,197,147,0.95) !important;
    background: rgba(20,16,10,0.75) !important;
}
button.ml_wcutablinks.active,
button.ml_wcutablinks.ml-wcutabfirst.active {
    border-color: rgba(204,197,147,0.85) !important;
    background: rgba(204,197,147,0.12) !important;
    color: rgba(204,197,147,1) !important;
}

/* ─── Section title: "Your sub-affiliate coupons:" / "Settings:" ──── */
.wcu-tab-title,
p.wcu-tab-title,
.settings-title,
p.settings-title {
    font-size: 12px !important;
    letter-spacing: 0.24em !important;
    text-transform: uppercase !important;
    color: rgba(204,197,147,0.82) !important;
    font-weight: 500 !important;
    margin: 32px 0 18px 0 !important;
    padding-bottom: 10px !important;
    border-bottom: 1px solid rgba(204,197,147,0.15) !important;
    text-align: left !important;
    line-height: 1.4 !important;
}

/* ─── Content header h1 ("Logout Affiliate Dashboard" etc.) ──── */
.affiliate-portal-container .welcome-header h1,
.affiliate-portal-container .content-header h1 {
    font-size: 13px !important;
    color: rgba(204,197,147,0.9) !important;
    letter-spacing: 0.24em !important;
    text-transform: uppercase !important;
    font-weight: 500 !important;
}

/* ─── Sub-affiliate coupon card (replaces floating "Sub" text) ─ */
.wcu-user-coupon-list {
    background: rgba(20,16,10,0.65) !important;
    border: 1px solid rgba(204,197,147,0.2) !important;
    border-left: 3px solid rgba(204,197,147,0.55) !important;
    border-radius: 3px !important;
    padding: 16px 22px !important;
    margin-bottom: 10px !important;
    display: block !important;
}
.wcu-user-coupon-list h3 {
    font-size: 14px !important;
    letter-spacing: 0.1em !important;
    color: rgba(204,197,147,1) !important;
    margin: 0 0 8px 0 !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
}
.wcu-user-coupon-list h3 .fa-tags,
.wcu-user-coupon-list .fa-tags {
    color: rgba(204,197,147,0.8) !important;
    margin-right: 10px !important;
    font-size: 12px !important;
}
.wcu-user-coupon-list p {
    font-size: 12px !important;
    color: rgba(240,235,225,0.72) !important;
    margin: 2px 0 !important;
    line-height: 1.7 !important;
}

/* ─── Empty state text ──────────────────────────────────────── */
.affiliate-portal-container .content-body > p,
.affiliate-portal-container .content-body .wcu-empty-message {
    font-size: 13px !important;
    color: rgba(240,235,225,0.72) !important;
    line-height: 1.7 !important;
    text-align: left !important;
    padding: 14px 18px !important;
    background: rgba(20,16,10,0.4) !important;
    border-left: 2px solid rgba(204,197,147,0.25) !important;
    border-radius: 2px !important;
}

/* ─── Settings tabs (PAYOUT / STATEMENT / NOTIFICATIONS / ACCOUNT) ─ */
.wcu-settings-tab-nav {
    border-bottom: 1px solid rgba(204,197,147,0.2) !important;
    display: flex !important;
    gap: 0 !important;
    flex-wrap: wrap !important;
    background: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
}
.wcu-settings-tab-nav li {
    background: transparent !important;
    list-style: none !important;
    margin: 0 !important;
}
.wcu-settings-tab-nav a {
    font-size: 11px !important;
    letter-spacing: 0.22em !important;
    text-transform: uppercase !important;
    color: rgba(240,235,225,0.55) !important;
    padding: 14px 26px !important;
    border-bottom: 2px solid transparent !important;
    transition: all 0.25s ease !important;
    font-weight: 500 !important;
    display: inline-block !important;
    text-decoration: none !important;
}
.wcu-settings-tab-nav a:hover {
    color: rgba(240,235,225,0.9) !important;
}
.wcu-settings-tab-nav li.active a,
.wcu-settings-tab-nav a.active {
    color: rgba(204,197,147,1) !important;
    border-bottom: 2px solid rgba(204,197,147,0.85) !important;
}

/* ─── Settings tab content panel ─────────────────────────────── */
.wcu-settings-tab-content {
    background: rgba(20,16,10,0.5) !important;
    border: 1px solid rgba(204,197,147,0.15) !important;
    border-top: none !important;
    padding: 28px !important;
    color: rgba(240,235,225,0.82) !important;
}
.wcu-settings-tab-content h2,
.wcu-settings-tab-content h3,
.wcu-settings-tab-content h4 {
    font-size: 12px !important;
    letter-spacing: 0.24em !important;
    text-transform: uppercase !important;
    color: rgba(204,197,147,0.85) !important;
    font-weight: 500 !important;
    margin: 0 0 20px 0 !important;
    text-align: left !important;
    font-family: inherit !important;
    font-style: normal !important;
    border-bottom: 1px solid rgba(204,197,147,0.12) !important;
    padding-bottom: 10px !important;
}
.wcu-settings-tab-content label {
    font-size: 12px !important;
    letter-spacing: 0.12em !important;
    text-transform: uppercase !important;
    color: rgba(240,235,225,0.75) !important;
    font-weight: 500 !important;
    display: block !important;
    margin-bottom: 8px !important;
}
.wcu-settings-tab-content p {
    font-size: 13px !important;
    color: rgba(240,235,225,0.72) !important;
    line-height: 1.6 !important;
    text-align: left !important;
}

/* ─── PAYOUT METHOD DROPDOWN — CUSTOM LUXURY SELECT ──────────── */
select#wcu-payout-type,
select[name="payouttype"],
.wcu-settings-tab-content select,
.wcu-settings-tab-pane select {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-color: rgba(20,16,10,0.92) !important;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ccc593' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 14px center !important;
    background-size: 14px !important;
    color: rgba(240,235,225,0.95) !important;
    border: 1px solid rgba(204,197,147,0.35) !important;
    border-radius: 3px !important;
    padding: 12px 42px 12px 18px !important;
    font-size: 13px !important;
    letter-spacing: 0.1em !important;
    min-width: 260px !important;
    cursor: pointer !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
    font-family: inherit !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
    display: inline-block !important;
    color-scheme: dark !important;
}
select#wcu-payout-type:hover, .wcu-settings-tab-content select:hover {
    border-color: rgba(204,197,147,0.65) !important;
}
select#wcu-payout-type:focus, .wcu-settings-tab-content select:focus {
    border-color: rgba(204,197,147,0.95) !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(204,197,147,0.12) !important;
}
select#wcu-payout-type option, .wcu-settings-tab-content select option {
    background: #0f0c08 !important;
    color: rgba(240,235,225,0.95) !important;
    padding: 10px !important;
}

/* ─── "Stripe" label / payout type sublabel below dropdown ──── */
.wcu-payout-type-paypal,
.wcu-payout-type-paypalapi,
.wcu-payout-type-banktransfer,
.wcu-payout-type-stripeapi,
.wcu-payout-type-credit,
.wcu-payout-type-custom1,
.wcu-payout-type-custom2,
.wcu-payout-type-wisebank {
    margin-top: 16px !important;
    padding: 16px 20px !important;
    background: rgba(20,16,10,0.45) !important;
    border: 1px solid rgba(204,197,147,0.15) !important;
    border-radius: 3px !important;
}

/* ─── Catch orphaned text like standalone "Stripe" label ───── */
.wcu-settings-tab-content strong,
.wcu-settings-tab-content em,
.wcu-payout-selected-method {
    font-size: 11px !important;
    letter-spacing: 0.22em !important;
    text-transform: uppercase !important;
    color: rgba(204,197,147,0.7) !important;
    font-weight: 500 !important;
    font-style: normal !important;
    display: inline-block !important;
    margin-top: 10px !important;
}

/* ─── Inputs inside settings (Stripe account, PayPal email, etc.) ─ */
.wcu-settings-tab-content input[type="text"],
.wcu-settings-tab-content input[type="email"],
.wcu-settings-tab-content input[type="url"],
.wcu-settings-tab-content input[type="number"],
.wcu-settings-tab-content input[type="tel"],
.wcu-settings-tab-content textarea {
    background: rgba(20,16,10,0.92) !important;
    color: rgba(240,235,225,0.9) !important;
    border: 1px solid rgba(204,197,147,0.28) !important;
    border-radius: 3px !important;
    padding: 10px 14px !important;
    font-size: 13px !important;
    width: 100% !important;
    max-width: 440px !important;
    box-sizing: border-box !important;
    font-family: inherit !important;
}
.wcu-settings-tab-content input:focus,
.wcu-settings-tab-content textarea:focus {
    border-color: rgba(204,197,147,0.7) !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(204,197,147,0.1) !important;
}

/* ─── Save Changes button ─────────────────────────────────── */
#wcu-settings-update-button,
.wcu-settings-tab-content input[type="submit"],
.wcu-settings-tab-content button[type="submit"],
button#wcu-settings-update-button {
    background: rgba(204,197,147,0.92) !important;
    color: #0f0c08 !important;
    border: 1px solid rgba(204,197,147,1) !important;
    padding: 13px 34px !important;
    font-size: 11px !important;
    letter-spacing: 0.26em !important;
    text-transform: uppercase !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    transition: all 0.25s ease !important;
    border-radius: 2px !important;
    margin-top: 24px !important;
    font-family: inherit !important;
}
#wcu-settings-update-button:hover {
    background: rgba(204,197,147,1) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(204,197,147,0.2) !important;
}

/* ─── Top corner "Affiliate Dashboard" / "Logout" blue links ──── */
.dropdown-content a,
.welcome-header .dropdown-content a,
.content-header .dropdown-content a {
    font-size: 11px !important;
    letter-spacing: 0.2em !important;
    text-transform: uppercase !important;
    color: rgba(204,197,147,0.85) !important;
    background: transparent !important;
}
.dropdown-content a:hover {
    color: rgba(204,197,147,1) !important;
}

/* ─── Fontawesome icons in nav ──────────────────────────────── */
button.ml_wcutablinks i,
.dropdown-content a i {
    color: rgba(204,197,147,0.8) !important;
    margin-right: 6px !important;
    font-size: 11px !important;
}


/* ─── Kill Cormorant serif on inline strong/em in settings tabs ─ */
.wcu-settings-tab-content strong,
.wcu-settings-tab-content em,
.wcu-settings-tab-pane strong,
.wcu-settings-tab-pane em,
.wcu-payout-type-section strong,
.wcu-payout-type-section em {
    font-family: inherit !important;
    font-style: normal !important;
    font-size: 11px !important;
    letter-spacing: 0.22em !important;
    text-transform: uppercase !important;
    color: rgba(204,197,147,0.85) !important;
    font-weight: 600 !important;
    display: inline-block !important;
    margin: 8px 0 !important;
}

</style>
    <?php
}

/* ============================================================
   COLIBRI #CONTENT DARK BG — professional/affiliate pages
   2026-04-17
   Pages: golden-account (64453), vendor-membership (3918),
   affiliate-registration (63619), affiliate-dashboard-2 (71222),
   multi-level-affiliate (71558), booking-pro-panel (54778),
   professional-space (20), vip-partner-or-vip-driver (3919)
   ============================================================ */
add_action( 'wp_footer', 'rg_colibri_content_dark', 99999 );
function rg_colibri_content_dark() {
    $dark_page_ids = [ 64453, 3918, 63619, 71222, 71558, 54778, 20, 3919 ];
    if ( ! is_page( $dark_page_ids ) ) return;
    ?>
<style id="rg-colibri-content-dark">

/* ─── Override Colibri #content light background ─────────────── */
#content,
.h-section#content,
[id="content"] {
    background-color: #0f0c08 !important;
    background-image: none !important;
}

/* ─── Override Colibri #about section if light ───────────────── */
#about,
.h-section#about {
    background-color: #0f0c08 !important;
}

/* ─── Body text — dark-on-light default → cream on dark ──────── */
#content p,
#content li,
#content td,
#content th,
#content label,
#content span:not([class*="icon"]):not([class*="btn"]) {
    color: rgba(240,235,225,0.82) !important;
}

/* ─── Headings → champagne gold ──────────────────────────────── */
#content h1,
#content h2,
#content h3,
#content h4,
#content h5,
#content h6 {
    color: rgba(204,197,147,0.95) !important;
}

/* ─── Links inside content ───────────────────────────────────── */
#content a:not([class*="btn"]):not([class*="button"]) {
    color: rgba(204,197,147,0.85) !important;
}
#content a:hover:not([class*="btn"]):not([class*="button"]) {
    color: rgba(204,197,147,1) !important;
}

/* ─── Cards, panels, boxes inside content ───────────────────── */
#content .card,
#content .panel,
#content [class*="box"],
#content [class*="pricing"],
#content [class*="plan-"] {
    background: rgba(20,16,10,0.7) !important;
    border: 1px solid rgba(204,197,147,0.18) !important;
    color: rgba(240,235,225,0.82) !important;
}

/* ─── Buttons inside content ─────────────────────────────────── */
#content .btn,
#content .button,
#content [class*="btn-primary"],
#content a.button,
#content input[type="submit"] {
    background: rgba(204,197,147,0.85) !important;
    color: #0f0c08 !important;
    border: none !important;
}
#content .btn:hover,
#content .button:hover,
#content a.button:hover {
    background: rgba(204,197,147,1) !important;
}

/* ─── WCFM vendor plan cards (vendor-membership page) ───────── */
#content .wcfm_membership_plan,
#content .wcfm-membership-plan,
#content [class*="wcfm_plan"],
#content .plan_features,
#content .wc_membership_plan {
    background: rgba(20,16,10,0.8) !important;
    border: 1px solid rgba(204,197,147,0.25) !important;
    color: rgba(240,235,225,0.85) !important;
}
#content .wcfm_membership_plan h2,
#content .wcfm_membership_plan h3,
#content .wcfm_membership_plan .plan-price,
#content [class*="wcfm_plan"] h2,
#content [class*="wcfm_plan"] .price {
    color: rgba(204,197,147,1) !important;
}

</style>
    <?php
}


add_action( 'wp_footer', 'rg_home_redesign', 99999 );
function rg_home_redesign() {
    ?>
    <style id="rg-home-redesign">
    /* ══ HOME PAGE REDESIGN v1.0 (2026-04-17) — full dark luxury ══ */

    /* ─── Section c2: kill white overlay, go dark ────────────── */
    #colibri [data-colibri-id="61860-c2"] {
        background-color: #0a0a0a !important;
        background-image: none !important;
    }
    #colibri [data-colibri-id="61860-c2"] .overlay-image-layer {
        background-color: transparent !important;
        background-image: none !important;
        opacity: 0 !important;
    }
    #colibri [data-colibri-id="61860-c2"] .background-layer {
        background-color: #0a0a0a !important;
    }

    /* ─── Row c3: kill the legacy transportation bg image ────── */
    #colibri [data-colibri-id="61860-c3"] .background-layer.paraxify {
        background-image: none !important;
    }
    #colibri [data-colibri-id="61860-c3"] {
        background-color: #0a0a0a !important;
    }

    /* ─── "Private Driver on Driver" tagline: smaller, gold ──── */
    #colibri [data-colibri-id="61860-c2"] .h-heading h1,
    #colibri [data-colibri-id="61860-c2"] .h-heading h2,
    #colibri [data-colibri-id="61860-c2"] .h-heading h3,
    #colibri [data-colibri-id="61860-c2"] .h-heading h4,
    #colibri [data-colibri-id="61860-c2"] .h-heading {
        font-size: clamp(14px, 2vw, 20px) !important;
        line-height: 1.35 !important;
        color: rgba(204,197,147,0.85) !important;
        letter-spacing: 0.04em !important;
    }

    /* ─── Step icons → gold circles ──────────────────────────── */
    #colibri [data-colibri-id="61860-c5"],
    #colibri [data-colibri-id="61860-c10"],
    #colibri [data-colibri-id="61860-c15"],
    #colibri [data-colibri-id="61860-c2"] .h-icon {
        width: 52px !important;
        height: 52px !important;
        min-width: 52px !important;
        min-height: 52px !important;
        border-radius: 50% !important;
        background: rgba(204,197,147,0.08) !important;
        border: 1px solid rgba(204,197,147,0.35) !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 auto 12px !important;
    }
    #colibri [data-colibri-id="61860-c5"] svg,
    #colibri [data-colibri-id="61860-c10"] svg,
    #colibri [data-colibri-id="61860-c15"] svg,
    #colibri [data-colibri-id="61860-c2"] .h-icon svg {
        width: 22px !important;
        height: 22px !important;
        color: rgba(204,197,147,0.85) !important;
        fill: rgba(204,197,147,0.85) !important;
    }

    /* ─── Step label text: small caps gold ───────────────────── */
    #colibri [data-colibri-id="61860-c6"],
    #colibri [data-colibri-id="61860-c11"],
    #colibri [data-colibri-id="61860-c16"],
    #colibri [data-colibri-id="61860-c2"] .h-heading {
        color: rgba(204,197,147,0.88) !important;
        font-size: 11px !important;
        letter-spacing: 0.14em !important;
        text-transform: uppercase !important;
        font-family: 'Inter', sans-serif !important;
    }

    /* ─── Step body text: cream, compact ─────────────────────── */
    #colibri [data-colibri-id="61860-c8"] p,
    #colibri [data-colibri-id="61860-c13"] p,
    #colibri [data-colibri-id="61860-c18"] p,
    #colibri [data-colibri-id="61860-c2"] .h-text p {
        color: rgba(190,183,143,0.6) !important;
        font-size: 11px !important;
        line-height: 1.55 !important;
    }

    /* ─── Step divider lines: subtle gold ────────────────────── */
    #colibri [data-colibri-id="61860-c2"] .h-divider__line {
        background: rgba(204,197,147,0.15) !important;
        border-color: rgba(204,197,147,0.15) !important;
    }

    /* ─── City destination grid row: dark bg ─────────────────── */
    #colibri [data-colibri-id="61860-c19"],
    #colibri [data-colibri-id="61860-c19"] .background-wrapper {
        background-color: #0a0a0a !important;
        background-image: none !important;
    }

    /* ─── City cards: dark glass (style-2217 + style-2220) ───── */
    #colibri .style-2217,
    #colibri .style-2220 {
        background: rgba(14,11,7,0.85) !important;
        border: 1px solid rgba(204,197,147,0.2) !important;
        border-radius: 3px !important;
        transition: border-color 0.25s, background 0.25s !important;
    }
    #colibri .style-2217:hover,
    #colibri .style-2220:hover {
        border-color: rgba(204,197,147,0.5) !important;
        background: rgba(20,16,10,0.9) !important;
    }

    /* ─── City card icon container (airplane): gold circle ───── */
    #colibri .style-2036,
    #colibri .style-588,
    #colibri .style-259 {
        background: rgba(204,197,147,0.08) !important;
        border: 1px solid rgba(204,197,147,0.25) !important;
        border-radius: 50% !important;
        width: 60px !important;
        height: 60px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 auto 12px !important;
    }
    #colibri .style-2036 svg,
    #colibri .style-588 svg,
    #colibri .style-259 svg {
        width: 26px !important;
        height: 26px !important;
        color: rgba(204,197,147,0.85) !important;
        fill: rgba(204,197,147,0.85) !important;
    }

    /* ─── City name text: cream white ────────────────────────── */
    #colibri [data-colibri-id="61860-c19"] .h-text p,
    #colibri [data-colibri-id="61860-c19"] .h-heading,
    #colibri [data-colibri-id="61860-c21"] p,
    #colibri .style-2217 .h-text p,
    #colibri .style-2220 .h-text p {
        color: rgba(230,225,210,0.9) !important;
        font-size: 13px !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        font-family: 'Inter', sans-serif !important;
    }

    /* ─── BOOK buttons: gold ghost outline ───────────────────── */
    #colibri [data-colibri-id="61860-c19"] .h-button a,
    #colibri [data-colibri-id="61860-c19"] .h-button span,
    #colibri [data-colibri-id="61860-c80"] .h-button a,
    #colibri [data-colibri-id="61860-c80"] .h-button span,
    #colibri .style-2217 .h-button a,
    #colibri .style-2220 .h-button a {
        background: rgba(204,197,147,0.08) !important;
        border: 1px solid rgba(204,197,147,0.45) !important;
        color: rgba(204,197,147,0.9) !important;
        border-radius: 2px !important;
        font-size: 10px !important;
        letter-spacing: 0.16em !important;
        text-transform: uppercase !important;
        padding: 7px 18px !important;
        transition: all 0.22s ease !important;
    }
    #colibri [data-colibri-id="61860-c19"] .h-button a:hover,
    #colibri .style-2217 .h-button a:hover,
    #colibri .style-2220 .h-button a:hover {
        background: rgba(204,197,147,0.18) !important;
        border-color: rgba(204,197,147,0.85) !important;
        color: rgba(204,197,147,1) !important;
    }

    /* ─── Kill blue borders on city cards (Colibri default) ──── */
    #colibri [data-colibri-id="61860-c19"] [class*="h-column"] {
        border-color: transparent !important;
        outline: none !important;
        box-shadow: none !important;
    }

    /* ─── Step column separator lines ────────────────────────── */
    #colibri [data-colibri-id="61860-c4"],
    #colibri [data-colibri-id="61860-c9"],
    #colibri [data-colibri-id="61860-c14"] {
        border-right: 1px solid rgba(204,197,147,0.12) !important;
        text-align: center !important;
    }

    /* ─── Entire c2 section text: make dark bg consistent ────── */
    #colibri [data-colibri-id="61860-c2"] .h-row-container {
        background-color: transparent !important;
        background-image: none !important;
    }
    #colibri [data-colibri-id="61860-c2"] .overlay-layer {
        display: none !important;
    }
    
    /* ─── MOBILE: 3 hero cards (Airport/Chauffeur/VIP) — v6 ──── */
    /* Icons pinned left (absolute), text centered in full card,     */
    /* line-height 1.4, gap halved to 3px, column padding killed so  */
    /* cards reach ~4px from phone edges. Group pulled up -110px.    */
    @media (max-width: 767px) {
        /* Pull animation + cards up (-60 from v5 + another -50) */
        #colibri [data-colibri-id="61861-h28"] {
            margin-top: -110px !important;
        }
        /* Kill column (h27) horizontal padding so cards extend wider */
        #colibri [data-colibri-id="61861-h27"] {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        /* Container: 4px side gutter, 3px vertical gap */
        #colibri .h-x-container-inner.style-dynamic-61861-h29-group {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            justify-content: center !important;
            gap: 3px !important;
            padding: 14px 4px !important;
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }
        /* Card outer: full width of container */
        #colibri .h-x-container-inner.style-dynamic-61861-h29-group > .h-button__outer {
            display: flex !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            flex: 0 0 auto !important;
            box-sizing: border-box !important;
        }
        /* Card link: position:relative so icon can absolute-pin left.  */
        /* Left padding reserves room for the icon; text centers in card.*/
        #colibri a[data-colibri-id="61861-h30"].h-button,
        #colibri a[data-colibri-id="61861-h31"].h-button,
        #colibri a[data-colibri-id="61861-h32"].h-button,
        #colibri a.h-button.style-local-61861-h30,
        #colibri a.h-button.style-local-61861-h31,
        #colibri a.h-button.style-local-61861-h32 {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            margin: 0 !important;
            padding: 12px 18px 12px 54px !important;
            box-sizing: border-box !important;
        }
        /* Icon pinned to left edge of card, vertically centered */
        #colibri a.h-button.style-local-61861-h30 > .h-svg-icon.h-button__icon,
        #colibri a.h-button.style-local-61861-h31 > .h-svg-icon.h-button__icon,
        #colibri a.h-button.style-local-61861-h32 > .h-svg-icon.h-button__icon {
            position: absolute !important;
            left: 16px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            margin: 0 !important;
            flex: 0 0 auto !important;
        }
        /* Text span: takes full width, centered, 1.4 line-height */
        #colibri a.h-button.style-local-61861-h30 > span:not(.h-svg-icon),
        #colibri a.h-button.style-local-61861-h31 > span:not(.h-svg-icon),
        #colibri a.h-button.style-local-61861-h32 > span:not(.h-svg-icon) {
            display: block !important;
            width: 100% !important;
            min-width: 0 !important;
            text-align: center !important;
            line-height: 1.4 !important;
            white-space: normal !important;
            overflow-wrap: normal !important;
            word-break: normal !important;
        }
    }

    </style>
    <?php
}


add_action( 'wp_footer', 'rg_amelia_persons_extras_css', 99999 );
function rg_amelia_persons_extras_css() {
    ?>
    <style id="rg-amelia-persons-extras">
    /* ══ PERSONS + EXTRAS STEP — DARK LUXURY (2026-04-17) — #68 ══
       Fixes: invisible passenger/suitcase counters (el-input-number)
       ═══════════════════════════════════════════════════════════════ */

    /* ─── Step wrapper backgrounds ─────────────────────────────── */
    .amelia-v2-booking .am-fs-p,
    .amelia-v2-booking .am-fs-p__wrapper,
    .amelia-v2-booking .am-extras,
    .amelia-v2-booking .am-extras__wrapper,
    .amelia-v2-booking [class*="am-fs-p"],
    .amelia-v2-booking [class*="am-extras"] {
        background: transparent !important;
        color: rgba(220,213,170,0.9) !important;
    }

    /* ─── Person / extra item rows ──────────────────────────────── */
    .amelia-v2-booking .am-fs-p__item,
    .amelia-v2-booking .am-extras__item,
    .amelia-v2-booking [class*="am-fs-p__item"],
    .amelia-v2-booking [class*="am-extras__item"] {
        background: rgba(20,16,10,0.7) !important;
        border: 1px solid rgba(204,197,147,0.15) !important;
        border-radius: 3px !important;
        color: rgba(220,213,170,0.9) !important;
    }
    .amelia-v2-booking .am-fs-p__item:hover,
    .amelia-v2-booking .am-extras__item:hover {
        border-color: rgba(204,197,147,0.3) !important;
    }

    /* ─── Item label / name text ────────────────────────────────── */
    .amelia-v2-booking .am-fs-p__item-name,
    .amelia-v2-booking .am-extras__item-name,
    .amelia-v2-booking .am-fs-p__item-label,
    .amelia-v2-booking .am-extras__item-label,
    .amelia-v2-booking [class*="am-fs-p__item-name"],
    .amelia-v2-booking [class*="am-extras__item-name"] {
        color: rgba(220,213,170,0.88) !important;
        font-size: 13px !important;
        letter-spacing: 0.04em !important;
    }

    /* ─── Item description / sub-label ─────────────────────────── */
    .amelia-v2-booking .am-fs-p__item-desc,
    .amelia-v2-booking .am-extras__item-desc,
    .amelia-v2-booking [class*="item-desc"],
    .amelia-v2-booking [class*="item-info"] {
        color: rgba(175,168,130,0.6) !important;
        font-size: 11px !important;
    }

    /* ─── El-UI input-number: the +/- counter ───────────────────── */
    .amelia-v2-booking .el-input-number {
        background: transparent !important;
        border: 1px solid rgba(204,197,147,0.3) !important;
        border-radius: 2px !important;
        overflow: hidden !important;
    }

    /* THE INVISIBLE NUMBER — this is the root cause ──────────────── */
    .amelia-v2-booking .el-input-number__inner,
    .amelia-v2-booking .el-input-number input {
        background: rgba(14,11,7,0.9) !important;
        color: rgba(220,213,170,0.95) !important;
        border: none !important;
        font-size: 15px !important;
        font-weight: 500 !important;
        text-align: center !important;
    }

    /* Decrease (−) and Increase (+) buttons ─── BRIGHT for visibility
       Design rule: never dark-on-dark. Champagne fill on dark card. */
    .amelia-v2-booking .el-input-number__decrease,
    .amelia-v2-booking .el-input-number__increase {
        background: rgba(204,197,147,0.28) !important;
        border-color: rgba(204,197,147,0.55) !important;
        color: rgba(240,233,200,1) !important;
        font-size: 18px !important;
        font-weight: 600 !important;
    }
    .amelia-v2-booking .el-input-number__decrease:hover,
    .amelia-v2-booking .el-input-number__increase:hover {
        background: rgba(204,197,147,0.55) !important;
        border-color: rgba(204,197,147,0.85) !important;
        color: #1a1a1a !important;
    }
    .amelia-v2-booking .el-input-number__decrease.is-disabled,
    .amelia-v2-booking .el-input-number__increase.is-disabled {
        background: rgba(204,197,147,0.06) !important;
        border-color: rgba(204,197,147,0.15) !important;
        color: rgba(204,197,147,0.25) !important;
        cursor: not-allowed !important;
    }
    /* Inline SVG icons inside the +/− buttons — ensure stroke matches */
    .amelia-v2-booking .el-input-number__decrease svg,
    .amelia-v2-booking .el-input-number__increase svg,
    .amelia-v2-booking .el-input-number__decrease i,
    .amelia-v2-booking .el-input-number__increase i {
        color: inherit !important;
        fill: currentColor !important;
        stroke: currentColor !important;
    }

    /* ─── Amelia's own counter component (am-counter) ───────────── */
    .amelia-v2-booking .am-counter,
    .amelia-v2-booking [class*="am-counter"] {
        background: rgba(14,11,7,0.9) !important;
        border: 1px solid rgba(204,197,147,0.3) !important;
        border-radius: 2px !important;
    }
    .amelia-v2-booking .am-counter__input,
    .amelia-v2-booking [class*="am-counter__input"] {
        color: rgba(220,213,170,0.95) !important;
        background: transparent !important;
        font-size: 15px !important;
        font-weight: 500 !important;
    }
    .amelia-v2-booking .am-counter__button,
    .amelia-v2-booking [class*="am-counter__button"] {
        background: rgba(204,197,147,0.08) !important;
        color: rgba(204,197,147,0.85) !important;
        border-color: rgba(204,197,147,0.2) !important;
    }
    .amelia-v2-booking .am-counter__button:hover {
        background: rgba(204,197,147,0.18) !important;
        color: rgba(204,197,147,1) !important;
    }

    /* ─── Extra item price tag ──────────────────────────────────── */
    .amelia-v2-booking .am-extras__item-price,
    .amelia-v2-booking [class*="extras__item-price"] {
        color: rgba(204,197,147,0.75) !important;
        font-size: 12px !important;
    }

    /* ─── Section heading ("Passengers", "Extras", "Luggage") ───── */
    .amelia-v2-booking .am-fs-p__heading,
    .amelia-v2-booking .am-extras__heading,
    .amelia-v2-booking [class*="am-fs-p__heading"],
    .amelia-v2-booking [class*="am-extras__heading"] {
        color: rgba(190,183,143,0.65) !important;
        font-size: 10px !important;
        letter-spacing: 0.14em !important;
        text-transform: uppercase !important;
    }

    /* ─── El-UI slider (if used for quantity) ───────────────────── */
    .amelia-v2-booking .el-slider__runway {
        background: rgba(204,197,147,0.12) !important;
    }
    .amelia-v2-booking .el-slider__bar {
        background: rgba(204,197,147,0.6) !important;
    }
    .amelia-v2-booking .el-slider__button {
        background: rgba(204,197,147,0.9) !important;
        border-color: rgba(204,197,147,0.9) !important;
    }

    /* ─── Global: any plain input in wizard (belt + suspenders) ─── */
    .amelia-v2-booking input[type="number"],
    .amelia-v2-booking input[type="text"]:not([readonly]) {
        color: rgba(220,213,170,0.92) !important;
        background: rgba(14,11,7,0.85) !important;
        border-color: rgba(204,197,147,0.25) !important;
    }

    /* ═══ Wizard modal WIDTH (desktop) ═════════════════════════════
       Daniel: "make it wider on desktop, see how you've got one but
       you can't make it into two or three because you can't see the
       plus sign". Default Amelia wizard is ~640px — too narrow for
       Persons + Extras rows with description + counter.
       ──────────────────────────────────────────────────────────── */
    @media (min-width: 1024px) {
        .amelia-v2-booking,
        .amelia-v2-booking .am-sfc,
        .amelia-v2-booking .am-sfc__content,
        .amelia-v2-booking .am-sfc__wrapper,
        .amelia-v2-booking .am-fs-c,
        .amelia-v2-booking .am-fs-c__content,
        .amelia-v2-booking .am-bw,
        .amelia-v2-booking .am-bw__content,
        .amelia-v2-booking .am-bwc,
        .amelia-v2-booking .am-bwc__content,
        .amelia-v2-booking [class*="am-sfc__content"],
        .amelia-v2-booking [class*="am-fs-c__content"],
        .amelia-v2-booking [class*="am-bw__content"] {
            max-width: 1080px !important;
            width: 92% !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        /* Two columns for Persons + Extras rows on desktop */
        .amelia-v2-booking .am-fs-p__list,
        .amelia-v2-booking .am-extras__list,
        .amelia-v2-booking [class*="am-fs-p__list"],
        .amelia-v2-booking [class*="am-extras__list"] {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 14px !important;
        }
        /* Give each row enough breathing room for name + desc + counter */
        .amelia-v2-booking .am-fs-p__item,
        .amelia-v2-booking .am-extras__item {
            padding: 16px 18px !important;
            min-height: 96px !important;
        }
    }
    @media (min-width: 1280px) {
        .amelia-v2-booking .am-fs-p__list,
        .amelia-v2-booking .am-extras__list,
        .amelia-v2-booking [class*="am-fs-p__list"],
        .amelia-v2-booking [class*="am-extras__list"] {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }

    /* ═══ "Learn More" toggle — force its own line ═════════════════
       Daniel: "learn more — why is that squashed with 'usually means?'"
       Amelia renders the toggle as an inline anchor inside the desc
       block, so it collides with the description text. Break it out.
       ──────────────────────────────────────────────────────────── */
    .amelia-v2-booking .am-extras__item-desc a,
    .amelia-v2-booking .am-extras__item-desc button,
    .amelia-v2-booking .am-fs-p__item-desc a,
    .amelia-v2-booking .am-fs-p__item-desc button,
    .amelia-v2-booking [class*="item-desc"] a,
    .amelia-v2-booking [class*="item-desc"] button,
    .amelia-v2-booking [class*="show-more"],
    .amelia-v2-booking [class*="read-more"],
    .amelia-v2-booking [class*="learn-more"],
    .amelia-v2-booking [class*="am-collapse__toggle"] {
        display: inline-block !important;
        margin-top: 8px !important;
        padding: 4px 0 !important;
        font-size: 11px !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
        color: rgba(204,197,147,0.85) !important;
        text-decoration: none !important;
        border-bottom: 1px solid rgba(204,197,147,0.35) !important;
        clear: both !important;
    }
    .amelia-v2-booking .am-extras__item-desc,
    .amelia-v2-booking .am-fs-p__item-desc,
    .amelia-v2-booking [class*="item-desc"] {
        display: block !important;
        line-height: 1.55 !important;
    }
    /* The description text node itself — give the toggle room below */
    .amelia-v2-booking .am-extras__item-desc > span:first-child,
    .amelia-v2-booking .am-fs-p__item-desc > span:first-child,
    .amelia-v2-booking [class*="item-desc"] > span:first-child {
        display: block !important;
        margin-bottom: 4px !important;
    }
    </style>
    <?php
}

/* ============================================================================
 * UM Login Page — Dark Luxury Redesign  (/login-2/, form 73396)
 * Problem: white card, invisible pale labels, invisible "Forgot password",
 *          dark-on-dark input text, default blue Sign In button.
 * Fix: scoped to body.um-page-loginregister and .um-73396 — does not touch
 *      the professional dashboard behind the login (out of scope per user).
 * ========================================================================= */
add_action( 'wp_footer', 'rg_um_login_redesign', 99999 );
function rg_um_login_redesign() {
    if ( ! is_page( array( 'login-2', 73400 ) ) ) return;
    ?>
    <style id="rg-um-login-redesign">
    /* Page background — dark */
    html:has(.um-73396), html:has(.um-73396) body { background-color: #0a0a0a !important; }
    html:has(.um-73396) .overlay-image-layer { background-image: none !important; background-color: transparent !important; opacity: 0 !important; }

    /* Card shell — dark glass */
    .um.um-73396,
    .um.um-login,
    body .um.um-73396 .um-form,
    body .um.um-login .um-form {
        background: rgba(14,11,7,0.88) !important;
        backdrop-filter: blur(28px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(28px) saturate(180%) !important;
        border: 1px solid rgba(204,197,147,0.22) !important;
        border-radius: 12px !important;
        padding: 44px 40px !important;
        max-width: 440px !important;
        margin: 60px auto !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5) !important;
    }

    /* Heading + subheading */
    .um.um-73396 h1, .um.um-73396 h2, .um.um-73396 h3,
    .um.um-73396 .um-header,
    .um.um-73396 .um-profile-title,
    .um.um-73396 .um-register-header,
    .um.um-73396 .um-login-header,
    .um.um-73396 .card-title {
        color: rgba(220,213,170,0.95) !important;
        font-family: 'Cormorant Garamond', serif !important;
        font-size: 26px !important;
        font-weight: 400 !important;
        letter-spacing: 0.02em !important;
        text-align: center !important;
        margin-bottom: 8px !important;
    }
    .um.um-73396 p, .um.um-73396 .um-subheader, .um.um-73396 .um-description {
        color: rgba(220,213,170,0.7) !important;
        font-size: 13px !important;
        text-align: center !important;
        margin-bottom: 28px !important;
    }

    /* Field labels (Email or Username, Password) */
    .um.um-73396 .um-field-label,
    .um.um-73396 label,
    .um.um-73396 .um-field label {
        color: rgba(220,213,170,0.92) !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        margin-bottom: 8px !important;
        display: block !important;
    }
    .um.um-73396 .um-field-label-required,
    .um.um-73396 .text-danger {
        color: rgba(204,197,147,0.9) !important;
    }

    /* Input fields — cream text on dark */
    .um.um-73396 input[type="text"],
    .um.um-73396 input[type="email"],
    .um.um-73396 input[type="password"],
    .um.um-73396 .um-form-field,
    .um.um-73396 .form-control {
        background: rgba(24,20,12,0.95) !important;
        color: rgba(220,213,170,0.95) !important;
        border: 1px solid rgba(204,197,147,0.25) !important;
        border-radius: 6px !important;
        padding: 14px 16px !important;
        font-size: 14px !important;
        height: auto !important;
        box-shadow: none !important;
    }
    .um.um-73396 input[type="text"]:focus,
    .um.um-73396 input[type="email"]:focus,
    .um.um-73396 input[type="password"]:focus,
    .um.um-73396 .form-control:focus {
        border-color: rgba(204,197,147,0.6) !important;
        outline: none !important;
        background: rgba(24,20,12,1) !important;
    }
    .um.um-73396 input::placeholder { color: rgba(220,213,170,0.35) !important; }

    /* Field spacing */
    .um.um-73396 .um-field,
    .um.um-73396 .um-form-row,
    .um.um-73396 .mb-3 {
        margin-bottom: 20px !important;
    }

    /* Icon prefix (envelope, padlock) */
    .um.um-73396 .um-field-icon,
    .um.um-73396 .input-group-text {
        color: rgba(204,197,147,0.7) !important;
        background: transparent !important;
        border-color: rgba(204,197,147,0.25) !important;
    }

    /* Submit button — gold, not blue */
    .um.um-73396 input[type="submit"],
    .um.um-73396 button[type="submit"],
    .um.um-73396 .um-button,
    .um.um-73396 .btn-primary,
    .um.um-73396 .uwp_login_submit {
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
        margin-top: 10px !important;
        transition: background 0.2s ease !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }
    .um.um-73396 input[type="submit"]:hover,
    .um.um-73396 button[type="submit"]:hover,
    .um.um-73396 .um-button:hover,
    .um.um-73396 .btn-primary:hover {
        background: rgba(220,213,170,1) !important;
        color: #0a0a0a !important;
    }

    /* Links — "Forgot password? Reset password" */
    .um.um-73396 a,
    .um.um-73396 a:link,
    .um.um-73396 a:visited,
    .um.um-73396 .um-form-row a,
    .um.um-73396 .um-alt a {
        color: rgba(204,197,147,0.85) !important;
        text-decoration: none !important;
        font-size: 12px !important;
        letter-spacing: 0.04em !important;
    }
    .um.um-73396 a:hover {
        color: rgba(220,213,170,1) !important;
        text-decoration: underline !important;
    }

    /* Bottom links row ("Forgot your password?" section) */
    .um.um-73396 .um-col-alt-b,
    .um.um-73396 .um-col-alt,
    .um.um-73396 .um-footer {
        text-align: center !important;
        margin-top: 22px !important;
        padding-top: 18px !important;
        border-top: 1px solid rgba(204,197,147,0.12) !important;
    }

    /* Eye icon toggle for password visibility */
    .um.um-73396 .fa-eye, .um.um-73396 .fa-eye-slash {
        color: rgba(204,197,147,0.7) !important;
    }
    </style>
    <?php
}

/* ============================================================================
 * WPForms Contact/Support — Dark Luxury Contrast Fix
 * Daniel: "In support also we can not read, as well."
 * Page: /contact-us-2/ (and any page rendering WPForms).
 * Scope: html:has(.wpforms-container) — only activates where WPForms renders.
 * ========================================================================= */
add_action( 'wp_footer', 'rg_wpforms_contrast_css', 99999 );
function rg_wpforms_contrast_css() {
    ?>
    <style id="rg-wpforms-contrast">
    /* Page bg on any page with WPForms */
    html:has(.wpforms-container), html:has(.wpforms-container) body {
        background-color: #0a0a0a !important;
    }
    html:has(.wpforms-container) .overlay-image-layer {
        background-image: none !important;
        background-color: transparent !important;
        opacity: 0 !important;
    }

    /* Form container as dark glass card */
    .wpforms-container,
    .wpforms-container-full,
    div.wpforms-container-full .wpforms-form {
        background: rgba(14,11,7,0.88) !important;
        backdrop-filter: blur(20px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
        border: 1px solid rgba(204,197,147,0.2) !important;
        border-radius: 12px !important;
        padding: 40px 36px !important;
        max-width: 640px !important;
        margin: 40px auto !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.45) !important;
    }

    /* Field labels */
    .wpforms-field-label,
    .wpforms-container .wpforms-field-label,
    div.wpforms-container-full .wpforms-form .wpforms-field-label {
        color: rgba(220,213,170,0.92) !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        margin-bottom: 8px !important;
        display: block !important;
    }

    /* Sub-labels (First / Last under name field) */
    .wpforms-field-sublabel,
    .wpforms-container .wpforms-field-sublabel,
    div.wpforms-container-full .wpforms-form .wpforms-field-sublabel {
        color: rgba(220,213,170,0.55) !important;
        font-size: 11px !important;
        letter-spacing: 0.04em !important;
    }

    /* Required asterisk */
    .wpforms-required-label,
    .wpforms-field-label .wpforms-required-label {
        color: rgba(204,197,147,0.9) !important;
    }

    /* Text inputs, email, textarea */
    .wpforms-container input[type="text"],
    .wpforms-container input[type="email"],
    .wpforms-container input[type="tel"],
    .wpforms-container input[type="url"],
    .wpforms-container input[type="number"],
    .wpforms-container textarea,
    .wpforms-container select,
    div.wpforms-container-full .wpforms-form input[type="text"],
    div.wpforms-container-full .wpforms-form input[type="email"],
    div.wpforms-container-full .wpforms-form textarea,
    div.wpforms-container-full .wpforms-form select {
        background: rgba(24,20,12,0.95) !important;
        color: rgba(220,213,170,0.95) !important;
        border: 1px solid rgba(204,197,147,0.25) !important;
        border-radius: 6px !important;
        padding: 13px 16px !important;
        font-size: 14px !important;
        box-shadow: none !important;
    }
    .wpforms-container input:focus,
    .wpforms-container textarea:focus,
    .wpforms-container select:focus,
    div.wpforms-container-full .wpforms-form input:focus,
    div.wpforms-container-full .wpforms-form textarea:focus {
        border-color: rgba(204,197,147,0.6) !important;
        outline: none !important;
        background: rgba(24,20,12,1) !important;
    }
    .wpforms-container input::placeholder,
    .wpforms-container textarea::placeholder {
        color: rgba(220,213,170,0.35) !important;
    }

    /* Textarea specifically — more breathing room */
    .wpforms-container textarea,
    div.wpforms-container-full .wpforms-form textarea {
        min-height: 140px !important;
        resize: vertical !important;
    }

    /* Field spacing */
    .wpforms-field,
    .wpforms-container .wpforms-field {
        margin-bottom: 22px !important;
        padding: 0 !important;
    }

    /* Submit button — gold, not default */
    .wpforms-container button[type="submit"],
    .wpforms-container .wpforms-submit,
    .wpforms-container input[type="submit"],
    div.wpforms-container-full .wpforms-form button[type="submit"],
    div.wpforms-container-full .wpforms-form .wpforms-submit {
        background: rgba(204,197,147,0.95) !important;
        color: #0a0a0a !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 14px 32px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        margin-top: 8px !important;
        transition: background 0.2s ease !important;
        box-shadow: none !important;
        text-shadow: none !important;
        cursor: pointer !important;
    }
    .wpforms-container button[type="submit"]:hover,
    .wpforms-container .wpforms-submit:hover,
    div.wpforms-container-full .wpforms-form button[type="submit"]:hover,
    div.wpforms-container-full .wpforms-form .wpforms-submit:hover {
        background: rgba(220,213,170,1) !important;
        color: #0a0a0a !important;
    }

    /* Error messages */
    .wpforms-container label.wpforms-error,
    .wpforms-container .wpforms-error-message {
        color: rgba(220,120,110,0.95) !important;
        font-size: 11px !important;
        margin-top: 6px !important;
    }
    .wpforms-container input.wpforms-error,
    .wpforms-container textarea.wpforms-error {
        border-color: rgba(220,120,110,0.7) !important;
    }

    /* Success message after submit */
    .wpforms-confirmation-container-full,
    .wpforms-confirmation-container {
        background: rgba(14,11,7,0.9) !important;
        color: rgba(220,213,170,0.95) !important;
        border: 1px solid rgba(204,197,147,0.3) !important;
        border-radius: 8px !important;
        padding: 20px !important;
    }

    /* Any text links inside the form (privacy links etc) */
    .wpforms-container a,
    .wpforms-container a:link,
    .wpforms-container a:visited {
        color: rgba(204,197,147,0.85) !important;
        text-decoration: underline !important;
        text-underline-offset: 2px !important;
    }
    .wpforms-container a:hover { color: rgba(220,213,170,1) !important; }
    </style>
    <?php
}

add_action( 'wp_footer', 'rg_vip_area_typography', 99999 );
function rg_vip_area_typography() {
    ?>
    <style id="rg-vip-typography">
    /* ─ VIP client area: cap oversized Colibri headings on mobile ─ */
    /* Applies to booking, account, affiliate, membership pages.   */
    /* Rule: line-height = 1.25 (font-size × 1.25 per design req). */
    @media (max-width: 767px) {
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h1,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h1 a,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h1 span {
            font-size: clamp(28px, 7.5vw, 38px) !important;
            line-height: 1.25 !important;
            word-break: normal !important;
            hyphens: manual !important;
        }
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h2,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h2 a,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h2 span {
            font-size: clamp(24px, 6.5vw, 32px) !important;
            line-height: 1.25 !important;
            word-break: normal !important;
            hyphens: manual !important;
        }
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h3,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h3 a,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h3 span {
            font-size: clamp(20px, 5.5vw, 26px) !important;
            line-height: 1.25 !important;
        }
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h4,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h5,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .h-heading h6 {
            line-height: 1.25 !important;
        }
        /* Also cap naked h1/h2 inside page content for these pages */
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .page-content h1,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .content > h1 {
            font-size: clamp(28px, 7.5vw, 38px) !important;
            line-height: 1.25 !important;
        }
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .page-content h2,
        body:is(.page-id-44401, .page-id-73136, .page-id-64659, .page-id-54773, .page-id-67192, .page-id-73400, .page-id-73401, .page-id-73404, .page-id-73805, .page-id-73806, .page-id-73807, .page-id-4425, .page-id-73402, .page-id-61943, .page-id-69945, .page-id-69766, .page-id-67312, .page-id-66224, .page-id-3918, .page-id-20, .page-id-54778, .page-id-64453, .page-id-63619, .page-id-71558, .page-id-71222, .page-id-73098, .page-id-73550, .page-id-66394, .page-id-66360, .page-id-64533, .page-id-3919, .page-id-35876, .page-id-10382, .page-id-5163, .page-id-5572, .page-id-70698, .page-id-70679, .page-id-70680, .page-id-70681, .page-id-16) .content > h2 {
            font-size: clamp(24px, 6.5vw, 32px) !important;
            line-height: 1.25 !important;
        }
    }
    </style>
    <?php
}

add_action( 'wp_footer', 'rg_um_account_narrow_fields', 99999 );
function rg_um_account_narrow_fields() {
    ?>
    <style id="rg-um-account-narrow">
    /* ── UM Account form: cap field widths ───────────────────── */
    /* Problem: username/first/last/email fields span full column  */
    /* (~650px). Content is short ("Rod", email) so fields looked  */
    /* absurdly wide. Cap form container + inputs to sensible size.*/
    body.page-id-73404 .um .um-form,
    body.um-page-account .um .um-form,
    body.um-73407 .um-form,
    body.um-73396 .um-form {
        max-width: 560px !important;
        margin-left: auto !important;
        margin-right: 40px !important;
    }
    body.page-id-73404 .um .um-field input[type="text"],
    body.page-id-73404 .um .um-field input[type="email"],
    body.page-id-73404 .um .um-field input[type="password"],
    body.um-page-account .um .um-field input[type="text"],
    body.um-page-account .um .um-field input[type="email"],
    body.um-page-account .um .um-field input[type="password"],
    body.um-page-account .um .um-field-area,
    body.page-id-73404 .um .um-field-area {
        max-width: 480px !important;
        box-sizing: border-box !important;
    }
    /* Update-account button: left-aligned under the narrower form */
    body.page-id-73404 .um .um-form .um-col-alt,
    body.um-page-account .um .um-form .um-col-alt {
        max-width: 480px !important;
        text-align: left !important;
    }
    </style>
    <?php
}

/* ============================================================
 * Amelia Employee Panel login — dark luxury reskin
 * Page: /booking-pro-panel/ (id 54778) — staff login for drivers (Manny).
 * Default Amelia renders a white card with gold labels on white (unreadable).
 * Convert the card to match the dark luxury theme used on /login-2/.
 * ============================================================ */
add_action( 'wp_footer', 'rg_amelia_employee_login_reskin', 200 );
function rg_amelia_employee_login_reskin() {
    if ( ! is_page( 54778 ) ) return;
    ?>
    <style id="rg-amelia-employee-login">
    /* Card: dark glass, gold-tinted border */
    body.page-id-54778 .amelia-v2-booking .am-login,
    body.page-id-54778 .amelia-app-booking .am-login,
    body.page-id-54778 .am-login,
    body.page-id-54778 .am-auth {
        background: rgba(20,20,20,0.92) !important;
        border: 1px solid rgba(204,197,147,0.18) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5) !important;
        padding: 40px 36px !important;
        color: #E6E0C8 !important;
    }

    /* Inner wrapper: kill any white panel Amelia ships */
    body.page-id-54778 .am-auth > *,
    body.page-id-54778 .am-login > *,
    body.page-id-54778 .am-login .am-card,
    body.page-id-54778 .am-login .el-card,
    body.page-id-54778 .am-login .el-card__body {
        background: transparent !important;
        box-shadow: none !important;
        border: 0 !important;
        color: #E6E0C8 !important;
    }

    /* "Welcome Back" heading → WHITE (not the Element-Plus default blue-green) */
    body.page-id-54778 .am-login h1,
    body.page-id-54778 .am-login h2,
    body.page-id-54778 .am-login h3,
    body.page-id-54778 .am-login h4,
    body.page-id-54778 .am-auth h1,
    body.page-id-54778 .am-auth h2,
    body.page-id-54778 .am-auth h3,
    body.page-id-54778 .am-auth h4,
    body.page-id-54778 .am-login .am-title,
    body.page-id-54778 .am-auth .am-title,
    body.page-id-54778 .am-login [class*="title"],
    body.page-id-54778 .am-auth  [class*="title"] {
        color: #FFFFFF !important;
        font-family: 'Cormorant Garamond', 'Playfair Display', Georgia, serif !important;
        font-weight: 400 !important;
        letter-spacing: 0.02em !important;
    }

    /* Subtitle / description rows → white, dimmed */
    body.page-id-54778 .am-login p,
    body.page-id-54778 .am-auth p,
    body.page-id-54778 .am-login .am-description,
    body.page-id-54778 .am-auth .am-description {
        color: rgba(255,255,255,0.65) !important;
        font-weight: 300 !important;
    }

    /* Form labels — UPPERCASE, small, letter-spaced (gold-standard style) */
    body.page-id-54778 .am-login .el-form-item__label,
    body.page-id-54778 .am-auth .el-form-item__label,
    body.page-id-54778 .am-login label,
    body.page-id-54778 .am-auth label {
        color: rgba(230,224,200,0.85) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        letter-spacing: 0.12em !important;
        text-transform: uppercase !important;
        line-height: 1.4 !important;
        padding: 0 0 8px 0 !important;
        opacity: 1 !important;
    }
    /* Required asterisks stay visible red */
    body.page-id-54778 .am-login .el-form-item.is-required > .el-form-item__label:before,
    body.page-id-54778 .am-auth .el-form-item.is-required > .el-form-item__label:before {
        color: #E06B5A !important;
        margin-right: 4px !important;
    }

    /* Unified input wrapper — single dark pill (no detached icon box) */
    body.page-id-54778 .am-login .el-input,
    body.page-id-54778 .am-auth  .el-input {
        width: 100% !important;
        background: rgba(255,255,255,0.04) !important;
        border: 1px solid rgba(230,224,200,0.15) !important;
        border-radius: 8px !important;
        height: 50px !important;
        transition: border-color .2s ease, box-shadow .2s ease !important;
    }
    body.page-id-54778 .am-login .el-input.is-focus,
    body.page-id-54778 .am-auth  .el-input.is-focus,
    body.page-id-54778 .am-login .el-input:focus-within,
    body.page-id-54778 .am-auth  .el-input:focus-within {
        border-color: rgba(204,197,147,0.6) !important;
        box-shadow: 0 0 0 3px rgba(204,197,147,0.12) !important;
    }

    body.page-id-54778 .am-login .el-input__inner,
    body.page-id-54778 .am-auth  .el-input__inner,
    body.page-id-54778 .am-login input[type="text"],
    body.page-id-54778 .am-login input[type="email"],
    body.page-id-54778 .am-login input[type="password"],
    body.page-id-54778 .am-auth  input[type="text"],
    body.page-id-54778 .am-auth  input[type="email"],
    body.page-id-54778 .am-auth  input[type="password"] {
        background: transparent !important;
        border: 0 !important;
        color: #FFFFFF !important;
        height: 50px !important;
        line-height: 50px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif !important;
        font-size: 15px !important;
        padding: 0 16px !important;
        box-shadow: none !important;
    }
    body.page-id-54778 .am-login .el-input__inner:focus,
    body.page-id-54778 .am-auth  .el-input__inner:focus,
    body.page-id-54778 .am-login input:focus,
    body.page-id-54778 .am-auth  input:focus {
        outline: none !important;
        box-shadow: none !important;
    }
    body.page-id-54778 .am-login .el-input__inner::placeholder,
    body.page-id-54778 .am-auth  .el-input__inner::placeholder {
        color: rgba(255,255,255,0.3) !important;
    }

    /* Hide the prefix icon boxes (envelope / lock) — cleaner, matches gold standard */
    body.page-id-54778 .am-login .el-input__prefix,
    body.page-id-54778 .am-auth  .el-input__prefix,
    body.page-id-54778 .am-login .el-input__prefix-inner,
    body.page-id-54778 .am-auth  .el-input__prefix-inner,
    body.page-id-54778 .am-login .el-input__icon,
    body.page-id-54778 .am-auth  .el-input__icon {
        display: none !important;
    }

    /* Hide the noisy red "..." validation suffix badges inside input */
    body.page-id-54778 .am-login .el-input__suffix,
    body.page-id-54778 .am-auth  .el-input__suffix,
    body.page-id-54778 .am-login .el-input__suffix-inner,
    body.page-id-54778 .am-auth  .el-input__suffix-inner {
        display: none !important;
    }
    /* Keep actual error messages visible below the field */
    body.page-id-54778 .am-login .el-form-item__error,
    body.page-id-54778 .am-auth  .el-form-item__error {
        color: #E06B5A !important;
        font-size: 12px !important;
        padding-top: 4px !important;
    }

    /* Submit button: champagne fill, UPPERCASE Inter charbon text
       (design rule: all primary buttons use this treatment) */
    body.page-id-54778 .am-login .am-button--primary,
    body.page-id-54778 .am-login .am-button--filled,
    body.page-id-54778 .am-login .el-button--primary,
    body.page-id-54778 .am-login .el-button,
    body.page-id-54778 .am-auth  .am-button--primary,
    body.page-id-54778 .am-auth  .am-button--filled,
    body.page-id-54778 .am-auth  .el-button--primary,
    body.page-id-54778 .am-auth  .el-button,
    body.page-id-54778 .am-login button[type="submit"],
    body.page-id-54778 .am-auth  button[type="submit"] {
        background: #CCC593 !important;
        background-color: #CCC593 !important;
        color: #1a1a1a !important;
        border: 0 !important;
        border-radius: 8px !important;
        height: 52px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        letter-spacing: 0.14em !important;
        text-transform: uppercase !important;
        width: 100% !important;
    }
    /* Nested span the Vue button wraps text in — force the text styles too */
    body.page-id-54778 .am-login .am-button--primary span,
    body.page-id-54778 .am-login .am-button--filled span,
    body.page-id-54778 .am-login .el-button--primary span,
    body.page-id-54778 .am-login .el-button span,
    body.page-id-54778 .am-auth  .am-button--primary span,
    body.page-id-54778 .am-auth  .am-button--filled span,
    body.page-id-54778 .am-auth  .el-button--primary span,
    body.page-id-54778 .am-auth  .el-button span,
    body.page-id-54778 .am-login button[type="submit"] span,
    body.page-id-54778 .am-auth  button[type="submit"] span {
        color: #1a1a1a !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', sans-serif !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        letter-spacing: 0.14em !important;
        text-transform: uppercase !important;
    }
    body.page-id-54778 .am-login .am-button--primary:hover,
    body.page-id-54778 .am-login .am-button--filled:hover,
    body.page-id-54778 .am-login .el-button--primary:hover,
    body.page-id-54778 .am-login .el-button:hover,
    body.page-id-54778 .am-auth  .am-button--primary:hover,
    body.page-id-54778 .am-auth  .am-button--filled:hover,
    body.page-id-54778 .am-auth  .el-button--primary:hover,
    body.page-id-54778 .am-auth  .el-button:hover,
    body.page-id-54778 .am-login button[type="submit"]:hover,
    body.page-id-54778 .am-auth  button[type="submit"]:hover {
        background: #E8DFB5 !important;
        color: #0c0c0c !important;
    }

    /* Forgot password / Reset Password row
       - 1pt smaller, 50% opacity, pushed further from button,
         and the two links visually separated by a middot divider */
    body.page-id-54778 .am-login .am-login__forgot,
    body.page-id-54778 .am-auth  .am-login__forgot,
    body.page-id-54778 .am-login .am-forgot,
    body.page-id-54778 .am-auth  .am-forgot,
    body.page-id-54778 .am-login form + p,
    body.page-id-54778 .am-auth  form + p,
    body.page-id-54778 .am-login .am-button + p,
    body.page-id-54778 .am-auth  .am-button + p,
    body.page-id-54778 .am-login .el-button + p,
    body.page-id-54778 .am-auth  .el-button + p,
    body.page-id-54778 .am-login button[type="submit"] + p,
    body.page-id-54778 .am-auth  button[type="submit"] + p {
        margin-top: 32px !important;
        padding-top: 4px !important;
        text-align: center !important;
        font-size: 12px !important;
        opacity: 0.5 !important;
        color: #FFFFFF !important;
        letter-spacing: 0.02em !important;
    }

    /* Anchor links inside the card (forgot password / reset password) */
    body.page-id-54778 .am-login a,
    body.page-id-54778 .am-auth  a {
        color: inherit !important;
        text-decoration: none !important;
        font-weight: 400 !important;
        font-size: 12px !important;
        padding: 0 8px !important;
    }
    body.page-id-54778 .am-login a:hover,
    body.page-id-54778 .am-auth  a:hover {
        color: #CCC593 !important;
        text-decoration: underline !important;
    }

    /* Kill any stray Colibri .h-global-transition-* white-flash */
    body.page-id-54778 .am-login,
    body.page-id-54778 .am-auth {
        max-width: 460px !important;
        margin: 40px auto !important;
    }

    /* Page background: stay dark luxury */
    body.page-id-54778,
    body.page-id-54778 .page-content,
    body.page-id-54778 .entry-content {
        background: #0c0c0c !important;
        color: #E6E0C8 !important;
    }
    </style>
    <?php
}

/* ============================================================
   CART STEP + TIME SLOT CONTRAST FIX — 2026-04-20 — #85
   Root cause: --am-c-main-text: #1A2C37 (dark navy) was designed
   for Amelia's light theme. Dark luxury bg makes it invisible.
   Also fixes time slot buttons using --am-c-primary: #1246D6.
   ============================================================ */
add_action( 'wp_footer', 'rg_cart_timeslot_contrast_css', 99999 );
function rg_cart_timeslot_contrast_css() { ?>
<style id="rg-cart-timeslot-contrast">

/* ── CART STEP: intro text ───────────────────────────────── */
.am-fs__cart-title {
    color: rgba(220, 215, 200, 0.75) !important;
}

/* ── CART STEP: "Service" / "Extras" section labels ─────── */
.am-fs__ci-title {
    color: rgba(204, 197, 147, 0.65) !important;
    text-transform: uppercase !important;
    font-size: 10px !important;
    letter-spacing: 0.1em !important;
}

/* ── CART STEP: service name row (wrapper had dark text) ─── */
.am-fs__ci-prod__title {
    color: rgba(255, 255, 255, 0.85) !important;
}

/* ── CART STEP: price column on service row ──────────────── */
.am-fs__ci-prod__price {
    color: #CCC593 !important;
}

/* ── CART STEP: Subtotal / Total labels + amounts ────────── */
.am-fs__ci-cost__title,
.am-fs__ci-cost__price {
    color: rgba(220, 215, 200, 0.85) !important;
}

/* ── CART STEP: Total Price row — slightly brighter ─────── */
.am-fs__ci-total .am-fs__ci-cost__title,
.am-fs__ci-total .am-fs__ci-cost__price {
    color: #CCC593 !important;
    font-weight: 600 !important;
}

/* ── CART STEP: "Edit" action link ──────────────────────── */
.am-fs__ci-manage__edit {
    color: #CCC593 !important;
}
.am-fs__ci-manage__edit:hover {
    color: #E8DFB5 !important;
}

/* ── CART STEP: total price badge blue bg → dark luxury ─── */
.am-fs__cserv-price {
    background: rgba(204, 197, 147, 0.12) !important;
    border: 1px solid rgba(204, 197, 147, 0.25) !important;
    color: #CCC593 !important;
}

/* ── TIME SLOTS: unselected — dark blue text on faint blue bg */
.am-advsc__slots-item__inner {
    color: rgba(220, 215, 200, 0.85) !important;
    background-color: rgba(255, 255, 255, 0.05) !important;
    border-color: rgba(204, 197, 147, 0.2) !important;
}

/* ── TIME SLOTS: selected — white on blue → champagne on dark */
.am-advsc__slots-item__selected .am-advsc__slots-item__inner,
.am-advsc__slots-item--selected .am-advsc__slots-item__inner {
    color: #CCC593 !important;
    background-color: rgba(204, 197, 147, 0.15) !important;
    border-color: rgba(204, 197, 147, 0.6) !important;
}

</style>
<?php }

/* ============================================================
   AM-ADV-SELECT (custom field "select" type) CONTRAST — #85
   Root cause: AmAdvancedSelect component uses .am-adv-select__item
   with --am-c-main-text (#1A2C37) — invisible on dark bg.
   Different from AmSelect (.am-select-option) used for month/year.
   ============================================================ */
add_action( 'wp_footer', 'rg_adv_select_contrast_css', 99999 );
function rg_adv_select_contrast_css() { ?>
<style id="rg-adv-select-contrast">

/* ── Dropdown wrapper / popper ────────────────────────────── */
.am-adv-select__wrapper {
    background: #1a1408 !important;
    border: 1px solid rgba(204, 197, 147, 0.3) !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.6) !important;
    border-radius: 2px !important;
}

/* ── Popper heading ───────────────────────────────────────── */
.am-adv-select__popper-heading {
    color: rgba(204, 197, 147, 0.65) !important;
    border-bottom: 1px solid rgba(204, 197, 147, 0.15) !important;
}

/* ── Each option item ─────────────────────────────────────── */
.am-adv-select__item {
    color: rgba(240, 235, 225, 0.85) !important;
    background: transparent !important;
}

/* ── Item sub-elements ────────────────────────────────────── */
.am-adv-select__item-label {
    color: rgba(240, 235, 225, 0.85) !important;
}
.am-adv-select__item-price,
.am-adv-select__item-quantity,
.am-adv-select__item-tax {
    color: rgba(204, 197, 147, 0.75) !important;
}

/* ── Hover state ──────────────────────────────────────────── */
.am-adv-select__item:hover,
.am-adv-select__item:hover .am-adv-select__item-label {
    background: rgba(204, 197, 147, 0.1) !important;
    color: #CCC593 !important;
}

/* ── Selected / checked state ─────────────────────────────── */
.am-adv-select__item-checked,
.am-adv-select__item-checked .am-adv-select__item-label {
    color: #CCC593 !important;
    font-weight: 500 !important;
}

</style>
<?php }

/* ============================================================
   WOOCOMMERCE CART + CHECKOUT DARK LUXURY — 2026-04-20 — #85
   Root cause: WooCommerce Coming Soon (store-pages) was hiding
   cart/checkout. Now visible but WC default light-theme styles
   clash with dark luxury background.
   ============================================================ */
add_action( 'wp_footer', 'rg_wc_cart_checkout_css', 99999 );
function rg_wc_cart_checkout_css() {
    if ( ! ( is_cart() || is_checkout() || is_page(14) || is_page(15) ) ) return;
    ?>
<style id="rg-wc-cart-checkout">

/* ── Page body ───────────────────────────────────────────── */
body.woocommerce-cart .entry-content,
body.woocommerce-checkout .entry-content {
    color: rgba(220, 215, 200, 0.85) !important;
}

/* ── Notices (info / empty cart / error / success) ───────── */
.woocommerce-info,
.woocommerce-message,
.woocommerce-error,
.cart-empty.woocommerce-info {
    background: rgba(26, 20, 8, 0.85) !important;
    border-top-color: #CCC593 !important;
    color: rgba(220, 215, 200, 0.85) !important;
    border-left: 4px solid rgba(204, 197, 147, 0.5) !important;
}
.woocommerce-info::before,
.woocommerce-message::before {
    color: #CCC593 !important;
}

/* ── All WC buttons → champagne luxury ──────────────────── */
.woocommerce .button,
.woocommerce button.button,
.woocommerce a.button,
.woocommerce input.button,
.woocommerce #respond input#submit,
.wc-backward,
.return-to-shop .button,
.wc-proceed-to-checkout .checkout-button {
    background: #CCC593 !important;
    background-color: #CCC593 !important;
    color: #1a1a1a !important;
    border: 0 !important;
    border-radius: 6px !important;
    font-family: 'Inter', sans-serif !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    letter-spacing: 0.1em !important;
    text-transform: uppercase !important;
    padding: 14px 28px !important;
}
.woocommerce .button:hover,
.woocommerce a.button:hover,
.wc-proceed-to-checkout .checkout-button:hover {
    background: #E8DFB5 !important;
    background-color: #E8DFB5 !important;
    color: #0c0c0c !important;
}

/* ── Cart table ──────────────────────────────────────────── */
table.shop_table,
table.woocommerce-checkout-review-order-table {
    background: rgba(26, 20, 8, 0.6) !important;
    border: 1px solid rgba(204, 197, 147, 0.2) !important;
    color: rgba(220, 215, 200, 0.85) !important;
    border-collapse: collapse !important;
}
table.shop_table th,
table.woocommerce-checkout-review-order-table th {
    background: rgba(204, 197, 147, 0.08) !important;
    color: rgba(204, 197, 147, 0.75) !important;
    border-bottom: 1px solid rgba(204, 197, 147, 0.2) !important;
    font-size: 11px !important;
    letter-spacing: 0.1em !important;
    text-transform: uppercase !important;
}
table.shop_table td,
table.woocommerce-checkout-review-order-table td {
    color: rgba(220, 215, 200, 0.85) !important;
    border-bottom: 1px solid rgba(204, 197, 147, 0.1) !important;
}
table.shop_table .product-name a,
table.shop_table .product-name {
    color: rgba(255, 255, 255, 0.88) !important;
}
table.shop_table .product-price,
table.shop_table .product-subtotal,
table.shop_table .order-total .amount,
.cart_totals .order-total .amount {
    color: #CCC593 !important;
    font-weight: 600 !important;
}

/* ── Cart totals sidebar ─────────────────────────────────── */
.cart-collaterals,
.cart_totals,
.cart_totals h2 {
    color: rgba(220, 215, 200, 0.85) !important;
}
.cart_totals table th,
.cart_totals table td {
    border-bottom: 1px solid rgba(204, 197, 147, 0.12) !important;
    color: rgba(220, 215, 200, 0.85) !important;
}

/* ── Checkout form fields ────────────────────────────────── */
.woocommerce-checkout .form-row label,
.woocommerce-billing-fields h3,
.woocommerce-shipping-fields h3,
.woocommerce-additional-fields h3,
#order_review_heading {
    color: rgba(204, 197, 147, 0.85) !important;
}
.woocommerce-checkout .input-text,
.woocommerce-checkout select,
.woocommerce-checkout textarea {
    background: rgba(20, 17, 12, 0.9) !important;
    border: 1px solid rgba(204, 197, 147, 0.35) !important;
    color: rgba(220, 215, 200, 0.9) !important;
    border-radius: 4px !important;
}
.woocommerce-checkout .input-text:focus,
.woocommerce-checkout select:focus {
    border-color: rgba(204, 197, 147, 0.7) !important;
    outline: none !important;
    box-shadow: 0 0 0 2px rgba(204, 197, 147, 0.1) !important;
}

/* ── Colibri section/column containers → transparent on cart/checkout ─── */
/* Root cause of 3 black pills: Colibri assigns background-color to        */
/* .h-column__inner / .h-section via its own scoped CSS. Making them       */
/* transparent lets the dark body (#1A1A1A) show through and the           */
/* WC content above becomes visible.                                        */
body.woocommerce-cart .h-section,
body.woocommerce-cart .h-row,
body.woocommerce-cart .h-col,
body.woocommerce-cart .h-column,
body.woocommerce-cart .h-column__inner,
body.woocommerce-cart .h-section-global-spacing,
body.woocommerce-checkout .h-section,
body.woocommerce-checkout .h-row,
body.woocommerce-checkout .h-col,
body.woocommerce-checkout .h-column,
body.woocommerce-checkout .h-column__inner,
body.woocommerce-checkout .h-section-global-spacing,
body.page-id-14 .h-section,
body.page-id-14 .h-column__inner,
body.page-id-14 .wp-block-woocommerce-classic-shortcode,
body.page-id-15 .h-section,
body.page-id-15 .h-column__inner {
    background-color: transparent !important;
    background-image: none !important;
}

/* ── WC cart/checkout wrapper text ──────────────────────── */
body.woocommerce-cart .woocommerce,
body.woocommerce-checkout .woocommerce,
body.page-id-14 .woocommerce,
body.page-id-15 .woocommerce {
    color: rgba(220, 215, 200, 0.85) !important;
}

/* ── "Proceed to Checkout" button — full width treatment ─── */
.wc-proceed-to-checkout {
    padding-top: 16px !important;
}
.wc-proceed-to-checkout .checkout-button {
    width: 100% !important;
    display: block !important;
    text-align: center !important;
    padding: 16px !important;
    font-size: 13px !important;
}

/* ── Payment methods on checkout ─────────────────────────── */
#payment {
    background: rgba(26, 20, 8, 0.6) !important;
    border-radius: 4px !important;
    border: 1px solid rgba(204, 197, 147, 0.2) !important;
}
#payment ul.payment_methods li label {
    color: rgba(220, 215, 200, 0.85) !important;
}
#payment .payment_box {
    background: rgba(204, 197, 147, 0.06) !important;
    color: rgba(220, 215, 200, 0.75) !important;
}

</style>
    <?php
}
