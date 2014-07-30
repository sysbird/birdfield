jQuery(function() {

	// Navigation for mobile
	jQuery( "#small-menu" ).click( function(){
		jQuery( "#menu-primary-items" ).slideToggle();
		jQuery( this ).toggleClass( "current" );
	});

	// back to pagetop
    var totop = jQuery( '#back-top' );
    totop.hide();
    jQuery( window ).scroll(function () {
        if ( jQuery( this ).scrollTop() > 800 ) totop.fadeIn(); else totop.fadeOut();
    });
    totop.click( function () {
        jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
    });

	// equalizing the height
	jQuery( window ).load(function() {

		// Masonry for Footer
		jQuery('#widget-area .container').masonry({
			itemSelector: '.widget',
			isAnimated: true
		});

		// Fixed Footer
		var widgetArea = jQuery( '#widget-area' ).height();
		var footerHeight = jQuery( '#footer' ).height();
		var height = parseInt( widgetArea ) + parseInt( footerHeight );
		jQuery('#content').css('padding-bottom', height + 'px' );
		jQuery('#footer').css('height', height + 'px' );

		// Equalize Height
		var equalize_toggle;
		var equalize_min_width = 930;

		function equalize_on(){
			jQuery( '#blog ul' ).equalize( 'height' );
			equalize_toggle = 1;
		}

		function equalize_off(){
			jQuery( '#blog ul li' ).css('height', 'auto');
			equalize_toggle = 0;
		}

		if(jQuery('html').width() >= equalize_min_width) {
			equalize_on();
		}

		jQuery(window).resize(function () {
			if(jQuery('html').width() < equalize_min_width) equalize_toggle ? equalize_off() : '';
				else equalize_on();
		});
	});

	// Fixed Menu
	var headerHeight = jQuery( '#header' ).height();
	headerHeight = parseInt( headerHeight );
	if(80 == headerHeight){
		// Parallax
		jQuery( window ).scroll(function(){
			var scrollTop = jQuery( this ).scrollTop();
			var headerHeight = jQuery( '#header' ).height();
			headerHeight = parseInt( headerHeight );
			jQuery( '.headerimage' ).css( 'top', parseInt( scrollTop) + 'px' );
		});
	}
	else{
		jQuery('.wrapper').removeClass('fixed-header');
	}
});
