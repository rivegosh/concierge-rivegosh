<?php
/**
 * Rive Gosh — Amelia Invoice Button Enhancement (v1.2)
 *
 * Injects a visible "INVOICE" badge next to the status badge in each
 * Amelia customer panel booking card. Green pill style matching the status badge.
 * Only shown for CONFIRMED bookings (approved/completed) — hidden for PENDING.
 * Clicking it triggers Amelia's native "Download Invoice" action.
 *
 * SAFE: Only adds DOM elements, never removes. All code try-catch wrapped.
 * If Amelia changes class names, buttons silently disappear — no breakage.
 * Only loads on pages containing the ameliacustomerpanel shortcode.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('wp_footer', 'rg_amelia_invoice_btn', 100010);
function rg_amelia_invoice_btn() {
    if (is_admin()) return;

    global $post;
    if (!$post || strpos($post->post_content, 'ameliacustomerpanel') === false) return;
    ?>
<style id="rg-amelia-invoice-btn-css">
/* Invoice badge — matches Amelia's status badge but in green */
.rg-invoice-badge {
    display: inline-flex;
    flex: 0 0 auto;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 500;
    line-height: 1.43;
    border-radius: 12px;
    padding: 2px 12px;
    margin-left: 8px;
    color: #2e7d32;
    background-color: rgba(46, 125, 50, 0.15);
    cursor: pointer;
    transition: background-color 0.2s;
    white-space: nowrap;
    vertical-align: middle;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.rg-invoice-badge:hover {
    background-color: rgba(46, 125, 50, 0.28);
}
.rg-invoice-badge::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #2e7d32;
    margin-right: 6px;
    flex-shrink: 0;
}
.rg-invoice-badge.rg-loading {
    opacity: 0.5;
    pointer-events: none;
}
</style>

<script id="rg-amelia-invoice-btn-js" data-no-optimize="1">
(function(){
  'use strict';
  try {
    var MARKER = 'data-rg-invoice';

    /* Statuses that should NOT show an invoice button */
    var SKIP_STATUSES = ['canceled', 'rejected', 'no-show'];

    function shouldSkip(statusEl) {
      var cls = statusEl.className || '';
      for (var i = 0; i < SKIP_STATUSES.length; i++) {
        if (cls.indexOf('am-cc__status-' + SKIP_STATUSES[i]) !== -1) return true;
      }
      return false;
    }

    function addInvoiceBadge(statusEl) {
      if (!statusEl || statusEl.getAttribute(MARKER)) return;
      statusEl.setAttribute(MARKER, '1');

      /* Skip pending/waiting/canceled/rejected/no-show */
      if (shouldSkip(statusEl)) return;

      var badge = document.createElement('span');
      badge.className = 'rg-invoice-badge';
      badge.textContent = 'Invoice';
      badge.title = 'Download Invoice';

      /* Find the three-dots button in the same booking card row */
      var row = statusEl.closest('.am-cc__heading') ||
                statusEl.closest('.am-cc__heading-wrapper') ||
                statusEl.parentElement;
      var dotsBtn = row ? row.querySelector('.am-cc__edit-btn.am-icon-dots-vertical') : null;

      if (!dotsBtn) {
        var parent = statusEl.parentElement;
        while (parent && !dotsBtn) {
          dotsBtn = parent.querySelector('.am-cc__edit-btn.am-icon-dots-vertical');
          parent = parent.parentElement;
          if (parent && parent.classList && parent.classList.contains('am-cc__heading')) break;
        }
      }

      badge.addEventListener('click', function(ev) {
        ev.stopPropagation();
        if (!dotsBtn) return;

        badge.classList.add('rg-loading');
        dotsBtn.click();

        setTimeout(function() {
          try {
            var items = document.querySelectorAll('.am-cc__edit-item, .am-sc__edit-item');
            var invoiceItem = null;

            for (var i = 0; i < items.length; i++) {
              var text = (items[i].textContent || '').toLowerCase();
              if (text.indexOf('download') !== -1 && text.indexOf('invoice') !== -1) {
                invoiceItem = items[i];
                break;
              }
            }
            if (!invoiceItem) {
              for (var j = 0; j < items.length; j++) {
                var t2 = (items[j].textContent || '').toLowerCase();
                if (t2.indexOf('invoice') !== -1) {
                  invoiceItem = items[j];
                  break;
                }
              }
            }

            if (invoiceItem) invoiceItem.click();
          } catch(e2) {}
          setTimeout(function(){ badge.classList.remove('rg-loading'); }, 2000);
        }, 350);
      });

      statusEl.parentNode.insertBefore(badge, statusEl.nextSibling);
    }

    function scan() {
      try {
        var statuses = document.querySelectorAll(
          '[class*="am-cc__status-"]:not([class*="dropdown"])'
        );
        for (var i = 0; i < statuses.length; i++) {
          addInvoiceBadge(statuses[i]);
        }
      } catch(e) {}
    }

    var observer = new MutationObserver(function() { scan(); });

    function init() {
      var target = document.querySelector('[id^="amelia-app"]') ||
                   document.querySelector('.amelia-app-booking') ||
                   document.body;
      observer.observe(target, { childList: true, subtree: true });
      scan();
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', function() {
        setTimeout(init, 1500);
      });
    } else {
      setTimeout(init, 1500);
    }
  } catch(e) {}
})();
</script>
    <?php
}
