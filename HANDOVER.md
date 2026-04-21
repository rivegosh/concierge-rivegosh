# HANDOVER — Rive Gosh Concierge
**Date:** 2026-04-21 | **Session:** Amelia smoke test + mailService fix + cart CSS + Coming Soon

---

## Current State — 2026-04-21 (end of session)

### Work completed this session

| Fix | File / Location | Change | Verified |
|-----|-----------------|--------|----------|
| Amelia mailService `'wp'` → `'wp_mail'` | DB `wp_options.amelia_settings` | `notifications.mailService` corrected via `$wpdb->update()` with `json_encode()`. Was falling through `MailerFactory` to PHP `mail()` directly, bypassing WP Mail SMTP | ✅ WP-CLI + wpmailsmtp_emails_log entries 1487-1489 (sendinblue) |
| Amelia booking smoke test | SSH + WP-CLI `eval-file` | Appointments 145 + 146 created via `AddBookingCommandHandler`. Customer + provider notification emails both delivered via Brevo | ✅ appointment IDs confirmed, email log verified |
| WC Coming Soon mode OFF | `wp option update woocommerce_coming_soon no` | Was blocking `wcfm_vendor` users (incl. `daniel@rivegosh-concierge.com`) from accessing cart/checkout | ✅ WP-CLI: `no` |
| Cart CSS — 3 targeted fixes | `mu-plugins/rg-cart-coming-soon-fix.php` v1.0.0 (new, commit 47d7383) | (1) WC Coming Soon block black text → champagne, (2) Amelia cart item meta black → champagne, (3) nav `.sub-menu` links global black → champagne. Priority 100000 | ✅ deployed + purged + git committed |
| CLAUDE.md Rules 16–19 | `CLAUDE.md` (commit dd1057d) | Added rules for: Amelia mailService, amelia_settings JSON storage, runInstantPostBookingActions CLI gate, WC Coming Soon vendor block | ✅ pushed to GitHub |
| KB #49 updated | GH issue #49 | Added §"WC Coming Soon blocks non-admin users" | ✅ |
| Master Index #34 updated | GH issue #34 | Added #88, #90, #91 to Amelia Email section | ✅ |
| Issue #90 closed | GH issue #90 | mailService fix verified — closed with evidence | ✅ |

### What still needs Daniel to verify

- **Full Amelia → cart → checkout flow** as `daniel@rivegosh-concierge.com` (wcfm_vendor) — was blocked by Coming Soon, should now work end-to-end
- **Cart page visuals** — confirm cart item meta (transfer type, date, airport, passengers) is readable champagne text (fixed by rg-cart-coming-soon-fix.php)
- **Nav sub-menus** — confirm dropdown nav links are visible champagne text (not black-on-dark)
- **Google Maps autocomplete + route map** — still waiting on Daniel to enable Maps JS API + Directions API on GCP project "Rive Gosh" (gen-lang-client-0317106618)

### ⚠️ Key discovery: wcfm_vendor role + WC Coming Soon

`woocommerce_coming_soon=yes` + `woocommerce_store_pages_only=yes` blocks ANY user without `manage_woocommerce` capability from `/your-booking/` and `/checkout/`. The `wcfm_vendor` role does NOT have this capability → `daniel@rivegosh-concierge.com` (user 462, wcfm_vendor) was silently blocked from completing Amelia→WooCommerce payment flow.

**Now fixed:** `woocommerce_coming_soon=no`. `woocommerce_store_pages_only` is still `yes` (inert).

### ⚠️ Amelia mailService — never revert

`amelia_settings.notifications.mailService` MUST be `'wp_mail'` (exact string). If set to `'wp'`, Amelia falls through `MailerFactory` to PHP `mail()` directly:
- Bypasses WP Mail SMTP → Brevo
- Bypasses `rg-mail-reply-to-guard.php`  
- Hostinger 100/day rate cap applies
- No email logging visible in WP Mail SMTP

If Amelia plugin update resets this: fix via `$wpdb->update()` with `json_encode()` — NEVER `update_option()` with a PHP array (crashes Amelia).

### ⚠️ rg-mail-reply-to-guard.php — the "keep Daniel at Rivegosh Concierge" script

`mu-plugins/rg-mail-reply-to-guard.php` v1.1.0 (sealed, commit abd6c6f) strips any `Reply-To` header not on `@rivegosh-concierge.com` or `@rivegosh.com`. Hostinger's inbound filter soft-bounces every email with an external `Reply-To` — WCFM sets `Reply-To` to the buyer's email (gmail, yahoo, etc.) → all vendor notifications bounced silently before this fix. Verified via Brevo events API TEST 2–8. See GH issue #88.

---

## Previous State — 2026-04-20 (end of session, Google Maps + CSS pass)

### Work completed that session

