<?php
/**
 * The template functions and definitions
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
//////////////////////////////////////////
// Set the content width based on the theme's design and stylesheet.
function birdfield_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'birdfield_content_width', 930 );
}
add_action( 'template_redirect', 'birdfield_content_width' );

//////////////////////////////////////////
// Customizer additions.
require get_template_directory() . '/functions_customizer.php';

//////////////////////////////////////////
// Set Widgets
function birdfield_widgets_init() {

	register_sidebar( array (
		'name'			=> __( 'Widget Area for header', 'birdfield' ),
		'id'			=> 'widget-area-header',
		'description'	=> __( 'One text widget for header', 'birdfield' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
		) );

	register_sidebar( array (
		'name'			=> __( 'Widget Area for footer', 'birdfield' ),
		'id'			=> 'widget-area-footer',
		'description'	=> __( 'Widget Area for footer', 'birdfield' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'	=> '</div>',
		'before_title'	=> '<h3>',
		'after_title'	=> '</h3>',
		) );
}
add_action( 'widgets_init', 'birdfield_widgets_init' );

//////////////////////////////////////////////////////
// Header markup
function birdfield_wrapper_class() {

	$birdfield_class = 'wrapper fixed-header';

	if ( 'blank' == get_header_textcolor()) {
		$birdfield_class .= ' no-title';
	}

	if ( !has_nav_menu( 'primary' )) {
		$birdfield_class .= ' no-nav-menu';
	}

	echo 'class="' .$birdfield_class .'"';
}

//////////////////////////////////////////////////////
// Copyright Year
function birdfield_get_copyright_year() {

	$birdfield_copyright_year = date("Y");

	$birdfield_first_year = $birdfield_copyright_year;
	$args = array(
		'numberposts'	=> 1,
		'orderby'		=> 'post_date',
		'order'			=> 'ASC',
	);
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$birdfield_first_year = mysql2date( 'Y', $post->post_date, true );
	}

	if( $birdfield_copyright_year <> $birdfield_first_year ){
		$birdfield_copyright_year = $birdfield_first_year .' - ' .$birdfield_copyright_year;
	}

	return $birdfield_copyright_year;
}

//////////////////////////////////////////////////////
// Setup Theme
if ( ! function_exists( 'birdfield_setup' ) ) :
function birdfield_setup() {

	// Set languages
	load_theme_textdomain( 'birdfield', get_template_directory() . '/languages' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );

	// Set feed
	add_theme_support( 'automatic-feed-links' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-image'		=> '',
		'default-color'		=> 'FFF',
		'wp-head-callback'	=> 'birdfield_custom_background_cb',
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Navigation Menu', 'birdfield' ),
	) );

	// Add support for title tag.
	add_theme_support( 'title-tag' );

	// Add support for custom headers.
	$custom_header_support = array(
		'default-image'			=> '%s/images/header.jpg',
		'height'				=> 900,
		'width'					=> 1280,
		'max-width'				=> 900,
		'random-default'		=> true,
	);

	// Add support for custom headers.
	add_theme_support( 'custom-header', $custom_header_support );

	register_default_headers( array(
		'birdfield'		=> array(
		'url'			=> '%s/images/header.jpg',
		'thumbnail_url'	=> '%s/images/header-thumbnail.jpg',
		'description'	=> 'birdfield'
		)
	) );

	// Add support for news content.
	add_theme_support( 'news-content', array(
		'news_content_filter'	=> 'birdfield_get_news_posts',
		'max_posts'				=> 5,
	) );
}
endif; // birdfield_setup
add_action( 'after_setup_theme', 'birdfield_setup' );

//////////////////////////////////////////////////////
// Filter the news posts to return
function birdfield_get_news_posts(){
	$array = get_posts(array(
		'tag_slug__in'	=> 'news',
		'numberposts'	=> 5
	));

	return $array;
}
add_filter( 'birdfield_get_news_posts', 'birdfield_get_news_posts', 100 );

//////////////////////////////////////////////////////
// Filter home and the news posts that returns a boolean value.
function birdfield_has_news_posts() {
	return ! is_paged() && ( bool ) birdfield_get_news_posts();
}

//////////////////////////////////////////////////////
// Filter main query at home
function birdfield_home_query( $query ) {
 	if ( $query->is_home() && $query->is_main_query() ) {
		$birdfield_news = get_term_by( 'name', 'news', 'post_tag' );
		if( $birdfield_news ){
			$query->set( 'tag__not_in', $birdfield_news->term_id );
		}
	}
}
add_action( 'pre_get_posts', 'birdfield_home_query' );

//////////////////////////////////////////////////////
// Enqueue Scripts
function birdfield_scripts() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'jquerytile', get_template_directory_uri() .'/js/jquery.tile.js', 'jquery', '1.1.2' );
	wp_enqueue_script( 'birdfield', get_template_directory_uri() .'/js/birdfield.js', array( 'jquery' , 'jquery-masonry', 'jquerytile' ), '1.12' );
	wp_enqueue_style( 'birdfield-google-font', '//fonts.googleapis.com/css?family=Raleway', false, null, 'all' );
	wp_enqueue_style( 'birdfield', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'birdfield_scripts' );

//////////////////////////////////////////////////////
// Theme Customizer
function birdfield_customize( $wp_customize ) {

	// defaut colors
	$birdfield_default_colors = birdfield_get_default_colors();

	// Text Color
	$wp_customize->add_setting( 'birdfield_text_color',
		array(
			'default'			=> '#222327',
			'sanitize_callback'	=> 'maybe_hash_hex_color',
		));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_text_color',
		array(
			'label'		=> __( 'Text Color', 'birdfield' ),
			'section'	=> 'colors',
			'settings'	=> 'birdfield_text_color',
		)));

	// Link Color
	$wp_customize->add_setting( 'birdfield_link_color',
		array(
			'default' 			=> '#1c4bbe',
			'sanitize_callback'	=> 'maybe_hash_hex_color',
		));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_link_color',
		array(
			'label'		=> __( 'Link Color', 'birdfield' ),
			'section'	=> 'colors',
			'settings'	=> 'birdfield_link_color',
		)));

	// Header, Footer Background Color
	$wp_customize->add_setting( 'birdfield_header_color',
		array(
			'default'			=> '#79a596',
			'sanitize_callback'	=> 'maybe_hash_hex_color',
		));

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_header_color',
		array(
			'label'		=> __( 'Header, Footer Background Color', 'birdfield' ),
			'section'	=> 'colors',
			'settings'	=> 'birdfield_header_color',
		)));

	// Footer Section
	$wp_customize->add_section( 'birdfield_customize',
		array(
			'title'		=> __( 'Footer', 'birdfield' ),
			'priority'	=> 62,
		));

	// Display Copyright
	$wp_customize->add_setting( 'birdfield_copyright',
		array(
			'default'			=> true,
			'sanitize_callback'	=> 'birdfield_sanitize_checkbox',
		));

	$wp_customize->add_control( 'birdfield_copyright',
		array(
			'label'		=> __( 'Display Copyright', 'birdfield' ),
			'section'	=> 'birdfield_customize',
			'type'		=> 'checkbox',
			'settings'	=> 'birdfield_copyright',
		));

	// Display Credit
	$wp_customize->add_setting( 'birdfield_credit',
		array(
			'default'			=> true,
			'sanitize_callback'	=> 'birdfield_sanitize_checkbox',
		));

	$wp_customize->add_control( 'birdfield_credit',
		array(
			'label'		=> __( 'Display Credit', 'birdfield' ),
			'section'	=> 'birdfield_customize',
			'type'		=> 'checkbox',
			'settings'	=> 'birdfield_credit',
		));
}
add_action( 'customize_register', 'birdfield_customize' );

//////////////////////////////////////////////////////
// Santize a checkbox
function birdfield_sanitize_checkbox( $input ) {

	if ( $input == true ) {
		return true;
	} else {
		return false;
	}
}

///////////////////////////////////////////////////////
// Sanitize text
function birdfield_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

//////////////////////////////////////////////////////
// Get default colors
function birdfield_get_default_colors() {
	return array( 'header_text_color'	=> '#ffffff',
			'header_color'				=> '#79a596',
			'text_color'				=> '#222327',
			'link_color'				=> '#1c4bbe' );
}

//////////////////////////////////////////////////////
// Enqueues front-end CSS for the Theme Customizer.
function birdfield_color_css() {

	// default color
	$birdfield_default_colors = birdfield_get_default_colors();

	// Custom Header Text Color
	$birdfield_header_text_color = get_header_textcolor();

	if( !empty( $birdfield_header_text_color ) && strcasecmp( $birdfield_header_text_color, trim( $birdfield_default_colors[ 'header_text_color' ], '#' ))) {
		$birdfield_css = "
			/* Custom Header Text Color */
			#header #branding #site-title,
			#header #branding #site-title a,
			#header #branding #site-description,
			#menu-wrapper .menu ul#menu-primary-items li a,
			#menu-wrapper .menu #small-menu,
			#widget-area .widget,
			#footer,
			#footer a {
				color: #{$birdfield_header_text_color};
			}

			#menu-wrapper .menu ul#menu-primary-items li a {
				border-color: #{$birdfield_header_text_color};
			}

			#menu-wrapper .menu #small-menu .icon,
			#menu-wrapper .menu #small-menu .icon:before,
			#menu-wrapper .menu #small-menu .icon:after {
				background-color: #{$birdfield_header_text_color};
			}

			@media screen and (min-width: 930px) {
				#menu-wrapper .menu ul#menu-primary-items li a:hover {
					background-color: #{$birdfield_header_text_color};
				}

				#menu-wrapper .menu ul#menu-primary-items li ul li a,
				#menu-wrapper .menu ul#menu-primary-items li ul li:first-child a {
					border-color: #{$birdfield_header_text_color};
				}
			}
			";

		wp_add_inline_style( 'birdfield', $birdfield_css );
	}

	// Custom Text Color
	$birdfield_text_color = get_theme_mod( 'birdfield_text_color', $birdfield_default_colors[ 'text_color' ] );
	if( strcasecmp( $birdfield_text_color, $birdfield_default_colors[ 'text_color' ] )) {
		$birdfield_css = "
			/* Custom Text Color */
			.wrapper,
			.home #content #blog ul.article .hentry .entry-header .entry-title,
			.archive #content ul.list li a .entry-content,
			.search #content ul.list li a .entry-content {
				color: {$birdfield_text_color};
			}
		";

		wp_add_inline_style( 'birdfield', $birdfield_css );
	}

	// Custom Link Color
	$birdfield_link_color = get_theme_mod( 'birdfield_link_color', $birdfield_default_colors[ 'link_color' ] );
	if( strcasecmp( $birdfield_link_color, $birdfield_default_colors[ 'link_color' ] )) {
		$birdfield_css = "
			/* Custom Link Color */
			a,
			#content .pagination a.page-numbers,
			#content .pagination .more-link,
			#content .hentry .page-links,
			#content .hentry .page-links a span,
			.home #content #news ul.article li .entry-header .entry-title,
			.archive #content ul.list li .entry-header .entry-title,
			.search #content ul.list li .entry-header .entry-title {
				color: {$birdfield_link_color};
			}

			#content .pagination a.page-numbers,
			#content .pagination .current,
			#content .hentry .page-links span,
			#content .hentry .page-links a span {
				border-color: {$birdfield_link_color};
			}

			#content .pagination .current,
			#content .hentry .page-links span {
				background-color: {$birdfield_link_color};
			}
		";

		wp_add_inline_style( 'birdfield', $birdfield_css );
	}

	// Custom Header, Footer Background Color
	$birdfield_header_color = get_theme_mod( 'birdfield_header_color', $birdfield_default_colors[ 'header_color' ] );
	if( strcasecmp( $birdfield_header_color, $birdfield_default_colors[ 'header_color' ] )) {
		$birdfield_header_color_rgb = birdfield_hex2rgb( $birdfield_header_color );
		$birdfield_css = "
			/* Custom Header, Footer Background Color */
			#header,
			#footer,
			#widget-area,
			.home #content #blog ul.article .hentry.sticky i span {
				background-color: {$birdfield_header_color};
			}

			#header.mini {
				background-color: rgba( {$birdfield_header_color_rgb}, 0.9 );
			}

			#content .hentry .entry-header .entry-title,
			#content .hentry .content-header .content-title,
			.home #about .widget h3,
			.home #content h2,
			.home #content #blog ul.article .hentry.sticky .entry-header .entry-title,
			.blog #content #blog ul.article .hentry.sticky .entry-header .entry-title,
			#content h1,
			#content h2,
			#content h3,
			#content h4,
			#content h5,
			#content h6,
			#content #comments ol.commentlist li.pingback.bypostauthor .comment-author,
			#content #comments ol.commentlist li.comment.bypostauthor .comment-author,
			#widget-area .widget #wp-calendar tbody th a,
			#widget-area .widget #wp-calendar tbody td a {
				color: {$birdfield_header_color};
			}

			#content h2,
			#content h3 {
				border-color: {$birdfield_header_color};
			}

			@media screen and (min-width: 930px) {
				#menu-wrapper .menu ul#menu-primary-items li a:hover {
					color: {$birdfield_header_color};
				}

				#menu-wrapper .menu ul#menu-primary-items li ul li a:hover {
					border-color: {$birdfield_header_color};
				}

				#menu-wrapper .menu ul#menu-primary-items li ul li a {
					background-color: {$birdfield_header_color};
				}
			}
		";

		wp_add_inline_style( 'birdfield', $birdfield_css );
	}
}
add_action( 'wp_enqueue_scripts', 'birdfield_color_css', 11 );

