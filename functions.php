<?php
/*
birdfield functions and definitions.
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
		'name' => __( 'Widget Area for header', 'birdfield' ),
		'id' => 'widget-area-header',
		'description' => __( 'Ont text widget for header', 'birdfield' ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );


	register_sidebar( array (
		'name' => __( 'Widget Area for footer', 'birdfield' ),
		'id' => 'widget-area-footer',
		'description' => __( 'Widget Area for footer', 'birdfield' ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
}
add_action( 'widgets_init', 'birdfield_widgets_init' );

//////////////////////////////////////////
// SinglePage Comment callback
function birdfield_custom_comments( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

	<?php if( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ):
		$birstips_url    = get_comment_author_url();
		$birstips_author = get_comment_author();
	 ?> 

		<div class="posted"><strong><?php _e( 'Pingback', 'birdfield' ); ?> : </strong><a href="<?php echo $birstips_url; ?>" target="_blank" class="web"><?php echo $birstips_author ?></a><?php edit_comment_link( __('(Edit)', 'birdfield'), ' ' ); ?></div>

	<?php else: ?>

		<div class="comment_meta">
			<?php echo get_avatar( $comment, 40 ); ?>
			<span class="author"><?php comment_author(); ?></span>
			<span class="postdate"><?php echo get_comment_time(get_option('date_format') .' ' .get_option('time_format')); ?></span><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'birdfield' ); ?></em>
		<?php endif; ?>

		<div class="comment_text">
			<?php comment_text(); ?>

			<?php $birdfield_web = get_comment_author_url(); ?>
			<?php if(!empty($birdfield_web)): ?>
				<p class="web"><a href="<?php echo $birdfield_web; ?>" target="_blank"><?php echo $birdfield_web; ?></a></p>
			<?php endif; ?>
		</div>

	<?php endif; ?>
<?php
	// no "</li>" conform WORDPRESS
}

//////////////////////////////////////////////////////
// Header markup
function birdfield_wrapper_class() {

	$birdfield_class = 'wrapper fixed-header';

	if ( 'blank' == get_header_textcolor() ) {
		$birdfield_class .= ' no-title';
	}

	if ( !has_nav_menu( 'primary' ) ) {
		$birdfield_class .= ' no-nav-menu';
	}

	echo 'class="' .$birdfield_class .'"';
}

//////////////////////////////////////////////////////
// Pagenation
function birdfield_the_pagenation() {

	global $wp_rewrite;
	global $wp_query;
	global $paged;

	$birdfield_paginate_base = get_pagenum_link( 1 );
	if ( strpos($birdfield_paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
		$birdfield_paginate_format = '';
		$birdfield_paginate_base = add_query_arg( 'paged', '%#%' );
	} else {
		$birdfield_paginate_format = ( substr( $birdfield_paginate_base, -1 ,1 ) == '/' ? '' : '/' ) .
		user_trailingslashit( 'page/%#%/', 'paged' );;
		$birdfield_paginate_base .= '%_%';
	}
	echo paginate_links( array(
		'base' => $birdfield_paginate_base,
		'format' => $birdfield_paginate_format,
		'total' => $wp_query->max_num_pages,
		'mid_size' => 3,
		'current' => ( $paged ? $paged : 1 ),
	));
}


//////////////////////////////////////////////////////
// Header Style
function birdfield_header_style() {

	//Theme Option
	$birdfield_text_color = get_theme_mod( 'birdfield_text_color', '#555555' );
	$birdfield_link_color = get_theme_mod( 'birdfield_link_color', '#3981e5' );
	$birdfield_header_color = get_theme_mod( 'birdfield_header_color', '#068441' );

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

	body.custom-background,
	body.custom-background.home #content #news,
	body.custom-background.home #content #blog,
	body.custom-background .wrapper {
		background: #<?php background_color();?>;
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
	#content #comments li.bypostauthor .comment_meta .author,
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
	.search #content ul.list li .entry-header .entry-title {
		color:  <?php echo $birdfield_link_color; ?>;
		}

	#content .tablenav a.page-numbers {
		border-color: <?php echo $birdfield_link_color; ?>;
		color: <?php echo $birdfield_link_color; ?>;
		}

	#content .tablenav .current {
	  	background: <?php echo $birdfield_link_color; ?>;
	  	border-color: <?php echo $birdfield_link_color; ?>;
		}

	@media screen and (min-width: 930px) {
		#menu-wrapper .menu ul#menu-primary-items li a:hover {
			color: <?php echo $birdfield_header_color; ?>;
			}

		#menu-wrapper .menu ul#menu-primary-items li ul li a {
			background-color: <?php echo $birdfield_header_color; ?>;
			}
		}

</style>

<?php 

}

//////////////////////////////////////////////////////
// Admin Header Style
function birdfield_admin_header_style() {

	$birdfield_header_color = get_theme_mod( 'birdfield_header_color', '#068441' );
?>

<style type="text/css">

	#birdfield_header {
		font-family: 'Raleway', Verdana,Arial,"メイリオ",Meiryo,"ヒラギノ角ゴPro W3","Hiragino Kaku Gothic Pro","ＭＳ Ｐゴシック",sans-serif;
		background: <?php echo $birdfield_header_color;?>;
		padding: 15px;
		}

	#birdfield_header #site-title {
		margin: 0;
		padding: 0;
		color: #<?php header_textcolor();?>;
		font-size: 2rem;
		}

	#birdfield_header #site-title a {
		color: #<?php header_textcolor();?>;
	    text-decoration: none;
		}

	#birdfield_header #site-description {
		color: #<?php header_textcolor();?>;
		font-size: 1rem;
		}

</style>

<?php

} 

//////////////////////////////////////////////////////
// Admin Header Image
function birdfield_admin_header_image() {

	$header_image = get_header_image();
	$birdfield_image_tag = '';
	if ( empty( $header_image ) ){
		$birdfield_image_tag = ' class="no-image"'; 
	}

	$style = '';
		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) ){
		$style = ' style="display:none;"';
	}
?>
	<div id="birdfield_header"<?php echo $birdfield_image_tag; ?>>

		<div id="site-title"><a <?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>
		<div id="site-description" <?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>

<?php
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) : ?>

		<img src="<?php echo esc_url( $header_image ); ?>" alt="" />

	<?php endif; ?>

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
		'default-color' => 'FFF',
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Navigation Menu', 'birdfield' ),
	) );

	// Add support for custom headers.
	$custom_header_support = array(
		// Text color and image (empty to use none).
		'default-text-color'     => 'FFF',
		'default-image'          => '',

		// Set height and width, with a maximum value for the width.
		'height'                 => 900,
		'width'                  => 1280,
		'max-width'              => 900,
		'default-image'          => '%s/images/green.jpg',

		// Random image rotation off by default.
		'random-default'         => true,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback' => 'birdfield_header_style',
		'admin-head-callback' => 'birdfield_admin_header_style',
		'admin-preview-callback' => 'birdfield_admin_header_image'
	);

	add_theme_support( 'custom-header', $custom_header_support );

	register_default_headers( array(
		'yellow' => array(
			'url' => '%s/images/yellow.jpg',
			'thumbnail_url' => '%s/images/yellow-thumbnail.jpg',
			'description' => 'Yellow'
		),
		'red' => array(
			'url' => '%s/images/red.jpg',
			'thumbnail_url' => '%s/images/red-thumbnail.jpg',
			'description' => 'Red'
		),
		'white' => array(
			'url' => '%s/images/white.jpg',
			'thumbnail_url' => '%s/images/white-thumbnail.jpg',
			'description' => 'White'
		),
		'pink' => array(
			'url' => '%s/images/pink.jpg',
			'thumbnail_url' => '%s/images/pink-thumbnail.jpg',
			'description' => 'Pink'
		),
		'purple' => array(
			'url' => '%s/images/purple.jpg',
			'thumbnail_url' => '%s/images/purple-thumbnail.jpg',
			'description' => 'Purple'
		),
	) );

	// Add support for news content.
	add_theme_support( 'news-content', array(
		'news_content_filter' => 'birdfield_get_news_posts',
		'max_posts' => 5,
	) );
}
add_action( 'after_setup_theme', 'birdfield_setup' );  

//////////////////////////////////////////////////////
// Filter the news posts to return
function birdfield_get_news_posts(){
    $array = get_posts(array(
        'tag_slug__in' => 'news',
        'numberposts' => 5
    ));
    return $array;
}
add_filter( 'birdfield_get_news_posts','birdfield_get_news_posts',100 );

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

	if ( is_singular() && comments_open() && get_option('thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery' );  
	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'tsvensen', get_template_directory_uri() .'/js/equalize.min.js', 'jquery', '20130202' );
	wp_enqueue_script( 'birdfield', get_template_directory_uri() .'/js/birdfield.js', 'jquery', '1.00' );
	wp_enqueue_style( 'birdfield-google-font', '//fonts.googleapis.com/css?family=Raleway', false, null, 'all' );
	wp_enqueue_style( 'birdfield', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'birdfield_scripts' );

//////////////////////////////////////////////////////
// Enqueue Scripts for admin
function birdfield_admin_scripts( $hook_suffix ) {

	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'birdfield-google-font', '//fonts.googleapis.com/css?family=Raleway', false, null, 'all' );
}
add_action( 'admin_enqueue_scripts', 'birdfield_admin_scripts' );

//////////////////////////////////////////////////////
// Theme Customizer
function birdfield_customize($wp_customize) {
 
	$wp_customize->add_section( 'birdfield_customize', array(
		'title'=> __( 'Theme Options', 'birdfield' ),
		'priority' => 99,
	) );

	// Text Color
	$wp_customize->add_setting( 'birdfield_text_color', array(
		'default' => '#555555',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_text_color', array(
		'label' => __( 'Text Color', 'birdfield' ),
		'section'=> 'birdfield_customize',
		'settings' => 'birdfield_text_color',
	) ) );

	// Link Color
	$wp_customize->add_setting( 'birdfield_link_color', array(
		'default' => '#3981e5',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_link_color', array(
		'label' => __( 'Link Color', 'birdfield' ),
		'section'=> 'birdfield_customize',
		'settings' => 'birdfield_link_color',
	) ) );

	// Header, Footer Background Color
	$wp_customize->add_setting( 'birdfield_header_color', array(
		'default' => '#068441',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'birdfield_header_color', array(
		'label' => __( 'Header, Footer Background Color', 'birdfield' ),
		'section'=> 'birdfield_customize',
		'settings' => 'birdfield_header_color',
	) ) );
}
add_action( 'customize_register', 'birdfield_customize' );
