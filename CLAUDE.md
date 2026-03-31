# Concierge Rive Gosh

## Project Overview

WordPress + WooCommerce marketplace migration. Rebranding "Top VIP Driver" (VTC/luxury transport booking platform) to "Concierge Rive Gosh."

**Business:** B2B/B2C luxury concierge platform with 5-level MLM affiliate system for VTC (chauffeur) drivers across France and the US.

**Repo:** https://github.com/rivegosh/concierge-rivegosh
**Master Index:** https://github.com/rivegosh/concierge-rivegosh/issues/2

---

## Project Management

**GitHub IS the project manager.** Everything lives in GitHub:
- Issues for all work, decisions, and tracking
- CLAUDE.md for AI project context (this file)
- Master Index issue (#2) is the roadmap

**No loose .md files** — if it's not in GitHub issues or CLAUDE.md, it doesn't exist.

---

## Current State (2026-03-31)

**Phase:** Pre-migration audit complete. Waiting on business decisions.

**Critical blocker:** The September 2025 SQL dump is incomplete — missing all core WordPress options. See [#1](https://github.com/rivegosh/concierge-rivegosh/issues/1).

**What's in this repo now:** A static HTML/Netlify prototype (NOT the WordPress site). This will likely be replaced with WordPress code or kept as a separate reference.

---

## Tech Stack

| Component | Technology |
|-----------|------------|
| CMS | WordPress 6.x |
| E-commerce | WooCommerce |
| Marketplace | WC Frontend Manager (WCFM) + Multivendor |
| Booking | OVA Booking (ova-brw) |
| Payments | Stripe (4 plugins — gateway, payments, split-pay, tax) |
| Affiliate/MLM | WCFM Affiliate + BSD Split Pay |
| Page Builder | Elementor + Pro |
| Theme | Colibri WP (v1.0.144) |
| Compliance | Complianz GDPR Premium |
| i18n | GTranslate (FR/EN) |
| Hosting | TBD (previously Hostinger) |

---

## Key Data

| Fact | Value |
|------|-------|
| Users | 54 (drivers + admins) |
| Plugins on disk | 69 |
| Plugins confirmed active | 16 (April 2025 snapshot) |
| Plugins added April–Sept 2025 | ~47 (status unknown — Sept dump incomplete) |
| Domain references in DB | 124,941 (`topvipdriver.com`) |
| DB tables | 226 |
| Original admin email | gracevincentstripe@gmail.com |
| Original site name | VTC Booking → Top VIP Driver |
| Currency | USD |
| Default country | US:CA |

---

## Site History

| Phase | Domain | Theme | Period |
|-------|--------|-------|--------|
| VTC Booking | vtc.udaantechnologies.com | Entox (child) | Pre-April 2025 |
| Top VIP Driver | topvipdriver.com | Colibri WP | April–Sept 2025 |
| Concierge Rive Gosh | TBD | TBD | Now |

---

## Local File Locations

| Asset | Path |
|-------|------|
| WordPress source code | `~/Downloads/system360vip.com/public_html/` |
| September 2025 SQL dump | `~/Downloads/system360vip.com/public_html/wp-content/uploads/2025/09/u454088328_ULgtS.20250921064346.sql_.gz.txt` |
| April 2025 Updraft backup | `~/Downloads/system360vip.com/public_html/wp-content/updraft/backup_2025-04-22-1221_VTC_Booking_30ab03c8574d-db.gz` |
| Deployment zip (no media) | `~/Downloads/system360vip.com/rive-gosh-wp-files.zip` (509MB) |

---

## Open Decisions

Track in GitHub issues with `decision-needed` label.

1. New domain name — [#3](https://github.com/rivegosh/concierge-rivegosh/issues/3)
2. Hosting provider — [#3](https://github.com/rivegosh/concierge-rivegosh/issues/3)
3. Hostinger panel access for fresh DB dump — [#1](https://github.com/rivegosh/concierge-rivegosh/issues/1)
4. Plugin license keys/transfers — [#7](https://github.com/rivegosh/concierge-rivegosh/issues/7)
5. Stripe account ownership — [#8](https://github.com/rivegosh/concierge-rivegosh/issues/8)
6. Media recovery (2.8GB stripped) — [#2](https://github.com/rivegosh/concierge-rivegosh/issues/2)

---

## Conventions

- All work tracked as GitHub issues
- Issue labels: P0-critical, P1-high, P2-medium, P3-low, migration, security, rebranding, decision-needed
- DU estimates on every issue
- Master Index ([#2](https://github.com/rivegosh/concierge-rivegosh/issues/2)) is the roadmap — keep updated
- WordPress migration uses WP-CLI for search-replace (never raw SQL on serialized data)