//////////////////////////////////////////////////////
// Excerpt More
function birdfield_excerpt_more($more) {
	return '<span class="more-link">' .__( 'Continue reading', 'birdfield' ) . '</span>';
}
add_filter('excerpt_more', 'birdfield_excerpt_more');

//////////////////////////////////////////////////////
// Removing the default gallery style
function birdfield_gallery_atts( $out, $pairs, $atts ) {

	$atts = shortcode_atts( array( 'size' => 'medium', ), $atts );
	$out['size'] = $atts['size'];

	return $out;
}
add_filter( 'shortcode_atts_gallery', 'birdfield_gallery_atts', 10, 3 );
add_filter( 'use_default_gallery_style', '__return_false' );

//////////////////////////////////////////////////////
// Custom Background callback
function birdfield_custom_background_cb() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		$style .= $image . $repeat . $position . $attachment;
	}
?>
<style type="text/css" id="custom-background-css">
	body.custom-background.home #content #news,
	body.custom-background.home #content #blog,
	body.custom-background .wrapper {
		<?php echo trim( $style ); ?>
		}
</style>
<?php
}

//////////////////////////////////////////////////////
// Add hook content begin
function birdfield_content_header() {
	$birdfield_html = apply_filters( 'birdfield_content_header', '' );
	echo $birdfield_html;
}

