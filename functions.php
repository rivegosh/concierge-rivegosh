<?php
/**
 * Rive Gosh Child Theme
 */

add_action( 'wp_enqueue_scripts', 'rivegosh_child_parent_theme_enqueue_styles' );
function rivegosh_child_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'colibri-wp-style', get_template_directory_uri() . '/style.css', array(), '0.1.0' );
	wp_enqueue_style( 'rivegosh-child-style', get_stylesheet_directory_uri() . '/style.css', array('colibri-wp-style'), '0.1.0' );
}

/* ===== MOBILE LOGO OVERLAY — fixed position, completely outside Colibri DOM ===== */
/* Reason: Colibri's sticky JS + AOS fight every CSS/JS centering attempt.
   Solution: hide Colibri's h4-outer on mobile, show our own fixed-position logo.
   position:fixed + left:50% + translateX(-50%) = true viewport center, immune to everything. */
add_action('wp_footer', 'rivegosh_mobile_logo_fixed', 99996);
function rivegosh_mobile_logo_fixed() {
	if (is_admin()) return;
	?>
	<style id="rg-fixed-logo-css">
	@media (max-width: 991px) {
		.rg-fixed-logo {
			position: fixed;
			top: 18px;
			left: 50%;
			transform: translateX(-50%);
			z-index: 9998;
			display: flex;
			align-items: center;
			justify-content: center;
			pointer-events: none;
			margin: 0;
			padding: 0;
		}
		.rg-fixed-logo a {
			pointer-events: auto;
			display: block;
			line-height: 0;
			margin: 0;
			padding: 0;
		}
		.rg-fixed-logo img {
			height: 55px;
			width: auto;
			display: block;
		}
	}
	@media (min-width: 992px) {
		.rg-fixed-logo { display: none !important; }
	}
	</style>
	<div class="rg-fixed-logo">
		<a href="<?php echo esc_url(home_url('/')); ?>">
			<img src="https://rivegosh-concierge.com/wp-content/uploads/2026/04/logo-header-light.png"
			     alt="Rive Gosh Concierge"
			     height="45" />
		</a>
	</div>
	<?php
}

add_action( 'wp_footer', 'rivegosh_late_css', 99999 );
function rivegosh_late_css() {
	?>
	<style id="rivegosh-banner-late">
	/* ============ COOKIE BANNER — v8 ============ */
	body .cmplz-cookiebanner .cmplz-header,
	body .cmplz-cookiebanner .cmplz-title,
	body .cmplz-cookiebanner .cmplz-close,
	body .cmplz-cookiebanner .cmplz-logo,
	body .cmplz-cookiebanner .cmplz-divider,
	body .cmplz-cookiebanner .cmplz-footer,
	body .cmplz-cookiebanner .cmplz-information,
	body .cmplz-cookiebanner .cmplz-links,
	body .cmplz-cookiebanner .cmplz-link,
	body .cmplz-cookiebanner a.cmplz-link,
	body .cmplz-cookiebanner .cmplz-manage-options,
	body .cmplz-cookiebanner a.cmplz-manage-options,
	body .cmplz-cookiebanner [class*="manage-options"],
	body .cmplz-cookiebanner [class*="view-preferences"]
	body .cmplz-cookiebanner .cmplz-documents,
	body .cmplz-cookiebanner .cmplz-categories,
	body .cmplz-cookiebanner button.cmplz-view-preferences { display: none !important; }

	body #cmplz-cookiebanner-container .cmplz-cookiebanner,
	body .cmplz-cookiebanner {
		background: rgba(10,10,10,0.72) !important;
		-webkit-backdrop-filter: blur(16px) saturate(160%) !important;
		backdrop-filter: blur(16px) saturate(160%) !important;
		padding: 11px 13px 7px 13px !important;
		max-width: 340px !important;
		width: 340px !important;
		bottom: 0px !important; right: 6px !important; left: auto !important; top: auto !important;
		border-radius: 4px !important;
		border: 1px solid rgba(204,197,147,0.35) !important;
	}
	body .cmplz-cookiebanner .cmplz-body { padding: 0 !important; }
	body .cmplz-cookiebanner .cmplz-message { margin: 0 !important; padding: 0 !important; }
	body .cmplz-cookiebanner .rg-banner-tagline {
		font-family: 'Inter',sans-serif !important; color: #CCC593 !important;
		font-size: 14px !important; letter-spacing: 0.18em !important; text-transform: uppercase !important;
		font-weight: 500 !important; display: block !important; margin: 0 0 2px 0 !important;
	}
	body .cmplz-cookiebanner .rg-banner-msg {
		font-family: 'Inter',sans-serif !important; color: #E8E2D0 !important;
		font-size: 11px !important; line-height: 1.35 !important; display: block !important;
		margin: 0 0 4px 0 !important; opacity: 0.72 !important;
	}
	body .cmplz-cookiebanner .cmplz-buttons { display: flex !important; gap: 6px !important; margin: 0 !important; padding: 0 !important; }
	body .cmplz-cookiebanner .cmplz-btn:not(.cmplz-manage-options):not([class*="manage"]),
	body .cmplz-cookiebanner button:not(.cmplz-close) {
		font-family: 'Inter',sans-serif !important; font-size: 10px !important;
		letter-spacing: 0.2em !important; text-transform: uppercase !important;
		padding: 10px 10px !important; border-radius: 2px !important;
		border: 1px solid #CCC593 !important; flex: 1 1 50% !important; line-height: 1 !important;
	}
	body .cmplz-cookiebanner button.cmplz-accept, body .cmplz-cookiebanner button.cmplz-accept-all,
	body .cmplz-cookiebanner .cmplz-accept { background: #CCC593 !important; color: #0A0A0A !important; }
	body .cmplz-cookiebanner button.cmplz-deny, body .cmplz-cookiebanner .cmplz-deny {
		background: transparent !important; color: #CCC593 !important;
	}

	@media (max-width: 768px) {
		body #cmplz-cookiebanner-container .cmplz-cookiebanner,
		body .cmplz-cookiebanner {
			left: 8px !important; right: 8px !important; bottom: 0px !important;
			max-width: none !important; width: auto !important; padding: 10px 12px 6px 12px !important;
		}
		body .cmplz-cookiebanner .rg-banner-tagline { font-size: 12.5px !important; letter-spacing: 0.14em !important; }
		body .cmplz-cookiebanner .rg-banner-msg { font-size: 10.5px !important; }
		body .cmplz-cookiebanner .cmplz-btn:not(.cmplz-manage-options):not([class*="manage"]),
		body .cmplz-cookiebanner button:not(.cmplz-close) { padding: 11px 10px !important; }
	}

	
/* ============ UNIVERSAL ALT-LOGO KILL (outside media query) ============ */
html body .h-logo__alt-image,
html body .h-navigation_sticky .h-logo__alt-image,
html.colibri-wp-theme body .h-logo__alt-image,
html.colibri-wp-theme body .h-navigation_sticky .h-logo__alt-image { display: none !important; visibility: hidden !important; opacity: 0 !important; }

/* ============ STICKY NAV DROPDOWN CONTRAST — v1 ============ */
/* Higher specificity (+1 class) than #colibri .sub-menu — always wins in sticky state */
@media (min-width: 992px) {
  #colibri .h-navigation_sticky .sub-menu,
  #colibri .h-navigation_sticky .colibri-menu li > ul {
    background: rgba(8,8,8,0.97) !important;
    backdrop-filter: blur(20px) saturate(180%) !important;
    -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
    border: 1px solid rgba(204,197,147,0.25) !important;
  }
  #colibri .h-navigation_sticky .sub-menu a,
  #colibri .h-navigation_sticky .colibri-menu li > ul a {
    color: rgba(204,197,147,1) !important;
  }
}

/* ============ DESKTOP STICKY — LOGO RESTORE + NAV HEIGHT FIX — v1 ============ */
@media (min-width: 992px) {
  /* Restore alt-logo in sticky desktop — overrides the global kill above (same specificity, later cascade wins).
     Apply invert filter so the white PNG appears as a dark logo against the sticky white/light nav. */
  html body .h-navigation_sticky .h-logo__alt-image {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    filter: invert(1) brightness(0.15) !important;
    -webkit-filter: invert(1) brightness(0.15) !important;
  }
  /* Trim nav bottom padding in sticky so space below items = space above */
  .h-navigation_sticky {
    padding-bottom: 12px !important;
  }
}

