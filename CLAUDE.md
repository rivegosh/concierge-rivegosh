# Rive Gosh

## NON-NEGOTIABLE: KB #49 FIRST

**Before ANY design or design-tech work on this site, read [Issue #49](https://github.com/rivegosh/concierge-rivegosh/issues/49) in full.**

"Design or design-tech work" means anything involving: CSS, header, nav, logo, sticky behavior, Colibri theme, mobile layout, fonts, colors, brand assets, GTranslate positioning, WooCommerce styling, LiteSpeed cache, or any visual element on the site.

This rule has no exceptions. Skipping it has repeatedly caused regressions. Read #49, then begin.

---

## Project Overview

WordPress + WooCommerce marketplace migration. Rebranding "Top VIP Driver" (VTC/luxury transport booking platform) to "Rive Gosh."

**Business:** B2B/B2C luxury concierge platform with 5-level MLM affiliate system for VTC (chauffeur) drivers across France and the US.

**Repo:** https://github.com/rivegosh/concierge-rivegosh
**Master Index:** https://github.com/rivegosh/concierge-rivegosh/issues/34

---

## Project Management

**GitHub IS the project manager.** Everything lives in GitHub:
- Issues for all work, decisions, and tracking
- Milestones act as project folders (Phase 1/2/3/4, Ongoing)
- CLAUDE.md for AI project context (this file)
- **[Master Index #34](https://github.com/rivegosh/concierge-rivegosh/issues/34)** is the pinned Table of Contents — the "Issue Zero"

**No loose .md files** — if it's not in GitHub issues or CLAUDE.md, it doesn't exist.

### Issue Zero Convention (applies to all projects)

Every project has ONE pinned issue that serves as the Master Index / Table of Contents. Update it whenever:
- A new milestone is created
- A P0/P1 issue is filed
- A phase completes

Every new issue gets: milestone assignment + priority label (P0/P1/P2) + category label.

---

## Current State (2026-03-31)

**Phase:** Daniel setting up site on Hostinger. Domain: rivegosh.com. Brand: Rive Gosh.

**Status:** Daniel is handling hosting setup and plugin activation directly. Domain rivegosh.com registered on Namecheap (created 10 Feb 2026), transferring to Hostinger.

**What's in this repo now:** CLAUDE.md + HANDOVER.md only. The Netlify prototype was deleted (commit 6294c48). The live site runs on Hostinger — this repo is the AI working context and project governance layer, not a code repo.

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
| Hosting | Hostinger (confirmed 4 Apr 2026) |

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
| Rive Gosh | rivegosh.com | TBD | Now |

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

Track in GitHub issues with `decision-needed` label. See [Master Index #34](https://github.com/rivegosh/concierge-rivegosh/issues/34) for full list.

**Blocking launch (Daniel must decide):**
1. Stripe account ownership — [#23](https://github.com/rivegosh/concierge-rivegosh/issues/23) ← most critical
2. Grace Vincent offboard method — [#22](https://github.com/rivegosh/concierge-rivegosh/issues/22)
3. Amelia vs OVA booking system — [#19](https://github.com/rivegosh/concierge-rivegosh/issues/19)
4. Real business address for WooCommerce store settings
5. Real SMTP mailbox (currently `name@rivegosh-concierge.com` placeholder) — [#25](https://github.com/rivegosh/concierge-rivegosh/issues/25)

**Resolved (archived):** domain (#3 → rivegosh-concierge.com), hosting (#3 → Hostinger confirmed Apr 2026), admin email (#17 → daniel@rivegosh.com ✅)

---

## Conventions

- All work tracked as GitHub issues
- Issue labels: P0-critical, P1-high, P2-medium, P3-low, migration, security, rebranding, decision-needed
- **Master Index: [#34](https://github.com/rivegosh/concierge-rivegosh/issues/34)** — pinned, always read first
- WordPress migration uses WP-CLI for search-replace (never raw SQL on serialized data)
- **REWRITE issues, never comment.** New findings → edit the issue body directly (`gh issue edit`). Comments = noise. The body = current truth. Comments only for external stakeholders (e.g., Daniel decision requests).
- **PNG only for all logos** — no SVG, no Safe SVG plugin. PNG-24 with transparency for site; PNG with dark background baked in for email.

---

## 🛑 Protected mu-plugins (DO NOT DELETE / DO NOT MODIFY without asking Roderic)

Each of these is a **frozen, signed-off fix** with a `DO NOT DELETE` banner in its file header. They exist because a specific regression was diagnosed, fixed, and verified. If the behavior they protect looks wrong later, **fix the cause in a NEW mu-plugin** — do NOT edit these files.

| File | Version | Commit of record | Issue | Why it exists |
|------|---------|-----|-----|---------------|
| `mu-plugins/rg-litespeed-amelia-guard.php` | 1.0.1 | [43dcc68](https://github.com/rivegosh/concierge-rivegosh/commit/43dcc68) | [#75](https://github.com/rivegosh/concierge-rivegosh/issues/75) | Locks LiteSpeed `optm-js_min=0` + `optm-js_defer=0` on every `admin_init`. If flipped on, Amelia webpack dynamic imports 404 → blank `/booking-pro-panel/` + broken wizard. |
| `mu-plugins/rg-pro-panel-unnest-card.php` | 1.0.3 | [9fbccfc](https://github.com/rivegosh/concierge-rivegosh/commit/9fbccfc) | [#75](https://github.com/rivegosh/concierge-rivegosh/issues/75) | Strips outer `.am-auth` card + inner `.el-input__wrapper`/`.el-input__inner`/raw input borders on page-id-54778. Without this, two mu-plugins compete and render THREE nested cards + THREE nested input borders per field. |
| `mu-plugins/rg-header-menu-lock.php` | 1.0.0 | [afc7524](https://github.com/rivegosh/concierge-rivegosh/commit/afc7524) | [#78](https://github.com/rivegosh/concierge-rivegosh/issues/78) | Auto-restores Affiliate Dashboard top-level + 2 children (Affiliate Registration → page 63619, Multi Level Affiliate → page 71558) in header-menu on `admin_init` if missing. Guards against silent DB deletions (menu-item-73499 was hard-deleted between 04-15 and 04-17 with no commit trail). |
| `mu-plugins/rg-booking-vip-guest-redirect.php` | 1.0.0 | [2087687](https://github.com/rivegosh/concierge-rivegosh/commit/2087687) | [#79](https://github.com/rivegosh/concierge-rivegosh/issues/79) | Intercepts logged-out users on /booking-vip/ (Amelia Customer Panel) before Amelia's own redirect fires. Sends to /login-2/?redirect_to=/booking-vip/ instead of /my-orders/ (WC override of wp_login_url). |
| `mu-plugins/rg-v52-card-icons.php` | — | — | — | (Inherited from prior session — DO NOT DELETE per auto-memory feedback.) |
| `mu-plugins/rg-login-page-tighten.php` | 1.2.0 | [4c2f763](https://github.com/rivegosh/concierge-rivegosh/commit/4c2f763) | [#81](https://github.com/rivegosh/concierge-rivegosh/issues/81) | Strips double card on /login-2/ UM form (rg-amelia-contrast.php applied card CSS to both .um-73396 AND its child .um-form). Tightens spacing. Extends dark luxury to /register/ (um-73395) and /my-orders/ (WC form). |

**Protocol for modifying a banner-protected file:**
1. Open a GH issue describing the proposed change and the regression risk
2. Wait for Roderic's explicit approval
3. Bump version, deploy, re-verify with Daniel screenshot, update commit of record

---

## Status Line (MANDATORY — Every Task Completion)

Every reply at task completion MUST end with a `---` separator followed by this status line:

```
CC Engaged: [#NNN Title](https://github.com/rivegosh/concierge-rivegosh/issues/NNN) | Status: X% complete
CC Queue: [queued items with full GitHub URLs]
Open Loops: [untracked ideas]
Coming: [planned items]
MCPs: Chi-GW [✅/❌] | Chrome [✅/❌] | SSH [✅/❌]
X/Y complete | Z% confident
DD.MM HH:MM | ~Xk tokens | ~$X.XX
```

**Rules:**
- CC Engaged MUST have a full clickable GitHub issue URL — never bare `#123`
- SSH status reflects whether Hostinger SSH was used this session
- Get time with: `date "+%d.%m %H:%M"`
- This is NON-NEGOTIABLE. No exceptions.

---

## Methodology — Phases for WordPress Work

This is a WordPress migration project, not a TypeScript codebase. Foundry phases map as follows:

| Phase | What it means here | Tool |
|-------|--------------------|------|
| **ASSAY** (audit) | ORR — operational readiness review | SSH + WP-CLI |
| **PLAN** | Issue triage — P0/P1/P2, milestones, decisions | `gh issue` |
| **HAMMER** (build) | WP-CLI operations, config fixes, search-replace | SSH |
| **TEMPER** (verify) | Visual check + SSH confirmation of change | Browser / SSH |
| **HOTFIX** | Emergency WP fix (site down, payment broken) | SSH immediate |

**WP-CLI reference commands:**
```bash
SSH="ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24"
WP="wp --path=/home/u100747640/domains/rivegosh-concierge.com/public_html"

$SSH "$WP option get <key>"          # Read config
$SSH "$WP option update <key> <val>" # Change config
$SSH "$WP plugin activate <slug>"    # Activate plugin
$SSH "$WP search-replace 'old' 'new' --dry-run"  # ALWAYS dry-run first
$SSH "$WP plugin list --status=active --format=csv"
```

**Rule:** Always `--dry-run` before any `search-replace`. Never use raw SQL on serialized data.

---

## Starting a Session

1. Read this file
2. Read [Master Index #34](https://github.com/rivegosh/concierge-rivegosh/issues/34) — the full project overview
3. Read `HANDOVER.md` — what's in flight right now
4. **Read [KB #49](https://github.com/rivegosh/concierge-rivegosh/issues/49) — WordPress/Colibri Knowledge Base** — REQUIRED before ANY header/CSS/mobile/Colibri work
5. `gh issue list --repo rivegosh/concierge-rivegosh --milestone "Phase 1 - Launch Blockers"` — current P0/P1 work
6. Search before creating: `gh issue list --repo rivegosh/concierge-rivegosh --search "keyword" --state all`

---

## WordPress Knowledge Base — MANDATORY REFERENCE

**[Issue #49](https://github.com/rivegosh/concierge-rivegosh/issues/49)** is the canonical knowledge base for this WordPress/Colibri/WooCommerce stack. It contains hard-won debugging patterns covering:

- Colibri theme architecture (filesystem storage, column taxonomy, dual-logo bug)
- Absolute positioning math inside Colibri headers (the inherited padding stack)
- CSS deploy workflow (late-CSS pattern, LiteSpeed cache invalidation, PHP lint)
- MCP Chrome debug workflow (viewport=0 trap, competing rule inspection)
- Complianz GDPR banner config
- WP-CLI reference
- Python re.sub patch deploy pattern
- Anti-patterns (what NOT to do)

**Before any CSS/header/mobile/Colibri work:** read Issue #49 first. When you discover a new pattern worth preserving, **edit Issue #49's body** (not comments — per the "rewrite issues, never comment" convention).
