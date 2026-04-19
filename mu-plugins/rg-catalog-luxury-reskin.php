<?php
/**
 * Plugin Name: Rive Gosh — Catalog Form Luxury Reskin
 * Description: Dark luxury reskin for ALL Amelia catalog form pages: /appointment/ entry page
 *              plus ALL destination sub-pages (all-transfers-airports-area-X, book-a-ride-X, etc.).
 *              Covers: catalog list view (.am-fcl / .am-fcil), service detail view (.am-fcis).
 *              v1.0.0 was gated to is_page(44401) — destination sub-pages never got CSS.
 *              v1.1.0 fixes: guard → is_singular(), body.page-id-44401 removed from all selectors.
 * Author: RG
 * Version: 1.1.0
 * Created: 2026-04-19
 * Updated: 2026-04-19
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║  🛑 DO NOT DELETE. DO NOT MODIFY WITHOUT ASKING RODERIC.         ║
 * ║  ───────────────────────────────────────────────────────────────  ║
 * ║  v1.1.0 verified on destination sub-pages (all-transfers-* etc.)  ║
 * ║  after removing is_page(44401) guard + body.page-id-44401 prefix  ║
 * ║                                                                   ║
 * ║  If Amelia catalog or service-detail views look wrong later,      ║
 * ║  FIX THE CAUSE (Amelia update, mu-plugin conflict) — do NOT gut  ║
 * ║  NOT gut or rewrite this file. Ship additive overrides in a NEW  ║
 * ║  mu-plugin if needed.                                             ║
 * ║                                                                   ║
 * ║  WHY THIS FILE EXISTS: The prior dark luxury reskin for the       ║
 * ║  Amelia catalog form (rg-amelia-catalog, rg-amelia-page-dark,    ║
 * ║  rg-amelia-luxury-redesign, rg-amelia-detail-redesign style IDs) ║
 * ║  was lost when concurrent CC sessions deleted the mu-plugins that ║
 * ║  output them. LiteSpeed cache masked the absence until 2026-04-19 ║
 * ║  when a cache purge revealed the regression.                     ║
 * ║                                                                   ║
 * ║  GitHub: rivegosh/concierge-rivegosh#82                          ║
 * ║  Commit of record: TBD                                            ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_footer', 'rg_catalog_luxury_reskin', 99999 );
function rg_catalog_luxury_reskin() {
    // Guard: only on singular pages/posts (not archives/home/search).
    // Selectors are scoped to .amelia-v2-booking — won't affect non-Amelia pages.
    // v1.0.0 used is_page(44401) which excluded ALL destination sub-pages (IDs 67025/67035/etc.).
    if ( ! is_singular() ) return;
    ?>
    <style id="rg-catalog-luxury-reskin">

    /* ══════════════════════════════════════════════════════════════
     * AMELIA CATALOG FORM — DARK LUXURY RESKIN
     * Design system: charbon #0a0a0a · gold #CCC593 · text rgba(220,213,170,x)
     * Loads after rg-amelia-contrast.php (c > a) and rg-appointment-redesign.php (c > a)
     * ══════════════════════════════════════════════════════════════ */

    /* ─── 0a. COLIBRI PAGE TEXT — white, constrained, centered ─────── */
    /* Description paragraphs on destination sub-pages live in Colibri
       h-text blocks (NOT Amelia). Default: rgb(0,0,0), full-width 1200px. */
    body:has(.amelia-v2-booking) .h-text {
        max-width: 680px !important;
        width: 100% !important;
        margin-left: auto !important;
        margin-right: auto !important;
        align-self: center !important;
        text-align: center !important;
    }
    body:has(.amelia-v2-booking) .h-text p {
        color: rgba(255, 255, 255, 0.88) !important;
        font-size: 15px !important;
        line-height: 1.75 !important;
        margin-bottom: 1em !important;
    }
    body:has(.amelia-v2-booking) .h-text strong,
    body:has(.amelia-v2-booking) .h-text b {
        color: #ffffff !important;
        font-weight: 600 !important;
    }

    /* ─── 0. DARK PAGE BODY ─────────────────────────────────────── */
    /* Colibri sections only set dark bg on their own box — the page body
       below them renders browser-white. Fix: force body dark on any page
       where Amelia booking form is present. Works on /appointment/ AND all
       destination sub-pages (all-transfers-*, book-a-ride-*, etc.). */
    body:has(.amelia-v2-booking) {
        background-color: #1A1A1A !important;
        min-height: 100vh;
    }

    /* ─── 1. DARK PAGE & CONTAINER ──────────────────────────────── */
    /* Override Amelia's inline CSS custom property (--am-c-main-bgr: #fff) set by Vue at mount.
       !important in stylesheet beats inline style without !important per CSS cascade spec. */
    .amelia-v2-booking,
    .amelia-v2-booking #amelia-container {
        --am-c-main-bgr: #0f0c08 !important;
        --am-c-card-bgr: transparent !important;
        --am-c-inp-bgr: rgba(20, 17, 12, 0.9) !important;
    }

    .amelia-v2-booking,
    .amelia-v2-booking #amelia-container,
    .amelia-v2-booking #amelia-container.am-fc__wrapper {
        background: transparent !important;
    }

    .amelia-v2-booking #amelia-container .am-fcl,
    .amelia-v2-booking #amelia-container .am-fcil,
    .amelia-v2-booking #amelia-container .am-cat__wrapper {
        background: transparent !important;
    }

    .amelia-v2-booking #amelia-container .am-fcis,
    .amelia-v2-booking #amelia-container .am-fcip {
        background: transparent !important;
    }

    /* ─── 2. CATEGORY DESCRIPTION TEXT ─────────────────────────── */
    /* The intro paragraph ("Illinois and Area refers to...") */
    .amelia-v2-booking #amelia-container .am-fcil p,
    .amelia-v2-booking #amelia-container .am-fcil span,
    .amelia-v2-booking #amelia-container .am-fcil__subtitle,
    .amelia-v2-booking #amelia-container .am-fcl__desc,
    .amelia-v2-booking #amelia-container [class*="fcil__desc"],
    .amelia-v2-booking #amelia-container [class*="fcl__desc"],
    .amelia-v2-booking #amelia-container .am-fcil__content p,
    .amelia-v2-booking #amelia-container .am-fcil__content span,
    .amelia-v2-booking #amelia-container .am-fcil strong,
    .amelia-v2-booking #amelia-container .am-fcil b {
        color: #ffffff !important;
        font-size: 14px !important;
        line-height: 1.65 !important;
        max-width: 640px !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* Service card titles in list view (was rgb(26,44,55) dark navy) */
    .amelia-v2-booking #amelia-container .am-fcil__item-name {
        color: #ffffff !important;
    }

    /* "Available – N Services" line */
    .amelia-v2-booking #amelia-container .am-fcil__heading,
    .amelia-v2-booking #amelia-container [class*="fcil__heading"],
    .amelia-v2-booking #amelia-container .am-fcl__services-count,
    .amelia-v2-booking #amelia-container [class*="services-count"] {
        color: rgba(204, 197, 147, 0.6) !important;
        font-size: 12px !important;
        letter-spacing: 0.1em !important;
        text-transform: uppercase !important;
    }

    /* ─── 3. SERVICE CARDS (list view) ─────────────────────────── */
    .amelia-v2-booking #amelia-container .am-fcl__card,
    .amelia-v2-booking #amelia-container [class*="fcl__card"]:not([class*="card-img"]):not([class*="card-info"]):not([class*="card-title"]):not([class*="card-price"]):not([class*="card-content"]) {
        background: rgba(14, 11, 7, 0.88) !important;
        border: 1px solid rgba(204, 197, 147, 0.2) !important;
        border-radius: 12px !important;
        backdrop-filter: blur(12px) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4) !important;
        overflow: hidden !important;
    }

    /* Card content wrapper */
    .amelia-v2-booking #amelia-container .am-fcl__card-content,
    .amelia-v2-booking #amelia-container [class*="fcl__card-content"] {
        background: transparent !important;
    }

    /* Service name */
    .amelia-v2-booking #amelia-container .am-fcl__card-title,
    .amelia-v2-booking #amelia-container [class*="fcl__card-title"] {
        color: #CCC593 !important;
        font-size: 16px !important;
        font-weight: 600 !important;
    }

    /* Card meta: category, duration, capacity icons */
    .amelia-v2-booking #amelia-container .am-fcl__card-info,
    .amelia-v2-booking #amelia-container [class*="fcl__card-info"],
    .amelia-v2-booking #amelia-container .am-fcl__card-info *,
    .amelia-v2-booking #amelia-container [class*="fcl__card-info"] * {
        color: rgba(220, 213, 170, 0.55) !important;
        font-size: 12px !important;
    }

    /* Price badge (el-tag) */
    .amelia-v2-booking #amelia-container .am-fcl__card .el-tag,
    .amelia-v2-booking #amelia-container [class*="fcl__card"] .el-tag {
        background: rgba(204, 197, 147, 0.12) !important;
        color: #CCC593 !important;
        border: 1px solid rgba(204, 197, 147, 0.3) !important;
        font-weight: 600 !important;
    }

    /* ─── 4. SERVICE DETAIL VIEW ────────────────────────────────── */
    /* Service title (e.g. "Sedan Airport Transfer California") */
    .amelia-v2-booking #amelia-container .am-fcis__title,
    .amelia-v2-booking #amelia-container [class*="fcis__title"],
    .amelia-v2-booking #amelia-container .am-fcis h1,
    .amelia-v2-booking #amelia-container .am-fcis h2,
    .amelia-v2-booking #amelia-container .am-fcis h3 {
        color: #CCC593 !important;
        font-size: 22px !important;
        font-weight: 600 !important;
        letter-spacing: 0.02em !important;
    }

    /* Price in detail header */
    .amelia-v2-booking #amelia-container .am-fcis .el-tag,
    .amelia-v2-booking #amelia-container .am-fcis__price,
    .amelia-v2-booking #amelia-container [class*="fcis__price"] {
        color: #CCC593 !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        background: transparent !important;
        border: none !important;
    }

    /* Meta row (category, duration, capacity) */
    .amelia-v2-booking #amelia-container .am-fcis__info,
    .amelia-v2-booking #amelia-container [class*="fcis__info"],
    .amelia-v2-booking #amelia-container .am-fcis__info *,
    .amelia-v2-booking #amelia-container [class*="fcis__info"] * {
        color: rgba(220, 213, 170, 0.55) !important;
        font-size: 12px !important;
    }

    /* "About Service" / "Employees" tabs */
    .amelia-v2-booking #amelia-container .am-fcis__tabs,
    .amelia-v2-booking #amelia-container [class*="fcis__tab"] {
        border-bottom-color: rgba(204, 197, 147, 0.15) !important;
    }
    .amelia-v2-booking #amelia-container .am-fcis__tab,
    .amelia-v2-booking #amelia-container [class*="fcis__tab"]:not(.is-active) {
        color: rgba(204, 197, 147, 0.5) !important;
    }
    .amelia-v2-booking #amelia-container .am-fcis__tab.is-active,
    .amelia-v2-booking #amelia-container [class*="fcis__tab"].is-active {
        color: #CCC593 !important;
        border-bottom-color: #CCC593 !important;
    }

    /* Service description text under "About Service" tab */
    .amelia-v2-booking #amelia-container .am-fcis__info-content,
    .amelia-v2-booking #amelia-container [class*="fcis__info-content"],
    .amelia-v2-booking #amelia-container .am-fcis__info-content *,
    .amelia-v2-booking #amelia-container [class*="fcis__info-content"] * {
        color: rgba(220, 213, 170, 0.7) !important;
        font-size: 14px !important;
        line-height: 1.7 !important;
    }

    /* ─── 5. GALLERY — KEEP HERO, REMOVE BUTTON + THUMBS ──────── */
    /* "View all photos" button — HIDE */
    .amelia-v2-booking #amelia-container .am-fcis__gallery-btn,
    .amelia-v2-booking #amelia-container .am-fcip__gallery-btn,
    .amelia-v2-booking [class*="fcis__gallery-btn"],
    .amelia-v2-booking [class*="fcip__gallery-btn"] {
        display: none !important;
    }

    /* Thumbnail strip — HIDE */
    .amelia-v2-booking #amelia-container .am-fcis__gallery-thumb__wrapper,
    .amelia-v2-booking #amelia-container .am-fcip__gallery-thumb__wrapper,
    .amelia-v2-booking [class*="fcis__gallery-thumb__wrapper"],
    .amelia-v2-booking [class*="fcip__gallery-thumb__wrapper"] {
        display: none !important;
    }

    /* Hero photo — full width, proper aspect ratio so full car is visible */
    .amelia-v2-booking #amelia-container .am-fcis__gallery-hero,
    .amelia-v2-booking #amelia-container .am-fcip__gallery-hero,
    .amelia-v2-booking [class*="fcis__gallery-hero"],
    .amelia-v2-booking [class*="fcip__gallery-hero"] {
        width: 100% !important;
        padding-top: 42% !important;          /* taller than Amelia's default 25% — shows full car */
        background-size: contain !important;   /* show full car, no cropping */
        background-repeat: no-repeat !important;
        background-position: center center !important;
        background-color: #0a0a0a !important;  /* dark fill behind transparent car cutout */
        border-radius: 8px !important;
    }

    /* Gallery container: keep dark background matching the page */
    .amelia-v2-booking #amelia-container .am-fcis__gallery,
    .amelia-v2-booking #amelia-container .am-fcip__gallery {
        background: #0a0a0a !important;
        margin-bottom: 16px !important;
        border-radius: 8px !important;
        overflow: hidden !important;
    }

    /* ─── 6. BUTTONS ───────────────────────────────────────────── */
    /* Continue / Book Now — champagne gold */
    .amelia-v2-booking #amelia-container .am-button.am-button--filled,
    .amelia-v2-booking #amelia-container [class*="am-button--filled"] {
        background: rgba(204, 197, 147, 0.92) !important;
        color: #0a0a0a !important;
        border: none !important;
        font-weight: 600 !important;
        letter-spacing: 0.08em !important;
    }
    .amelia-v2-booking #amelia-container .am-button.am-button--filled:hover {
        background: rgba(220, 213, 170, 1) !important;
    }

    /* Go Back — glass dark */
    .amelia-v2-booking #amelia-container .am-button.am-button--plain,
    .amelia-v2-booking #amelia-container [class*="am-button--plain"] {
        background: rgba(14, 11, 7, 0.85) !important;
        border: 1px solid rgba(204, 197, 147, 0.3) !important;
        color: rgba(204, 197, 147, 0.75) !important;
    }

    /* View Employees link */
    .amelia-v2-booking #amelia-container .am-fcl__card a,
    .amelia-v2-booking #amelia-container .am-fcl__card-link,
    .amelia-v2-booking #amelia-container [class*="fcl__card-link"] {
        color: rgba(204, 197, 147, 0.6) !important;
        font-size: 12px !important;
    }

    /* ─── 7. SERVICE TYPE BADGE ("Service" tag) ─────────────────── */
    /* Was green-on-green. Scoped to .am-fcis so we don't touch gallery el-tags. */
    .amelia-v2-booking #amelia-container .am-fcis .el-tag--light,
    .amelia-v2-booking #amelia-container .am-fcis .el-tag.el-tag--success,
    .amelia-v2-booking #amelia-container .am-fcis .el-tag.el-tag--primary,
    .amelia-v2-booking #amelia-container .am-fcl__card .el-tag.el-tag--success,
    .amelia-v2-booking #amelia-container .am-fcl__card .el-tag.el-tag--light {
        background: rgba(204, 197, 147, 0.12) !important;
        border: 1px solid rgba(204, 197, 147, 0.3) !important;
        color: #CCC593 !important;
    }

    /* ─── 8. SERVICE DETAIL — HEADER CONTRAST FIXES ─────────────── */
    /* Go Back btn — .am-button--plain already exists in §6, but the header
       variant sits inside .am-fcis__header which may reset it. Re-scope it. */
    .amelia-v2-booking #amelia-container .am-fcis__header .am-button,
    .amelia-v2-booking #amelia-container [class*="fcis__header-btn"] {
        background: rgba(14, 11, 7, 0.75) !important;
        border: 1px solid rgba(204, 197, 147, 0.35) !important;
        color: rgba(204, 197, 147, 0.85) !important;
    }

    /* Price: el-tag inside header price area was rendering dark-on-blue */
    .amelia-v2-booking #amelia-container [class*="fcis__header-price"] .el-tag,
    .amelia-v2-booking #amelia-container [class*="fcis__header-price"] {
        color: #CCC593 !important;
        background: transparent !important;
        border: none !important;
        font-size: 20px !important;
        font-weight: 700 !important;
    }

    /* Mini-info row: category + driver count + duration + capacity pills.
       NO wildcard * here — only named pill classes to stay gallery-safe. */
    .amelia-v2-booking #amelia-container [class*="fcis__mini-info"],
    .amelia-v2-booking #amelia-container [class*="fcis__mini-info"] .el-tag,
    .amelia-v2-booking #amelia-container [class*="fcis__mini-info"] span {
        color: rgba(220, 213, 170, 0.75) !important;
        background: transparent !important;
        border-color: rgba(204, 197, 147, 0.2) !important;
        font-size: 12px !important;
    }

    /* Description/body-copy dark boxes: transparent bg on text containers only */
    .amelia-v2-booking #amelia-container [class*="fcis__info-content"],
    .amelia-v2-booking #amelia-container [class*="fcis__info-service__desc"],
    .amelia-v2-booking #amelia-container .am-fcil__item-content {
        background: transparent !important;
        color: rgba(220, 213, 170, 0.82) !important;
    }

    /* Header top/bottom strips — transparent so dark page shows through */
    .amelia-v2-booking #amelia-container [class*="fcis__header-top"],
    .amelia-v2-booking #amelia-container [class*="fcis__header-bottom"] {
        background: transparent !important;
    }

    </style>
    <?php
}