| Fix | File | Change | Verified |
|-----|------|--------|----------|
| Address fields 20/21/27 wrong type | DB + stash | `type=text` → `type=address` in `wp_amelia_custom_fields` + stash rebuild | ✅ `window.ameliaEntities` |
| Google Maps route panel | `rg-booking-maps-display.php` (new) | MutationObserver → InfoStep → injects dark `#rg-map-panel` → DirectionsService route | ✅ script loads |
| Map fallback mode | `rg-booking-maps-display.php` | Detects `.gm-err-container` → dark luxury fallback + "View Route on Google Maps" link | ✅ code-verified |
| Suitcase/passenger dropdown invisible | `rg-amelia-select-dropdown-contrast.php` v1.1.0 (new) | Dark luxury for teleported Element Plus popper + collapsed trigger | ✅ CSS deployed |
| Nav dropdowns broken on WC pages | `rg-misc-css.php` | `position:relative` on `li.menu-item-has-children` | ✅ screenshot |
| Vendor notifications silently bouncing | `rg-mail-reply-to-guard.php` v1.1.0 (new) | Strip external `Reply-To` headers on `wp_mail` | ✅ Brevo TEST 7+8 |
| Checkout luxury skin | `rg-checkout-luxury.php` v1.0.0, `rg-checkout-luxury-skin.php` v1.0.0 | Dark luxury for /checkout/ with `is_wc_endpoint_url('order-received')` guard | ✅ |
| git sync — 15 server-only files | commit abd6c6f | Pulled all server-deployed plugins into git | ✅ committed |

### ⚠️ GCP BLOCKER — Daniel must do this

Maps tile rendering and autocomplete require Google Cloud APIs. **Must use Daniel's Google account, NOT Roderic's.**

Daniel steps:
1. `console.cloud.google.com` → sign in with **your own Google account**
2. Switch project to **"Rive Gosh"** (ID: `gen-lang-client-0317106618`)
3. APIs & Services → Library → enable **"Maps JavaScript API"** + **"Directions API"**
4. Link billing account when prompted

Phase B also needs: **"Distance Matrix API"** (for surcharge calculation).

---

## Next Session: Start Here

1. **Daniel visual confirms needed:**
   - Full Amelia → cart → checkout payment flow as wcfm_vendor user (now unblocked)
   - Cart item meta text readable (rg-cart-coming-soon-fix.php)
   - Nav sub-menu links visible
   - Google Maps autocomplete (after GCP blocker resolved)

2. **Pending decisions blocking launch:**
   - Stripe account ownership — [#23](https://github.com/rivegosh/concierge-rivegosh/issues/23) ← most critical
   - Grace Vincent offboard — [#22](https://github.com/rivegosh/concierge-rivegosh/issues/22)
   - Amelia vs OVA booking system — [#19](https://github.com/rivegosh/concierge-rivegosh/issues/19)
   - Real SMTP mailbox — [#25](https://github.com/rivegosh/concierge-rivegosh/issues/25)
   - GA4 Measurement ID — [#14](https://github.com/rivegosh/concierge-rivegosh/issues/14)

3. **In progress:** #7 invoices sidebar, #9 wizard persons, #10 home grid

4. **Professional nav #69**: Daniel must test with driver account

---

## SSH Access (ready, passwordless)
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24
WP="wp --path=/home/u100747640/domains/rivegosh-concierge.com/public_html"
MUP="/home/u100747640/domains/rivegosh-concierge.com/public_html/wp-content/mu-plugins"
LSCSS="/home/u100747640/domains/rivegosh-concierge.com/public_html/wp-content/litespeed/css"
```

## Site State (verified 2026-04-21)
- WordPress 6.x | WooCommerce | Colibri WP + rivegosh-child
- **Coming Soon: OFF** ✅ (`woocommerce_coming_soon=no`)
- **Amelia mailService: wp_mail** ✅ → routes through WP Mail SMTP → Brevo
- LiteSpeed JS Minify/Defer: LOCKED OFF (`rg-litespeed-amelia-guard.php`)
- Header menu: 3 top-level items + submenus (locked)
- Catalog/destination pages: full dark luxury ✅ (`rg-catalog-luxury-reskin.php` v2.0.0)
- VIP Client → guests → `/login-2/?redirect_to=/booking-vip/` ✅
- Reply-To guard active ✅ (`rg-mail-reply-to-guard.php` v1.1.0)
- Protected mu-plugins: 15 sealed files (full list in CLAUDE.md)

---

## Key Technical Facts (anti-forget)

### Colibri Architecture
- Theme data: FILESYSTEM JSON at `wp-content/uploads/colibri/c-5894288-4d442e60-12716623-3de27865`
- `wp search-replace` misses it — must `sed -i` directly
- Post 61861 = header template; Post 69149 = Additional CSS

### WooCommerce / UM
- WC myaccount page = page ID 16, slug `/my-orders/`
- UM login page = page ID 73396, slug `/login-2/`
- WC overrides `wp_login_url()` → /my-orders/ (hence `rg-booking-vip-guest-redirect.php`)
- `wcfm_vendor` role does NOT have `manage_woocommerce` — affects WC Coming Soon access

### Key User IDs
| ID | Email | Role |
|----|-------|------|
| 1 | gracevincentstripe@gmail.com | administrator (original — Stripe owner, DO NOT TOUCH) |
| 81 | myvipcab2025@gmail.com (Daniel) | administrator |
| 462 | daniel@rivegosh-concierge.com | wcfm_vendor |

### Amelia CSS battle rules (hard-won)
- `--am-c-main-bgr: #0f0c08` — NEVER change. Gallery hero uses this var; dark cars need dark field.
- Service detail title uses `color: var(--am-c-main-text) !important` — beat it with 3-class selector.
- Colibri h-text blocks are NOT inside `.amelia-v2-booking` — scope `.h-text` separately.
- `body.page-id-44401` needed explicitly — /appointment/ page has no `.amelia-v2-booking`.

### Protected mu-plugins (full list in CLAUDE.md)
15 sealed files — never delete, never modify without explicit Roderic approval.

### Launch Readiness
~75% — blocked on Daniel decisions (Stripe, Grace, Amelia vs OVA, SMTP) + GCP Maps API