/* ============ MOBILE HEADER LAYOUT v4 — CORRECT: burger=h10, kill alt-logo ============ */
@media (max-width: 991px) {/* ============ DESIGN BIBLE: CTA CARDS v27 — ISOLATED BLOCKS ============ */
  /* iOS text auto-zoom kill */
  html,
  body{ -webkit-text-size-adjust: 100% !important; text-size-adjust: 100% !important; }/* Kill parent flex/gap interference — h29 becomes plain block */
  [data-colibri-id="61861-h29"],
  [data-colibri-id="61861-h29"] .h-column__content,
  [data-colibri-id="61861-h29"] .h-y-container{
    display: block !important;
    padding: 0 !important;
    margin: 0 !important;
  }/* Outer span wrappers: standalone blocks with breathing room */
  .style-local-61861-h30-outer,
  .style-local-61861-h31-outer,
  .style-local-61861-h32-outer{
    display: block !important;
    width: calc(100vw - 32px) !important;
    margin: 0 16px !important;
    max-width: none !important;
    box-sizing: border-box !important;
  }/* Individual top padding for vertical separation */
  .style-local-61861-h31-outer{ padding-top: 14px !important; }.style-local-61861-h32-outer{ padding-top: 14px !important; }/* Inner anchors: full width of wrapper */
  #colibri a[data-colibri-id="61861-h30"].h-button,
  #colibri a[data-colibri-id="61861-h31"].h-button,
  #colibri a[data-colibri-id="61861-h32"].h-button{
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    width: 100% !important;
    min-height: 48px !important;
    padding: 10px 22px !important;
    margin: 0 !important;
    border-radius: 10px !important;
    gap: 14px !important;
    text-align: left !important;
    box-sizing: border-box !important;
    font-size: 13px !important;
    letter-spacing: 0.12em !important;
    background-color: rgba(0,0,0,0.35) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
  }/* Text inside cards */
  #colibri a[data-colibri-id="61861-h30"].h-button *,
  #colibri a[data-colibri-id="61861-h31"].h-button *,
  #colibri a[data-colibri-id="61861-h32"].h-button *{
    white-space: nowrap !important;
    overflow: visible !important;
    text-overflow: clip !important;
    word-break: keep-all !important;
  }/* Icons: transfer (plane) +40%,
  ride (car) +25%,
  VIP +25% */
  #colibri .style-local-61861-h30-icon,
  #colibri .style-local-61861-h30-icon svg{
    width: 17px !important; height: 17px !important;
    font-size: 17px !important;
    flex: 0 0 auto !important;
  }#colibri .style-local-61861-h31-icon,
  #colibri .style-local-61861-h31-icon svg,
  #colibri .style-local-61861-h32-icon,
  #colibri .style-local-61861-h32-icon svg{
    width: 15px !important; height: 15px !important;
    font-size: 15px !important;
    flex: 0 0 auto !important;
  }/* KILL duplicate alt-logo (Colibri sticky variant) */
  .h-logo__alt-image{ display: none !important; }/* Header row = flex,
  space-between,
  3 columns */
  [data-colibri-id="61861-h3"],
  [data-colibri-id="61861-h3"] > *,
  [data-colibri-id="61861-h3"] .h-row{
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: space-between !important;
    width: 100% !important;
    position: relative !important;
    padding-top: 4px !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    min-height: 60px !important;
  }/* Kill h-navigation + h-row-container horizontal padding so absolute left/right = true screen edge */
  .h-section.h-navigation{ padding-left: 0 !important; padding-right: 0 !important; }.h-section.h-navigation .h-row-container{ padding-left: 0 !important; padding-right: 0 !important; }.h-section.h-navigation .h-row{ margin-left: 0 !important; margin-right: 0 !important; }/* Make header row positioning context */
  [data-colibri-id="61861-h3"],
  .style-local-61861-h3,
  .style-local-61861-h3 .h-row{ position: relative !important; }/* H8 = BURGER — yanked out of flex flow,
  pinned top-left */
  .style-local-61861-h8-outer,
  .style-local-61866-h8-outer{
    position: absolute !important;
    top: 8px !important;
    left: 0 !important;
    width: 40px !important; max-width: 40px !important;
    height: 40px !important;
    flex: 0 0 auto !important;
    order: 0 !important;
    margin: 0 !important; padding: 0 !important;
    display: flex !important; justify-content: flex-start !important; align-items: center !important;
    z-index: 100 !important;
  }.style-local-61861-h8-outer .h-column__inner,
  .style-local-61861-h8-outer .h-column__content,
  .style-local-61866-h8-outer .h-column__inner,
  .style-local-61866-h8-outer .h-column__content{ padding: 0 !important; margin: 0 !important; }/* Kill burger column's internal padding (Colibri default 10px) */
  .style-local-61861-h8-outer,
  .style-local-61861-h8-outer > .h-column__inner,
  [data-colibri-id="61861-h8"],
  /* Kill burger column's internal padding (Colibri default 10px) */
  .style-local-61866-h8-outer,
  .style-local-61866-h8-outer > .h-column__inner{ padding-left: 0 !important; padding-right: 0 !important; }/* H4 = LOGO — absolute center of row (geometric dead center) */
  .style-local-61861-h4-outer,
  /* H4 = LOGO — absolute center of row (geometric dead center) */
  .style-local-61866-h4-outer{
    position: absolute !important;
    left: 50% !important;
    top: 50% !important;
    transform: translate(-50%, -50%) !important;
    width: auto !important; max-width: 70% !important;
    flex: 0 0 auto !important;
    order: 2 !important;
    margin: 0 !important; padding: 0 !important;
    display: flex !important; justify-content: center !important; align-items: center !important;
    text-align: center !important;
    z-index: 50 !important;
  }.style-local-61861-h4-outer .h-column__inner,
  .style-local-61861-h4-outer .h-column__content,
  .style-local-61861-h4-outer .h-logo,
  .style-local-61861-h4-outer a,
  .style-local-61866-h4-outer .h-column__inner,
  .style-local-61866-h4-outer .h-column__content,
  .style-local-61866-h4-outer .h-logo,
  .style-local-61866-h4-outer a{
    width: auto !important; max-width: none !important;
    text-align: center !important;
    margin: 0 auto !important; padding: 0 !important;
    display: flex !important; justify-content: center !important; align-items: center !important;
  }.style-local-61861-h4-outer img,
  .style-local-61866-h4-outer img{ margin: 0 auto !important; display: block !important; }/* Logo: kill Colibri/AOS entrance animation — pure center,
  no diagonal */
  .style-local-61861-h4-outer,
  .style-local-61861-h4-outer *,
  .style-local-61866-h4-outer,
  .style-local-61866-h4-outer *{
    animation: none !important;
    -webkit-animation: none !important;
    transition: opacity 0.35s ease !important;
  }.style-local-61861-h4-outer,
  .style-local-61866-h4-outer{
    transform: translate(-50%, -50%) !important;
  }.style-local-61861-h4-outer[data-aos],
  .style-local-61861-h4-outer [data-aos],
  .style-local-61866-h4-outer[data-aos],
  .style-local-61866-h4-outer [data-aos]{
    opacity: 1 !important;
    transform: translate(-50%, -50%) !important;
  }/* H6 = hide spacer (no longer needed — burger is absolute) */
  .style-local-61861-h6-outer,
  /* H6 = hide spacer (no longer needed — burger is absolute) */
  .style-local-61866-h6-outer{ display: none !important; }/* Burger button
  /* v54: TRUE CENTER — section is positioning parent (full-width), logo left:0/right:0/margin:auto */
  .h-section.h-navigation{
    position: relative !important;
  }
  /* LOGO: section is positioning parent (full-width), left:50% from section edge = true center */
  .h-section.h-navigation .style-local-61861-h4-outer,
  .h-section.h-navigation .style-local-61866-h4-outer{
    position: absolute !important;
    left: 50% !important;
    right: auto !important;
    top: 3px !important;
    transform: translateX(-50%) !important;
    width: auto !important;
    max-width: 55% !important;
    margin: 0 !important;
    padding: 0 !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    z-index: 50 !important;
  }
  .h-section.h-navigation .style-local-61861-h4-outer img,
  .h-section.h-navigation .style-local-61866-h4-outer img{
    max-height: 62px !important;
    width: auto !important; height: auto !important;
    display: block !important; margin: 0 auto !important;
  }
  /* Kill AOS ONLY on logo element */
  .h-section.h-navigation .style-local-61861-h4-outer[data-aos],
  .h-section.h-navigation .style-local-61861-h4-outer [data-aos],
  .h-section.h-navigation .style-local-61866-h4-outer[data-aos],
  .h-section.h-navigation .style-local-61866-h4-outer [data-aos]{
    opacity: 1 !important; transform: translateX(-50%) !important; animation: none !important;
  }
  /* BURGER: absolute top-left within section */
  .h-section.h-navigation .style-local-61861-h8-outer,
  .h-section.h-navigation .style-local-61866-h8-outer{
    position: absolute !important;
    top: 8px !important; left: 0 !important; right: auto !important;
    width: 40px !important; max-width: 40px !important; height: 40px !important;
    margin: 0 !important; padding: 0 !important;
    display: flex !important; justify-content: flex-start !important; align-items: center !important;
    z-index: 100 !important;
  } — 50% opacity,
  thin */
  .h-hamburger-button{
    opacity: 0.5 !important;
    padding: 6px !important;
    width: 36px !important; height: 36px !important;
    margin: 0 !important;
  }.h-hamburger-button svg{ width: 22px !important; height: 22px !important; }.h-hamburger-button path,
  .h-hamburger-button line{ stroke-width: 1.2 !important; }.h-hamburger-button span{ height: 1.2px !important; background: #CCC593 !important; }/* legacy hero CTA removed — see DESIGN BIBLE block */
  [data-colibri-id="61861-h28"],
  .style-local-61861-h28{
    order: 2 !important; margin-top: 8px !important; margin-bottom: 0 !important;
  }.h-y-container.h-column__content{ display: flex !important; flex-direction: column !important; }#overlappable-2{ padding-bottom: 140px !important; }/* ============ CTA v37 — hover text stays gold,
  cards moved up ============ */
  #colibri a[data-colibri-id="61861-h30"].h-button:hover,
  #colibri a[data-colibri-id="61861-h30"].h-button:hover *,
  #colibri a[data-colibri-id="61861-h31"].h-button:hover,
  #colibri a[data-colibri-id="61861-h31"].h-button:hover *,
  #colibri a[data-colibri-id="61861-h32"].h-button:hover,
  #colibri a[data-colibri-id="61861-h32"].h-button:hover *,
  #colibri a[data-colibri-id="61861-h30"].h-button:active,
  #colibri a[data-colibri-id="61861-h30"].h-button:active *,
  #colibri a[data-colibri-id="61861-h31"].h-button:active,
  #colibri a[data-colibri-id="61861-h31"].h-button:active *,
  #colibri a[data-colibri-id="61861-h32"].h-button:active,
  #colibri a[data-colibri-id="61861-h32"].h-button:active *{
    color: #CCC593 !important;
    fill: #CCC593 !important;
  }.style-local-61861-h30-outer{
    margin-top: -60px !important;
  }/* ============ MOBILE MENU v40 — CLEAN RESET ============ */
  /* Panel: 85vw from right. Colibri handles open/close natively (data-click-outside). */
  .h-offcanvas-panel{
    width: 85vw !important;
    max-width: 85vw !important;
    right: 0 !important;
    left: auto !important;
    background-color: #0a0a0a !important;
    padding: 70px 24px 40px 24px !important;
    border: none !important;
    border-radius: 0 !important;
    overflow-y: auto !important;
  }/* Kill ALL visual noise — no borders,
  no backgrounds inside panel */
  .h-offcanvas-panel *,
  .h-offcanvas-panel .colibri-menu *,
  .h-offcanvas-panel .sub-menu *{
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
    background: transparent !important;
    background-color: transparent !important;
  }/* List resets */
  .h-offcanvas-panel .colibri-menu,
  .h-offcanvas-panel .sub-menu{
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
  }.h-offcanvas-panel .colibri-menu li,
  .h-offcanvas-panel .sub-menu li{
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
    display: block !important;
    width: 100% !important;
  }/* VIP Customer (63536): hide parent label,
  expand children as main menu */
  .h-offcanvas-panel .menu-item-63536 > a{
    display: none !important;
  }.h-offcanvas-panel .menu-item-63536 > .sub-menu{
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    max-height: none !important;
    overflow: visible !important;
    position: static !important;
    transform: none !important;
    padding: 0 !important;
    margin: 0 !important;
  }/* All visible links — white Inter,
  centered,
  no decoration */
  .h-offcanvas-panel .menu-item-63536 > .sub-menu > li > a,
  .h-offcanvas-panel .menu-item-64806 > a,
  .h-offcanvas-panel .menu-item-73499 > a{
    display: block !important;
    padding: 14px 0 !important;
    text-align: center !important;
    color: #FFFFFF !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 15px !important;
    font-weight: 400 !important;
    letter-spacing: 0.02em !important;
    text-transform: none !important;
    text-decoration: none !important;
    width: 100% !important;
    background: transparent !important;
  }/* Divider before Professional */
  .h-offcanvas-panel .menu-item-64806{
    border-top: 1px solid rgba(255,255,255,0.15) !important;
    margin-top: 20px !important;
    padding-top: 6px !important;
  }/* Hide Professional and Affiliate submenus */
  .h-offcanvas-panel .menu-item-64806 > .sub-menu,
  .h-offcanvas-panel .menu-item-73499 > .sub-menu{
    display: none !important;
  }/* Hide ALL SVG accordion arrows inside offcanvas links */
  .h-offcanvas-panel .colibri-menu a svg,
  .h-offcanvas-panel .colibri-menu a .svg-inline--fa,
  .h-offcanvas-panel .h-submenu-toggle,
  .h-offcanvas-panel [class*="caret"],
  .h-offcanvas-panel [class*="angle"]{
    display: none !important;
    width: 0 !important;
    height: 0 !important;
  }/* Hover state */
  .h-offcanvas-panel .colibri-menu a:hover,
  .h-offcanvas-panel .colibri-menu a:focus{
    color: #CCC593 !important;
    background: transparent !important;
  }/* Footer inside drawer */
  .h-offcanvas-panel .offscreen-footer{
    padding: 20px 0 0 0 !important;
    margin-top: 24px !important;
    text-align: center !important;
    color: rgba(255,255,255,0.35) !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 11px !important;
    letter-spacing: 0.08em !important;
    text-transform: none !important;
    border-top: 1px solid rgba(255,255,255,0.08) !important;
  }/* ============ v41 — kill two-column bug,
  hide gt-li,
  tighten pro/affiliate ============ */
  .h-offcanvas-panel .colibri-menu,
  .h-offcanvas-panel .colibri-menu-container,
  .h-offcanvas-panel .colibri-menu > li{
    display: block !important;
    flex-direction: column !important;
    flex-wrap: nowrap !important;
    float: none !important;
    width: 100% !important;
  }.h-offcanvas-panel .menu-item-gtranslate,
  .h-offcanvas-panel [class*="gt-menu-"],
  .h-offcanvas-panel li[class*="gtranslate"]{
    display: none !important;
    visibility: hidden !important;
    width: 0 !important;
    height: 0 !important;
    overflow: hidden !important;
  }.h-offcanvas-panel .menu-item-64806{
    margin-top: 8px !important;
    padding-top: 4px !important;
  }.h-offcanvas-panel .menu-item-73499{
    margin-top: 0 !important;
    padding-top: 0 !important;
  }.h-offcanvas-panel .menu-item-64806 > a,
  .h-offcanvas-panel .menu-item-73499 > a{
    padding: 8px 0 !important;
  }.h-offcanvas-panel .colibri-menu li,
  .h-offcanvas-panel .colibri-menu li a{
    outline: none !important;
    box-shadow: none !important;
    border-left: none !important;
    border-right: none !important;
    border-bottom: none !important;
  }
  /* MOBILE LOGO: Colibri's logo column hidden — replaced by .rg-fixed-logo overlay.
     Uses high-specificity selectors to beat the .h-section.h-navigation scope rules above. */
  #colibri .h-section.h-navigation .style-local-61861-h4-outer,
  #colibri .h-section.h-navigation .style-local-61866-h4-outer,
  .style-local-61861-h4-outer,
  .style-local-61866-h4-outer { display: none !important; visibility: hidden !important; }

  /* ============ MOBILE FORM PADDING v1 — 7px edge breathing room ============ */
  /* Ultimate Member forms (login, register, profile) */
  .um {
    padding-left: 7px !important;
    padding-right: 7px !important;
    box-sizing: border-box !important;
  }
  /* WooCommerce forms (checkout, my account, edit address) */
  .woocommerce form,
  .woocommerce-page .entry-content .woocommerce,
  .woocommerce-account .woocommerce {
    padding-left: 7px !important;
    padding-right: 7px !important;
    box-sizing: border-box !important;
  }
  /* Bootstrap/generic inputs: prevent overflow, ensure box model is sane */
  input[type="text"],
  input[type="email"],
  input[type="password"],
  input[type="number"],
  input[type="tel"],
  input[type="search"],
  select,
  textarea {
    max-width: 100% !important;
    box-sizing: border-box !important;
  }

}
  /* Outer span wrappers — wider (less margin) */
  .style-local-61861-h30-outer,
  .style-local-61861-h31-outer,
  .style-local-61861-h32-outer {
    display: flex !important;
    width: 100% !important;
    max-width: 360px !important;
    margin: 0 auto !important;
  }
  /* Inner anchors */
  #colibri a[data-colibri-id="61861-h30"].h-button,
  #colibri a[data-colibri-id="61861-h31"].h-button,
  #colibri a[data-colibri-id="61861-h32"].h-button {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-start !important;
    width: 100% !important;
    min-height: 48px !important;
    padding: 10px 22px !important;
    margin: 0 !important;
    border-radius: 10px !important;
    gap: 14px !important;
    text-align: left !important;
    box-sizing: border-box !important;
    font-size: 13px !important;
    letter-spacing: 0.12em !important;
    background-color: rgba(0,0,0,0.35) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
  }
  a[data-colibri-id="61861-h30"].h-button *,
  a[data-colibri-id="61861-h31"].h-button *,
  a[data-colibri-id="61861-h32"].h-button *,
  [data-colibri-id="61861-h30"] *,
  [data-colibri-id="61861-h31"] *,
  [data-colibri-id="61861-h32"] * {
    white-space: nowrap !important;
    overflow: visible !important;
    text-overflow: clip !important;
    word-break: keep-all !important;
  }
  /* Icons: transfer (plane) +40%, ride (car) +25%, VIP +25% */
  .style-local-61861-h30-icon,
  .style-local-61861-h30-icon svg {
    width: 17px !important; height: 17px !important;
    font-size: 17px !important;
    flex: 0 0 auto !important;
  }
  .style-local-61861-h31-icon,
  .style-local-61861-h31-icon svg,
  .style-local-61861-h32-icon,
  .style-local-61861-h32-icon svg {
    width: 15px !important; height: 15px !important;
    font-size: 15px !important;
    flex: 0 0 auto !important;
  }
}


/* ============================================
   HOMEPAGE CARDS — Center, Hover, Gap (2026-04-15)
   ============================================ */

/* Center text+icon — exact Colibri selector, loads later so wins cascade */
#colibri a[data-colibri-id="61861-h30"].h-button,
#colibri a[data-colibri-id="61861-h31"].h-button,
#colibri a[data-colibri-id="61861-h32"].h-button {
  justify-content: center !important;
}

/* Vertical gap between cards */
.style-local-61861-h30-outer,
.style-local-61861-h31-outer {
  margin-bottom: 10px !important;
}

/* Hover — gold tint, visible on dark background */
[data-colibri-id="61861-h30"]:hover,
[data-colibri-id="61861-h31"]:hover,
[data-colibri-id="61861-h32"]:hover {
  background: rgba(204, 197, 147, 0.18) !important;
  border-color: rgba(204, 197, 147, 0.55) !important;
}


