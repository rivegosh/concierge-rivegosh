<?php
/**
 * Plugin Name: RG Drawer Override (LOCKED)
 * Description: LOCKED — DO NOT MODIFY. Full mobile drawer replacement.
 *   Outputs complete #rg-drawer HTML/CSS/JS. Suppresses any duplicate from functions.php.
 *   Survives functions.php rewrites. Priority 100001 (after functions.php drawer at 99998).
 *
 * ⚠️  ANTI-REGRESSION RULES — READ BEFORE TOUCHING THIS FILE:
 *   1. Do NOT remove or modify this file without reading HANDOVER.md and KB issue #49 first.
 *   2. This file is the ONLY source of truth for the mobile hamburger drawer on this site.
 *   3. functions.php has a drawer (rivegosh_custom_drawer_v43) — it is SUPPRESSED by this file.
 *   4. The desktop nav is locked by rg-v52-card-icons.php — also DO NOT touch.
 *   5. Nav menu location lock (header-menu=86) lives in rg-v52-card-icons.php.
 *
 * Items always shown (NO login gating — all items visible to all users):
 *   Home | Login | Register | Account | My Orders | Members | Your Booking | FAQ
 *   + Professional | Affiliate Dashboard (secondary, below divider)
 */

// ── STEP 1: Suppress the functions.php drawer output entirely ─────────────────
add_action( 'wp_footer', 'rg_drawer_suppress_functions_php', 99997 );
function rg_drawer_suppress_functions_php() {
    if ( is_admin() ) return;
    // Remove rivegosh_custom_drawer_v43 before it fires (priority 99998)
    remove_action( 'wp_footer', 'rivegosh_custom_drawer_v43', 99998 );
}

