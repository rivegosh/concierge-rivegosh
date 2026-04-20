<?php
/**
 * Plugin Name: RG Amelia Select Dropdown Contrast
 * Description: Dark luxury contrast for Amelia's Element Plus .el-select-dropdown
 *              popper (custom fields like "How many suitcase?" / "Number of
 *              passengers"). Popper teleports to document.body so it escapes
 *              the .amelia-v2-booking parent scope — gated via :has().
 * Version: 1.1.0
 * Created: 2026-04-20
 * Updated: 2026-04-20 — v1.1.0 adds Element Plus v2 trigger selectors.
 *          Amelia v3 uses .el-select__wrapper / __selection / __placeholder /
 *          __selected-item (NOT v1 .el-input__inner). Verified by grepping
 *          plugins/ameliabooking/v3/public/assets/stepForm.a706e754.css.
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║                                                                   ║
 * ║ Problem (user Daniel, 2026-04-20): in the booking wizard, when   ║
 * ║ you click "How many suitcase?" the dropdown opens with invisible ║
 * ║ options (1, 2, 3, 4...) — white text on white bg OR light text   ║
 * ║ on light bg. Same for "Number of passengers". Both are Amelia    ║
 * ║ custom_fields of type `select` (verified in wp_amelia_custom_    ║
 * ║ fields).                                                          ║
 * ║                                                                   ║
 * ║ Root cause: Element Plus renders .el-select-dropdown as a        ║
 * ║ popper teleported to document.body → escapes .amelia-v2-booking  ║
 * ║ parent scope → rg-amelia-contrast.php's selectors don't reach    ║
 * ║ it (grep `el-select-dropdown` in that file = 0 hits).            ║
 * ║                                                                   ║
 * ║ Fix: scope with body:has(.amelia-v2-booking) so the rule only    ║
 * ║ applies when Amelia is actually mounted on the page (zero bleed  ║
 * ║ to WooCommerce / admin / other areas). :has() supported in all   ║
 * ║ modern browsers (Chrome 105+, Safari 15.4+, FF 121+).            ║
 * ║                                                                   ║
 * ║ Contrast floor (WCAG AA 4.5:1):                                  ║
 * ║   - option text rgba(230,225,195,0.92) on rgb(20,16,10) ≈ 10:1 ✓ ║
 * ║   - hovered option #0f0c08 on #CCC593 ≈ 8.9:1 ✓                  ║
 * ║                                                                   ║
 * ║ CSS-only. NO functionality touch. Revert: delete this file.     ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-select-dropdown-contrast">
	/* ==================================================================
	 * Popper shell — dark translucent with champagne hairline
	 * ================================================================== */
	body:has(.amelia-v2-booking) .el-select-dropdown,
	body:has(.amelia-v2-booking) .el-popper.el-select__popper,
	body:has(.amelia-v2-booking) .am-popover-popper.el-select__popper {
		background-color: rgba(20, 16, 10, 0.98) !important;
		border: 1px solid rgba(204, 197, 147, 0.35) !important;
		border-radius: 3px !important;
		box-shadow: 0 6px 24px rgba(0, 0, 0, 0.55) !important;
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* Popper arrow (pointer) — match dark bg */
	body:has(.amelia-v2-booking) .el-popper.el-select__popper .el-popper__arrow::before,
	body:has(.amelia-v2-booking) .el-select-dropdown .el-popper__arrow::before {
		background-color: rgba(20, 16, 10, 0.98) !important;
		border-color: rgba(204, 197, 147, 0.35) !important;
	}

	/* Inner scroll wrapper + list */
	body:has(.amelia-v2-booking) .el-select-dropdown .el-scrollbar,
	body:has(.amelia-v2-booking) .el-select-dropdown .el-scrollbar__wrap,
	body:has(.amelia-v2-booking) .el-select-dropdown .el-select-dropdown__wrap,
	body:has(.amelia-v2-booking) .el-select-dropdown .el-select-dropdown__list {
		background-color: transparent !important;
	}

	/* ==================================================================
	 * THE FIX — individual options (1, 2, 3, 4, ... Number of suitcases)
	 * ================================================================== */
	body:has(.amelia-v2-booking) .el-select-dropdown__item {
		background-color: transparent !important;
		color: rgba(230, 225, 195, 0.92) !important;
		font-size: 14px !important;
		padding: 10px 16px !important;
		line-height: 1.5 !important;
	}

	/* Hovered option — champagne fill, dark text (strong contrast) */
	body:has(.amelia-v2-booking) .el-select-dropdown__item.hover,
	body:has(.amelia-v2-booking) .el-select-dropdown__item:hover {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
		font-weight: 600 !important;
	}

	/* Currently selected option — bold champagne */
	body:has(.amelia-v2-booking) .el-select-dropdown__item.selected,
	body:has(.amelia-v2-booking) .el-select-dropdown__item.is-selected {
		color: #CCC593 !important;
		background-color: rgba(204, 197, 147, 0.1) !important;
		font-weight: 600 !important;
	}
	body:has(.amelia-v2-booking) .el-select-dropdown__item.selected.hover,
	body:has(.amelia-v2-booking) .el-select-dropdown__item.is-selected:hover {
		background-color: #CCC593 !important;
		color: #0f0c08 !important;
	}

	/* Disabled option — dimmed */
	body:has(.amelia-v2-booking) .el-select-dropdown__item.is-disabled {
		color: rgba(204, 197, 147, 0.25) !important;
		cursor: not-allowed !important;
	}

	/* "No data" / empty state text */
	body:has(.amelia-v2-booking) .el-select-dropdown__empty,
	body:has(.amelia-v2-booking) .el-select-dropdown .el-empty__description {
		color: rgba(204, 197, 147, 0.55) !important;
		font-size: 13px !important;
	}

	/* ==================================================================
	 * THE TRIGGER — closed select field (Element Plus v2 — Amelia v3)
	 *
	 * Problem (user report, 2026-04-20): after selecting "2" the dropdown
	 * closes, but the value "2" is invisible in the collapsed trigger.
	 *
	 * Root cause: EP v2 renders the selected value via .el-select__placeholder
	 * or .el-select__selected-item (INSIDE .el-select__wrapper > __selection),
	 * NOT via .el-input__inner. v1.0.0 targeted the v1 selector by mistake.
	 *
	 * Structure (verified in Amelia's stepForm.a706e754.css class list):
	 *   .el-select
	 *     .el-select__wrapper
	 *       .el-select__selection
	 *         .el-select__selected-item   ← selected value rendered here
	 *         .el-select__placeholder     ← OR placeholder when empty
	 *       .el-select__suffix
	 *         .el-select__caret
	 * ================================================================== */
	.amelia-v2-booking .el-select__wrapper {
		background-color: rgba(14, 11, 7, 0.9) !important;
		box-shadow: 0 0 0 1px rgba(204, 197, 147, 0.3) inset !important;
		color: rgba(230, 225, 195, 0.92) !important;
		border-radius: 2px !important;
	}
	.amelia-v2-booking .el-select__wrapper:hover,
	.amelia-v2-booking .el-select.is-focus .el-select__wrapper,
	.amelia-v2-booking .el-select__wrapper.is-hovering {
		box-shadow: 0 0 0 1px rgba(204, 197, 147, 0.55) inset !important;
	}

	/* The selected value text — THE FIX for user's complaint */
	.amelia-v2-booking .el-select__wrapper .el-select__selection,
	.amelia-v2-booking .el-select__wrapper .el-select__selected-item,
	.amelia-v2-booking .el-select__wrapper .el-select__placeholder,
	.amelia-v2-booking .el-select__wrapper .el-select__placeholder > span,
	.amelia-v2-booking .el-select__wrapper .el-select__tags-text {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* Placeholder in empty state — slightly dimmer, still readable */
	.amelia-v2-booking .el-select__wrapper .el-select__placeholder.is-transparent,
	.amelia-v2-booking .el-select__wrapper .el-select__placeholder:not(:has(> span:not(:empty))) {
		color: rgba(204, 197, 147, 0.55) !important;
	}

	/* Typeable input (when filterable) */
	.amelia-v2-booking .el-select__input,
	.amelia-v2-booking .el-select__input-wrapper input {
		color: rgba(230, 225, 195, 0.92) !important;
		background: transparent !important;
	}

	/* Suffix / caret */
	.amelia-v2-booking .el-select__suffix,
	.amelia-v2-booking .el-select__caret {
		color: rgba(204, 197, 147, 0.7) !important;
	}
	.amelia-v2-booking .el-select.is-focus .el-select__caret,
	.amelia-v2-booking .el-select__wrapper:hover .el-select__caret {
		color: rgba(204, 197, 147, 1) !important;
	}

	/* Legacy Element Plus v1 fallback (in case any v1 select survives) */
	.amelia-v2-booking .el-select .el-input__wrapper,
	.amelia-v2-booking .el-select .el-input .el-input__inner {
		background-color: rgba(14, 11, 7, 0.9) !important;
		color: rgba(230, 225, 195, 0.92) !important;
		box-shadow: 0 0 0 1px rgba(204, 197, 147, 0.3) inset !important;
	}

	/* Scrollbar thumb inside long dropdowns (e.g., 10+ suitcases) */
	body:has(.amelia-v2-booking) .el-select-dropdown .el-scrollbar__thumb {
		background-color: rgba(204, 197, 147, 0.35) !important;
	}
	body:has(.amelia-v2-booking) .el-select-dropdown .el-scrollbar__thumb:hover {
		background-color: rgba(204, 197, 147, 0.55) !important;
	}
	</style>
	<?php
}, 99999 );
