# HANDOVER — Rive Gosh Concierge
**Date:** 2026-04-15 11:00 | **Session:** Nav Centering + GTranslate Separation

---

## SSH Access (ready, passwordless)
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24
WP=/home/u100747640/domains/rivegosh-concierge.com/public_html
```

## Site State (verified 2026-04-14 20:12)
- WordPress 6.9.4 | WooCommerce 10.6.2 | Colibri WP 1.0.162 (parent) + rivegosh-child (active)
- **57 active plugins** / 6 inactive / 2 must-use
- **Coming Soon: OFF** ✅ — site publicly visible
- Admin email: daniel@rivegosh.com ✅
- Timezone: Europe/Paris ✅
- GTranslate: ACTIVE ✅ (FR/EN and 4 other languages)
- WC store email: daniel@rivegosh.com ✅
- Child theme: rivegosh-child active ✅

## Done This Session
- Generated 11 PNG brand assets → `brand-assets/` committed
- Uploaded 6 logos to WP media (IDs 73790–73795), set custom_logo + site_icon
- Fixed Colibri header post 61861 → logo IMAGE (not text) for desktop + mobile
- Brand CSS in post 69149: logo 49px, 30px left padding, 14px nav padding, dark overlay
- Written 17 Elementor global colors (kit ID 19) + 3 typography tokens
- Turned Coming Soon OFF (both Hostinger + WooCommerce)
- **Fixed gold sitewide (#42 CLOSED):**
  - Root cause: Colibri stores theme in FILESYSTEM file, not just DB
  - File: `wp-content/uploads/colibri/c-5894288-4d442e60-12716623-3de27865`
  - Replaced `f79007` → `CCC593` (DB: 4 hits, file: 77 hits)
  - Replaced `D6B579` → `CCC593` (DB: 16 hits, file: 1 hit + RGB)
  - Replaced `D69C32` → `CCC593` (file: 1 hit + RGB)
  - Also fixed `theme.css` static file (19 hits)
  - Browser verified: 23 headings all `rgb(204, 197, 147)` = `#CCC593` ✅