/* ============ GTRANSLATE v40 — Hide when drawer open ============ */
body.h-offcanvas-opened .gt_switcher_wrapper,
body.h-offcanvas-opened .gt_white_content,
body.h-offcanvas-opened .gt_float_switcher,
body.h-offcanvas-opened [class*="gt_switcher"] {
  display: none !important;
  opacity: 0 !important;
  pointer-events: none !important;
}


/* ============ GTRANSLATE v40 — hide when Colibri opens drawer ============ */
/* Colibri adds 'h-offcanvas-opened' to body when panel is open */
body.h-offcanvas-opened .gt_white_content,
body.h-offcanvas-opened .gt_switcher_wrapper,
body.h-offcanvas-opened [class*="gt_switcher"] {
  display: none !important;
  opacity: 0 !important;
  pointer-events: none !important;
}


/* ============================================
   HOMEPAGE HERO v3 — Centered + raised (2026-04-15)
   ============================================ */

@media (min-width: 769px) {
  /* h26: absolute positioning within h25 hero — raised to upper third */
  [data-colibri-id="61861-h26"] {
    position: absolute !important;
    top: 22% !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    margin: 0 !important;
    transform: none !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    padding: 0 !important;
    box-sizing: border-box !important;
  }
  /* Fix Colibri h-row: overrides justify-content-lg-end → center */
  [data-colibri-id="61861-h26"] > div {
    justify-content: center !important;
    width: 100% !important;
  }
  /* Cards inner flex container */
  [data-colibri-id="61861-h29"] .h-x-container-inner {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: stretch !important;
    gap: 24px !important;
    width: 100% !important;
  }
  [data-colibri-id="61861-h30"],
  [data-colibri-id="61861-h31"],
  [data-colibri-id="61861-h32"] {
    flex: 1 1 0 !important;
    max-width: 290px !important;
    min-width: 160px !important;
    position: static !important;
  }
}

/* Mid breakpoint: tablets / small desktops (769–1100px) */
@media (min-width: 769px) and (max-width: 1100px) {
  [data-colibri-id="61861-h26"] { top: 18% !important; }
  [data-colibri-id="61861-h30"],
  [data-colibri-id="61861-h31"],
  [data-colibri-id="61861-h32"] {
    max-width: 220px !important;
    min-width: 120px !important;
  }
}

/* ============ FOOTER: KILL TEXTURE + DARK BRAND BG ============ */
/* Colibri footer section #footer1 / 61872-f2 has a sports-texture bg image — nuke it, use near-black */
#footer1,
.style-local-61872-f2,
[data-colibri-id="61872-f2"] {
  background-image: none !important;
  background-color: #0c0c0c !important;
}
/* Links → cognac; secondary copy → cognac 55% */
#footer1 a,
.style-local-61872-f2 a { color: #CCC593 !important; text-decoration: none !important; }
#footer1 a:hover,
.style-local-61872-f2 a:hover { color: #fff !important; }
#footer1,
.style-local-61872-f2 { color: rgba(204,197,147,0.55) !important; }
/* Hide Colibri footer entirely — replaced by #rg-footer-bar injected via PHP */
.page-footer,
[data-colibri-id="61872-f1"],
.style-local-61872-f1 { display: none !important; }
/* Our custom footer bar: pure text, fixed to viewport bottom, zero background */
#rg-footer-bar {
  position: fixed;
  bottom: 20px;
  left: 0;
  right: 0;
  text-align: center;
  z-index: 9000;
  font-family: 'Inter', sans-serif;
  font-size: 11px;
  letter-spacing: 0.06em;
  color: rgba(204,197,147,0.5);
  white-space: nowrap;
  pointer-events: none;
  background: none !important;
}
#rg-footer-bar a {
  color: rgba(204,197,147,0.5) !important;
  text-decoration: none !important;
  pointer-events: auto;
}
#rg-footer-bar a:hover { color: #CCC593 !important; }
#rg-footer-bar .rg-fb-sep { margin: 0 16px; opacity: 0.3; }
@media (max-width: 991px) {
  #rg-footer-bar { font-size: 10px; bottom: 12px; }
}

/* ============================================================
   HERO TEXT: desktop reduce ~50% + line-height 1.25
   Mobile untouched (user confirmed mobile is perfect)
   ============================================================ */
@media (min-width: 992px) {
  .h-section.h-hero h1,
  .h-section.h-hero h2,
  .h-section.h-hero h3,
  .h-section.h-hero .h-heading,
  .h-section.h-hero [class*="h-heading"] {
    font-size: 32px !important;
    line-height: 1.25 !important;
  }
}

/* ============================================================
   HERO ARROW: champagne gold + mobile center
   ============================================================ */
