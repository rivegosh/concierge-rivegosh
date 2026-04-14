# HANDOVER — Rive Gosh Concierge
**Date:** 2026-04-14 | **Session:** Deep Audit + Bootstrap + GitHub Governance

---

## SSH Access (ready, passwordless)
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 u100747640@145.79.20.24
WP=/home/u100747640/domains/rivegosh-concierge.com/public_html
```

## Site State (verified 2026-04-14)
- WordPress 6.9.4 (latest) | WooCommerce 10.6.2 | Colibri WP 1.0.162
- **56 active plugins** / 6 inactive / 2 must-use
- **173 published pages** / 12 drafts / 17 trashed
- Coming Soon: **ON** (intentional — non-admins see gate)
- Admin email: daniel@rivegosh.com ✅
- DB: 298MB | Uploads: 3.7GB | Disk total: 17GB

## Done This Session
- Deep ORR audit completed → [#21](https://github.com/rivegosh/concierge-rivegosh/issues/21)
- 12 new issues filed (#22–#33) — 3 critical security findings
- Master Index (Issue Zero) created → [#34](https://github.com/rivegosh/concierge-rivegosh/issues/34) pinned
- 5 GitHub milestones created (project folder structure)
- All 34 open issues assigned to milestones
- Bootstrap applied: CLAUDE.md updated with Status Line, methodology, session protocol
- Global bootstrap hook wired into SessionStart
- Issue Zero + search-first rules added to AISTEERINGRULES.md + CLAUDE.md

## Launch Readiness: 35% — 3 NEW P0 Security Blockers

### 🔴 P0 — Blocked on Daniel's decision
| Issue | Problem |
|-------|---------|
| [#22](https://github.com/rivegosh/concierge-rivegosh/issues/22) | Grace Vincent still admin (can log in, has plugin/theme edit rights) |
| [#23](https://github.com/rivegosh/concierge-rivegosh/issues/23) | Stripe live keys in DB — account may still be Udaan Technologies' |
| [#19](https://github.com/rivegosh/concierge-rivegosh/issues/19) | Amelia AND OVA both active — booking conflict |

### 🟠 P1 — Ready to fix (no decisions needed)
| Issue | Fix |
|-------|-----|
| [#18](https://github.com/rivegosh/concierge-rivegosh/issues/18) | GTranslate inactive: `wp plugin activate gtranslate` |
| [#28](https://github.com/rivegosh/concierge-rivegosh/issues/28) | Timezone empty: `wp option update timezone_string Europe/Paris` |
| [#27](https://github.com/rivegosh/concierge-rivegosh/issues/27) | WC onboarding store_email = Grace's email |
| [#25](https://github.com/rivegosh/concierge-rivegosh/issues/25) | SMTP broken — placeholder username, emails not sending |
| [#5](https://github.com/rivegosh/concierge-rivegosh/issues/5) | Search-replace 124,941 topvipdriver.com refs (after logo done) |
| [#24](https://github.com/rivegosh/concierge-rivegosh/issues/24) | PayPal config points to Udaan Technologies email |

### 🔴 P0 — Blocked on logo files (Roderic making them)
| Issue | Fix |
|-------|-----|
| [#15](https://github.com/rivegosh/concierge-rivegosh/issues/15) | Reskin Phase 1: logo, favicon, brand colors, Coming Soon page |

## Next Session: Start Here
1. Ask Daniel: **Stripe account ownership** (#23) — is it his account or old owner's?
2. Ask Daniel: **Grace offboard method** (#22) — delete / demote / anonymize?
3. **Safe to do now** (no decisions): activate GTranslate (#18) + fix timezone (#28) + fix WC onboarding (#27)
4. When logo ready: reskin (#15) → then search-replace (#5)

## Key Decisions Pending (Daniel)
1. Stripe account — whose is it? (→ #23)
2. Grace Vincent offboard — how? (→ #22)
3. Amelia vs OVA — which booking system wins? (→ #19)
4. Real business address for WooCommerce (→ core WC settings)
5. Real mailbox for SMTP (e.g., no-reply@rivegosh-concierge.com) (→ #25)
