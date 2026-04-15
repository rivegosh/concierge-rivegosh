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
    if (empty($vip_kids)) {
        $vip_kids = [
            ['title' => 'Home',         'url' => '/'],
            ['title' => 'Login',        'url' => '/login-2/'],
            ['title' => 'Register',     'url' => '/register/'],
            ['title' => 'Account',      'url' => '/account/'],
            ['title' => 'My Orders',    'url' => '/my-account/'],
            ['title' => 'Members',      'url' => '/members/'],
            ['title' => 'Your Booking', 'url' => '/booking-vip/'],
            ['title' => 'FAQ',          'url' => '/faq-2/'],
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
        <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        <?php foreach ($vip_kids as $k): ?>
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

