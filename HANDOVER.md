# HANDOVER — Rive Gosh Concierge
**Date:** 2026-04-14 | **Session:** Brand Assets + WordPress Installation

---

## SSH Access (ready, passwordless)
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24
WP=/home/u100747640/domains/rivegosh-concierge.com/public_html
```

## Site State (verified 2026-04-14)
- WordPress 6.9.4 | WooCommerce 10.6.2 | Colibri WP 1.0.162 | Elementor 4.0.2
- **56 active plugins** / 6 inactive / 2 must-use
- **Coming Soon: OFF** ✅ — site publicly visible
- Admin email: daniel@rivegosh.com ✅
- DB: 298MB | Uploads: 3.7GB | Disk total: 17GB

## Done This Session
- Generated 11 PNG brand asset variants → `brand-assets/` committed + pushed
- Uploaded 6 logos to WordPress media library (IDs: 73790–73795)
- Set `custom_logo` ID 73790 (Rive Gosh Concierge stacked, header)
- Set `site_icon` ID 73792 (RG favicon-512)
- Set WooCommerce email header to `logo-email.png`
- Written 17 Elementor global colors to kit ID 19 via WP-CLI
- Written 3 Elementor typography tokens (Cormorant Garamond + Inter)
- Flushed Elementor CSS cache — all changes live
- Turned Coming Soon OFF
- Updated Master Index #34, issue #15, issue #40 (closed), issue #41
- Issued #36–#40 assigned to Phase 2 milestone

## Launch Readiness: 45% — Going live ~2 days

### 🔴 P0 — Blocked on Daniel's decision
| Issue | Problem |
|-------|---------|
| [#22](https://github.com/rivegosh/concierge-rivegosh/issues/22) | Grace Vincent still admin |
| [#23](https://github.com/rivegosh/concierge-rivegosh/issues/23) | Stripe account ownership unknown |
| [#19](https://github.com/rivegosh/concierge-rivegosh/issues/19) | Amelia AND OVA both active — booking conflict |

### 🟠 P1 — Ready to fix NOW (no decisions needed)
| Issue | Fix |
|-------|-----|
| [#18](https://github.com/rivegosh/concierge-rivegosh/issues/18) | GTranslate inactive: `wp plugin activate gtranslate` |
| [#28](https://github.com/rivegosh/concierge-rivegosh/issues/28) | Timezone empty: `wp option update timezone_string Europe/Paris` |
| [#27](https://github.com/rivegosh/concierge-rivegosh/issues/27) | WC onboarding store_email = Grace's email |
| [#24](https://github.com/rivegosh/concierge-rivegosh/issues/24) | PayPal config → Udaan Technologies email |
| [#36](https://github.com/rivegosh/concierge-rivegosh/issues/36) | Child theme scaffold (needed for WC/WCFM CSS) |

### 🔴 P0 — Logo/branding (brand assets done ✅, below still pending)
| Issue | Status |
|-------|--------|
| [#15](https://github.com/rivegosh/concierge-rivegosh/issues/15) | Colibri header logo width verify in browser |

## Next Session: Start Here
1. **Verify in browser:** Open rivegosh-concierge.com — confirm logo shows in header, favicon in tab
2. **Quick P1 fixes** (no decisions): activate GTranslate (#18) + fix timezone (#28) + fix WC email (#27)
3. **Child theme scaffold** (#36): `wp scaffold child-theme rivegosh-child --parent_theme=colibri-wp`
4. **Await Daniel:** Stripe (#23) + Grace offboard (#22) + Amelia vs OVA (#19)

## Key Decisions Still Pending (Daniel)
1. Stripe account — whose is it? (→ #23) ← most critical before launch
2. Grace Vincent offboard — how? (→ #22)
3. Amelia vs OVA — which booking system wins? (→ #19)
4. Real business address for WooCommerce
5. Real SMTP mailbox (→ #25)
