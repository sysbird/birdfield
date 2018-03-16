////////////////////////////////////////
// File birdfield.js.
jQuery(function() {

	jQuery( window ).load(function() {

		// home grid
		jQuery( "#blog ul li" ).tile( 3 );

		// Browser supports matchMedia
		if ( window.matchMedia ) {
			// MediaQueryList
			var mq = window.matchMedia( "( min-width: 930px )" );

			// MediaQueryListListener
			var birdfieldHeightCheck = function ( mq ) {
				if ( mq.matches ) {
					// tile for home
					jQuery( "#blog ul li" ).tile(3);
				}
				else {
					// cansel
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

		// Header Slider
		jQuery( '.slider').birdfield_Slider();

		// gallery columns tile
		jQuery.each(  jQuery ( ' .gallery' ),  function(){
			gallery_class = jQuery( this ).attr( 'class' );
			gallery_columns = String(gallery_class.match( /gallery-columns-\d/ ));
			gallery_columns = gallery_columns.replace( 'gallery-columns-', '' );
				jQuery( this ).find( '.gallery-item').tile( parseInt( gallery_columns ));
			});

		// Masonry for footer widget area
		jQuery( '#widget-area .container' ).masonry({
				itemSelector: '.widget',
				isAnimated: true
			});
	});

	// Navigation for mobile
	jQuery( "#small-menu" ).click( function(){
		jQuery( "#menu-primary-items" ).slideToggle();
		jQuery( this ).toggleClass( "current" );
	});

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
	birdfield_AdjustHeader();

	// Windows Scroll
	var totop = jQuery( '#back-top' );
	totop.hide();
	jQuery( window ).scroll(function () {
		// back to pagetop
		var scrollTop = parseInt( jQuery( this ).scrollTop() );
		if ( scrollTop > 800 ) totop.fadeIn(); else totop.fadeOut();

		// mini header with scroll
		var header_clip = jQuery( '#header' ).css( 'clip' );
		if( -1 == header_clip.indexOf( 'rect' ) ) {
			if ( scrollTop > 200 ) {
				jQuery('.fixed-header .wrapper:not(.thin-navigation) #header').addClass('mini');
			}
			else {
				jQuery('.fixed-header .wrapper:not(.thin-navigation) #header').removeClass('mini');
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
	else{
		jQuery( '.wrapper' ).removeClass( 'thin-navigation' );
	}
}

////////////////////////////////////////
// Header Slider
jQuery.fn.birdfield_Slider = function(){
	return this.each(function(i, elem) {

		// change slide
		var index = 0;
		if( 0 < jQuery('.slideitem.active').length ){
			index = jQuery('.slideitem.active').index( '.slideitem' );
			index++;
			if( index >= jQuery('.slideitem' ).length ){
				index = 0;
			}
		}

		jQuery( '.slideitem.active' ).fadeOut( 1000 );
		jQuery('.slideitem:eq(' + index + ')').fadeIn( 1000 );
		var birdfield_interval = jQuery( '.slider' ).attr( 'data-interval' );
		setTimeout(function(){
			jQuery( '.slider' ).birdfield_Slider();
			jQuery('.slideitem.active').removeClass( 'active' );
			jQuery('.slideitem:eq(' + index + ')').addClass( 'active' );

		}, birdfield_interval );
	});
};
