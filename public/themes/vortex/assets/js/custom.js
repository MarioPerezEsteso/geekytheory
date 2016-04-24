(function($){

	"use strict";

	/* ---------------------------------------------- /*
	 * Preloader
	/* ---------------------------------------------- */

	$(window).load(function() {
		$('.loader').fadeOut();
		$('.page-loader').delay(350).fadeOut('slow');
	});

	$(document).ready(function() {

		/* ---------------------------------------------- /*
		 * Initialization general scripts for all pages
		/* ---------------------------------------------- */

		var moduleHero      = $('#hero'),
			overlayMenu     = $('#overlay-menu'),
			slider          = $('#slides'),
			navbar          = $('.navbar-custom'),
			filters         = $('#filters'),
			worksgrid       = $('#works-grid'),
			modules         = $('.module-hero, .module, .module-small'),
			windowWidth     = Math.max($(window).width(), window.innerWidth),
			navbatTrans,
			mobileTest;

		navbarCheck(navbar);

		$(window).resize(function() {
			buildModuleHero();
			windowWidth     = Math.max($(window).width(), window.innerWidth);
		});

		$(window).scroll(function() {
			if(windowWidth > 960) {
				navbarAnimation(navbar, moduleHero);
			}
		}).scroll();

		/* ---------------------------------------------- /*
		 * Mobile detect
		/* ---------------------------------------------- */

		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			mobileTest = true;
		} else {
			mobileTest = false;
		}

		/* ---------------------------------------------- /*
		 * Intro slider setup
		/* ---------------------------------------------- */

		$('#slides').superslides({
			play: 10000,
			animation: 'fade',
			animation_speed: 800,
			pagination: true,
		});

		/* ---------------------------------------------- /*
		 * Setting background of modules
		/* ---------------------------------------------- */

		modules.each(function() {
			if ($(this).attr('data-background')) {
				$(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
			}
		});

		/* ---------------------------------------------- /*
		 * Parallax
		/* ---------------------------------------------- */

		if (mobileTest === true) {
			$('.module-parallax').css({'background-attachment': 'scroll'});
		} else {
			$('#hero.module-parallax').parallax('50%', 0.2);
		}

		/* ---------------------------------------------- /*
		 * Full height module
		/* ---------------------------------------------- */

		function buildModuleHero() {
			if (moduleHero.length > 0) {
				if (moduleHero.hasClass('module-full-height')) {
					moduleHero.height($(window).height());
				} else {
					moduleHero.height($(window).height() * 0.85);
				}
			}
		}

		/* ---------------------------------------------- /*
		 * Youtube video background
		/* ---------------------------------------------- */

		$(function(){
			$('.video-player').mb_YTPlayer();
		});

		/* ---------------------------------------------- /*
		 * Transparent navbar animation
		/* ---------------------------------------------- */

		function navbarCheck() {
			if (navbar.length > 0 && navbar.hasClass('navbar-transparent')) {
				navbatTrans = true;
			} else {
				navbatTrans = false;
			}
		}

		function navbarAnimation(navbar, moduleHero) {
			var topScroll = $(window).scrollTop();
			if (navbar.length > 0 && navbatTrans !== false) {
				if (topScroll >= 5) {
					navbar.removeClass('navbar-transparent');
				} else {
					navbar.addClass('navbar-transparent');
				}
			}
		}

		/* ---------------------------------------------- /*
		 * Show/Hide overlay menu
		/* ---------------------------------------------- */

		$('#toggle-menu').on('click', function() {
			showMenu();
			$('body').addClass('aux-navigation-active');
			return false;
		});

		$('#overlay-menu-hide').on('click', function() {
			hideMenu();
			$('body').removeClass('aux-navigation-active');
			return false;
		});

		$(window).keydown(function(e) {
			if (overlayMenu.hasClass('active')) {
				if (e.which === 27) {
					hideMenu();
				}
			}
		});

		function showMenu() {
			navbar.animate({'opacity': 0, 'top': -80}, {
				duration: 150,
				easing: 'easeInOutQuart'
			});

			overlayMenu.addClass('active');
		}

		function hideMenu() {
			navbar.animate({'opacity': 1, 'top': 0}, {
				duration: 150,
				easing: 'easeInOutQuart'
			});

			overlayMenu.removeClass('active');
		}

		/* ---------------------------------------------- /*
		 * Overlay dropdown menu
		/* ---------------------------------------------- */

		$('#nav > li.slidedown > a').on('click', function() {
			if ($(this).attr('class') != 'active') {
				$('#nav li ul').slideUp({duration: 300, easing: 'easeInOutQuart'});
				$('#nav li a').removeClass('active');
				$(this).next().slideToggle({duration: 300, easing: 'easeInOutQuart'}).addClass('open');
				$(this).addClass('active');
			} else {
				$('#nav li ul').slideUp({duration: 300, easing: 'easeInOutQuart'}).removeClass('open');
				$(this).removeClass('active');
			}
			return false;
		});

		/* ---------------------------------------------- /*
		 * Portfolio
		/* ---------------------------------------------- */

		$('a', filters).on('click', function() {
			var selector = $(this).attr('data-filter');

			$('.current', filters).removeClass('current');
			$(this).addClass('current');

			worksgrid.isotope({
				filter: selector
			});

			return false;
		});

		$(window).on('resize', function() {

			var windowWidth    = Math.max($(window).width(), window.innerWidth),
				itemWidht      = $('.grid-sizer').width(),
				itemHeight     = Math.floor(itemWidht * 0.95),
				itemTallHeight = itemHeight * 2;

			if (windowWidth > 500) {
				$('.work-item', worksgrid).each(function() {
					if ($(this).hasClass('tall')) {
						$(this).css({
							height : itemTallHeight
						});
					} else if ($(this).hasClass('wide')) {
						$(this).css({
							height : itemHeight
						});
					} else if ($(this).hasClass('wide-tall')) {
						$(this).css({
							height : itemTallHeight
						});
					} else {
						$(this).css({
							height : itemHeight
						});
					}
				});
			} else {
				$('.work-item', worksgrid).each(function() {
					if ($(this).hasClass('tall')) {
						$(this).css({
							height : itemTallHeight
						});
					} else if ($(this).hasClass('wide')) {
						$(this).css({
							height : itemHeight / 2
						});
					} else if ($(this).hasClass('wide-tall')) {
						$(this).css({
							height : itemHeight
						});
					} else {
						$(this).css({
							height : itemHeight
						});
					}
				});
			}

			worksgrid.imagesLoaded(function() {
				worksgrid.isotope({
					layoutMode: 'packery',
					itemSelector: '.work-item',
					transitionDuration: '0.3s',
					packery: {
						columnWidth: '.grid-sizer',
					},
				});
			});

		}).resize();

		/* ---------------------------------------------- /*
		 * Blog grid
		/* ---------------------------------------------- */

		$('#posts-masonry').imagesLoaded(function() {
			$('#posts-masonry').isotope({
				layoutMode: 'masonry',
				transitionDuration: '0.3s'
			});
		});

		/* ---------------------------------------------- /*
		 * Google Map
		/* ---------------------------------------------- */

		var mapLocation = new google.maps.LatLng(34.031428,-118.2071542,17);

		var $mapis = $('#map');

		if ($mapis.length > 0) {

			var map;
			map = new GMaps({
				streetViewControl : true,
				overviewMapControl: true,
				mapTypeControl: true,
				zoomControl : true,
				panControl : true,
				scrollwheel: false,
				center: mapLocation,
				el: '#map',
				zoom: 16,
				styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]
			});

			var image = new google.maps.MarkerImage('assets/images/map-icon.png',
				new google.maps.Size(59, 65),
				new google.maps.Point(0, 0),
				new google.maps.Point(24, 42)
			);

			map.addMarker({
				position: mapLocation,
				icon: image,
				title: 'Vortex',
				infoWindow: {
					content: '<p><strong>Vortex</strong><br/>121 Somewhere Ave, Suite 123<br/>P: (123) 456-7890<br/>Australia</p>'
				}
			});

		}

		/* ---------------------------------------------- /*
		 * Ajax options
		/* ---------------------------------------------- */

		var pageNumber = 0,
			workNumberToload = 5;

		var doneText    = 'Done',
			loadText    = 'More works',
			loadingText = 'Loading...',
			errorText   = 'Error! Check the console for more information.';

		/* ---------------------------------------------- /*
		 * Ajax portfolio
		/* ---------------------------------------------- */

		$('#show-more').on('click', function() {
			$(this).text(loadingText);

			setTimeout(function() {
				ajaxLoad(workNumberToload, pageNumber);
			}, 300);

			pageNumber++;

			return false;
		});

		function ajaxLoad(workNumberToload, pageNumber) {
			var $loadButton = $('#show-more');
			var dataString = 'numPosts=' + workNumberToload + '&pageNumber=' + pageNumber;

			$.ajax({
				type: 'GET',
				data: dataString,
				dataType: 'html',
				url: 'assets/php/ajax-load-more/ajax-load-more.php',
				success: function(data) {
					var $data = $(data);
					var start_index = (pageNumber - 1) * workNumberToload;
					var end_index = + start_index + workNumberToload;

					if ($data.find('.work-item').slice(start_index).length) {
						var work = $data.find('.work-item').slice(start_index, end_index);

						worksgrid.append(work).isotope('appended', work).resize();

						setTimeout(function() {
							$loadButton.text(loadText);
						}, 300);
					} else {
						setTimeout(function() {
							$loadButton.text(doneText);
						}, 300);

						setTimeout(function () {
							$('#show-more').animate({
								opacity: 0,
							}).css('display', 'none');
						}, 1500);
					}
				},

				error: function (jqXHR, textStatus, errorThrown) {
					console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);

					setTimeout(function() {
						$loadButton.removeClass('ss-loading');
						$loadButton.text(errorText);
					}, 300);

				}
			});
		}

		/* ---------------------------------------------- /*
		 * Rotate
		/* ---------------------------------------------- */

		$(".rotate").textrotator({
			animation: "dissolve",
			separator: "|",
			speed: 3000
		});

		/* ---------------------------------------------- /*
		 * Owl sliders
		/* ---------------------------------------------- */

		$('.slider-testimonials').owlCarousel({
			stopOnHover:     !0,
			singleItem:      !0,
			autoHeight:      !0,
			slideSpeed:      400,
			paginationSpeed: 1000,
			goToFirstSpeed:  2000,
			autoPlay:        3000,
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		});

		$('.slider-images').owlCarousel({
			stopOnHover:     !0,
			singleItem:      !0,
			autoHeight:      !0,
			navigation:      !0,
			slideSpeed:      400,
			paginationSpeed: 1000,
			goToFirstSpeed:  2000,
			autoPlay:        3000,
			transitionStyle : "fade",
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		});

		/* ---------------------------------------------- /*
		 * Video popup, Gallery
		/* ---------------------------------------------- */

		$('.video-pop-up').magnificPopup({
			type: 'iframe',
		});

		$('a.gallery').magnificPopup({
			type: 'image',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1]
			},
			image: {
				titleSrc: 'title',
				tError: 'The image could not be loaded.',
			}
		});

		/* ---------------------------------------------- /*
		 * Progress bars, counters animations
		/* ---------------------------------------------- */

		$('.progress-bar').each(function(i) {
			$(this).appear(function() {
				var percent = $(this).attr('aria-valuenow');
				$(this).animate({'width' : percent + '%'});
				$(this).find('span').animate({'opacity' : 1}, 900);
				$(this).find('span').countTo({from: 0, to: percent, speed: 900, refreshInterval: 30});
			});
		});

		$('.counter-item').each(function(i) {
			$(this).appear(function() {
				var number = $(this).find('.counter-number').data('number');
				$(this).find('.counter-number span').countTo({from: 0, to: number, speed: 1200, refreshInterval: 30});
			});
		});

		/* ---------------------------------------------- /*
		 * WOW Animation
		/* ---------------------------------------------- */

		var wow = new WOW({
			mobile: false
		});

		wow.init();

		/* ---------------------------------------------- /*
		 * A jQuery plugin for fluid width video embeds
		/* ---------------------------------------------- */

		$('body').fitVids();

		/* ---------------------------------------------- /*
		 * Scroll Animation
		/* ---------------------------------------------- */

		$('.section-scroll').bind('click', function(e) {
			var anchor = $(this);

			$('html, body').stop().animate({
				scrollTop: $(anchor.attr('href')).offset().top
			}, 1000);

			e.preventDefault();
		});

		/* ---------------------------------------------- /*
		 * Scroll top
		/* ---------------------------------------------- */

		$(window).scroll(function() {
			if ($(this).scrollTop() > 100) {
				$('.scroll-up').fadeIn();
			} else {
				$('.scroll-up').fadeOut();
			}
		});

		$('a[href="#totop"]').click(function() {
			$('html, body').animate({ scrollTop: 0 }, 'slow');
			return false;
		});

	});

})(jQuery);