- **P1 sweep:**
  - GTranslate activated (#18 CLOSED) ✅
  - Timezone → Europe/Paris (#28 CLOSED) ✅
  - WC onboarding email → daniel@rivegosh.com (#27 CLOSED) ✅
  - Child theme scaffolded + activated (#36 CLOSED) ✅
  - topvipdriver.com → rivegosh-concierge.com: 678 replacements (#5 CLOSED) ✅
  - system360vip.com + udaantechnologies.com: already clean

- **Glassmorphic nav (#48 CLOSED — v12 final):**
  - 3 main items: 14px Cormorant Garamond, 40px gap, centered full-screen (h8 absolute overlay technique)
  - ENGLISH: Inter 11px, `position: absolute; right: 48px` pinned to header row right
  - Panels: rgba(8,8,8,0.25) + blur(28px) saturate(180%), 1px gold border, 220px wide, centered under trigger
  - Items: Inter 12px, `padding: 10px 5px 10px 8px`, word-wrap at spaces (no mid-word breaks)
  - Hover: `rgba(204,197,147,0.03)` tint + gold left-border accent
  - Mobile: rgba(8,8,8,0.95) + blur, Inter 12px
  - **Colibri h8 structure**: h3=row-container, h4=logo, h6=spacer, h8=nav column, h9=h-menu
  - CSS in WP Additional CSS post 69149
- **UX issues filed (#43–#47) + CSS fixes applied:**
  - #43 ✅ Monoton → Cormorant Garamond on interior hero heading
  - #44 ✅ 200px dead space removed (padding-bottom: 60px)
  - #45 ✅ Mobile: hero height 260px, hamburger centered, heading 28px
  - #46 ✅ GTranslate fixed to bottom, body padding-bottom added
  - #47 Queued (Phase 2): homepage marquee text run-on
- **Cookie consent fixed:** domain mismatch was causing banner to reappear — changed from www.rivegosh-concierge.com to .rivegosh-concierge.com; LiteSpeed configured to bypass cache for cmplz_ cookie holders
- **Header padding + logo sizing unified (#CSS DONE):**
  - Homepage logo: 56px (15% bigger than 49px interior)
  - Interior logo: 49px (all pages via post 61866)
  - Both headers: 48px left padding, 22px top/bottom padding
  - Both headers: dark overlay rgba(26,26,26,0.45) applied
  - CSS in post 69149, selectors: `[data-colibri-id="61861-*"]` + `[data-colibri-id="61866-*"]`
  - Browser-verified: computed styles confirmed exact px values on both pages
  - Fonts replaced sitewide: Cormorant Garamond (headings, 287x) + Inter (body, 125x)

## Launch Readiness: 68% — Going live ~2 days

### 🔴 P0 — Blocked on Daniel's decision
| Issue | Problem |
|-------|---------|
| [#22](https://github.com/rivegosh/concierge-rivegosh/issues/22) | Grace Vincent still admin |
| [#23](https://github.com/rivegosh/concierge-rivegosh/issues/23) | Stripe account ownership unknown |
| [#19](https://github.com/rivegosh/concierge-rivegosh/issues/19) | Amelia AND OVA both active — booking conflict |
| [#24](https://github.com/rivegosh/concierge-rivegosh/issues/24) | PayPal configured with Udaan Technologies — needs correct PayPal email |

### 🟠 P1 — Remaining (no decisions needed)
| Issue | Fix |
|-------|-----|
| [#5 done] | topvipdriver.com replaced ✅ |
| [#14](https://github.com/rivegosh/concierge-rivegosh/issues/14) | GA4 ID empty — need GA4 property ID from Daniel |

## Next Session: Start Here
1. **Await Daniel decisions:** Stripe (#23), Grace offboard (#22), Amelia vs OVA (#19), PayPal email (#24)
2. **GA4 (#14):** Ask Daniel for GA4 Measurement ID — 5 min fix once we have it
3. **Phase 2:** WooCommerce dark theme CSS (#37), WCFM dark theme CSS (#38) — now safe with child theme
4. **Domain migration:** When rivegosh.com DNS points to Hostinger, run:
   `wp search-replace 'rivegosh-concierge.com' 'rivegosh.com' --all-tables`

## Key Decisions Still Pending (Daniel)
1. Stripe account — whose is it? (→ #23) ← most critical before launch
2. Grace Vincent offboard — how? (→ #22)
3. Amelia vs OVA — which booking system wins? (→ #19)
4. PayPal — which email/account? (→ #24)
5. Real SMTP mailbox (→ #25)
6. GA4 Measurement ID (→ #14)
7. Real business address for WooCommerce

## CRITICAL: Colibri Architecture (must know for any color/style work)
- **Colibri stores theme data in a FILESYSTEM JSON file**, not just wp_options
- Active file: `wp-content/uploads/colibri/c-5894288-4d442e60-12716623-3de27865`
- `colibri_page_builder_use_fs` option = `c-5894288-4d442e60-12716623-3de27865` (current file ID)
- `wp search-replace` does NOT touch this file — must use `sed -i` directly on the server
- Three gold colors were hardcoded there: f79007, D6B579, D69C32 — all replaced with CCC593
- Backup files exist in same dir with `.bkp` suffix — do not confuse with active file
- **Post 61861** = Colibri header template (pre-compiled HTML with token system)
- **Post 69149** = WordPress Additional CSS (brand CSS block) — linked to `rivegosh-child` theme mods
- **Colibri Color slots**: Color 1 = primary, Color 2 was orange (now CCC593 champagne gold)
- **Elementor kit ID 19**: `_elementor_page_settings` post meta stores global color + typography tokens
- **Child theme**: `rivegosh-child` (parent: colibri-wp) — put CSS overrides in child theme functions.php
