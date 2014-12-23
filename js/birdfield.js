jQuery(function() {

	jQuery( window ).load(function() {

		jQuery( "#blog ul li" ).tile( 3 );

	    // Browser supports matchMedia
	    if ( window.matchMedia ) {

	        // MediaQueryList
	        var mq = window.matchMedia( "( min-width: 930px )" );

	        // MediaQueryListListener
	        var birdfieldHeightCheck = function ( mq ) {
	            if ( mq.matches ) {
					jQuery( "#blog ul li" ).tile(3);
	            } else {
					jQuery( '#blog ul li' ).css( 'height', 'auto' );
	            }
	        };

	        // Add listener
	        mq.addListener( birdfieldHeightCheck );

	        // Manually call listener
	        birdfieldHeightCheck( mq );
	    }

	    // Browser doesn't support matchMedia
	    else {
			jQuery( "#blog ul li" ).tile( 3 );
	    }

		// Masonry for Footer
		jQuery( '#widget-area .container' ).masonry({
			itemSelector: '.widget',
			isAnimated: true
		});

		// Fixed Footer
		var widgetArea = jQuery( '#widget-area' ).height();
		var footerHeight = jQuery( '#footer .site-title' ).innerHeight();
		var height = parseInt( widgetArea ) + parseInt( footerHeight );
		jQuery('#content').css('padding-bottom', height + 'px' );
		jQuery('#footer').css('height', height + 'px' );
	});

	// Navigation for mobile
	jQuery( "#small-menu" ).click( function(){
		jQuery( "#menu-primary-items" ).slideToggle();
		jQuery( this ).toggleClass( "current" );
	});

	// Fixed Navigation
	birdfield_AdjustHeader();

	// Window Resize
	var timer = false;
	jQuery(window).resize(function() {
	    if (timer !== false) {
	        clearTimeout(timer);
	    }
	    timer = setTimeout(function() {
			birdfield_AdjustHeader();
	    }, 200);
	});

	// Windows Scroll
    var totop = jQuery( '#back-top' );
    totop.hide();
    jQuery( window ).scroll(function () {
		// back to pagetop
        if ( jQuery( this ).scrollTop() > 800 ) totop.fadeIn(); else totop.fadeOut();

		// Parallax
		if( jQuery('.wrapper[class*=parallax]').length ){
			var scrollTop = parseInt( jQuery( this ).scrollTop() );
			var top = 0;

			if( jQuery('.wrapper[class*=fixed-header]').length ){
				top = scrollTop;
			}
			else{
				var headerHeight = parseInt( jQuery( '#header' ).height() );
				if(scrollTop > headerHeight){
					top = scrollTop - headerHeight;
				}

			}

			jQuery( '.headerimage' ).css( 'top', top + 'px' );
		}
    });

    totop.click( function () {
		// back to pagetop
        jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
    });

});

////////////////////////////////////////
// Adjust Header height
function birdfield_AdjustHeader() {

	var headerHeight = parseInt( jQuery( '#header' ).height() );
	if( 80 < headerHeight ){
		// Long Navigation
		jQuery( '.wrapper' ).addClass( 'thin-navigation' );
	}

	if( jQuery( '#small-menu' ).is( ':visible' ) ){
		// Wide Display
		jQuery( '.fixed-header #content' ).css( 'margin-top', '' );
	}
	else{
		// Small Display
		headerHeight = parseInt( jQuery( '#header' ).height() );
		jQuery( '.fixed-header #content' ).css( 'margin-top', headerHeight + 'px' );
	}
}