.h-scroll-to__outer svg,
.h-down-arrow svg,
.move-down-bounce svg {
  color: #CCC593 !important;
  stroke: #CCC593 !important;
  fill: #CCC593 !important;
}
/* Some Colibri arrows use border/pseudo instead of SVG */
.h-scroll-to__outer i,
.h-down-arrow i,
.move-down-bounce i { color: #CCC593 !important; }
/* Mobile: center the arrow horizontally */
@media (max-width: 991px) {
  .h-scroll-to__outer,
  .h-down-arrow {
    left: 50% !important;
    transform: translateX(-50%) !important;
    right: auto !important;
    position: absolute !important;
  }
}

/* ============ DRAWER: HIDE ON DESKTOP ============ */
/* #rg-drawer HTML is always emitted — only CSS is media-gated → leaks on desktop. Kill it. */
@media (min-width: 992px) {
  #rg-drawer,
  #rg-drawer-backdrop { display: none !important; }
}

/* ============================================================
   PHASE 1: ULTIMATE MEMBER FORMS — DARK LUXURY TREATMENT
   Targets: /login-2/ and /register/ (UM form IDs 73395, 73396)
   ============================================================ */
/* Page-level background */
.um-page-login-2 .site-content,
.um-page-register .site-content,
body.page-id-73400,
body.page-id-73401 { background: #0c0c0c !important; }

/* UM outer wrapper — scoped to login + register pages only */
body.page-id-73400 .um,
body.page-id-73401 .um { max-width: 480px !important; margin: 0 auto !important; }

/* UM form fields */
.um-field-label label,
.um-field-label span { color: rgba(204,197,147,0.7) !important; font-family: 'Inter', sans-serif !important; font-size: 11px !important; letter-spacing: 0.1em !important; text-transform: uppercase !important; }
.um-field-input input[type="text"],
.um-field-input input[type="email"],
.um-field-input input[type="password"],
.um-field-input input[type="tel"] {
  background: rgba(255,255,255,0.05) !important;
  border: 1px solid rgba(204,197,147,0.25) !important;
  border-radius: 2px !important;
  color: #fff !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 15px !important;
  padding: 14px 14px !important;
}
.um-field-input input:focus { border-color: #CCC593 !important; outline: none !important; }
/* Eye icon wrapper for UM password fields */
.rg-pw-wrap { position: relative !important; display: block !important; }
.rg-pw-wrap input { padding-right: 44px !important; width: 100% !important; box-sizing: border-box !important; }
.rg-pw-toggle {
  position: absolute !important; right: 12px !important; top: 50% !important;
  transform: translateY(-50%) !important;
  background: none !important; border: none !important; cursor: pointer !important;
  padding: 4px !important; color: rgba(204,197,147,0.5) !important;
  display: flex !important; align-items: center !important;
}
.rg-pw-toggle:hover { color: #CCC593 !important; }
.rg-pw-toggle svg { width: 18px !important; height: 18px !important; display: block !important; }

/* UM submit button — override UM inline styles via high-specificity */
.um .um-button,
.um input[type="submit"],
.um button[type="submit"] {
  background: #CCC593 !important;
  background-color: #CCC593 !important;
  border: none !important;
  border-radius: 2px !important;
  color: #0c0c0c !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 12px !important;
  font-weight: 600 !important;
  letter-spacing: 0.12em !important;
  text-transform: uppercase !important;
  padding: 14px 32px !important;
  cursor: pointer !important;
  transition: background 0.2s, color 0.2s !important;
}
.um .um-button:hover { background: #fff !important; background-color: #fff !important; }

/* UM secondary links (Login / Register toggle) */
.um-col-alt a, .um-col-alt span { color: rgba(204,197,147,0.55) !important; }
.um-col-alt a:hover { color: #CCC593 !important; }

/* UM error messages */
.um .um-notice { background: rgba(204,197,147,0.08) !important; border-color: #CCC593 !important; color: #CCC593 !important; }

/* ============================================================
   PHASE 2: AMELIA BOOKING GATE — DARK TREATMENT
   /booking-vip/ (page 54773) — Colibri sections + Amelia panel
   ============================================================ */
/* Kill the white overlay on the booking page header card */
[data-colibri-id="54773-c2"] .overlay-image-layer { background-color: #0c0c0c !important; opacity: 0.92 !important; }
[data-colibri-id="54773-c2"] { background-color: #0c0c0c !important; }
/* Main Amelia section bg */
[data-colibri-id="54773-c9"],
.style-local-54773-c9 { background-color: #0c0c0c !important; }
/* Column inners: c4 = shortcode/empty column, c6 = text/dashboard panel */
[data-colibri-id="54773-c4"],
.style-local-54773-c4,
[data-colibri-id="54773-c6"],
.style-local-54773-c6 { background-color: #0c0c0c !important; color: rgba(255,255,255,0.8) !important; }

/* Amelia v2 customer panel — login gate + general UI */
.amelia-app-wrapper,
.amelia-app { background: transparent !important; }
/* Login form card */
.amelia-app-wrapper .am-auth,
.amelia-app-wrapper .am-login { background: rgba(255,255,255,0.04) !important; border: 1px solid rgba(204,197,147,0.15) !important; border-radius: 4px !important; }
/* Amelia headings */
.amelia-app-wrapper h1, .amelia-app-wrapper h2,
.amelia-app-wrapper h3, .amelia-app-wrapper h4 { color: #CCC593 !important; font-family: 'Cormorant Garamond', 'Georgia', serif !important; }
/* Amelia body text — avoid div (too broad, breaks status chips/error states) */
.amelia-app-wrapper p,
.amelia-app-wrapper label { color: rgba(255,255,255,0.8) !important; }
/* Amelia inputs */
.amelia-app-wrapper input[type="text"],
.amelia-app-wrapper input[type="email"],
.amelia-app-wrapper input[type="password"] {
  background: rgba(255,255,255,0.06) !important;
  border: 1px solid rgba(204,197,147,0.25) !important;
  color: #fff !important; border-radius: 2px !important;
}
/* Amelia primary button — Element UI + Amelia classes */
.amelia-app-wrapper .el-button--primary,
.amelia-app-wrapper button.el-button--primary,
.amelia-app-wrapper .am-button--primary {
  background-color: #CCC593 !important;
  border-color: #CCC593 !important;
  color: #0c0c0c !important;
  font-weight: 600 !important; letter-spacing: 0.08em !important;
}
.amelia-app-wrapper .el-button--primary:hover { background-color: #fff !important; border-color: #fff !important; }
/* Amelia secondary/text buttons */
.amelia-app-wrapper .el-button--text,
.amelia-app-wrapper .el-link { color: #CCC593 !important; }

/* ============================================================
   PHASE 3: WOOCOMMERCE MY ACCOUNT — DARK SIDEBAR
   /my-account/ (page 16) — WooCommerce account area
   ============================================================ */
/* Page wrapper */
.woocommerce-account { background: #0c0c0c !important; }
.woocommerce-account .site-content { background: #0c0c0c !important; }

/* Sidebar navigation */
.woocommerce-account .woocommerce-MyAccount-navigation {
  background: #111 !important;
  border-right: 1px solid rgba(204,197,147,0.12) !important;
  padding: 24px 0 !important;
  border-radius: 2px !important;
}
.woocommerce-account .woocommerce-MyAccount-navigation ul { list-style: none !important; margin: 0 !important; padding: 0 !important; }
.woocommerce-account .woocommerce-MyAccount-navigation li { border-bottom: 1px solid rgba(255,255,255,0.04) !important; }
.woocommerce-account .woocommerce-MyAccount-navigation li a {
  display: block !important;
  padding: 13px 24px !important;
  color: rgba(204,197,147,0.6) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 11px !important;
  font-weight: 400 !important;
  letter-spacing: 0.1em !important;
  text-transform: uppercase !important;
  text-decoration: none !important;
  transition: color 0.2s, background 0.2s !important;
}
.woocommerce-account .woocommerce-MyAccount-navigation li a:hover,
.woocommerce-account .woocommerce-MyAccount-navigation li.is-active a,
.woocommerce-account .woocommerce-MyAccount-navigation li.woocommerce-MyAccount-navigation-link--is-active a {
  color: #CCC593 !important;
  background: rgba(204,197,147,0.06) !important;
  border-left: 2px solid #CCC593 !important;
  padding-left: 22px !important;
}

/* Content area */
.woocommerce-account .woocommerce-MyAccount-content {
  background: rgba(255,255,255,0.03) !important;
  border: 1px solid rgba(204,197,147,0.08) !important;
  color: rgba(255,255,255,0.85) !important;
  border-radius: 2px !important;
  padding: 32px !important;
}
.woocommerce-account .woocommerce-MyAccount-content h2,
.woocommerce-account .woocommerce-MyAccount-content h3 { color: #CCC593 !important; font-family: 'Cormorant Garamond', 'Georgia', serif !important; }
.woocommerce-account .woocommerce-MyAccount-content a { color: #CCC593 !important; }
.woocommerce-account .woocommerce-MyAccount-content a:hover { color: #fff !important; }
.woocommerce-account .woocommerce-MyAccount-content table th { color: rgba(204,197,147,0.55) !important; border-color: rgba(204,197,147,0.12) !important; }
.woocommerce-account .woocommerce-MyAccount-content table td { color: rgba(255,255,255,0.8) !important; border-color: rgba(255,255,255,0.06) !important; }

/* ============================================================
   PHASE 6: REMAINING PORTAL PAGES — DARK LUXURY TREATMENT
   ⚠️  CURRENT WORK — 2026-04-16 (Chi/Sonnet) — DO NOT MODIFY
   Pages: WC MyAccount guest(16), Account(73404), Members(73402), FAQ(61943)
   ============================================================ */

/* --- Page-level dark background --- */
body.page-id-54773,
body.page-id-73404,
body.page-id-73402,
body.page-id-61943 { background: #0c0c0c !important; }

/* Kill white Colibri section backgrounds on all portal pages */
body.page-id-16 .h-section,
body.page-id-54773 .h-section,
body.page-id-73404 .h-section,
body.page-id-73402 .h-section,
body.page-id-61943 .h-section { background-color: #0c0c0c !important; }

body.page-id-54773 .site-content,
body.page-id-73404 .site-content,
body.page-id-73402 .site-content,
body.page-id-61943 .site-content { background: #0c0c0c !important; }

/* FAQ direct section override — beats Colibri style-994 global class */
.style-local-61943-c2 { background-color: #0c0c0c !important; background: #0c0c0c !important; }
/* Booking VIP direct overrides — catches any remaining white wrappers */
body.page-id-54773 .h-row-container { background: #0c0c0c !important; }
body.page-id-54773 .content { background: #0c0c0c !important; }

/* ===================
   WC MY ACCOUNT (16) — Guest state: Login + Register forms
   =================== */
/* Two-column login/register form cards */
.woocommerce-account .woocommerce-form-login,
.woocommerce-account .register {
  background: rgba(255,255,255,0.03) !important;
  border: 1px solid rgba(204,197,147,0.1) !important;
  border-radius: 2px !important;
  padding: 32px !important;
}
/* "Login" / "Register" headings */
.woocommerce-account .col2-set h2,
.woocommerce-account > .woocommerce > h2 {
  color: #CCC593 !important;
  font-family: 'Cormorant Garamond', 'Georgia', serif !important;
  font-size: 24px !important; letter-spacing: 0.04em !important;
}
/* All WC account labels */
.woocommerce-account .woocommerce-form__label,
.woocommerce-account label {
  color: rgba(204,197,147,0.6) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 11px !important; letter-spacing: 0.08em !important;
  text-transform: uppercase !important;
}
/* All WC account inputs (guest + logged-in edit forms) */
.woocommerce-account input[type="text"],
.woocommerce-account input[type="email"],
.woocommerce-account input[type="password"],
.woocommerce-account input[type="tel"],
.woocommerce-account select,
.woocommerce-account textarea {
  background: rgba(255,255,255,0.06) !important;
  border: 1px solid rgba(204,197,147,0.2) !important;
  border-radius: 1px !important;
  color: #fff !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 15px !important;
  padding: 14px 16px !important;
}
.woocommerce-account input:focus,
.woocommerce-account select:focus,
.woocommerce-account textarea:focus {
  border-color: rgba(204,197,147,0.6) !important;
  outline: none !important; box-shadow: none !important;
}
/* Buttons — replace WooCommerce blue with cognac */
.woocommerce-account .woocommerce-Button,
.woocommerce-account button.button,
.woocommerce-account input[type="submit"].button,
.woocommerce-account button[type="submit"] {
  background: #CCC593 !important;
  color: #0c0c0c !important;
  border: none !important; border-radius: 2px !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 11px !important; font-weight: 600 !important;
  letter-spacing: 0.12em !important; text-transform: uppercase !important;
  padding: 14px 32px !important;
  transition: background 0.2s !important;
}
.woocommerce-account .woocommerce-Button:hover,
.woocommerce-account button.button:hover,
.woocommerce-account button[type="submit"]:hover { background: #fff !important; }
/* Muted helper text */
.woocommerce-account .woocommerce-LostPassword a,
.woocommerce-account .lost_password a { color: rgba(204,197,147,0.5) !important; font-size: 11px !important; }
.woocommerce-account .woocommerce-privacy-policy-text,
.woocommerce-account .woocommerce-privacy-policy-text * { color: rgba(255,255,255,0.35) !important; font-size: 11px !important; }
.woocommerce-account .woocommerce-privacy-policy-text a { color: rgba(204,197,147,0.5) !important; }
.woocommerce-account .woocommerce-form-login__rememberme span { color: rgba(255,255,255,0.45) !important; font-size: 11px !important; }
.woocommerce-account input[type="checkbox"] { accent-color: #CCC593; }
/* PROXIMITY RULE: login button further from last field than fields are from each other */
.woocommerce-account .woocommerce-form-login p.form-row:not(.woocommerce-form-row--wide) {
  margin-top: 28px !important;
  display: flex !important;
  align-items: center !important;
  flex-wrap: nowrap !important;
}
/* WC HTML order: Remember Me FIRST, button SECOND — use order to flip: button left, Remember Me right */
.woocommerce-account .woocommerce-form-login input[name="login"],
.woocommerce-account .woocommerce-form-login button[name="login"],
.woocommerce-account .woocommerce-form-login .woocommerce-Button { order: 1 !important; }
.woocommerce-account .woocommerce-form-login .woocommerce-form-login__rememberme {
  order: 2 !important;
  margin-left: auto !important;
  padding-left: 20px !important;
  white-space: nowrap !important;
}
/* WC REGISTER form on /my-orders/ — hide it; replaced with UM redirect panel via JS */
body.page-id-16 .woocommerce-form-register { display: none !important; }
/* Push login+register content right of portal sidebar (sidebar ends at ~210px from left) */
@media (min-width: 992px) {
  body.page-id-16:not(.woocommerce-logged-in) #customer_login,
  body.page-id-16 #customer_login {
    padding-left: 200px !important;
  }
  /* Narrow the Create Account (right) column — less wasted space */
  body.page-id-16 .u-column1.col-1 { width: 52% !important; }
  body.page-id-16 .u-column2.col-2 { width: 38% !important; }
}
/* WC My Account sidebar nav — hidden on all portal pages (we use our own sidebar) */
body.page-id-73404 .woocommerce-MyAccount-navigation,
body.page-id-16 .woocommerce-MyAccount-navigation,
body.page-id-73402 .woocommerce-MyAccount-navigation,
body.page-id-54773 .woocommerce-MyAccount-navigation { display: none !important; }
/* WC dashboard content: dark treatment + push right of portal sidebar */
@media (min-width: 992px) {
  body.page-id-73404 .woocommerce-MyAccount-content,
  body.page-id-16 .woocommerce-MyAccount-content {
    padding-left: 200px !important;
    width: 100% !important;
    float: none !important;
  }
}
/* Hide ugly WC "Hello [name] (not [name]? Log out)" greeting */
/* Hide WC "Hello X (not X? Log out)" greeting on portal pages (NOT the dashboard description) */
body.page-id-73404 .woocommerce-MyAccount-content > p:first-child,
body.page-id-73404 .woocommerce-MyAccount-content > p:first-of-type,
body.page-id-73404 .woocommerce-MyAccount-content > p:nth-of-type(2),
body.page-id-16 .woocommerce-MyAccount-content > p:first-child,
body.page-id-16 .woocommerce-MyAccount-content > p:first-of-type { display: none !important; }
/* Style WC dashboard paragraphs + links dark */
.woocommerce-MyAccount-content p,
.woocommerce-MyAccount-content td,
.woocommerce-MyAccount-content th,
.woocommerce-MyAccount-content label {
  color: rgba(255,255,255,0.75) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 13px !important;
}
.woocommerce-MyAccount-content a { color: #CCC593 !important; }
.woocommerce-MyAccount-content table { border-color: rgba(204,197,147,0.1) !important; width: 100% !important; }
.woocommerce-MyAccount-content table thead th {
  color: rgba(204,197,147,0.6) !important;
  font-size: 11px !important; letter-spacing: 0.08em !important; text-transform: uppercase !important;
  border-bottom: 1px solid rgba(204,197,147,0.15) !important;
  background: transparent !important;
}
.woocommerce-MyAccount-content table tbody td { border-bottom: 1px solid rgba(255,255,255,0.04) !important; }
/* WC "no orders" message */
.woocommerce-MyAccount-content .woocommerce-Message {
  background: rgba(255,255,255,0.03) !important;
  border-top: 2px solid #CCC593 !important;
  color: rgba(255,255,255,0.65) !important;
}

/* ===================
   UM ACCOUNT page (73404) — profile dark treatment
   =================== */
body.page-id-73404 .um { color: rgba(255,255,255,0.85) !important; }
body.page-id-73404 .um-profile-header-main { background: rgba(255,255,255,0.03) !important; border: 1px solid rgba(204,197,147,0.1) !important; border-radius: 2px !important; }
body.page-id-73404 .um-profile-nav { border-bottom: 1px solid rgba(204,197,147,0.1) !important; background: transparent !important; }
body.page-id-73404 .um-profile-nav-item a { color: rgba(204,197,147,0.6) !important; font-family: 'Inter', sans-serif !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.08em !important; }
body.page-id-73404 .um-profile-nav-item.active a,
body.page-id-73404 .um-profile-nav-item a:hover { color: #CCC593 !important; }
body.page-id-73404 .um-field-label label { color: rgba(204,197,147,0.55) !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.08em !important; }
body.page-id-73404 .um-field-value,
body.page-id-73404 .um-field-area { color: rgba(255,255,255,0.85) !important; }
body.page-id-73404 .um-name a { color: #CCC593 !important; font-family: 'Cormorant Garamond', serif !important; font-size: 22px !important; }
body.page-id-73404 .um-edit-btn,
body.page-id-73404 .um .um-button { background: #CCC593 !important; color: #0c0c0c !important; border: none !important; border-radius: 2px !important; font-family: 'Inter', sans-serif !important; font-size: 11px !important; font-weight: 600 !important; letter-spacing: 0.12em !important; text-transform: uppercase !important; }
body.page-id-73404 .um-edit-btn:hover,
body.page-id-73404 .um .um-button:hover { background: #fff !important; }

/* ===================
   UM MEMBERS directory (73402) — dark grid
   =================== */
body.page-id-73402 .um-members,
body.page-id-73402 .um-members-grid,
body.page-id-73402 .um { background: transparent !important; }
/* Member cards */
body.page-id-73402 .um-member-card,
body.page-id-73402 .um-member {
  background: rgba(255,255,255,0.03) !important;
  border: 1px solid rgba(204,197,147,0.1) !important;
  border-radius: 2px !important;
}
body.page-id-73402 .um-member-name a,
body.page-id-73402 .um-member-name { color: #CCC593 !important; font-family: 'Cormorant Garamond', serif !important; }
body.page-id-73402 .um-member-name a:hover { color: #fff !important; }
body.page-id-73402 .um-member-meta { color: rgba(255,255,255,0.55) !important; font-size: 11px !important; }
/* Filter/search */
body.page-id-73402 .um-members-filter input[type="search"],
body.page-id-73402 .um-members-filter input[type="text"],
body.page-id-73402 .um-members-filter select {
  background: rgba(255,255,255,0.06) !important;
  border: 1px solid rgba(204,197,147,0.2) !important;
  color: #fff !important; border-radius: 1px !important;
}
body.page-id-73402 .um-members-filter label,
body.page-id-73402 .um-members-filter span { color: rgba(204,197,147,0.6) !important; }
body.page-id-73402 .um-members-filter button,
body.page-id-73402 .um-members-filter input[type="submit"] { background: #CCC593 !important; color: #0c0c0c !important; border: none !important; border-radius: 1px !important; }
/* Pagination */
body.page-id-73402 .um-pagination a { color: rgba(204,197,147,0.6) !important; }
body.page-id-73402 .um-pagination .current,
body.page-id-73402 .um-pagination a:hover { color: #CCC593 !important; }

/* ===================
   FAQ page (61943) — Colibri text/heading overrides
   =================== */
body.page-id-61943 .h-heading,
body.page-id-61943 h1, body.page-id-61943 h2,
body.page-id-61943 h3, body.page-id-61943 h4 { color: #CCC593 !important; }
body.page-id-61943 .h-text,
body.page-id-61943 p,
body.page-id-61943 .h-accordion-content { color: rgba(255,255,255,0.8) !important; }
body.page-id-61943 .h-accordion-title { color: rgba(204,197,147,0.9) !important; border-bottom: 1px solid rgba(204,197,147,0.12) !important; }
/* Kill Colibri accordion grey (#eeeeee) — actual widget classes */
body.page-id-61943 .h-accordion-item-title {
  background: rgba(255,255,255,0.04) !important;
  border-bottom: 1px solid rgba(204,197,147,0.15) !important;
  color: rgba(204,197,147,0.9) !important;
  font-size: 13px !important;
  font-family: 'Inter', sans-serif !important;
  letter-spacing: 0.08em !important;
  text-transform: uppercase !important;
}
body.page-id-61943 .h-accordion-item-content {
  background: transparent !important;
  color: rgba(255,255,255,0.8) !important;
  font-size: 13px !important;
  font-family: 'Inter', sans-serif !important;
}
body.page-id-61943 .h-accordion-item-content p,
body.page-id-61943 .h-accordion-item-content li { font-size: 13px !important; line-height: 1.6 !important; }
/* Accordion +/- toggle buttons → cognac (override Colibri blue) */
body.page-id-61943 .h-accordion-item-title button,
body.page-id-61943 .h-accordion-item-title .expand-icon,
body.page-id-61943 .h-accordion-item-title .contract-icon,
body.page-id-61943 .h-accordion-item-title svg,
body.page-id-61943 .h-accordion-item-title svg path,
body.page-id-61943 .h-accordion-item-title svg circle,
body.page-id-61943 .h-accordion-item-title svg line,
body.page-id-61943 .expand-trigger button,
body.page-id-61943 .contract-trigger button {
  color: #CCC593 !important;
  fill: #CCC593 !important;
  stroke: #CCC593 !important;
  border-color: #CCC593 !important;
  background: transparent !important;
}
/* Q&A proximity — answer hugs its question, gap before next Q */
body.page-id-61943 .h-accordion-item { margin-bottom: 2px !important; }
body.page-id-61943 .h-accordion-item-content { padding-top: 6px !important; padding-bottom: 10px !important; }
body.page-id-61943 .h-accordion-item-content p { margin-top: 0 !important; margin-bottom: 6px !important; }
body.page-id-61943 .h-accordion-item-content p:last-child { margin-bottom: 0 !important; }
/* Booking page (54773): hide ugly Colibri card section (stripe texture + empty columns) */
body.page-id-54773 [data-colibri-id="54773-c2"],
body.page-id-54773 .style-local-54773-c2 { display: none !important; }
/* Hide Colibri "Shortcode is empty" placeholder bar */
body.page-id-54773 .shortcode-placeholder-preview { display: none !important; }
/* WC register form hidden on page 16 — replaced with UM redirect panel (see rivegosh_wc_register_replace) */
/* Kill any column inner whites on FAQ */
body.page-id-61943 .h-column__inner { background: transparent !important; }
/* Accordion container */
body.page-id-61943 .h-accordion,
body.page-id-61943 .h-accordion-item,
body.page-id-61943 .expand-trigger,
body.page-id-61943 .contract-trigger { background: transparent !important; }
/* ============================================================
   PHASE 7: AMELIA CUSTOMER PANEL — DARK EMBEDDED TREATMENT
   /booking-vip/ (page 54773) — Amelia v9.3 Vue customer panel
   Target: make the panel feel natively embedded in the dark portal
   ============================================================ */

/* --- PUSH UP: panel hugs the hero image base --- */
body.page-id-54773 .am-cap__wrapper {
  margin-top: 0 !important;
}

/* --- WRAPPER: remove white box-shadow, match dark bg --- */
body.page-id-54773 .amelia-v2-booking,
body.page-id-54773 .am-cap__wrapper {
  box-shadow: none !important;
  background: transparent !important;
}

/* --- SIDEBAR: navy → dark --- */
body.page-id-54773 .am-fs-sb {
  background: #111 !important;
  border-right: 1px solid rgba(204,197,147,0.08) !important;
}
/* Sidebar pages (Rod Andrews, Appointments, Events, Packages) */
body.page-id-54773 .am-fs-sb__page {
  color: rgba(255,255,255,0.7) !important;
}
body.page-id-54773 .am-fs-sb__page:hover,
body.page-id-54773 .am-fs-sb__page[style*="background"] {
  background: rgba(204,197,147,0.08) !important;
  color: #CCC593 !important;
}
/* Active sidebar page highlight */
body.page-id-54773 .am-fs-sb__page-wrapper .am-fs-sb__page:nth-child(1) {
  color: #CCC593 !important;
}
body.page-id-54773 .am-fs-sb__page-heading {
  color: rgba(255,255,255,0.4) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 10px !important;
  letter-spacing: 0.08em !important;
  text-transform: uppercase !important;
}
body.page-id-54773 .am-fs-sb__page-divider {
  background: rgba(204,197,147,0.1) !important;
}
body.page-id-54773 .am-fs-sb__page-icon,
body.page-id-54773 .am-fs-sb [class*="am-icon"] {
  color: rgba(204,197,147,0.5) !important;
}
body.page-id-54773 .am-fs-sb__page:hover [class*="am-icon"] {
  color: #CCC593 !important;
}
body.page-id-54773 .am-fs-sb__footer {
  display: none !important;
}

/* --- MAIN CONTENT: white → dark --- */
body.page-id-54773 .am-fs__main {
  background: #0c0c0c !important;
  color: rgba(255,255,255,0.8) !important;
  border-left: 1px solid rgba(204,197,147,0.06) !important;
}

/* --- HEADER BAR --- */
body.page-id-54773 .am-caph {
  background: rgba(255,255,255,0.02) !important;
  border-bottom: 1px solid rgba(204,197,147,0.08) !important;
}
body.page-id-54773 .am-caph__text {
  color: #CCC593 !important;
  font-family: 'Cormorant Garamond', 'Georgia', serif !important;
}
body.page-id-54773 .am-caph__main [class*="am-icon"] {
  color: rgba(204,197,147,0.5) !important;
}

/* --- TIMEZONE / DROPDOWN TEXT --- */
body.page-id-54773 .am-ctz { color: rgba(255,255,255,0.5) !important; }
body.page-id-54773 .am-ctz [class*="am-icon"] { color: rgba(204,197,147,0.4) !important; }

/* --- FILTER BAR + DATE PICKER --- */
body.page-id-54773 .am-capf {
  border-bottom: 1px solid rgba(204,197,147,0.06) !important;
}
body.page-id-54773 .am-capf__menu-btn {
  background: #CCC593 !important;
  border-color: #CCC593 !important;
  color: #0c0c0c !important;
}
body.page-id-54773 .am-capf__menu-btn:hover {
  background: #fff !important;
  border-color: #fff !important;
}
body.page-id-54773 .am-date-picker__input,
body.page-id-54773 .am-date-picker__input-start,
body.page-id-54773 .am-date-picker__input-end {
  color: rgba(255,255,255,0.7) !important;
  background: transparent !important;
}
body.page-id-54773 .am-capf__menu-datepicker,
body.page-id-54773 .am-date-picker__wrapper {
  background: rgba(255,255,255,0.04) !important;
  border: 1px solid rgba(204,197,147,0.15) !important;
  border-radius: 4px !important;
}
/* Element UI select (timezone dropdown) */
body.page-id-54773 .el-select__wrapper,
body.page-id-54773 .el-input__wrapper {
  background: rgba(255,255,255,0.04) !important;
  border: 1px solid rgba(204,197,147,0.15) !important;
  box-shadow: none !important;
  color: rgba(255,255,255,0.7) !important;
}
body.page-id-54773 .el-select__wrapper input,
body.page-id-54773 .el-input__inner,
body.page-id-54773 .el-select__selected-item,
body.page-id-54773 .el-select__placeholder {
  color: rgba(255,255,255,0.7) !important;
}

/* --- EMPTY STATE (No appointments found) --- */
body.page-id-54773 .am-ces {
  background: transparent !important;
}
body.page-id-54773 .am-ces__heading {
  color: rgba(255,255,255,0.8) !important;
  font-family: 'Cormorant Garamond', 'Georgia', serif !important;
}
body.page-id-54773 .am-ces__text {
  color: rgba(255,255,255,0.45) !important;
  font-family: 'Inter', sans-serif !important;
}
/* Tone down the empty state illustration */
body.page-id-54773 .am-ces__img-holder {
  opacity: 0.4 !important;
  filter: grayscale(0.5) !important;
}

/* --- BUTTONS --- */
body.page-id-54773 .am-button--primary,
body.page-id-54773 .am-button--primary.am-button--filled {
  background: #CCC593 !important;
  border-color: #CCC593 !important;
  color: #0c0c0c !important;
  font-weight: 600 !important;
  letter-spacing: 0.06em !important;
}
body.page-id-54773 .am-button--primary:hover {
  background: #fff !important;
  border-color: #fff !important;
}

/* --- SLIDE POPUP / MOBILE MENU --- */
body.page-id-54773 .am-slide-popup__block {
  background: #111 !important;
  border: 1px solid rgba(204,197,147,0.1) !important;
}
body.page-id-54773 .am-msd__item {
  color: rgba(255,255,255,0.7) !important;
}
body.page-id-54773 .am-msd__item:hover {
  background: rgba(204,197,147,0.06) !important;
  color: #CCC593 !important;
}
body.page-id-54773 .am-msd__item-divider {
  background: rgba(204,197,147,0.08) !important;
}

/* --- GLOBAL TEXT inside Amelia on this page --- */
body.page-id-54773 .amelia-v2-booking p,
body.page-id-54773 .amelia-v2-booking span:not([class*="am-icon"]),
body.page-id-54773 .amelia-v2-booking label {
  color: rgba(255,255,255,0.7) !important;
  font-family: 'Inter', sans-serif !important;
}
body.page-id-54773 .amelia-v2-booking a {
  color: #CCC593 !important;
}

/* --- INPUT FIELDS inside panel --- */
body.page-id-54773 .amelia-v2-booking input[type="text"],
body.page-id-54773 .amelia-v2-booking input[type="email"],
body.page-id-54773 .amelia-v2-booking input[type="password"],
body.page-id-54773 .amelia-v2-booking input[type="tel"],
body.page-id-54773 .amelia-v2-booking textarea,
body.page-id-54773 .amelia-v2-booking select {
  background: rgba(255,255,255,0.04) !important;
  border: 1px solid rgba(204,197,147,0.2) !important;
  color: #fff !important;
  border-radius: 2px !important;
  font-family: 'Inter', sans-serif !important;
}

/* --- DESKTOP: scale up 10%, tighter to portal sidebar --- */
@media (min-width: 992px) {
  body.page-id-54773 .amelia-v2-booking {
    padding-left: 120px !important;
    transform: scale(1.1) !important;
    transform-origin: top left !important;
  }
}
/* --- Kill ALL Colibri padding in the Amelia section + pull up under hero arrow --- */
body.page-id-54773 .style-local-54773-c9,
body.page-id-54773 .style-local-54773-c9 .h-row-container,
body.page-id-54773 .style-local-54773-c9 .h-column__inner,
body.page-id-54773 .style-local-54773-c9 .h-column-container {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
  margin-top: 0 !important;
}
body.page-id-54773 .style-local-54773-c8 {
  margin-bottom: 0 !important;
}
body.page-id-54773 .style-local-54773-c9 {
  margin-top: -75px !important;
  position: relative !important;
  z-index: 10 !important;
}

/* ===== PHASE 7 END ===== 2026-04-16 */

/* ============================================================
   PHASE 8: ACCOUNT PAGE (page-id-73404) UM DARK RESKIN
   + MY ORDERS (page-id-16) DASHBOARD DESCRIPTION STYLING
   ============================================================ */

/* --- MY ORDERS: dashboard description text (now visible) --- */
body.page-id-16 .woocommerce-MyAccount-content > p {
  color: rgba(255,255,255,0.55) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 13px !important;
  line-height: 1.8 !important;
  padding: 28px 32px !important;
  text-align: center !important;
}
body.page-id-16 .woocommerce-MyAccount-content > p a {
  color: rgba(204,197,147,0.7) !important;
}

/* --- ACCOUNT: UM input fields → dark --- */
body.page-id-73404 input.um-form-field,
body.page-id-73404 .um input[type="text"],
body.page-id-73404 .um input[type="email"],
body.page-id-73404 .um input[type="password"],
body.page-id-73404 .um input[type="tel"],
body.page-id-73404 .um textarea,
body.page-id-73404 .um select {
  background: rgba(255,255,255,0.04) !important;
  border: 1px solid rgba(204,197,147,0.25) !important;
  color: rgba(255,255,255,0.85) !important;
  border-radius: 2px !important;
  font-family: 'Inter', sans-serif !important;
  box-shadow: none !important;
}
body.page-id-73404 input.um-form-field:focus,
body.page-id-73404 .um input:focus {
  border-color: #CCC593 !important;
  outline: none !important;
  box-shadow: 0 0 0 2px rgba(204,197,147,0.12) !important;
}

/* --- ACCOUNT: UM nav tabs (Account / Change Password / Privacy / Delete) --- */
body.page-id-73404 .um-account-nav a {
  color: rgba(255,255,255,0.55) !important;
  border-bottom-color: rgba(204,197,147,0.1) !important;
}
body.page-id-73404 .um-account-nav a:hover {
  color: rgba(255,255,255,0.85) !important;
  border-bottom-color: rgba(204,197,147,0.35) !important;
}
body.page-id-73404 .um-account-nav a.current {
  color: #CCC593 !important;
  border-bottom-color: #CCC593 !important;
}

/* --- ACCOUNT: UM tab boxes background --- */
body.page-id-73404 .um-account-tab {
  background: rgba(255,255,255,0.02) !important;
  border: none !important;
}
body.page-id-73404 .um-account-nav a.current .um-account-tab,
body.page-id-73404 .um-account-nav a:hover .um-account-tab {
  background: rgba(204,197,147,0.05) !important;
}

/* --- ACCOUNT: Icons (UM uses um-icon + material icons font) --- */
body.page-id-73404 [class*="um-icon"],
body.page-id-73404 .um-account-tab i,
body.page-id-73404 .um-account-nav i {
  color: rgba(204,197,147,0.45) !important;
}
body.page-id-73404 .um-account-nav a.current [class*="um-icon"],
body.page-id-73404 .um-account-nav a.current i,
body.page-id-73404 .um-account-nav a:hover [class*="um-icon"],
body.page-id-73404 .um-account-nav a:hover i {
  color: #CCC593 !important;
}

/* --- ACCOUNT: Avatar ring (blue → gold) --- */
body.page-id-73404 .um-avatar,
body.page-id-73404 .um .um-avatar-wrapper img {
  border-color: rgba(204,197,147,0.5) !important;
}

/* --- ACCOUNT: Field labels --- */
body.page-id-73404 .um .um-field-label label,
body.page-id-73404 .um label {
  color: rgba(255,255,255,0.45) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 10px !important;
  letter-spacing: 0.09em !important;
  text-transform: uppercase !important;
}

/* --- ACCOUNT: Section heading ("Account" title with icon) --- */
body.page-id-73404 .um-account-heading,
body.page-id-73404 .um-account-heading * {
  color: #CCC593 !important;
  font-family: 'Cormorant Garamond', 'Georgia', serif !important;
  border-bottom-color: rgba(204,197,147,0.15) !important;
}

/* --- ACCOUNT: Profile name + "View profile" link --- */
body.page-id-73404 .um-account-name a,
body.page-id-73404 .um-account-name span {
  color: #CCC593 !important;
  font-family: 'Cormorant Garamond', 'Georgia', serif !important;
}
body.page-id-73404 .um-account-profile-link a {
  color: rgba(204,197,147,0.5) !important;
  font-size: 12px !important;
}

/* --- ACCOUNT: Submit / Update button --- */
body.page-id-73404 .um .um-button,
body.page-id-73404 .um input[type="submit"],
body.page-id-73404 .um button[type="submit"] {
  background: #CCC593 !important;
  color: #0c0c0c !important;
  border: none !important;
  font-family: 'Inter', sans-serif !important;
  font-weight: 600 !important;
  letter-spacing: 0.06em !important;
  text-transform: uppercase !important;
  font-size: 12px !important;
}
body.page-id-73404 .um .um-button:hover,
body.page-id-73404 .um input[type="submit"]:hover {
  background: #fff !important;
}

/* --- ACCOUNT: Desktop side nav (.um-account-side) — the real nav boxes --- */
body.page-id-73404 .um-account-side li {
  background: rgba(255,255,255,0.03) !important;
  border-bottom: 1px solid rgba(204,197,147,0.08) !important;
}
body.page-id-73404 .um .um-account-link {
  color: rgba(255,255,255,0.65) !important;
}
body.page-id-73404 .um .um-account-link.current,
body.page-id-73404 .um .um-account-link:hover {
  color: #CCC593 !important;
  background: rgba(204,197,147,0.04) !important;
}
/* Icon (blue rgb(59,161,218) → gold) */
body.page-id-73404 .um .um-account-icon,
body.page-id-73404 .um .um-account-icon i,
body.page-id-73404 .um .um-account-icontip i {
  color: rgba(204,197,147,0.5) !important;
}
body.page-id-73404 .um .um-account-link.current .um-account-icon,
body.page-id-73404 .um .um-account-link.current .um-account-icon i,
body.page-id-73404 .um .um-account-link:hover .um-account-icon i {
  color: #CCC593 !important;
}
/* Title and arrow */
body.page-id-73404 .um .um-account-title {
  color: rgba(255,255,255,0.65) !important;
  font-family: 'Inter', sans-serif !important;
  font-size: 13px !important;
  letter-spacing: 0.03em !important;
}
body.page-id-73404 .um .um-account-link.current .um-account-title {
  color: #CCC593 !important;
}
body.page-id-73404 .um .um-account-arrow i {
  color: rgba(204,197,147,0.3) !important;
}

/* ===== PHASE 8 END ===== 2026-04-16 */

</style>


	<script id="rivegosh-gtranslate-override" data-no-optimize="1">
	(function() {
		function applyStyles() {
			var panel = document.querySelector(".gt_white_content");
			if (!panel) { setTimeout(applyStyles, 150); return; }
			var hasAdminBar = document.body.classList.contains("admin-bar");
			var topVal = hasAdminBar ? "80px" : "48px";
			panel.style.setProperty("position","fixed","important");
			panel.style.setProperty("top",topVal,"important");
			panel.style.setProperty("right","20px","important");
			panel.style.setProperty("left","auto","important");
			panel.style.setProperty("width","max-content","important");
			panel.style.setProperty("min-width","0","important");
			panel.style.setProperty("max-width","none","important");
			panel.style.setProperty("background","rgba(8,8,8,0.25)","important");
			panel.style.setProperty("backdrop-filter","blur(28px) saturate(180%)","important");
			panel.style.setProperty("-webkit-backdrop-filter","blur(28px) saturate(180%)","important");
			panel.style.setProperty("border","1px solid rgba(204,197,147,0.30)","important");
			panel.style.setProperty("border-radius","2px","important");
			panel.style.setProperty("padding","4px 0","important");
			panel.style.setProperty("box-shadow","none","important");
			panel.style.setProperty("z-index","9999","important");
			panel.style.setProperty("zoom","1","important");
			panel.querySelectorAll("br").forEach(function(el){ el.style.setProperty("display","none","important"); });
			var inner = panel.firstElementChild;
			if (inner) {
				inner.style.setProperty("font-size","0","important");
				inner.style.setProperty("line-height","0","important");
				inner.style.setProperty("padding","0","important");
				inner.style.setProperty("margin","0","important");
			}
			panel.querySelectorAll("a").forEach(function(el) {
				var isAr = el.getAttribute("data-gt-lang") === "ar";
				el.style.setProperty("font-family","Inter, sans-serif","important");
				el.style.setProperty("font-size", isAr ? "18px" : "12px","important");
				el.style.setProperty("line-height","1.25","important");
				el.style.setProperty("letter-spacing", isAr ? "0" : "0.06em","important");
				el.style.setProperty("text-transform", isAr ? "none" : "uppercase","important");
				el.style.setProperty("color","rgba(204,197,147,0.85)","important");
				el.style.setProperty("padding","10px 14px","important");
				el.style.setProperty("display","block","important");
				el.style.setProperty("background","transparent","important");
				el.style.setProperty("margin","0","important");
				el.style.setProperty("white-space","nowrap","important");
				el.style.setProperty("zoom","1","important");
			});
		}
		applyStyles();
		setTimeout(applyStyles, 300);
		setTimeout(applyStyles, 800);
		new MutationObserver(function(){ if (document.querySelector(".gt_white_content")) applyStyles(); }).observe(document.body, {childList:true, subtree:true});
		document.addEventListener("click", function(e) {
			var panel = document.querySelector(".gt_white_content");
			if (!panel) return;
			var trigger = document.querySelector("li.menu-item-gtranslate");
			if (!trigger) return;
			if (!trigger.contains(e.target) && !panel.contains(e.target)) {
				panel.style.setProperty("display","none","important");
			}
		});
	})();
	</script>
	<script id="rivegosh-cards-fix" data-no-optimize="1">
	(function() {
		var GOLD = "rgb(204,197,147)";
		var WHITE = "rgb(255,255,255)";
		var IDS = ["61861-h30","61861-h31","61861-h32"];
		function applyHover(btn, on) {
			btn.querySelectorAll("span, svg path").forEach(function(el) {
				el.style.setProperty("color", on ? WHITE : GOLD, "important");
				el.style.setProperty("fill",  on ? WHITE : GOLD, "important");
			});
			btn.style.setProperty("background", on ? "rgba(255,255,255,0.12)" : "rgba(0,0,0,0.35)", "important");
			btn.style.setProperty("border-color", on ? "rgba(255,255,255,0.5)" : "rgba(204,197,147,0.4)", "important");
		}
		function wireCards() {
			IDS.forEach(function(id) {
				var btn = document.querySelector('[data-colibri-id="' + id + '"');
				if (!btn) return;
				btn.addEventListener("mouseenter", function() { applyHover(btn, true); });
				btn.addEventListener("mouseleave", function() { applyHover(btn, false); });
			});
		}
		if (document.readyState === "loading") {
			document.addEventListener("DOMContentLoaded", wireCards);
		} else {
			wireCards();
		}
	})();
	</script>
	<script id="rivegosh-logo-inject" data-no-optimize="1">
	(function() {
		var LOGO_SRC = "https://rivegosh-concierge.com/wp-content/uploads/2026/04/logo-header-light.png";
		function injectLogo() {
			// Only run on inner pages (61866 header), not homepage (61861)
			var h5 = document.querySelector("[data-colibri-id=\"61866-h5\"]");
			if (!h5) return;
			// Already has logo image? skip
			if (h5.querySelector("img.h-logo__image")) return;
			var anchor = h5.querySelector("a");
			if (!anchor) return;
			// Remove any empty text span
			var emptySpan = anchor.querySelector(".h-logo__text");
			if (emptySpan) emptySpan.remove();
			// Inject main logo image
			var img = document.createElement("img");
			img.src = LOGO_SRC;
			img.className = "h-logo__image h-logo__image_h logo-image style-608-image style-local-61866-h5-image";
			img.alt = "Rive Gosh Concierge";
			img.style.setProperty("max-height", "49px", "important");
			img.style.setProperty("width", "auto", "important");
			anchor.insertBefore(img, anchor.firstChild);
		}
		if (document.readyState === "loading") {
			document.addEventListener("DOMContentLoaded", injectLogo);
		} else {
			injectLogo();
		}
	})();
	</script>
	<script id="rivegosh-banner-nuke" data-no-optimize="1">(function(){function nuke(){var b=document.querySelector('.cmplz-cookiebanner');if(!b)return;['cmplz-header','cmplz-title','cmplz-close','cmplz-logo','cmplz-divider','cmplz-footer','cmplz-information','cmplz-links','cmplz-documents','cmplz-categories'].forEach(function(c){b.querySelectorAll('.'+c).forEach(function(el){el.style.setProperty('display','none','important')})});b.querySelectorAll('a.cmplz-link, .cmplz-manage-options, [class*="manage-options"], [class*="view-preferences"]').forEach(function(el){el.style.setProperty('display','none','important')})}
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', nuke); else nuke();
document.addEventListener('cmplz_cookie_banner_data', nuke);
setTimeout(nuke, 500); setTimeout(nuke, 1500);
})();
	</script>
	<?php
}

// ===== RG DRAWER v43 START =====
// Custom mobile drawer — replaces Colibri offcanvas on <=991px screens.
// Safe: additive, mobile-only. Rollback = delete this block.
add_action('wp_footer', 'rivegosh_custom_drawer_v43', 99998);
function rivegosh_custom_drawer_v43() {
    // Pull menu items dynamically (fallback to hardcoded URLs if menu lookup fails)
    $vip_kids = [];
    $pro_link = null;
    $aff_link = null;
    $menus = wp_get_nav_menus();
    if ($menus) {
        foreach ($menus as $menu) {
            $items = wp_get_nav_menu_items($menu->term_id);
            if (!$items) continue;
            $has = false;
            foreach ($items as $it) { if ((int)$it->ID === 63536) { $has = true; break; } }
            if (!$has) continue;
            foreach ($items as $it) {
                if ((int)$it->menu_item_parent === 63536) {
                    $vip_kids[] = ['title' => $it->title, 'url' => $it->url];
                }
                if ((int)$it->ID === 64806) $pro_link = ['title' => $it->title, 'url' => $it->url];
                if ((int)$it->ID === 73499) $aff_link = ['title' => $it->title, 'url' => $it->url];
            }
            break;
        }
    }
    // PHASE 5: Determine login state for conditional nav
    $rg_logged_in = is_user_logged_in();

    if (empty($vip_kids)) {
        $vip_kids = [
            ['title' => 'Home',         'url' => '/',             'vis' => 'all'],
            ['title' => 'Login',        'url' => '/login-2/',     'vis' => 'guest'],
            ['title' => 'Register',     'url' => '/register/',    'vis' => 'guest'],
            ['title' => 'Account',      'url' => '/account/',     'vis' => 'member'],
            ['title' => 'Reservations', 'url' => '/booking-vip/', 'vis' => 'member'],
            ['title' => 'Invoices',     'url' => '/my-orders/orders/', 'vis' => 'member'],
            ['title' => 'Members',      'url' => '/members/',     'vis' => 'member'],
            ['title' => 'FAQ',          'url' => '/faq-2/',       'vis' => 'all'],
        ];
    }
    if (!$pro_link) $pro_link = ['title' => 'Professional',        'url' => '/vendor-membership/'];
    if (!$aff_link) $aff_link = ['title' => 'Affiliate Dashboard', 'url' => '/affiliate-dashboard/'];
    ?>
    <style id="rg-drawer-css">
    @media (max-width: 991px) {
      /* Hide Colibri's native drawer entirely — we replace it */
      #colibri .h-offcanvas-panel,
      .h-offcanvas-panel { display: none !important; }
      /* Backdrop */
      #rg-drawer-backdrop {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.55);
        opacity: 0; pointer-events: none;
        transition: opacity 0.25s ease;
        z-index: 99998;
      }
      #rg-drawer-backdrop.rg-open { opacity: 1; pointer-events: auto; }
      /* Drawer panel */
      #rg-drawer {
        position: fixed; top: 0; right: 0;
        width: 85vw; max-width: 360px; height: 100vh;
        background: #0a0a0a;
        padding: 40px 0 40px 0;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        z-index: 99999;
        overflow-y: auto; overflow-x: hidden;
        box-sizing: border-box;
        box-shadow: -8px 0 24px rgba(0,0,0,0.4);
      }
      #rg-drawer.rg-open { transform: translateX(0); }
      #rg-drawer-close {
        position: absolute; top: 8px; right: 8px;
        background: transparent; border: 0; cursor: pointer;
        color: #fff; font-size: 28px; line-height: 1;
        width: 36px; height: 36px; padding: 0;
        font-family: 'Inter', sans-serif; font-weight: 300;
      }
      #rg-drawer-close:hover { color: #CCC593; }
      .rg-nav { display: block; padding: 0 24px; }
      .rg-nav a,
      .rg-nav a:link,
      .rg-nav a:visited {
        display: block !important;
        width: 100% !important;
        padding: 7px 0 !important;
        text-align: center !important;
        color: #FFFFFF !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        text-decoration: none !important;
        border: 0 !important;
        background: transparent !important;
        transition: color 0.2s ease !important;
      }
      .rg-nav a:hover,
      .rg-nav a:focus,
      .rg-nav a:active { color: #CCC593 !important; outline: none; }
      .rg-divider {
        height: 1px; background: rgba(255,255,255,0.15);
        margin: 14px 16px 6px 16px;
      }
      .rg-nav a.rg-secondary { padding: 5px 0 !important; font-size: 13px !important; }
      .rg-footer-text {
        margin-top: 24px; padding: 16px 0 0 0;
        border-top: 1px solid rgba(255,255,255,0.08);
        text-align: center;
        color: rgba(255,255,255,0.35);
        font-family: 'Inter', sans-serif;
        font-size: 11px; letter-spacing: 0.08em;
      }
      /* Hide GTranslate while our drawer is open */
      body.rg-drawer-open .gt_white_content,
      body.rg-drawer-open .gt_switcher_wrapper,
      body.rg-drawer-open .gt_float_switcher,
      body.rg-drawer-open [class*="gt_switcher"] {
        display: none !important;
        opacity: 0 !important;
        pointer-events: none !important;
      }
      /* Lock body scroll when drawer open */
      body.rg-drawer-open { overflow: hidden !important; }
    }
    </style>
    <div id="rg-drawer-backdrop"></div>
    <aside id="rg-drawer" aria-hidden="true" role="dialog" aria-label="Main menu">
      <button id="rg-drawer-close" type="button" aria-label="Close menu">&times;</button>
      <nav class="rg-nav">
        <?php foreach ($vip_kids as $k):
          // Phase 5: visibility gating
          $vis = isset($k['vis']) ? $k['vis'] : 'all';
          if ($vis === 'guest'  && $rg_logged_in)  continue;
          if ($vis === 'member' && !$rg_logged_in) continue;
          // For dynamic menu items (no vis key): gate by URL pattern
          if (!isset($k['vis'])) {
            $u = $k['url'];
            $is_auth  = (strpos($u,'/login')!==false || strpos($u,'/register')!==false);
            $is_mbr   = (strpos($u,'/account')!==false || strpos($u,'/my-orders')!==false || strpos($u,'/members')!==false || strpos($u,'/booking-vip')!==false);
            if ($is_auth && $rg_logged_in)  continue;
            if ($is_mbr  && !$rg_logged_in) continue;
          }
        ?>
          <a href="<?php echo esc_url($k['url']); ?>"><?php echo esc_html($k['title']); ?></a>
        <?php endforeach; ?>
        <div class="rg-divider"></div>
        <a class="rg-secondary" href="<?php echo esc_url($pro_link['url']); ?>"><?php echo esc_html($pro_link['title']); ?></a>
        <a class="rg-secondary" href="<?php echo esc_url($aff_link['url']); ?>"><?php echo esc_html($aff_link['title']); ?></a>
        <div class="rg-footer-text">RIVE GOSH CONCIERGE<br>&copy; 2026</div>
      </nav>
    </aside>
    <script id="rg-drawer-js">
    (function(){
      var drawer = document.getElementById('rg-drawer');
      var backdrop = document.getElementById('rg-drawer-backdrop');
      var closeBtn = document.getElementById('rg-drawer-close');
      if (!drawer || !backdrop) return;
      function openDrawer(){
        drawer.classList.add('rg-open');
        backdrop.classList.add('rg-open');
        document.body.classList.add('rg-drawer-open');
        drawer.setAttribute('aria-hidden','false');
      }
      function closeDrawer(){
        drawer.classList.remove('rg-open');
        backdrop.classList.remove('rg-open');
        document.body.classList.remove('rg-drawer-open');
        drawer.setAttribute('aria-hidden','true');
      }
      // Hijack hamburger buttons (capture phase so Colibri's handler doesn't run)
      document.addEventListener('click', function(e){
        // Only on mobile
        if (window.innerWidth > 991) return;
        var burger = e.target && e.target.closest && e.target.closest('.h-hamburger-button, .h-navbar-toggler, [data-colibri-component="offcanvas-button"], .navbar-toggler');
        if (burger) {
          e.preventDefault();
          e.stopImmediatePropagation();
          openDrawer();
        }
      }, true);
      closeBtn.addEventListener('click', closeDrawer);
      backdrop.addEventListener('click', closeDrawer);
      document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeDrawer(); });
      // Belt-and-braces: force Colibri's panel to stay hidden
      setInterval(function(){
        var colPanel = document.querySelector('.h-offcanvas-panel');
        if (colPanel) colPanel.style.display = 'none';
      }, 750);
    })();
    </script>
    <?php
}
// ===== RG DRAWER v43 END =====

// ===== HERO GRAPHICS v3 — Sequential two-word cycling =====
add_action( 'wp_footer', 'rivegosh_cycling_hero_js', 99999 );
function rivegosh_cycling_hero_js() { ?>
<script id="rg-cycling-js">
(function(){
  var pairs=[
    ['PREMIUM','TRANSFERS'],
    ['PREMIUM','CHAUFFEUR'],
    ['PREMIUM','EXPERIENCES'],
    ['PREMIUM','CONCIERGE'],
    ['PREMIUM','ARRIVALS']
  ];
  var idx=0,lines=[];
  function build(){
    var wrap=document.createElement('div');
    wrap.className='rg-cycling-wrap';
    pairs.forEach(function(p,i){
      var line=document.createElement('div');
      line.className='rg-cycling-line'+(i===0?' rg-visible':'');
      var w1=document.createElement('span');
      w1.className='rg-word-1';
      w1.textContent=p[0];
      var w2=document.createElement('span');
      w2.className='rg-word-2';
      w2.textContent=p[1];
      line.appendChild(w1);
      line.appendChild(w2);
      wrap.appendChild(line);
    });
    return wrap;
  }
  function inject(){
    var anchor=document.querySelector('[data-colibri-id="61861-h29"]');
    if(!anchor||document.querySelector('.rg-cycling-wrap'))return;
    anchor.parentNode.insertBefore(build(),anchor);
    lines=Array.from(document.querySelectorAll('.rg-cycling-line'));
    setInterval(function(){
      lines[idx].classList.remove('rg-visible');
      lines[idx].classList.add('rg-exit');
      idx=(idx+1)%lines.length;
      lines[idx].classList.remove('rg-exit');
      lines[idx].classList.add('rg-visible');
      setTimeout(function(){
        lines.forEach(function(l){l.classList.remove('rg-exit');});
      },400);
    },2800);
  }
  if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',inject);}
  else{inject();}
})();
</script>
<?php }
// ===== HERO GRAPHICS v3 END =====

// ===== PHASE 3: WOOCOMMERCE MY ACCOUNT — REMOVE IRRELEVANT TABS =====
// 'followings' = social plugin; 'support-tickets' = helpdesk plugin; 'inquiry' = extra plugin.
// All unrelated to Rive Gosh. 'wpf-delete-account' = risky — remove from nav, keep endpoint.
add_filter('woocommerce_account_menu_items', 'rivegosh_account_menu_items');
function rivegosh_account_menu_items($items) {
  unset(
    $items['followings'],
    $items['support-tickets'],
    $items['inquiry'],
    $items['wpf-delete-account']
  );
  return $items;
}
// ===== PHASE 3 END =====

// ===== PHASE 4: CONTEXTUAL HERO TEXT PER PAGE =====
// Inner page hero always says "YOUR DESTINATION" — meaningless on auth pages.
// Replace via JS based on body page-id class. Falls back silently if heading not found.
add_action('wp_footer', 'rivegosh_contextual_hero_text', 99999);
function rivegosh_contextual_hero_text() {
  $map = [
    73400 => "WELCOME BACK",
    73401 => "JOIN THE\nPRIVATE CIRCLE",
    73404 => "YOUR\nPRIVATE SPACE",
    16    => "YOUR\nPRIVATE SPACE",
    54773 => "YOUR EXCLUSIVE\nITINERARY",
    73402 => "YOUR\nMEMBER SPACE",
    61943 => "FREQUENTLY ASKED\nQUESTIONS",
  ];
  $id  = get_the_ID();
  if (!isset($map[$id])) return;
  // Use <br> for line breaks — textContent ignores \n, innerHTML renders <br>
  $html = nl2br( esc_html($map[$id]) );
  ?>
  <script id="rg-hero-text">
  (function(){
    var newHtml = <?php echo json_encode($html); ?>;
    function swap(){
      var heroes = document.querySelectorAll('.h-section.h-hero h1, .h-section.h-hero h2, .h-section.h-hero h3, .h-section.h-hero h4, .h-section.h-hero h5, .h-section.h-hero .h-heading, .h-section.h-hero [class*="h-heading"]');
      heroes.forEach(function(el){
        var t = el.textContent.trim().toUpperCase();
        if(t.includes('DESTINATION') || t.includes('YOUR ')){
          el.innerHTML = newHtml;
        }
      });
    }
    if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded',swap); }
    else { swap(); }
  })();
  </script>
  <?php
  // On FAQ page: hide the content-area "Frequently asked questions" heading — it moved to hero
  if ($id === 61943): ?>
  <script id="rg-faq-hide-heading">
  (function(){
    function hideContentHeading(){
      var allH = document.querySelectorAll('.h-section:not(.h-hero):not(.h-navigation) h1, .h-section:not(.h-hero):not(.h-navigation) h2, .h-section:not(.h-hero):not(.h-navigation) h3');
      allH.forEach(function(el){
        var t = el.textContent.trim().toUpperCase();
        if(t.includes('FREQUENTLY') || t.includes('ASKED') || t.includes('QUESTIONS')){
          el.style.setProperty('display','none','important');
          // Also hide the parent widget wrapper so gap doesn't remain
          var p = el.closest('[class*="style-local"]') || el.parentElement;
          if(p && p !== document.body){ p.style.setProperty('display','none','important'); }
        }
      });
    }
    if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded',hideContentHeading); }
    else { hideContentHeading(); }
  })();
  </script>
  <?php endif; ?>
  <?php
}
// ===== PHASE 4 END =====

// ===== REGISTER PAGE: REDIRECT LOGGED-IN USERS =====
// When a logged-in user hits /register/, send them straight to My Account.
// Prevents the dead "You are already registered." screen.
add_action('template_redirect', 'rivegosh_register_logged_in_redirect');
function rivegosh_register_logged_in_redirect() {
  if ( is_user_logged_in() && is_page('register') ) {
    wp_safe_redirect( home_url('/my-orders/') );
    exit;
  }
}
// ===== REGISTER PAGE REDIRECT END =====

// ===== AMELIA SSO: auto-link new UM registrations to Amelia customer records =====
// GitHub: growthpigs/lifemodo#554
// When a user registers via UM, we:
// 1. Assign the wpamelia-customer WP role (so Amelia recognizes them)
// 2. Create an amelia_users record with externalId = WP user ID
// This enables Amelia's native WP SSO — no second login form ever shown.
add_action('um_registration_complete', 'rivegosh_amelia_sso_link', 5, 2);
function rivegosh_amelia_sso_link($user_id, $args) {
  // 1. Assign WP role
  $user = new WP_User($user_id);
  $user->add_role('wpamelia-customer');

  // 2. Create Amelia customer record linked to this WP user
  global $wpdb;
  $table = $wpdb->prefix . 'amelia_users';
  // Only create if no record exists yet (prevent duplicates)
  $exists = $wpdb->get_var($wpdb->prepare(
    "SELECT id FROM {$table} WHERE externalId = %d AND type = 'customer'", $user_id
  ));
  if (!$exists) {
    $wp_user = get_userdata($user_id);
    $wpdb->insert($table, [
      'status'     => 'visible',
      'type'       => 'customer',
      'externalId' => $user_id,
      'firstName'  => $wp_user->first_name ?: $wp_user->display_name,
      'lastName'   => $wp_user->last_name ?: '',
      'email'      => $wp_user->user_email,
    ]);
  }
}
// ===== AMELIA SSO END =====

// ===== UM POST-LOGIN + POST-REGISTRATION REDIRECTS =====
// After login → My Orders portal. After registration → Account page.
add_filter('um_login_redirect_url', 'rivegosh_um_login_redirect', 10, 3);
function rivegosh_um_login_redirect($url, $user_id, $redirect_to) {
  return home_url('/my-orders/');
}

add_action('um_registration_complete', 'rivegosh_um_after_register', 10, 2);
function rivegosh_um_after_register($user_id, $args) {
  wp_safe_redirect( home_url('/account/') );
  exit;
}
// ===== UM REDIRECTS END =====

// ===== UM PROFILE PAGE: REDIRECT AWAY =====
// /user/username/ is UM's public profile — not needed for a concierge service.
add_action('template_redirect', 'rivegosh_um_profile_redirect', 5);
function rivegosh_um_profile_redirect() {
  if ( !function_exists('um_is_core_page') ) return;
  if ( um_is_core_page('user') ) {
    if ( is_user_logged_in() ) {
      wp_safe_redirect( home_url('/my-orders/') );
    } else {
      wp_safe_redirect( home_url('/login-2/') );
    }
    exit;
  }
}
// ===== UM PROFILE PAGE REDIRECT END =====

// ===== /my-account/ → /my-orders/ 301 REDIRECT =====
// Slug changed from my-account to my-orders. Redirect old bookmarks/WC internal links.
add_action('template_redirect', 'rivegosh_myaccount_slug_redirect', 1);
function rivegosh_myaccount_slug_redirect() {
  $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
  // Only redirect paths that literally start with /my-account (not /my-orders which is now canonical)
  if ( preg_match('#^/my-account(/|$)#', $uri) ) {
    $new = preg_replace('#^/my-account#', '/my-orders', $uri);
    wp_redirect( home_url($new), 301 );
    exit;
  }
}
// ===== /my-account/ REDIRECT END =====

// ===== PORTAL PAGES: REDIRECT LOGGED-OUT USERS TO MY ORDERS LOGIN PAGE =====
// Account (73404), Members (73402), Your Booking (54773) have no guest content.
// All redirect → /my-orders/ (page 16) which shows Login (left) + Create Account (right).
add_action('template_redirect', 'rivegosh_portal_guest_redirect');
function rivegosh_portal_guest_redirect() {
  if ( is_user_logged_in() ) return;
  $id = get_the_ID();
  if ( in_array( $id, [73404, 73402, 54773] ) ) {
    wp_safe_redirect( home_url('/my-orders/') );
    exit;
  }
}
// ===== PORTAL GUEST REDIRECT END =====

// ===== WC MY ACCOUNT: REPLACE REGISTER FORM WITH UM REDIRECT PANEL =====
// WC's register form (email+password only) conflicts with UM's full register form.
// On /my-account/ we hide the WC form (CSS above) and inject a styled panel → /register/.
// Both WC login + register forms replaced with clean redirect panels → /login-2/ and /register/
add_action('wp_footer', 'rivegosh_wc_register_replace', 99999);
function rivegosh_wc_register_replace() {
  if ( !is_page(16) || is_user_logged_in() ) return;
  ?>
  <style id="rg-register-panel-css">
  .rg-auth-panel {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    padding: 32px 0;
  }
  .rg-auth-panel h2.rg-panel-title {
    color: #CCC593 !important;
    font-family: 'Cormorant Garamond', 'Georgia', serif !important;
    font-size: 24px !important;
    letter-spacing: 0.04em !important;
    margin-bottom: 16px !important;
  }
  .rg-auth-panel p {
    color: rgba(255,255,255,0.65) !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 13px !important;
    line-height: 1.7 !important;
    margin-bottom: 28px !important;
  }
  .rg-auth-panel a.rg-panel-btn {
    display: inline-block;
    background: #CCC593 !important;
    color: #0c0c0c !important;
    font-family: 'Inter', sans-serif !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    letter-spacing: 0.12em !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    padding: 14px 32px !important;
    border-radius: 1px;
    transition: background 0.2s;
    align-self: flex-start;
  }
  .rg-auth-panel a.rg-panel-btn:hover { background: #fff !important; }
  .rg-auth-panel .rg-panel-note {
    margin-top: 16px !important;
    font-size: 11px !important;
    color: rgba(255,255,255,0.3) !important;
  }
  </style>
  <script id="rg-register-panel-js">
  (function(){
    function injectPanels(){
      var wrap = document.querySelector('#customer_login');
      if (!wrap) return;

      // Hide all WC forms inside
      wrap.querySelectorAll('form').forEach(function(f){ f.style.setProperty('display','none','important'); });
      // Also hide WC headings
      wrap.querySelectorAll('h2').forEach(function(h){ h.style.setProperty('display','none','important'); });

      // Left column: Log In panel
      var col1 = wrap.querySelector('.u-column1');
      if (col1) {
        var loginPanel = document.createElement('div');
        loginPanel.className = 'rg-auth-panel';
        loginPanel.innerHTML = [
          '<h2 class="rg-panel-title">Log In</h2>',
          '<p>Access your VIP Customer portal — bookings, membership, exclusive services.</p>',
          '<a href="/login-2/" class="rg-panel-btn">Log In</a>',
          '<span class="rg-panel-note">Existing members only</span>'
        ].join('');
        col1.appendChild(loginPanel);
      }

      // Right column: Create Account panel
      var col2 = wrap.querySelector('.u-column2');
      if (col2) {
        var registerPanel = document.createElement('div');
        registerPanel.className = 'rg-auth-panel';
        registerPanel.innerHTML = [
          '<h2 class="rg-panel-title">Create Account</h2>',
          '<p>Join the Rive Gosh private circle. Full VIP profile — takes under a minute.</p>',
          '<a href="/register/" class="rg-panel-btn">Create Account</a>',
          '<span class="rg-panel-note">Username &middot; Name &middot; Email &middot; Password</span>'
        ].join('');
        col2.appendChild(registerPanel);
      }
    }
    if(document.readyState==='loading'){ document.addEventListener('DOMContentLoaded',injectPanels); }
    else { injectPanels(); }
  })();
  </script>
  <?php
}
// ===== WC REGISTER REPLACE END =====

// ===== TOP NAV: FIX VIP CUSTOMER LINK FOR LOGGED-OUT USERS =====
// Colibri sets "VIP CUSTOMER" header link → /register/ — confusing for guests.
// For logged-out users, intercept and point it to /login-2/ (UM portal login page).
add_action('wp_footer', 'rivegosh_fix_nav_for_guests', 99999);
function rivegosh_fix_nav_for_guests() {
  if ( is_user_logged_in() ) return;
  ?>
  <script id="rg-nav-guest-fix">
  (function(){
    // Change all /register/ links in the Colibri top nav → /login-2/
    // Sidebar REGISTER link is inside #rg-portal-sidebar, not .h-navigation — so it stays.
    var navLinks = document.querySelectorAll('.h-navigation a[href*="/register/"]');
    navLinks.forEach(function(a){ a.href = '/login-2/'; });
    // Also fix the Colibri offcanvas/drawer nav links
    var offLinks = document.querySelectorAll('.h-offcanvas-panel a[href*="/register/"]');
    offLinks.forEach(function(a){ a.href = '/login-2/'; });
  })();
  </script>
  <?php
}
// ===== TOP NAV FIX END =====

// ===== FOOTER BAR: custom fixed footer, replaces hidden Colibri footer =====
add_action('wp_footer', 'rivegosh_footer_bar', 99999);
function rivegosh_footer_bar() {
  $terms_url = home_url('/terms-et-conditions-generales-privacy-policy-cookies-eu-us/');
  ?>
  <div id="rg-footer-bar">
    <a href="<?php echo esc_url($terms_url); ?>">Terms &amp; Conditions, Privacy Policy, Cookies</a>
    <span class="rg-fb-sep">|</span>
    <span>&copy; Rive Gosh 2026</span>
  </div>
  <?php
}
// ===== FOOTER BAR END =====

// ===== PORTAL SIDEBAR v2 — gutter-positioned VIP customer nav, desktop only =====
// ⚠️  CURRENT WORK — DO NOT MODIFY — Last updated: 2026-04-16 by CC session (Chi/Sonnet)
// Feature: Fixed left-gutter sidebar on all 6 portal pages. All 7 items always visible.
// GitHub issue: rivegosh/concierge-rivegosh#56 (CLOSED — implemented)
// -----------------------------------------------------------------------
// All 7 items always visible (design continuity with header dropdown — no guest/member filter).
// Sidebar floats in the NATURAL GUTTER to the left of the centered form content.
// NO content push — content stays centered, sidebar sits beside it.
// Top offset = nav bar height + hero section height (not just nav bar).
// Suppressed on WooCommerce My Account pages (Phase 3 WC sidebar handles those).
// Registered LAST at 99999 — CSS loads after all other 99999-priority styles (KB#49 §20).
add_action('wp_footer', 'rivegosh_portal_sidebar_v2', 99999);
function rivegosh_portal_sidebar_v2() {
  $portal_ids = [73400, 73401, 73404, 73402, 54773, 61943, 16];
  $current_id = get_the_ID();
  if (!in_array($current_id, $portal_ids)) return;

  // Visibility-gated nav: guests see auth links, members see portal links
  $rg_logged_in = is_user_logged_in();
  $nav = [
    ['label' => 'HOME',         'url' => '/',             'id' => 0,     'vis' => 'all'],
    ['label' => 'LOGIN',        'url' => '/login-2/',     'id' => 73400, 'vis' => 'guest'],
    ['label' => 'REGISTER',     'url' => '/register/',    'id' => 73401, 'vis' => 'guest'],
    ['sep' => true,                                                        'vis' => 'member'],
    ['label' => 'ACCOUNT',       'url' => '/account/',     'id' => 73404, 'vis' => 'member'],
    ['label' => 'RESERVATIONS',  'url' => '/booking-vip/', 'id' => 54773, 'vis' => 'member'],
    ['label' => 'INVOICES',      'url' => '/my-orders/orders/', 'id' => 16,    'vis' => 'member'],
    ['label' => 'MEMBERS',       'url' => '/members/',     'id' => 73402, 'vis' => 'member'],
    ['label' => 'FAQ',          'url' => '/faq-2/',       'id' => 61943, 'vis' => 'all'],
    ['sep' => true,                                                        'vis' => 'member'],
    ['label' => 'LOG OUT',      'url' => wp_logout_url( home_url('/') ),   'id' => 0,     'vis' => 'member', 'logout' => true],
  ];
  ?>
  <style id="rg-portal-sidebar-css">
  /* ============================================================
     PORTAL SIDEBAR v2 — gutter-positioned, desktop only (>=992px)
     No content push — sidebar floats in the natural gutter.
     JS measures content left edge and positions sidebar there.
     ============================================================ */
  #rg-portal-sidebar {
    position: fixed;
    left: 44px; /* JS overrides: aligns with logo left edge */
    top: 0;     /* JS sets from header offsetHeight */
    width: 140px;
    height: 100vh; /* JS corrects to 100vh minus header */
    background: transparent; /* floats on dark page bg — no box */
    z-index: 1000; /* above content, below GTranslate(9999), below drawer(99998) — KB#49 §21 */
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: none;
    -ms-overflow-style: none;
    display: flex;
    flex-direction: column;
    padding-top: 28px;
  }
  #rg-portal-sidebar::-webkit-scrollbar { display: none; }

  /* "VIP CUSTOMER" section label — bold, same size as nav links */
  #rg-portal-sidebar .rg-ps-label {
    color: rgba(204,197,147,0.85);
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0 0 12px 2px;
    display: block;
  }
  /* Single divider under label — no other lines */
  #rg-portal-sidebar .rg-ps-divider {
    height: 1px;
    background: rgba(204,197,147,0.25);
    margin: 0 0 14px 0;
    flex-shrink: 0;
  }
  /* Separator between guest and member sections */
  #rg-portal-sidebar .rg-ps-sep {
    height: 1px;
    background: rgba(204,197,147,0.12);
    margin: 6px 0 6px 2px;
    flex-shrink: 0;
  }

  /* Nav links */
  #rg-portal-sidebar a {
    display: block;
    padding: 10px 8px 10px 2px;
    color: rgba(204,197,147,0.6);
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    text-decoration: none !important;
    white-space: nowrap !important;
    transition: color 0.18s, border-color 0.18s;
    border-left: 2px solid transparent;
    line-height: 1.3;
  }
  #rg-portal-sidebar a:hover {
    color: #CCC593 !important;
    border-left-color: rgba(204,197,147,0.35) !important;
    padding-left: 6px !important;
  }
  #rg-portal-sidebar a.rg-ps-active {
    color: #CCC593 !important;
    border-left: 2px solid #CCC593 !important;
    padding-left: 6px !important;
  }
  #rg-portal-sidebar a.rg-ps-logout {
    color: rgba(255,255,255,0.3) !important;
    font-size: 11px !important;
    letter-spacing: 0.08em !important;
  }
  #rg-portal-sidebar a.rg-ps-logout:hover {
    color: rgba(255,80,80,0.7) !important;
    border-left-color: transparent !important;
  }

  /* Mobile: hide completely — no layout impact */
  @media (max-width: 991px) {
    #rg-portal-sidebar { display: none !important; }
  }

  /* ---- WooCommerce My Account — "VIP CUSTOMER" portal label above WC sidebar (KB#49 §19) ---- */
  @media (min-width: 992px) {
    .woocommerce-account .woocommerce-MyAccount-navigation::before {
      content: 'VIP CUSTOMER';
      display: block;
      color: rgba(204,197,147,0.45);
      font-family: 'Inter', sans-serif;
      font-size: 9px;
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      padding: 20px 24px 0;
    }
    .woocommerce-account .woocommerce-MyAccount-navigation ul::before {
      content: '';
      display: block;
      height: 1px;
      background: rgba(204,197,147,0.25);
      margin: 12px 16px 8px;
    }
  }
  </style>

  <nav id="rg-portal-sidebar" aria-label="VIP Customer Portal" role="navigation">
    <span class="rg-ps-label">VIP CUSTOMER</span>
    <div class="rg-ps-divider"></div>
    <?php foreach ($nav as $item):
      $vis = isset($item['vis']) ? $item['vis'] : 'all';
      if ($vis === 'guest'  && $rg_logged_in)  continue;
      if ($vis === 'member' && !$rg_logged_in) continue;
      if (!empty($item['sep'])): ?>
        <div class="rg-ps-sep"></div>
    <?php continue; endif;
      $active = ($item['id'] === $current_id);
      $is_logout = !empty($item['logout']);
      $classes = $active ? 'rg-ps-active' : ( $is_logout ? 'rg-ps-logout' : '' );
    ?>
      <a href="<?php echo esc_url($is_logout ? $item['url'] : home_url($item['url'])); ?>"<?php echo $classes ? ' class="' . esc_attr($classes) . '"' : ''; ?>><?php echo esc_html($item['label']); ?></a>
    <?php endforeach; ?>
  </nav>

  <script id="rg-portal-sidebar-js">
  (function(){
    var sb = document.getElementById('rg-portal-sidebar');
    if (!sb) return;
    var SB_W = 140;

    function positionSidebar() {
      if (window.innerWidth < 992) { sb.style.display = 'none'; return; }
      sb.style.display = 'flex';

      // Top offset = nav bar + hero section (both sit above the form content area)
      var hdr  = document.querySelector('.h-section.h-navigation');
      var hero = document.querySelector('.h-section.h-hero');
      var hdrH  = hdr  ? hdr.offsetHeight  : 90;
      var heroH = hero ? hero.offsetHeight : 0;
      var adminH = document.body.classList.contains('admin-bar') ? 32 : 0;
      var topOffset = hdrH + heroH + adminH;
      sb.style.top = topOffset + 'px';
      sb.style.height = 'calc(100vh - ' + topOffset + 'px)';

      // Align sidebar left edge with the left edge of the Rive Gosh logo "R"
      var logoImg = document.querySelector('.h-section.h-navigation img');
      var leftPos = 44; // fallback
      if (logoImg) {
        leftPos = Math.round(logoImg.getBoundingClientRect().left);
      }
      sb.style.left = leftPos + 'px';
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', positionSidebar);
    } else {
      positionSidebar();
    }
    var _rt;
    window.addEventListener('resize', function(){ clearTimeout(_rt); _rt = setTimeout(positionSidebar, 80); });
  })();
  </script>
  <?php
}
// ===== PORTAL SIDEBAR v2 END ===== (2026-04-16 — DO NOT MODIFY without reading #56)

// ===== EYE ICON: password visibility toggle for UM + WC portal forms =====
add_action('wp_footer', 'rivegosh_password_eye_icon', 99999);
function rivegosh_password_eye_icon() {
  // Only run on portal pages
  $portal_ids = [73400, 73401, 73404, 16, 73402, 54773, 61943];
  if ( !is_page($portal_ids) ) return;
  ?>
  <script id="rg-pw-eye">
  (function(){
    var EYE_OPEN = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
    var EYE_SHUT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';

    function wrapField(input) {
      if (input.parentNode && input.parentNode.classList.contains('rg-pw-wrap')) return;
      var wrap = document.createElement('div');
      wrap.className = 'rg-pw-wrap';
      input.parentNode.insertBefore(wrap, input);
      wrap.appendChild(input);

      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'rg-pw-toggle';
      btn.setAttribute('aria-label', 'Toggle password visibility');
      btn.innerHTML = EYE_OPEN;
      wrap.appendChild(btn);

      btn.addEventListener('click', function(){
        var visible = input.type === 'text';
        input.type = visible ? 'password' : 'text';
        btn.innerHTML = visible ? EYE_OPEN : EYE_SHUT;
        btn.style.color = visible ? '' : '#CCC593';
      });
    }

    function init() {
      var fields = document.querySelectorAll('input[type="password"]');
      fields.forEach(wrapField);
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
    } else {
      init();
    }
    // Also catch dynamically injected forms (UM lazy-loads)
    setTimeout(init, 800);
  })();
  </script>
  <?php
}
// ===== EYE ICON END =====
