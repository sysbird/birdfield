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
	global $content_width;
	$content_width = 930;
}
add_action( 'template_redirect', 'birdfield_content_width' );

//////////////////////////////////////////
// Set Widgets
function birdfield_widgets_init() {

	register_sidebar( array (
		'name'			=> __( 'Widget Area for header', 'birdfield' ),
		'id'			=> 'widget-area-header',
		'description'		=> __( 'One text widget for header', 'birdfield' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'		=> '</div>',
		'before_title'		=> '<h3>',
		'after_title'		=> '</h3>',
		) );


	register_sidebar( array (
		'name'			=> __( 'Widget Area for footer', 'birdfield' ),
		'id'			=> 'widget-area-footer',
		'description'		=> __( 'Widget Area for footer', 'birdfield' ),
		'before_widget'	=> '<div class="widget">',
		'after_widget'		=> '</div>',
		'before_title'		=> '<h3>',
		'after_title'		=> '</h3>',
		) );
}
add_action( 'widgets_init', 'birdfield_widgets_init' );

//////////////////////////////////////////////////////
// Header markup
function birdfield_wrapper_class() {

	$birdfield_class = 'wrapper';

	if( get_theme_mod( 'birdfield_fixedheader', true ) ){
		$birdfield_class .= ' fixed-header';
	}

	if( get_theme_mod( 'birdfield_parallax', true ) ){
		$birdfield_class .= ' parallax';
	}

	if ( 'blank' == get_header_textcolor() ) {
		$birdfield_class .= ' no-title';
	}

	if ( !has_nav_menu( 'primary' ) ) {
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
		'orderby'	=> 'post_date',
		'order'		=> 'ASC',
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
// Header Style
function birdfield_header_style() {

	//Theme Option
	$birdfield_text_color = esc_attr( get_theme_mod( 'birdfield_text_color', '#222327' ) );
	$birdfield_link_color = esc_attr( get_theme_mod( 'birdfield_link_color', '#1c4bbe' ) );
	$birdfield_header_color = esc_attr( get_theme_mod( 'birdfield_header_color', '#79a596' ) );

?>

<style type="text/css">

	#header #branding #site-title,
	#header #branding #site-title a,
	#header #branding #site-description,
	#menu-wrapper .menu ul#menu-primary-items li a,
	#menu-wrapper .menu #small-menu,
	#widget-area .widget,
	#footer,
	#footer a {
		color: #<?php header_textcolor();?>;
		}

	#header,
	#footer,
	#widget-area,
	.home #content #blog ul.article .hentry.sticky i span {
		background: <?php echo $birdfield_header_color; ?>;
		}

	#content .hentry .entry-header .entry-title,
	#content .hentry .content-header .content-title,
	.home #about .widget h3,
	.home #content h2,
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
		color: <?php echo $birdfield_header_color; ?>;
		}

	.wrapper,
	.home #content #blog ul.article .hentry .entry-header .entry-title,
	.archive #content ul.list li a .entry-content,
	.search #content ul.list li a .entry-content {
		color:  <?php echo $birdfield_text_color; ?>;
		}

	a,
	.home #content #news ul.article li .entry-header .entry-title,
	.archive #content ul.list li .entry-header .entry-title,
	.search #content ul.list li .entry-header .entry-title,
	#content .hentry .page-links,
	#content .pagination a.page-numbers.prev,
	#content .pagination a.page-numbers.next,
	#content .pagination .more-link {
		color:  <?php echo $birdfield_link_color; ?>;
		}

	#content .pagination .current,
	#content .hentry .page-links span {
	  	background: <?php echo $birdfield_link_color; ?>;
	  	border-color: <?php echo $birdfield_link_color; ?>;
		}

	@media screen and (min-width: 930px) {
		#menu-wrapper .menu ul#menu-primary-items li a:hover {
			color: <?php echo $birdfield_header_color; ?>;
			}

		#menu-wrapper .menu ul#menu-primary-items li ul li a:hover {
			border-color: <?php echo $birdfield_header_color; ?>;
			}

		#menu-wrapper .menu ul#menu-primary-items li ul li a {
			background-color: <?php echo $birdfield_header_color; ?>;
			}
		}

</style>

<?php

}

