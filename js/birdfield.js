jQuery(function() {

	var headerimage_y = 0;

	jQuery( window ).load(function() {

		// home grid
		jQuery( "#blog ul li" ).tile( 3 );

		// header sliderer
		jQuery('.headerimage.slider').on('init',function(){
			jQuery('.headerimage.slider .slideitem').css({ 'display': 'block'});
		});

		jQuery('.headerimage.slider').slick({
			infinite: true,
			autoplaySpeed: 4000,
			speed: 1000,
			fade: true,
			cssEase: 'linear',
			autoplay: true,
		});

  		// Browser supports matchMedia
		if ( window.matchMedia ) {
			// MediaQueryList
			var mq = window.matchMedia( "( min-width: 930px )" );

			// MediaQueryListListener
			var birdfieldHeightCheck = function ( mq ) {
				if ( mq.matches ) {
					jQuery( "#blog ul li" ).tile(3);
				}
				else {
					jQuery( '#blog ul li' ).css( 'height', 'auto' );
				}
			};

			// Add listener
			mq.addListener( birdfieldHeightCheck );

			// Manually call listener
			birdfieldHeightCheck( mq );
		}
		else {
			// Browser doesn't support matchMedia
			jQuery( "#blog ul li" ).tile( 3 );
		}

		// gallery columns tile
		jQuery.each(  jQuery ( ' .gallery' ),  function(){
			gallery_class = jQuery( this ).attr( 'class' );
			gallery_columns = String(gallery_class.match( /gallery-columns-\d/ ));
			gallery_columns = gallery_columns.replace( 'gallery-columns-', '' );
				jQuery( this ).find( '.gallery-item').tile( parseInt( gallery_columns ));
		});

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
		var scrollTop = parseInt( jQuery( this ).scrollTop() );
		if ( scrollTop > 800 ) totop.fadeIn(); else totop.fadeOut();

		// Parallax
		if( jQuery('.wrapper[class*=parallax]').length ){
			var wall_max_height = parseInt( jQuery( '#wall' ).css( 'max-height' ));
			if( 600 == wall_max_height ){
				jQuery( '.fixedimage' ).css( 'background-position-y', 'calc( 50%' + ' + ' + scrollTop + 'px)');
			}
		}

		// mini header with scroll
		var header_clip = jQuery( '#header' ).css( 'clip' );
		if( -1 == header_clip.indexOf( 'rect' ) ) {
			if ( scrollTop > 200 ) {
				jQuery('.wrapper:not(.thin-navigation) #header').addClass('mini');
			}
			else {
				jQuery('.wrapper:not(.thin-navigation) #header').removeClass('mini');
			}
		}
	});

	// back to pagetop
	totop.click( function () {
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
}