// ── STEP 2: Output the complete locked drawer ─────────────────────────────────
add_action( 'wp_footer', 'rg_drawer_locked', 100001 );
function rg_drawer_locked() {
    if ( is_admin() ) return;

    // Build nav items — dynamic lookup (children of VIP Client, menu item 63536)
    $vip_kids = [];
    $pro_link = null;
    $aff_link = null;
    $menus    = wp_get_nav_menus();
    if ( $menus ) {
        foreach ( $menus as $menu ) {
            $items = wp_get_nav_menu_items( $menu->term_id );
            if ( ! $items ) continue;
            $has = false;
            foreach ( $items as $it ) {
                if ( (int) $it->ID === 63536 ) { $has = true; break; }
            }
            if ( ! $has ) continue;
            foreach ( $items as $it ) {
                if ( (int) $it->menu_item_parent === 63536 ) {
                    $vip_kids[] = [ 'title' => $it->title, 'url' => $it->url ];
                }
                if ( (int) $it->ID === 64806 ) $pro_link = [ 'title' => $it->title, 'url' => $it->url ];
                if ( (int) $it->ID === 73499 ) $aff_link = [ 'title' => $it->title, 'url' => $it->url ];
            }
            break;
        }
    }
    // Home is not a child of VIP Client in menu 86 — prepend manually
    array_unshift( $vip_kids, [ 'title' => 'Home', 'url' => home_url( '/' ) ] );

    // Fallback if dynamic lookup fails
    if ( count( $vip_kids ) < 2 ) {
        $vip_kids = [
            [ 'title' => 'Home',         'url' => home_url( '/' ) ],
            [ 'title' => 'Login',        'url' => home_url( '/login-2/' ) ],
            [ 'title' => 'Register',     'url' => home_url( '/register/' ) ],
            [ 'title' => 'Account',      'url' => home_url( '/account/' ) ],
            [ 'title' => 'My Orders',    'url' => home_url( '/my-account/' ) ],
            [ 'title' => 'Members',      'url' => home_url( '/members/' ) ],
            [ 'title' => 'Your Booking', 'url' => home_url( '/booking-vip/' ) ],
            [ 'title' => 'FAQ',          'url' => home_url( '/faq-2/' ) ],
        ];
    }
    if ( ! $pro_link ) $pro_link = [ 'title' => 'Professional',        'url' => home_url( '/vendor-membership/' ) ];
    if ( ! $aff_link ) $aff_link = [ 'title' => 'Affiliate Dashboard', 'url' => home_url( '/affiliate-dashboard-2/' ) ];
    ?>
<style id="rg-drawer-locked-css">
@media (min-width: 992px) {
  /* Hide drawer entirely on desktop */
  #rg-drawer, #rg-drawer-backdrop { display: none !important; }
}
@media (max-width: 991px) {
  /* Hide Colibri's native offcanvas — replaced by this drawer */
  #colibri .h-offcanvas-panel,
  .h-offcanvas-panel { display: none !important; }

  #rg-drawer-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.55);
    opacity: 0; pointer-events: none;
    transition: opacity 0.25s ease;
    z-index: 99998;
  }
  #rg-drawer-backdrop.rg-open { opacity: 1; pointer-events: auto; }

  #rg-drawer {
    position: fixed; top: 0; right: 0;
    width: 85vw; max-width: 360px; height: 100vh;
    background: #0a0a0a;
    padding: 40px 0 40px 0;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    z-index: 99999;
    overflow-y: auto; overflow-x: hidden;
    box-sizing: border-box;
    box-shadow: -8px 0 24px rgba(0,0,0,0.4);
  }
  #rg-drawer.rg-open { transform: translateX(0); }

  #rg-drawer-close {
    position: absolute; top: 8px; right: 8px;
    background: transparent; border: 0; cursor: pointer;
    color: #fff; font-size: 28px; line-height: 1;
    width: 36px; height: 36px; padding: 0;
    font-family: 'Inter', sans-serif; font-weight: 300;
  }
  #rg-drawer-close:hover { color: #CCC593; }

  .rg-nav { display: block; padding: 0 24px; }

  /* ── Primary nav items ── */
  .rg-nav a,
  .rg-nav a:link,
  .rg-nav a:visited {
    display: block !important;
    width: 100% !important;
    color: #CCC593 !important;
    text-align: left !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 12px !important;
    font-weight: 400 !important;
    letter-spacing: 0.08em !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    /* 25% tighter than original 10px */
    padding: 7px 5px 7px 12px !important;
    border: 0 !important;
    background: transparent !important;
    position: relative !important;
    transition: color 0.2s ease, background 0.2s ease !important;
  }
  /* Left-bar indicator: 70% height (30% shorter), vertically centred */
  .rg-nav a::before {
    content: '' !important;
    position: absolute !important;
    left: 0 !important;
    top: 15% !important;
    height: 70% !important;
    width: 2px !important;
    background: transparent !important;
    transition: background 0.2s ease !important;
  }
  .rg-nav a:hover,
  .rg-nav a:focus,
  .rg-nav a:active {
    color: #CCC593 !important;
    background: rgba(204,197,147,0.03) !important;
    outline: none;
  }
  .rg-nav a:hover::before,
  .rg-nav a:focus::before,
  .rg-nav a:active::before { background: #CCC593 !important; }

  /* ── Secondary items (Professional, Affiliate Dashboard) ── */
  .rg-nav a.rg-secondary {
    font-size: 11px !important;
    padding: 5px 5px 5px 12px !important;
  }

  .rg-divider {
    height: 1px; background: rgba(255,255,255,0.15);
    margin: 10px 16px 4px 16px;
  }
  .rg-footer-text {
    margin-top: 20px; padding: 14px 0 0 0;
    border-top: 1px solid rgba(255,255,255,0.08);
    text-align: center;
    color: rgba(255,255,255,0.35);
    font-family: 'Inter', sans-serif;
    font-size: 11px; letter-spacing: 0.08em;
  }
  body.rg-drawer-open .gt_white_content,
  body.rg-drawer-open .gt_switcher_wrapper,
  body.rg-drawer-open .gt_float_switcher,
  body.rg-drawer-open [class*="gt_switcher"] {
    display: none !important; opacity: 0 !important; pointer-events: none !important;
  }
  body.rg-drawer-open { overflow: hidden !important; }

  /* ── Logo: top aligns with hamburger top. Site-wide. ── */
  .rg-fixed-logo {
    top: 18px !important;
    position: absolute !important;
  }
  /* ── Logo 25% smaller (was 55px in functions.php) site-wide ── */
  .rg-fixed-logo img {
    height: 41px !important;
    width: auto !important;
  }

  /* ── Interior hero (61866-h25): zoom top-left, shift image 70px left.
     200% width = 2x zoom (shows top-left 1/4 of image).
     background-position-x: -70px moves image left so driver appears left in frame. ── */
  #colibri [data-colibri-id="61866-h25"],
  #colibri [data-colibri-id="61866-h25"] .paraxify,
  #colibri [data-colibri-id="61866-h25"] .background-layer {
    background-position: -70px 0px !important;
    background-size: 200% auto !important;
  }

  /* ── Banner height: 154px (30% less than 220px), zero padding ── */
  #colibri [data-colibri-id="61866-h25"] {
    min-height: 180px !important;
    padding-bottom: 0 !important;
  }

  /* ── Hero section: position:relative needed for arrow bottom:4px to work ── */
  #colibri [data-colibri-id="61866-h25"] {
    position: relative !important;
  }

  /* ── Push hero content DOWN to clear the logo (41px logo + 18px top = 59px clearance needed) ── */
  #colibri [data-colibri-id="61866-h28"] {
    margin-top: 30px !important;
    display: block !important;
  }

  /* ── Remove nav-height compensation so content sits at top of hero. ── */
  #colibri [data-colibri-id="61866-h25"] .h-navigation-padding {
    padding-top: 0 !important;
  }

  /* ── Interior hero heading: smaller font, tighter line-height. Site-wide mobile.
     Colibri sets 4em / line-height 1.6. Reduce by ~2pt → 3.75em. LH = font+25% = 1.25. ── */
  #colibri [data-colibri-id="61866-h28"] h1,
  #colibri [data-colibri-id="61866-h28"] h2,
  #colibri [data-colibri-id="61866-h28"] h3,
  #colibri [data-colibri-id="61866-h28"] p {
    font-size: 20px !important;
    line-height: 25px !important;
  }

  /* ── Interior mobile nav: dark background — kills white strip on scroll ── */
  #colibri [data-colibri-id="61866-h2"],
  #colibri [data-colibri-id="61866-h2"].h-navigation_sticky {
    background: transparent !important;
    box-shadow: none !important;
  }

  /* ── Interior mobile hamburger icon: white lines visible on dark bg ── */
  #colibri [data-colibri-id="61866-h2"] .h-hamburger-button span,
  #colibri [data-colibri-id="61866-h2"] .navbar-toggler-icon,
  #colibri [data-colibri-id="61866-h2"] .h-hamburger-button .icon-bar {
    background: #CCC593 !important;
  }

  /* ── Scroll arrow: push to bottom edge of banner ── */
  #colibri .style-local-61866-h29-outer,
  #colibri [data-colibri-id="61866-h29"] {
    bottom: 4px !important;
  }
}
</style>

