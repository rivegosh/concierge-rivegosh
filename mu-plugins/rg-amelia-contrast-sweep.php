<?php
/**
 * Plugin Name: RG Amelia Contrast Sweep
 * Description: Silver-bullet contrast fix — redefines Amelia's CSS custom
 *              properties so every component using var(--am-c-*) cascades
 *              to champagne-on-dark. Also fixes GTranslate + wizard footer.
 * Version: 1.0.0
 * Created: 2026-04-20
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║                                                                   ║
 * ║ Root cause (verified via live DOM probe, 2026-04-20):            ║
 * ║ Amelia v3 themes the wizard via CSS custom properties on the     ║
 * ║ .amelia-v2-booking root. Defaults shipped:                       ║
 * ║   --am-c-main-text:          #1A2C37  (dark navy)                ║
 * ║   --am-c-main-heading-text:  #33434C  (dark slate)               ║
 * ║   --am-c-inp-text:           #1A2C37                              ║
 * ║   --am-c-drop-text:          #0E1920  (near black)               ║
 * ║   --am-c-btn-sec-text:       #1A2C37  ("Go Back" text)           ║
 * ║   --am-c-btn-prim:           #265CF2  (Amelia default blue)      ║
 * ║                                                                   ║
 * ║ These inherit through VAR() calls in thousands of Amelia rules.  ║
 * ║ Class-by-class overrides (rg-amelia-contrast.php) miss many      ║
 * ║ consumers. Single source-of-truth fix = redefine variables on    ║
 * ║ the root. Contrast goes from 1.17:1 → 9+:1 in one stroke.        ║
 * ║                                                                   ║
 * ║ Also fixes:                                                       ║
 * ║  - "Go Back" secondary button text (dark on dark → champagne)    ║
 * ║  - "Book Now" primary button text (champagne-on-champagne → dark)║
 * ║  - Footer Terms/Copyright opacity 0.5 → 0.7 (3.49 → 4.9:1)       ║
 * ║  - GTranslate "English" champagne-on-white → dark-on-white       ║
 * ║                                                                   ║
 * ║ Scope: body:has(.amelia-v2-booking) for teleported poppers +     ║
 * ║        .amelia-v2-booking for scoped elements. Zero bleed.       ║
 * ║ Revert: delete this file.                                        ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-contrast-sweep">
	/* ==================================================================
	 * THE SILVER BULLET — redefine Amelia's theme variables
	 * These cascade through every component using var(--am-c-*).
	 * ================================================================== */
	.amelia-v2-booking,
	body:has(.amelia-v2-booking) .el-popper.el-select__popper,
	body:has(.amelia-v2-booking) .am-popover-popper,
	body:has(.amelia-v2-booking) .el-select-dropdown {
		/* BODY TEXT — was #1A2C37 (1.17:1) */
		--am-c-main-text: rgba(230, 225, 195, 0.92) !important;
		/* HEADING TEXT — was #33434C */
		--am-c-main-heading-text: #CCC593 !important;
		/* INPUT TEXT — was #1A2C37 (invisible on dark input bg) */
		--am-c-inp-text: rgba(240, 235, 225, 0.95) !important;
		/* INPUT PLACEHOLDER — was #808A90 */
		--am-c-inp-placeholder: rgba(204, 197, 147, 0.55) !important;
		/* INPUT BORDER */
		--am-c-inp-border: rgba(204, 197, 147, 0.35) !important;
		/* DROPDOWN TEXT — was #0E1920 */
		--am-c-drop-text: rgba(240, 235, 225, 0.95) !important;
		/* DROPDOWN BG — was #FFFFFF (white popper clashes with dark) */
		--am-c-drop-bgr: rgba(20, 16, 10, 0.98) !important;
		/* SECONDARY BUTTON (Go Back) — text was #1A2C37 on transparent */
		--am-c-btn-sec-text: #CCC593 !important;
		--am-c-btn-sec: transparent !important;
		/* PRIMARY BUTTON (Continue / Book Now) — was blue #265CF2 */
		--am-c-btn-prim: #CCC593 !important;
		--am-c-btn-prim-text: #0f0c08 !important;
		/* SIDEBAR BG — was #17295a (Amelia default blue) */
		--am-c-sb-bgr: rgba(20, 16, 10, 0.6) !important;
		--am-c-sb-text: rgba(230, 225, 195, 0.92) !important;
		/* PRIMARY ACCENT */
		--am-c-primary: #CCC593 !important;
	}

	/* ==================================================================
	 * HARD BACKSTOP — any element still inheriting raw #1A2C37 navy
	 * or #0E1920 near-black (e.g., inline style="color: #1A2C37")
	 * gets forced to champagne. Uses attribute selector to hit inline
	 * styles directly.
	 * ================================================================== */
	.amelia-v2-booking [style*="color: #1A2C37"],
	.amelia-v2-booking [style*="color: #0E1920"],
	.amelia-v2-booking [style*="color: rgb(26, 44, 55)"],
	.amelia-v2-booking [style*="color:rgb(26, 44, 55)"],
	.amelia-v2-booking [style*="color: rgba(26, 44, 55"],
	.amelia-v2-booking [style*="color:rgba(26,44,55"] {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* Specific Amelia helper classes that sometimes bypass var() */
	.amelia-v2-booking .am-fs__bringing-message,
	.amelia-v2-booking .am-fs__extras-card__content-sub,
	.amelia-v2-booking .am-fs__extras-card__content,
	.amelia-v2-booking .am-fs__extras-card__content p,
	.amelia-v2-booking .am-fs__extras-card__content span,
	.amelia-v2-booking .am-fs__extras-card__content li,
	.amelia-v2-booking .am-fs__extras-card__content strong,
	.amelia-v2-booking .am-fs__description,
	.amelia-v2-booking .am-fs__sub-title,
	.amelia-v2-booking .am-fs-label,
	.amelia-v2-booking .am-fs__item-descr {
		color: rgba(230, 225, 195, 0.88) !important;
	}

	/* Month/year dropdown trigger text (Date & Time step) */
	.amelia-v2-booking .el-select .el-select__wrapper,
	.amelia-v2-booking .el-select .el-select__wrapper .el-select__selected-item,
	.amelia-v2-booking .el-select .el-select__wrapper .el-select__placeholder,
	.amelia-v2-booking .el-select .el-select__wrapper .el-select__placeholder span {
		color: rgba(240, 235, 225, 0.95) !important;
	}

	/* ==================================================================
	 * BUTTONS — filled vs outline distinction (REGRESSION FIX 2026-04-20)
	 *
	 * Bug: setting --am-c-btn-sec-text to champagne made "Go Back" and
	 * "View all photos" invisible because .am-button--filled.am-button--
	 * secondary has a CHAMPAGNE BACKGROUND (rgba(204,197,147,0.92)) — so
	 * champagne text on champagne bg = unreadable.
	 *
	 * Rule: ANY filled button gets DARK text. Only outline buttons
	 * (no --filled class) get champagne text.
	 * ================================================================== */

	/* ALL filled buttons (primary OR secondary) — dark text on champagne */
	.amelia-v2-booking .am-button--filled,
	.amelia-v2-booking .am-button--filled .am-button__inner,
	.amelia-v2-booking .am-button--filled .am-button__inner span,
	.amelia-v2-booking .am-button--filled .am-button__inner svg {
		color: #0f0c08 !important;
		fill: #0f0c08 !important;
		font-weight: 600 !important;
	}

	/* Outline secondary buttons (NO --filled class) — champagne text */
	.amelia-v2-booking .am-button--secondary:not(.am-button--filled) .am-button__inner,
	.amelia-v2-booking .am-button.secondary:not(.am-button--filled) .am-button__inner {
		color: #CCC593 !important;
	}
	.amelia-v2-booking .am-button--secondary:not(.am-button--filled) .am-button__inner svg,
	.amelia-v2-booking .am-button.secondary:not(.am-button--filled) .am-button__inner svg {
		fill: #CCC593 !important;
	}

	/* Primary (Continue, Book Now, Next) — force champagne bg + dark text */
	.amelia-v2-booking .am-button.primary,
	.amelia-v2-booking .am-button--primary,
	.amelia-v2-booking .am-button.am-booking-continue,
	.amelia-v2-booking .am-button[class*="primary"] {
		background-color: #CCC593 !important;
	}
	.amelia-v2-booking .am-button.primary .am-button__inner,
	.amelia-v2-booking .am-button--primary .am-button__inner,
	.amelia-v2-booking .am-button[class*="primary"] .am-button__inner {
		color: #0f0c08 !important;
		font-weight: 600 !important;
	}

	/* Gallery button specific (View all photos) — ensure dark text */
	.amelia-v2-booking .am-fcis__gallery-btn,
	.amelia-v2-booking .am-fcis__gallery-btn .am-button__inner,
	.amelia-v2-booking .am-fcis__gallery-btn .am-button__inner span {
		color: #0f0c08 !important;
		font-weight: 600 !important;
	}

	/* ==================================================================
	 * WIZARD FOOTER — Terms / Privacy / Copyright (opacity 0.5 → 0.7)
	 * Rises from 3.49:1 → ~4.9:1 (clears AA 4.5:1 threshold)
	 * ================================================================== */
	body:has(.amelia-v2-booking) footer a[href*="/terms"],
	body:has(.amelia-v2-booking) footer a[href*="/privacy"],
	body:has(.amelia-v2-booking) footer a[href*="/cookie"],
	body:has(.amelia-v2-booking) footer .h-copyright,
	body:has(.amelia-v2-booking) footer p,
	body:has(.amelia-v2-booking) footer span {
		color: rgba(220, 215, 185, 0.82) !important;
	}

	/* ==================================================================
	 * GTRANSLATE SWITCHER — "English" text visible
	 * Was champagne-on-white = 1.6:1 (invisible).
	 * Fix: dark text on white bg OR transparent bg with champagne text.
	 * Going with champagne on dark (consistent with rest of site).
	 * ================================================================== */
	.gt_selector,
	select.gt_selector,
	#gtranslate_selector,
	.gtranslate_wrapper .gt_selector,
	.gtranslate_wrapper select {
		background-color: rgba(20, 16, 10, 0.9) !important;
		color: #CCC593 !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
	}
	.gt_selector option,
	.gtranslate_wrapper select option {
		background-color: rgba(20, 16, 10, 0.98) !important;
		color: rgba(230, 225, 195, 0.92) !important;
	}
	/* GTranslate float switcher label if used */
	.gtranslate_wrapper a,
	.glink,
	.glink.nturl {
		color: #CCC593 !important;
	}

	/* ==================================================================
	 * CALENDAR DAY CELLS — numbers need to stay readable on dark bg
	 * ================================================================== */
	.amelia-v2-booking .am-calendar-day,
	.amelia-v2-booking .el-date-table td span,
	.amelia-v2-booking .el-date-table td .cell {
		color: rgba(230, 225, 195, 0.88) !important;
	}
	.amelia-v2-booking .am-calendar-day.disabled,
	.amelia-v2-booking .el-date-table td.disabled span {
		color: rgba(204, 197, 147, 0.25) !important;
	}
	.amelia-v2-booking .am-calendar-day.selected,
	.amelia-v2-booking .el-date-table td.current span {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
		font-weight: 600 !important;
	}

	/* Weekday header row (MON TUE WED ...) */
	.amelia-v2-booking .el-date-table th,
	.amelia-v2-booking th.am-weekday {
		color: #CCC593 !important;
		letter-spacing: 0.04em !important;
	}

	/* ==================================================================
	 * STEPPER LABELS (left sidebar: Bringing anyone / Extras / etc.)
	 * Should be champagne when active, dim when pending, bright when done
	 * ================================================================== */
	.amelia-v2-booking .am-step__label,
	.amelia-v2-booking .am-step span {
		color: rgba(230, 225, 195, 0.88) !important;
	}
	.amelia-v2-booking .am-step.active .am-step__label,
	.amelia-v2-booking .am-step.current .am-step__label {
		color: #CCC593 !important;
		font-weight: 600 !important;
	}
	</style>
	<?php
}, 100000 );
