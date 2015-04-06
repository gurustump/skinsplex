/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
var vidPlayer;
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {
	
	var win = $(window)
	/*
	* Let's fire off the gravatar function
	* You can remove this if you don't need it
	*/
	loadGravatars();
	
	win.resize(function () {
		waitForFinalEvent( function() {
			adminBarMove = $('#wpadminbar').outerHeight()-1;
			mobileDeviceBodyClass();
		}, timeToWaitForLast, 'resizeWindow');
	});
	
	function mobileDeviceType() {
		if (win.width() > 1024) {
			return false;
		} else if (win.width() < 768) {
			return 'mobile';
		} else {
			return 'tablet';
		}
	}
	function mobileDeviceBodyClass() {
		if (mobileDeviceType() == 'mobile') {
			$('body').addClass('mobile').removeClass('tablet');
		} else if (mobileDeviceType() == 'tablet') {
			$('body').addClass('tablet').removeClass('mobile');
		} else {
			$('body').removeClass('mobile tablet');
		}
	}
	mobileDeviceBodyClass();
	
	// Hide wp admin bar
	var adminBarMove = $('#wpadminbar').outerHeight()-1
	$('#wpadminbar').animate({
		'top':'-='+adminBarMove
	}, 2000,function() {
	}).hover(
		function(){
			$('#wpadminbar').stop().css('top','0').toggleClass('wpadminbar-shown');
		},
		function(){
			$('#wpadminbar').animate({
				'top':'-='+adminBarMove
			}, 2000).toggleClass('wpadminbar-shown');
		}
	).append('<div class="wpadminbar-activator"></div>');
	
	$('.TRIGGER_NAV').click(function(e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$('.MAIN_NAV').toggleClass('active');
	});
	
	$('.MAIN_NAV').on('click','a',function(e) {
		if (mobileDeviceType()) {
			$('.TRIGGER_NAV').click();
		}
	});
	$('.TRIGGER_SEARCH').click(function(e) {
		e.preventDefault();
		$('.TOP_NAV_SEARCH_FORM').addClass('active');
	});
	$('.TRIGGER_LOGIN').click(function(e) {
		e.preventDefault();
		$('.TOP_NAV_LOGIN_FORM').addClass('active');
	});
	$('.TRIGGER_LOGOUT').click(function(e) {
		e.preventDefault();
		$('.TOP_NAV_LOGOUT_FORM').addClass('active');
	});
	
	$('.OV_CLOSE').click(function(e) {
		e.preventDefault();
		$(this).parents('.OV').removeClass('active');
	});
	
	$(document).keyup(function(e) {
		//console.log(e.which);
		if (e.which == 27) {
			$('.OV').removeClass('active');
			$('.OV.ui-dialog-content').dialog('close');
		}
	})
	
    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        $('form#login p.status').show().text('Logging in, please wait...');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username').val(), 
                'password': $('form#login #password').val(), 
                'security': $('form#login #security').val()
			},
            success: function(data){
                $('form#login p.status').hide();
                $('form#login .OV_CLOSE').click();
				$('.TRIGGER_LOGIN').parent('li').addClass('inactive');
				$('.TRIGGER_LOGOUT').parent('li').removeClass('inactive');
                if (data.loggedin == true){
					//console.log(data)
					location.reload();
                    //document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });
	
    // Perform AJAX logout on form submit
    $('form#logout').on('submit', function(e){
        $('form#logout p.status').show().text('Logging out, please wait...');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogout', //calls wp_ajax_ajaxlogout
                'security': ajax_login_object.logout_nonce
			},
            success: function(data){
                $('form#logout p.status').hide();
                $('form#logout .OV_CLOSE').click();
				$('.TRIGGER_LOGOUT').parent('li').addClass('inactive');
				$('.TRIGGER_LOGIN').parent('li').removeClass('inactive');
                if (data.loggedout == true){
					//console.log(data)
                    //document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });
	
	var vidPlayers = []
	var vidPlayerOvs = []
	$('.VID_PLAYER').each(function(k,v) {
		vidPlayers[k] = videojs($(this).attr('id'), {
			/*'width':Math.min(1280,win.width()),
			'height':Math.min(720,win.height())*/
		});
		vidPlayerOvs[k] = $('.VID_PLAYER_OV')
		vidPlayerOvs[k].dialog({
			autoOpen:false,
			dialogClass:'vid-player-ov-container',
			open: function() {
				vidPlayer.play();
			},
			close: function() {
				vidPlayer.exitFullscreen().pause();
			}
		});
		/*$('.TRIGGER_VIDEO').click(function(e) {
			e.preventDefault();
			vidPlayerOv.dialog('open');
		});*/
	})
	
/*****************************************************
 Page specific scripts
*/
// Index (home & category) pages **************************
	if ( typeof is_index === "undefined" ) var is_index = $('body').hasClass('page-template-page-custom-index');
	
	if (is_index) {
		var thumbAnimation;
		var thumbAnimationRestart;
		$('.INDEX_BANNER').imgpreload();
		var gal = $('.BANNER_GALLERY');
		var thumbs = $('.THUMBNAIL_GALLERY');
		
		/* OWL NAV */
		function owlNavVisibility() {
			var allActive = true;
			$('.owl-item').each(function() {
				if (!$(this).hasClass('active')) {
					allActive = false;
					return false;
				}
			});
			if (allActive) {
				$('.owl-controls').addClass('inactive');
			} else {
				$('.owl-controls').removeClass('inactive');
			}
		}
		thumbs.owlCarousel({
			autoWidth:true,
			margin:0,
			nav:true,
			dots:false,
			loop:true,
			navText:['previous','next'],
			slideBy:2,
			responsive: {
				0: {
					items:2
				},
				480: {
					items:3
				},
				640: {
					items:4
				},
				800: {
					items:5
				},
				960: {
					items:6
				},
				1120: {
					items:7
				},
				1280: {
					items:8
				},
				1440: {
					items:9
				},
				1600: {
					items:10
				},
				1760: {
					items:11
				},
				1920: {
					items:12
				}
			},
			onInitialized:owlNavVisibility,
			onResized:owlNavVisibility
		});
		/* 
		// useful when owl carousel loop != true 
		thumbs.on('changed.owl.carousel', function(event) {
			owlNavVisibility(event);
		});
		function owlNavVisibility(event) {
			
			if (event.item.index == 0) {
				$(event.target).find('.owl-prev').removeClass('active');
			} else {
				$(event.target).find('.owl-prev').addClass('active');
			}
			if (event.item.count <= event.item.index + itemsCount()) {
				$(event.target).find('.owl-next').removeClass('active');
			} else {
				$(event.target).find('.owl-next').addClass('active');
			}
		} */
		function resizeBannerGallery() {
			if (mobileDeviceType() == 'mobile') {
				gal.css('height','auto');
			} else {
				gal.height(gal.width() * .4);
			}
		}
		function changeGalleryImage() {
			var delay = gal.hasClass('initialized') ? 275 : 0;
			gal.removeClass('initialized')
			setTimeout(function() {
				var activeThumb = thumbs.find('.THUMBNAIL_ITEM.active:first');
				activeThumb.find('.INDEX_BANNER').imgpreload(function() {
					gal.addClass('initialized');
				});
				gal.children('img').attr({
					'src':activeThumb.find('.INDEX_BANNER').attr('src'),
					'alt':activeThumb.find('.INDEX_BANNER').attr('alt'),
				});
				gal.find('.BANNER_HEADING h2, .LINK span').text(activeThumb.find('.INDEX_TITLE').text());
				gal.find('.BANNER_HEADING p').text(activeThumb.find('.INDEX_EXCERPT').text());
				gal.find('.LINK').attr('href',activeThumb.find('a').attr('href'));
				if (activeThumb.find('.INDEX_EXCERPT_LEFT').length > 0) {
					gal.children('.BANNER_HEADING').css('left',activeThumb.find('.INDEX_EXCERPT_LEFT').text()+'%');
				} else {
					gal.children('.BANNER_HEADING').css('left','10%');
				}
				if (activeThumb.find('.INDEX_EXCERPT_TOP').length > 0) {
					gal.children('.BANNER_HEADING').css('top',activeThumb.find('.INDEX_EXCERPT_TOP').text()+'%');
				} else {
					gal.children('.BANNER_HEADING').css('top','10%');
				}
				if (activeThumb.find('.INDEX_EXCERPT_TEXT_COLOR').length > 0) {
					gal.children('.BANNER_HEADING').css('color',activeThumb.find('.INDEX_EXCERPT_TEXT_COLOR').text());
				} else {
					gal.children('.BANNER_HEADING').css('color','#fff');
				}
			}, delay);
		}
		function selectThumb(selectedThumb,instigator) {
			$('.BANNER_NAV').removeClass('banner-active hit-zone-active');
			var current = thumbs.find('.THUMBNAIL_ITEM.active:first');
			if (!selectedThumb) {
				var selectedThumb = (instigator && instigator.hasClass('PREV')) ? (current.parents('.owl-item').prev().length > 0 ? current.parents('.owl-item').prev().find('.THUMBNAIL_ITEM') : current.parents('.owl-item').siblings().last().find('.THUMBNAIL_ITEM')) : (current.parents('.owl-item').next().length > 0 ? current.parents('.owl-item').next().find('.THUMBNAIL_ITEM') : current.parents('.owl-item').siblings().first().find('.THUMBNAIL_ITEM'))
			}
			current.removeClass('active');
			selectedThumb.addClass('active');
			if (!selectedThumb.parent('.owl-item').hasClass('active')) {
				if (instigator && instigator.hasClass('PREV')) {
					thumbs.trigger('prev.owl.carousel');
				} else {
					thumbs.trigger('next.owl.carousel');
				}
			}
			changeGalleryImage();
		}
		function initiateThumbAnimation() {
			clearInterval(thumbAnimation);
			thumbAnimation = setInterval(function() {
				selectThumb()
			}, 5000);
		}
		function pauseThumbAnimation() {
			clearInterval(thumbAnimation);
			clearInterval(thumbAnimationRestart);
			thumbAnimationRestart = setTimeout(function() {
				initiateThumbAnimation();
			}, 30000);
		}
		
		resizeBannerGallery();
		changeGalleryImage();
	
		win.resize(function () {
			waitForFinalEvent( function() {
				resizeBannerGallery();
			}, timeToWaitForLast, 'resizeIndex');
		});
		
		thumbs.find('a').click(function(e) {
			e.preventDefault();
			pauseThumbAnimation();
			selectThumb($(this).parents('.THUMBNAIL_ITEM'));
		});
		
		gal.find('.BANNER_NAV a:not(.LINK)').click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			pauseThumbAnimation();
			selectThumb(false,$(this));
		})
		initiateThumbAnimation();
		
		$('.BANNER_NAV').click(function() {
			$(this).toggleClass('banner-active');
			pauseThumbAnimation();
		});
		$('.HIT_ZONE').hover(function() {
			$('.BANNER_NAV').addClass('hit-zone-active');
			pauseThumbAnimation();
		},function() {
			$('.BANNER_NAV').removeClass('hit-zone-active');
			//initiateThumbAnimation();
		});
	}
// Index (home & category) pages **************************
	if ( typeof is_single_media_item === "undefined" ) var is_single_media_item = $('body').hasClass('single-media_items');
	
	if (is_single_media_item) {
		if ($('#vidPlayer').length > 0) {
			var vidPlayer = videojs('vidPlayer', {
				/*'width':Math.min(1280,win.width()),
				'height':Math.min(720,win.height())*/
			});
			var vidPlayerOv = $('.VID_PLAYER_OV')
			vidPlayerOv.dialog({
				autoOpen:false,
				dialogClass:'vid-player-ov-container',
				open: function() {
					vidPlayer.play();
				},
				close: function() {
					vidPlayer.exitFullscreen().pause();
				}
			});
			$('.TRIGGER_VIDEO').click(function(e) {
				e.preventDefault();
				vidPlayerOv.dialog('open');
			});
		}
	}

}); /* end of as page load scripts */