<div id="rg-drawer-backdrop"></div>
<aside id="rg-drawer" aria-hidden="true" role="dialog" aria-label="Main menu">
  <button id="rg-drawer-close" type="button" aria-label="Close menu">&times;</button>
  <nav class="rg-nav">
    <?php foreach ( $vip_kids as $k ): ?>
      <a href="<?php echo esc_url( $k['url'] ); ?>"><?php echo esc_html( $k['title'] ); ?></a>
    <?php endforeach; ?>
    <div class="rg-divider"></div>
    <a class="rg-secondary" href="<?php echo esc_url( $pro_link['url'] ); ?>"><?php echo esc_html( $pro_link['title'] ); ?></a>
    <a class="rg-secondary" href="<?php echo esc_url( $aff_link['url'] ); ?>"><?php echo esc_html( $aff_link['title'] ); ?></a>
    <div class="rg-footer-text">RIVE GOSH CONCIERGE<br>&copy; 2026</div>
  </nav>
</aside>

<script id="rg-drawer-locked-js" data-no-optimize="1">
(function(){
  var drawer   = document.getElementById('rg-drawer');
  var backdrop = document.getElementById('rg-drawer-backdrop');
  var closeBtn = document.getElementById('rg-drawer-close');
  if (!drawer || !backdrop) return;

  function openDrawer()  {
    drawer.classList.add('rg-open');
    backdrop.classList.add('rg-open');
    document.body.classList.add('rg-drawer-open');
    drawer.setAttribute('aria-hidden','false');
  }
  function closeDrawer() {
    drawer.classList.remove('rg-open');
    backdrop.classList.remove('rg-open');
    document.body.classList.remove('rg-drawer-open');
    drawer.setAttribute('aria-hidden','true');
  }

  // Capture phase — intercepts before Colibri's handler
  document.addEventListener('click', function(e) {
    if (window.innerWidth > 991) return;
    var burger = e.target && e.target.closest &&
      e.target.closest('.h-hamburger-button, .h-navbar-toggler, [data-colibri-component="offcanvas-button"], .navbar-toggler');
    if (burger) { e.preventDefault(); e.stopImmediatePropagation(); openDrawer(); }
  }, true);

  closeBtn.addEventListener('click', closeDrawer);
  backdrop.addEventListener('click', closeDrawer);
  document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeDrawer(); });

  // Belt-and-suspenders: keep Colibri panel hidden
  setInterval(function() {
    var p = document.querySelector('.h-offcanvas-panel');
    if (p) p.style.display = 'none';
  }, 750);
})();
</script>
    <?php
}

