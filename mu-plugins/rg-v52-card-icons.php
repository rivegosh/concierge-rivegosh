<?php
/**
 * Rive Gosh — Card Icon & Mobile Fixes (v52 FINAL)
 * =====================================================
 * MUST-USE PLUGIN — DO NOT DELETE OR MODIFY
 * =====================================================
 * Priority 100000 beats rivegosh_late_css (functions.php @ 99999).
 * Desktop and mobile are SEPARATE breakpoints — desktop is untouched by mobile rules.
 *
 * DESKTOP: 3 cards side-by-side, gap:6px, justify-content:center — NO media query.
 * MOBILE (≤767px): stacked, centered, constrained width, hero moved up — separate block.
 */

if ( defined( 'ABSPATH' ) ) {
    add_action( 'wp_footer', 'rivegosh_v52_card_icons', 100000 );
}

function rivegosh_v52_card_icons() {
    if ( is_admin() ) return;
    ?>
<style id="rg-mobile-v52">

/* ============================================================
   DESKTOP — 3 cards side by side, icon+text centered in each
   No media query = applies everywhere, mobile overrides below
   ============================================================ */

/* Override rivegosh_late_css justify:flex-start gap:14px (priority 100000 > 99999) */
#colibri a[data-colibri-id="61861-h30"].h-button,
#colibri a[data-colibri-id="61861-h31"].h-button,
#colibri a[data-colibri-id="61861-h32"].h-button {
  justify-content: center !important;
  gap: 6px !important;
  text-align: center !important;
}

/* Restore icon into flex flow (Colibri sets position:absolute top:0) */
#colibri [data-colibri-id="61861-h30"] .h-button__icon,
#colibri [data-colibri-id="61861-h31"] .h-button__icon,
#colibri [data-colibri-id="61861-h32"] .h-button__icon {
  position: relative !important;
  top: 7px !important;
  left: 0 !important;
  align-self: center !important;
  margin: 0 !important;
}

/* SVG display:block kills vertical-align:baseline */
#colibri [data-colibri-id="61861-h30"] .h-button__icon svg,
#colibri [data-colibri-id="61861-h31"] .h-button__icon svg,
#colibri [data-colibri-id="61861-h32"] .h-button__icon svg {
  display: block !important;
}

/* ============================================================
   MOBILE ONLY (≤767px)
   Cards stack vertically, centered, fit screen width.
   Hero section moved up. Cycling text smaller.
   DOES NOT affect desktop layout above 767px.
   ============================================================ */
@media (max-width: 767px) {

  /* 1. Move hero content UP — reduce top padding on hero section */
  #colibri [data-colibri-id="61861-h25"] {
    padding-top: 20px !important;
  }

  /* 2. Cards container: column, centered, reduced top padding, tight gap */
  #colibri [data-colibri-id="61861-h29"],
  #colibri .style-dynamic-61861-h29-group {
    flex-direction: column !important;
    align-items: center !important;
    gap: 5px !important;
    padding-top: 12px !important;
    width: 100% !important;
    max-width: 100vw !important;
  }

  /* 3. Each card slot: constrained to screen width with 20px margin each side */
  #colibri [data-colibri-id="61861-h29"] .h-button__outer,
  #colibri .style-dynamic-61861-h29-group .h-button__outer {
    width: min(280px, calc(100vw - 40px)) !important;
    max-width: 100% !important;
    flex-shrink: 0 !important;
  }

  /* 4. Each button: fill card slot width, content centered */
  #colibri a[data-colibri-id="61861-h30"].h-button,
  #colibri a[data-colibri-id="61861-h31"].h-button,
  #colibri a[data-colibri-id="61861-h32"].h-button {
    width: 100% !important;
    justify-content: center !important;
    gap: 6px !important;
  }

  /* 5. Cycling text: smaller font, less height to prevent overflow */
  .rg-word-1, .rg-word-2 {
    font-size: 18px !important;
    letter-spacing: 0.04em !important;
  }
  .rg-cycling-wrap {
    height: 26px !important;
    margin: 0 0 4px 0 !important;
  }

  /* 6. Kill sticky nav on mobile */
  #colibri [data-colibri-id="61861-h2"].h-navigation_sticky,
  #colibri [data-colibri-id="61866-h2"].h-navigation_sticky {
    position: relative !important;
    top: auto !important;
  }

  /* 7. Scrollable logo */
  .rg-fixed-logo {
    position: absolute !important;
    top: 64px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    z-index: 500 !important;
  }
}

