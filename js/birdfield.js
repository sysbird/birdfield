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

	// back to pagetop
    var totop = jQuery( '#back-top' );
    totop.hide();
    jQuery( window ).scroll(function () {
        if ( jQuery( this ).scrollTop() > 800 ) totop.fadeIn(); else totop.fadeOut();
    });
    totop.click( function () {
        jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
    });

	// Fixed Menu
	var headerHeight = jQuery( '#header' ).height();
	headerHeight = parseInt( headerHeight );
	if( 80 == headerHeight ){
		// Parallax
		jQuery( window ).scroll( function(){
			var scrollTop = jQuery( this ).scrollTop();
			var headerHeight = jQuery( '#header' ).height();
			headerHeight = parseInt( headerHeight );
			jQuery( '.headerimage' ).css( 'top', parseInt( scrollTop ) + 'px' );
		});
	}
	else{
		jQuery( '.wrapper' ).removeClass( 'fixed-header' );
	}
});
