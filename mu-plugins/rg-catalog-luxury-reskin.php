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
    /* Override Amelia's inline --am-c-main-bgr: #fff. Set to match page body
       (#1A1A1A) so any element using var(--am-c-main-bgr) blends in rather
       than showing as a near-black box on the slightly-lighter page. */
    .amelia-v2-booking,
    .amelia-v2-booking #amelia-container {
        --am-c-main-bgr: #1A1A1A !important;
        --am-c-card-bgr: transparent !important;
        --am-c-inp-bgr: rgba(20, 17, 12, 0.9) !important;
        --am-c-main-text: rgba(220, 213, 170, 0.88) !important;
        --am-c-main-heading-text: #CCC593 !important;
        --am-c-primary: #CCC593 !important;
        --am-c-primary-text: #0a0a0a !important;
    }

    .amelia-v2-booking,
    .amelia-v2-booking #amelia-container,
    .amelia-v2-booking #amelia-container.am-fc__wrapper {
        background: transparent !important;
    }

    .amelia-v2-booking #amelia-container .am-fcl,
    .amelia-v2-booking #amelia-container .am-fcil,
    .amelia-v2-booking #amelia-container .am-fcil__wrapper,
    .amelia-v2-booking #amelia-container .am-cat__wrapper {
        background: transparent !important;
    }

    .amelia-v2-booking #amelia-container .am-fcis,
    .amelia-v2-booking #amelia-container .am-fcip {
        background: transparent !important;
    }

    /* ─── 2. CATEGORY DESCRIPTION TEXT ─────────────────────────── */
    /* Transparent bg on ALL text containers so no dark-box artifacts on
       the #1A1A1A page body. Color to champagne for readability. */
    .amelia-v2-booking #amelia-container .am-fcil p,
    .amelia-v2-booking #amelia-container .am-fcil span,
    .amelia-v2-booking #amelia-container .am-fcil__subtitle,
    .amelia-v2-booking #amelia-container .am-fcl__desc,
    .amelia-v2-booking #amelia-container [class*="fcil__desc"],
    .amelia-v2-booking #amelia-container [class*="fcl__desc"],
    .amelia-v2-booking #amelia-container .am-fcil__item-content,
    .amelia-v2-booking #amelia-container [class*="fcil__item"] {
        color: rgba(220, 213, 170, 0.88) !important;
        background: transparent !important;
        font-size: 14px !important;
        line-height: 1.65 !important;
        max-width: 640px !important;
        margin-left: auto !important;
        margin-right: auto !important;
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
    /* Service title */
    .amelia-v2-booking #amelia-container .am-fcis__header-name,
    .amelia-v2-booking #amelia-container [class*="fcis__header-name"],
    .amelia-v2-booking #amelia-container .am-fcis h1,
    .amelia-v2-booking #amelia-container .am-fcis h2,
    .amelia-v2-booking #amelia-container .am-fcis h3 {
        color: #CCC593 !important;
        font-size: 22px !important;
        font-weight: 600 !important;
        letter-spacing: 0.02em !important;
    }

    /* Service type badge ("Service" / "Package" — was green-on-green) */
    .amelia-v2-booking #amelia-container .am-fcis__badge,
    .amelia-v2-booking #amelia-container [class*="fcis__badge"],
    .amelia-v2-booking #amelia-container .am-fcis__badge [class*="el-tag"],
    .amelia-v2-booking #amelia-container [class*="fcis__badge"] [class*="el-tag"] {
        background: rgba(204, 197, 147, 0.12) !important;
        border: 1px solid rgba(204, 197, 147, 0.35) !important;
        color: #CCC593 !important;
        font-size: 11px !important;
        font-weight: 600 !important;
    }

    /* Price — was dark-on-blue el-tag */
    .amelia-v2-booking #amelia-container .am-fcis__header-price,
    .amelia-v2-booking #amelia-container [class*="fcis__header-price"],
    .amelia-v2-booking #amelia-container .am-fcis__header-price [class*="el-tag"],
    .amelia-v2-booking #amelia-container .am-fcis__header-price * {
        color: #CCC593 !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        background: transparent !important;
        border: none !important;
    }

    /* Header tax line */
    .amelia-v2-booking #amelia-container .am-fcis__header-tax,
    .amelia-v2-booking #amelia-container [class*="fcis__header-tax"] {
        color: rgba(204, 197, 147, 0.5) !important;
        font-size: 11px !important;
    }

    /* Go Back button */
    .amelia-v2-booking #amelia-container .am-fcis__header-btn,
    .amelia-v2-booking #amelia-container [class*="fcis__header-btn"] {
        background: rgba(14, 11, 7, 0.7) !important;
        border: 1px solid rgba(204, 197, 147, 0.35) !important;
        color: rgba(204, 197, 147, 0.85) !important;
        font-size: 13px !important;
    }

    /* Mini info row: "Florida Transfer USA + 200 drivers | 2h | 1/3"
       was dark-text on dark pill badges */
    .amelia-v2-booking #amelia-container .am-fcis__mini-info,
    .amelia-v2-booking #amelia-container [class*="fcis__mini-info"],
    .amelia-v2-booking #amelia-container .am-fcis__mini-info *,
    .amelia-v2-booking #amelia-container [class*="fcis__mini-info"] * {
        color: rgba(220, 213, 170, 0.75) !important;
        background: transparent !important;
        border-color: rgba(204, 197, 147, 0.2) !important;
        font-size: 12px !important;
    }

    /* Header bottom strip (holds badge + price + action) */
    .amelia-v2-booking #amelia-container .am-fcis__header-bottom,
    .amelia-v2-booking #amelia-container [class*="fcis__header-bottom"] {
        background: transparent !important;
    }

    /* Header top strip */
    .amelia-v2-booking #amelia-container .am-fcis__header-top,
    .amelia-v2-booking #amelia-container [class*="fcis__header-top"] {
        background: transparent !important;
    }

    /* Service description text under "About Service" tab */
    .amelia-v2-booking #amelia-container .am-fcis__info-content,
    .amelia-v2-booking #amelia-container .am-fcis__info-service__desc,
    .amelia-v2-booking #amelia-container [class*="fcis__info-content"],
    .amelia-v2-booking #amelia-container [class*="fcis__info-content"] *,
    .amelia-v2-booking #amelia-container [class*="fcis__info-service__desc"] * {
        color: rgba(220, 213, 170, 0.85) !important;
        background: transparent !important;
        font-size: 14px !important;
        line-height: 1.7 !important;
    }

    /* Meta row (category, duration, capacity) */
    .amelia-v2-booking #amelia-container .am-fcis__info,
    .amelia-v2-booking #amelia-container [class*="fcis__info"],
    .amelia-v2-booking #amelia-container .am-fcis__info *,
    .amelia-v2-booking #amelia-container [class*="fcis__info"] * {
        color: rgba(220, 213, 170, 0.75) !important;
        background: transparent !important;
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

    /* ─── 7. ALL EL-TAGS — universal champagne override ─────────── */
    /* Catches any el-tag variant (--success, --primary, --warning, --light)
       that Amelia might render. Each gets champagne text on dark glass bg. */
    .amelia-v2-booking #amelia-container [class*="el-tag"] {
        background: rgba(204, 197, 147, 0.1) !important;
        border: 1px solid rgba(204, 197, 147, 0.25) !important;
        color: rgba(220, 213, 170, 0.9) !important;
    }

    </style>
    <?php
}
