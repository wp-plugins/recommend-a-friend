jQuery(function() {

	fancySetup();
});

function fancySetup(){
	/* This is basic - uses default settings */
	jQuery("a.raf_link").fancybox({
		'transitionIn'	:	'fade',
		'transitionOut'	:	'fade',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false,
		'autoDimensions':	false,
		'width'			:	800,
		'height'		:	'100%',
		'autoDimensions':	true,
		'centerOnScroll':	true,
		'titleShow' : false
	});
}