//////////////////////////////////////////////////////
// Add hook content end
function birdfield_content_footer() {
	$birdfield_html = apply_filters( 'birdfield_content_footer', '' );
	echo $birdfield_html;
}

//////////////////////////////////////////////////////
// hex color to rgb
function birdfield_hex2rgb ( $hex ) {

	$birdfield_hex = preg_replace('/#/', '', $hex);

	$birdfield_hex_rgba = hexdec(substr($birdfield_hex, 0, 2));
	$birdfield_hex_rgba .= ', ' .hexdec(substr($birdfield_hex, 2, 2));
	$birdfield_hex_rgba .= ', ' .hexdec(substr($birdfield_hex, 4, 2));

	return $birdfield_hex_rgba;
}

//////////////////////////////////////////////////////
// Header Slider
if ( ! function_exists( 'birdfield_headerslider' )) :
function birdfield_headerslider() {

	if (( !is_front_page())) {
		return false;
	}

	if( !get_theme_mod( 'use_slider', false ) ){
		return false;
	}

	$birdfield_interval = get_theme_mod( 'slide_interval', 7000 );
	if( 0 == $birdfield_interval){
		$birdfield_interval = 7000;
	}

	// get headerslide option
	$birdfield_slides = array();
	$birdfield_max = 0;

	for( $birdfield_count = 1; $birdfield_count <= 5; $birdfield_count++ ) {
		$birdfield_default_image = '';
		$birdfield_default_title = '';
		$birdfield_default_description = '';
		$birdfield_default_link = '';

		if( 1 == $birdfield_count ){
			$birdfield_default_image = get_template_directory_uri() . '/images/header.jpg';
			$birdfield_default_title =  __( 'Hello world!','birdfield' );
			$birdfield_default_description = __( 'Begin your website.', 'birdfield' );
			$birdfield_default_link = '#';
		}

		$birdfield_image = get_theme_mod( 'slider_image_' .strval( $birdfield_count ), $birdfield_default_image );
		if ( ! empty( $birdfield_image )) {
			$birdfield_slides[ $birdfield_count -1 ][ 'image' ] = $birdfield_image;
			$birdfield_slides[ $birdfield_count -1 ][ 'title' ] = get_theme_mod( 'slider_title_' . strval( $birdfield_count ), $birdfield_default_title );
			$birdfield_slides[ $birdfield_count -1 ][ 'description' ] = get_theme_mod( 'slider_description_' . strval( $birdfield_count ), $birdfield_default_description );
			$birdfield_slides[$birdfield_count -1 ][ 'link' ] = get_theme_mod( 'slider_link_' . strval( $birdfield_count ), $birdfield_default_link );

			$birdfield_max++;
		}
		else{
			break;
		}
	}

	if( !$birdfield_max ){
		return false;
	}

	if( 1 < $birdfield_max ){
		$birdfield_interval = 'data-interval="' .$birdfield_interval .'"';
	}
	else{
		$birdfield_interval = '';
	}

?>
	<section id="wall">
		<div class="headerimage slider" <?php echo $birdfield_interval; ?>>

<?php
	// sort randam
	$birdfield_html = '';
	$birdfield_start = mt_rand( 1, $birdfield_max );
	for( $birdfield_count = 1; $birdfield_count <= $birdfield_max; $birdfield_count++ ) {
			$birdfield_class = '';
			if( $birdfield_start == $birdfield_count ){
				$birdfield_class = ' start active';
			}

			$birdfield_html .= '<div class="slideitem' .$birdfield_class .'" id="slideitem_' .$birdfield_count .'">';
			$birdfield_html .= '<div class="fixedimage" style="background-image: url(' .$birdfield_slides[ $birdfield_count -1 ][ 'image' ] .')"></div>';
			$birdfield_html .= '<div class="caption">';
			$birdfield_html .= '<p><strong>' .$birdfield_slides[ $birdfield_count -1 ][ 'title' ] .'</strong><span>' .$birdfield_slides[ $birdfield_count -1 ][ 'description' ] .'</span></p>';
			if( ! empty( $birdfield_slides[ $birdfield_count -1 ][ 'link' ] )){
				$birdfield_html .= '<a href="' .$birdfield_slides[ $birdfield_count -1 ][ 'link' ] .'">' .__( 'More', 'birdfield' ) .'</a>';
			}
			$birdfield_html .= '</div>';
			$birdfield_html .= '</div>';
	}

	echo $birdfield_html;
?>
		</div>
	</section>

<?php
	return true;
}
endif;