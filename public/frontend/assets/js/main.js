/***************************************************
==================== JS INDEX ======================
****************************************************
01. PreLoader Js
02. Mobile Menu Js
03. Sidebar Js
04. Search Js
05. Sticky Header Js
06. Data-Background Js
07. Testimonial Slider Js
08. Testimonial Slider 3 Js
09. Testimonial Slider 5 Js
10. Team Slider Js
11. Masonary Js
12. WoW Js
13. Counter Js
14. Parallax Js
15. InHover Active Js
****************************************************/

(function ($) {
"use strict";

	var windowOn = $(window);
	////////////////////////////////////////////////////
    // 01. PreLoader Js
	windowOn.on('load',function() {
		$("#loading").fadeOut(500);
	});


	////////////////////////////////////////////////////
    // 02. Mobile Menu Js
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});


	////////////////////////////////////////////////////
    // 03. Sidebar Js
	$("#sidebar-toggle").on("click", function () {
		$(".sidebar__area").addClass("sidebar-opened");
		$(".body-overlay").addClass("opened");
	});
	$(".sidebar__close-btn").on("click", function () {
		$(".sidebar__area").removeClass("sidebar-opened");
		$(".body-overlay").removeClass("opened");
	});



	////////////////////////////////////////////////////
    // 04. Search Js
	$(".searchOpen").on("click", function () {
		$(".search-wrapper").addClass("search-open");
		$(".body-overlay").addClass("opened");
	});
	$(".search-close").on("click", function () {
		$(".search-wrapper").removeClass("search-open");
		$(".body-overlay").removeClass("opened");
	});


	////////////////////////////////////////////////////
    // 05. Sticky Header Js
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$("#header-sticky").removeClass("sticky");
		} else {
			$("#header-sticky").addClass("sticky");
		}
	});

	////////////////////////////////////////////////////
    // 06. Data-Background Js
	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});

  
	////////////////////////////////////////////////////
    // 07. Testimonial Slider Js
	$('.testimonial__slider').owlCarousel({
		loop:true,
		margin:30,
		autoplay:true,
		autoplayTimeout:3000,
		smartSpeed:500,
		items:6,
		navText:['<button><i class="fa fa-angle-left"></i>PREV</button>','<button>NEXT<i class="fa fa-angle-right"></i></button>'],
		nav:false,
		dots:true,
		responsive:{
			0:{
				items:1
			},
			576:{
				items:1
			},
			767:{
				items:2
			},
			992:{
				items:3
			},
			1200:{
				items:2
			},
			1600:{
				items:2
			}
		}
	});

	////////////////////////////////////////////////////
    // 08. Testimonial Slider 3 Js
	$('.testimonial__slider-3').owlCarousel({
		loop:true,
		margin:30,
		autoplay:true,
		autoplayTimeout:3000,
		smartSpeed:500,
		items:6,
		navText:['<button><i class="fa fa-angle-left"></i>PREV</button>','<button>NEXT<i class="fa fa-angle-right"></i></button>'],
		nav:false,
		dots:true,
		responsive:{
			0:{
				items:1
			},
			576:{
				items:1
			},
			767:{
				items:2
			},
			992:{
				items:2
			},
			1200:{
				items:3
			},
			1600:{
				items:3
			}
		}
	});

	////////////////////////////////////////////////////
    // 09. Testimonial Slider 5 Js
	$('.testimonial__slider-5').owlCarousel({
		loop:true,
		margin:30,
		autoplay:true,
		autoplayTimeout:3000,
		smartSpeed:500,
		items:6,
		navText:['<button><i class="fa fa-angle-left"></i>PREV</button>','<button>NEXT<i class="fa fa-angle-right"></i></button>'],
		nav:false,
		dots:true,
		responsive:{
			0:{
				items:1
			},
			576:{
				items:1
			},
			767:{
				items:1
			},
			992:{
				items:1
			},
			1200:{
				items:1
			},
			1600:{
				items:1
			}
		}
	});

	////////////////////////////////////////////////////
    // 10. Team Slider Js
	$('.team__slider ').owlCarousel({
		loop:true,
		margin:30,
		autoplay:false,
		autoplayTimeout:3000,
		smartSpeed:500,
		items:6,
		navText:['<button><i class="fa fa-angle-left"></i>PREV</button>','<button>NEXT<i class="fa fa-angle-right"></i></button>'],
		nav:false,
		dots:true,
		responsive:{
			0:{
				items:1
			},
			576:{
				items:1
			},
			767:{
				items:2
			},
			992:{
				items:3
			},
			1200:{
				items:3
			},
			1600:{
				items:3
			}
		}
	});


	
	////////////////////////////////////////////////////
    // 11. Masonary Js
	$('.grid').imagesLoaded( function() {
		// init Isotope
		var $grid = $('.grid').isotope({
		  itemSelector: '.grid-item',
		  percentPosition: true,
		  masonry: {
			// use outer width of grid-sizer for columnWidth
			columnWidth: '.grid-item',
		  }
		});


	// filter items on button click
	$('.masonary-menu').on( 'click', 'button', function() {
	  var filterValue = $(this).attr('data-filter');
	  $grid.isotope({ filter: filterValue });
	});

	//for menu active class
	$('.masonary-menu button').on('click', function(event) {
		$(this).siblings('.active').removeClass('active');
		$(this).addClass('active');
		event.preventDefault();
	});

	});


	////////////////////////////////////////////////////
    // 12. WoW Js
	new WOW().init();


	////////////////////////////////////////////////////
    // 13. Counter Js
	$('.counter').counterUp({
		delay: 10,
		time: 2000
	});
	
	////////////////////////////////////////////////////
    // 14. Parallax Js
	if ($('.scene').length > 0 ) {
		$('.scene').parallax({
			scalarX: 10.0,
			scalarY: 15.0,
		}); 
	};

	////////////////////////////////////////////////////
    // 15. InHover Active Js
	$('.hover__active').on('mouseenter', function () {
		$(this).addClass('active').parent().siblings().find('.hover__active').removeClass('active');
	});

})(jQuery);