<?php
/**
 * Plugin Name: RG Amelia CAPF Fix
 * Description: Fix overlapping date text in Amelia customer panel filter.
 *   Root cause: Amelia renders its own custom date DIVs
 *   (.am-date-picker__input-start / -end) AT THE SAME POSITION as
 *   Element Plus's <input class="el-range-input"> — double text render.
 *   Fix: hide Element Plus input text (transparent), keep Amelia's
 *   styled display div as the sole visible layer.
 * Author: RG
 * Version: 2.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', 'rg_amelia_capf_fix', 99999 );
function rg_amelia_capf_fix() {
    ?>
    <style id="rg-amelia-capf-fix">
    /* ─── Fix date-text overlap in Amelia customer panel filter ─── */
    /* .am-date-picker__wrapper contains BOTH:                       */
    /*   1. .am-date-picker__input (Amelia's styled display layer)   */
    /*   2. .el-date-editor > input.el-range-input (Element Plus)    */
    /* Both render the same date text at overlapping positions.      */
    /* Hide Element Plus's input text while keeping it clickable.    */
    .am-capf .el-range-input,
    .am-date-picker__wrapper .el-range-input,
    .am-capf__menu-datepicker .el-range-input {
        color: transparent !important;
        caret-color: transparent !important;
        -webkit-text-fill-color: transparent !important;
    }
    .am-capf .el-range-separator,
    .am-date-picker__wrapper .el-range-separator,
    .am-capf__menu-datepicker .el-range-separator {
        color: transparent !important;
        -webkit-text-fill-color: transparent !important;
    }
    /* Make sure Amelia's display div sits ON TOP (readable) and    */
    /* is NOT interactive (so clicks fall through to el-date-editor) */
    .am-date-picker__wrapper .am-date-picker__input,
    .am-date-picker__wrapper .am-date-picker__input-start,
    .am-date-picker__wrapper .am-date-picker__input-end {
        pointer-events: none !important;
        z-index: 2 !important;
    }
    /* Ensure the el-date-editor underneath stays clickable */
    .am-date-picker__wrapper .el-date-editor {
        z-index: 1 !important;
        position: relative !important;
    }

    /* ─── Keep the .am-capf container laid out on mobile ────────── */
    /* Secondary fix: on narrow viewports make sure timezone +      */
    /* date-picker stack cleanly without horizontal overlap.        */
    @media (max-width: 767px) {
        .am-cap .am-capf,
        .am-capf {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 12px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .am-capf > *,
        .am-capf__zone,
        .am-date-picker__wrapper {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
    </style>
    <?php
}
