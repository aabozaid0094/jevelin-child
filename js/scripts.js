jQuery(document).ready(function ($) {
	"use strict";

	/* Write your custom JS below */
	var single_title = $(".single .blog-single>article .post-title>*").text();
	$(
		".single .sh-titlebar .titlebar-title>*, .single .sh-titlebar .sh-element-titlebar-title>*"
	).text(single_title);

	$(".rtl.archive #content, .rtl.search #content")
		.addClass("content-with-sidebar-left")
		.removeClass("content-with-sidebar-right");
	$(".rtl.archive #sidebar, .rtl.search #sidebar")
		.addClass("sidebar-left")
		.removeClass("sidebar-right");
	$(".rtl .sh-page-switcher-button i").toggleClass(
		"ti-arrow-right ti-arrow-left"
	);

	var icon_url = "";
	var icon_element = "";
	$(".service-item-featured .service-icon").each(function () {
		icon_url = $(this).text();
		icon_element = '<img src="' + icon_url + '" alt="service-icon">';
		$(this).html(icon_element);
	});

	$(".sticky-buttons #sticky_toggler").on("click", function (event) {
		event.preventDefault();
		$(this).parent(".sticky-buttons").toggleClass("active");
		$(this)
			.siblings("a:not(.sticky_toggler)")
			.slideToggle(400, function () {
				if ($(this).is(":visible")) {
					$(this).css("display", "flex");
				}
			});
	});

	$(".sticky-buttons a[hidden-data-id]").click(function () {
		var identifying_class = $(this).attr("hidden-data-id");
		$(this)
			.siblings(
				".hidden-data.active:not([hidden-data-id=" +
					identifying_class +
					"])"
			)
			.removeClass("active");
		$(this)
			.siblings(".hidden-data[hidden-data-id=" + identifying_class + "]")
			.toggleClass("active");
	});

	if( $(document).width() < 1025 ) {
		let menuToggler = $('#main-header .sh-header-builder-mobile-menu');
		let menuTogglerIcon = $('#main-header .sh-header-builder-mobile-menu .c-hamburger');
		let menuLogoWrapper = $('#main-header .sh-header-builder-mobile .sh-header-builder-logo').clone();
		let menuDropdown = $('#main-header nav.sh-header-mobile-dropdown');
		menuLogoWrapper.prependTo(menuDropdown);
		$('<div><i class="fi-br-cross mobile-menu-close"></i></div>').appendTo(menuDropdown);
		let menuClose = $('#main-header nav.sh-header-mobile-dropdown .mobile-menu-close');
		let body = $(document.body);
		$('<div class="side-menu-overlay"></div>').insertAfter(menuDropdown);
		let sideMenuOverlay = $('#main-header .side-menu-overlay');
		menuToggler.on('click', function(e){
			if(menuTogglerIcon.hasClass('is-active'))
			{
				body.addClass('side-menu-active');
				menuDropdown.addClass('is-active');
			}
			else
			{
				body.removeClass('side-menu-active');
				menuDropdown.removeClass('is-active');
			}
		});
		sideMenuOverlay.add(menuClose).on('click', function(e){
			if(menuDropdown.hasClass('is-active')){
				body.removeClass('side-menu-active');
				menuDropdown.removeClass('is-active');
				menuTogglerIcon.removeClass('is-active');
			}
		});
	}

	$('.g-tracked, a[href*="tel:"], a[href*="wa.me"], a[href*="m.me"]').each(
		function () {
			let anchor_element = $(this).is("a") ? $(this) : $(this).find("a");
			anchor_element = $.isArray(anchor_element)
				? anchor_element[0]
				: anchor_element;
			let anchor_category = $(document).find("title").text()
				? $(document).find("title").text()
				: window.location.href;
			let anchor_href = anchor_element.attr("href");
			let anchor_label = anchor_element.attr("title")
				? anchor_element.attr("title")
				: anchor_element.attr("href");
			if ($(this).parents(".sticky-buttons")) {
				anchor_label += " - Sticky Button";
			}
			if ($(this).parents("body.single")) {
				anchor_label += " - Single Post Link";
			}
			anchor_element.attr({
				"data-vars-ga-category": anchor_category,
				"data-vars-ga-action": anchor_href,
				"data-vars-ga-label": anchor_label,
			});
		}
	);

	$(".sh-social-share-networks").jsSocials({
		showLabel: false,
		showCount: "inside",
		shares: [
			"facebook",
			"twitter",
			"email",
			"linkedin",
			"telegram",
			"whatsapp",
			// "pinterest",
			// "messenger",
			// "line",
			// "viber",
			// "googleplus",
			// "vkontakte",
			// "stumbleupon",
			// "pocket"
		],
		shareIn: "blank",
	});
});