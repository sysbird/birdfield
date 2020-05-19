////////////////////////////////////////
// File birdfield.js.
jQuery(function() {

	jQuery( window ).load(function() {

        var headerHeight = parseInt( jQuery( '#header' ).height() );
        if( 81 < headerHeight ){
            // so many Navigation
            jQuery( '.wrapper' ).removeClass( 'fixed-header' );
        }

        // Header Slider
        jQuery('.slider[data-interval]').birdfield_Slider();

		// gallery columns tile
		jQuery.each(  jQuery ( '.gallery' ),  function(){
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
        jQuery( "#menu-wrapper" ).slideToggle();
		jQuery( this ).toggleClass( "current" );
	});

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
                jQuery('.wrapper.fixed-header #header').addClass('mini');
			}
			else {
                jQuery('.wrapper.fixed-header #header').removeClass('mini');
			}
		}
	});

    // Browser supports matchMedia and Header Image
    const birdfield_mql = window.matchMedia('(min-width: 930px)');
    const birdfield_handleMediaQuery = function (birdfield_mql) {
        if (birdfield_mql.matches) {
            // PC
            jQuery('#wall').birdfield_resize_Wall(false);
        } else {
            // mobile
            jQuery('#wall').birdfield_resize_Wall(true);
        }
    };

    birdfield_mql.addListener(birdfield_handleMediaQuery);
    birdfield_handleMediaQuery(birdfield_mql);

    // back to pagetop
	totop.click( function () {
		jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
	});
});

////////////////////////////////////////
// Header Slider
jQuery.fn.birdfield_Slider = function () {

    return this.each(function (i, elem) {

        var birdfield_interval = jQuery('.slider').attr('data-interval');

        // init slider
        if (1 < jQuery('.slideitem').length) {
            setInterval(function () {

                index = jQuery('.slideitem.active').index('.slideitem');
                index++;
                if (index >= jQuery('.slideitem').length) {
                    index = 0;
                }

                // fade parseIn
                jQuery('.slideitem:eq(' + index + ')').fadeIn(1000, function () {

                    // resize slider
                    var height = birdfield_get_slider_height(this, -1);
                    jQuery('.headerimage').css({ 'padding-top': height });

                    // fade out
                    jQuery('.slideitem.active').fadeOut(500);
                    jQuery('.slideitem.start').removeClass('start');
                    jQuery('.slideitem.active').removeClass('active');
                    jQuery('.slideitem:eq(' + index + ')').addClass('active');
                });
            }, birdfield_interval);
        }
    });
};

////////////////////////////////////////
// resize Header Image or Slider
jQuery.fn.birdfield_resize_Wall = function (is_mobile) {

    return this.each(function (i, elem) {

        if (jQuery('.slider[data-interval]').length) {
            // Slider
            jQuery('.slideitem').each(function (index, element) {
                var height = birdfield_get_slider_height(this, is_mobile);
                jQuery(this).children('.fixedimage').css({ 'padding-top': height });

                if (jQuery(this).hasClass('active')){
                    jQuery('.headerimage').css({ 'padding-top': height });
                }                
            });            
        }
        else if (jQuery('#wall img').length){
            // Image
            var height = birdfield_get_slider_height(jQuery('#wall'), is_mobile);
            jQuery('.fixedimage').css({ 'padding-top': height });
            jQuery('.headerimage').css({ 'padding-top': height });
        }
    });
}

////////////////////////////////////////
// get slideritem height
function birdfield_get_slider_height(elem, is_mobile) {

    if (0 > is_mobile){
        if (930 <= jQuery('#wall').width()){
            is_mobile = 0;
        }
    }

    ratio = jQuery(elem).find('img').attr('ratio');
    var height = jQuery('#wall').width() * parseInt(ratio) / 100;
    if (!is_mobile && 650 < height) {
        height = '650px';
    }
    else {
        height = ratio;
    }

    return height;
};
