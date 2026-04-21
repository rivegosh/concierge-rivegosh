# Rive Gosh

## NON-NEGOTIABLE: KB #49 FIRST

**Before ANY design or design-tech work on this site, read [Issue #49](https://github.com/rivegosh/concierge-rivegosh/issues/49) in full.**

"Design or design-tech work" means anything involving: CSS, header, nav, logo, sticky behavior, Colibri theme, mobile layout, fonts, colors, brand assets, GTranslate positioning, WooCommerce styling, LiteSpeed cache, or any visual element on the site.

This rule has no exceptions. Skipping it has repeatedly caused regressions. Read #49, then begin.

---

## 🎓 HARD-WON RULES (2026-04-20 — READ BEFORE ANY WORK)

**These are the lessons from 3 hours of painful debugging. Every single one was discovered by breaking something. Future AI: internalize these BEFORE touching anything.**

### RULE 1 — You cannot trust your eyes. Use the contrast scanner.

Humans (and LLMs reading screenshots) miss dark-on-dark text because it's invisible. You will ship regressions if you rely on visual inspection. Run the WCAG contrast scanner BEFORE and AFTER every CSS change:

```javascript
// Paste into Chrome console or run via Chrome MCP on the target page.
// Returns total count + worst 15 violations. 4.5:1 is WCAG AA floor.
(() => {
  function parseColor(c) {
    if (!c || c === 'transparent') return null;
    const m = c.match(/rgba?\(([^)]+)\)/);
    if (!m) return null;
    const [r, g, b, a] = m[1].split(',').map(s => parseFloat(s));
    return { r, g, b, a: isNaN(a) ? 1 : a };
  }
  function lum({r,g,b}) {
    const [R,G,B] = [r,g,b].map(v => { v/=255; return v<=0.03928 ? v/12.92 : Math.pow((v+0.055)/1.055, 2.4); });
    return 0.2126*R + 0.7152*G + 0.0722*B;
  }
  function ratio(c1, c2) { const l1=lum(c1), l2=lum(c2); return (Math.max(l1,l2)+0.05)/(Math.min(l1,l2)+0.05); }
  function effBg(el) {
    let cur=el, stack=[];
    while (cur && cur !== document.documentElement) {
      const c = parseColor(getComputedStyle(cur).backgroundColor);
      if (c && c.a > 0) stack.push(c);
      cur = cur.parentElement;
    }
    let bg = { r:15, g:12, b:8, a:1 }; // dark luxury body fallback
    stack.reverse().forEach(c => {
      const a = c.a;
      bg = { r: c.r*a+bg.r*(1-a), g: c.g*a+bg.g*(1-a), b: c.b*a+bg.b*(1-a), a:1 };
    });
    return bg;
  }
  const v = [], seen = new Set();
  const w = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
  let n; while ((n = w.nextNode())) {
    const t = n.textContent.trim(); if (!t || t.length < 2) continue;
    const el = n.parentElement; if (!el || seen.has(el)) continue;
    seen.add(el);
    const r = el.getBoundingClientRect(); if (r.width===0 || r.height===0) continue;
    const s = getComputedStyle(el);
    if (s.visibility==='hidden' || s.display==='none' || parseFloat(s.opacity)<0.05) continue;
    const fg = parseColor(s.color); if (!fg) continue;
    const bg = effBg(el);
    const cmp = { r: fg.r*fg.a+bg.r*(1-fg.a), g: fg.g*fg.a+bg.g*(1-fg.a), b: fg.b*fg.a+bg.b*(1-fg.a) };
    const rr = ratio(cmp, bg);
    if (rr < 4.5) v.push({ text: t.slice(0,50), ratio: rr.toFixed(2), fg: s.color, bg: `rgb(${Math.round(bg.r)},${Math.round(bg.g)},${Math.round(bg.b)})`, cls: (el.className||'').toString().slice(0,60) });
  }
  return { url: location.href, total: v.length, worst: v.sort((a,b)=>parseFloat(a.ratio)-parseFloat(b.ratio)).slice(0,15) };
})();
```

**Save this as `scripts/contrast-audit.js` and run it every time. "Black on black" is a real bug even when you can't see it.**

### RULE 2 — Amelia v3 themes via CSS custom properties. Use the silver bullet.

Amelia v3 renders its wizard inside `.amelia-v2-booking` and themes EVERY component via `var(--am-c-*)` variables on that root:

| Variable | What it colors | Default (invisible on dark) |
|----------|----------------|------------------------------|
| `--am-c-main-text` | Body text | `#1A2C37` (dark navy) |
| `--am-c-main-heading-text` | Headings | `#33434C` (dark slate) |
| `--am-c-inp-text` | Input field text | `#1A2C37` |
| `--am-c-drop-text` | Dropdown option text | `#0E1920` |
| `--am-c-drop-bgr` | Dropdown background | `#FFFFFF` |
| `--am-c-btn-sec-text` | Secondary button text | `#1A2C37` |
| `--am-c-btn-prim` | Primary button bg | `#265CF2` |
| `--am-c-btn-prim-text` | Primary button text | `#FFFFFF` |
| `--am-c-sb-bgr` | Sidebar bg | `#17295a` |

**Redefine these on `.amelia-v2-booking` and the fix cascades through thousands of rules in one stroke.** See `mu-plugins/rg-amelia-contrast-sweep.php`. Class-by-class overrides are slow, brittle, and always miss consumers.

**Gotcha:** `.el-select-dropdown` and `.el-popper.el-select__popper` TELEPORT to `document.body` — they escape `.amelia-v2-booking` parent scope. Use `body:has(.amelia-v2-booking)` as the scope for teleported elements (zero bleed — only matches when Amelia is mounted).

### RULE 3 — Filled vs outline buttons: one CSS mistake makes them invisible.

**Amelia and Colibri both use `.am-button--filled` / `.h-link` with a champagne background (`rgba(204,197,147,0.92)`).** If you set `color: #CCC593` on these, you get CHAMPAGNE TEXT ON CHAMPAGNE BG = invisible.

The rule:
- `.am-button--filled` (any variant) → **dark text** (`#0f0c08`)
- `.am-button--secondary:not(.am-button--filled)` (outline) → **champagne text** (`#CCC593`)
- `.h-link.style-NNNN` with champagne bg → **dark text** (`#0f0c08`)

This bit us twice on 2026-04-20 (Go Back button + Get The Golden Account button). Verify button visibility with the scanner after ANY button CSS change.

### RULE 4 — SSH deploy pattern (CANONICAL — do not improvise).

```bash
SSH="ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24"
WP="wp --path=/home/u100747640/domains/rivegosh-concierge.com/public_html"
MUP="/home/u100747640/domains/rivegosh-concierge.com/public_html/wp-content/mu-plugins"
LSCSS="/home/u100747640/domains/rivegosh-concierge.com/public_html/wp-content/litespeed/css"

# 1. SCP to /tmp
scp -P 65002 -i ~/.ssh/id_ed25519 /tmp/plugin.php u100747640@145.79.20.24:/tmp/

# 2. Lint + move + purge — ALL in one SSH call
$SSH "php -l /tmp/plugin.php && mv /tmp/plugin.php $MUP/plugin.php && $WP litespeed-purge all && rm -rf $LSCSS/*"
```

**Why `rm -rf $LSCSS/*`:** `wp litespeed-purge all` invalidates the HTML cache but NOT the combined CSS cache. If you only run `litespeed-purge all`, your CSS change will appear to not work on the live site — you'll chase a phantom bug. **Always clear `wp-content/litespeed/css/` manually.**

**Why lint first:** A PHP syntax error in a mu-plugin crashes the entire site. `php -l` catches it before the `mv`.

### RULE 5 — LiteSpeed is protected by `rg-litespeed-amelia-guard.php`. Don't flip it.

Amelia uses webpack dynamic imports. If LiteSpeed has `optm-js_min=1` or `optm-js_defer=1`, those imports 404 and the booking wizard goes blank. The guard plugin re-locks `optm-js_min=0` + `optm-js_defer=0` on every `admin_init`. If you think you need to enable JS minification, you don't. Leave it alone.

### RULE 6 — `amelia_stash` is a SEPARATE cache from LiteSpeed.

After any write to `wp_amelia_custom_fields`, `wp_amelia_services`, or `wp_amelia_events`, run the stash rebuild:

```bash
$SSH "$WP eval-file /tmp/rg-rebuild-stash-customfields.php"
```

Purging LiteSpeed does NOT update the stash. The wizard will serve stale field definitions until you rebuild.

**Format rule for custom fields stash:** `customFields` must use `services:[{id:N}]`, NOT `serviceIds:[N]`. The v1 shape breaks the wizard silently.

### RULE 7 — Coming Soon mode blocks guest access to wizards.

WooCommerce "Coming Soon — Store pages only" mode redirects non-admin users from `/appointment/`, `/booking-pro-panel/`, `/booking-vip/` to home. This means:

- **You cannot live-verify the Amelia wizard as a guest via Chrome MCP.**
- **The curl of `/appointment/` will return home HTML, not the wizard.**
- **Only a logged-in admin can see and test the wizard.**

Options when you need to verify:
1. Ask Daniel to screenshot the broken state (fastest)
2. Ask Roderic to disable Coming Soon temporarily (risky — public reveal)
3. Trust the CSS selector specificity and rely on scanner-before/after diff on pages you CAN reach (home, catalog, cart)

**Never claim "the wizard is fixed" without admin-session verification.** State what you verified and what you couldn't.

### RULE 8 — Colibri page scoping: use `body#colibri.page-id-N` (SAME ELEMENT).

Per KB #49: Colibri puts the numeric page ID on `<body id="colibri" class="page-id-N ...">`. Use the compound selector on the SAME element:

```css
/* CORRECT — same element, both selectors */
body#colibri.page-id-14 .woocommerce-cart-form { ... }

/* WRONG — these look similar but descendant-combine differently */
body#colibri .page-id-14 .woocommerce-cart-form { ... }
body.page-id-14 .woocommerce-cart-form { ... }  /* sometimes works, sometimes doesn't */
```

### RULE 9 — Protected mu-plugins are SEALED. New fixes = new files.

Any mu-plugin with `╔══ DO NOT DELETE — SIGNED-OFF FIX ══╗` banner is frozen. If you think the behavior is wrong:

1. Open a GH issue explaining the regression risk
2. Wait for Roderic's explicit approval
3. Only then bump version, redeploy, re-verify

**Do NOT edit a sealed mu-plugin in-place.** If you need a counter-fix, create a NEW mu-plugin that loads later (higher wp_footer priority number fires later in the CSS cascade).

See "Protected mu-plugins" table below for the current list and reasoning.

### RULE 10 — PHP lint + HEREDOC are mandatory for mu-plugin CSS.

When embedding CSS via `add_action('wp_footer', ...)`:

- Use `<?php ... ?>` wrapped around `<style>` blocks with raw CSS inside — do NOT put CSS inside a PHP string.
- Run `php -l` on every file before `mv`. A syntax error 500s the whole site.
- Keep `if ( ! defined( 'ABSPATH' ) ) exit;` as the first non-comment line.
- Scope every CSS rule — zero bleed is the rule, not an aspiration.

### RULE 11 — LiteSpeed CSS Combine creates stale cascades.

If a style change appears to not take effect even after `litespeed-purge all`, the combined CSS file in `wp-content/litespeed/css/*.css` is stale. The fix is always `rm -rf wp-content/litespeed/css/*`. This is rolled into Rule 4's canonical deploy sequence — NEVER skip it.

### RULE 12 — Always verify with a cache-busting query param.

Browser cache + LiteSpeed CDN cache + service worker cache = three layers that can each serve stale content. When testing in Chrome MCP, use `?cb=YYYYMMDD-NN` or `?cb=verify-01` query strings. Each load should use a NEW cb value.

### RULE 13 — Read the file. Trust nothing.

Memory says "file exists" is not "file exists NOW." Before any SSH deploy, `ls -la $MUP/filename.php` to confirm current state. Before editing, `Read` the file. Claims like "I already deployed this" are worthless — verify.

### RULE 14 — `is_checkout()` returns `true` on `/checkout/order-received/`. Always add the endpoint guard.

WooCommerce's `is_checkout()` returns `true` for the checkout page AND all its sub-endpoints — including `/checkout/order-received/{id}/` (the Thank You page). Any `wp_footer` hook guarded only by `is_checkout()` will fire CSS on the Thank You page too.

**Always add the exclusion guard immediately after `is_checkout()`:**

```php
add_action( 'wp_footer', function () {
    if ( ! is_checkout() && ! is_page( 15 ) ) return;
    if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) return; // ← MANDATORY
    ?>
```

Failure to add this caused `rg-checkout-luxury.php` to inject H2 sizing + `#payment` background rules on the Thank You page, undermining the order-received counter-skin plugins. Fixed in commit `f3031d3`. Every checkout mu-plugin must have this guard — see `rg-checkout-luxury-skin.php` line 33 as the canonical pattern.

### RULE 15 — Every mu-plugin deployment = lint + deploy + commit (in that order). Never split them.

The pattern `scp → php -l → mv → purge` (Rule 4) covers the server side. But the git side is equally mandatory:

```
scp file.php server:/tmp/
ssh "php -l /tmp/file.php && mv /tmp/file.php $MUP/file.php && wp litespeed-purge all && rm -rf $LSCSS/*"
# THEN IMMEDIATELY:
git add mu-plugins/file.php && git commit -m "..."
```

**Why:** Any session that deploys via SSH without committing creates server↔git drift. The 2026-04-21 audit found 15 plugins on server that had never been committed across multiple prior sessions. Drift is invisible until an audit; it causes confusion, risks overwriting production with outdated git pulls, and defeats the purpose of version control.

**CTO ratification checklist for any mu-plugin commit:**
- [ ] `if ( ! defined( 'ABSPATH' ) ) exit;` present as first executable line
- [ ] `php -l` clean on server (PHP 8.3)
- [ ] CSS scoped to specific page — no global bleed
- [ ] `is_checkout()` plugins have `is_wc_endpoint_url('order-received')` exclusion
- [ ] No sealed plugin was edited in-place (Rule 9)
- [ ] `git add` + `git commit` immediately after deploy

### RULE 16 — Amelia `mailService` MUST be `'wp_mail'` (not `'wp'`).

`MailerFactory::create()` uses strict string comparisons: `=== 'smtp'`, `=== 'mailgun'`, `=== 'wp_mail'`, `=== 'outlook'`. The value `'wp'` matches NOTHING and falls through to `PHPMailService` (PHP native `mail()` function directly). Consequences:
1. Amelia booking emails bypass WP Mail SMTP → hit Hostinger MTA → subject to 100/day rate cap
2. Emails not logged in WP Mail SMTP log (invisible to debugging)
3. `rg-mail-reply-to-guard.php` hook on `wp_mail` has **zero effect** on Amelia emails

**Verify/fix from WP-CLI:**
```bash
SSH="ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24"
WP="wp --path=/home/u100747640/domains/rivegosh-concierge.com/public_html"
# Check current value:
$SSH "$WP eval 'echo json_decode(get_option(\"amelia_settings\"),true)[\"notifications\"][\"mailService\"];'"
# Fix (must use json_encode — see Rule 17):
# Write a PHP eval-file that does $wpdb->update('wp_options', ['option_value' => json_encode($data)], ...)
```

### RULE 17 — `amelia_settings` is stored as raw JSON. Never use `update_option()` with an array.

`SettingsStorage::getSavedSettings()` calls `json_decode(get_option('amelia_settings'), true)`. If you call `update_option('amelia_settings', $phpArray)`, WordPress PHP-serializes the array. On next Amelia load: `TypeError: json_decode(): Argument #1 must be of type string, array given` → Amelia crashes site-wide.

**Correct pattern:** Always read, decode, patch, re-encode, write via `$wpdb->update()`:
```php
global $wpdb;
$raw = $wpdb->get_var("SELECT option_value FROM {$wpdb->options} WHERE option_name='amelia_settings'");
$data = json_decode($raw, true);
$data['notifications']['mailService'] = 'wp_mail'; // patch the field
$wpdb->update($wpdb->options, ['option_value' => json_encode($data)], ['option_name' => 'amelia_settings']);
```

### RULE 18 — `runInstantPostBookingActions` must be `true` for CLI smoke tests.

`AddBookingCommandHandler::handle()` only calls `runPostBookingActions()` (which sends notifications) if:
- `general.runInstantPostBookingActions === true` in Amelia settings, OR
- `runInstantPostBookingActions: true` is set on the command object

Default is `false` (defers to background cron). In CLI smoke tests via `wp eval`, explicitly set:
```php
$command->setField('runInstantPostBookingActions', true);
```
Without this, the booking is created but zero notification emails are sent — you'll think Amelia is broken when it's just deferred.

### RULE 19 — WC Coming Soon blocks `wcfm_vendor` users from cart/checkout.

`woocommerce_coming_soon=yes` + `woocommerce_store_pages_only=yes` redirects any user without `manage_woocommerce` capability away from `/your-booking/` and `/checkout/`. The `wcfm_vendor` role does NOT have this capability → vendor accounts like `daniel@rivegosh-concierge.com` (user 462) are blocked from completing Amelia bookings via WC payment.

**When ready to launch:**
```bash
$SSH "$WP option update woocommerce_coming_soon no"
```

**Do NOT disable prematurely** — site is not launch-ready yet. This is intentional testing mode.

---

## 🔧 KNOWN-BROKEN PATTERNS (what NOT to do)

| Anti-pattern | Why it breaks | What to do instead |
|--------------|---------------|---------------------|
| `color: #CCC593` on `.am-button--filled` | Champagne text on champagne bg = invisible | Dark text (`#0f0c08`) on filled buttons |
| `wp litespeed-purge all` without `rm -rf litespeed/css/*` | Combined CSS cache stays stale | Always run both (Rule 4) |
| `body.page-id-N` alone | Sometimes matches, sometimes not | Use `body#colibri.page-id-N` (Rule 8) |
| Editing a `DO NOT DELETE` mu-plugin | Breaks a signed-off fix | Open GH issue, wait for approval (Rule 9) |
| Claiming "the wizard works" without admin-session test | Guest is redirected by Coming Soon | Ask Daniel to screenshot (Rule 7) |
| Putting CSS inside a PHP string | Escaping hell + no syntax highlighting | Use `<?php ... ?>` around raw `<style>` (Rule 10) |
| Writing inline `color: rgb(7,7,7)` | Carried over from light-bg era, invisible now | Run contrast scanner and override (Rule 1) |
| Minifying or deferring Amelia JS | Webpack dynamic imports 404 | Keep LiteSpeed JS off (Rule 5) |
| Using `serviceIds:[N]` in custom_fields | Breaks wizard silently | Use `services:[{id:N}]` (Rule 6) |
| Using SVG logos | No Safe SVG plugin | PNG-24 with transparency (see Conventions) |
| `is_checkout()` only guard on `wp_footer` | Also fires on `/checkout/order-received/` (Thank You page) | Add `is_wc_endpoint_url('order-received')` exclusion (Rule 14) |
| Missing `if ( ! defined( 'ABSPATH' ) ) exit;` in mu-plugin | Security gate absent — direct PHP execution possible | First non-comment executable line — no exceptions (Rule 10/15) |
| Deploying via SSH without committing to git | Server↔git drift — silent, dangerous, hard to audit | Always `git add + commit` immediately after every SSH deploy (Rule 15) |
| Contrast scanner violations on hidden/tooltip elements | False-positives: scanner finds `inViewport: false` elements with white card bg | Check `inViewport` + `nearestBg` before acting on scanner results — invisible elements don't need fixing |
| `amelia_settings.mailService = 'wp'` | Falls through MailerFactory to PHPMailService — bypasses WP Mail SMTP, Reply-To guard, rate-limit protection | Must be `'wp_mail'` (exact string) — see Rule 16 |
| `update_option('amelia_settings', $phpArray)` | WordPress PHP-serializes it; `SettingsStorage::getSavedSettings()` calls `json_decode()` → crashes Amelia site-wide | Use `$wpdb->update()` with `json_encode($data)` directly — see Rule 17 |
| CLI smoke test shows 0 notifications | `runInstantPostBookingActions` defaults to `false` — defers to cron | Set `$command->setField('runInstantPostBookingActions', true)` — see Rule 18 |
| Testing Amelia flow as `wcfm_vendor` user | WC Coming Soon blocks non-admin (no `manage_woocommerce`) from cart/checkout | Test as administrator, or disable Coming Soon when ready to launch (Rule 19) |

---

## 🧰 REUSABLE SCRIPTS

| Script | Purpose | Where |
|--------|---------|-------|
| Contrast audit | Find all text with <4.5:1 ratio | Rule 1 above, inline |
| amelia_stash rebuild | Resync custom field cache | `/tmp/rg-rebuild-stash-customfields.php` on server |
| Plugin status snapshot | Active plugin list | `$SSH "$WP plugin list --status=active --format=csv"` |
| mu-plugin listing | Confirm current mu-plugins | `$SSH "ls -la $MUP"` |

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
| `mu-plugins/rg-appointment-redesign.php` | 1.2.3 | [68c2e5f](https://github.com/rivegosh/concierge-rivegosh/commit/68c2e5f) | [#80](https://github.com/rivegosh/concierge-rivegosh/issues/80) | Skins /appointment/ page (ID 44401) — vertical stepper (number + label + representative SVG icon) + 11 destination cards with champagne-gold hairline + centered airplane icons. Missed by #68 Amelia reskin (targeted 61860-c2 home, not 44401-*). Scope-guarded via is_page( 44401 ) — zero bleed. |
| `mu-plugins/rg-appointment-gallery-hide.php` | 1.3.0 | [5577325](https://github.com/rivegosh/concierge-rivegosh/commit/5577325) | [#82](https://github.com/rivegosh/concierge-rivegosh/issues/82) | Hides .am-fcis__gallery-btn + .am-fcis__gallery-thumb__wrapper on /appointment/ (ID 44401). Keeps gallery container + hero (car photo). Nuclear CSS specificity (1,3,1) + JS MutationObserver with `style.setProperty('display','none','important')` — immune to all CSS battles. |
| `mu-plugins/rg-catalog-luxury-reskin.php` | 2.0.0 | [8ee8645](https://github.com/rivegosh/concierge-rivegosh/commit/8ee8645) | [#82](https://github.com/rivegosh/concierge-rivegosh/issues/82) | Dark luxury for Amelia catalog + destination sub-pages. Covers: body dark (#1A1A1A) via body:has(.amelia-v2-booking) + body.page-id-44401, Colibri h-text paras white+680px centered, am-fcil__item-name white, am-fcis__header-name champagne gold (3-class specificity), Service badge champagne. CRITICAL: --am-c-main-bgr stays #0f0c08 — changing it kills car gallery images (b3a11ac incident). |
| `mu-plugins/rg-mail-reply-to-guard.php` | 1.1.0 | [abd6c6f](https://github.com/rivegosh/concierge-rivegosh/commit/abd6c6f) | [#88](https://github.com/rivegosh/concierge-rivegosh/issues/88) | Hooks `wp_mail` filter at priority 9999. Strips any `Reply-To:` header whose address is NOT on `rivegosh-concierge.com` or `rivegosh.com`. Fixes Hostinger inbound filter silently soft-bouncing every vendor notification (WCFM sets Reply-To = buyer email; Hostinger rejects external domains). Admin email on user 1 stays as `gracevincentstripe@gmail.com` (Stripe/vendor records safe). Verified TEST 7 (gmail Reply-To stripped → delivered) + TEST 8 (rivegosh.com Reply-To kept → delivered). Logic audited 2026-04-21: 10/10 checks pass. |
| `mu-plugins/rg-checkout-luxury.php` | 1.0.0 | [f3031d3](https://github.com/rivegosh/concierge-rivegosh/commit/f3031d3) | — | Base luxury skin for /checkout/ (page-id-15) — hero H2 sizing, coupon toggle bg, payment-request buttons, place-order button. Has `is_wc_endpoint_url('order-received')` exclusion guard (line 36) — MUST remain or CSS fires on Thank You page too (see Rule 14). |
| `mu-plugins/rg-checkout-luxury-skin.php` | 1.0.0 | [abd6c6f](https://github.com/rivegosh/concierge-rivegosh/commit/abd6c6f) | — | Counter-skin for /checkout/ page — dark luxury coupon bar + billing form + order review + Stripe card box + place-order button. Priority 99999 (after base checkout skin). Has `is_wc_endpoint_url('order-received')` exclusion guard (line 33). Scoped `body.woocommerce-checkout`. |
| `mu-plugins/rg-order-received-billing-fix.php` | 1.0.0 | [abd6c6f](https://github.com/rivegosh/concierge-rivegosh/commit/abd6c6f) | — | Counter-skin for /checkout/order-received/ — catches white Billing Address card + Thank You paragraph + email pill missed by base order-received luxury mu-plugin. Priority 99999. Scoped `body.woocommerce-order-received` — zero bleed. |
| `mu-plugins/rg-home-contrast-fix.php` | 1.0.0 | [abd6c6f](https://github.com/rivegosh/concierge-rivegosh/commit/abd6c6f) | — | Counter-skin for home page (id 61860) — overrides migrated inline `color: rgb(7,7,7)` / `rgb(26,25,24)` dark-on-dark h-text paras. Forces "Get The Golden Account" champagne-on-champagne button to dark text. Priority 99998. Scoped `body#colibri.home.page-id-61860` — zero bleed. |
| `mu-plugins/rg-cart-coming-soon-fix.php` | 1.0.0 | [47d7383](https://github.com/rivegosh/concierge-rivegosh/commit/47d7383) | — | Three CSS fixes for /your-booking/ (page-id-14) and global nav: (1) WC Coming Soon block black text → champagne on dark body, (2) Amelia cart item meta (transfer type/date/airport/passengers) black text → champagne, (3) nav `.sub-menu` links `rgb(0,0,0)` global → champagne. Priority 100000 (fires after rg-cart-luxury.php at 99999). |
| `mu-plugins/rg-checkout-review-polish.php` | 1.0.0 | [66285fd](https://github.com/rivegosh/concierge-rivegosh/commit/66285fd) | — | Two targeted fixes on /checkout/ (page-id-15): (1) `::placeholder` visibility — inputs never had placeholder color set so placeholder text was invisible (dark-on-dark). (2) `dl.variation dt { float:none; display:block }` — WooCommerce default `float:left` caused "Appointment Info:" + "Local Time:" on same line. Shrinks bold dd labels to 11px. Priority 100001. Has `is_wc_endpoint_url('order-received')` guard. |
| `mu-plugins/rg-checkout-billing-dark.php` | 1.0.0 | [262c92a](https://github.com/rivegosh/concierge-rivegosh/commit/262c92a) | — | Kills white background on `#customer_details.col2-set` (WooCommerce default `rgb(255,255,255)` made all champagne labels 1.16:1 ratio — invisible). Sets dark `rgba(20,16,10,0.7)` wrapper. Bumps `dl.variation dt` opacity 0.5→0.72 (3.50:1→4.6:1 ✓). Fixes `.payment-methods--logos-count` dark-on-dark badge. Priority 100002. Checkout scanner: 23→2 violations after this. |
| `mu-plugins/rg-amelia-select-value-fix.php` | 1.0.0 | [ecff0a0](https://github.com/rivegosh/concierge-rivegosh/commit/ecff0a0) | — | Fixes invisible selected value in Amelia suitcase/passenger dropdowns. Root: Amelia stepForm CSS uses `.am-select .el-select__selected-item.el-select__placeholder span { color:var(--am-c-select-text)!important }` — higher specificity than sealed plugin's parent-only selector. Fix overrides `--am-c-select-text` at `.am-select` scope AND directly targets span child. Priority 100003. |
| `mu-plugins/rg-service-detail-fix.php` | 1.3.0 | [ce2ca46](https://github.com/rivegosh/concierge-rivegosh/commit/ce2ca46) | — | Three fixes for Amelia catalog + service detail: (0) Catalog list card hero — `background-color:#0a0a0a` + `background-size:contain` so transparent car PNGs don't bleed white. (1) Book Now button — sealed §8 of rg-catalog-luxury-reskin.php beats §6 champagne fill in specificity tie (both 1,3,0; §8 is later). Fix: (1,4,0) selector + priority 100005 restores champagne gold. (2) Gallery hero 54% padding-top for Cadillac 662×337 aspect + min-height 200px floor. Priority 100005. |
| `mu-plugins/rg-checkout-select2-dropdown.php` | 1.0.0 | [1113a90](https://github.com/rivegosh/concierge-rivegosh/commit/1113a90) | — | Dark luxury skin for select2 open dropdown on /checkout/ (page-id-15). rg-checkout-coupon-fix.php §4 only styles the collapsed trigger. This plugin targets the teleported dropdown panel (.select2-dropdown), search field, option items (default/highlighted/selected states). select2 appends to body directly → body.woocommerce-checkout is the correct ancestor scope. Priority 100006. |
| `mu-plugins/rg-wizard-continue-btn.php` | 1.1.0 | [d4afaa5](https://github.com/rivegosh/concierge-rivegosh/commit/d4afaa5) | — | CONTINUE button in Amelia booking wizard (.am-fs__main-footer .am-button-continue): min-width 240px (was ~117px), font-size 13px (was 11px), font-weight 700, color #0a0a0a. margin-left:auto anchors it to right edge regardless of sibling "Book another" button on Cart step. Footer min-height 74px prevents layout jitter. Priority 100007. |
| `mu-plugins/rg-checkout-order-hierarchy.php` | 1.0.0 | [6386ae6](https://github.com/rivegosh/concierge-rivegosh/commit/6386ae6) | — | Checkout order review table hierarchy: td.product-total vertical-align:top (price was floating mid-row), price 18px champagne bold, TOTAL row 22px. dl.variation dt → 10px uppercase champagne labels; dd → 13px white values. Section headers (APPOINTMENT INFO, Custom Fields, MY SPACE) get :first-child prominence. Empty dd collapsed. Priority 100008. |

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
# ⚠️ After ANY change to wp_amelia_custom_fields, rebuild amelia_stash:
# $SSH "wp --path=... eval-file /tmp/rg-rebuild-stash-customfields.php"
# (stash is a separate cache from LiteSpeed — purging LiteSpeed does NOT update it)
# Format rule: customFields must use services:[{id:N}] NOT serviceIds:[N]
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
