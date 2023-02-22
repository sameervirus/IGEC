(function ($) {
	"use strict";
	var pnwt = pnwt || {};
	window.pnwt = pnwt;
	function parseVal(s, d)
	{
		s = ( typeof s != "undefined" ) ? s : d;
		return ( ( /^\s*(true|1|on)\s*$/i ).test(s) ) ? true : false;
	}
	pnwt.initialization = {
		init: function () {
			
			new WOW({'mobile':false}).init();
			
			$('.header a[href^="#"], .wsmenu a[href^="#"], .page a.btn[href^="#"], .page a.internal-link[href^="#"]').on('click', function (e) {
				e.preventDefault();
				var target = this.hash,
					$target = jQuery(target);
				if( $target.length > 0 ) {
					$htmlBody.stop().animate({
						'scrollTop': $target.offset().top - 60 // - 200px (nav-height)
					}, 'slow', 'easeInSine', function () {
						window.location.hash = '1' + target;
					});
				}
			});
			
			$('.count-element').each(function () {
				$(this).appear(function() {
					$(this).prop('Counter',0).animate({
						Counter: $(this).text()
					}, {
						duration: 4000,
						easing: 'swing',
						step: function (now) {
							$(this).text(Math.ceil(now));
						}
					});
				},{accX: 0, accY: 0});
			});
			
			$('.video-popup').magnificPopup({
				type: 'iframe',
				iframe: {
				  patterns: { 
					youtube: {
						index: 'youtube.com/',
						id: function(url) {
							var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
							if ( !m || !m[1] ) return null;
							return m[1];
						},
						src: '//www.youtube.com/embed/%id%?autoplay=1' 
					}, 
					vimeo: {
						index: 'vimeo.com/',
						id: function(url) {
							var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
							if ( !m || !m[5] ) return null;
							return m[5];
						},
						src: '//player.vimeo.com/video/%id%?autoplay=1' 
					}
				}
				} 
			});
			this.footerCollapse('.collapsed-mobile');
			this.infiniteScroll();
			this.menu();
		},
		menu: function () {
			document.addEventListener('touchstart', function () {}, false);
			$body.wrapInner('<div class="wsmenucontainer" />');
			$('<div class="overlapblackbg"></div>').prependTo('.wsmenu');
			$('#wsnavtoggle').click(function (e) {
				e.preventDefault();
				$body.toggleClass('wsactive');
			});
			$('.overlapblackbg').click(function () {
				$body.removeClass('wsactive');
			});
			$('.wsmenu > .wsmenu-list > li').has('.sub-menu, .wsmegamenu').prepend('<span class="wsmenu-click"><i class="wsmenu-arrow"></i></span>');
			$('.wsmenu-click').click(function () {
				var $this = $(this);
				$this.toggleClass('ws-activearrow').parent().siblings().children().removeClass('ws-activearrow');
				$this.closest('li').toggleClass('active');
				$('.wsmenu > .wsmenu-list > li > .sub-menu, .wsmegamenu').not($this.siblings('.wsmenu > .wsmenu-list > li > .sub-menu, .wsmegamenu')).slideUp('100');
				$this.siblings('.sub-menu, .wsmegamenu').slideToggle('100');
			});
			$('.wsmenu > .wsmenu-list li > ul > li').has('.sub-menu').prepend('<span class="wsmenu-click02"><i class="wsmenu-arrow"></i></span>');
			$body.on( 'click', '.wsmenu-click02', function(){
				var $this = $(this);
				$this.children('.wsmenu-arrow').toggleClass('wsmenu-rotate');
				$this.closest('li').toggleClass('active');
				$this.siblings('li > .sub-menu').slideToggle('100');
			});
			$window.on('resize', function () {
				var $this = $(this);
				if ($window.outerWidth() < 992) {
					$('.wsmenu').css('height', $this.height() + 'px');
					$('.wsmenucontainer').css('min-width', $this.width() + 'px');
				} else {
					$('.wsmenu').removeAttr('style');
					$('.wsmenucontainer').removeAttr('style');
					$body.removeClass('wsactive');
					$('.wsmenu > .wsmenu-list > li > .wsmegamenu, .wsmenu > .wsmenu-list li > ul.sub-menu').removeAttr('style');
					$('.wsmenu-click').removeClass('ws-activearrow');
					$('.wsmenu-click02 > i').removeClass('wsmenu-rotate');
				}
			});
			$window.trigger('resize');
		},
		footerCollapse: function (el) {
			$.fn.footerCollapse = function () {
				var $collapsed = this;
				$('.widget-title', $collapsed).on('click', function (e) {
					e.preventDefault;
					$(this).closest('.collapsed-mobile').toggleClass('open');
				});
			};
			$(el).footerCollapse();
		},
		infiniteScroll: function() {
			$window.on( 'load', function() {
				if ( $.fn.infiniteScroll !== undefined && $( 'div.infinite-scroll-nav .next-posts a' ).length ) {
					powernodepwiInfiniteScrollInit();
				}
				
				function powernodepwiInfiniteScrollInit() {
					$( '.infinite-scroll-wrap' ).each(function( e ) {
					  	var $this = $(this),
						infStyle = $this.parents('div').find('.infinite-pagination').data('style'),
						itemSelector = $this.parents('div').find('.infinite-pagination').data('item-selector'),
						isLoadMore = ( infStyle == 'load-more' ) ? false : true;
						$this.infiniteScroll( {
							path 	: '.next-posts a',
							append 	: ( itemSelector ) ? itemSelector : '.item-entry',
							status 	: '.infinite-pagination',
							button  : '.load-more-button',
							scrollThreshold : isLoadMore,
							hideNav : '.infinite-scroll-nav',
							history : false,
							checkLastPage : true,
						} );
						
						$this.on( 'load.infiniteScroll', function( event, response, path, items ) {
							var $items = $( response ).find( '.item-entry' );
							$items.imagesLoaded( function() {
								$items.animate( { opacity : 1 } );
								// Force the images to be parsed to fix Safari issue
								$items.find( 'img' ).each( function( index, img ) {
									img.outerHTML = img.outerHTML;
								} );

							} );

						} );
					});
				}
			} );
		},
		sidebarToggleDropdown: function (el) { 
			$document.on('click', '.sidebar-widget ul li.menu-item-has-children, .sidebar-widget ul li.page_item_has_children', function (e) {
				var ele = $(this);
				if (ele.hasClass('open')) {
					ele.removeClass('open').find('li').removeClass('open');
					ele.find('ul').slideUp();
				} else {
					ele.addClass('open').children('ul').slideDown();
					ele.siblings('li').children('ul').slideUp();
					ele.siblings('li').removeClass('open');
					ele.siblings('li').find('li').removeClass('open');
					ele.siblings('li').find('ul').slideUp();
				}
			});
		},
	},
	pnwt.header = {
		init: function () {
			this.megaMenu();
			this.searchToggle();
		},
		searchToggle: function () {
			$body.on('click', '.search-action', function(){
				$(this).parents('.header-search').toggleClass('search-open');
			});
		},
		megaMenu: function () {
			var MegaMenu = {
				MegaMenuData: {
					header: '.header',
					menu: '.pnwt-menu',
					submenu: '.pnwt-dropdown',
					toggleMenu: '.toggleMenu',
					simpleDropdn: '.has-simple-menu',
					megaDropdn: '.has-mega-menu',
					vertical: false
				},
				init: function (options) {
					$.extend(this.MegaMenuData, options);
					if ( !isMobile && $(this.MegaMenuData.menu).length) {
						MegaMenu._handlers(this);
					}
				},
				_handlers: function (menu) {
					
					function setMaxHeight(wHeight, submenu) {
						if ($menu.hasClass('menu-vertical')) return false;
						if (submenu.length) {
							var maxH = $header.find('.header-wrap').hasClass('scroll') ? (wHeight - $header.find('.header-wrap.scroll').outerHeight()) : (wHeight - submenu.prev().offset().top - submenu.prev().outerHeight());
							submenu.css({
								'max-height': maxH + 'px'
							})
						}
					}
					
					function setMenuXPosition(wWidth, submenu) {
						if ($menu.hasClass('menu-vertical')) return false;
						if (submenu.length) {
							submenu.css("left", '');
							var menuContainer = $header.find('.menu-container');
							if(typeof submenu.offset() !== 'undefined' && menuContainer && submenu.parent('li').hasClass('has-mega-menu')){
								var oPosition = submenu.offset().left,
								oWidth = submenu.outerWidth(),
								cnWidth = menuContainer.width(),
								cnLeftOffset = menuContainer.offset().left;
								if (submenu.parent('li').hasClass('mega-menu-full-width')) {
									submenu.find('.pnwt-megamenu-inside').width(cnWidth);
								}
								if ( oWidth + oPosition - cnLeftOffset >= cnWidth ) {
									var delta = parseInt( oWidth + oPosition - cnWidth - cnLeftOffset - 15);
									//alert( 'oWidth:'+oWidth+'oPosition:'+oPosition+'cnWidth:'+cnWidth+'cnLeftOffset:'+cnLeftOffset  );
									submenu.css({'left' : - delta});
								}
							}
						}
					}
					
					function setSubmenuPosition(wWidth, submenu) {
						if ($menu.hasClass('menu-vertical')) return false;
						if (submenu.length) {
							submenu.find('li').each(function() {
								var $this = $(this),
								menuContainer = $header.find('.menu-container'),
								$item = $($this).find('.pnwt-megamenu-inside .pnwt-dropdown').first();
								if ( $($item).length > 0 ) {
									if ( submenu.parent('li').hasClass('menu-item') ) {
										wWidth = (menuContainer.width())+(menuContainer.offset().left) ;
									}
									var ofRight = (wWidth - ($item.offset().left + $item.outerWidth()));
									if ( ofRight < 0 ) {
										$($item).removeClass('to-right').addClass('to-left');
									}
								}
							});
						}
					}

					function clearMaxHeight() {
						$submenu.each(function () {
							var $this = $(this);
							$this.css({
								'max-height': ''
							});
						})
					}

					var $menu = $(menu.MegaMenuData.menu),
						submenu = menu.MegaMenuData.submenu,
						$submenu = $(menu.MegaMenuData.submenu, $menu),
						$header = $(menu.MegaMenuData.header),
						$toggleMenu = $(menu.MegaMenuData.toggleMenu),
						megaDropdnClass = menu.MegaMenuData.megaDropdn,
						simpleDropdnClass = menu.MegaMenuData.simpleDropdn,
						vertical = menu.MegaMenuData.vertical;
						
					if (vertical && (window.innerWidth || $window.width()) < 1024) {
						$menu.on(".pnwt-menu", ".submenu a", function (e) {
							var $this = $(this);
							if (!$this.data('firstclick')) {
								$this.data('firstclick', true);
								e.preventDefault();
							}
						});
						$menu.on(".pnwt-menu", megaDropdnClass + '> a,' + simpleDropdnClass + '> a', function (e) {
							if (!$(this).parent('li').hasClass('hovered')) {
								setMaxHeight($window.height(), $(this).next());
								$submenu.scrollTop(0);
								$('li', $menu).removeClass('hovered');
								$(this).parent('li').addClass('hovered');
								e.preventDefault();
							} else {
								clearMaxHeight();
								$(this).parent('li').removeClass('hovered');
								$(submenu + 'a').removeData('firstclick');
							}
						});
						$menu.on(".pnwt-menu", function (e) {
							e.stopPropagation();
						})
					} else {
						
						$menu.on('hover mouseenter', '.has-mega-menu, .has-simple-menu', function () {
							var $this = $(this),
								$submenu = $this.find(submenu).first();
							setMaxHeight($(window).height(), $submenu);
							setMenuXPosition($(window).width(), $submenu);
							setSubmenuPosition($(window).width(), $submenu);
							$submenu.scrollTop(0);
							$this.addClass('hovered');
						}).on("mouseleave", megaDropdnClass + ',' + simpleDropdnClass, function () {
							clearMaxHeight();
							var $this = $(this);
							$this.removeClass('hovered');
						});
						
					}
					
					$toggleMenu.on('click', function (e) {
						var $this = this;
						$header.toggleClass('open');
						$this.toggleClass('open');
						$menu.addClass('disable').delay(1000).queue(function () {
							$this.removeClass('disable').dequeue();
						});
						e.preventDefault();
					});
					
					if (vertical) {
						$('li.has-simple-menu', $menu).on('hover', function () {
							var $this = $(this),
								$elm = $('.sub-menu', this).length ? $('.sub-menu', this) : $('ul:first', this),
								windowH = $window.height(),
								isYvisible = (windowH + $window.scrollTop()) - ($elm.offset().top + $elm.outerHeight());
							if (isYvisible < 0 && !$this.hasClass('has-mega-menu')) {
								$elm.css({
									'margin-top': isYvisible + 'px'
								});
							}
						})
					}
				}
			};
			pnwt.megamenu = Object.create(MegaMenu);
			pnwt.megamenu.init();
		},
	},
	pnwt.sections = {
		init: function () {
			this.pnwtSlickCarousel();
			this.pnwtOwlCarousel();
			this.masonryGrid();
		},
		pnwtOwlCarousel: function () {
			var owlCarousel = {
				data: {
					carousel: '.pnwt-owl-slider'
				},
				init: function (options) {
					$.extend(this.data, options);
					this.reinit();
				},
				reinit: function () {
					$(this.data.carousel).each(function () {
						var owl = $(this),
							itemPerLine = owl.data('items') || 5,
							itemLg = owl.data('items-lg') || 4,
							itemMd = owl.data('items-md') || 3,
							itemSm = owl.data('items-sm') || 2,
							itemXs = owl.data('items-xs') || 2,
							itemXxs = owl.data('items-xxs') || 1,
							itemAuto = owl.data('autoplay') || false,
							itemLoop = owl.data('infinite') || false,
							itemNav = owl.data('nav') || false,
							marGin = owl.data('margin') || 0,
							itemDots = owl.data('dots') || false,
							lazyLoader = pnWT.lazyLoader || false;
							owl.addClass('owl-carousel');
							owl.owlCarousel({
								autoplay:itemAuto,
								smartSpeed:500,
								margin:marGin,
								lazyLoad:true,
								rewind:true,
								loop:itemLoop,
								items:itemPerLine,
								dragClass:'owl-drag owl-theme',
								dots:itemDots,
								responsiveClass:true,
								navText:"",
								responsive:{
									0:{items:itemXxs},
									576:{items:itemXs},
									768:{items:itemSm},
									992:{items:itemMd},
									1200:{items:itemLg},
									1770:{items:itemPerLine},
								},
								nav:itemNav,
								pagination:false,
							});
							setTimeout( function(){
								owl.owlCarousel('refresh');
							}, 400 );
							
						
					});
				}
			}
			pnwt.pnwtOwlCarousel = Object.create(owlCarousel);
			pnwt.pnwtOwlCarousel.init({});
		},
		pnwtSlickCarousel: function () {
			var slickCarousel = {
				data: {
					carousel: '.pnwt-slick-slider'
				},
				init: function (options) {
					$.extend(this.data, options);
					if (w < maxSM && $(this.data.carousel).hasClass('js-product-isotope-sm')) {
						return false;
					}
					this.reinit();
				},
				reinit: function () {
					$('body').find(this.data.carousel).each(function () {
						var $this = $(this),
							arrowsplace;
						if (w < maxSM && $this.hasClass('js-product-isotope-sm')) {
							if ( $this.hasClass('slick-initialized')) {
								 $this.css({
									'height': ''
								}).slick('unslick');
							}
							return false;
						} else if ( $this.hasClass('slick-initialized')) {
							 $this.css({'height': ''}).slick('unslick');
						}
						if ($this.parent().find('.carousel-arrows').length) {
							arrowsplace = $this.parent().find('.carousel-arrows');
						} else if ($this.closest('.holder').find('.carousel-arrows').length) {
							arrowsplace = $this.closest('.holder').find('.carousel-arrows');
						}
						$this.on('beforeChange', function () {
							$this.find('.color-swatch').each(function () {
								$(this).find('.js-color-toggle').first().trigger('click');
							})
						});
						$this.on('init', function () {
							//pnwt.initialization.productWidth('.prd', $this);
							//pnwt.initialization.imageLoaded($('.prd.prd-has-loader', $this), true);
						})
						var items =  $this.data('items'),
							itemsMD =  $this.data('items-md') || 3,
							itemsSM =  $this.data('items-sm') || 2,
							itemsXS =  $this.data('items-xs') || 1;
						var slick = $this.slick({
							slidesToShow: items,
							slidesToScroll: 1,
							arrows: parseVal( $this.data('nav'), true ),
							dots: parseVal( $this.data('dots'), true ),
							appendArrows: arrowsplace,
							adaptiveHeight: true,
							infinite: parseVal( $this.data('infinite'), true ),
							autoplay: parseVal( $this.data('autoplay'), false ),
							autoplaySpeed: $this.data('autoplay-speed') || 1500,
							speed: 1000,
							centerMode: parseVal( $this.data('center-mode'), false ),
							variableWidth: parseVal( $this.data('variable-width'), false ),
							responsive: [
							{
								breakpoint: 1770,
								settings: {
									slidesToShow: items,
								}
							},
							{
								breakpoint: 992,
								settings: {
									slidesToShow: itemsMD,
								}
							},
							{
								breakpoint: 768,
								settings: {
									slidesToShow: itemsSM,
								}
							},
							{
								breakpoint: 576,
								settings: {
									slidesToShow: itemsXS,
									dots: false,
									slidesToShow: 1,
									fade: true,
									cssEase: 'linear',
									variableWidth: false,
								}
							},
							{
								breakpoint: 0,
								settings: {
									slidesToShow: 1,
									variableWidth: false,
								}
							}]
						});
					});
				}
			}
			pnwt.pnwtSlickCarousel = Object.create(slickCarousel);
			pnwt.pnwtSlickCarousel.init({});
		},
		masonryGrid: function() {
			$('.grid-loaded').imagesLoaded(function () {
				$('.masonry-filter').on('click', 'button', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({
					  filter: filterValue
					});
				});
				$('.masonry-filter button').on('click', function () {
					$('.masonry-filter button').removeClass('is-checked');
					$(this).addClass('is-checked');
					var selector = $(this).attr('data-filter');
					$grid.isotope({
					  filter: selector
					});
					return false;
				});
				var $grid = $('.masonry-wrap').isotope({
					itemSelector: '.masonry-image',
					percentPosition: true,
					transitionDuration: '0.7s',
					masonry: {
					  columnWidth: '.masonry-image',
					}
				});
				
			});
		},
	},
	pnwt.general = {
		init: function () {
		},
		preLoader: function () {
			var preloader = $('#loader-wrapper'),
			loader = preloader.find('.cssload-loader');
			loader.fadeOut();
			preloader.delay(400).fadeOut('slow');
		},
		scrollFromTop: function () {
			var b = $window.scrollTop();
			if( b > 80 ){		
				$(".wsmainfull, .wsmobileheader, .header-wrapper").addClass("scroll");
			} else {
				$(".wsmainfull, .wsmobileheader, .header-wrapper").removeClass("scroll");
			}
		},
		scrollUp: function ( options ) {
			var defaults = {
				scrollName: 'scrollUp', // Element ID
				topDistance: 600, // Distance from top before showing element (px)
				topSpeed: 800, // Speed back to top (ms)
				animation: 'fade', // Fade, slide, none
				animationInSpeed: 200, // Animation in speed (ms)
				animationOutSpeed: 200, // Animation out speed (ms)
				scrollText: '', // Text for element
				scrollImg: false, // Set true to use image
				activeOverlay: false // Set CSS color to display scrollUp active point, e.g '#00FFFF'
			};
			var o = $.extend({}, defaults, options),
				scrollId = '#' + o.scrollName;
			$('<a/>', {
				id: o.scrollName,
				href: '#top',
				title: o.scrollText
			}).appendTo('body');
			if (!o.scrollImg) {
				$(scrollId).text(o.scrollText);
			}
			$(scrollId).css({'display':'none','position': 'fixed','z-index': '99999'});
			if (o.activeOverlay) {
				$body.append("<div id='"+ o.scrollName +"-active'></div>");
				$(scrollId+"-active").css({ 'position': 'absolute', 'top': o.topDistance+'px', 'width': '100%', 'border-top': '1px dotted '+o.activeOverlay, 'z-index': '99999' });
			}
			$window.on('scroll', function(){	
				switch (o.animation) {
					case "fade":
						$( ($window.scrollTop() > o.topDistance) ? $(scrollId).fadeIn(o.animationInSpeed) : $(scrollId).fadeOut(o.animationOutSpeed) );
						break;
					case "slide":
						$( ($window.scrollTop() > o.topDistance) ? $(scrollId).slideDown(o.animationInSpeed) : $(scrollId).slideUp(o.animationOutSpeed) );
						break;
					default:
						$( ($window.scrollTop() > o.topDistance) ? $(scrollId).show(0) : $(scrollId).hide(0) );
				}
			});
			$(scrollId).on('click', function(event){
				$htmlBody.animate({scrollTop:0}, o.topSpeed);
				event.preventDefault();
			});
		},
	};
	pnwt.documentReady = {
		init: function () {
			pnwt.initialization.init();
			pnwt.general.scrollUp();
			pnwt.header.init();
			pnwt.sections.init();
		}
	};
	pnwt.documentLoad = {
		init: function () {
			pnwt.general.preLoader();
		}
	};
	pnwt.documentScroll = {
		init: function () {
			pnwt.general.scrollFromTop();
		}
	};
	
	var $body = $('body'),
		$htmlBody = $('html, body'),
		$window = $(window),
		$document = $(document),
		w = $window.innerWidth() || $window.width(),
		swipemode = false,
		maxXXS = 0,
		maxXS = 576,
		maxSM = 768,
		maxMD = 992,
		maxLG = 1200,
		maxXL = 1770,
		mobileMenuBreikpoint = 992,
		isMobile = w < mobileMenuBreikpoint;
		$document.on('ready', pnwt.documentReady.init);
		$window.on('load', pnwt.documentLoad.init);
		$window.on('scroll', pnwt.documentScroll.init);
		//$window.on('resize', pnwt.documentResize.init);
})(jQuery, window, document);