/* Cycling text at 768px (tablet boundary) */
@media (max-width: 768px) {
  .rg-cycling-wrap {
    height: 26px !important;
    margin: 0 0 4px 0 !important;
  }
}

</style>
    <?php
}

// ===== MOBILE NAV COLOR (v1 — 2026-04-16) =====
// Changes hamburger menu text from white to champagne gold #CCC593
// Colibri offcanvas panel: .h-offcanvas or inline mobile overlay
add_action( 'wp_footer', 'rivegosh_mobile_nav_colors', 100001 );
function rivegosh_mobile_nav_colors() {
    if ( is_admin() ) return;
    ?>
<style id="rg-mobile-nav-color">

/* Mobile hamburger overlay text → champagne gold */
/* Colibri mobile nav panel */
.h-offcanvas .colibri-menu a,
.h-offcanvas .h-menu a,
.h-offcanvas .menu-item a,
.h-offcanvas ul li a,
/* Colibri inline mobile nav (overlay style) */
.h-navigation_mobile .colibri-menu a,
.h-navigation_mobile .h-menu a,
.h-navigation_mobile .menu-item a,
.h-navigation_mobile ul li a,
/* Generic fallback for any Colibri mobile nav variant */
[class*="h-navigation"] .colibri-menu a,
[class*="mobile-nav"] a,
[class*="h-offcanvas"] a,
/* Hamburger icon lines */
.h-hamburger span,
.h-hamburger::before,
.h-hamburger::after,
[class*="hamburger"] span,
[class*="hamburger"]::before,
[class*="hamburger"]::after {
  color: #CCC593 !important;
  fill: #CCC593 !important;
}

/* Hamburger icon bar color (bg-color for span-based hamburger) */
.h-hamburger span,
[class*="hamburger"] span {
  background-color: #CCC593 !important;
}

/* Mobile nav background — keep dark with good contrast for gold text */
.h-offcanvas,
.h-navigation_mobile {
  background: rgba(8, 8, 8, 0.97) !important;
}

</style>
    <?php
}
// ===== MOBILE NAV COLOR END =====

// ===== MOBILE OFFCANVAS NAV OVERRIDE (v1 — 2026-04-16) =====
// Replaces the Colibri offcanvas panel nav with a clean flat list.
// Only targets #offcanvas-wrapper-61861-h10 (mobile panel, not desktop nav).
// Desktop nav (header-menu) is untouched.
add_action( 'wp_footer', 'rivegosh_mobile_offcanvas_nav', 100002 );
function rivegosh_mobile_offcanvas_nav() {
    if ( is_admin() ) return;
    $home    = home_url('/');
    $items   = [
        ['Home',         $home],
        ['Login',        $home . 'login-2/'],
        ['Register',     $home . 'register/'],
        ['Account',      $home . 'account/'],
        ['My Orders',    $home . 'my-account/'],
        ['Members',      $home . 'members/'],
        ['Your Booking', $home . 'booking-vip/'],
        ['FAQ',          $home . 'faq-2/'],
    ];
    $li = '';
    foreach ( $items as $item ) {
        $li .= '<li class="menu-item"><a href="' . esc_url($item[1]) . '">' . esc_html($item[0]) . '</a></li>' . "\n";
    }
    ?>
<script id="rg-offcanvas-nav">
(function() {
  function replaceOffcanvasNav() {
    var panel = document.getElementById('offcanvas-wrapper-61861-h10');
    if (!panel) return;
    var ul = panel.querySelector('ul.colibri-menu, ul.h-menu, ul.menu, ul');
    if (!ul) return;
    ul.innerHTML = <?php echo json_encode($li); ?>;
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', replaceOffcanvasNav);
  } else {
    replaceOffcanvasNav();
  }
})();
</script>
    <?php
}
// ===== MOBILE OFFCANVAS NAV OVERRIDE END =====

