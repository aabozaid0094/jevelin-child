jQuery(window).on("load", function () {
	terms_slick_options.forEach((element, index) => {
		let autoplay = element.autoplay != null ? element.autoplay : true;
		let autoplaySpeed = element.autoplaySpeed
			? element.autoplaySpeed
			: 3000;
		let rtl = element.rtl != null ? element.rtl : true;
		let dirAttr = rtl ? "rtl" : "";
		let arrows = element.arrows != null ? element.arrows : false;
		let prevArrow = element.prevArrow;
		if (!prevArrow && rtl) {
			prevArrow =
				'<i class="fa fa-chevron-right" aria-hidden="true"></i>';
		} else if (!prevArrow && !rtl) {
			prevArrow = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
		}
		let nextArrow = element.nextArrow;
		if (!nextArrow && rtl) {
			nextArrow = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
		} else if (!nextArrow && !rtl) {
			nextArrow =
				'<i class="fa fa-chevron-right" aria-hidden="true"></i>';
		}
		let dots = element.dots != null ? element.dots : true;
		let dotIcon = element.dotIcon;
		if (!dotIcon) {
			dotIcon = '<i class="fa fa-square" aria-hidden="true"></i>';
		}
		let centerMode =
			element.centerMode != null ? element.centerMode : false;
		let desktop_slidesToShow = element.desktop_slidesToShow
			? element.desktop_slidesToShow
			: 1;
		let tablet_slidesToShow = element.tablet_slidesToShow
			? element.tablet_slidesToShow
			: Math.min(element.desktop_slidesToShow, 2);
		let mobile_slidesToShow = element.mobile_slidesToShow
			? element.mobile_slidesToShow
			: 1;
		let slidesToScroll = element.slidesToScroll
			? element.slidesToScroll
			: "all";
		let desktop_slidesToScroll =
			slidesToScroll == "one" ? 1 : parseInt(desktop_slidesToShow);
		let tablet_slidesToScroll =
			slidesToScroll == "one" ? 1 : parseInt(tablet_slidesToShow);
		let mobile_slidesToScroll =
			slidesToScroll == "one" ? 1 : parseInt(mobile_slidesToShow);
		if (typeof jQuery(".post-terms-slider-" + index).slick == "function") {
			jQuery(".post-terms-slider-" + index)
				.attr("dir", dirAttr)
				.slick({
					autoplay: autoplay,
					autoplaySpeed: parseInt(autoplaySpeed),
					dots: dots,
					arrows: arrows,
					nextArrow:
						'<a type="button" role="button" aria-label="Next" class="slick-arrow slick-next">' +
						nextArrow +
						"</a>",
					prevArrow:
						'<a type="button" role="button" aria-label="Previous" class="slick-arrow slick-prev">' +
						prevArrow +
						"</a>",
					slidesToShow: parseInt(desktop_slidesToShow),
					slidesToScroll: desktop_slidesToScroll,
					rtl: rtl,
					centerMode: centerMode,
					responsive: [
						{
							breakpoint: 1200,
							settings: {
								slidesToShow: Math.min(
									parseInt(desktop_slidesToShow),
									4
								),
								slidesToScroll: desktop_slidesToScroll,
							},
						},
						{
							breakpoint: 992,
							settings: {
								slidesToShow: parseInt(tablet_slidesToShow),
								slidesToScroll: tablet_slidesToScroll,
							},
						},
						{
							breakpoint: 768,
							settings: {
								autoplay: true,
								slidesToShow: parseInt(mobile_slidesToShow),
								slidesToScroll: mobile_slidesToScroll,
								arrows: false,
							},
						},
					],
					pauseOnDotsHover: true,
					customPaging: function (slider, i) {
						return (
							'<a type="button" role="button" data-role="none" tabindex="0" class="slick-dot">' +
							dotIcon +
							"</a>"
						);
					},
				});
		}
	});
});
