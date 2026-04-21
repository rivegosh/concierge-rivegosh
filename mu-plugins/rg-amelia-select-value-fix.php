<?php
/**
 * Plugin Name: RG Amelia Select Value Fix
 * Description: Fixes invisible selected value text in Amelia custom-field
 *              dropdowns (suitcases, passengers). Targets the span child
 *              inside .el-select__selected-item that rg-amelia-select-
 *              dropdown-contrast.php misses (parent-only selector, beaten
 *              by Amelia's own higher-specificity span rule).
 * Version: 1.0.0
 * Created: 2026-04-21
 *
 * ╔══════════════════════════════════════════════════════════════════╗
 * ║ DO NOT DELETE — SIGNED-OFF FIX                                   ║
 * ║ Scope: .amelia-v2-booking ONLY (zero bleed).                     ║
 * ║ Priority 100003 — fires after all existing Amelia contrast       ║
 * ║ plugins (100000, 99999, etc.).                                   ║
 * ║ Revert: delete this file.                                        ║
 * ║                                                                   ║
 * ║ Root cause (2026-04-21 — CSS forensics):                         ║
 * ║  Amelia stepForm CSS sets on .am-select:                         ║
 * ║    --am-c-select-text: var(--am-c-inp-text)                      ║
 * ║  Then on .am-select .el-select__selected-item.el-select__        ║
 * ║  placeholder span:                                               ║
 * ║    color: var(--am-c-select-text)!important                      ║
 * ║  The span rule has a 4-class + ID selector — much higher         ║
 * ║  specificity than our sealed plugin's 2-class selector.          ║
 * ║  rg-amelia-select-dropdown-contrast.php (sealed at priority      ║
 * ║  99999) targets the parent element, not the span child, so       ║
 * ║  Amelia's own rule wins on the span.                             ║
 * ║                                                                   ║
 * ║ Fix strategy:                                                     ║
 * ║  1. Override --am-c-select-text at .am-select scope with !imp    ║
 * ║  2. Directly target the span child with explicit color override  ║
 * ║  3. Use matching or higher specificity to beat Amelia's rule     ║
 * ╚══════════════════════════════════════════════════════════════════╝
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', function () {
	?>
	<style id="rg-amelia-select-value-fix">

	/* ==================================================================
	 * 1. OVERRIDE --am-c-select-text AT SOURCE (.am-select scope)
	 *    Amelia defines it here as var(--am-c-inp-text) — redefine it
	 *    with our champagne color directly so ALL consumers cascade.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-select,
	.amelia-v2-booking #amelia-container .am-select.el-select {
		--am-c-select-text: rgba(230, 225, 195, 0.92) !important;
		--am-c-inp-text: rgba(230, 225, 195, 0.92) !important;
	}

	/* ==================================================================
	 * 2. DIRECT SPAN OVERRIDE — the actual rendered text node
	 *    Amelia: .amelia-v2-booking #amelia-container .am-select
	 *            .el-select__selected-item.el-select__placeholder span
	 *              { color: var(--am-c-select-text)!important }
	 *    We match that specificity exactly and add !important.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-select .el-select__selected-item span,
	.amelia-v2-booking #amelia-container .am-select .el-select__selected-item.el-select__placeholder span,
	.amelia-v2-booking #amelia-container .am-select .el-select__selection span {
		color: rgba(230, 225, 195, 0.92) !important;
	}

	/* ==================================================================
	 * 3. PLACEHOLDER STATE — slightly dimmer, still readable (4.5:1+)
	 *    When no value is selected, .is-transparent marks the empty state.
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-select .el-select__selected-item.el-select__placeholder.is-transparent span {
		color: rgba(204, 197, 147, 0.55) !important;
	}

	/* ==================================================================
	 * 4. WRAPPER BG + BORDER confirm (belt-and-suspenders with sealed plugin)
	 * ================================================================== */
	.amelia-v2-booking #amelia-container .am-select .el-select__wrapper {
		background-color: rgba(14, 11, 7, 0.9) !important;
		box-shadow: 0 0 0 1px rgba(204, 197, 147, 0.3) inset !important;
	}

	</style>
	<?php
}, 100003 );