// ── STEP 3: Fix contextual hero text JS (prevents h2 from being destroyed) ──────────────────────
// functions.php uses [class*="h-heading"] which matches the OUTER wrapper div first,
// destroying the inner h2. Fix: suppress it and re-output with h1-h5 selectors only.
add_action( 'wp_footer', 'rg_suppress_hero_text', 99998 );
function rg_suppress_hero_text() {
    remove_action( 'wp_footer', 'rivegosh_contextual_hero_text', 99999 );
}

add_action( 'wp_footer', 'rg_contextual_hero_text_fixed', 100002 );
function rg_contextual_hero_text_fixed() {
    if ( is_admin() ) return;
    $map = [
        73400 => "WELCOME BACK",
        73401 => "JOIN THE\nPRIVATE CIRCLE",
        73404 => "YOUR\nPRIVATE SPACE",
        16    => "YOUR\nPRIVATE SPACE",
        54773 => "YOUR EXCLUSIVE\nITINERARY",
        73402 => "YOUR\nMEMBER SPACE",
        61943 => "FREQUENTLY ASKED\nQUESTIONS",
    ];
    $id  = get_the_ID();
    if ( ! isset( $map[$id] ) ) return;
    $html = nl2br( esc_html( $map[$id] ) );
    ?>
<script id="rg-hero-text-fixed" data-no-optimize="1">
(function(){
  var newHtml = <?php echo json_encode($html); ?>;
  function swap(){
    // FIXED: only h1-h5 tags — NOT .h-heading wrapper divs.
    // The old selector [class*="h-heading"] matched the outer wrapper div first (DOM order),
    // replaced its innerHTML with plain text, destroying the inner <h2>.
    // With no h2 in DOM, all CSS selectors targeting h2 children had nothing to match.
    var heroes = document.querySelectorAll(
      '.h-section.h-hero h1, .h-section.h-hero h2, .h-section.h-hero h3, ' +
      '.h-section.h-hero h4, .h-section.h-hero h5'
    );
    heroes.forEach(function(el){
      var t = el.textContent.trim().toUpperCase();
      if(t.includes('DESTINATION') || t.includes('YOUR ') || t.includes('WELCOME') ||
         t.includes('PREMIUM') || t.includes('FREQUENTLY')){
        el.innerHTML = newHtml;
      }
    });
  }
  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', swap);
  } else { swap(); }
})();
</script>
    <?php
}
