# HANDOVER — Rive Gosh Concierge
**Date:** 2026-04-19 | **Session:** Catalog luxury reskin v2.0.0 — full dark luxury verified

---

## Current State — 2026-04-19 (end of session)

### Work completed this session

| Fix | Issue | File | Verified |
|-----|-------|------|----------|
| Affiliate Dashboard restored as 3rd top-level nav + 2 children | — | DB (menu items 74053/74057/74058) | ✅ |
| Header menu lock guard | [#78](https://github.com/rivegosh/concierge-rivegosh/issues/78) ✅ | `mu-plugins/rg-header-menu-lock.php` v1.0.0 | ✅ |
| VIP Client → /my-orders/ redirect fixed | [#79](https://github.com/rivegosh/concierge-rivegosh/issues/79) ✅ | `mu-plugins/rg-booking-vip-guest-redirect.php` v1.0.0 | ✅ |
| /login-2/ spacing tighten + dark luxury to /register/ + /my-orders/ | [#81](https://github.com/rivegosh/concierge-rivegosh/issues/81) ✅ | `mu-plugins/rg-login-page-tighten.php` v1.2.0 | ✅ |
| /appointment/ gallery hide v1.3.0 | [#82](https://github.com/rivegosh/concierge-rivegosh/issues/82) ✅ | `mu-plugins/rg-appointment-gallery-hide.php` v1.3.0 | ✅ |
| Catalog luxury reskin v2.0.0 — full dark luxury, all contrast issues resolved | [#82](https://github.com/rivegosh/concierge-rivegosh/issues/82) ✅ | `mu-plugins/rg-catalog-luxury-reskin.php` v2.0.0 | ✅ DOM-verified |

### What v2.0.0 covers (all DOM-verified on Florida destination page)

| Element | Fix | DOM result |
|---------|-----|-----------|
| Body background | `body:has(.amelia-v2-booking)` + `body.page-id-44401` | `#1A1A1A` dark |
| Colibri description paragraphs | `.h-text p` → white 15px 680px centered | `rgb(255,255,255)` |
| Service card titles | `.am-fcil__item-name` → white | `rgb(255,255,255)` |
| Service detail title | `.am-fcis .am-fcis__header-name` (3-class spec) → champagne | `rgb(204,197,147)` |
| Service/Package badge | `.am-fcis .el-tag` + `.am-fcil__item .el-tag` → champagne | verified |
| Gallery hero | `padding-top: 42%`, `background-size: contain` | car fully visible |

### CRITICAL anti-pattern documented (b3a11ac incident)

**Never change `--am-c-main-bgr` from `#0f0c08`.** Amelia uses this CSS custom property for the gallery-hero background. The dark car cutout photos need a dark field to be visible. When b3a11ac changed it to `#1A1A1A` (page-body grey), the cars vanished. Reverted via dba1649.

### Root causes documented
- **Gallery hide v1.0.0–v1.2.0 wrong**: Hid `.am-fcis__gallery` (container) → removed car photo. v1.3.0 targets only btn + thumb.
- **Dark luxury gone (white background)**: Concurrent CC sessions deleted prior catalog mu-plugins. LiteSpeed cache masked absence until cache purge.
- **Colibri h-text text dark**: Description paragraphs live in Colibri h-text blocks (NOT Amelia). Required `body:has(.amelia-v2-booking) .h-text p` — Amelia selectors never reached it.
- **am-fcis__header-name still dark**: Amelia's own rule uses `color: var(--am-c-main-text)` with higher specificity. Fix: 3-class selector `.am-fcis .am-fcis__header-name`.
- **body.page-id-44401 white below cards**: /appointment/ page has no `.amelia-v2-booking` so `:has()` rule missed it. Added explicit `body.page-id-44401` selector.

---

## MU-Plugins on server (state as of 2026-04-19)

**Protected (DO NOT DELETE):**
See CLAUDE.md Protected mu-plugins table — 9 frozen files with banners.

**Other active files on server (not in git — do not touch without reading first):**
- `rg-amelia-contrast.php` — 880+ lines, 6 wp_footer functions (catalog, wizard, WCFM dark CSS etc.)
- `rg-drawer-override.php` — LOCKED mobile drawer (DO NOT MODIFY)
- `rg-v52-card-icons.php` — LOCKED (DO NOT DELETE per auto-memory)
- `rg-amelia-capf-fix.php`, `rg-amelia-invoice-patch.php`, `rg-amelia-invoice-btn.php`
- `rg-invoices-page.php`, `rg-order-view.php`, `rg-email-as-username.php`
- `rg-login-page-guard.php` — redirects logged-IN users from /login-2/ → /booking-vip/
- `rg-health-check.php`, `rg-wcusage-login-reskin.php`, `rg-wcusage-register-reskin.php`
- `rg-pro-login-refinements.php`, `rg-v53-nav-fixes.php`
- `rg-category-page-tweaks.php` — hides `.am-fcil__filter` (Amelia search input)
- `rg-legacy-contrast-fixes.php` — v1.1.1, JS Pass 3 only fires on woocommerce-page class
- `rg-account-layout.php`, `rg-gold-account-secret-of-success.php`

---

## Header Menu Structure (as of 2026-04-18)

| Position | Parent | Children |
|----------|--------|----------|
| 1 | VIP Client (63536) → /booking-vip/ | Login, Register, Account, Reservations, Invoices, Members, FAQ |
| 2 | Professional (64806) → /vendor-membership/ | Become a Partner, Professional Account, Professional Booking Dashboard, Be an Affiliate |
| 3 | Affiliate Dashboard (74053) → /affiliate-dashboard/ | Affiliate Registration (74057), Multi Level Affiliate (74058) |

Guard `rg-header-menu-lock.php` auto-restores item 3 + its 2 children if deleted.

---

## Next Session: Start Here

1. **Pending Daniel/Roderic decisions** (blocking launch):
   - Stripe account (#23) ← most critical
   - Grace Vincent offboard (#22)
   - Amelia vs OVA (#19)
   - PayPal email (#24)
   - Real SMTP mailbox (#25)
   - GA4 Measurement ID (#14)
2. **Remaining in-progress**: #7 invoices sidebar, #9 wizard persons, #10 home grid
3. **Professional nav #69**: Daniel must test with driver account — still redirects to /my-orders/?
4. **VIP Client post-login**: Daniel must log in via VIP Client → confirm lands on /booking-vip/

---

## SSH Access (ready, passwordless)
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24
WP=/home/u100747640/domains/rivegosh-concierge.com/public_html
```

## Site State (verified 2026-04-19)
- WordPress 6.x | WooCommerce | Colibri WP + rivegosh-child
- **Coming Soon: OFF** ✅
- Header menu: 3 top-level items + submenus (locked)
- VIP Client → guests go to /login-2/?redirect_to=/booking-vip/ ✅
- LiteSpeed JS Minify/Defer: LOCKED OFF (rg-litespeed-amelia-guard.php)
- Catalog/destination pages: full dark luxury ✅ (rg-catalog-luxury-reskin.php v2.0.0)

---

## Key Technical Facts (anti-forget)

### Colibri Architecture
- Theme data: FILESYSTEM JSON at `wp-content/uploads/colibri/c-5894288-4d442e60-12716623-3de27865`
- `wp search-replace` misses it — must `sed -i` directly
- Post 61861 = header template; Post 69149 = Additional CSS

### WooCommerce / UM
- WC myaccount page = page ID 16, slug `/my-orders/`
- UM login page = page ID 73396, slug `/login-2/`
- WC overrides `wp_login_url()` → /my-orders/ (hence rg-booking-vip-guest-redirect.php exists)
- UM reads `$_REQUEST['redirect_to']` from login form — passes through post-login

### Amelia CSS battle rules (hard-won)
- `--am-c-main-bgr: #0f0c08` — NEVER change. Gallery hero uses this var; dark cars need dark field.
- Service detail title uses `color: var(--am-c-main-text) !important` — beat it with 3-class selector.
- Colibri h-text blocks are NOT inside `.amelia-v2-booking` — scope `.h-text` separately.
- `body.page-id-44401` needed explicitly — /appointment/ page has no `.amelia-v2-booking`.
- `rg-catalog-luxury-reskin.php` loads after all `rg-a*` files (alphabetical) — source-order advantage.

### Protected mu-plugins (full list in CLAUDE.md)
Never delete, never modify without explicit Roderic approval:
`rg-litespeed-amelia-guard.php` · `rg-pro-panel-unnest-card.php` · `rg-header-menu-lock.php` · `rg-booking-vip-guest-redirect.php` · `rg-v52-card-icons.php` · `rg-login-page-tighten.php` · `rg-appointment-redesign.php` · `rg-appointment-gallery-hide.php` · `rg-catalog-luxury-reskin.php`

### Launch Readiness
~70% — blocked on Roderic/Daniel decisions (Stripe, Grace, Amelia vs OVA, PayPal, SMTP)