// ===== LOCKED NAV MENU ASSIGNMENTS (2026-04-16) =====
// Forces correct menu IDs regardless of WP admin or CLI reassignment.
// header-menu → 86 (Header Menu, 16 items)
// content-menu → 86
// footer-menu  → 83
add_filter( 'theme_mod_nav_menu_locations', function( $locations ) {
    $locations['header-menu']  = 86;
    $locations['content-menu'] = 86;
    $locations['footer-menu']  = 83;
    return $locations;
} );
// ===== LOCKED NAV MENU ASSIGNMENTS END =====

// ===== MOBILE OFFCANVAS NAV — SERVER-SIDE REPLACEMENT (v2 — 2026-04-16) =====
// Uses wp_nav_menu_items filter (server-side, immune to LiteSpeed deferral).
// Colibri renders header-menu TWICE: 1st = desktop (ul#menu-header-menu),
// 2nd = mobile offcanvas (ul#menu-header-menu-1). We intercept the 2nd render.
// Matches the desktop VIP Client dropdown style.
add_filter( 'wp_nav_menu_items', 'rivegosh_mobile_menu_items', 10, 2 );
function rivegosh_mobile_menu_items( $items, $args ) {
    static $header_count = 0;
    if ( is_admin() ) return $items;
    if ( isset( $args->theme_location ) && $args->theme_location === 'header-menu' ) {
        $header_count++;
        if ( $header_count === 2 ) { // second render = mobile offcanvas
            $h = home_url('/');
            $items  = '<li class="menu-item rg-mob-item"><a href="' . esc_url($h) . '">Home</a></li>';
            $items .= '<li class="menu-item rg-mob-item rg-mob-divider-after"><a href="' . esc_url($h . 'login-2/') . '">Login</a></li>';
            $items .= '<li class="menu-item rg-mob-item"><a href="' . esc_url($h . 'register/') . '">Register</a></li>';
            $items .= '<li class="menu-item rg-mob-item rg-mob-sep"></li>';
            $items .= '<li class="menu-item rg-mob-item"><a href="' . esc_url($h . 'account/') . '">Account</a></li>';
            $items .= '<li class="menu-item rg-mob-item"><a href="' . esc_url($h . 'my-account/') . '">My Orders</a></li>';
            $items .= '<li class="menu-item rg-mob-item"><a href="' . esc_url($h . 'members/') . '">Members</a></li>';
            $items .= '<li class="menu-item rg-mob-item"><a href="' . esc_url($h . 'booking-vip/') . '">Your Booking</a></li>';
            $items .= '<li class="menu-item rg-mob-item"><a href="' . esc_url($h . 'faq-2/') . '">FAQ</a></li>';
        }
    }
    return $items;
}

// CSS: Style mobile nav to match desktop VIP Client dropdown
add_action( 'wp_footer', 'rivegosh_mobile_nav_v2_styles', 100003 );
function rivegosh_mobile_nav_v2_styles() {
    if ( is_admin() ) return;
    ?>
<style id="rg-mob-nav-v2">

/* Mobile offcanvas nav items — match desktop VIP Client dropdown */
#menu-header-menu-1 .rg-mob-item {
  list-style: none !important;
  padding: 0 !important;
  margin: 0 !important;
  border: none !important;
}

#menu-header-menu-1 .rg-mob-item > a {
  display: block !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 12px !important;
  font-weight: 500 !important;
  letter-spacing: 0.12em !important;
  text-transform: uppercase !important;
  color: #CCC593 !important;
  text-align: left !important;
  padding: 11px 24px !important;
  text-decoration: none !important;
  border-left: 2px solid transparent !important;
  transition: border-color 0.15s, background 0.15s !important;
}

#menu-header-menu-1 .rg-mob-item > a:hover {
  border-left-color: #CCC593 !important;
  background: rgba(204, 197, 147, 0.04) !important;
}

/* Separator line between Register and Account */
#menu-header-menu-1 .rg-mob-sep {
  display: block !important;
  height: 1px !important;
  background: rgba(204, 197, 147, 0.25) !important;
  margin: 6px 24px !important;
  padding: 0 !important;
  pointer-events: none !important;
}

</style>
    <?php
}
// ===== MOBILE OFFCANVAS NAV v2 END =====
