# HANDOVER — Rive Gosh Concierge
**Date:** 2026-04-19 | **Session:** Nav bugs + Login page CSS tighten + Gallery hide fix + Catalog luxury reskin

---

## Current State — 2026-04-19

### Work completed this session

| Fix | Issue | File | Verified |
|-----|-------|------|----------|
| Affiliate Dashboard restored as 3rd top-level nav + 2 children | — | DB (menu items 74053/74057/74058) | ✅ curl (menu-item-has-children) |
| Header menu lock guard | [#78](https://github.com/rivegosh/concierge-rivegosh/issues/78) ✅ | `mu-plugins/rg-header-menu-lock.php` v1.0.0 | ✅ self-heal proven |
| VIP Client → /my-orders/ redirect fixed | [#79](https://github.com/rivegosh/concierge-rivegosh/issues/79) ✅ | `mu-plugins/rg-booking-vip-guest-redirect.php` v1.0.0 | ✅ curl 302 → /login-2/?redirect_to=/booking-vip/ |
| /login-2/ spacing tighten + dark luxury to /register/ + /my-orders/ | [#81](https://github.com/rivegosh/concierge-rivegosh/issues/81) ✅ | `mu-plugins/rg-login-page-tighten.php` v1.2.0 | ✅ Daniel screenshot sign-off |
| /appointment/ gallery hide v1.3.0 — hides btn+thumbs, keeps car hero | [#82](https://github.com/rivegosh/concierge-rivegosh/issues/82) | `mu-plugins/rg-appointment-gallery-hide.php` v1.3.0 | ⏳ Awaiting Daniel screenshot |
| /appointment/ catalog luxury reskin v1.0.0 — dark bg, body copy fix, car sizing | [#82](https://github.com/rivegosh/concierge-rivegosh/issues/82) | `mu-plugins/rg-catalog-luxury-reskin.php` v1.0.0 | ⏳ Awaiting Daniel screenshot |

### Root causes documented
- **Gallery hide v1.0.0–v1.2.0 wrong**: Hiding `.am-fcis__gallery` (the container) also hid the car hero photo inside it. v1.3.0 corrects: hides only `.am-fcis__gallery-btn` + `.am-fcis__gallery-thumb__wrapper`.
- **Dark luxury gone (white background)**: Concurrent CC sessions deleted prior catalog form mu-plugins. LiteSpeed cache was masking the absence — purge revealed white. Root: `rg-amelia-contrast.php` has zero `am-fc*` rules; catalog reskin was in a now-deleted file. Fix: `rg-catalog-luxury-reskin.php` v1.0.0 (18ca4cf).
- **Gallery hide v1.0.0 CSS battle**: `rg-amelia-contrast.php` sets `display: flex !important` on `.amelia-v2-booking [class*="fcis__gallery"]` (specificity 0,2,0). Our bare `.am-fcis__gallery` (0,1,0) lost. Fix: nuclear specificity (1,3,1) + JS MutationObserver inline `!important`. Documented in KB #49 §25.
- **Affiliate Dashboard** deleted between 2026-04-15 and 2026-04-17 — hard-deleted from `wp_posts`, no commit trail. Silent concurrent CC session wipe. Now locked by guard.
- **VIP Client → /my-orders/**: Amelia Customer Panel (page 54773) calls `wp_login_url()` for logged-out users. WooCommerce overrides `wp_login_url()` to return WC myaccount (page ID 16, slug `/my-orders/`). Fixed by `template_redirect` priority 1 intercept.

### Chain confirmed (redirect_to flow)
UM login form on `/login-2/` reads `$_REQUEST['redirect_to']` (proven: `um-actions-misc.php:60`, `um-actions-login.php:226-227`). Page 73396 has `_um_login_use_custom_settings = 0` — no override. Full chain:
> Click VIP Client → /booking-vip/ → 302 → /login-2/?redirect_to=/booking-vip/ → user logs in → UM fires `um_safe_redirect($submitted_data['redirect_to'])` → /booking-vip/ (reservations) ✅

### Remaining assumption (must confirm with Daniel)
- **Login post-redirect**: Daniel must log in via VIP Client → confirm lands on /booking-vip/ (Amelia customer panel / Reservations) after login. This is the only untested leg of the flow.

---

## MU-Plugins on server (state as of 2026-04-18)

**Protected (DO NOT DELETE):**
See CLAUDE.md Protected mu-plugins table — 5 frozen files with banners.

**Other active files on server (not in git — do not touch without reading first):**
- `rg-amelia-contrast.php` — 880+ lines, 6 wp_footer functions (catalog, wizard, WCFM dark CSS etc.)
- `rg-drawer-override.php` — LOCKED mobile drawer (DO NOT MODIFY)
- `rg-v52-card-icons.php` — LOCKED (DO NOT DELETE per auto-memory)
- `rg-amelia-capf-fix.php`, `rg-amelia-invoice-patch.php`, `rg-amelia-invoice-btn.php`
- `rg-invoices-page.php`, `rg-order-view.php`, `rg-email-as-username.php`
- `rg-login-page-guard.php` — redirects logged-IN users from /login-2/ → /booking-vip/
- `rg-health-check.php`, `rg-wcusage-login-reskin.php`, `rg-wcusage-register-reskin.php`
- `rg-pro-login-refinements.php`, `rg-v53-nav-fixes.php`

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

1. **Daniel test**: Log in via VIP Client header → confirm /booking-vip/ (Amelia reservations) after login
2. **Professional nav #69**: Daniel must test with driver account — still redirects to /my-orders/?
3. **Verify /register/ + /my-orders/ login** visually (Daniel) — code matches /login-2/ pattern but unconfirmed screenshots
4. **Blockers pending Daniel decisions** (unchanged):
   - Stripe account (#23) ← most critical
   - Grace Vincent offboard (#22)
   - Amelia vs OVA (#19)
   - PayPal email (#24)
   - Real SMTP mailbox (#25)
   - GA4 Measurement ID (#14)
5. **Remaining in-progress**: #7 invoices sidebar, #9 wizard persons, #10 home grid

---

## SSH Access (ready, passwordless)
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24
WP=/home/u100747640/domains/rivegosh-concierge.com/public_html
```

## Site State (verified 2026-04-18)
- WordPress 6.x | WooCommerce | Colibri WP + rivegosh-child
- **Coming Soon: OFF** ✅
- Header menu: 3 top-level items + submenus (locked)
- VIP Client → guests go to /login-2/?redirect_to=/booking-vip/ (not /my-orders/) ✅
- LiteSpeed JS Minify/Defer: LOCKED OFF (rg-litespeed-amelia-guard.php)

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

### Protected mu-plugins (full list in CLAUDE.md)
Never delete, never modify without explicit Roderic approval:
`rg-litespeed-amelia-guard.php` · `rg-pro-panel-unnest-card.php` · `rg-header-menu-lock.php` · `rg-booking-vip-guest-redirect.php` · `rg-v52-card-icons.php`

### Launch Readiness
~68% — blocked on Daniel's decisions (Stripe, Grace, Amelia vs OVA, PayPal, SMTP)
