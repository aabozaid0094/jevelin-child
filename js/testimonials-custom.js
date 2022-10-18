jQuery(document).ready(function ($) {
	testimonials_slick_options.forEach((element, index) => {
    let autoplay = element.autoplay;
    let autoplaySpeed = element.autoplaySpeed;
    let rtl = element.rtl;
    let arrows = element.arrows;
    let prevArrow = element.prevArrow;
      if (!prevArrow && rtl) { prevArrow = '<i class="fa fa-chevron-right" aria-hidden="true"></i>'; } 
      else if(!prevArrow && !rtl) { prevArrow = '<i class="fa fa-chevron-left" aria-hidden="true"></i>'; }
    let nextArrow = element.nextArrow;
      if (!nextArrow && rtl) { nextArrow = '<i class="fa fa-chevron-left" aria-hidden="true"></i>'; }
      else if(!nextArrow && !rtl) { nextArrow = '<i class="fa fa-chevron-right" aria-hidden="true"></i>'; }
    let dots = element.dots;
    let dotIcon = element.dotIcon;
      if (!dotIcon) { dotIcon = '<i class="fa fa-square" aria-hidden="true"></i>'; }
    let centerMode = element.centerMode;
    let desktop_slidesToShow = element.desktop_slidesToShow;
    let tablet_slidesToShow = element.tablet_slidesToShow;
    let mobile_slidesToShow = element.mobile_slidesToShow;
    let slidesToScroll = element.slidesToScroll;
    let desktop_slidesToScroll = (slidesToScroll == "one") ? 1 : parseInt(desktop_slidesToShow) ;
    let tablet_slidesToScroll = (slidesToScroll == "one") ? 1 : parseInt(tablet_slidesToShow) ;
    let mobile_slidesToScroll = (slidesToScroll == "one") ? 1 : parseInt(mobile_slidesToShow) ;
    $(window).on("load", function () {
      if ( typeof jQuery(".testimonials-custom-"+index).slick == "function") {
        $(".testimonials-custom-"+index).slick({
          autoplay: autoplay,
          autoplaySpeed: parseInt(autoplaySpeed),
          dots: dots,
          arrows: arrows,
          nextArrow: '<a type="button" role="button" aria-label="Next" class="slick-arrow slick-next">'+prevArrow+'</a>',
          prevArrow: '<a type="button" role="button" aria-label="Previous" class="slick-arrow slick-prev">'+nextArrow+'</a>',
          slidesToShow: parseInt(desktop_slidesToShow),
          slidesToScroll: desktop_slidesToScroll,
          rtl: rtl,
          centerMode: centerMode,
          focusOnSelect: true,
          responsive: [
            {
              breakpoint: 1026,
              settings: {
                slidesToShow: parseInt(desktop_slidesToShow),
                slidesToScroll: desktop_slidesToScroll,
              },
            },
            {
              breakpoint: 1025,
              settings: {
                slidesToShow: parseInt(tablet_slidesToShow),
                slidesToScroll: tablet_slidesToScroll,
              },
            },
            {
              breakpoint: 760,
              settings: {
                slidesToShow: parseInt(mobile_slidesToShow),
                slidesToScroll: mobile_slidesToScroll,
              },
            },
          ],
          pauseOnDotsHover: true,
          customPaging: function (slider, i) {
            return '<a type="button" role="button" data-role="none" tabindex="0" class="slick-dot">'+dotIcon+'</a>';
          },
        });
      }
    });
  });
});