//////////////////////////////////////////////////////
// Setup Theme
function birdfield_setup() {

	// Set languages
	load_theme_textdomain( 'birdfield', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Set feed
	add_theme_support( 'automatic-feed-links' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

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

	// Add support for custom headers.
	$custom_header_support = array(
		// Text color and image (empty to use none).
		'default-text-color'	=> 'FFF',
		'default-image'		=> '%s/images/header.jpg',

		// Set height and width, with a maximum value for the width.
		'height'			=> 900,
		'width'			=> 1280,
		'max-width'		=> 900,

		// Random image rotation off by default.
		'random-default'	=> true,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'	=> 'birdfield_header_style',
	);

	// Add support for title tag.
	add_theme_support( 'title-tag' );

	// Add support for custom headers.
	add_theme_support( 'custom-header', $custom_header_support );

	register_default_headers( array(
		'birdfield'		=> array(
		'url'			=> '%s/images/header.jpg',
		'thumbnail_url'		=> '%s/images/header-thumbnail.jpg',
		'description'		=> 'birdfield'
		)
	) );

	// Add support for news content.
	add_theme_support( 'news-content', array(
		'news_content_filter'	=> 'birdfield_get_news_posts',
		'max_posts'		=> 5,
	) );
}
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
// Document Title
function birdfield_title( $title ) {
	global $page, $paged;

	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title .= ' | ' . sprintf( __( 'Page %s', 'birdfield' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'birdfield_title' );

//////////////////////////////////////////////////////
// Enqueue Scripts
function birdfield_scripts() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'jquerytile', get_template_directory_uri() .'/js/jquery.tile.js', 'jquery', '20140801' );
	wp_enqueue_script( 'birdfield', get_template_directory_uri() .'/js/birdfield.js', 'jquery', '1.08' );
	wp_enqueue_style( 'birdfield-google-font', '//fonts.googleapis.com/css?family=Raleway', false, null, 'all' );
	wp_enqueue_style( 'birdfield', get_stylesheet_uri() );

	if ( strtoupper( get_locale() ) == 'JA' ) {
		wp_enqueue_style( 'birdfield_ja', get_template_directory_uri().'/css/ja.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'birdfield_scripts' );

//////////////////////////////////////////////////////
// Theme Customizer
function birdfield_customize($wp_customize) {
	// Text Color
	$wp_customize->add_setting( 'birdfield_text_color', array(
		'default' => '#222327',
		'sanitize_callback' => 'maybe_hash_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_text_color', array(
		'label'		=> __( 'Text Color', 'birdfield' ),
		'section'	=> 'colors',
		'settings'	=> 'birdfield_text_color',
	) ) );

	// Link Color
	$wp_customize->add_setting( 'birdfield_link_color', array(
		'default' => '#1c4bbe',
		'sanitize_callback' => 'maybe_hash_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_link_color', array(
		'label'		=> __( 'Link Color', 'birdfield' ),
		'section'	=> 'colors',
		'settings'	=> 'birdfield_link_color',
	) ) );

	// Header, Footer Background Color
	$wp_customize->add_setting( 'birdfield_header_color', array(
		'default' => '#79a596',
		'sanitize_callback' => 'maybe_hash_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_header_color', array(
		'label'		=> __( 'Header, Footer Background Color', 'birdfield' ),
		'section'	=> 'colors',
		'settings'	=> 'birdfield_header_color',
	) ) );

	// Parallax Header Image
	$wp_customize->add_setting( 'birdfield_parallax', array(
		'default'  => true,
		'sanitize_callback' => 'birdfield_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'birdfield_parallax', array(
		'label'		=> __( 'Display Parallax', 'birdfield' ),
		'section'	=> 'header_image',
		'type'		=> 'checkbox',
		'settings'	=> 'birdfield_parallax',
	) );

	// Fixed Menu
	$wp_customize->add_setting( 'birdfield_fixedheader', array(
		'default'		=> true,
		'sanitize_callback'	=> 'birdfield_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'birdfield_fixedheader', array(
		'label'		=> __( 'Fixed Header', 'birdfield' ),
		'section'	=> 'title_tagline',
		'type'		=> 'checkbox',
		'settings'	=> 'birdfield_fixedheader',
	) );

	// Footer Section
	$wp_customize->add_section( 'birdfield_customize', array(
		'title'		=> __( 'Footer', 'birdfield' ),
		'priority'	=> 999,
	) );

	// Display Copyright
	$wp_customize->add_setting( 'birdfield_copyright', array(
		'default'		=> true,
		'sanitize_callback'	=> 'birdfield_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'birdfield_copyright', array(
		'label'		=> __( 'Display Copyright', 'birdfield' ),
		'section'	=> 'birdfield_customize',
		'type'		=> 'checkbox',
		'settings'	=> 'birdfield_copyright',
	) );

	// Display Credit
	$wp_customize->add_setting( 'birdfield_credit', array(
		'default'		=> true,
		'sanitize_callback'	=> 'birdfield_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'birdfield_credit', array(
		'label'		=> __( 'Display Credit', 'birdfield' ),
		'section'	=> 'birdfield_customize',
		'type'		=> 'checkbox',
		'settings'	=> 'birdfield_credit',
	) );
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

